<?php

namespace Database\Factories;

use App\Models\Certification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CertificationFactory extends Factory
{
    protected $model = Certification::class;

    public function definition()
    {
        return [
            'certification_name' => $this->faker->word,
            'certificatin_path' => $this->faker->filePath(),
            'description' => $this->faker->paragraph,
            'is_verified' => $this->faker->boolean,
            'user_id' => null,
        ];
    }
}