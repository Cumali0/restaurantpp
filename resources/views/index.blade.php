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
                <form id="reservationForm" action="" method="POST">

                    @csrf
                    <div class="row g-3">
                        <!-- Ad -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Ad" required>
                                <label for="name">Ad</label>
                            </div>
                        </div>
                        <!-- Soyad -->
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

                        <!-- Tarih & Saat -->
                        <div class="col-md-6">
                            <div class="form-floating date" id="date3">
                                <input type="text" class="form-control" id="datetimepicker" name="datetime" placeholder="Date & Time" required autocomplete="off">
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
                </form>
                <div id="reservationResult"></div>
            </div>
        </div>
    </div>
</div>

<!--Reservation Section End-->


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
