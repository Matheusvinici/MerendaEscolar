<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <!-- Painel Inicial - Acesso para todos -->
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-tachometer-alt text-white"></i>
                <p>{{ __('Painel Inicial') }}</p>
            </a>
        </li>

        <!-- Opção: Servidores - Acesso para todos -->
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-users text-white"></i>
                <p>{{ __('Servidores') }}</p>
            </a>
        </li>

        <!-- Opção: Escolas - Acesso para todos -->
        <li class="nav-item">
            <a href="{{ route('escolas.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-book text-white"></i>
                <p>{{ __('Escolas') }}</p>
            </a>
        </li>

        <!-- Opção: Alimentos - Acesso para todos -->
        <li class="nav-item">
            <a href="{{ route('alimentos.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-caret-square-right text-white"></i>
                <p>{{ __('Alimentos') }}</p>
            </a>
        </li>

        <!-- Opção: Orçamento - Acesso para todos -->
        <li class="nav-item">
            <a href="{{ route('orcamentos.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-book text-white"></i>
                <p>{{ __('Orçamento') }}</p>
            </a>
        </li>

        <!-- About Us - Acesso para todos -->
        <li class="nav-item">
            <a href="{{ route('about') }}" class="nav-link text-white">
                <i class="nav-icon far fa-address-card text-white"></i>
                <p>{{ __('Sobre Nós') }}</p>
            </a>
        </li>

    </ul>
</nav>
<!-- /.sidebar-menu -->
