<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        @foreach ($sidebaradmin as $side)
            @if ($side->nvl == 1)
                @if ($side->drop)
                    <li class="nav-item">
                        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse"
                            href="#">
                            <i class="bi bi-menu-button-wide"></i><span>{{ $side->nome }}</span><i
                                class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                            @foreach ($sidebaradmin as $sidenvl2)
                                @if ($sidenvl2->nvl == 2)
                                    @if ($sidenvl2->drop)
                                    @else
                                        <li>
                                            <a href="{{ $sidenvl2->url }}">
                                                <i class="{{ $sidenvl2->icon }} fs-3"></i><span>{{ $sidenvl2->nome }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    </li><!-- End Components Nav -->
                @else
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ $side->url }}">
                            <i class="{{ $side->icon }} fs-3"></i>
                            <span>{{ $side->nome }}</span>
                        </a>
                    </li>
                @endif
            @endif
        @endforeach
    </ul>
</aside><!-- End Sidebar-->
