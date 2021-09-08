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

    public function testRegisterNewUser(): void
    {
        $data = [
            'email' => 'laraneat@mail.test',
            'name' => 'Laraneat',
            'password' => 'secret',
        ];
        $dataWithoutPassword = Arr::except($data, ['password']);

        $this->getTestingUser();
        $this->postJson($this->buildApiUrl($this->url), $data)
            ->assertCreated()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('_profiler')
                    ->has('data', fn (AssertableJson $json) =>
                        $json->has('id')
                            ->whereAll($dataWithoutPassword)
                            ->etc()
                        )
            );

        $query = User::query();
        foreach ($dataWithoutPassword as $key => $value) {
            $query->where($key, $value);
        }
        $this->assertTrue($query->exists());
    }

    public function testRegisterNewUserWithoutAccess(): void
    {
        $data = [
            'email' => 'laraneat@mail.test',
            'name' => 'Laraneat',
            'password' => 'secret',
        ];

        $this->getTestingUserWithoutAccess();
        $this->postJson($this->buildApiUrl($this->url), $data)
            ->assertForbidden();
    }

    public function testRegisterExistingUser(): void
    {
        $data = [
            'email' => 'laraneat@mail.test',
            'name' => 'Laraneat',
            'password' => 'secret',
        ];

        $this->getTestingUser($data);

        $this->postJson($this->buildApiUrl($this->url), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email has already been taken.',
            ]);
    }

    public function testRegisterNewUserWithoutEmail(): void
    {
        $data = [
            'name' => 'Laraneat',
            'password' => 'secret',
        ];

        $this->getTestingUser();

        $this->postJson($this->buildApiUrl($this->url), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email field is required.',
            ]);
    }

    public function testRegisterNewUserWithoutName(): void
    {
        $data = [
            'email' => 'laraneat@mail.test',
            'password' => 'secret',
        ];

        $this->getTestingUser();

        $this->postJson($this->buildApiUrl($this->url), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name' => 'The name field is required.',
            ]);
    }

    public function testRegisterNewUserWithoutPassword(): void
    {
        $data = [
            'email' => 'laraneat@mail.test',
            'name' => 'Laraneat',
        ];

        $this->getTestingUser();

        $this->postJson($this->buildApiUrl($this->url), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'password' => 'The password field is required.',
            ]);
    }

    public function testRegisterNewUserWithInvalidEmail(): void
    {
        $data = [
            'email' => 'missing-at.test',
            'name' => 'Laraneat',
            'password' => 'secret',
        ];

        $this->getTestingUser();

        $this->postJson($this->buildApiUrl($this->url), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email must be a valid email address.',
            ]);
    }
}
