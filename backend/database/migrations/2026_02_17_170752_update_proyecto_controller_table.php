<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::table('proyecto_controller', function (Blueprint $table) {
            $table->string('video_url')->nullable(false)->change();  // obligatoria
            $table->string('curso')->nullable();                     // nuevo campo
            $table->text('documentos')->nullable();                  // nuevo campo
            $table->string('tags')->nullable();                      // nuevo campo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proyecto_controller', function (Blueprint $table) {
            //
            $table->string('video_url')->nullable()->change();  
            $table->dropColumn(['curso', 'documentos', 'tags']);

        });
    }
};
