<?php

namespace Tests\Feature;

use App\Models\Roles;
use Tests\OAuthTestCase;

class DestroyRoleTest extends OAuthTestCase
{
    protected $data;
    private $tokenDestroyRoleTest;

    public function setUp()
    {
        parent::setUp();
        $this->tokenDestroyRoleTest = $this->tokenPermission(['DELETE_ROLES' => 'DELETE_ROLES']);
        $role = [
            'name' => 'damnx ' . $this->faker->name,
        ];
        $this->data = factory(Roles::class)->create($role);
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
        ])->delete('api/roles/' . $this->data['id']);
        $response->assertStatus(401);
    }

    /**
     *  Không phân quyền
     * pre data: user không có quyền
     * input: data
     * output: trả về mã lỗi 403
     */

    public function testResponse403()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ])->delete('api/roles/' . $this->data['id']);
        $response->assertStatus(403);
    }

    /**
     *  Không tìm thấy trang
     * pre data: user có quyền
     * input: data
     * output: trả về mã lỗi 404
     */

    public function testResponse404()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->tokenDestroyRoleTest,
        ])->delete('api/roless/' . $this->data['id']);
        $response->assertStatus(404);
    }

    public function testDestroySuccess()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->tokenDestroyRoleTest,
        ])->delete('api/roles/' . $this->data['id']);

        $content = json_decode($response->content(), true);
        $this->assertEquals(0, $content['status']);
        $this->assertEquals($this->data['id'], $content['data']['id']);
    }
}
