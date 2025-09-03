@extends('layouts.app')

@section('title', 'Ana Sayfa - Restaurant')

@section('content')

<!-- Hero Section -->
<div class="container-fluid py-5 bg-dark hero-header mb-5">
    <div class="container my-5 py-5">
        <div class="row align-items-center g-5 register-tr">
            <div class="col-lg-6 text-center text-lg-start"></div>
            <h1 class="display-3 text-white animated slinderInLeft me-2">Lezzetli Yemeğimizin <br>Tadını Çıkarın</h1>
            <p class="text-white animated slinderInLeft mb-4 p-2 ms-4">Kalite Paraya Değer </p>
            <a href="#" id="reserveBtn" class="btn btn-primary py-sm-3 px-sm-5 slinderInLeft ms-4" style="width: 20%;">Masa Ayırt</a>
        </div>
        <div class="text-center text-lg-end overflow-hidden">

            <img src="{{ asset('img/hero.png') }}" class="img-fluid" width="500px" alt="">
        </div>
    </div>
</div>



<!--navbar & hero Ends-->

<!--Service Section State-->

<div class="container py-5">
    <div class="container">
        <div class="row g-4">

            <!-- 1. Kutu -->
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item rounded pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-user-tie text-primary mb-4"></i>
                        <h5>Usta Aşçılar</h5>
                        <p>Yılların tecrübesiyle, damaklarda unutulmaz tatlar yaratıyoruz</p>
                    </div>
                </div>
            </div>

            <!-- 2. Kutu -->
            <div class="col-lg-3 col-sm-6 wow fadeInUp">
                <div class="service-item rounded pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-utensils text-primary mb-4"></i>
                        <h5>Kaliteli Aşçılar</h5>
                        <p>Deneyimli ve tutkulu şeflerimiz, her yemeği sanat eserine dönüştürüyor.</p>
                    </div>
                </div>
            </div>

            <!-- 3. Kutu -->
            <div class="col-lg-3 col-sm-6 wow fadeInUp">
                <div class="service-item rounded pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-cart-plus text-primary mb-4"></i>
                        <h5>Kaliteli Yemek</h5>
                        <p>Her lokmada tazelik ve özenle hazırlanan eşsiz lezzetler</p>
                    </div>
                </div>
            </div>

            <!-- 4. Kutu -->
            <div class="col-lg-3 col-sm-6 wow fadeInUp">
                <div class="service-item rounded pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-headset text-primary mb-4"></i>
                        <h5>7/24 Servis</h5>
                        <p>Kalite lezzetin adresi değil midir? O yüzden kaliteli yiyin.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!--Service Section  End-->

<!--About Section State -->


<div class="container py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6 text-start">
                        <img class="img-gluid rounded w-100 wow zoomIn" src="{{ asset('img/about-1.jpg') }}" alt="">
                    </div>
                    <div class="col-6 text-start">
                        <img class="img-fluid rounded w-75 wow zoomIn cumali" src="{{ asset('img/about-2.jpg') }}" style="margin-top: 25%;" alt="">

                    </div>
                    <div class="col-6 text-start">
                        <img class="img-fluid rounded w-75 wow zoomIn" src="{{ asset('img/about-3.jpg') }}" alt="">

                    </div>
                    <div class="col-6 text-start">
                        <img class="img-fluid rounded w-100 wow zoomIn" src="{{ asset('img/about-4.jpg') }}" alt="">

                    </div>
                </div>
            </div>
            <div id="hakkimiz-section" class="col-lg-6">
                <h5 class="Section-title ff-secondary text-start text-primary fw-normal">Hakkımızda</h5>
                <h1 class="mb-4">Restorana<i class="fa fa-utensils text-primary me-2"></i>Hoşgeldiniz</h1>
                <p class="mb-4"> Sizlere en taze malzemelerle hazırladığımız enfes lezzetlerimizi sunmak ve keyifli bir yemek deneyimi yaşatmak için buradayız. Afiyetle, güzel anılar biriktirmeniz dileğiyle.</p>
                <p class="mb-4">Çıkın çıkın gelin buraya mükemmel</p>
                <div class="row g-4 mb-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center border-start border-5 border-primary px-3x">
                            <h1 class="flex-shrink-0 display-5 text-primary mb-0">15</h1>
                            <div class="ps-4">
                                <p class="mb-0">Yılların</p>
                                <h6 class="text-uppercase mb-0">Deneyimi</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center border-start border-5 border-primary px-3x">
                            <h1 class="flex-shrink-0 display-5 text-primary mb-0">50</h1>
                            <div class="ps-4">
                                <p class="mb-0">Popüler</p>
                                <h6 class="text-uppercase mb-0">Usta Aşçılar</h6>
                            </div>
                        </div>
                    </div>

                </div>
                <a href="" class="btn btn-primary py-3 px-5 mt-2"></a>
            </div>
        </div>
    </div>
</div>

<!--About Section End -->



<!--Reservation Section Start-->

<div id="reservation" class="container py-5 px-0 wow fadeInUp">
    <div class="row g-0">
        <div class="col-md-6">
            <div class="video">
                <button type="button" class="btn-play" data-bs-toggle="modal" data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videomodal">
                    <span></span>
                </button>
            </div>
        </div>
        <div class="col-md-6 bg-dark align-items-center">
            <div class="p-5">
                <h5 class="section-title ff-secondary text-start text-primary fw-normal">
                    Rezervasyon
                </h5>
                <h1 class="text-white mb-4">Online Masa Kaydı</h1>
                <form id="reservationForm" action="{{ route('reservations.store.public') }}" method="POST">

                    @csrf
                    <div class="row g-3">
                        @guest
                            <!-- Giriş yapmamış kullanıcı: tüm alanlar boş ve doldurulabilir -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Ad" required>
                                    <label for="name">Ad</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="surname" name="surname" placeholder="Soyad" required>
                                    <label for="surname">Soyad</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Telefon" required>
                                    <label for="phone">Telefon</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="E-posta Adresi" required>
                                    <label for="email">E-posta Adresi</label>
                                </div>
                            </div>
                        @endguest

                            @auth
                                <!-- Giriş yapmış kullanıcı: alanlar dolu ve readonly -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ optional(auth()->user())->name }}" readonly>
                                        <label for="name">Ad</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="surname" name="surname" value="{{ optional(auth()->user())->surname }}" readonly>
                                        <label for="surname">Soyad</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ optional(auth()->user())->phone }}" readonly>
                                        <label for="phone">Telefon</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" name="email" value="{{ optional(auth()->user())->email }}" readonly>
                                        <label for="email">E-posta Adresi</label>
                                    </div>
                                </div>
                            @endauth


                            <!-- Tarih & Saat -->
                        <div class="col-md-6">
                            <div class="form-floating date" id="date3">
                                <input  type="text" class="form-control" id="datetimepicker" name="datetime" placeholder="Date & Time" required autocomplete="off">
                                <label for="datetimepicker">Tarih & Saat</label>
                            </div>
                        </div>
                        <!-- Kişi Sayısı -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="people" name="people" required>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }} Kişi</option>
                                    @endfor
                                </select>
                                <label for="people">Kişi Sayısı</label>
                            </div>
                        </div>



                        <!-- Masalar Dinamik Listesi -->
                        <div class="col-12" id="tables-container" style="margin-top: 15px; display: flex;">
                            <p class="text-white">Lütfen önce tarih ve saati seçiniz.</p>
                        </div>

                        <!-- Seçilen masa id'si gizli input -->
                        <input type="hidden" id="selected_table_id" name="table_id" />

                        <!-- Özel İstek -->
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" id="message" name="message" placeholder="Özel İstek" style="height: 100px;"></textarea>
                                <label for="message">Özel İstek</label>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-check">
                                <input type="checkbox"  name="is_preorder" value="1" class="form-check-input" id="is_preorder">

                                <label class="form-check-label text-white" for="is_preorder">Ön sipariş vermek istiyorum</label>

                            </div>
                        </div>

                        <!-- Gönder -->
                        <div class="col-12">
                            <button class="btn btn-primary w-100 py-3" type="submit">Şimdi Rezervasyon Yap</button>
                        </div>

                        <div class="col-12 mt-2">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @elseif(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div id="reservationResult"></div>
                </form>

            </div>
        </div>
    </div>
</div>

<!--Reservation Section End-->

<!-- Masa Ödeme Popup -->
<div class="modal fade" id="tablePaymentModal" tabindex="-1" aria-labelledby="tablePaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="tablePaymentModalLabel">Masa Ücreti Ödemesi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>

            <div class="modal-body">
                <p>Bu masayı rezerve edebilmek için ön ödeme yapmanız gerekiyor.</p>
                <p><strong>Tutar:</strong> <span id="reservationPrice"></span> ₺</p>
            </div>

            <div class="modal-footer">
                <a href="#" id="goToPayment" class="btn btn-primary">Ödemeye Git</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
            </div>

        </div>
    </div>
</div>



@guest
    <div class="mt-4 p-3 border rounded bg-light">
        <h6>Şiparişiniz yarım kaldıysa:</h6>
        <p>Rezervasyon ID'nizi girin ve devam edin.</p>
        <div class="d-flex gap-2">
            <input type="text" id="reservation_id_input" class="form-control" placeholder="Rezervasyon ID">
            <button type="button" id="guest_resume_btn" class="btn btn-primary">Devam Et</button>
        </div>
        <p id="guest_message" class="mt-2 text-success"></p>
    </div>

    <script>
        document.getElementById('guest_resume_btn').addEventListener('click', async () => {
            const reservationId = document.getElementById('reservation_id_input').value;
            const messageEl = document.getElementById('guest_message');

            if(!reservationId) {
                messageEl.textContent = 'Lütfen rezervasyon ID girin!';
                messageEl.classList.remove('text-success');
                messageEl.classList.add('text-danger');
                return;
            }

            const res = await fetch('{{ route("reservation.generateToken") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ reservation_id: reservationId })
            });

            const data = await res.json();

            if(data.success || data.message){
                messageEl.textContent = data.message || 'Yeni token emailinize gönderildi.';
                messageEl.classList.remove('text-danger');
                messageEl.classList.add('text-success');
            } else {
                messageEl.textContent = 'Bir hata oluştu!';
                messageEl.classList.remove('text-success');
                messageEl.classList.add('text-danger');
            }
        });
    </script>
@endguest





<
<!--Team Section Start-->

<div class="container pt-5 pb-3">
    <div class="container">
        <div class="text-center wow fadeInup">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">
                Ekip Üyeleri
            </h5>
            <h1 class="mb-5">Usta Şeflerimiz</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 wow fadeInup register-clove">
                <div class="team-item text-center rounded overflow-hidden">
                    <div class="rounded-circle overflow-hidden m-4">
                        <img class="img-fluid" src="{{ asset('img/team-1.jpg') }}" alt="">

                    </div>
                    <h5 class="mb-0">Zafer Şef</h5>
                    <small>Yardımcı Aşçı</small>
                    <div class="d-flex justify-content-center mt-3">
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook"></i></a>
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInup">
                <div class="team-item text-center rounded overflow-hidden">
                    <div class="rounded-circle overflow-hidden m-4">
                        <img class="img-fluid" src="{{ asset('img/team-2.jpg') }}" alt="">

                    </div>
                    <h5 class="mb-0">Mehmet Şef</h5>
                    <small>Aşçı</small>
                    <div class="d-flex justify-content-center mt-3">
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook"></i></a>
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                    </div>

                </div>

            </div>
            <div class="col-lg-3 col-md-6 wow fadeInup">
                <div class="team-item text-center rounded overflow-hidden">
                    <div class="rounded-circle overflow-hidden m-4">
                        <img class="img-fluid" src="{{ asset('img/team-3.jpg') }}" alt="">

                    </div>
                    <h5 class="mb-0">Soner Şef</h5>
                    <small>Baş Aşçı</small>
                    <div class="d-flex justify-content-center mt-3">
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook"></i></a>
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                    </div>

                </div>

            </div>
            <div class="col-lg-3 col-md-6 wow fadeInup">
                <div class="team-item text-center rounded overflow-hidden">
                    <div class="rounded-circle overflow-hidden m-4">
                        <img class="img-fluid" src="{{ asset('img/team-4.jpg') }}" alt="">


                    </div>
                    <h5 class="mb-0">Danilo Şef</h5>
                    <small>Gurme</small>
                    <div class="d-flex justify-content-center mt-3">
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook"></i></a>
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>










<!--Team Section End -->


@endsection



@push('styles')
    <style>
        table {
            padding: 10px 15px;
            border-radius: 5px;
            color: white;
            background-color: #0d6efd;
            cursor: pointer;
            text-align: center;
            flex: 0 0 120px; /* sabit genişlik */
            margin-bottom: 10px;
        }

        #tables-container { display:flex; flex-wrap:wrap; gap:10px; margin-top:10px;}
        .table {padding:10px 15px; border-radius:5px; color:white; background-color:#0d6efd; cursor:pointer; user-select:none; text-align:center;}
        .table.selected { background-color:#198754; }
        .table.booked { opacity:0.6; cursor:not-allowed; }
    </style>
@endpush

@push('scripts')
    <script>


        document.addEventListener('DOMContentLoaded', function() {

            let selectedTableId = null;

            // -----------------------------
            // Flatpickr
            // -----------------------------
            const datetimeInput = document.getElementById('datetimepicker');

            const fpInstance = flatpickr(datetimeInput, {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
                locale: "tr",
                minDate: "today",
                onChange: function(selectedDates, dateStr) {
                    if(dateStr) fetchAvailableTables(dateStr);
                    else clearTables();
                    updateTimeLimits(selectedDates[0]);
                }
            });

            function updateTimeLimits(selectedDate){
                if(!selectedDate) return;
                const day = selectedDate.getDay();
                if(day === 0){ // Pazar
                    fpInstance.set('minTime', "10:00");
                    fpInstance.set('maxTime', "20:00");
                } else { // Diğer günler
                    fpInstance.set('minTime', "09:00");
                    fpInstance.set('maxTime', "21:00");
                }
            }

            // -----------------------------
            // Masalar
            // -----------------------------
            const tablesContainer = document.getElementById('tables-container');

            function fetchAvailableTables(datetime){
                fetch(`/tables-availability?datetime=${encodeURIComponent(datetime)}&duration=90`)
                    .then(res=>res.json())
                    .then(data=>{
                        tablesContainer.innerHTML = '';
                        selectedTableId = null;
                        document.getElementById('selected_table_id').value = '';

                        if(data.error){
                            tablesContainer.innerHTML = `<p class="text-danger">${data.error}</p>`;
                            return;
                        }

                        if((!data.available || !data.available.length) && (!data.booked || !data.booked.length)){
                            tablesContainer.innerHTML = `<p class="text-white">Bu tarihte hiç masa bulunmamaktadır.</p>`;
                            return;
                        }

                        (data.available || []).forEach(table=>{
                            const div = document.createElement('div');
                            div.className = 'table available';
                            div.textContent = 'Masa ' + table.name;
                            div.onclick = () => selectTable(table.id, div);
                            tablesContainer.appendChild(div);
                        });

                        (data.booked || []).forEach(table=>{
                            const div = document.createElement('div');
                            div.className = 'table booked';
                            div.textContent = 'Masa ' + table.name;
                            tablesContainer.appendChild(div);
                        });
                    })
                    .catch(err=>{
                        tablesContainer.innerHTML = '<p class="text-danger">Masalar yüklenemedi, lütfen tekrar deneyin.</p>';
                        console.error(err);
                    });
            }

            function selectTable(id, element){
                if(element.classList.contains('booked')) return;

                const selectedInput = document.getElementById('selected_table_id');

                if(selectedTableId === id){
                    selectedTableId = null;
                    element.classList.remove('selected');
                    selectedInput.value = '';
                } else {
                    selectedTableId = id;
                    document.querySelectorAll('.table.selected').forEach(el=>el.classList.remove('selected'));
                    element.classList.add('selected');
                    selectedInput.value = id;
                }
            }

            function clearTables(){
                tablesContainer.innerHTML = '<p class="text-white">Lütfen önce tarih ve saati seçiniz.</p>';
                selectedTableId = null;
                document.getElementById('selected_table_id').value = '';
            }

            clearTables();

            // -----------------------------
            // Form submit
            // -----------------------------
            const reservationForm = document.getElementById('reservationForm');
            const preorderCheckbox = document.getElementById('is_preorder');

            reservationForm.addEventListener('submit', function(e){
                e.preventDefault();

                const formData = new FormData(reservationForm);
                const datetimeValue = fpInstance.input.value.trim();

                if(!selectedTableId || !datetimeValue){
                    document.getElementById('reservationResult').innerHTML =
                        '<p style="color:red;">Lütfen masa ve tarih/saat seçiniz.</p>';
                    return;
                }

                formData.set('table_id', selectedTableId);
                formData.set('datetime', datetimeValue);

                fetch(reservationForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                    .then(res=>res.json())
                    .then(data=>{
                        if(data.success){
                            // Eğer masa ücreti ödemesi gerekiyorysa modal göster
                            if(data.payment_url){
                                document.getElementById('reservationPrice').textContent = data.table_preprice || '0';
                                const goBtn = document.getElementById('goToPayment');
                                goBtn.href = data.payment_url;
                                const paymentModal = new bootstrap.Modal(document.getElementById('tablePaymentModal'));
                                paymentModal.show();
                            }

                            // Ön sipariş varsa yönlendirme
                            else if(preorderCheckbox.checked && data.preorder_url){
                                window.location.href = data.preorder_url;
                            }

                            else {
                                Swal.fire({icon:'success', title:'Başarılı', text:data.message, timer:2000, showConfirmButton:false});
                                reservationForm.reset();
                                clearTables();
                            }
                        } else {
                            Swal.fire({icon:'error', title:'Hata', text:data.message||'Rezervasyon yapılamadı.'});
                        }
                    })

                    .catch(err=>{
                        console.error(err);
                        document.getElementById('reservationResult').innerHTML =
                            '<p style="color:red;">Sunucu hatası oluştu.</p>';
                    });
            });

        });
    </script>

@endpush
