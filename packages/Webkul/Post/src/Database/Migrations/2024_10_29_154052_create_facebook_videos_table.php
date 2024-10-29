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
        Schema::create('facebook_videos', function (Blueprint $table) {
            $table->id();
            $table->string('video_path');//ruta tempooral del video en el servidor
            $table->string('description')->nullable();//descripcion del video
            $table->dateTime('publish_time');//fecha y hora de publicacion
            $table->enum('status', ['pendiente', 'publicado', 'error'])->default('pendiente'); // Estado del video
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facebook_videos');
    }
};
