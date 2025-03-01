<?php

namespace Database\Factories;

use App\Models\VerificationId;
use Illuminate\Database\Eloquent\Factories\Factory;

class VerificationIdFactory extends Factory
{
    protected $model = VerificationId::class;

    public function definition()
    {
        return [
            'id_path' => $this->faker->filePath(),
            'type' => $this->faker->randomElement(['front', 'back']),
            'is_verified' => $this->faker->boolean(),
        ];
    }
}