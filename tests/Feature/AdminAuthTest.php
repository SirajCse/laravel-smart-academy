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
        $response->assertSee(__('Sign in to start your session'));
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        $this->seed(\Database\Seeders\AdminUserSeeder::class);

        $response = $this->post(route('admin.login'), [
            'username' => 'admin',
            'password' => 'admin123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated('admin');
    }

    public function test_admin_cannot_login_with_invalid_credentials(): void
    {
        $response = $this->post(route('admin.login'), [
            'username' => 'admin',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('username');
        $this->assertGuest('admin');
    }
}
