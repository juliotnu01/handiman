<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\BasicInformationUser;
use Faker\Factory as Faker;

class BasicInformationUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el primer usuario existente
        $user = User::first();

        // Verificar si el usuario existe
        if ($user) {
            // Inicializar Faker
            $faker = Faker::create();

            // Crear datos para basic_information_users asociados al usuario
            BasicInformationUser::create([
                'user_id' => $user->id,
                'banner_photo_url' => 'https://picsum.photos/1200/400', // Banner dinámico de Lorem Ipsum
                'title_user' => $faker->sentence, // Título del usuario, ahora es una frase completa
                'user_mobile' => $faker->phoneNumber,
                'main_address' => $faker->address,
                'abount_user' => $faker->paragraph,
                'first_name' => $faker->firstName,
                'second_name' => $faker->firstName,
                'first_last_name' => $faker->lastName,
                'second_last_name' => $faker->lastName,
                'nationality' => $faker->country,
                'website' => $faker->url,
                'birthdate' => $faker->date,
            ]);

            $this->command->info('Datos de basic_information_users creados para el usuario con ID: ' . $user->id);
        } else {
            $this->command->error('No se encontró ningún usuario en la base de datos.');
        }
    }
}
