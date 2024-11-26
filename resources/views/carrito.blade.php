@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh; padding-top: 50px; padding-bottom: 50px;">
    <div class="col-md-8">
        <div class="card shadow-sm border-0" style="background-color: #f8f9fa;">
            <div class="card-header text-center bg-dark text-white">
                <h4>Carrito de Compras</h4>
            </div>
            <div class="card-body" style="padding: 30px;">
                <!-- Mensajes de éxito -->
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Mensajes de error -->
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Contenido del carrito -->
                @if (empty($carrito))
                    <p class="text-center">No hay elementos en tu carrito.</p>
                @else
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>Título</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carrito as $item)
                                <tr>
                                    <td>{{ $item['Título'] }}</td>
                                    <td>${{ number_format($item['PrecioOferta'], 2) }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('carrito.actualizar', $item['id']) }}" class="d-inline-flex">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" max="{{ $item['max_cantidad'] }}" class="form-control form-control-sm me-2" style="width: 80px;">
                                            <button type="submit" class="btn btn-success btn-sm">Actualizar</button>
                                        </form>
                                    </td>
                                    <td>${{ number_format($item['subtotal'], 2) }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('carrito.eliminar', $item['id']) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-end mt-3">
                        <h5 class="fw-bold">Total: ${{ number_format($total, 2) }}</h5>
                        <a href="{{ route('carrito.pagar') }}" class="btn btn-dark">Pagar</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
