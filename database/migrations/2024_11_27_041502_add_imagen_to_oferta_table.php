<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImagenToOfertaTable extends Migration
{
    public function up()
{
    Schema::table('oferta', function (Blueprint $table) {
        $table->string('Imagen')->nullable(); // Campo para la imagen
    });
}

public function down()
{
    Schema::table('oferta', function (Blueprint $table) {
        $table->dropColumn('Imagen'); // Eliminar el campo Imagen en caso de rollback
    });
}

}
