<?php

namespace App\Containers\Main\Authorization\Data\Factories;

use App\Containers\Main\Authorization\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->slug,
            'display_name' => $this->faker->name,
        ];
    }
}
