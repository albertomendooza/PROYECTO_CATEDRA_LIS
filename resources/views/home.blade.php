@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Bienvenido a La Cuponera SV
    </h2>
@endsection

@section('content')
<div class="row">
    <!-- Panel de categorías -->
    <div class="col-lg-3">
        <h1 class="my-4">Categorías</h1>
        <div class="list-group">
            <a href="#" class="list-group-item">Tecnología</a>
            <a href="#" class="list-group-item">Restaurantes</a>
            <a href="#" class="list-group-item">Entretenimiento</a>
        </div>
    </div>

    <!-- Panel de ofertas disponibles -->
    <div class="col-lg-9">
        <div class="row">
            @forelse($offers as $offer)
                <!-- Tarjeta de oferta -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <a href="#">
                            <img 
                                class="card-img-top" 
                                src="{{ asset('template/assets/item.jpg') }}" 
                                alt="{{ $offer->Título }}">
                        </a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">{{ $offer->Título }}</a>
                            </h4>
                            <h5>${{ number_format($offer->PrecioOferta, 2) }}</h5>
                            <p class="card-text">{{ Str::limit($offer->Descripción, 100) }}</p>
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
@endsection
