<?php

namespace Tests\Feature;

use App\Models\Roles;
use Tests\OAuthTestCase;

class UpdateRoleTest extends OAuthTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    protected $data;
    private $tokenUpdateRole;
    private $role;
    public function setUp()
    {
        parent::setUp();
        $this->data = [
            'name' => $this->faker->name,
            'groupUserId' => $this->faker->uuid,
            'permissions' => ['CREATE_ROLES'],
        ];
        $this->tokenUpdateRole = $this->tokenPermission(['UPDATE_ROLES' => 'UPDATE_ROLES']);
        $role = factory(Roles::class)->create();
        $this->role = $role;
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
        ])->put('api/roles/' . $this->role['id'], $this->data);
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
        $role = factory(Roles::class)->create();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ])->put('api/roles/' . $this->role['id'], $this->data);
        $response->assertStatus(403);
    }
    /**
     *  Không tìm thấy trang
     * pre data: user có quyền
     * input: data
     * output: trả về mã lỗi 403
     */
    public function testResponse404()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ])->put('api/update-rolesss/' . $this->role['id'], $this->data);
        $response->assertStatus(404);
    }

    /**
     * validate required name,groupUserId
     * pre data: user có quyền
     * input: data=[
     *              'name' => '',
     *              'groupUserId' => '',
     *              ];
     * output:
     *          status = 1
     *          errors['name'][0] = 'The name field is required.'
     *          errors['groupUserId'][0] = 'The group user id field is required.'
     */
    public function testValidationRequiredUpdate()
    {
        $data = [
            'name' => '',
            'groupUserId' => '',
        ];
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->tokenUpdateRole,
        ])->put('api/roles/' . $this->role['id'], $data);
        $content = json_decode($response->content(), true);
        $this->assertEquals(1, $content['status']);
        $this->assertEquals('The name field is required.', $content['errors']['name'][0]);
        $this->assertEquals('The group user id field is required.', $content['errors']['groupUserId'][0]);
    }

    /**
     * validate name lớn hơn 255 ký tự
     * pre data: user có quyền
     * input: data=[
     *              'name' => string()>255 ký tự,
     *              'groupUserId' => uuid,
     *              ];
     * output:
     *          status = 1
     *          errors['name'][0] = 'The name may not be greater than 255 characters.'
     *
     */
    public function testValidationNameMax255Update()
    {
        $data = [
            'name' => $this->faker->realText($maxNbChars = 300, $indexSize = 2),
            'groupUserId' => $this->faker->uuid,
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->tokenUpdateRole,
        ])->put('api/roles/' . $this->role['id'], $data);
        
        $content = json_decode($response->content(), true);
        $this->assertEquals(1, $content['status']);
        $this->assertEquals('The name may not be greater than 255 characters.', $content['errors']['name'][0]);
    }

    /**
     * validate name Unique
     * pre data: user có quyền
     * input: data=[
     *              'name' => string(),
     *              'groupUserId' => uuid,
     *              ];
     * output:
     *          status = 1
     *          errors['name'][0] = 'The name has already been taken.'
     */

    public function testValidationNameUnique()
    {
        $role = factory(Roles::class)->create();
        $data = [
            'name' => $role['name'],
            'groupUserId' => $this->faker->uuid,
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->tokenUpdateRole,
        ])->put('api/roles/' . $this->role['id'], $data);

        $content = json_decode($response->content(), true);
        $this->assertEquals(1, $content['status']);
        $this->assertEquals('The name has already been taken.', $content['errors']['name'][0]);
    }

    /**
     * Update role thành công
     * pre data: user có quyền
     * input: data=[
     *              'name' => string(),
     *              'groupUserId' => uuid,
     *              ];
     * output:
     *          status = 0
     *          $data['name'], $content['data']['name']
     */
    public function testUpdateSuccess()
    {
        $data = [
            'name' => $this->faker->name,
            'groupUserId' => $this->faker->uuid,
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->tokenUpdateRole,
        ])->put('api/roles/' . $this->role['id'], $data);

        $content = json_decode($response->content(), true);

        $this->assertEquals(0, $content['status']);
        $this->assertEquals($data['name'], $content['data']['name']);
    }

}
