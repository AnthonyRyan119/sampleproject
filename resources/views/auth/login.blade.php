<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>{{ env('APP_NAME') }}</title>
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="../img/PSG-blue.png" />
        <script data-search-pseudo-elements src="{{ asset('js/all.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/feather.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/app.js') }}"></script>

        <!-- Vendor CSS Files -->
        <link href="{{asset('assets/vendor/aos/aos.css')}}" rel="stylesheet">
        <link href="{{asset('assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
        <!-- end css template -->
    </head>
    <!-- bg-gradient-success-to-secondary -->
    <body class="nav-fixed ">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
            <div class="container px-4 h-100 container-login" data-aos="fade-up">
                    <div class="row h-100 d-flex justify-content-center align-items-center">
                        <div class="col-lg-11">
                            <div class="shadow bg-white rounded-3" data-aos="fade-up">
                                <div class="card border-0 rounded-left">
                                    <div class="card-body p-0">
                                        <div class="row no-gutters">
                                            <div class="col-lg-6">
                                                <div class="p-5">
                                                    <div class="mb-3">
                                                        <div class="row">
                                                            <!-- <div class="col text-center">
                                                                <span><img style="height: 90px" src="../img/PSG-Blue.png" alt=""></span>
                                                            </div> -->
                                                            <!-- <div class="col">
                                                                <p class="h1 font-weight-bold text-theme" style="color:#00AC69">Login</p>
                                                            </div> -->
                                                        </div>
                                                    </div>

                                                    <h6 class="h5 mb-0 text-center">Welcome!</h6>
                                                    <p class="text-muted mt-2 mb-4 text-center">Enter your Credentials to access this site.</p>

                                                    <form method="POST" action="{{ route('api.login') }}">
                                                        @csrf

                                                        @if ($errors->has('error'))
                                                            <div class="alert alert-danger" role="alert">
                                                                {{ $errors->first('error') }}
                                                            </div>  
                                                        @endif
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1" class="fw-600">Username</label>
                                                            <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter ursername or email address" required autofocus>
                                                        </div>
                                                        <div class="form-group mb-2 mt-2">
                                                            <label for="exampleInputPassword1" class="fw-600">Password</label>
                                                            <div class="input-group mb-3">
                                                                <input id="password" name="password" type="password" value="" class="input form-control" placeholder="Enter password" required/>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" onclick="password_show_hide();">
                                                                    <i class="fa-solid fa-eye" id="show_eye"></i>
                                                                    <i class="fa-solid fa-eye-slash d-none" id="hide_eye"></i>
                                                                    </span>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                        <div class="mb-2">
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <button type="submit" class="btn btn-primary">Login</button>
                                                                </div>
                                                                <div class="col-7" align="right">
                                                                    <input id="remember" type="checkbox" name="remember">
                                                                    <small style="margin-left: 5px;">Remember me</small>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="card-footer text-center">
                                                    
                                                </div>
                                            </div>

                                            <div class="col-lg-6 d-none d-lg-inline-block">
                                                <div class="account-block d-flex align-items-center rounded-right">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="footer-admin mt-auto">
                    <div class="container-xl px-4">
                        <div class="row">
                            <div class="col-md-6 small fw-400 text-muted">Copyright &copy; {{ env('APP_NAME') }} 2023</div>
                            <div class="col-md-6 text-md-end small fw-400 text-muted">
                                <a href="#!">Privacy Policy</a>
                                &middot;
                                <a href="#!">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        
        <!-- Vendor JS Files -->
        <script src="{{asset('assets/vendor/aos/aos.js')}}"></script>
        <script src="{{asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>

        <!-- Template Main JS File -->
        <script src="{{asset('assets/js/main.js')}}"></script>
        
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
    </body>
</html>
<script>
    function password_show_hide() {
        var x = document.getElementById("password");
        var show_eye = document.getElementById("show_eye");
        var hide_eye = document.getElementById("hide_eye");
        hide_eye.classList.remove("d-none");
        if (x.type === "password") {
            x.type = "text";
            show_eye.style.display = "none";
            hide_eye.style.display = "block";
        } else {
            x.type = "password";
            show_eye.style.display = "block";
            hide_eye.style.display = "none";
        }
    }
</script>
<style>
    @media (min-width: 1500px){
        .container-login{
            max-width: 1100px !important;
        }
    }

    /* Removed animation on smaller screens */
    @media screen and (max-width: 768px) {
        [data-aos] {
            pointer-events: auto !important;
        }

        html:not(.no-js) [data-aos^=fade][data-aos^=fade] {
            opacity: 1 !important;
        }

        html:not(.no-js) [data-aos=fade-up] {
            transform: none !important;
        }
    }

    body{
        background-image: linear-gradient(to top, #aceeae 0%, #e7fde7 100%);
        /* background: linear-gradient(to right, rgba(21, 153, 87, 0.8) 0%, rgba(21, 87, 153, 0.8) 100%), url(../img/hero-bg.jpg); */
        background-size: 100%;
    }
    
    .account-block {
        /* background-color: black; */
        background-image: url("../img/home_image2.jpg");
        background-repeat: no-repeat;
        height: 100%;
        position: relative;
        background-position: center;
        background-size: 80%;
    }
    .account-block .overlay {
        -webkit-box-flex: 1;
        -ms-flex: 1;
        flex: 1;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.4);
    }
    .account-block .account-testimonial {
        text-align: center;
        color: #fff;
        position: absolute;
        margin: 0 auto;
        padding: 0 1.75rem;
        left: 0;
        right: 0;
    }
</style>
