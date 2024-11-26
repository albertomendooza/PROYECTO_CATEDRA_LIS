@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensaje de bienvenida estilizado -->
            <div class="alert alert-primary text-center shadow-lg p-4 mb-6 rounded">
                <h1 class="display-4 font-weight-bold mb-2">Bienvenido, {{ auth()->user()->name }}</h1>
                <p class="lead">Accede a las herramientas y opciones disponibles en tu panel de administración.</p>
            </div>

            <!-- Recuadro de usuarios pendientes de aprobación -->
            <div class="bg-white shadow-sm sm:rounded-lg p-4 mb-6">
                <h3 class="font-weight-bold text-lg mb-3">Usuarios pendientes de aprobación</h3>

                @if($pendingUsers->isEmpty())
                    <p class="text-muted">No hay usuarios pendientes de aprobación.</p>
                @else
                    <ul class="list-group" id="pending-users-list">
                        @foreach($pendingUsers as $user)
                            @if($user->role === 'empresa') <!-- Filtramos usuarios tipo empresa -->
                                <li class="list-group-item d-flex justify-content-between align-items-center" id="user-{{ $user->id }}">
                                    {{ $user->name }} ({{ $user->email }})
                                    <button class="btn btn-success btn-sm approve-btn" data-id="{{ $user->id }}" data-name="{{ $user->name }}">Aprobar</button>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const approveButtons = document.querySelectorAll('.approve-btn');

            approveButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const userId = this.dataset.id;
                    const userName = this.dataset.name;

                    Swal.fire({
                        title: `¿Estás seguro que quieres aprobar a ${userName}?`,
                        text: "Esta acción no puede deshacerse.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, aprobar",
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Realiza la solicitud AJAX
                            fetch(`/dashboard/approve/${userId}`, {
                                method: 'PATCH',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    Swal.fire(
                                        "¡Aprobado!",
                                        `El usuario ${userName} ha sido aprobado.`,
                                        "success"
                                    );
                                    // Elimina el usuario aprobado del listado
                                    document.getElementById(`user-${userId}`).remove();
                                } else {
                                    Swal.fire(
                                        "Error",
                                        "No se pudo aprobar al usuario. Inténtalo nuevamente.",
                                        "error"
                                    );
                                }
                            })
                            .catch(() => {
                                Swal.fire(
                                    "Error",
                                    "Ocurrió un problema al procesar la solicitud.",
                                    "error"
                                );
                            });
                        }
                    });
                });
            });
        });
    </script>
@endsection
