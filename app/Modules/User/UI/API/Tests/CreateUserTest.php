<?php

namespace App\Modules\User\UI\API\Tests;

use App\Modules\User\Models\User;
use App\Ship\Abstracts\Tests\TestCase;
use Illuminate\Support\Arr;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group user
 * @group api
 */
class CreateUserTest extends TestCase
{
    protected array $access = [
        'roles' => '',
        'permissions' => 'create-users',
    ];

    protected function getTestData(): array
    {
        return [
            'email' => 'laraneat@mail.test',
            'name' => 'Laraneat',
            'password' => 'some_secret',
            'password_confirmation' => 'some_secret',
        ];
    }

    public function testCreateUser(): void
    {
        $this->getTestingUser();
        $data = $this->getTestData();
        $dataWithoutPassword = Arr::except($data, ['password', 'password_confirmation']);

        $this->postJson(route('api.users.create'), $data)
            ->assertCreated()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', fn (AssertableJson $json) =>
                    $json->has('id')
                        ->whereAll($dataWithoutPassword)
                        ->etc()
                )
            );

        $this->assertExistsModelWhereColumns(User::class, $dataWithoutPassword);
    }

    public function testCreateUserWithoutAccess(): void
    {
        $this->getTestingUserWithoutAccess();
        $data = $this->getTestData();

        $this->postJson(route('api.users.create'), $data)
            ->assertForbidden();
    }

    public function testCreateExistingUser(): void
    {
        $data = $this->getTestData();
        $this->getTestingUser(Arr::except($data, ['password_confirmation']));

        $this->postJson(route('api.users.create'), $data)
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'email'
            ]);
    }

    public function testCreateUserWithoutEmail(): void
    {
        $this->getTestingUser();
        $data = [
            'name' => 'Laraneat',
            'password' => 'some_secret',
            'password_confirmation' => 'some_secret',
        ];

        $this->postJson(route('api.users.create'), $data)
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'email'
            ]);
    }

    public function testCreateUserWithoutName(): void
    {
        $this->getTestingUser();
        $data = [
            'email' => 'laraneat@mail.test',
            'password' => 'some_secret',
            'password_confirmation' => 'some_secret',
        ];

        $this->postJson(route('api.users.create'), $data)
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name'
            ]);
    }

    public function testCreateUserWithoutPassword(): void
    {
        $this->getTestingUser();
        $data = [
            'email' => 'laraneat@mail.test',
            'name' => 'Laraneat',
        ];

        $this->postJson(route('api.users.create'), $data)
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'password'
            ]);
    }

    public function testCreateUserWithInvalidEmail(): void
    {
        $this->getTestingUser();
        $data = [
            'email' => 'missing-at.test',
            'name' => 'Laraneat',
            'password' => 'some_secret',
            'password_confirmation' => 'some_secret',
        ];

        $this->postJson(route('api.users.create'), $data)
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'email'
            ]);
    }
}
