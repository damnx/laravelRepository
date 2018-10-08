<?php

namespace Tests\Feature;

use Tests\OAuthTestCase;

class RoleTest extends OAuthTestCase
{
    protected $data;

    public function setUp()
    {
        parent::setUp();
        $this->data = [
            'name' => 'acc',
            'groupUserId' => '321335897',
        ];
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
        $tokenPermission = $this->tokenPermission(['CREATE_ROLES' => 'CREATE_ROLES']);
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $tokenPermission,
        ])->post('api/create-role', $data);
        $content = json_decode($response->content(), true);
        $this->assertEquals(1, $content['status']);
        $this->assertEquals('The name field is required.', $content['errors']['name'][0]);
        $this->assertEquals('The group user id field is required.', $content['errors']['groupUserId'][0]);
    }

    

}
