<?php

namespace Tests;

use App\Models\Roles;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OAuthTestCase extends TestCase
{
    use DatabaseTransactions;

    protected $token;
    protected $tokenSA;
    protected $faker;

    public function setUp()
    {
        parent::setUp();
        $this->faker = Factory::create();
        $data = [
            "id" => uniqid(null, true),
            "name" => "testNames",
            "email" => $this->faker->email,
            "password" => bcrypt("123456789"),
            "phone_number" => "12345678901",
        ];

        $newUser = User::create($data);
        $this->token = $this->getToken(["email" => $data['email'], "password" => "123456789"]);

        // $dataSA = [
        //     "id" => uniqid(null, true),
        //     "name" => "super admin",
        //     "email" => "sa@gmail.com",
        //     "password" => bcrypt("123456"),
        //     "phone_number" => "12345678901",
        //     "is_sadmin" => true,
        // ];

        // $sAdmin = User::create($dataSA);
        // $this->tokenSA = $this->getToken(["email" => $data['email'], "password" => "123456789"]);
    }

    public function getToken($user)
    {
        sleep(2);
        $response = $this->post('/oauth/token', [
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => 'FQvEtlLLazb6ojo7xJJBzZ3qxMPkZfrHu7wbNHAa',
            'username' => $user['email'],
            'password' => $user['password'],
            'scope' => '*',
        ]);
        $response = $response;
        $content = json_decode($response->content());
        return $content->access_token;

    }

    public function tokenPermission($permission)
    {
        $data = [
            "id" => uniqid(null, true),
            "name" => "testNamea",
            "email" => $this->faker->email,
            "password" => bcrypt("123456789"),
            "phone_number" => "12345678901",
        ];
        $user = User::create($data);
        $role = factory(Roles::class)->create();
        $role->permissions = $permission;
        $role->save();
        $role->users()->sync($user->id);
        return $this->getToken(["email" => $data['email'], "password" => "123456789"]);
    }
}
