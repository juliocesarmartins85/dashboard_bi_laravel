@php
    // Uma única consulta reaproveitada abaixo, em vez de 5 chamadas
    // separadas a App\Models\Site::first() espalhadas pelo <head> e pelo body.
    $site = App\Models\Site::first();
@endphp
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <meta content="{{ $site->description }}" name="description">
    <meta content="{{ $site->keywords }}" name="keywords">
    @stack('meta')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $site->name }} | Login</title>

    <!-- Aplica o tema salvo (mesma chave usada no admin) antes do primeiro
         paint, para não piscar claro-depois-escuro ao carregar a página. -->
    <script>
        (function () {
            var stored = localStorage.getItem('theme');
            var theme = stored || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-bs-theme', theme);
        })();
    </script>

    <!-- Favicons -->
    <link href="{{ $site->favicon }}" rel="icon">
    <link href="{{ $site->favicon }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <style>
        .login-card {
            width: 100%;
        }

        .login-card .btn-primary[disabled] {
            opacity: .75;
            cursor: progress;
        }

        .toggle-password {
            cursor: pointer;
        }

        .login-alert {
            width: 100%;
        }

        #theme-toggle-btn {
            width: 42px;
            height: 42px;
            z-index: 10000;
        }

        /* Esta página usa o Bootstrap estático (assets/vendor/bootstrap),
           que não conhece data-bs-theme — diferente do admin (compilado via
           Vite). Os overrides abaixo replicam a mesma paleta escura do
           Bootstrap 5.3 na mão, só para os elementos que existem aqui. */
        [data-bs-theme="dark"] {
            background-color: #212529;
        }

        [data-bs-theme="dark"] body {
            background: #212529;
            color: #dee2e6;
        }

        [data-bs-theme="dark"] .card {
            background-color: #2b3035;
            color: #dee2e6;
        }

        [data-bs-theme="dark"] .card-title,
        [data-bs-theme="dark"] .form-label,
        [data-bs-theme="dark"] .form-check-label {
            color: #dee2e6;
        }

        [data-bs-theme="dark"] p.text-center.small {
            color: #adb5bd;
        }

        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .input-group-text {
            background-color: #212529;
            border-color: #495057;
            color: #dee2e6;
        }

        [data-bs-theme="dark"] .form-control:focus {
            background-color: #212529;
            color: #dee2e6;
            border-color: #4154f1;
        }

        [data-bs-theme="dark"] .form-control::placeholder {
            color: #6c757d;
        }

        [data-bs-theme="dark"] a {
            color: #8fa5ff;
        }

        [data-bs-theme="dark"] .form-check-input {
            background-color: #212529;
            border-color: #495057;
        }

        [data-bs-theme="dark"] .form-check-input:checked {
            background-color: #4154f1;
            border-color: #4154f1;
        }

        [data-bs-theme="dark"] .alert-success {
            background-color: rgba(25, 135, 84, .15);
            border-color: rgba(25, 135, 84, .4);
            color: #75dfa0;
        }

        [data-bs-theme="dark"] .alert-danger {
            background-color: rgba(220, 53, 69, .15);
            border-color: rgba(220, 53, 69, .4);
            color: #ea868f;
        }

        [data-bs-theme="dark"] #theme-toggle-btn {
            background-color: #2b3035;
            border-color: #495057;
            color: #dee2e6;
        }
    </style>

    <!-- =======================================================
  * Template Name: NiceAdmin - v2.5.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <button type="button" id="theme-toggle-btn"
        class="btn btn-light border rounded-circle shadow-sm position-fixed top-0 end-0 m-3 d-flex align-items-center justify-content-center"
        title="Alternar tema">
        <i class="bi bi-moon-stars" id="theme-toggle-icon"></i>
    </button>

    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="card mb-3 login-card">

                                <div class="card-body">

                                    <div class="pt-4 pb-2 text-center">
                                        <img src="{{ asset($site->logo) }}" class="w-100" alt="{{ $site->name }}">
                                        <h5 class="card-title pb-0 fs-4">Faça login na sua conta</h5>
                                        <p class="text-center small">Digite seu e-mail e senha para entrar</p>
                                    </div>

                                    {{-- Feedback geral: mensagens de sucesso vindas de outros fluxos
                                         (ex.: redefinição de senha concluída) --}}
                                    @if (session('status'))
                                        <div class="alert alert-success login-alert py-2" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    {{-- Feedback geral: erros que não pertencem a um campo específico
                                         (ex.: bloqueio por excesso de tentativas de login) --}}
                                    @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
                                        <div class="alert alert-danger login-alert py-2" role="alert">
                                            {{ $errors->first() }}
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('login') }}" id="loginForm"
                                        class="row g-3 needs-validation" novalidate>
                                        @csrf

                                        <div class="col-12">
                                            <label for="email"
                                                class="form-label">{{ __('Endereço de email') }}</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    name="email" value="{{ old('email') }}" required
                                                    autocomplete="username email" autofocus
                                                    aria-describedby="inputGroupPrepend @error('email') email-feedback @enderror">
                                                @error('email')
                                                    <span class="invalid-feedback" id="email-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="form-label">{{ __('Senha') }}</label>
                                            <div class="input-group has-validation">
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="current-password"
                                                    aria-describedby="@error('password') password-feedback @enderror">
                                                <span class="input-group-text toggle-password" id="togglePassword"
                                                    role="button" tabindex="0"
                                                    aria-label="Mostrar senha" aria-pressed="false">
                                                    <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                                </span>
                                                @error('password')
                                                    <span class="invalid-feedback" id="password-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex align-items-center justify-content-between">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label small" for="remember">
                                                    {{ __('Lembrar-me') }}
                                                </label>
                                            </div>
                                            @if (Illuminate\Support\Facades\Route::has('password.request'))
                                                <a class="small" href="{{ route('password.request') }}">
                                                    {{ __('Esqueceu a senha?') }}
                                                </a>
                                            @endif
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit" id="loginSubmit">
                                                <span id="loginSubmitLabel">{{ __('Login') }}</span>
                                                <span id="loginSubmitSpinner"
                                                    class="spinner-border spinner-border-sm ms-1 d-none"
                                                    role="status" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <script>
        (function () {
            // Alterna a visibilidade da senha (clique ou teclado).
            var toggle = document.getElementById('togglePassword');
            var icon = document.getElementById('togglePasswordIcon');
            var passwordInput = document.getElementById('password');

            function togglePasswordVisibility() {
                var isHidden = passwordInput.type === 'password';
                passwordInput.type = isHidden ? 'text' : 'password';
                icon.classList.toggle('bi-eye', !isHidden);
                icon.classList.toggle('bi-eye-slash', isHidden);
                toggle.setAttribute('aria-pressed', String(isHidden));
                toggle.setAttribute('aria-label', isHidden ? 'Ocultar senha' : 'Mostrar senha');
            }

            toggle.addEventListener('click', togglePasswordVisibility);
            toggle.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    togglePasswordVisibility();
                }
            });

            // Feedback visual de carregamento: evita duplo envio e mostra
            // "Entrando..." enquanto a requisição de login está em andamento.
            // Só desabilita o botão quando o formulário é válido, para não
            // travar o submit em caso de erro de validação do navegador.
            var form = document.getElementById('loginForm');
            var submitBtn = document.getElementById('loginSubmit');
            var submitLabel = document.getElementById('loginSubmitLabel');
            var submitSpinner = document.getElementById('loginSubmitSpinner');

            form.addEventListener('submit', function () {
                if (!form.checkValidity()) {
                    return;
                }

                submitBtn.disabled = true;
                submitLabel.textContent = 'Entrando...';
                submitSpinner.classList.remove('d-none');
            });
        })();
    </script>

    <script>
        (function () {
            // Mesma chave de localStorage do admin ('theme'), para que a
            // preferência escolhida em qualquer uma das duas telas valha
            // para a outra também.
            var toggleBtn = document.getElementById('theme-toggle-btn');
            var icon = document.getElementById('theme-toggle-icon');

            function applyIcon(theme) {
                icon.classList.toggle('bi-moon-stars', theme !== 'dark');
                icon.classList.toggle('bi-sun', theme === 'dark');
            }

            applyIcon(document.documentElement.getAttribute('data-bs-theme') || 'light');

            toggleBtn.addEventListener('click', function () {
                var next = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-bs-theme', next);
                localStorage.setItem('theme', next);
                applyIcon(next);
            });
        })();
    </script>

</body>

</html>
