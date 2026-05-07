@extends('layouts.admin')

@section('content')
    <div class="card shadow-sm border-0 my-4">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold text-primary">
                <i class="bi bi-arrow-left-right me-2"></i>Vincular Veículo à Rota
            </h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('stops.updateVehicle') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- Seleção de Rota -->
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="route_id" id="route_id" class="form-select" required>
                                <option value="" selected disabled>Selecione uma rota...</option>
                                @foreach ($routes as $route)
                                    <option value="{{ $route->id }}">{{ $route->short_name }}</option>
                                @endforeach
                            </select>
                            <label for="route_id">Rota</label>
                        </div>
                    </div>

                    <!-- Seleção de Veículo -->
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="vehicle_id" id="vehicle_id" class="form-select" required>
                                <option value="" selected disabled>Selecione um veículo...</option>
                                @foreach ($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">
                                        {{ $vehicle->plate }} — {{ $vehicle->model }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="vehicle_id">Veículo</label>
                        </div>
                    </div>

                    <!-- Botão de Submissão -->
                    <div class="col-12 text-end mt-4">
                        <hr class="text-muted opacity-25">
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="bi bi-link-45deg me-1"></i> Vincular Agora
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card my-3">
        <div class="card-body">
            <div class="container-fluid my-5">
                <h2 class="mb-4">Frota de Veículos</h2>
                <div class="table-responsive">
                    <table class="dataTableAdmin table table-hover align-middle dt-responsive" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th># ID</th>
                                <th>Placa</th>
                                <th>Modelo</th>
                                <th>Rota</th>
                                <th>Capacidade</th>
                                <th>Acessibilidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vehicles as $v)
                                <tr>
                                    <td>{{ $v->id }}</td>
                                    <td><strong>{{ $v->plate }}</strong></td>
                                    <td>{{ $v->model }}</td>
                                    <td>{{ $v->route_id != null ? App\Models\Route::findOrFail($v->route_id)->short_name : 'Não atribuída' }}
                                    </td>
                                    <td>{{ $v->capacity }} passageiros</td>
                                    <td>
                                        <i
                                            class="bi bi-{{ $v->has_accessibility ? 'person-wheelchair text-primary' : 'slash-circle text-muted' }}"></i>
                                        {{ $v->has_accessibility ? 'Sim' : 'Não' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card my-3">
        <div class="card-body">
            <div class="container-fluid my-5">
                <h2 class="mb-4">Linhas Disponíveis</h2>
                <div class="table-responsive">
                    <table class="dataTableAdmin table table-hover align-middle dt-responsive" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>Código</th>
                                <th>Nome da Linha / Destino</th>
                                <th>Tipo</th>
                                <th>Cor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($routes as $v)
                                <tr>
                                    <td><span class="badge bg-secondary">{{ $v->short_name }}</span></td>
                                    <td>{{ $v->long_name }}</td>
                                    <td><i class="bi bi-bus-front"></i> {{ ucfirst($v->type) }}</td>
                                    <td>
                                        <div
                                            style="width: 30px; height: 15px; background-color: {{ $v->color }}; border-radius: 4px; border: 1px solid #ddd;">
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
    <div class="card my-3">
        <div class="card-body">
            <div class="container-fluid my-5">
                <h2 class="mb-4">Monitoramento de Pontos de Parada - São Lourenço</h2>
                <div class="table-responsive">
                    <table class="dataTableAdmin table table-hover align-middle dt-responsive" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>Linha</th>
                                <th>Localização</th>
                                <th>Status</th>
                                <th>Mapa (GPS)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stops as $v)
                                {{-- Ajustado para usar $datapage conforme seu Controller --}}
                                <tr>
                                    <td>
                                        <strong>{{ $v->linha }}</strong><br>
                                        <small class="text-muted">{{ $v->itinerario }}</small>
                                    </td>
                                    <td>{{ $v->localizacao }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match ($v->status) {
                                                'Executado' => 'bg-success',
                                                'Remanejar' => 'bg-warning text-dark',
                                                default => 'bg-danger',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $v->status }}</span>
                                    </td>
                                    <td>
                                        @if ($v->latitude && $v->longitude)
                                            <a href="https://www.google.com/maps?q={{ $v->latitude }},{{ $v->longitude }}"
                                                target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-geo-alt"></i> Ver no Mapa
                                            </a>
                                        @else
                                            <span class="text-muted small italic">Sem coordenadas</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card my-3">
        <div class="card-body">
            <div class="container-fluid my-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Mapeamento de Ruas (São Lourenço - MG)</h2>
                    <a href="{{ route('streets.create') }}" class="btn btn-primary btn-sm">Nova Rua</a>
                </div>

                <div class="table-responsive">
                    <table class="dataTableAdmin table table-hover align-middle dt-responsive" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>Rua</th>
                                <th>Bairro</th>
                                <th>Coordenadas</th>
                                <th>Mapa</th>
                                <th>Cadastro</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($streets as $v)
                                <tr>
                                    <td class="fw-bold">{{ $v->name }}</td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $v->neighborhood->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($v->latitude && $v->longitude)
                                            <small class="text-muted">
                                                {{ number_format($v->latitude, 5) }},
                                                {{ number_format($v->longitude, 5) }}
                                            </small>
                                        @else
                                            <span class="text-danger small">Não geocodificada</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($v->latitude && $v->longitude)
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ $v->latitude }},{{ $v->longitude }}"
                                                target="_blank" class="btn btn-sm btn-outline-secondary"
                                                title="Ver no Google Maps">
                                                <i class="bi bi-geo-alt-fill text-danger"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $v->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
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
