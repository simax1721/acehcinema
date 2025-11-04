<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') . ' | DASHBOARD' }}</title>

    <!-- Fonts -->
    <link href="{{ url('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ url('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ url('admin/css/auth.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('admin/vendor/toastr/toastr.min.css') }}">

    <!-- Favicon -->
    {{-- <link href="{{ url('logo.png') }}" rel="icon" type="image/png"> --}}

    <style>
        
    </style>
</head>
<body class="">

    <main>
        <div class="row bg-dark" style="margin:0;">
            <div class="col-lg-4 bg-white text-center d-flex align-items-center justify-content-center" style="height: 100vh;">
                
                <div class="" style="width: 100%;">

                    <img style="width: 150px;" class="" src="{{ url('assets/img/hero-section-logo.png') }}" alt="">
                    <h1 class="mt-5 text-dark display-4">Login Admin</h1>

                    <div class="container">
                        {{-- @if ($errors->any())
                            <div class="alert alert-danger border-left-danger" role="alert">
                                <ul class="pl-4 my-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}
                        <form class="user" id="admin-loginForm">
                            {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
                            @csrf
                            <div class="main">
                                <div class="w-100">
                                <div class="text-field">
                                    <input type="email" placeholder="..." name="email" value="" required id="email" autofocus>
                                    <label>E-mail:</label>
                                </div>
                                </div>
                            
                                <div class="w-100">
                                <div class="text-field">
                                    <input type="password" placeholder="..." name="password" placeholder="{{ __('Password') }}" required id="password">
                                    <label>Password:</label>
                                </div>
                                </div>
                            </div>

                            <div class="form-group d-flex justify-content-between" style="margin: 5px 0 15px 0; font-size: 16px !important;">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" style="color: #000000AA" for="remember">{{ __('Remember Me') }}</label>
                                </div>
                                {{-- <div class="custom-control custom-checkbox small">
                                    <a href="{{ route('password.request') }}" style="color: #bc032f">Forgot Password?</a>
                                </div> --}}
                            </div>

                            <div class="button-field">
                                <button type="submit" id="admin-login-btn">
                                LOGIN
                                </button>
                            </div>

                            <div class="" style="margin-top: 40px">
                                {{-- <span style="font-size: 16px; margin-top: 15px;">New Here? <a href="{{ route('register') }}" style="color: #bc032f">Create Account</a></span> --}}
                                <br> <span style="font-size: 16px; margin-top: 15px;">Back to <a href="{{ url('/') }}" style="color: #FF9406">Home</a></span>
                            </div>

                        </form>
                    </div>
                    
                </div>

            </div>
            <div class="col-lg-8 d-flex align-items-center justify-content-center main-logo">
                <img class="d-none d-lg-block" src="{{ url('assets/img/hero-section-logo.png') }}" alt="" style="width: 50%">
            </div>
        </div>
    </main>
        

<!-- Scripts -->
<script src="{{ url('admin/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ url('admin/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ url('admin/js/sb-admin-2.min.js') }}"></script>
<script src="{{ url('admin/vendor/toastr/toastr.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ url('admin/js/auth.js') }}"></script>

<script>
    function sweetAlertNorm(title, text, icon) {
  Swal.fire({
    icon: icon,
    title: title,
    timer: 3000,
    text: text,
    // showConfirmButton: false,
  });
}
</script>

<script>
    // isLoggedInAdmin('login');
    $(document).ready(function () {
        // console.log(Auth.isLoggedIn());
        // redirect_dashboard();
    });
</script>
</body>
</html>
