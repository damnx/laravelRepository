<?php

namespace Tests\Feature;

use Tests\OAuthTestCase;

class CreateRoleTest extends OAuthTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    protected $data;
    private $tokenCreateRole;

    public function setUp()
    {
        parent::setUp();
        $this->data = [
            'name' => $this->faker->name,
            'groupUserId' => $this->faker->uuid,
            'permissions' => ['CREATE_ROLES'],
        ];
        $this->tokenCreateRole = $this->tokenPermission(['CREATE_ROLES' => 'CREATE_ROLES']);
    }

    public function testResponse401()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token . str_random(3),
        ])->post('api/create-role', $this->data);
        $response->assertStatus(401);
    }

    public function testResponse403()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ])->post('api/create-role', $this->data);
        $response->assertStatus(403);
    }

    public function testResponse404()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ])->post('api/create-rolesss', $this->data);
        $response->assertStatus(404);
    }

    public function testValidationRequiredCreate()
    {
        $data = [
            'name' => '',
            'groupUserId' => '',
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->tokenCreateRole,
        ])->post('api/create-role', $data);

        $content = json_decode($response->content(), true);
        $this->assertEquals(1, $content['status']);
        $this->assertEquals('The name field is required.', $content['errors']['name'][0]);
        $this->assertEquals('The group user id field is required.', $content['errors']['groupUserId'][0]);
    }

    public function testValidationNameMax255Create()
    {
        $data = [
            'name' => $this->faker->realText($maxNbChars = 300, $indexSize = 2),
            'groupUserId' => $this->faker->uuid,
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->tokenCreateRole,
        ])->post('api/create-role', $data);
        $content = json_decode($response->content(), true);
        $this->assertEquals(1, $content['status']);
        $this->assertEquals('The name may not be greater than 255 characters.', $content['errors']['name'][0]);
    }

    public function testValidationNameUnique()
    {
        $data = [
            'name' => $this->faker->name,
            'groupUserId' => $this->faker->uuid,
        ];

        $response1 = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->tokenCreateRole,
        ])->post('api/create-role', $data);

        $response2 = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->tokenCreateRole,
        ])->post('api/create-role', $data);

        $content = json_decode($response2->content(), true);
        $this->assertEquals(1, $content['status']);
        $this->assertEquals('The name has already been taken.', $content['errors']['name'][0]);
    }

    public function testCreateSuccess()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->tokenCreateRole,
        ])->post('api/create-role', $this->data);
       
        $content = json_decode($response->content(), true);
        $this->assertEquals(0, $content['status']);
        $this->assertEquals($this->data['name'], $content['data']['name']);
        $this->assertEquals('CREATE_ROLES', $content['data']['permissions']['CREATE_ROLES']);
    }


}
