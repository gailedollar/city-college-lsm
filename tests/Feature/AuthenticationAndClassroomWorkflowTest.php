<?php

namespace Tests\Feature;

use App\Models\Classroom;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationAndClassroomWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_verifies_credentials_and_database_role(): void
    {
        $student = User::factory()->create(['role' => 'student', 'student_id' => 'TEST-STU-001', 'password' => Hash::make('secure-test-password')]);
        $this->post('/login', ['login_role' => 'teacher', 'login_id' => 'TEST-STU-001', 'password' => 'secure-test-password'])->assertSessionHasErrors('login_id');
        $this->assertGuest();
        $this->post('/login', ['login_role' => 'student', 'login_id' => 'TEST-STU-001', 'password' => 'secure-test-password'])->assertRedirect(route('student.dashboard'));
        $this->assertAuthenticatedAs($student);
    }

    public function test_teacher_can_create_a_persistent_owned_classroom(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher', 'student_id' => null, 'employee_id' => 'TEST-TCH-001']);
        $response = $this->actingAs($teacher)->post(route('teacher.classrooms.store'), $this->classroomData());
        $classroom = Classroom::firstOrFail();
        $response->assertRedirect(route('teacher.classrooms.show', $classroom));
        $this->assertSame($teacher->id, $classroom->teacher_id);
        $this->assertNotEmpty($classroom->joining_code);
    }

    public function test_administrator_can_login_with_username(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'username' => 'tidmac', 'student_id' => null, 'password' => Hash::make('admin123')]);

        $this->post('/login', ['login_role' => 'admin', 'login_id' => 'tidmac', 'password' => 'admin123'])
            ->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_enrollment_requires_teacher_approval_before_student_access(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher', 'student_id' => null, 'employee_id' => 'TEST-TCH-001']);
        $student = User::factory()->create(['role' => 'student']);
        $classroom = Classroom::factory()->for($teacher, 'teacher')->create();
        $this->actingAs($student)->post(route('student.classrooms.enroll', $classroom));
        $enrollment = Enrollment::firstOrFail();
        $this->assertSame('pending', $enrollment->status);
        $this->actingAs($student)->get(route('student.classrooms.show', $classroom))->assertForbidden();
        $this->actingAs($teacher)->patch(route('teacher.requests.update', $enrollment), ['status' => 'approved'])->assertRedirect();
        $this->actingAs($student)->get(route('student.classrooms.show', $classroom))->assertOk();
    }

    public function test_roles_and_classroom_ownership_are_enforced(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher', 'student_id' => null, 'employee_id' => 'TCH-ONE']);
        $otherTeacher = User::factory()->create(['role' => 'teacher', 'student_id' => null, 'employee_id' => 'TCH-TWO']);
        $student = User::factory()->create(['role' => 'student']);
        $classroom = Classroom::factory()->for($teacher, 'teacher')->create();
        $enrollment = Enrollment::factory()->for($classroom)->for($student, 'student')->create();
        $this->actingAs($student)->get(route('teacher.classrooms'))->assertForbidden();
        $this->actingAs($otherTeacher)->get(route('teacher.classrooms.show', $classroom))->assertForbidden();
        $this->actingAs($otherTeacher)->patch(route('teacher.requests.update', $enrollment), ['status' => 'approved'])->assertForbidden();
    }

    public function test_each_authenticated_portal_dashboard_renders_for_its_role(): void
    {
        foreach (['student', 'teacher', 'admin'] as $role) {
            $attributes = ['role' => $role, 'student_id' => null, 'employee_id' => null];
            if ($role === 'student') {
                $attributes['student_id'] = 'STUDENT-DASHBOARD';
            }
            if ($role === 'teacher') {
                $attributes['employee_id'] = 'TEACHER-DASHBOARD';
            }
            $user = User::factory()->create($attributes);
            $this->actingAs($user)->get(route($role.'.dashboard'))->assertOk();
        }
    }

    public function test_invalid_joining_code_does_not_expose_a_classroom(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $this->actingAs($student)->get(route('student.classrooms.join', ['code' => 'INVALID-CODE']))
            ->assertOk()
            ->assertSee('No classroom matches that joining code.');
    }

    public function test_duplicate_requests_and_logout(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $classroom = Classroom::factory()->create();
        $this->actingAs($student)->post(route('student.classrooms.enroll', $classroom));
        $this->actingAs($student)->post(route('student.classrooms.enroll', $classroom));
        $this->assertDatabaseCount('enrollments', 1);
        $this->post(route('logout'))->assertRedirect(route('login'));
        $this->assertGuest();
        $this->get(route('student.dashboard'))->assertRedirect(route('login'));
    }

    /** @return array<string, string> */
    private function classroomData(): array
    {
        return ['subject_name' => 'Web Development', 'subject_code' => 'IT 204', 'subject_description' => 'Web foundations.', 'section' => 'BSIT 2A', 'academic_year' => '2026–2027', 'semester' => 'First semester', 'class_schedule' => 'Tue/Thu 10:30 AM', 'description' => 'Classroom expectations.'];
    }
}
