<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovedToUsersTable extends Migration
{
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->boolean('approved')->default(0); // Campo de aprobación, por defecto 0 (no aprobado)
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('approved');
    });
}

}
