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
        <!-- <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" /> -->
        <script data-search-pseudo-elements src="{{ asset('js/all.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/feather.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <!-- Odometer -->
        <link href="{{ asset('../css/odometer.css') }}" rel="stylesheet">
        <script src="{{ asset('../js/odometer.js') }}"></script>
    </head>
    <body class="nav-fixed">
        <div id="app">
            <master-top-bar app_name="{{ env('APP_NAME') }}" user_data="{{ auth()->user() }}"></master-top-bar>
            <div id="layoutSidenav">
                <master-side-bar user_data="{{ auth()->user() }}"></master-side-bar>
                <div id="layoutSidenav_content">
                    <main class="bg-light">
                        @yield('content')
                    </main>
                    <master-footer app_name="{{ env('APP_NAME') }}"></master-footer>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
    </body>
</html>
