<?php

namespace App\Containers\Main\User\Tests\Unit;

use App\Containers\Main\User\Actions\RegisterUserAction;
use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\Tests\TestCase;
use App\Containers\Main\User\UI\API\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\App;

/**
 * Class RegisterUserTest.
 *
 * @group user
 * @group unit
 */
class RegisterUserTest extends TestCase
{
    public function testCreateUser(): void
    {
        $data = [
            'email' => 'Mahmoud@test.test',
            'password' => 'so-secret',
            'name' => 'Mahmoud',
        ];

        $request = new RegisterUserRequest($data);
        $user = App::make(RegisterUserAction::class)->run($request);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($user->name, $data['name']);
    }
}
