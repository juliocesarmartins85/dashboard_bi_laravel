@extends('layouts.admin')

@section('content')
    <div class="card shadow-sm border-0">
        <!-- Header do Card -->
        <div class="card-header bg-white py-3 border-bottom">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="card-title h4 mb-0 fw-bold">Adicionar {{ $titlepage }}</h3>
                </div>
                <div class="col-auto">
                    <a class="btn btn-outline-secondary" href="{{ route("$route.index") }}" data-bs-toggle="tooltip"
                        title="Voltar">
                        <i class="bi bi-arrow-left me-1"></i> Voltar
                    </a>
                </div>
            </div>
        </div>

        <!-- Corpo do Formidável -->
        <div class="card-body p-4">
            <form action="{{ route("$route.store") }}" method="POST" class="row g-3 needs-validation"
                enctype="multipart/form-data" novalidate>
                @csrf

                @foreach ($form_create as $frm)
                    @switch($frm['tag'])
                        @case('textarea')
                            <div class="col-12 col-md-{{ $frm['col'] }}">
                                <label for="{{ $frm['name'] }}" class="form-label fw-semibold">{{ $frm['title'] }}</label>
                                <textarea class="form-control" name="{{ $frm['name'] }}" id="{{ $frm['name'] }}" rows="4"
                                    placeholder="{{ $frm['placeholder'] }}" required></textarea>
                                <div class="invalid-feedback">Este campo é obrigatório.</div>
                            </div>
                        @break

                        @case('radio')
                            <div class="col-12 col-md-{{ $frm['col'] }}">
                                <label class="form-label fw-semibold d-block">{{ ucwords($frm['title']) }}</label>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach ($frm['options'] as $keyoptions => $options)
                                        <div class="form-check">
                                            <input class="form-check-input" type="{{ $frm['type'] }}" name="{{ $frm['name'] }}"
                                                id="radio_{{ $frm['name'] }}_{{ $keyoptions }}" value="{{ $options['type'] }}"
                                                {{ $keyoptions == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="radio_{{ $frm['name'] }}_{{ $keyoptions }}">
                                                {{ ucwords($options['title']) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @break

                        @case('date')
                            <div class="col-12 col-md-{{ $frm['col'] }}">
                                <label class="form-label fw-semibold">{{ ucwords($frm['title']) }}</label>
                                <div class="input-group">
                                    <input type="date" name="{{ $frm['name'] }}[]" class="form-control" required>
                                    <input type="time" name="{{ $frm['name'] }}[]" class="form-control" required>
                                </div>
                            </div>
                        @break

                        @case('select')
                            <div class="col-12 col-md-{{ $frm['col'] }}">
                                <label for="{{ $frm['name'] }}"
                                    class="form-label fw-semibold">{{ ucwords($frm['title']) }}</label>
                                <select class="form-select" name="{{ $frm['name'] }}" id="{{ $frm['name'] }}" required>
                                    <option value="" selected disabled>Selecione uma opção...</option>
                                    @foreach ($frm['options'] as $options)
                                        <option value="{{ $options['type'] }}">{{ ucwords($options['title']) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @break

                        @case('multipleselect')
                            <div class="col-12 col-md-{{ $frm['col'] }}">
                                <label for="{{ $frm['name'] }}"
                                    class="form-label fw-semibold">{{ ucwords($frm['title']) }}</label>
                                <select class="form-select" multiple name="{{ $frm['name'] }}[]" id="{{ $frm['name'] }}"
                                    required>
                                    @foreach ($frm['options'] as $options)
                                        @if ($frm['name'] == 'routers')
                                            <option value="{{ $options->id }}">{{ $options->nome }}</option>
                                        @else
                                            <option value="{{ $options->id }}">{{ $options->question }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        @break

                        @case('arquivo')
                            <div class="col-12 col-md-{{ $frm['col'] ?? 12 }}">
                                <label class="form-label fw-semibold"
                                    for="inputFile{{ $frm['name'] }}">{{ ucwords($frm['title']) }}</label>
                                <input type="file" onchange="upload_check(this)" name="{{ $frm['name'] }}"
                                    id="inputFile{{ $frm['name'] }}" class="form-control @error('file') is-invalid @enderror"
                                    accept="video/*, image/png, image/jpeg, .pdf" required>
                                <input type="hidden" name="MAX_FILE_SIZE" value="200000000" />
                                <div class="invalid-feedback">Selecione um arquivo válido.</div>
                            </div>
                        @break

                        @case('editor')
                            <div class="col-12 col-md-{{ $frm['col'] }}">
                                <label class="form-label fw-semibold">{{ ucwords($frm['title']) }}</label>
                                <div id="editor" style="min-height: 150px;"></div>
                                <input type="hidden" id="quill_html" name="{{ $frm['name'] }}">
                            </div>
                        @break

                        @default
                            @if ($frm['name'] == 'options')
                                <div id="optionsradio" class="col-12 col-md-{{ $frm['col'] }} d-none">
                                    <label for="{{ $frm['name'] }}"
                                        class="form-label fw-semibold">{{ ucwords($frm['title']) }}</label>
                                    <input type="{{ $frm['type'] }}" name="{{ $frm['name'] }}" class="form-control"
                                        placeholder="{{ ucwords($frm['placeholder']) }}" id="{{ $frm['name'] }}">
                                    <div class="invalid-feedback">Digite um valor válido.</div>
                                </div>
                            @else
                                <div class="col-12 col-md-{{ $frm['col'] }}">
                                    <label for="{{ $frm['name'] }}"
                                        class="form-label fw-semibold">{{ ucwords($frm['title']) }}</label>
                                    <input type="{{ $frm['type'] }}" name="{{ $frm['name'] }}" class="form-control"
                                        placeholder="{{ ucwords($frm['placeholder']) }}" id="{{ $frm['name'] }}" required>
                                    <div class="invalid-feedback">Digite um valor válido.</div>
                                </div>
                            @endif
                    @endswitch
                @endforeach

                <!-- Seção de Permissões -->
                @isset($permission)
                    <div class="col-12 mt-4">
                        <label class="form-label fw-semibold d-block border-bottom pb-2">Permissões</label>
                        <div class="d-flex flex-wrap gap-3 pt-2">
                            @foreach ($permission as $value)
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="permission[]" value="{{ $value->id }}"
                                        type="checkbox" id="permission{{ $value->id }}">
                                    <label class="form-check-label"
                                        for="permission{{ $value->id }}">{{ App\Helpers\WebHelper::rename_role($value->name) }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endisset

                <!-- Seção de Acessos -->
                @isset($rolesuser)
                    <div class="col-12 mt-3">
                        <label for="roles" class="form-label fw-semibold">Acessos</label>
                        <select name="roles[]" id="roles" class="form-select" multiple>
                            @foreach ($rolesuser as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                @endisset

                <!-- Ações do Formulário -->
                <div class="col-12 d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route("$route.index") }}" class="btn btn-light border">Cancelar</a>
                    <button class="btn btn-primary d-inline-flex align-items-center gap-2" type="submit">
                        <i class="ri-save-3-line"></i> Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var radioButtons = document.getElementsByName('type');
            var campoInput = document.getElementById('optionsradio');
            var campoInputOption = document.getElementById('options');

            radioButtons.forEach(function(radioButton) {
                radioButton.addEventListener('change', function() {
                    if (this.value != 'text') {
                        campoInput.classList.remove('d-none');
                        campoInputOption.setAttribute("required", "");
                    } else {
                        campoInput.classList.add('d-none');
                        campoInputOption.removeAttribute("required");
                    }
                });
            });
        });

        function upload_check(input) {
            // Precisa bater com o MAX_FILE_SIZE enviado junto no form.
            var maxSize = 200000000;

            if (!input.files.length) {
                return;
            }

            // Remove um alerta anterior deste mesmo campo, se houver, antes
            // de mostrar um novo (evita empilhar alertas repetidos).
            var existing = input.parentElement.querySelector('.upload-size-alert');
            if (existing) {
                existing.remove();
            }

            if (input.files[0].size > maxSize) {
                var alerta = document.createElement("div");
                alerta.classList.add("alert", "alert-danger", "mt-2", "upload-size-alert");
                alerta.textContent = "Arquivo muito grande. O limite é de " + Math.round(maxSize / 1024 / 1024) + " MB.";
                input.insertAdjacentElement('afterend', alerta);
                input.value = "";
            }
        };

        if (document.querySelector('#quill_html')) {
            //Se existir o id verdadeiro entra aqui
            var quill = new Quill('#editor', {
                theme: 'snow'
            });
            quill.on('text-change', function(delta, oldDelta, source) {
                document.getElementById("quill_html").value = quill.root.innerHTML;
            });
        } else {
            //Se não existir entra aqui.
        }
    </script>
@endpush
