@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-6">
        <div class="card shadow-sm border-0" style="background-color: #f8f9fa;">
            <div class="card-header text-center bg-dark text-white">
                <h4>Iniciar Sesión</h4>
            </div>
            <div class="card-body">
                <!-- Mensajes de sesión -->
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Mensajes de validación -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="form-group mb-3">
                        <label for="email" class="text-dark">Correo Electrónico</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    </div>

                    <!-- Contraseña -->
                    <div class="form-group mb-3">
                        <label for="password" class="text-dark">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <!-- Recordarme -->
                    <div class="form-check mb-3">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                        <label class="form-check-label text-dark" for="remember">Recordarme</label>
                    </div>

                    <div class="d-flex justify-content-between">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-decoration-none text-secondary">¿Olvidaste tu contraseña?</a>
                        @endif
                        <button type="submit" class="btn btn-dark">Iniciar Sesión</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
