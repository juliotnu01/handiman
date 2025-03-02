<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReviewUser>
 */
class ReviewUserFactory extends Factory
{
    protected $model = \App\Models\ReviewUser::class;

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
        ];
    }

    /**
     * Assign a random user and reviewer to the review.
     *
     * @param array $userIds
     * @return static
     */
    public function withRandomUsers(array $userIds): static
    {
        $userId = $this->faker->randomElement($userIds);
        $reviewerId = $this->faker->randomElement(array_diff($userIds, [$userId]));

        return $this->state([
            'user_id' => $userId,
            'reviewer_id' => $reviewerId,
        ]);
    }
}