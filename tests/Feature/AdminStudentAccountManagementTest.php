<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminStudentAccountManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_management_requires_an_authenticated_administrator(): void
    {
        $this->get(route('admin.students.index'))->assertRedirect(route('login'));

        $teacher = User::factory()->create(['role' => 'teacher', 'student_id' => null, 'employee_id' => 'TCH-EXISTING']);
        $this->actingAs($teacher)->get(route('admin.students.index'))->assertForbidden();
        $this->actingAs($teacher)->post(route('admin.students.store'), $this->validStudentData())->assertForbidden();
    }

    public function test_administrator_can_create_a_student_account(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'student_id' => null]);

        $response = $this->actingAs($admin)->post(route('admin.students.store'), $this->validStudentData());

        $response->assertRedirect(route('admin.students.index'));
        $student = User::where('student_id', 'CCS-2026-001')->firstOrFail();
        $this->assertSame('student', $student->role);
        $this->assertNull($student->employee_id);
        $this->assertTrue(Hash::check('SecureStudent123', $student->password));
        $this->actingAs($admin)->get(route('admin.students.index'))->assertOk()->assertSee('Taylor Cruz');
    }

    public function test_student_email_and_student_id_must_be_unique(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'student_id' => null]);
        User::factory()->create(['student_id' => 'CCS-2026-001', 'email' => 'student@example.test']);

        $this->actingAs($admin)->post(route('admin.students.store'), $this->validStudentData())
            ->assertSessionHasErrors(['student_id', 'email']);
    }

    /** @return array<string, string> */
    private function validStudentData(): array
    {
        return ['name' => 'Taylor Cruz', 'student_id' => 'CCS-2026-001', 'email' => 'student@example.test', 'password' => 'SecureStudent123', 'password_confirmation' => 'SecureStudent123'];
    }
}
