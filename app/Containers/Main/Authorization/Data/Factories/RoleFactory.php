<?php

namespace App\Containers\Main\Authorization\Data\Factories;

use App\Containers\Main\Authorization\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->slug,
            'display_name' => $this->faker->name,
        ];
    }
}
