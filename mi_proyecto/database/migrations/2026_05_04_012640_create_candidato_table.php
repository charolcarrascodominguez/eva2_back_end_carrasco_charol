<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Undocumented function
     *
     * @return void
     */
     public function up()
    {
        Schema::create('candidato', function (Blueprint $table) {
            $table->string('rut_cantidado', 20)->primary();
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->string('email', 100);
            $table->string('profesion', 50);
        });
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidato');
    }
};
