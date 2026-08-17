@extends('layouts.admin')
@section('content')
    <!-- Card da Listagem -->
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <!-- Cabeçalho com ações principais -->
            <div class="card-header bg-white py-3 border-bottom">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="card-title h4 mb-0 fw-bold">{{ $titlepage }}s</h3>
                    </div>
                    <div class="col-auto d-flex gap-2">
                        <a class="btn btn-outline-secondary d-inline-flex align-items-center gap-1" href="{{ route('home') }}"
                            data-bs-toggle="tooltip" title="Voltar ao início">
                            <i class="bi bi-arrow-left"></i>
                            <span class="d-none d-sm-inline">Voltar</span>
                        </a>
                        @can("$can-criar")
                            <a class="btn btn-primary d-inline-flex align-items-center gap-1"
                                href="{{ route("$route.create") }}" data-bs-toggle="tooltip" title="Cadastrar novo">
                                <i class="bi bi-plus-lg"></i>
                                <span class="d-none d-sm-inline">Novo</span>
                            </a>
                        @endcan
                        </div>
                    </div>
                </div>

                <!-- Corpo da Tabela -->
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="dataTableAdmin table table-hover align-middle dt-responsive w-100">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 50px;">#</th>
                                    @foreach ($header_table as $hdr)
                                        <th scope="col" @if (!empty($hdr['width'])) style="width: {{ $hdr['width'] }}px;" @endif>{{ $hdr['title'] }}</th>
                                    @endforeach
                                    <th scope="col" class="text-end" style="width: 140px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Dados Genéricos --}}
                                @isset($datapage)
                                    @foreach ($datapage as $key => $dt)
                                        <tr>
                                            <td class="fw-semibold text-secondary">{{ $loop->iteration }}</td>

                                            @foreach ($body_table as $bdy)
                                                @if (isset($bdy['status']))
                                                    <td>
                                                        @if ($dt->{$bdy['value']} == 0)
                                                            <span
                                                                class="badge bg-danger-subtle text-danger border border-danger-subtle">Desabilitado</span>
                                                        @else
                                                            <span
                                                                class="badge bg-success-subtle text-success border border-success-subtle">Habilitado</span>
                                                        @endif
                                                    </td>
                                                @elseif (isset($bdy['img']))
                                                    <td>
                                                        <img src="{{ asset($dt->{$bdy['value']}) }}" class="img-thumbnail rounded"
                                                            style="max-height: 50px; object-fit: cover;" alt="Imagem">
                                                    </td>
                                                @else
                                                    @php
                                                        $decodedJson = json_decode($dt->{$bdy['value']} ?? '');
                                                    @endphp

                                                    @if (is_array($decodedJson))
                                                        <td>
                                                            <ul class="list-unstyled mb-0 small">
                                                                @foreach ($decodedJson as $lts)
                                                                    <li><i
                                                                            class="bi bi-chevron-right me-1 text-muted"></i>{{ App\Models\Perguntas::findOrFail($lts)->question }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                    @else
                                                        <td>{!! ucfirst($dt->{$bdy['value']}) !!}</td>
                                                    @endif
                                                @endif
                                            @endforeach

                                            <!-- Ações da Linha -->
                                            <td class="text-end">
                                                <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                                    <a class="btn btn-outline-primary" href="{{ route("$route.show", $dt->id) }}"
                                                        data-bs-toggle="tooltip" title="Detalhes">
                                                        <i class="bi bi-eye"></i>
                                                    </a>

                                                    @can("$can-editar")
                                                        <a class="btn btn-outline-secondary" href="{{ route("$route.edit", $dt->id) }}"
                                                            data-bs-toggle="tooltip" title="Editar">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                    @endcan

                                                    @can("$can-deletar")
                                                        {{-- O <form> não pode ser filho do .btn-group: o CSS de
                                                             agrupamento do Bootstrap (bordas/largura) só se aplica a
                                                             .btn filhos diretos, então o form quebrava o alinhamento
                                                             do 3º botão. O button referencia o form pelo atributo
                                                             HTML5 form="", ficando como filho direto do grupo. --}}
                                                        <button type="submit" form="delete-{{ $route }}-{{ $dt->id }}"
                                                            class="btn btn-outline-danger" data-bs-toggle="tooltip" title="Excluir">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    @endcan
                                                </div>
                                                @can("$can-deletar")
                                                    <form id="delete-{{ $route }}-{{ $dt->id }}"
                                                        action="{{ route("$route.destroy", $dt->id) }}" method="POST" class="d-none"
                                                        onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset

                                {{-- Dados de Usuário --}}
                                @isset($datauser)
                                    @foreach ($datauser as $key => $user)
                                        <tr>
                                            <td class="fw-semibold text-secondary">{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if (!empty($user->getRoleNames()))
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @foreach ($user->getRoleNames() as $v)
                                                            <span
                                                                class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ $v }}</span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                                    <a class="btn btn-outline-primary" href="{{ route("$route.show", $user->id) }}"
                                                        data-bs-toggle="tooltip" title="Detalhes">
                                                        <i class="bi bi-eye"></i>
                                                    </a>

                                                    @can("$can-editar")
                                                        <a class="btn btn-outline-secondary"
                                                            href="{{ route("$route.edit", $user->id) }}" data-bs-toggle="tooltip"
                                                            title="Editar">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                    @endcan

                                                    @can("$can-deletar")
                                                        <button type="submit" form="delete-{{ $route }}-{{ $user->id }}"
                                                            class="btn btn-outline-danger" data-bs-toggle="tooltip" title="Excluir">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    @endcan
                                                </div>
                                                @can("$can-deletar")
                                                    <form id="delete-{{ $route }}-{{ $user->id }}"
                                                        action="{{ route("$route.destroy", $user->id) }}" method="POST" class="d-none"
                                                        onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('scripts')
        <script src="{{ asset('assets/js/datatableapp.js') }}"></script>
    @endpush
