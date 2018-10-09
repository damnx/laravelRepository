<?php

namespace Tests\Feature;

use Tests\OAuthTestCase;

class ListRoleTest extends OAuthTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    protected $data;
    private $tokenUpdateRole;

    public function setUp()
    {
        parent::setUp();

        $this->tokenUpdateRole = $this->tokenPermission(['VIEW_ROLES' => 'VIEW_ROLES']);
        dd($this->tokenUpdateRole);
    }
    
    /**
     *
     * Chưa xác thực login
     * Data bất kỳ
     * input: token sai
     * output: trả về mã lỗi 401
     */

    public function testResponse401()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token . str_random(3),
        ])->put('api/update-role/' . $this->idRole, $this->data);
        $response->assertStatus(401);
    }
}
