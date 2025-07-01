@extends('layouts.admin')


@section('content')
    <!-- Card with header and footer -->
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10">
                    <h3>Detalhes {{ $titlepage }}</h3>
                </div>
                <div class="col-md-2 ms-auto d-flex justify-content-end">
                    <a class="btn btn-lg btn-primary" href="{{ route("$route.index") }}"><i
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
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">{{ ucfirst($frm['title']) }}</div>
                                    @if (is_array(json_decode($datapage->{$frm['name']})))
                                        @foreach (json_decode($datapage->{$frm['name']}) as $lts)
                                            @if (isset($frm['id']))
                                                <p>{{ App\Models\Perguntas::findOrFail($lts)->question }}</p>
                                            @else
                                                <span class="badge bg-primary">{{ $lts }}</span>
                                            @endif
                                        @endforeach
                                    @else
                                        @if ($frm['name'] == 'image')
                                            <img src="{{ asset($datapage->{$frm['name']}) }}" class="img-thumbnail"
                                                alt="{{ asset($datapage->{$frm['name']}) }}">
                                        @elseif ($frm['name'] == 'video')
                                            <video width="320" height="240" controls>
                                                <source src="{{ asset('videos_enquete/' . $datapage->{$frm['name']}) }}"
                                                    type="video/mp4">
                                            </video>
                                        @else
                                            @if (isset($frm['status']))
                                                <td>{{ $datapage->{$frm['name']} == 0 ? 'Desabilitado' : 'Habilitado' }}</td>
                                            @else
                                                {{ Str::limit(ucfirst($datapage->{$frm['name']}), 120) }}
                                            @endif
                                        @endif
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    @endisset
                    @isset($rolePermissions)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Permissões</div>
                                <div class="my-3">
                                    @foreach ($rolePermissions as $v)
                                        <button type="button" class="btn btn-primary mb-2">
                                            {{ $v->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    @endisset
                </ol><!-- End with custom content -->
            </div>
        </div>
    </div><!-- End Card with header and footer -->
@endsection
