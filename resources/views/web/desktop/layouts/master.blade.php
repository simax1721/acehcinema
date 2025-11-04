<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Aceh Cinema</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ url('/assets/css/style.css') }}">

  <!-- External libraries -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
  <script src="https://kit.fontawesome.com/b69e31cf66.js" crossorigin="anonymous"></script>

  @stack('styles')
</head>
<body>

  {{-- 🧭 Navbar --}}
  <nav class="navbar navbar-dark navbar-expand-md nav-costum-bg sticky-top">
    <div class="w-100 d-flex justify-content-between align-items-center" id="navbarNav">
      <div class="d-flex align-items-center">
        <a class="navbar-brand mobile-logo" href="/">
          <img src="{{ url('/assets/img/hero-section-logo.png') }}" alt="aceh cinema logo" height="30">
        </a>
      </div>

      <div class="d-flex align-items-center">
        <ul class="navbar-nav" id="nav-left-menu">
          <li class="nav-item"><a class="nav-link nav-link-costume nav-link-costume-menu" href="/">Beranda</a></li>
          <li class="nav-item"><a class="nav-link nav-link-costume nav-link-costume-menu" href="{{ url('/section-movie/fiction') }}">Fiksi</a></li>
          <li class="nav-item"><a class="nav-link nav-link-costume nav-link-costume-menu" href="{{ url('/section-movie/documentary') }}">Dokumentari</a></li>
          <li class="nav-item"><a class="nav-link nav-link-costume nav-link-costume-menu" href="#">Favoritku</a></li>
          <li class="nav-item"><a class="nav-link nav-link-costume" href="#"><i class="fa-solid fa-magnifying-glass"></i></a></li>
          <li class="nav-item"><a class="nav-link nav-link-costume" href="#"><i class="fa-regular fa-bell"></i></a></li>

          {{-- 🧑 Auth Area --}}
          <li class="nav-item dropdown">
            <a class="nav-link nav-link-costume" href="#" id="user-name" data-bs-toggle="dropdown"><i class="fa-regular fa-circle-user"></i></a>
            <ul class="dropdown-menu" id="user-dropdown" {{-- style="margin-left: -55px" --}}>
                <li class="d-none auth-in-session"><a class="dropdown-item" href="/profil">Profil Saya</a></li>
                <li class="d-none auth-in-session"><hr class="dropdown-divider"></li>
                <li class="d-none auth-in-session"><a class="dropdown-item text-danger" href="#" id="logout-btn">Keluar</a></li>
                <li class="d-none auth-out-session"><a class="dropdown-item" href="#" id="open-auth-modal">Masuk / Daftar</a></li>
            </ul>
          </li>
          {{-- <li class="nav-item dropdown ms-2" id="nav-auth-area">
            <a class="nav-link nav-link-costume" href="#" id="navbarUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-regular fa-circle-user"></i> <span id="user-name">Masuk</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUser" id="user-dropdown">
              <li><a class="dropdown-item" href="#" id="open-auth-modal">Masuk / Daftar</a></li>
            </ul>
          </li> --}}
        </ul>
      </div>
    </div>
  </nav>

  {{-- 📱 Bottom Navbar --}}
  <div class="navbar-bottom">
    <div class="container-fluid d-flex justify-content-between" id="nav-bottom-menu">
      <a href="/" class="nav-bottom-link"><i class="fa-solid fa-house"></i><br><span>Beranda</span></a>
      <a href="{{ url('/section-movie/1') }}" class="nav-bottom-link"><i class="fa-solid fa-film"></i><br><span>Fiksi</span></a>
      <a href="{{ url('/section-movie/1') }}" class="nav-bottom-link"><i class="fa-solid fa-book"></i><br><span>Dokumentari</span></a>
      <a href="#" class="nav-bottom-link"><i class="fa-solid fa-bookmark"></i><br><span>Favoritku</span></a>
    </div>
  </div>

  {{-- 🧩 Main Content --}}
  @yield('main-content')

  {{-- Tooltip & Modal --}}
  @include('web.desktop.layouts.components.movie-tooltip')

  {{-- Modal Auth --}}
  <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="background-color: transparent; border: 0">
        <div class="modal-body">
          @include('web.desktop.layouts.components.loginForm')
        </div>
      </div>
    </div>
  </div>

  <!-- JS Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ url('assets/js/auth.js') }}"></script>
  <script src="{{ url('assets/js/script.js') }}"></script>

  <script>
    AOS.init();
  </script>

  @stack('scripts')
</body>
</html>
