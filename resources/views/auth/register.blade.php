@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-6">
        <div class="card shadow-sm border-0" style="background-color: #f8f9fa;">
            <div class="card-header text-center bg-dark text-white">
                <h4>Registrar Nuevo Usuario</h4>
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

                <!-- Formulario de registro -->
                <form method="POST" action="{{ isset($isAdmin) && $isAdmin ? route('admin.register') : route('register.store') }}">
                    @csrf

                    <!-- Campo de nombre -->
                    <div class="form-group mb-3">
                        <label for="name" class="text-dark">Nombre</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <!-- Campo de correo -->
                    <div class="form-group mb-3">
                        <label for="email" class="text-dark">Correo Electrónico</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
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

                    <!-- Campo de rol -->
                    <div class="form-group mb-3">
                        <label for="role" class="text-dark">Rol</label>
                        <select name="role" id="role" class="form-control" required>
                            @if(isset($isAdmin) && $isAdmin)
                                <option value="admin">Administrador</option>
                                <option value="empresa">Empresa</option>
                                <option value="cliente">Cliente</option>
                            @else
                                <option value="empresa">Empresa</option>
                                <option value="cliente">Cliente</option>
                            @endif
                        </select>
                    </div>

                    <!-- Botón de envío -->
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-dark">Registrar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
