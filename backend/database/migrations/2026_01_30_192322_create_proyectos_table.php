<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    public function up(): void {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('resumen');
            $table->text('descripción');
            $table->string('curso');
            $table->string('alumnos');
            $table->string('video_url');
            $table->json('documentos')->nullable();
            $table->json("tags")->nullable();
            $table->boolean('checked')->default(false);
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('proyectos');
    }
};
