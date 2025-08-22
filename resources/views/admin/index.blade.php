<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive dahsboard using HTML CSS and Javascript </title>


    <!---Materail CDN--->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">




    <!---StyleSheet-->

    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">


</head>

<body>
<div class="container">
    <aside>
        <div class="top">
            <div class="logo">
                <img src="{{ asset('img/logo.png') }}" alt="Logo">
                <h2>EGA <span class="danger">TOR</span></h2>
            </div>
            <div class="close" id="close-btn">
                <span class="material-icons-sharp">close</span>
            </div>
        </div>
        <div class="sidebar">


            <a href="{{ route('dashboard') }}">
                <span class="material-icons-sharp">grid_view</span>
                <h3>Kontrol Paneli</h3>
            </a>

            <a href="{{ route('tables.index') }}">
                <span class="material-icons-sharp">person_outline</span>
                <h3>Masa Yönetimi</h3>
            </a>

            <a href="{{ route('reservations.index') }}">
                <span class="material-icons-sharp">receipt_long</span>
                <h3>Rezervasyon Listesi</h3>
            </a>

            <a href="#">
                <span class="material-icons-sharp">insights</span>
                <h3>Analitik</h3>
            </a>

            <a href="#">
                <span class="material-icons-sharp">mail_outline</span>
                <h3>Mesajlar</h3>
                <span class="message-count">26</span>
            </a>

            <a href="{{ route('admin.products.index') }}">
                <span class="material-icons-sharp">inventory</span>
                <h3>Ürün Yönetimi</h3>
            </a>

            <a href="#">
                <span class="material-icons-sharp">report_gmailerrorred</span>
                <h3>Rapor</h3>
            </a>

            <a href="#">
                <span class="material-icons-sharp">settings</span>
                <h3>Ayarlar</h3>
            </a>

            <a href="#">
                <span class="material-icons-sharp">add</span>
                <h3>...</h3>
            </a>

            <a href="#" id="logout-link">
                <span class="material-icons-sharp">logout</span>
                <h3>Oturumu Kapat</h3>
            </a>



        </div>
    </aside>


    <!----------------END OF ASIDE------------->

    <main>

        <h1>Admin Panel</h1>

        <div class="date">

            <input type="date">

        </div>

        <div class="insights">
            <div class="sales">
                <span class="material-icons-sharp">analytics</span>
                <div class="middle">
                    <div class="left">
                        <h3>Toplam Satış</h3>
                        <h1>$25,024</h1>
                    </div>
                    <div class="progress">
                        <svg>
                            <circle cx='38' cy='38' r='36'></circle>
                        </svg>
                        <div class="number">
                            <p>81%</p>
                        </div>
                    </div>
                </div>
                <small class="text-muted">Son 24 Saate</small>
            </div>
            <!----------------END OF SALES--------------->
            <div class="expenses">
                <span class="material-icons-sharp">analytics</span>
                <div class="middle">
                    <div class="left">
                        <h3>Toplam Giderler</h3>
                        <h1>$14,160</h1>
                    </div>
                    <div class="progress">
                        <svg>
                            <circle cx='38' cy='38' r='36'></circle>
                        </svg>
                        <div class="number">
                            <p>62%</p>
                        </div>
                    </div>
                </div>
                <small class="text-muted">Son 24 Saate</small>
            </div>
            <!----------------END OF EXPENT--------------->
            <div class="income">
                <span class="material-icons-sharp">bar_chart</span>
                <div class="middle">
                    <div class="left">
                        <h3>Toplam Gelir</h3>
                        <h1>$10,864</h1>
                    </div>
                    <div class="progress">
                        <svg>
                            <circle cx='38' cy='38' r='36'></circle>
                        </svg>
                        <div class="number">
                            <p>44%</p>
                        </div>
                    </div>
                </div>
                <small class="text-muted">Son 24 Saate</small>
            </div>
            <!----------------END OF INCOME--------------->
        </div>
        <!--------------------END OF INSIGHTS-------------->

        <div class="recent-orders">
            <h2>Son Rezarvasyonlar</h2>
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th>Status</th>

                </tr>
                </thead>
                <tbody>
                @forelse($recentReservations as $reservation)
                    <tr>
                        <td>{{ $reservation->name }}</td>
                        <td>{{ $reservation->surname }}</td>
                        <td>{{ $reservation->email }}</td> <!-- Buraya email eklendi -->
                        <td>{{ $reservation->datetime }}</td>
                        <td class="{{ $reservation->status == 'approved' ? 'success' : 'warning' }}">
                            {{ ucfirst($reservation->status) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No recent reservations found.</td> <!-- colspan'u 5 yaptık -->
                    </tr>
                @endforelse

                </tbody>
            </table>
            <a href="{{ route('reservations.index') }}">Hepsini Göster</a>
        </div>

    </main>

    <!-----------------END OF MAIN-------------->
    <div class="right">
        <div class="top">
            <button id="menu-btn">
                <span class="material-icons-sharp">menu</span>
            </button>
            <div class="theme-toggler">
                <span class="material-icons-sharp active">light_mode</span>
                <span class="material-icons-sharp">dark_mode</span>

            </div>
            <div class="profile">
                <div class="info">
                    <p>Hoşgeldin, {{ auth()->user()->name }}</p>
                    <small class="text-muted">Admin</small>
                </div>

                <div class="profile-photo">
                    <img src="{{ asset('img/profile-photo.jpg') }}" alt="Profile Photo">
                </div>
            </div>
        </div>
        <!-----END OF TOP  ------->
        <div class="recent-updates">
            <h2>Son Güncellemeler</h2>
            <div class="updates">
                <div class="update">
                    <div class="profile-photo">
                        <img src="{{ asset('img/profile-1.jpg') }}" alt="Profile 1">

                    </div>
                    <div class="message">
                        <p> <b>Dexter Morgan</b> Tonight's the night..  </p>
                        <small class="text-muted">2 Minutrs Ago</small>
                    </div>

                </div>

                <div class="update">
                    <div class="profile-photo">
                        <img src="{{ asset('img/profile-2.jpg') }}" alt="Profile 2">

                    </div>
                    <div class="message">
                        <p> <b>John Snow</b> Telling the Truth Is Doing the Right Thing, Even Though It Is Not Always Easy.  </p>
                        <small class="text-muted">49 Minute Ago</small>
                    </div>

                </div>

                <div class="update">
                    <div class="profile-photo">
                        <img src="{{ asset('img/profile-3.jpg') }}" alt="Profile 3">

                    </div>
                    <div class="message">
                        <p> <b>Tony Stark</b> The truth is... I am Iron Man  </p>
                        <small class="text-muted">30 Minutrs Ago</small>
                    </div>

                </div>
            </div>
        </div>

        <!-------------------END OF RECENT UPDATES ------------------>

        <div class="sales-analytics">
            <h2>Satış Analistleri</h2>

            <div class="item online">
                <div class="icon">
                    <span class="material-icons-sharp">shopping_cart</span>
                </div>
                <div class="right">
                    <div class="info">
                        <h3>ONLINE Siparişler</h3>
                        <small class="text-muted">Son 24 Saate</small>
                    </div>
                    <h5 class="success">+39%</h5>
                    <h3>3849</h3>
                </div>
            </div>

            <div class="item offline">
                <div class="icon">
                    <span class="material-icons-sharp">local_mall</span>
                </div>
                <div class="right">
                    <div class="info">
                        <h3>OFFLINE Siparişler</h3>
                        <small class="text-muted">Son 24 Saate</small>
                    </div>
                    <h5 class="danger">-17%</h5>
                    <h3>1100</h3>
                </div>
            </div>

            <div class="item customers">
                <div class="icon">
                    <span class="material-icons-sharp">person</span>
                </div>
                <div class="right">
                    <div class="info">
                        <h3>Yeni Müşteriler</h3>
                        <small class="text-muted">Son 24 Saate</small>
                    </div>
                    <h5 class="success">+25%</h5>
                    <h3>849</h3>
                </div>
            </div>
            <div class="item add-product">
                <div>
                    <span class="material-icons-sharp">add</span>
                    <h3>Ekle...</h3>
                </div>
            </div>
        </div>
    </div>
</div>


<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
    @csrf
</form>


<script src="{{ asset('admin/js/order.js') }}"></script>
<script src="{{ asset('admin/js/index.js') }}"></script>


</body>

</html>
