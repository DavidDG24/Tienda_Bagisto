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
        Schema::create('facebook_settings', function (Blueprint $table) {
            $table->id();
            $table->string('page_id'); // ID de la página de Facebook
            $table->text('access_token'); // Token de acceso, será encriptado
            $table->string('default_message')->nullable(); // Mensaje por defecto
            $table->enum('status', ['active', 'expired'])->default('active'); // Estado del token
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facebook_settings');
    }
};
