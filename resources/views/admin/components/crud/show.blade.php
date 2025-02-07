@extends('layouts.admin')


@section('content')
    <!-- Card with header and footer -->
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10">
                    <h3>Detalhes</h3>
                </div>
                <div class="col-md-2 ms-auto d-flex justify-content-end">
                    <a class="btn btn-lg btn-primary rounded-circle" href="{{ route("$route.index") }}"><i
                            class="bi bi-arrow-left fs-3"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-lg-8 my-5">
                <!-- List group with custom content -->
                <ol class="list-group list-group-numbered">
                    @isset($datapage)
                        @foreach ($form_show as $frm)
                            @if (isset($frm['img']))
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">{{ ucfirst($frm['title']) }}</div>
                                        <img src="{{ asset($datapage->{$frm['name']}) }}" class="img-thumbnail"
                                            alt="{{ asset($datapage->{$frm['name']}) }}">
                                    </div>
                                    {{-- <span class="badge bg-primary rounded-pill">14</span> --}}
                                </li>
                            @else
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">{!! ucfirst($frm['title']) !!}</div>
                                        @if (is_array(json_decode($datapage->{$frm['name']})))
                                            @foreach (json_decode($datapage->{$frm['name']}) as $key => $lts)
                                                {{-- <p>{{ App\Models\Perguntas::findOrFail($lts)->question }}</p> --}}
                                                {{ $lts }}<br/>
                                            @endforeach
                                        @else
                                            @if (isset($frm['status']))
                                                <td>{{ $datapage->{$frm['name']} == 0 ? 'Desabilitado' : 'Habilitado' }}</td>
                                            @else
                                                {!! Str::limit(ucfirst($datapage->{$frm['name']}), 120) !!}
                                            @endif
                                        @endif
                                        {{-- {{ ucfirst($datapage->{$frm['name']}) }} --}}
                                        {{-- {{ is_array(json_decode($datapage->{$frm['name']})) ? 'Array' : 'not an Array' }} --}}
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    @endisset
                    @isset($rolePermissions)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Permissões</div>
                                <div class="my-3">
                                    @foreach ($rolePermissions as $v)
                                        <button type="button" class="btn btn-primary mb-2">
                                            {{ App\Helpers\WebHelper::rename_role($v->name) }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    @endisset
                </ol><!-- End with custom content -->
            </div>
        </div>
        <div class="card-footer">

        </div>
    </div><!-- End Card with header and footer -->
@endsection
