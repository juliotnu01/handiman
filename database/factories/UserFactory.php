<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
            'mode' => $this->faker->numberBetween(0, 1),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     */
    public function withPersonalTeam(callable $callback = null): static
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(fn(array $attributes, User $user) => [
                    'name' => $user->name . '\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }

    public function withBasicInformation()
    {
        return $this->has(
            \App\Models\BasicInformationUser::factory(),
            'basicInformation'
        );
    }

    public function withPaymentMethods(int $count = 3): static
    {
        return $this->has(
            \App\Models\PaymentMethod::factory()->count($count),
            'paymentMethods'
        );
    }
    public function withCertifications(int $count = 3): static
    {
        return $this->has(
            \App\Models\Certification::factory()->count($count),
            'certifications'
        );
    }
    public function withVerificationIds(int $count = 2): static
    {
        return $this->has(
            \App\Models\VerificationID::factory()->count($count),
            'verificationIds'
        );
    }
    /**
     * Indicate that the model should have reviews.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withReviews()
    {
        return $this->has(
            \App\Models\ReviewUser::factory()->count(rand(1, 10000)),
            'reviewUsers'
        );
    }
}
