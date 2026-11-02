<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_form_loads(): void
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(200);
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        $this->seed(\Database\Seeders\AdminUserSeeder::class);
        $response = $this->post(route('admin.login'), [
            'username' => 'admin@smart-academy.local',
            'password' => 'admin123',
        ]);
        $this->assertAuthenticated('admin');
    }

    public function test_admin_cannot_login_with_invalid_credentials(): void
    {
        $this->seed(\Database\Seeders\AdminUserSeeder::class);
        $response = $this->post(route('admin.login'), [
            'username' => 'admin@smart-academy.local',
            'password' => 'wrong-password',
        ]);
        $response->assertSessionHasErrors('username');
        $this->assertGuest('admin');
    }
}
