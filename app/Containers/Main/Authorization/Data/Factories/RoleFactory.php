<?php

namespace App\Containers\Main\Authorization\Data\Factories;

use App\Containers\Main\Authorization\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @method \Illuminate\Support\Collection|Role create($attributes = [], ?Role $parent = null)
 * @method \Illuminate\Support\Collection createMany(iterable $records)
 * @method Role createOne($attributes = [])
 * @method \Illuminate\Support\Collection|Role make($attributes = [], ?Role $parent = null)
 * @method Role makeOne($attributes = [])
 */
class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->slug,
            'display_name' => $this->faker->name,
            'description' => $this->faker->text(100),
            'guard_name' => 'web'
        ];
    }
}
