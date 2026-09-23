<?php

namespace Database\Factories;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Classroom>
 */
class ClassroomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'teacher_id' => User::factory()->state(['role' => 'teacher', 'student_id' => null, 'employee_id' => fake()->unique()->bothify('TEST-TCH-####')]),
            'name' => fake()->words(3, true), 'section' => 'BSIT 1A', 'academic_year' => '2026–2027',
            'semester' => 'First semester', 'class_schedule' => 'Mon/Wed 9:00 AM', 'description' => fake()->paragraph(),
            'joining_code' => Str::upper(Str::random(10)),
        ];
    }
}
