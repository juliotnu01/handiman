<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ReviewUser;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReviewUser>
 */
class ReviewUserFactory extends Factory
{
    protected $model = ReviewUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'score' => $this->faker->randomFloat(1, 1, 5),
            'score_comment' => $this->faker->sentence,
            'like_dislike' => $this->faker->boolean,
            'user_id' => null,
        ];
    }
}
