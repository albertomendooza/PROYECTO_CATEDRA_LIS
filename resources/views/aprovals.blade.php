@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Aprobaciones Pendientes</h2>

    <!-- Mostrar un mensaje si no hay usuarios pendientes -->
    @if($pendingUsers->isEmpty())
        <div class="alert alert-info text-center">
            No hay usuarios pendientes de aprobación.
        </div>
    @else
        <!-- Tabla para mostrar usuarios pendientes -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingUsers as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>
                                <!-- Botón para aprobar usuario -->
                                <form method="POST" action="{{ route('dashboard.approve', $user->id) }}" style="display: inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">Aprobar</button>
                                </form>

                                <!-- Botón para rechazar usuario -->
                                <form method="POST" action="{{ route('dashboard.reject', $user->id) }}" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Rechazar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
