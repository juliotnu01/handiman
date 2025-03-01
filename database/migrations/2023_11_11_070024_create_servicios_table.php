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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->text('codigo')->nullable();
            $table->text('servicio')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('coordenadas')->nullable();
            $table->boolean('status')->nullable();
            $table->float('precio', 8, 2)->nullable();
            $table->foreignId('usr_creador')->nullable()->constrained('users');
            $table->foreignId('usr_receptor')->nullable()->constrained('users');                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
