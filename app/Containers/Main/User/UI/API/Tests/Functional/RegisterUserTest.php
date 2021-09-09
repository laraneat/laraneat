<?php

namespace App\Containers\Main\User\UI\API\Tests\Functional;

use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\Tests\ApiTestCase;
use Illuminate\Support\Arr;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * Class RegisterUserTest.
 *
 * @group user
 * @group api
 */
class RegisterUserTest extends ApiTestCase
{
    protected string $url = 'v1/users';

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

    public function testRegisterNewUser(): void
    {
        $this->getTestingUser();
        $data = $this->getTestData();
        $dataWithoutPassword = Arr::except($data, ['password']);

        $this->postJson($this->buildApiUrl(), $data)
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

    public function testRegisterNewUserWithoutAccess(): void
    {
        $this->getTestingUserWithoutAccess();
        $data = $this->getTestData();

        $this->postJson($this->buildApiUrl(), $data)
            ->assertForbidden();
    }

    public function testRegisterExistingUser(): void
    {
        $data = $this->getTestData();
        $this->getTestingUser($data);

        $this->postJson($this->buildApiUrl(), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email has already been taken.',
            ]);
    }

    public function testRegisterNewUserWithoutEmail(): void
    {
        $this->getTestingUser();
        $data = [
            'name' => 'Laraneat',
            'password' => 'secret',
        ];

        $this->postJson($this->buildApiUrl(), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email field is required.',
            ]);
    }

    public function testRegisterNewUserWithoutName(): void
    {
        $this->getTestingUser();
        $data = [
            'email' => 'laraneat@mail.test',
            'password' => 'secret',
        ];

        $this->postJson($this->buildApiUrl(), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name' => 'The name field is required.',
            ]);
    }

    public function testRegisterNewUserWithoutPassword(): void
    {
        $this->getTestingUser();
        $data = [
            'email' => 'laraneat@mail.test',
            'name' => 'Laraneat',
        ];

        $this->postJson($this->buildApiUrl(), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'password' => 'The password field is required.',
            ]);
    }

    public function testRegisterNewUserWithInvalidEmail(): void
    {
        $this->getTestingUser();
        $data = [
            'email' => 'missing-at.test',
            'name' => 'Laraneat',
            'password' => 'secret',
        ];

        $this->postJson($this->buildApiUrl(), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email must be a valid email address.',
            ]);
    }
}
