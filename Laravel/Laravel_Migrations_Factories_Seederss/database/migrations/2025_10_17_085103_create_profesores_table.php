<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profesores', function (Blueprint $table) {
            $table->id()->unique();
            // $table->string('dni', 15)->primary(); // alternativa sin id autoincremental
            $table->string('nombre');
            $table->string('cargo');
            $table->integer('edad');
            $table->string('departamento');
            $table->text('observaciones');
            $table->date('fecha_nacimiento')->nullable();
            $table->timestamps();

            //Para claves compuestas:
            //$table->string('dni', 15);
            //$table->string('matricula', 20);
            //$table->primary(['dni', 'matricula']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profesores');
    }
};
