<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_with_invalid_credentials_expect_code_400()
    {
        $data = [
            'nickname' => 'sherif*********',
            'password' => '12345678',
            'device_token' => 'test'
        ];

        $response = $this->post('/api/v1/login', $data);
        
        // dd($response);
        // $response->assertStatus(400);

        // dd($response['code']);
        $response->assertJsonPath('code', 400);
        // $response->assertJsonValidationErrors(['The password must be at least 8 characters.']);


        // $response->assertJsonValidationErrors(['key' => 'password', 'value' => 'The password must be at least 8 characters.']);
        // $response->assertJsonFragment(['code' => 400]);
    }
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_without_sending_nickname()
    {
        $data = [
            'nickname' => '',
            'password' => '12345678',
            'device_token' => '111111'
        ];

        $response = $this->post('/api/v1/login', $data);

        $response->assertValid(['password', 'device_token'])
                    ->assertInValid(['nickname']);
    }
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_without_sending_password()
    {
        $data = [
            'nickname' => 'sherif',
            'password' => '',
            'device_token' => '111111'
        ];

        $response = $this->post('/api/v1/login', $data);

        $response->assertValid(['nickname', 'device_token'])
                    ->assertInValid(['password']);
    }
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_with_sending_password_less_than_8_characters()
    {
        $data = [
            'nickname' => 'sherif',
            'password' => '123456',
            'device_token' => '111111'
        ];

        $response = $this->post('/api/v1/login', $data);

        $response->assertValid(['nickname', 'device_token'])
                    ->assertInValid(['password']);
    }
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_without_sending_device_token()
    {
        $data = [
            'nickname' => 'sherif',
            'password' => '12345678',
            'device_token' => ''
        ];

        $response = $this->post('/api/v1/login', $data);

        $response->assertValid(['nickname', 'password'])
                    ->assertInValid(['device_token']);
    }
}
