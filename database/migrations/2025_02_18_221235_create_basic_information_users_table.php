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
        Schema::create('basic_information_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('banner_photo_url', 2048)->nullable();
            $table->string('title_user')->nullable();
            $table->string('user_mobile')->nullable();
            $table->string('main_address')->nullable();
            $table->text('abount_user')->nullable();
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('first_last_name')->nullable();
            $table->string('second_last_name')->nullable();
            $table->string('nationality')->nullable();
            $table->string('website')->nullable();
            $table->date('birthdate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basic_information_users');
    }
};
