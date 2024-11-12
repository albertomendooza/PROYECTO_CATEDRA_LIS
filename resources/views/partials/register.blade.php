@extends('partials.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-6">
        <div class="card shadow-sm border-0" style="background-color: #f8f9fa;">
            <div class="card-header text-center bg-dark text-white">
                <h4>Registro de Usuario</h4>
            </div>
            <div class="card-body">
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

                <!-- Formulario de Registro -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Campo de nombre -->
                    <div class="form-group mb-3">
                        <label for="name" class="text-dark">Nombre</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required autofocus>
                    </div>

                    <!-- Campo de contraseña -->
                    <div class="form-group mb-3">
                        <label for="password" class="text-dark">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <!-- Campo de confirmar contraseña -->
                    <div class="form-group mb-3">
                        <label for="password_confirmation" class="text-dark">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>

                    <!-- Campo de rol (lista desplegable) -->
                    <div class="form-group mb-3">
                        <label for="role" class="text-dark">Rol</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="admin">Administrador</option>
                            <option value="user">Cliente</option>
                            <option value="guest">Empresa</option>
                        </select>
                    </div>

                    <!-- Campo de is_active (oculto y por defecto 1) -->
                    <input type="hidden" name="is_active" value="1">

                    <!-- Botón de registro -->
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-dark">Registrarse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
