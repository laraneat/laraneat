<?php

namespace App\Modules\User\Data\Factories;

use App\Modules\User\Models\User;
use App\Ship\Abstracts\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @method \Illuminate\Support\Collection|User create($attributes = [], ?User $parent = null)
 * @method \Illuminate\Support\Collection createMany(iterable $records)
 * @method User createOne($attributes = [])
 * @method \Illuminate\Support\Collection|User make($attributes = [], ?User $parent = null)
 * @method User makeOne($attributes = [])
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        static $password;

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $password ?: $password = Hash::make('testing-password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
