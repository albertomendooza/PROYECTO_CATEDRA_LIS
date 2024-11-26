<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">La Cuponera SV</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Enlace visible para todos los usuarios -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                </li>

                <!-- Opciones para usuarios no autenticados -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Registrar</a>
                    </li>
                @endguest

                <!-- Opciones para usuarios autenticados -->
                @auth
                    <!-- Opciones para Administradores -->
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.register') }}">Registrar Usuarios</a>
                        </li>
                    @endif

                    <!-- Opciones para Empresas -->
                    @if(auth()->user()->role === 'empresa')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('offers.create') }}">Gestión de Cupones</a>
                        </li>
                    @endif

                    <!-- Opciones para Clientes -->
                    @if(auth()->user()->role === 'cliente')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('carrito.index') }}">Carrito</a>
                        </li>
                    @endif

                    <!-- Enlace para cerrar sesión -->
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-info" style="text-decoration: none;">
                                Cerrar Sesión
                            </button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
