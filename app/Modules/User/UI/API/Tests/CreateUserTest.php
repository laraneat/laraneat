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
    protected string $url = 'api/v1/users';

    protected array $access = [
        'roles' => '',
        'permissions' => 'create-users',
    ];

    protected function getTestData(): array
    {
        return [
            'email' => 'laraneat@mail.test',
            'name' => 'Laraneat',
            'password' => 'secret',
        ];
    }

    public function testCreateUser(): void
    {
        $this->getTestingUser();
        $data = $this->getTestData();
        $dataWithoutPassword = Arr::except($data, ['password']);

        $this->postJson($this->buildUrl(), $data)
            ->assertCreated()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('_profiler')
                    ->has('data', fn (AssertableJson $json) =>
                        $json->has('id')
                            ->whereAll($dataWithoutPassword)
                            ->etc()
                        )
            );

        $this->assertExistsModelWithAttributes(User::class, $dataWithoutPassword);
    }

    public function testCreateUserWithoutAccess(): void
    {
        $this->getTestingUserWithoutAccess();
        $data = $this->getTestData();

        $this->postJson($this->buildUrl(), $data)
            ->assertForbidden();
    }

    public function testCreateExistingUser(): void
    {
        $data = $this->getTestData();
        $this->getTestingUser($data);

        $this->postJson($this->buildUrl(), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email has already been taken.',
            ]);
    }

    public function testCreateUserWithoutEmail(): void
    {
        $this->getTestingUser();
        $data = [
            'name' => 'Laraneat',
            'password' => 'secret',
        ];

        $this->postJson($this->buildUrl(), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email field is required.',
            ]);
    }

    public function testCreateUserWithoutName(): void
    {
        $this->getTestingUser();
        $data = [
            'email' => 'laraneat@mail.test',
            'password' => 'secret',
        ];

        $this->postJson($this->buildUrl(), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name' => 'The name field is required.',
            ]);
    }

    public function testCreateUserWithoutPassword(): void
    {
        $this->getTestingUser();
        $data = [
            'email' => 'laraneat@mail.test',
            'name' => 'Laraneat',
        ];

        $this->postJson($this->buildUrl(), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'password' => 'The password field is required.',
            ]);
    }

    public function testCreateUserWithInvalidEmail(): void
    {
        $this->getTestingUser();
        $data = [
            'email' => 'missing-at.test',
            'name' => 'Laraneat',
            'password' => 'secret',
        ];

        $this->postJson($this->buildUrl(), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email must be a valid email address.',
            ]);
    }
}
