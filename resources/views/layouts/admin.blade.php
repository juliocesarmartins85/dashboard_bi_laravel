<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <meta content="{{ App\Models\Site::first()->description }}" name="description">
    <meta content="{{ App\Models\Site::first()->keywords }}" name="keywords">
    @stack('meta')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ App\Models\Site::first()->name }}</title>

    <!-- Favicons -->
    <link href="{{ asset(App\Models\Site::first()->favicon) }}" rel="icon">
    <link href="{{ asset(App\Models\Site::first()->favicon) }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/datatable/datatables.min.css') }}" rel="stylesheet">
    <!-- Template Main CSS File -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="logo d-flex align-items-center justify-content-center">
                <div><img class="w-100" src="{{ asset(App\Models\Site::first()->logo) }}"></div>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        @include('admin.components.navbar')

    </header><!-- End Header -->

    @include('admin.components.sidebar')

    <main id="main" class="main">
        <div class="pagetitle">
            {{-- <h1>{{ $titlepage }}</h1> --}}
            <nav>
                <ol class="breadcrumb">
                    @foreach ($breadcrumbs as $key_brdc => $brdc)
                        <li class="breadcrumb-item {{ $loop->iteration == count($breadcrumbs) ? 'active' : '' }}"><a
                                href="{{ url($brdc['url']) }}">{{ $brdc['title'] }}</a>
                        </li>
                    @endforeach
                    {{-- <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li> --}}
                </ol>
            </nav>
        </div><!-- End Page Title -->

        @include('admin.components.flashMessage')

        @yield('content')

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Ono Tecnologia</span></strong>. Todos os direitos reservados
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatable/datatables.min.js') }}"></script>

    <!-- Template Main JS File -->
    @stack('scripts')

</body>

</html>
