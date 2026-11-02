<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_students_list(): void
    {
        $this->seed(\Database\Seeders\AdminUserSeeder::class);

        $this->post(route('admin.login'), ['username' => 'admin', 'password' => 'admin123']);

        $response = $this->get(route('admin.student.index'));
        $response->assertStatus(200);
        $response->assertSee(__('Students List'));
    }
}
