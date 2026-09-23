<?php

namespace Tests\Feature;

use Tests\TestCase;

class PrototypeClassroomPagesTest extends TestCase
{
    public function test_local_classroom_preview_pages_render(): void
    {
        if (! app()->environment('local') || ! config('app.debug')) {
            $this->markTestSkipped('Local debug preview routes are intentionally unavailable.');
        }

        $paths = [
            '/dev/student',
            '/dev/student/classrooms',
            '/dev/student/classrooms/join',
            '/dev/student/classrooms/introduction-to-it',
            '/dev/student/messages',
            '/dev/teacher',
            '/dev/teacher/classrooms',
            '/dev/teacher/classrooms/create',
            '/dev/teacher/assignments',
            '/dev/teacher/assignments/create',
            '/dev/teacher/assignments/digital-literacy-reflection',
            '/dev/teacher/assignments/digital-literacy-reflection/submissions',
            '/dev/teacher/classrooms/introduction-to-it',
            '/dev/teacher/joining-requests',
            '/dev/teacher/messages',
            '/dev/admin',
            '/login',
        ];

        foreach ($paths as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_preview_routes_are_unavailable_outside_local_debug_mode(): void
    {
        if (app()->environment('local') && config('app.debug')) {
            $this->markTestSkipped('This assertion applies outside local debug mode.');
        }

        $this->get('/dev/student/classrooms')->assertNotFound();
        $this->get('/dev/teacher/classrooms')->assertNotFound();
        $this->get('/dev/student/messages')->assertNotFound();
        $this->get('/dev/teacher/messages')->assertNotFound();
        $this->get('/dev/teacher/assignments')->assertNotFound();
    }

    public function test_authenticated_dashboard_remains_protected(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }
}
