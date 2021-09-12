<?php

namespace App\Containers\Main\Authorization\Data\Factories;

use App\Containers\Main\Authorization\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @method \Illuminate\Support\Collection|Permission create($attributes = [], ?Permission $parent = null)
 * @method \Illuminate\Support\Collection createMany(iterable $records)
 * @method Permission createOne($attributes = [])
 * @method \Illuminate\Support\Collection|Permission make($attributes = [], ?Permission $parent = null)
 * @method Permission makeOne($attributes = [])
 */
class PermissionFactory extends Factory
{
    protected $model = Permission::class;

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
