<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Staff;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_students_list(): void
    {
        $this->seed(\Database\Seeders\AdminUserSeeder::class);
        $staff = Staff::where('email', 'admin@smart-academy.local')->first();
        $this->actingAs($staff, 'admin');
        $response = $this->get(route('admin.student.index'));
        $response->assertStatus(200);
    }
}
