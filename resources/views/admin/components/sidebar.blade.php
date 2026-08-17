<!-- Sidebar Navigation -->
<aside id="sidebar" class="sidebar bg-white border-end shadow-sm" style="min-height: 100vh;">
    <ul class="sidebar-nav list-unstyled p-2 m-0" id="sidebar-nav">
        @foreach ($sidebaradmin as $side)
            @if ($side->nvl == 1)
                @if ($side->drop)
                    @php
                        // ID único para cada submenu dinâmico
                        $targetId = 'menu-dropdown-' . $side->id;

                        // Verifica se algum filho está ativo no momento para manter aberto
                        $hasActiveChild = $sidebaradmin->where('nvl', 2)->contains(function ($child) {
                            return request()->is(ltrim($child->url, '/'));
                        });
                    @endphp

                    <li class="nav-item mb-1">
                        <a class="nav-link {{ $hasActiveChild ? '' : 'collapsed' }} d-flex align-items-center gap-2 py-2 px-3 rounded text-decoration-none"
                            data-bs-target="#{{ $targetId }}" data-bs-toggle="collapse" href="#"
                            aria-expanded="{{ $hasActiveChild ? 'true' : 'false' }}">
                            <i class="{{ $side->icon ?? 'bi bi-grid' }} fs-5"></i>
                            <span class="fw-semibold">{{ $side->nome }}</span>
                            <i class="bi bi-chevron-down ms-auto fs-6"></i>
                        </a>

                        <ul id="{{ $targetId }}"
                            class="nav-content collapse {{ $hasActiveChild ? 'show' : '' }} list-unstyled ps-4 pe-2 py-1"
                            data-bs-parent="#sidebar-nav">
                            @foreach ($sidebaradmin as $sidenvl2)
                                @if ($sidenvl2->nvl == 2 && !$sidenvl2->drop)
                                    @php
                                        $isChildActive = request()->is(ltrim($sidenvl2->url, '/'));
                                    @endphp
                                    <li class="my-1">
                                        <a href="{{ $sidenvl2->url }}"
                                            class="d-flex align-items-center gap-2 py-1 px-2 rounded text-decoration-none {{ $isChildActive ? 'active fw-bold text-primary bg-primary-subtle' : 'text-secondary hover-bg-light' }}">
                                            <i class="{{ $sidenvl2->icon ?? 'bi bi-circle' }} fs-6"></i>
                                            <span>{{ $sidenvl2->nome }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @else
                    @php
                        $isActive = request()->is(ltrim($side->url, '/'));
                    @endphp
                    <li class="nav-item mb-1">
                        <a class="nav-link {{ $isActive ? 'active bg-primary text-white' : 'collapsed text-dark' }} d-flex align-items-center gap-2 py-2 px-3 rounded text-decoration-none"
                            href="{{ $side->url }}">
                            <i class="{{ $side->icon ?? 'bi bi-grid' }} fs-5"></i>
                            <span class="fw-semibold">{{ $side->nome }}</span>
                        </a>
                    </li>
                @endif
            @endif
        @endforeach
    </ul>
</aside>
