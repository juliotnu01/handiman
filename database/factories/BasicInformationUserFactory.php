<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BasicInformationUser>
 */
class BasicInformationUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'banner_photo_url' => 'https://picsum.photos/1200/400', // Banner dinámico
            'title_user' => $this->faker->sentence,
            'user_mobile' => $this->faker->phoneNumber,
            'main_address' => $this->faker->address,
            'abount_user' => $this->faker->paragraph,
            'first_name' => $this->faker->firstName,
            'second_name' => $this->faker->firstName,
            'first_last_name' => $this->faker->lastName,
            'second_last_name' => $this->faker->lastName,
            'nationality' => $this->faker->country,
            'website' => $this->faker->url,
            'birthdate' => $this->faker->date,
        ];
    }
}
