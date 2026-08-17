@extends('layouts.admin')

@section('content')
    <!-- Card de Detalhes -->
    <div class="card shadow-sm border-0">
        <!-- Cabeçalho -->
        <div class="card-header bg-white py-3 border-bottom">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="card-title h4 mb-0 fw-bold">Detalhes {{ $titlepage }}</h3>
                </div>
                <div class="col-auto">
                    <a class="btn btn-outline-secondary" href="{{ route("$route.index") }}" data-bs-toggle="tooltip"
                        title="Voltar">
                        <i class="bi bi-arrow-left me-1"></i> Voltar
                    </a>
                </div>
            </div>
        </div>

        <!-- Corpo -->
        <div class="card-body p-4">
            <ul class="list-group list-group-flush">
                @isset($datapage)
                    @foreach ($form_show as $frm)
                        @php
                            // Lido uma vez e reaproveitado abaixo, em vez de repetir
                            // $datapage->{$frm['name']} e json_decode() várias vezes.
                            // O ?? '' evita warning de null passado pra json_decode()/
                            // ucfirst() em colunas nullable (ex.: campos do Site).
                            $fieldValue = $datapage->{$frm['name']} ?? '';
                            $decodedValue = json_decode($fieldValue);
                        @endphp
                        <li class="list-group-item px-0 py-3">
                            <div class="row align-items-start gy-1">
                                <div class="col-12 col-sm-3 text-secondary small text-uppercase fw-semibold pt-1">
                                    {{ ucfirst($frm['title']) }}
                                </div>
                                <div class="col-12 col-sm-9">
                                    @if (is_array($decodedValue))
                                        @foreach ($decodedValue as $lts)
                                            @if (isset($frm['id']))
                                                <p class="mb-1">{{ App\Models\Perguntas::findOrFail($lts)->question }}</p>
                                            @else
                                                <span
                                                    class="badge bg-primary-subtle text-primary border border-primary-subtle me-1">{{ $lts }}</span>
                                            @endif
                                        @endforeach
                                    @else
                                        @if ($frm['name'] == 'image')
                                            <img src="{{ asset($fieldValue) }}" class="img-thumbnail"
                                                style="max-height: 150px;" alt="{{ asset($fieldValue) }}">
                                        @elseif ($frm['name'] == 'video')
                                            <video width="320" height="240" controls>
                                                <source src="{{ asset('videos_enquete/' . $fieldValue) }}"
                                                    type="video/mp4">
                                            </video>
                                        @else
                                            @if (isset($frm['status']))
                                                @if ($fieldValue == 0)
                                                    <span
                                                        class="badge bg-danger-subtle text-danger border border-danger-subtle">Desabilitado</span>
                                                @else
                                                    <span
                                                        class="badge bg-success-subtle text-success border border-success-subtle">Habilitado</span>
                                                @endif
                                            @else
                                                <span class="fw-medium">{{ Str::limit(ucfirst($fieldValue), 120) }}</span>
                                            @endif
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                @endisset

                @isset($rolePermissions)
                    <li class="list-group-item px-0 py-3">
                        <div class="row align-items-start gy-1">
                            <div class="col-12 col-sm-3 text-secondary small text-uppercase fw-semibold pt-1">
                                Permissões
                            </div>
                            <div class="col-12 col-sm-9 d-flex flex-wrap gap-2">
                                @foreach ($rolePermissions as $v)
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                        {{ $v->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </li>
                @endisset
            </ul>
        </div>
    </div>
@endsection
