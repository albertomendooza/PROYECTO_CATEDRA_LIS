@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensaje de bienvenida estilizado -->
            <div class="alert alert-primary text-center shadow-lg p-4 mb-6 rounded">
                <h1 class="display-4 font-weight-bold mb-2">Bienvenido, {{ auth()->user()->name }}</h1>
                <p class="lead">Accede a las herramientas y opciones disponibles en tu panel de administración.</p>
            </div>

            <!-- Contenido principal del dashboard -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Mensaje de prueba -->
                    <h1 class="text-3xl font-bold text-center text-danger mb-6">
                        Hola, soy el dashboard, y estoy funcionando.
                    </h1>

                    <!-- Opciones adicionales solo para administradores -->
                    @if(auth()->user()->role === 'admin')
                        <h3 class="font-weight-bold text-lg mt-4">Opciones del Administrador:</h3>
                        <ul class="list-unstyled ml-3 mt-2">
                            <li>
                                <a href="{{ route('dashboard.approvals') }}" class="text-primary">
                                    Ver Aprobaciones Pendientes
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.register') }}" class="text-primary">
                                    Registrar Nuevo Usuario
                                </a>
                            </li>
                        </ul>
                    @else
                        <p class="text-muted">No tienes permisos de administrador. Explora las opciones disponibles.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
