<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pontos de Acesso</h5>
                    <!-- Default Table -->
                    <table class="dataenquete table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-capitalize" scope="col">#</th>
                                <th class="text-capitalize" scope="col">nome</th>
                                <th class="text-capitalize" scope="col">host</th>
                                <th class="text-capitalize" scope="col">user</th>
                                <th class="text-capitalize" scope="col">pass</th>
                                <th class="text-capitalize" scope="col">port</th>
                                <th class="text-capitalize" scope="col">token</th>
                                <th class="text-capitalize" scope="col" width="200px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['hotspost'] as $htsp)
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{ $htsp->nome }}</td>
                                    <td>{{ $htsp->host }}</td>
                                    <td>{{ $htsp->user }}</td>
                                    <td>{{ $htsp->pass }}</td>
                                    <td>{{ $htsp->port }}</td>
                                    <td>{{ $htsp->token }}</td>
                                    <td>
                                        <form action="{{ route('hotspot.destroy', $htsp->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('hotspot.show', $htsp->id) }}"><i
                                                    class="bi bi-info-lg fs-3"></i></a>
                                            {{-- @can("$can-editar") --}}
                                            <a class="btn btn-secondary"
                                                href="{{ route('hotspot.edit', $htsp->id) }}"><i
                                                    class="bi bi-pencil-fill fs-3"></i></a>
                                            {{-- @endcan --}}
                                            @csrf
                                            @method('DELETE')
                                            {{-- @can("$can-deletar") --}}
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="bi bi-trash-fill fs-3"></i></button>
                                            {{-- @endcan --}}
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Default Table Example -->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Router Board</h5>
                    <!-- Default Table -->
                    <table class="dataenquete table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-capitalize" scope="col">#</th>
                                <th class="text-capitalize" scope="col">nome</th>
                                <th class="text-capitalize" scope="col">host</th>
                                <th class="text-capitalize" scope="col">porta</th>
                                <th class="text-capitalize" scope="col">usuario</th>
                                <th class="text-capitalize" scope="col">senha</th>
                                <th class="text-capitalize" scope="col" width="200px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['routerboard'] as $htsp)
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{ $htsp->nome }}</td>
                                    <td>{{ $htsp->host }}</td>
                                    <td>{{ $htsp->port }}</td>
                                    <td>{{ $htsp->user }}</td>
                                    <td>{{ $htsp->pass }}</td>
                                    <td>
                                        {{-- <a href="#" type="button" class="btn btn-primary"><i
                                                class="bi bi-list-stars fs-2"></i></a> --}}
                                        <a href="{{ route("routerboard.edit", $htsp->id) }}" type="button" class="btn btn-secondary"><i
                                                class="bi bi-pencil-fill fs-2"></i></a>
                                        {{-- <a href="#" type="button" class="btn btn-danger"><i
                                                class="bi bi-trash3 fs-2"></i></a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Default Table Example -->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Liberar Acesso Usuário</h5>
                    <!-- Default Table -->
                    <table class="dataenquete table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-capitalize" scope="col">#</th>
                                <th class="text-capitalize" scope="col">Mac Address</th>
                                <th class="text-capitalize" scope="col">Nome</th>
                                <th class="text-capitalize" scope="col">Função</th>
                                <th class="text-capitalize" scope="col">Permissão</th>
                                <th class="text-capitalize" scope="col">Status</th>
                                <th class="text-capitalize" scope="col" width="200px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['profileuser'] as $htsp)
                                <tr>
                                    <th scope="row">{{ $htsp->id }}</th>
                                    <td>{{ $htsp->mac_address }}</td>
                                    <td>{{ $htsp->name }}</td>
                                    <td>{{ $htsp->funcao }}</td>
                                    <td>{{ $htsp->funcaosis }}</td>
                                    <td>{{ $htsp->status }}</td>
                                    <td>
                                        <a href="{{  route('ipBindingAdd', ['id' => $htsp->id,'cmd' => 'bypassed'])  }}" type="button" class="btn btn-success"><i
                                                class="bi bi-check-circle-fill fs-2"></i></a>
                                        <a href="{{ route('ipBindingRemove',$htsp->id) }}" type="button" class="btn btn-danger"><i
                                                class="bi bi-trash3 fs-2"></i></a>
                                        <a href="{{  route('ipBindingAdd', ['id' => $htsp->id,'cmd' => 'blocked'])  }}" type="button" class="btn btn-danger"><i
                                                class="bi bi-x-circle-fill fs-2"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Default Table Example -->
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
    <script src="{{ asset('assets/js/datatableapp.js') }}"></script>
@endpush
