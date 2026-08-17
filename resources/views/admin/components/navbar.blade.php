<nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center list-unstyled mb-0 gap-2">

        <!-- Ícone da Busca Mobile -->
        <li class="nav-item d-block d-lg-none">
            <a class="nav-link nav-icon search-bar-toggle p-2 text-secondary" href="#" data-bs-toggle="tooltip"
                title="Buscar">
                <i class="bi bi-search fs-5"></i>
            </a>
        </li>

        <!-- Alternar Tema Claro/Escuro -->
        <li class="nav-item">
            <button type="button" id="theme-toggle-btn"
                class="nav-link nav-icon p-2 text-secondary border-0 bg-transparent" data-bs-toggle="tooltip"
                title="Alternar tema">
                <i class="bi bi-moon-stars fs-5" id="theme-toggle-icon"></i>
            </button>
        </li>

        <!-- Dropdown de Perfil -->
        <li class="nav-item dropdown pe-2">
            <a class="nav-link nav-profile d-flex align-items-center gap-2 p-1 rounded-pill hover-bg-light"
                href="#" data-bs-toggle="dropdown" aria-expanded="false">
                @php
                    $avatar = !empty(Auth::user()->foto)
                        ? asset('fotosperfil/' . Auth::user()->foto)
                        : asset('assets/img/avatar.jpeg');
                @endphp

                <img src="{{ $avatar }}" alt="Foto de Perfil" class="rounded-circle object-fit-cover"
                    style="width: 36px; height: 36px;">
                <span
                    class="d-none d-md-block dropdown-toggle fw-semibold text-dark pe-1">{{ Auth::user()->name }}</span>
            </a>

            <!-- Menu Suspenso -->
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2 py-2" style="min-width: 220px;">
                <!-- Cabeçalho do Perfil -->
                <li class="px-3 py-2 border-bottom mb-2 bg-light-subtle">
                    <h6 class="mb-0 fw-bold text-dark">{{ Auth::user()->name }}</h6>
                    <small class="text-muted d-block">{{ Auth::user()->funcao ?? 'Usuário' }}</small>
                </li>

                <!-- Item: Perfil -->
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('config_user') }}">
                        <i class="bi bi-person fs-5 text-primary"></i>
                        <span>Meu Perfil</span>
                    </a>
                </li>

                <li>
                    <hr class="dropdown-divider my-1">
                </li>

                <!-- Item: Sair -->
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger"
                        href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right fs-5"></i>
                        <span>Sair</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<script>
    (function () {
        var toggleBtn = document.getElementById('theme-toggle-btn');
        var icon = document.getElementById('theme-toggle-icon');

        function applyIcon(theme) {
            icon.classList.toggle('bi-moon-stars', theme !== 'dark');
            icon.classList.toggle('bi-sun', theme === 'dark');
        }

        // O atributo já foi definido o mais cedo possível (ver <head> do
        // layout), aqui só sincronizamos o ícone com o estado atual.
        applyIcon(document.documentElement.getAttribute('data-bs-theme') || 'light');

        toggleBtn.addEventListener('click', function () {
            var next = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-bs-theme', next);
            localStorage.setItem('theme', next);
            applyIcon(next);
        });
    })();
</script>
