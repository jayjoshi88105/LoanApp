<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    public function testRegister()
    {
        $response = $this->json('POST', '/api/register', [
            'name'  =>  $name = 'Test',
            'email'  =>  $email = time().'test@example.com',
            'password'  =>  $password = '123456789',
        ]);
        $response->assertStatus(200);
        $this->assertArrayHasKey('token',$response->json());
    }

    public function testLogin()
    {
        $this->json('POST', '/api/register', [
            'name'  =>  $name = 'Test',
            'email'  =>  $email = time().'test@example.com',
            'password'  =>  $password = '123456789',
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/login', ['email' => $email, 'password' => $password]);
        $response->assertStatus(200);
        User::where('email',$email)->delete();
    }
}