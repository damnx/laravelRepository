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

    protected $response;
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
            "password" => bcrypt("123456"),
            "phone_number" => "12345678901",
        ];

        $newUser = User::create($data);

        $response = $this->post('/oauth/token', [
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => 'v4fT9xi7ooXNvlIor8Ajwf143JAUkP3Z2thefIug',
            'username' => $newUser->email,
            'password' => '123456',
            'scope' => '*',
        ]);
        $this->response = $response;
        $content = json_decode($this->response->content());
        $this->token = $content->access_token;

        $dataSA = [
            "id" => uniqid(null, true),
            "name" => "super admin",
            "email" => "sa@gmail.com",
            "password" => bcrypt("123456"),
            "phone_number" => "12345678901",
            "is_sadmin" => true,
        ];
        $sAdmin = User::create($dataSA);

        $responseSA = $this->post('/oauth/token', [
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => 'v4fT9xi7ooXNvlIor8Ajwf143JAUkP3Z2thefIug',
            'username' => $newUser->email,
            'password' => '123456',
            'scope' => '*',
        ]);

        $contentSA = json_decode($responseSA->content());
        $this->tokenSA = $contentSA->access_token;
    }

    public function getToken($user)
    {

        $response = $this->post('/oauth/token', [
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => 'v4fT9xi7ooXNvlIor8Ajwf143JAUkP3Z2thefIug',
            'username' => $user['email'],
            'password' => $user['password'],
            'scope' => '*',
        ]);

        $this->response = $response;
        $content = json_decode($this->response->content());
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
