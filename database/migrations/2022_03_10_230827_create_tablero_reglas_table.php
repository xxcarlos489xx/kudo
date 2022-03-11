<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableroReglasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tablero_reglas', function (Blueprint $table) {
            $table->char('tablero_id', 36)->foreignId('tablero_id')->constrained('tableros');
            $table->char('regla_id', 36)->foreignId('regla_id')->constrained('reglas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tablero_reglas');
    }
}
