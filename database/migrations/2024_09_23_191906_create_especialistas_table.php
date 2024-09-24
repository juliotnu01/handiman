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
        Schema::create('especialistas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->string('numero_identificacion')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('correo')->nullable();
            $table->boolean('status')->nullable();
            $table->text('url_documento_identificacion_frontal')->nullable();
            $table->text('url_documento_identificacion_trasera')->nullable();
            $table->text('url_avatar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('especialistas');
    }
};
