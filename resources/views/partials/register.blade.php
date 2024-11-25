@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Registrar Nuevo Usuario</h2>
    <form method="POST" action="{{ route('admin.register') }}">
        @csrf

        <!-- Campo de nombre -->
        <div class="form-group mb-3">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <!-- Campo de correo -->
        <div class="form-group mb-3">
            <label for="email">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <!-- Campo de contraseña -->
        <div class="form-group mb-3">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <!-- Campo de confirmar contraseña -->
        <div class="form-group mb-3">
            <label for="password_confirmation">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>

        <!-- Campo de rol -->
        <div class="form-group mb-3">
            <label for="role">Rol</label>
            <select name="role" id="role" class="form-control" required>
                <option value="empresa">Empresa</option>
                <option value="cliente">Cliente</option>
            </select>
        </div>

        <!-- Botón de envío -->
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary">Crear Usuario</button>
        </div>
    </form>
</div>
@endsection
