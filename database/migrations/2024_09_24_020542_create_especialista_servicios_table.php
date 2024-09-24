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
        Schema::create('especialista_tipo_servicio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('especialista_id')->nullable()->constrained('especialistas');
            $table->foreignId('tipo_servicio_id')->nullable()->constrained('tipo_servicios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('especialista_servicios');
    }
};
