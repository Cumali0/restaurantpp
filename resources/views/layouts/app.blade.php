<!DOCTYPE html>
<html lang="en">



<body>

<!-- Navbar -->
@include('partials.navbar')

<!-- Main Content -->
<main>
    @yield('content')
</main>

<!-- Footer -->
@include('partials.footer')



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/tr.js"></script>
<!-- Custom JS -->
<script src="{{ asset('js/custom.js') }}"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




@stack('scripts')
</body>
</html>
