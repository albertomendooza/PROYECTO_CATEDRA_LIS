@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Bienvenido a La Cuponera SV
    </h2>
@endsection

@section('content')
<div class="container py-5">
    <!-- Filtros -->
    <div class="row mb-4">
        <div class="col-lg-9">
            <!-- Filtro por nombre o descripción -->
            <form method="GET" action="{{ route('home') }}">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Campo de búsqueda -->
                    <div class="form-group d-flex flex-grow-1">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o descripción" value="{{ request()->query('search') }}">
                    </div>
                    
                    <!-- Botón de búsqueda -->
                    <div class="form-group ms-2">
                        <button type="submit" class="btn btn-dark">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Filtro de categorías como botones -->
    <div class="row mb-4">
        <div class="col-lg-9">
            <div class="btn-group" role="group" aria-label="Categorias">
                <a href="{{ route('home', ['categoria' => 'Tecnología']) }}" class="btn btn-outline-secondary {{ request()->query('categoria') == 'Tecnología' ? 'active' : '' }}">Tecnología</a>
                <a href="{{ route('home', ['categoria' => 'Restaurantes']) }}" class="btn btn-outline-secondary {{ request()->query('categoria') == 'Restaurantes' ? 'active' : '' }}">Restaurantes</a>
                <a href="{{ route('home', ['categoria' => 'Entretenimiento']) }}" class="btn btn-outline-secondary {{ request()->query('categoria') == 'Entretenimiento' ? 'active' : '' }}">Entretenimiento</a>
                <a href="{{ route('home', ['categoria' => 'Salud y Belleza']) }}" class="btn btn-outline-secondary {{ request()->query('categoria') == 'Salud y Belleza' ? 'active' : '' }}">Salud y Belleza</a>
                <a href="{{ route('home', ['categoria' => 'Viajes']) }}" class="btn btn-outline-secondary {{ request()->query('categoria') == 'Viajes' ? 'active' : '' }}">Viajes</a>
                <a href="{{ route('home', ['categoria' => 'Ropa y Moda']) }}" class="btn btn-outline-secondary {{ request()->query('categoria') == 'Ropa y Moda' ? 'active' : '' }}">Ropa y Moda</a>
                <a href="{{ route('home', ['categoria' => 'Hogar y Muebles']) }}" class="btn btn-outline-secondary {{ request()->query('categoria') == 'Hogar y Muebles' ? 'active' : '' }}">Hogar y Muebles</a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Panel de ofertas disponibles -->
        <div class="col-lg-12">
            <div class="row">
                @forelse($offers as $offer)
                    <!-- Tarjeta de oferta -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <a href="#" class="offer-details" data-id="{{ $offer->id }}" data-title="{{ $offer->Título }}" data-price="{{ $offer->PrecioOferta }}" data-price-old="{{ $offer->PrecioRegular }}" data-description="{{ $offer->Descripción }}" data-image="{{ Storage::url($offer->Imagen) }}" data-quantity="{{ $offer->CantidadCupones }}">
                                @if($offer->Imagen && Storage::exists($offer->Imagen))
                                    <img class="card-img-top" src="{{ Storage::url($offer->Imagen) }}" alt="{{ $offer->Título }}">
                                @else
                                    <img class="card-img-top" src="{{ asset('template/assets/item.jpg') }}" alt="Imagen no disponible">
                                @endif
                            </a>
                            <div class="card-body">
                            <h4 class="card-title">
    <a href="#" class="offer-details" 
        data-id="{{ $offer->id }}" 
        data-title="{{ $offer->Título }}" 
        data-price="{{ $offer->PrecioOferta }}" 
        data-price-old="{{ $offer->PrecioRegular }}" 
        data-description="{{ $offer->Descripción }}" 
        data-image="{{ Storage::url($offer->Imagen) }}" 
        data-quantity="{{ $offer->CantidadCupones }}" 
        style="color: #343a40;">  <!-- Color negro del titulo del cuponc -->
        {{ $offer->Título }}
    </a>
</h4>

                                <h5>
                                    <span style="text-decoration: line-through; font-size: 0.9rem;">${{ number_format($offer->PrecioRegular, 2) }}</span>
                                    <strong>${{ number_format($offer->PrecioOferta, 2) }}</strong>
                                </h5>
                                <p class="card-text">{{ Str::limit($offer->Descripción, 100) }}</p>
<!-- Botón de "Agregar al carrito" -->
@auth
    @if(auth()->user()->role === 'cliente')
        <button class="btn btn-success btn-sm add-to-cart" 
                data-id="{{ $offer->id }}" 
                data-title="{{ $offer->Título }}" 
                data-price="{{ $offer->PrecioOferta }}" 
                data-quantity="{{ $offer->CantidadCupones }}">
            Agregar al Carrito
        </button>
    @endif
@else
    <button class="btn btn-success btn-sm" onclick="window.location.href='{{ route('login') }}'">Agregar al Carrito</button>
@endauth



                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Mensaje si no hay ofertas -->
                    <div class="col-12">
                        <p class="text-center">No hay ofertas disponibles en este momento.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const offerDetails = document.querySelectorAll('.offer-details');

        offerDetails.forEach(offer => {
            offer.addEventListener('click', function(e) {
                e.preventDefault(); // Evitar el comportamiento por defecto del enlace

                const title = this.dataset.title;
                const price = this.dataset.price;
                const oldPrice = this.dataset.priceOld;
                const description = this.dataset.description;
                const image = this.dataset.image;
                const quantity = this.dataset.quantity;

                Swal.fire({
                    title: title,
                    html: `
                        <img src="${image}" class="img-fluid mb-2" style="max-width: 100%; height: auto;">
                        <h5><span style="text-decoration: line-through;">$${oldPrice}</span> $${price}</h5>
                        <p>${description}</p>
                        <p><strong>Disponibles: </strong>${quantity} cupones restantes</p>
                    `,
                    showCancelButton: true,
                    cancelButtonText: 'Cerrar',
                    confirmButtonText: 'Agregar al carrito',
                    icon: null, // Eliminar el icono de alerta

                    // Verificar si el usuario está autenticado y es un cliente
                    preConfirm: () => {
    if (!{{ auth()->check() ? 'true' : 'false' }}) {
        // Si no está autenticado, redirigir al login directamente
        window.location.href = "{{ route('login') }}";
        return false;  // Evitar la acción del botón
    }

    // Verificar si el usuario autenticado es de tipo cliente
    if ('{{ auth()->check() ? auth()->user()->role : "" }}' === 'cliente') {
        return true;  // El usuario puede agregar al carrito
    } else {
        Swal.fire('Solo los clientes pueden agregar al carrito', '', 'info');
        return false;  // No se permite agregar al carrito
    }
}

                });
            });
        });
    });
</script>


@endsection
