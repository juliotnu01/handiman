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
        Schema::create('ofertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('titulo')->nullable();
            $table->string('url_portada')->nullable();
            $table->text('descripcion')->nullable();
            //cateogira
            //folio
            $table->float('costo_hora', 10, 2)->nullable();
            $table->string('direccion')->nullable();
            $table->bigInteger('lat')->nullable();
            $table->bigInteger('lng')->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ofertas');
    }
};
