<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'full_name' => $this->faker->name(),
            'nick_name' => $this->faker->unique()->userName(),
            'nationallity' => $this->faker->name(),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'date_of_birth' => $this->faker->date(),
            'active' => $this->faker->boolean(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->unique()->numerify('##########'),
            'email_verified_at' => now(),
            'password' => Hash::make('test@123456'), // password
            'remember_token' => Str::random(10),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole($this->faker->randomElement(['Manager', 'Player']));
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
