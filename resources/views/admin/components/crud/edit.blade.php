@extends('layouts.admin')


@section('content')
    <!-- Card with header and footer -->
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10">
                    <h2>Editar</h2>
                </div>
                <div class="col-md-2 ms-auto d-flex justify-content-end">
                    <a class="btn btn-lg btn-primary rounded-circle" href="{{ route("$route.index") }}"><i
                            class="bi bi-arrow-left fs-3"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body my-5">
            <div id="form"></div>
            <!-- Custom Styled Validation -->
            <form action="{{ route("$route.update", $datapage->id) }}" method="POST" class="row g-3 needs-validation"
                enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                @foreach ($form_edit as $frm)
                    @switch($frm['tag'])
                        @case('textarea')
                            <div class="col-md-12">
                                <label for="{{ $frm['name'] }}" class="form-label">{{ $frm['title'] }}</label>
                                <textarea class="form-control" style="height:150px" name="{{ $frm['name'] }}" id="{{ $frm['name'] }}" required>{{ $datapage->{$frm['value']} }}</textarea>
                                <div class="invalid-feedback">
                                    Digite um valor válido
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
                                                    value="{{ $options['type'] }}"
                                                    {{ $options['type'] == $datapage->{$frm['value']} ? 'checked' : '' }}>
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
                                    <input type="date" name="{{ $frm['name'] }}[]" class="form-control" {{-- required --}}>
                                </div>
                                <div class="col-sm-2">
                                    <input type="time" name="{{ $frm['name'] }}[]" class="form-control" step="1"
                                        {{-- required --}}>
                                </div>
                            </div>
                        @break

                        @case('select')
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">{{ ucwords($frm['title']) }}</label>
                                <div class="col-sm-3">
                                    <select class="form-select" aria-label="Default select example" name="{{ $frm['name'] }}"
                                        id="{{ $frm['name'] }}">
                                        @foreach ($frm['options'] as $keyoptions => $options)
                                            <option value="{{ $options['type'] }}"
                                                {{ $datapage->{$frm['value']} == $options['type'] ? 'selected' : '' }}>
                                                {{ ucwords($options['title']) }}</option>
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
                                        <option>Use Ctrl para selecionar as perguntas.</option>
                                        @foreach (json_decode($frm['options']) as $keyoptions => $options)
                                            <option value="{{ $options->id }}"
                                                {{ in_array($options->id, json_decode($datapage->{$frm['value']})) ? 'selected' : '' }}>
                                                {{ $options->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @break

                        @case('arquivo')
                            <div class="row mb-3">
                                <label class="form-label" for="inputFile">{{ ucwords($frm['title']) }}:</label>
                                <input type="file" onchange="upload_check()" name="{{ $frm['name'] }}" id="inputFile"
                                    class="form-control @error('file') is-invalid @enderror"
                                    accept="video/*, image/png, image/jpeg, .pdf" value="{{ asset($datapage->{$frm['value']}) }}">
                                <input id="max_id" type="hidden" name="MAX_FILE_SIZE" value="200000000" />
                                {{-- Regra para pdf banner --}}
                                @if ($frm['name'] == 'pdf')
                                    <input type="hidden" name="{{ $frm['name'] . '_old' }}"
                                        value="{{ App\Models\Footer::where('link', $datapage->{$frm['value']})->first()->doc ?? '' }}">
                                @else
                                @endif
                                @if (!empty($datapage->{$frm['value']}))
                                    {{-- Regra para imagem banner --}}
                                    @if (isset($frm['imgmobile']))
                                        <div class="ml-2 my-3 col-sm-6">
                                            <img src="{{ asset(str_replace('.', '-mobile.', $datapage->{$frm['value']})) }}"
                                                id="preview" class="img-thumbnail">
                                        </div>
                                        <input type="hidden" name="{{ $frm['name'] . '_old' }}"
                                            value="{{ str_replace('.', '-mobile.', $datapage->{$frm['value']}) }}">
                                    @else
                                        {{-- Regra para pdf banner --}}
                                        @if ($frm['name'] == 'pdf')
                                        @else
                                            <div class="ml-2 my-3 col-sm-6">
                                                <img src="{{ asset($datapage->{$frm['value']}) }}" id="preview"
                                                    class="img-thumbnail">
                                            </div>
                                            <input type="hidden" name="{{ $frm['name'] . '_old' }}"
                                                value="{{ $datapage->{$frm['value']} }}">
                                        @endif
                                    @endif
                                @endif
                            </div>
                        @break

                        @case('editor')
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="inputFile">{{ ucwords($frm['title']) }}:</label>
                                <div>
                                    <div id="editor">{!! $datapage->{$frm['value']} !!}</div>
                                    <input type="hidden" id="quill_html" name="{{ $frm['name'] }}">
                                </div>
                            </div>
                        @break

                        @case('hidden')
                            <input type="{{ $frm['type'] }}" id="{{ $frm['name'] }}" name="{{ $frm['name'] }}">
                        @break

                        @default
                            @if ($frm['name'] == 'options')
                                <div id="optionsradio" class="col-md-12 d-none">
                                    <label for="{{ $frm['name'] }}" class="form-label">{{ ucwords($frm['title']) }}</label>
                                    <input type="{{ $frm['type'] }}" name="{{ $frm['name'] }}" class="form-control"
                                        placeholder="{{ ucwords($frm['placeholder']) }}" id="{{ $frm['name'] }}"
                                        value="{{ $datapage->{$frm['value']} }}">
                                    <div class="invalid-feedback">
                                        Digite um valor válido
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 mb-3">
                                    <label for="{{ $frm['name'] }}" class="form-label">{{ ucwords($frm['title']) }}</label>
                                    <input type="{{ $frm['type'] }}" name="{{ $frm['name'] }}" class="form-control"
                                        placeholder="{{ ucwords($frm['placeholder']) }}" id="{{ $frm['name'] }}"
                                        value="{{ is_array(json_decode($datapage->{$frm['value']})) ? '' : $datapage->{$frm['value']} }}"
                                        required>
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

                            <div class="col-sm-10">
                                @foreach ($permission as $value)
                                    <div class="form-check form-switch form-check-inline">
                                        <input class="form-check-input" name="permission[]" value="{{ $value->id }}"
                                            type="checkbox" id="permission{{ $value->id }}"
                                            {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="permission{{ $value->id }}">{{ App\Helpers\WebHelper::rename_role($value->name) }}</label>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                @endisset
                @isset($roles)
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Role:</strong>
                            {!! Form::select('roles[]', $roles, $userRole, ['class' => 'form-control', 'multiple']) !!}
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
