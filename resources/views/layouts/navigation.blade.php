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

        <!-- Opção: Regiões - Acesso para todos -->
        <li class="nav-item">
            <a href="{{ route('regioes.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-map-marked-alt text-white"></i>
                <p>{{ __('Regiões de Juazeiro-BA') }}</p>
            </a>
        </li>

        <!-- Opção: Bairros - Acesso para todos -->
        <li class="nav-item">
            <a href="{{ route('bairros.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-map-marker-alt text-white"></i>
                <p>{{ __('Bairros de Juazeiro-BA') }}</p>
            </a>
        </li>

                    <li class="nav-header text-uppercase text-white">{{ __('Merenda Escolar') }}</li>

            <li class="nav-item">
                <a href="{{ route('cardapios.index') }}" class="nav-link text-white">
                    <i class="nav-icon fas fa-utensils text-white"></i>
                    <p>{{ __('Cardápios') }}</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('alunos.index') }}" class="nav-link text-white">
                    <i class="nav-icon fas fa-school text-white"></i>
                    <p>{{ __('Alunos') }}</p>
                </a>
            </li>

                    <li class="nav-item">
            <a href="{{ route('pedidos.lote.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-clipboard-list text-white"></i>
                <p>{{ __('Pedidos Quinzenais') }}</p> <!-- Ou "Programação de Merenda" -->
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('recebimentos.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-clipboard-list text-white"></i>
                <p>{{ __('Recebimento e Atesto de Qualidade') }}</p> <!-- Ou "Programação de Merenda" -->
            </a>
        </li>
        

        <!-- Opção: Alimentos - Acesso para todos -->
        <li class="nav-item">
            <a href="{{ route('alimentos.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-utensils text-white"></i>
                <p>{{ __('Alimentos') }}</p>
            </a>
        </li>

        <!-- Opção: Orçamento - Acesso para todos -->
        <li class="nav-item">
            <a href="{{ route('orcamentos.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-file-invoice-dollar text-white"></i>
                <p>{{ __('Orçamentos') }}</p>
            </a>
        </li>

        <!-- Opção: Chamadas Públicas -->
        <li class="nav-item">
            <a href="{{ route('chamadas_publicas.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-bullhorn text-white"></i>
                <p>{{ __('Chamadas Públicas') }}</p>
            </a>
        </li>

        <!-- Opção: Cadastro de Documentação -->
        <li class="nav-item">
            <a href="{{ route('validacoes.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-file-alt text-white"></i>
                <p>{{ __('Cadastro de Documentação') }}</p>
            </a>
        </li>

        <!-- Opção: Proposta de Venda -->
        <li class="nav-item">
            <a href="{{ route('propostas.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-handshake text-white"></i>
                <p>{{ __('Proposta de Venda') }}</p>
            </a>
        </li>

        <!-- Opção: Avaliação das Propostas de Venda -->
        <li class="nav-item">
            <a href="{{ route('avaliacoes.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-clipboard-check text-white"></i>
                <p>{{ __('Avaliação das Propostas de Venda') }}</p>
            </a>
        </li>

        <!-- About Us - Acesso para todos -->
        <li class="nav-item">
            <a href="{{ route('about') }}" class="nav-link text-white">
                <i class="nav-icon far fa-address-card text-white"></i>
                <p>{{ __('Sobre Nós') }}</p>
            </a>
        </li>

            @if(auth()->check() && auth()->user()->hasPermissionTo('Menu-Administracao'))
            <li class="nav-item">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('roles.index') }}">Papéis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('Listar-Papeis-Usuarios') }}">Usuários por Papel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('Copy-Permissions-Form') }}">Copiar Permissões</a>
                    </li>
                </ul>
            </li>
            @endif

    </ul>
</nav>
<!-- /.sidebar-menu -->