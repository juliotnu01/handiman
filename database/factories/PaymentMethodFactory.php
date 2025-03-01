<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentMethodFactory extends Factory
{
    protected $model = PaymentMethod::class;

    public function definition(): array
    {
        return [
            'bank_name' => $this->faker->name(),
            'titular_name' => $this->faker->name(),
            'account_number' => $this->faker->bankAccountNumber(),
            'id_titular' => $this->faker->numerify('##########'),
            'type_account' => $this->faker->randomElement(['ahorro', 'corriente']),
            'status' => $this->faker->boolean(),
            'user_id' => null, // Esto se establecerá al asociar con el usuario
        ];
    }
}