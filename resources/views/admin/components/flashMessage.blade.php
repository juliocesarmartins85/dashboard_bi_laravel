@php
    $alerts = [
        'success' => ['type' => 'success', 'icon' => 'bi-check-circle-fill'],
        'error' => ['type' => 'danger', 'icon' => 'bi-exclamation-octagon-fill'],
        'warning' => ['type' => 'warning', 'icon' => 'bi-exclamation-triangle-fill'],
        'info' => ['type' => 'info', 'icon' => 'bi-info-circle-fill'],
    ];
@endphp

{{-- Alertas de Sessão --}}
@foreach ($alerts as $key => $alert)
    @if ($message = Session::get($key))
        <div class="alert alert-{{ $alert['type'] }} alert-dismissible fade show d-flex align-items-center shadow-sm"
            role="alert">
            <i class="bi {{ $alert['icon'] }} me-2 fs-5 flex-shrink-0"></i>
            <div>
                <strong>{{ $message }}</strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    @endif
@endforeach

{{-- Alertas de Erros de Validação --}}
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
        <i class="bi bi-exclamation-octagon-fill me-2 fs-5 flex-shrink-0"></i>
        <div>
            <strong>Verifique se há erros no formulário abaixo:</strong>
            <ul class="mb-0 mt-1 ps-3 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
@endif
