<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">La Cuponera SV</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Ofertas</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrar</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('coupons.create') }}">Cupones</a></li>
            </ul>
        </div>
    </div>
</nav>

