<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Laravel SB Admin 2">
    <meta name="author" content="Alejandro RH">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') . ' | DASHBOARD' }}</title>

    <!-- Fonts -->
    <script src="https://kit.fontawesome.com/b69e31cf66.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ url('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/admin/css/style.css">
    <link rel="stylesheet" href="{{ url('admin/vendor/toastr/toastr.min.css') }}">

    <!-- Favicon -->
    {{-- <link href="{{ url('') }}" rel="icon" type="image/png"> --}}

    @stack('css')
</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav {{-- bg-gradient-primary --}} {{-- bg-dark --}} sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: var(--aceh-cinema-primary)">

         <!-- Sidebar - Brand -->
         <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/admin/dashboard') }}">
            <div class="sidebar-brand-icon">
                <img style="width: 80px" class="" src="{{ url('assets/img/hero-section-logo.png') }}" alt="">
            </div>
            {{-- <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div> --}}
        </a>

        <!-- Divider -->

        <hr class="sidebar-divider">
        
        <li class="nav-item ">
            <a class="nav-link pb-2" href="{{ url('/admin/dashboard') }}">
                <i class="fas fa-fw fa-dashboard"></i>
                <span>Dashboard</span></a>
        </li>
        
        <li class="nav-item ">
            <a class="nav-link pb-2" href="{{ url('/admin/movie') }}">
                <i class="fas fa-fw fa-film"></i>
                <span>Film</span></a>
        </li>

        
        


        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0 bg-dark text-dark" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

              <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <h3 style="font-family: Arial, Helvetica, sans-serif">ACEH CINEMA</h3>

              <!-- Topbar Navbar -->
              <ul class="navbar-nav ml-auto">

                
                  

                  <div class="topbar-divider d-none d-sm-block"></div>

                  <!-- Nav Item - User Information -->
                  <li class="nav-item dropdown no-arrow">
                      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="mr-2 d-none d-lg-inline text-gray-600 small" id="admin-name"></span>
                          <figure class="img-profile rounded-circle avatar font-weight-bold" id="admin-name-first" data-initial="" style="background-color: var(--aceh-cinema-primary)"></figure>
                      </a>
                      <!-- Dropdown - User Information -->
                      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                          <a class="dropdown-item" href="#{{ url('admin/profile') }}">
                              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                              {{ __('Profile') }}
                          </a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                              {{ __('Logout') }}
                          </a>
                      </div>
                  </li>

              </ul>

          </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">@yield('title')</h1>

                @if (session('success'))
                <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                @if (session('danger'))
                <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
                    {{ session('danger') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success border-left-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger border-left-danger" role="alert">
                        <ul class="pl-4 my-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('main-content')

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Aceh Cinema {{ now()->year }}</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Ready to Leave?') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                <a class="btn btn-danger" href="#" id="admin-logout-btn">{{ __('Logout') }}</a>
                {{-- <form id="logout-form" action="{{ url('api/auth/logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>        --}}
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ url('admin/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ url('admin/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ url('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ url('admin/js/sb-admin-2.min.js') }}"></script>
<script src="{{ url('admin/vendor/toastr/toastr.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ url('admin/js/auth.js') }}"></script>
<script src="{{ url('admin/js/script.js') }}"></script>

@stack('scripts')
</body>
</html>