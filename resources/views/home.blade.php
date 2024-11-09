@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Bienvenido a La Cuponera SV
    </h2>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-3">
        <h1 class="my-4">Categorías</h1>
        <div class="list-group">
            <a href="#" class="list-group-item">Tecnología</a>
            <a href="#" class="list-group-item">Restaurantes</a>
            <a href="#" class="list-group-item">Entretenimiento</a>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <a href="#"><img class="card-img-top" src="template/assets/item.jpg" alt=""></a>
                    <div class="card-body">
                        <h4 class="card-title"><a href="#">Oferta 1</a></h4>
                        <h5>$10.00</h5>
                        <p class="card-text">Descripción breve de la oferta.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

