<section class="section">
    <!-- Card 1: Pontos de Acesso -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title h5 mb-0 fw-bold">Pontos de Acesso</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="dataTableAdmin table table-hover align-middle dt-responsive w-100">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 50px;">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Host</th>
                                    <th scope="col">Usuário</th>
                                    <th scope="col">Senha</th>
                                    <th scope="col">Porta</th>
                                    <th scope="col">Token</th>
                                    <th scope="col" class="text-end" style="width: 140px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['hotspost'] as $htsp)
                                    <tr>
                                        <td class="fw-semibold text-secondary">{{ $loop->iteration }}</td>
                                        <td class="fw-semibold">{{ $htsp->nome }}</td>
                                        <td><code>{{ $htsp->host }}</code></td>
                                        <td>{{ $htsp->user }}</td>
                                        <td><span class="text-muted">••••••••</span></td>
                                        <td><span class="badge bg-light text-dark border">{{ $htsp->port }}</span>
                                        </td>
                                        <td><code class="small text-truncate d-inline-block"
                                                style="max-width: 120px;">{{ $htsp->token }}</code></td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                                <a class="btn btn-outline-primary"
                                                    href="{{ route('hotspot.show', $htsp->id) }}"
                                                    data-bs-toggle="tooltip" title="Detalhes">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a class="btn btn-outline-secondary"
                                                    href="{{ route('hotspot.edit', $htsp->id) }}"
                                                    data-bs-toggle="tooltip" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('hotspot.destroy', $htsp->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Tem certeza que deseja excluir este Ponto de Acesso?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger rounded-end"
                                                        data-bs-toggle="tooltip" title="Excluir">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Router Board -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title h5 mb-0 fw-bold">Router Board</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="dataTableAdmin table table-hover align-middle dt-responsive w-100">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 50px;">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Host</th>
                                    <th scope="col">Porta</th>
                                    <th scope="col">Usuário</th>
                                    <th scope="col">Senha</th>
                                    <th scope="col" class="text-end" style="width: 100px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['routerboard'] as $htsp)
                                    <tr>
                                        <td class="fw-semibold text-secondary">{{ $loop->iteration }}</td>
                                        <td class="fw-semibold">{{ $htsp->nome }}</td>
                                        <td><code>{{ $htsp->host }}</code></td>
                                        <td><span class="badge bg-light text-dark border">{{ $htsp->port }}</span>
                                        </td>
                                        <td>{{ $htsp->user }}</td>
                                        <td><span class="text-muted">••••••••</span></td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                                <a href="{{ route('routerboard.edit', $htsp->id) }}"
                                                    class="btn btn-outline-secondary" data-bs-toggle="tooltip"
                                                    title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Liberar Acesso Usuário -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title h5 mb-0 fw-bold">Liberar Acesso Usuário</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="dataTableAdmin table table-hover align-middle dt-responsive w-100">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 50px;">#</th>
                                    <th scope="col">MAC Address</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Função</th>
                                    <th scope="col">Permissão</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-end" style="width: 150px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['profileuser'] as $htsp)
                                    <tr>
                                        <td class="fw-semibold text-secondary">{{ $htsp->id }}</td>
                                        <td><code>{{ $htsp->mac_address }}</code></td>
                                        <td class="fw-semibold">{{ $htsp->name }}</td>
                                        <td>{{ $htsp->funcao }}</td>
                                        <td>{{ $htsp->funcaosis }}</td>
                                        <td>
                                            @switch(strtolower($htsp->status))
                                                @case('bypassed')
                                                @case('liberado')

                                                @case('ativo')
                                                    <span
                                                        class="badge bg-success-subtle text-success border border-success-subtle">Liberado</span>
                                                @break

                                                @case('blocked')
                                                @case('bloqueado')
                                                    <span
                                                        class="badge bg-danger-subtle text-danger border border-danger-subtle">Bloqueado</span>
                                                @break

                                                @default
                                                    <span
                                                        class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">{{ $htsp->status }}</span>
                                            @endswitch
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm" role="group"
                                                aria-label="Ações de Liberação">
                                                <a href="{{ route('ipBindingAdd', ['id' => $htsp->id, 'cmd' => 'bypassed']) }}"
                                                    class="btn btn-outline-success" data-bs-toggle="tooltip"
                                                    title="Liberar (Bypass)">
                                                    <i class="bi bi-check-circle"></i>
                                                </a>
                                                <a href="{{ route('ipBindingAdd', ['id' => $htsp->id, 'cmd' => 'blocked']) }}"
                                                    class="btn btn-outline-warning" data-bs-toggle="tooltip"
                                                    title="Bloquear">
                                                    <i class="bi bi-slash-circle"></i>
                                                </a>
                                                <a href="{{ route('ipBindingRemove', $htsp->id) }}"
                                                    class="btn btn-outline-danger" data-bs-toggle="tooltip"
                                                    title="Remover Binding"
                                                    onsubmit="return confirm('Deseja remover este registro?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
