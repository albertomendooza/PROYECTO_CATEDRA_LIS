@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh; padding-top: 50px; padding-bottom: 50px;">
    <div class="col-md-6">
        <div class="card shadow-sm border-0" style="background-color: #f8f9fa; margin-top: 20px; margin-bottom: 20px;">
            <div class="card-header text-center bg-dark text-white">
                <h4>Registrar un Cupón</h4>
            </div>
            <div class="card-body" style="padding: 30px;">
                <!-- Mensajes de éxito o error -->
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Formulario de registro de cupones -->
                <form method="POST" action="{{ route('offers.store') }}" enctype="multipart/form-data">
    @csrf

    <!-- Campo: Título -->
    <div class="form-group mb-4">
        <label for="Título" class="text-dark">Título</label>
        <input type="text" name="Título" id="Título" class="form-control" required>
    </div>

    <!-- Campo: Categoría -->
<div class="form-group mb-4">
    <label for="categoria" class="text-dark">Categoría</label>
    <select name="categoria" id="categoria" class="form-control" required>
        <option value="">Selecciona una categoría</option>
        <option value="Tecnología">Tecnología</option>
        <option value="Restaurantes">Restaurantes</option>
        <option value="Entretenimiento">Entretenimiento</option>
        <option value="Salud y Belleza">Salud y Belleza</option>
        <option value="Viajes">Viajes</option>
        <option value="Ropa y Moda">Ropa y Moda</option>
        <option value="Hogar y Muebles">Hogar y Muebles</option>
    </select>
</div>



    <!-- Campo: Precio Regular -->
    <div class="form-group mb-4">
        <label for="PrecioRegular" class="text-dark">Precio Regular</label>
        <input type="number" name="PrecioRegular" id="PrecioRegular" class="form-control" required>
    </div>

    <!-- Campo: Precio Oferta -->
    <div class="form-group mb-4">
        <label for="PrecioOferta" class="text-dark">Precio Oferta</label>
        <input type="number" name="PrecioOferta" id="PrecioOferta" class="form-control" required>
    </div>

    <!-- Campo: Fecha Inicio -->
    <div class="form-group mb-4">
        <label for="FechaInicio" class="text-dark">Fecha Inicio</label>
        <input type="date" name="FechaInicio" id="FechaInicio" class="form-control" required>
    </div>

    <!-- Campo: Fecha Fin -->
    <div class="form-group mb-4">
        <label for="FechaFin" class="text-dark">Fecha Fin</label>
        <input type="date" name="FechaFin" id="FechaFin" class="form-control" required>
    </div>

    <!-- Campo: Fecha Límite Canje -->
    <div class="form-group mb-4">
        <label for="FechaLimiteCanje" class="text-dark">Fecha Límite Canje</label>
        <input type="date" name="FechaLimiteCanje" id="FechaLimiteCanje" class="form-control" required>
    </div>

    <!-- Campo: Cantidad de Cupones -->
    <div class="form-group mb-4">
        <label for="CantidadCupones" class="text-dark">Cantidad de Cupones</label>
        <input type="number" name="CantidadCupones" id="CantidadCupones" class="form-control" required>
    </div>

    <!-- Campo: Descripción -->
    <div class="form-group mb-4">
        <label for="Descripción" class="text-dark">Descripción</label>
        <textarea name="Descripción" id="Descripción" class="form-control" rows="4" required></textarea>
    </div>

    <!-- Campo: Estado -->
    <div class="form-group mb-4">
        <label for="Estado" class="text-dark">Estado</label>
        <select name="Estado" id="Estado" class="form-control" required>
            <option value="Disponible">Disponible</option>
            <option value="No disponible">No disponible</option>
        </select>
    </div>

    <!-- Campo: Imagen -->
<div class="form-group mb-4">
    <label for="Imagen" class="text-dark">Imagen</label>
    <input type="file" name="Imagen" id="Imagen" class="form-control" accept="image/jpeg, image/png, image/jpg, image/gif">
</div>


    <!-- Botón de enviar -->
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-dark">Registrar</button>
    </div>
</form>

            </div>
        </div>
    </div>
</div>
@endsection
