<?php

namespace Tests\Feature;

use App\Models\Classroom;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_empty_teacher_dashboard_shows_zero_values_and_no_sample_data(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher', 'student_id' => null, 'employee_id' => 'TCH-001']);

        $this->actingAs($teacher)->get(route('teacher.dashboard'))
            ->assertOk()
            ->assertSee('No pending enrollment requests.')
            ->assertSee('No classrooms created yet.')
            ->assertDontSee('Jamie Flores')
            ->assertDontSee('126')
            ->assertDontSee('Introduction to Information Technology');
    }

    public function test_teacher_dashboard_uses_the_teachers_own_classroom_and_enrollment_data(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher', 'student_id' => null, 'employee_id' => 'TCH-001']);
        $otherTeacher = User::factory()->create(['role' => 'teacher', 'student_id' => null, 'employee_id' => 'TCH-002']);
        $student = User::factory()->create();
        $otherStudent = User::factory()->create();
        $classroom = Classroom::factory()->create(['teacher_id' => $teacher->id, 'subject_name' => 'Database Systems']);
        $otherClassroom = Classroom::factory()->create(['teacher_id' => $otherTeacher->id, 'subject_name' => 'Hidden Classroom']);
        Enrollment::factory()->create(['classroom_id' => $classroom->id, 'student_id' => $student->id, 'status' => 'approved']);
        Enrollment::factory()->create(['classroom_id' => $otherClassroom->id, 'student_id' => $otherStudent->id, 'status' => 'approved']);

        $this->actingAs($teacher)->get(route('teacher.dashboard'))
            ->assertOk()
            ->assertSee('Database Systems')
            ->assertDontSee('Hidden Classroom');
    }
}
