<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLacuponerasvTables extends Migration
{
    public function up()
    {
        // Tabla Administrador
        Schema::create('administrador', function (Blueprint $table) {
            $table->id('ID');
            $table->string('Usuario', 100);
            $table->string('Contraseña');
            $table->timestamps();
        });

        // Tabla Cliente
        Schema::create('cliente', function (Blueprint $table) {
            $table->id('ID');
            $table->string('Usuario', 100);
            $table->string('Correo');
            $table->string('Contraseña');
            $table->string('NombreCompleto');
            $table->string('Apellidos');
            $table->string('DUI', 10);
            $table->date('FechaNacimiento');
            $table->timestamps();
        });

        // Tabla Empresa
        Schema::create('empresa', function (Blueprint $table) {
            $table->id('ID');
            $table->string('Nombre');
            $table->string('NIT', 14);
            $table->text('Dirección');
            $table->string('Teléfono', 15);
            $table->string('Correo');
            $table->string('Usuario', 100);
            $table->string('Contraseña');
            $table->float('Comisión');
            $table->timestamps();
        });

        // Tabla Oferta
        Schema::create('oferta', function (Blueprint $table) {
            $table->id('ID');
            $table->foreignId('EmpresaID')->constrained('empresa')->onDelete('cascade');
            $table->string('Título');
            $table->float('PrecioRegular');
            $table->float('PrecioOferta');
            $table->date('FechaInicio');
            $table->date('FechaFin');
            $table->date('FechaLimiteCanje');
            $table->integer('CantidadCupones')->nullable();
            $table->text('Descripción');
            $table->enum('Estado', ['Disponible', 'No disponible']);
            $table->timestamps();
        });

        // Tabla Compra
        Schema::create('compra', function (Blueprint $table) {
            $table->id('ID');
            $table->foreignId('ClienteID')->constrained('cliente')->onDelete('cascade');
            $table->foreignId('OfertaID')->constrained('oferta')->onDelete('cascade');
            $table->dateTime('FechaCompra');
            $table->string('CodigoCupon', 50)->unique();
            $table->integer('Cantidad');
            $table->timestamps();
        });

        // Tabla Factura
        Schema::create('factura', function (Blueprint $table) {
            $table->id('ID');
            $table->foreignId('CompraID')->constrained('compra')->onDelete('cascade');
            $table->float('MontoTotal');
            $table->dateTime('Fecha');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('factura');
        Schema::dropIfExists('compra');
        Schema::dropIfExists('oferta');
        Schema::dropIfExists('empresa');
        Schema::dropIfExists('cliente');
        Schema::dropIfExists('administrador');
    }
}
