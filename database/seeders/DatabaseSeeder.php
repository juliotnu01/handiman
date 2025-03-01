<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\BasicInformationUserSeeder;
use App\Models\User;
use App\Models\TipoServicio;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuarios con información básica asociada
        User::factory(50)
            ->withBasicInformation()
            ->withPaymentMethods(3)
            ->withCertifications(3)
            ->withVerificationIds(2)
            ->create();
    }
}
