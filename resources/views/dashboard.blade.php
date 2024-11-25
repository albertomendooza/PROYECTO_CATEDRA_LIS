<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Mensaje de bienvenida -->
                    <p class="text-lg font-semibold mb-4">¡Bienvenido, {{ auth()->user()->name }}!</p>

                    <!-- Mensajes flash -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                            {{ session('warning') }}
                        </div>
                    @endif

                    <!-- Opciones adicionales solo para administradores -->
                    @if(auth()->user()->role === 'admin')
                        <h3 class="font-semibold text-lg text-gray-800 mt-4">Opciones del Administrador:</h3>
                        <ul class="list-disc ml-6 mt-2">
                            <li>
                                <a href="{{ route('dashboard.approvals') }}" class="text-blue-600 hover:underline">
                                    Ver Aprobaciones Pendientes
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.register') }}" class="text-blue-600 hover:underline">
                                    Registrar Nuevo Usuario
                                </a>
                            </li>
                        </ul>
                    @else
                        <p class="text-gray-600">No tienes permisos de administrador. Explora las opciones disponibles.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
