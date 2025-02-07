@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header mb-3">
            <div class="row">
                <div class="col-md-10">
                    <h3>Adicionar Novo</h3>
                </div>
                <div class="col-md-2 ms-auto d-flex justify-content-end">
                    <a class="btn btn-lg btn-primary rounded-circle" href="{{ route("$route.index") }}"><i
                            class="bi bi-arrow-left fs-3"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            {{-- <div id="form"></div> --}}
            <form action="{{ route("$route.store") }}" method="POST" class="row g-3 needs-validation"
                enctype="multipart/form-data" novalidate>
                @csrf
                @foreach ($form_create as $frm)
                    @switch($frm['tag'])
                        @case('textarea')
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{ $frm['title'] }}:</strong>
                                    <textarea class="form-control" style="height:150px" name="{{ $frm['name'] }}" placeholder="{{ $frm['placeholder'] }}"
                                        required></textarea>
                                </div>
                            </div>
                        @break

                        @case('radio')
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <fieldset class="row mb-3">
                                    <legend class="col-form-label col-sm-2 pt-0">{{ ucwords($frm['title']) }}:</legend>
                                    <div class="col-sm-10">
                                        @foreach ($frm['options'] as $keyoptions => $options)
                                            <div class="form-check">
                                                <input class="form-check-input" type="{{ $frm['type'] }}"
                                                    name="{{ $frm['name'] }}" id="{{ $keyoptions }}"
                                                    value="{{ $options['type'] }}" {{ $keyoptions == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $keyoptions }}">
                                                    {{ ucwords($options['title']) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </fieldset>
                            </div>
                        @break

                        @case('date')
                            <div class="row mb-3">
                                <label for="inputDate" class="col-sm-2 col-form-label">{{ ucwords($frm['title']) }}</label>
                                <div class="col-sm-4">
                                    <input type="date" name="{{ $frm['name'] }}[]" class="form-control">
                                </div>
                                <div class="col-sm-2">
                                    <input type="time" name="{{ $frm['name'] }}[]" class="form-control">
                                </div>
                            </div>
                        @break

                        @case('select')
                            <div class="row my-3">
                                <label class="col-sm-2 col-form-label">{{ ucwords($frm['title']) }}</label>
                                <div class="col-sm-3">
                                    <select class="form-select" aria-label="Default select example" name="{{ $frm['name'] }}"
                                        id="{{ $frm['name'] }}">
                                        @foreach ($frm['options'] as $keyoptions => $options)
                                            <option value="{{ $options['type'] }}">{{ ucwords($options['title']) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @break

                        @case('multipleselect')
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">{{ ucwords($frm['title']) }}</label>
                                <div class="col-sm-10">
                                    <select class="form-select" multiple aria-label="multiple select example"
                                        name="{{ $frm['name'] }}[]" id="{{ $frm['name'] }}">
                                        @foreach (json_decode($frm['options']) as $keyoptions => $options)
                                            {{ $options->id }}
                                            <option value="{{ $options->id }}">{{ $options->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @break

                        @case('arquivo')
                            <div class="mb-3">
                                <label class="form-label" for="inputFile">{{ ucwords($frm['title']) }}:</label>
                                <input type="file" onchange="upload_check()" name="{{ $frm['name'] }}"
                                    id="inputFile{{ $frm['name'] }}" class="form-control @error('file') is-invalid @enderror"
                                    accept="video/*, image/png, image/jpeg, .pdf" {{-- required --}}>
                                <input id="max_id" type="hidden" name="MAX_FILE_SIZE" value="200000000" />
                                {{--                                 @error('file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror --}}
                            </div>
                        @break

                        @case('editor')
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="inputFile"><strong>{{ ucwords($frm['title']) }}:</strong></label>
                                <div>
                                    <div id="editor"></div>
                                    <input type="hidden" id="quill_html" name="{{ $frm['name'] }}">
                                </div>
                            </div>
                        @break

                        @default
                            @if ($frm['name'] == 'options')
                                <div id="optionsradio" class="col-md-12 mb-3 d-none">
                                    <label for="{{ $frm['name'] }}" class="form-label">{{ ucwords($frm['title']) }}</label>
                                    <input type="{{ $frm['type'] }}" name="{{ $frm['name'] }}" class="form-control"
                                        placeholder="{{ ucwords($frm['placeholder']) }}" id="{{ $frm['name'] }}">
                                    <div class="invalid-feedback">
                                        Digite um valor válido
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 mb-3">
                                    <label for="{{ $frm['name'] }}"
                                        class="form-label"><strong>{{ ucwords($frm['title']) }}:</strong></label>
                                    <input type="{{ $frm['type'] }}" name="{{ $frm['name'] }}" class="form-control"
                                        placeholder="{{ ucwords($frm['placeholder']) }}" id="{{ $frm['name'] }}" required>
                                    <div class="invalid-feedback">
                                        Digite um valor válido
                                    </div>
                                </div>
                            @endif
                    @endswitch
                @endforeach
                @isset($permission)
                    <div class="col-md-12">
                        <legend class="col-form-label col-sm-2 pt-0">Permissões</legend>
                        <div class="col-sm-10">
                            @foreach ($permission as $value)
                                <div class="form-check form-switch form-check-inline">
                                    <input class="form-check-input" name="permission[]" value="{{ $value->id }}"
                                        type="checkbox" id="permission{{ $value->id }}">
                                    <label class="form-check-label"
                                        for="permission{{ $value->id }}">{{ App\Helpers\WebHelper::rename_role($value->name) }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endisset
                @isset($rolesuser)
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Nivel de Permissão:</strong>
                            <select name="roles[]" class="form-control" multiple>
                                @foreach ($rolesuser as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endisset
                <div class="col-12">
                    <button class="btn btn-lg btn-success rounded-circle" type="submit"><i
                        class="bi bi-save fs-4"></i></button>
                </div>
            </form><!-- End Custom Styled Validation -->
        </div>
    </div><!-- End Card with header and footer -->
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

        function upload_check() {
            var upl = document.getElementById("inputFile");
            var max = document.getElementById("max_id").value;
            var alerta = document.createElement("div");
            alerta.classList.add("alert", "alert-danger");
            alerta.textContent = "Tamanho de arquivo inválido!";

            if (upl.files[0].size > max) {
                //alert("Tamanho de arquivo inválido!");
                // Exibir um alerta de erro
                document.getElementById('form').appendChild(alerta);
                upl.value = "";
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
