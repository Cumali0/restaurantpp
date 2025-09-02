<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Iyzipay\Options;
use Iyzipay\Model\Payment;
use Iyzipay\Request\CreatePaymentRequest;
use App\Models\Reservation;
use App\Models\Payment as PaymentModel;

class TablePaymentController extends Controller
{
    // Masa ödeme formunu göster
    public function showPaymentForm(Reservation $reservation)
    {
        return view('preorder.table-payment-form', compact('reservation'));
    }

    // Masa ödemesini yap
    public function pay(Request $request, Reservation $reservation)
    {
        $options = new Options();
        $options->setApiKey(config('services.iyzico.api_key'));
        $options->setSecretKey(config('services.iyzico.secret_key'));
        $options->setBaseUrl(config('services.iyzico.base_url'));

        $requestIyzi = new CreatePaymentRequest();
        $requestIyzi->setLocale(\Iyzipay\Model\Locale::TR);
        $requestIyzi->setConversationId((string)$reservation->id);
        $requestIyzi->setPrice($reservation->table_price);
        $requestIyzi->setPaidPrice($reservation->table_price);
        $requestIyzi->setCurrency(\Iyzipay\Model\Currency::TL);
        $requestIyzi->setInstallment(1);
        $requestIyzi->setBasketId("T{$reservation->id}");
        $requestIyzi->setPaymentChannel(\Iyzipay\Model\PaymentChannel::WEB);
        $requestIyzi->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);

        // BillingAddress
        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName($reservation->name);
        $billingAddress->setCity("Istanbul");
        $billingAddress->setCountry("Turkey");
        $billingAddress->setAddress($reservation->address ?? 'Adres örneği');
        $billingAddress->setZipCode("34732");
        $requestIyzi->setBillingAddress($billingAddress);

        // Kart bilgileri
        $paymentCard = new \Iyzipay\Model\PaymentCard();
        $paymentCard->setCardHolderName($request->card_holder_name);
        $paymentCard->setCardNumber($request->card_number);
        $paymentCard->setExpireMonth($request->expire_month);
        $paymentCard->setExpireYear($request->expire_year);
        $paymentCard->setCvc($request->cvc);
        $paymentCard->setRegisterCard(0);
        $requestIyzi->setPaymentCard($paymentCard);

        // Buyer
        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId("BYT{$reservation->id}");
        $buyer->setName($reservation->name);
        $buyer->setSurname($reservation->surname ?? '');
        $buyer->setEmail($reservation->email ?? 'email@email.com');
        $buyer->setIdentityNumber("74300864791");
        $buyer->setIp($request->ip());
        $buyer->setCity("Istanbul");
        $buyer->setCountry("Turkey");
        $buyer->setRegistrationAddress($reservation->address ?? 'Adres örneği');
        $requestIyzi->setBuyer($buyer);

        // Basket item
        $basketItem = new \Iyzipay\Model\BasketItem();
        $basketItem->setId("BI_T{$reservation->id}");
        $basketItem->setName("Masa Ücreti");
        $basketItem->setCategory1("Rezervasyon");
        $basketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
        $basketItem->setPrice($reservation->table_price);
        $requestIyzi->setBasketItems([$basketItem]);

        // Ödeme oluştur
        $payment = Payment::create($requestIyzi, $options);

        if ($payment->getStatus() === 'success') {
            // Reservation onaylandı
            $reservation->update(['status' => 'paid']);

            // Payment kaydı
            PaymentModel::create([
                'order_id' => null,
                'table_id' => $reservation->table_id,
                'payment_method_id' => 1, // IyziCo
                'amount_price' => $reservation->table_price,
                'status' => $payment->getStatus(),
            ]);
        }

        return view('preorder.table-payment-result', [
            'payment' => $payment,
            'reservation' => $reservation
        ]);
    }
}
