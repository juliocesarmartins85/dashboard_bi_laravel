@extends('layouts.admin')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3>{{ $titlepage }}s</h3>
                    </div>
                    <div class="col-md-4 ms-auto d-flex justify-content-end">
                        <a class="btn btn-lg btn-primary mx-1" href="{{ route('home') }}"><i
                                class="bi bi-arrow-left"></i></a>
                        @can("$can-criar")
                            <a class="btn btn-lg btn-success" href="{{ route("$route.create") }}"><i
                                    class="bi bi-plus-lg"></i>
                                </i>
                            </a>
                        @endcan
                    </div>

                </div>
            </div>
            <div class="card-body">
                <div class="my-3">
                    <table class="dataTableAdmin table table-hover align-middle dt-responsive">
                        <thead>
                            <tr>
                                <th width="20px">No</th>
                                @foreach ($header_table as $hdr)
                                    <th width="{{ $hdr['width'] }}px">{{ $hdr['title'] }}</th>
                                @endforeach
                                <th width="210px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($datapage)
                                @foreach ($datapage as $key => $dt)
                                    <tr>
                                        <td>{{ $key }}</td>
                                        @foreach ($body_table as $bdy)
                                            @if (isset($bdy['status']))
                                                <td>{{ $dt->{$bdy['value']} == 0 ? 'Desabilitado' : 'Habilitado' }}</td>
                                            @elseif (isset($bdy['img']))
                                                <td><img src="{{ asset($dt->{$bdy['value']}) }}"
                                                        class="img-thumbnail rounded mx-auto d-block" alt="..."></td>
                                            @else
                                                @if (is_array(json_decode($dt->{$bdy['value']})))
                                                    <td>
                                                        @foreach (json_decode($dt->{$bdy['value']}) as $lts)
                                                            <p>{{ App\Models\Perguntas::findOrFail($lts)->question }}</p>
                                                        @endforeach
                                                    </td>
                                                @else
                                                    <td>{!! ucfirst($dt->{$bdy['value']}) !!}</td>
                                                @endif
                                            @endif
                                        @endforeach
                                        @if ($route == 'blacklists')
                                            <td>
                                                <form action="{{ route("$route.store") }}" method="POST"
                                                    class="row g-3 needs-validation" enctype="multipart/form-data" novalidate>
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $dt->id }}">
                                                            <button type="submit" class="btn btn-danger btn-lg" type="button"><i
                                                            class="bi bi-exclamation-triangle fs-3"></i></button>
                                                </form>
                                            </td>
                                        @else
                                            <td>
                                                <form action="{{ route("$route.destroy", $dt->id) }}" method="POST">
                                                    @if ($route == 'routerboard')
                                                        <a class="btn btn-primary btn-lg"
                                                            href="{{ route('router_dash', $dt->id) }}"><i
                                                                class="bi bi-info-lg fs-3"></i></a>
                                                    @else
                                                        <a class="btn btn-primary btn-lg"
                                                            href="{{ route("$route.show", $dt->id) }}"><i
                                                                class="bi bi-info-lg fs-3"></i></a>
                                                    @endif
                                                    @can("$can-editar")
                                                        <a class="btn btn-secondary btn-lg"
                                                            href="{{ route("$route.edit", $dt->id) }}"><i
                                                                class="bi bi-pencil-fill fs-3"></i></a>
                                                    @endcan
                                                    @csrf
                                                    @method('DELETE')
                                                    @can("$can-deletar")
                                                        <button type="submit" class="btn btn-danger btn-lg"><i
                                                                class="bi bi-trash-fill fs-3"></i></button>
                                                    @endcan
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endisset
                            {{-- Dados de usuario --}}
                            @isset($datauser)
                                @foreach ($datauser as $key => $user)
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if (!empty($user->getRoleNames()))
                                                @foreach ($user->getRoleNames() as $v)
                                                    <label class="badge bg-success">{{ $v }}</label>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route("$route.destroy", $user->id) }}" method="POST">
                                                <a class="btn btn-primary btn-lg"
                                                    href="{{ route("$route.show", $user->id) }}"><i
                                                        class="bi bi-info-lg fs-3"></i></a>
                                                @can("$can-editar")
                                                    <a class="btn btn-secondary btn-lg"
                                                        href="{{ route("$route.edit", $user->id) }}"><i
                                                            class="bi bi-pencil-fill fs-3"></i></a>
                                                @endcan
                                                @csrf
                                                @method('DELETE')
                                                @can("$can-deletar")
                                                    <button type="submit" class="btn btn-danger btn-lg"><i
                                                            class="bi bi-trash-fill fs-3"></i></button>
                                                @endcan
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($route == 'blacklist')
            @else
                {{--                 <div class="card-footer">
                    @can("$can-criar")
                        <a class="btn btn-success" href="{{ route("$route.create") }}">Adicionar
                            Novo</i></a>
                    @endcan
                </div> --}}
            @endif
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/datatableapp.js') }}"></script>
@endpush
