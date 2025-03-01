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
        // Crear registros para TipoServicio
        TipoServicio::factory(10)->create();

        // Crear usuarios con información básica asociada
        User::factory(50)
            ->withBasicInformation()
            ->create();
    }
}
