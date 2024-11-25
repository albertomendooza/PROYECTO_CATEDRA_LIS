<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">La Cuponera SV</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Enlace visible para todos los usuarios (registrados o no) -->
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Inicio</a></li>
                
                <!-- Enlaces visibles solo para usuarios no autenticados -->
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrar</a></li>
                @endguest

                <!-- Enlaces visibles solo para usuarios autenticados -->
                @auth
                    <!-- Opciones para administradores -->
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.register') }}">Registrar Usuarios</a></li>
                    @endif

                    <!-- Opciones para empresas -->
                    @if(auth()->user()->role === 'empresa')
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registro de Cupones</a></li>
                    @endif

                    <!-- Opciones para clientes -->
                    @if(auth()->user()->role === 'cliente')
                        <li class="nav-item"><a class="nav-link" href="#">Carrito</a></li> <!-- Actualiza con la ruta correcta cuando esté disponible -->
                    @endif

                    <!-- Enlace para cerrar sesión (visible para todos los roles autenticados) -->
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
