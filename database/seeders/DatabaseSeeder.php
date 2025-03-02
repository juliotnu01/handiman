<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Paso 1: Crear 50 usuarios con información asociada
        $users = User::factory(50)
            ->withBasicInformation()
            ->withPaymentMethods(3)
            ->withCertifications(3)
            ->withVerificationIds(2)
            ->create();

        // Obtener los IDs de los usuarios creados
        $userIds = $users->pluck('id')->toArray();

        // Paso 2: Crear revisiones para los usuarios existentes
        foreach ($users as $user) {
            // Crear entre 1 y 10 revisiones por usuario
            \App\Models\ReviewUser::factory(rand(1, 50))
                ->count(rand(1, 10))
                ->withRandomUsers($userIds)
                ->create();
        }
    }
}