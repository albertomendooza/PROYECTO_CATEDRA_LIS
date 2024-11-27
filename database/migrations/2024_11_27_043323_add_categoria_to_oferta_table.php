<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoriaToOfertaTable extends Migration
{
    public function up()
{
    Schema::table('oferta', function (Blueprint $table) {
        $table->string('categoria')->nullable(); // Añadimos el campo categoria
    });
}

public function down()
{
    Schema::table('oferta', function (Blueprint $table) {
        $table->dropColumn('categoria'); // Elimina el campo categoria si se hace rollback
    });
}

}
