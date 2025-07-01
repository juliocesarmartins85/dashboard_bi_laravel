<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
    <main>
        <div class="container">
            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <img src="{{ asset(App\Models\Site::first()->logo) }}"
                                            class="img-fluid rounded mx-auto d-block" alt="">
                                        <h5 class="card-title text-center pb-0 fs-4">Enquete Para Acesso</h5>
                                        <p class="text-center small">Responda as perguntas para se autenticar a rede.
                                        </p>
                                    </div>
                                    <form id="formenquete" class="row g-3 needs-validation"
                                        action="{{ route('wifi_free_conectar') }}" method="POST" novalidate>
                                        @csrf
                                        <input type="hidden" name="mac" value="{{ $res_mac_address }}">
                                        @foreach ($form as $key => $frm)
                                            @switch($frm['tag'])
                                                @case('dropdown')
                                                    <div class="col-md-12">
                                                        <div class="form-floating mb-3">
                                                            <select class="form-select" name="{{ $frm['name'] }}"
                                                                id="{{ $frm['title'] }}" required aria-label="">
                                                                <option selected disabled value="">Selecione um bairro
                                                                </option>
                                                                @foreach ($bairros as $brrs)
                                                                    <option value="{{ $brrs->id }}">{{ $brrs->bairro }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <label for="{{ $frm['title'] }}">{{ $frm['title'] }}</label>
                                                        </div>
                                                        <div class="invalid-feedback">Campo Obrigatório.</div>
                                                    </div>
                                                @break

                                                @default
                                                    <div class="col-md-12">
                                                        <div class="form-floating">
                                                            <input class="form-control" id="{{ $frm['name'] }}"
                                                                placeholder="{{ $frm['title'] }}" name="{{ $frm['name'] }}"
                                                                oninput="{{ $frm['name'] == 'telefone' ? 'mascaraTelefone(this)' : '' }}"
                                                                type="{{ $frm['type'] }}" name="{{ $frm['name'] }}"
                                                                required>
                                                            <label for="{{ $frm['name'] }}">{{ $frm['title'] }}</label>
                                                        </div>
                                                        <div class="invalid-feedback">Campo Obrigatório.</div>
                                                    </div>
                                            @endswitch
                                        @endforeach
                                        @foreach ($enquete as $key_enqt => $enqt)
                                            <input type="hidden" name="id_enquete" value="{{ $enqt->id_enquete }}">
                                            @switch($enqt->type)
                                                @case('checkbox')
                                                    <div class="col-12 mb-3">
                                                        <label for="pergunta{{ $enqt->id }}"
                                                            class="form-label">{{ $enqt->question }}</label>
                                                        <select class="form-select" multiple aria-label="select example"
                                                            name="pergunta[{{ $enqt->id }}][]" required>
                                                            <option selected disabled value="">Selecione uma resposta
                                                            </option>
                                                            @foreach (explode('/', $enqt->options) as $item)
                                                                <option value="{{ $item }}">{{ $item }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">Campo Obrigatório.</div>
                                                    </div>
                                                @break

                                                @case('radio')
                                                    <div class="col-md-12">
                                                        <div class="form-floating mb-3">
                                                            <select class="form-select" name="pergunta[{{ $enqt->id }}][]"
                                                                id="pergunta{{ $enqt->id }}" aria-label="" required>
                                                                <option selected disabled value="">Selecione uma resposta
                                                                </option>
                                                                @foreach (explode('/', $enqt->options) as $item)
                                                                    <option value="{{ $item }}">{{ $item }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <label
                                                                for="pergunta{{ $enqt->id }}">{{ $enqt->question }}</label>
                                                        </div>
                                                        <div class="invalid-feedback">Campo Obrigatório.</div>
                                                    </div>
                                                @break

                                                @default
                                                    <div class="col-md-12">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="{{ $enqt->id }}"
                                                                placeholder="{{ $enqt->question }}"
                                                                name="pergunta[{{ $enqt->id }}][]" required>
                                                            <label for="{{ $enqt->id }}">{{ $enqt->question }}</label>
                                                        </div>
                                                        <div class="invalid-feedback">Campo Obrigatório.</div>
                                                    </div>
                                            @endswitch
                                        @endforeach
                                        <div class="col-12">
                                            @include('admin.components.flashMessage')
                                            <button class="btn btn-primary w-100" type="submit">Enviar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="credits">
                                Criado por <a href="https://onotecnologia.com.br/">Ono Tecnologia</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main><!-- End #main -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="embed-responsive embed-responsive-16by9">
                        <video id="meu-video" class="embed-responsive-item w-100" playsinline>
                            <source src="{{ asset("videos_enquete/$video_enquete") }}" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <script src="assets/js/main.js"></script>

    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        function mascaraTelefone(input) {
            let value = input.value;
            value = value.replace(/\D/g, ''); // Remove caracteres não numéricos

            // Aplica a máscara (xx) xxxx-xxxx
            value = value.replace(/(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{5})(\d)/, '$1-$2');

            // Limita o número de caracteres para 14
            if (value.length > 15) {
                value = value.slice(0, 15);
            }

            input.value = value;
        }

        document.getElementById('formenquete').addEventListener('submit', function(event) {
            event.preventDefault();
            event.stopPropagation();

            var formulario = event.currentTarget;

            if (formulario.checkValidity() === false) {
                formulario.classList.add('was-validated');
                return;
            }
            document.querySelector('[type=submit]').disabled = true;
            if ({{ Js::from(!empty($video_enquete)) }}) {
                var myModal = new bootstrap.Modal(document.getElementById('myModal'));
                var video = document.getElementById("meu-video");
                myModal.show();
                video.play();
                video.addEventListener("ended", function() {
                    document.getElementById('formenquete').submit();
                });
            } else {
                document.getElementById('formenquete').submit();
            }
        });
    </script>

</body>

</html>
