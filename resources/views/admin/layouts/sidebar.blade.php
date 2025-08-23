<aside>
    <div class="top">
        <div class="logo">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" />
            <h2>EGA <span class="danger">TOR</span></h2>
        </div>
        <div class="close" id="close-btn">
            <span class="material-icons-sharp">close</span>
        </div>
    </div>

    <div class="sidebar">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="material-icons-sharp">grid_view</span>
            <h3>Kontrol Paneli</h3>
        </a>

        <a href="{{ route('tables.index') }}" class="{{ request()->routeIs('tables.*') ? 'active' : '' }}">
            <span class="material-icons-sharp">person_outline</span>
            <h3>Masa Yönetimi</h3>
        </a>

        <a href="{{ route('reservations.index') }}" class="{{ request()->routeIs('reservations.index') ? 'active' : '' }}">
            <span class="material-icons-sharp">receipt_long</span>
            <h3>Rezarvasyon Listesi</h3>
        </a>

        <a href="{{ route('analytics.index') }}" class="{{ request()->routeIs('analytics.index') ? 'active' : '' }}">
            <span class="material-icons-sharp">insights</span>
            <h3>Analitik</h3>
        </a>

        <a href="#" >
            <span class="material-icons-sharp">mail_outline</span>
            <h3>Mesajlar</h3>
            <span class="message-count">26</span>
        </a>

        <a href="{{ route('admin.menus.index') }}" class="{{ request()->routeIs('admin.menus.index') ? 'active' : '' }}">
            <span class="material-icons-sharp">inventory</span>
            <h3>Ürün Yönetimi</h3>
        </a>

        <a href="#">
            <span class="material-icons-sharp">report_gmailerrorred</span>
            <h3>Raporlar</h3>
        </a>

        <a class="nav-link" href="{{ route('admin.profile.edit') }}">
            <span class="material-icons-sharp">settings</span>
            <h3>Ayarlar</h3>
        </a>


        <a href="#">
            <span class="material-icons-sharp">add</span>
            <h3>...</h3>
        </a>

        <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
            @csrf
            <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"
               class="{{ request()->routeIs('logout') ? 'active' : '' }}">
                <span class="material-icons-sharp">logout</span>
                <h3>Oturumu Kapat</h3>
            </a>
        </form>

    </div>
</aside>

<div class="right">
    <div class="top register-r">
        <button id="menu-btn">
            <span class="material-icons-sharp">menu</span>
        </button>
        <div class="theme-toggler">
            <span class="material-icons-sharp active">light_mode</span>
            <span class="material-icons-sharp">dark_mode</span>
        </div>
        <div class="profile">
            <div class="info">
                <p>Hey, <b>{{ Auth::user()->name ?? 'User' }}</b></p>
                <small class="text-muted">Admin</small>
            </div>
            <div class="profile-photo">
                <img src="{{ asset('img/profile-photo.jpg') }}" alt="Profile Photo">
            </div>
        </div>
    </div>

    {{-- Buraya ana içerik gelecek --}}
</div>
