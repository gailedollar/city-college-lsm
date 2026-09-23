<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminTeacherAccountManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_management_requires_an_authenticated_administrator(): void
    {
        $this->get(route('admin.teachers.index'))->assertRedirect(route('login'));

        $teacher = User::factory()->create(['role' => 'teacher', 'student_id' => null, 'employee_id' => 'TCH-EXISTING']);
        $this->actingAs($teacher)->get(route('admin.teachers.index'))->assertForbidden();
        $this->actingAs($teacher)->post(route('admin.teachers.store'), $this->validTeacherData())->assertForbidden();
    }

    public function test_administrator_can_create_a_teacher_account(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'student_id' => null]);
        $response = $this->actingAs($admin)->post(route('admin.teachers.store'), $this->validTeacherData());

        $response->assertRedirect(route('admin.teachers.index'));
        $teacher = User::where('employee_id', 'CCT-2026-001')->firstOrFail();
        $this->assertSame('teacher', $teacher->role);
        $this->assertTrue(Hash::check('SecureTeacher123', $teacher->password));
        $this->actingAs($admin)->get(route('admin.teachers.index'))->assertOk()->assertSee('Prof. Taylor Cruz');
    }

    public function test_administrator_dashboard_uses_database_counts_and_empty_states(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'student_id' => null]);

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Registered students')
            ->assertSee('No Student or Teacher accounts have been registered.')
            ->assertDontSee('Taylor Mendoza')
            ->assertDontSee('1,248');
    }

    public function test_administrator_dashboard_only_offers_student_and_teacher_account_management(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'student_id' => null]);

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Create Student Account')
            ->assertSee('Create Teacher Account')
            ->assertDontSee('Programs &amp; Subjects', false)
            ->assertDontSee('Roles &amp; Permissions', false)
            ->assertDontSee('System Settings');
    }

    public function test_teacher_email_and_employee_id_must_be_unique(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'student_id' => null]);
        User::factory()->create(['role' => 'teacher', 'student_id' => null, 'employee_id' => 'CCT-2026-001', 'email' => 'teacher@example.test']);

        $this->actingAs($admin)->post(route('admin.teachers.store'), $this->validTeacherData())
            ->assertSessionHasErrors(['employee_id', 'email']);
    }

    /** @return array<string, string> */
    private function validTeacherData(): array
    {
        return ['name' => 'Prof. Taylor Cruz', 'employee_id' => 'CCT-2026-001', 'email' => 'teacher@example.test', 'password' => 'SecureTeacher123', 'password_confirmation' => 'SecureTeacher123'];
    }
}
