<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Aplica o tema salvo o mais cedo possível, antes do primeiro paint,
         para não piscar claro-depois-escuro ao carregar a página. -->
    <script>
        (function () {
            var stored = localStorage.getItem('theme');
            var theme = stored || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-bs-theme', theme);
        })();
    </script>

    @php
        // Cache leve do model do site para evitar múltiplas consultas ao banco no header/meta
        $site = App\Models\Site::first();
    @endphp

    <meta name="description" content="{{ $site->description ?? '' }}">
    <meta name="keywords" content="{{ $site->keywords ?? '' }}">
    @stack('meta')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $site->name ?? config('app.name', 'Laravel') }}</title>

    <!-- Favicons -->
    @if (!empty($site->favicon))
        <link rel="icon" href="{{ asset($site->favicon) }}">
        <link rel="apple-touch-icon" href="{{ asset($site->favicon) }}">
    @endif

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&family=Open+Sans:wght@300;400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/datatable/datatables.min.css') }}" rel="stylesheet">

    <!-- Vite Assets (Bootstrap + App Styles) -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100 bg-light">

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center bg-white border-bottom shadow-sm px-3">
        <div class="d-flex align-items-center justify-content-between gap-3">
            <a href="{{ route('home') }}" class="logo d-flex align-items-center text-decoration-none">
                @if (!empty($site->logo))
                    <img src="{{ asset($site->logo) }}" alt="{{ $site->name }}" class="img-fluid"
                        style="max-height: 40px;">
                @else
                    <span class="fw-bold fs-4 text-dark">{{ $site->name ?? 'Admin' }}</span>
                @endif
            </a>
            <button class="btn btn-link link-dark p-0 toggle-sidebar-btn" type="button" aria-label="Alternar Menu">
                <i class="bi bi-list fs-3"></i>
            </button>
        </div><!-- End Logo -->

        @include('admin.components.navbar')
    </header><!-- End Header -->

    <!-- Sidebar -->
    @include('admin.components.sidebar')

    <!-- Main Content Container -->
    <main id="main" class="main flex-grow-1 p-3 p-md-4 mt-5">

        <!-- Breadcrumb / Pagetitle -->
        @if (isset($breadcrumbs) && count($breadcrumbs) > 0)
            <div class="pagetitle mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 py-1 px-0 bg-transparent">
                        @foreach ($breadcrumbs as $brdc)
                            <li class="breadcrumb-item {{ $loop->last ? 'active fw-semibold' : '' }}"
                                {{ $loop->last ? 'aria-current=page' : '' }}>
                                @if ($loop->last)
                                    {{ $brdc['title'] }}
                                @else
                                    <a href="{{ url($brdc['url']) }}"
                                        class="text-decoration-none">{{ $brdc['title'] }}</a>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </nav>
            </div>
        @endif
        <!-- End Page Title -->

        <!-- Flashed Messages -->
        @include('admin.components.flashMessage')

        <!-- Dynamic Page Content -->
        @yield('content')

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer py-3 bg-white border-top text-center text-muted mt-auto">
        <div class="container-fluid">
            <small class="copyright">
                &copy; {{ date('Y') }} <strong><span>Ono Tecnologia</span></strong>. Todos os direitos reservados.
            </small>
        </div>
    </footer><!-- End Footer -->

    <!-- Back to top button -->
    <a href="#"
        class="back-to-top d-flex align-items-center justify-content-center btn btn-primary rounded-circle shadow position-fixed bottom-0 end-0 m-3 d-none"
        style="width: 40px; height: 40px;" aria-label="Voltar ao topo">
        <i class="bi bi-arrow-up-short fs-4"></i>
    </a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatable/datatables.min.js') }}"></script>

    <!-- Custom Scripts Injection -->
    @stack('scripts')

</body>

</html>
