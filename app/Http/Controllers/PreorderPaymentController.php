<?php

namespace App\Http\Controllers;

use App\Mail\OrderInvoiceMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Iyzipay\Options;
use Iyzipay\Model\Payment;
use Iyzipay\Request\CreatePaymentRequest;
use App\Models\Order;
use App\Models\Payment as PaymentModel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

// Payment modelini ekle

class PreorderPaymentController extends Controller
{
    // Ödeme formunu göster
    public function showPaymentForm(Order $order)
    {
        return view('preorder.payment-form', compact('order'));
    }



public function pay(Request $request, Order $order)
{
    $options = new Options();
    $options->setApiKey(config('services.iyzico.api_key'));
    $options->setSecretKey(config('services.iyzico.secret_key'));
    $options->setBaseUrl(config('services.iyzico.base_url'));

        $requestIyzi = new CreatePaymentRequest();
        $requestIyzi->setLocale(\Iyzipay\Model\Locale::TR);
        $requestIyzi->setConversationId((string)$order->id);
        $requestIyzi->setPrice($order->total_price);
        $requestIyzi->setPaidPrice($order->total_price);
        $requestIyzi->setCurrency(\Iyzipay\Model\Currency::TL);
        $requestIyzi->setInstallment(1);
        $requestIyzi->setBasketId("B{$order->id}");
        $requestIyzi->setPaymentChannel(\Iyzipay\Model\PaymentChannel::WEB);
        $requestIyzi->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);

        // BillingAddress (zorunlu)
        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName($order->reservation->name ?? $request->card_holder_name);
        $billingAddress->setCity("Istanbul");
        $billingAddress->setCountry("Turkey");
        $billingAddress->setAddress($order->reservation->address ?? 'Adres örneği');
        $billingAddress->setZipCode("34732");
        $requestIyzi->setBillingAddress($billingAddress);

        // Kart bilgileri (formdan alınacak)
        $paymentCard = new \Iyzipay\Model\PaymentCard();
        $paymentCard->setCardHolderName($request->card_holder_name);
        $paymentCard->setCardNumber($request->card_number);
        $paymentCard->setExpireMonth($request->expire_month);
        $paymentCard->setExpireYear($request->expire_year);
        $paymentCard->setCvc($request->cvc);
        $paymentCard->setRegisterCard(0);
        $requestIyzi->setPaymentCard($paymentCard);

        // Buyer bilgileri
        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId("BY{$order->id}");
        $buyer->setName($order->reservation->name ?? 'John');
        $buyer->setSurname($order->reservation->surname ?? 'Doe');
        $buyer->setEmail($order->reservation->email ?? 'email@email.com');
        $buyer->setIdentityNumber("74300864791");
        $buyer->setIp($request->ip());
        $buyer->setCity("Istanbul");
        $buyer->setCountry("Turkey");
        $buyer->setRegistrationAddress($order->reservation->address ?? 'Adres örneği');
        $requestIyzi->setBuyer($buyer);

        // Basket item
        $basketItems = [];
        foreach ($order->items as $item) {
            $basketItem = new \Iyzipay\Model\BasketItem();
            $basketItem->setId("BI{$item->id}");
            $basketItem->setName($item->product->name);
            $basketItem->setCategory1($item->product->category->name ?? 'Ürün');
            $basketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
            $basketItem->setPrice($item->total_price);
            $basketItems[] = $basketItem;
        }
        $requestIyzi->setBasketItems($basketItems);

    // Ödemeyi oluştur
    $payment = Payment::create($requestIyzi, $options);

    // Ödeme başarılıysa
    if ($payment->getStatus() === 'success') {
        // Order status güncelle
        $order->update(['status' => 'paid']);

        // Payment kaydı oluştur
        PaymentModel::create([
            'order_id' => $order->id,
            'table_id' => $order->reservation->table_id ?? 1, // rezervasyon masası veya default 1
            'payment_method_id' => 1, // IyziCo payment method ID
            'amount_price' => $order->total_price,
            'status' => $payment->getStatus(),

        ]);



        // Mail gönder
        Mail::to($order->reservation->email)->send(new OrderInvoiceMail($order));
    }


    // Ödeme sonucunu göster
    return view('preorder.payment-result', ['payment' => $payment, 'order' => $order]);
}

}
