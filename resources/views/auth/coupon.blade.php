@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-6">
        <div class="card shadow-sm border-0" style="background-color: #f8f9fa;">
            <div class="card-header text-center bg-dark text-white">
                <h4>Registro de Cupón</h4>
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

                <!-- Formulario de Registro de Cupón -->
                <form method="POST" action="{{ route('coupons.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Campo de nombre del cupón -->
                    <div class="form-group mb-3">
                        <label for="name" class="text-dark">Nombre del Cupón</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required autofocus>
                    </div>

                    <!-- Campo de precio -->
                    <div class="form-group mb-3">
                        <label for="price" class="text-dark">Precio</label>
                        <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" required min="0" step="0.01">
                    </div>

                    <!-- Campo de descripción -->
                    <div class="form-group mb-3">
                        <label for="description" class="text-dark">Descripción</label>
                        <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
                    </div>

                    <!-- Campo de categoría (lista desplegable) -->
                    <div class="form-group mb-3">
                        <label for="category" class="text-dark">Categoría</label>
                        <select name="category" id="category" class="form-control" required>
                            <option value="entretenimiento">Entretenimiento</option>
                            <option value="restaurantes">Restaurantes</option>
                            <option value="tecnologia">Tecnología</option>
                        </select>
                    </div>

                    <!-- Campo de imagen -->
                    <div class="form-group mb-3">
                        <label for="image" class="text-dark">Imagen del Cupón</label>
                        <input type="file" name="image" id="image" class="form-control-file" accept="image/*" required>
                    </div>

                    <!-- Botón de registro -->
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-dark">Registrar Cupón</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
