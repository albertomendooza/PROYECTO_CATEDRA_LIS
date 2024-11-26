@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh; padding-top: 50px; padding-bottom: 50px;">
    <div class="col-md-6">
        <div class="card shadow-sm border-0" style="background-color: #f8f9fa;">
            <div class="card-header text-center bg-dark text-white">
                <h4>Pasarela de Pago</h4>
            </div>
            <div class="card-body" style="padding: 30px;">
                <!-- Mensajes de error -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('carrito.pagar.procesar') }}">
                    @csrf

                    <!-- Número de Tarjeta -->
                    <div class="form-group mb-4">
                        <label for="card_number" class="text-dark">Número de Tarjeta</label>
                        <input 
                            type="text" 
                            name="card_number" 
                            id="card_number" 
                            class="form-control" 
                            placeholder="1234 5678 9123 4567" 
                            required 
                            maxlength="16"
                            pattern="\d{16}"
                            title="Ingrese un número de tarjeta válido (16 dígitos)">
                    </div>

                    <!-- Fecha de Expiración -->
                    <div class="form-group mb-4">
                        <label for="expiry_date" class="text-dark">Fecha de Expiración</label>
                        <input 
                            type="text" 
                            name="expiry_date" 
                            id="expiry_date" 
                            class="form-control" 
                            placeholder="MM/AA" 
                            required 
                            pattern="^(0[1-9]|1[0-2])\/\d{2}$"
                            title="Ingrese la fecha de expiración en formato MM/AA">
                    </div>

                    <!-- CVV -->
                    <div class="form-group mb-4">
                        <label for="cvv" class="text-dark">CVV</label>
                        <input 
                            type="text" 
                            name="cvv" 
                            id="cvv" 
                            class="form-control" 
                            placeholder="123" 
                            required 
                            maxlength="3"
                            pattern="\d{3}"
                            title="Ingrese un CVV válido (3 dígitos)">
                    </div>

                    <!-- Nombre del Titular -->
                    <div class="form-group mb-4">
                        <label for="cardholder_name" class="text-dark">Nombre del Titular</label>
                        <input 
                            type="text" 
                            name="cardholder_name" 
                            id="cardholder_name" 
                            class="form-control" 
                            placeholder="Nombre Completo" 
                            required>
                    </div>

                    <!-- Total a pagar -->
                    <div class="form-group mb-4">
                        <label for="total" class="text-dark">Total a pagar</label>
                        <input 
                            type="text" 
                            id="total" 
                            class="form-control" 
                            value="${{ number_format($total, 2) }}" 
                            readonly>
                    </div>

                    <!-- Botón de pagar -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-dark">Pagar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
