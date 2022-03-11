<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTablerosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tableros', function (Blueprint $table) {
            $table->uuid('id')->primary('id');
            $table->string('titulo');
            $table->string('slug');
            $table->char('usuario_id', 36)->foreignId('usuario_id')->constrained('usuarios');
            $table->text('descripcion')->nullable();
            $table->char('usuario_send_id', 36)->foreignId('usuario_send_id')->constrained('usuarios');
            $table->date('date_send')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tableros');
    }
}
