<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PortalPreviewController extends Controller
{
    public function student(): View
    {
        return view('student.dashboard');
    }

    public function teacher(): View
    {
        return view('teacher.dashboard');
    }

    public function studentClassrooms(): View
    {
        return view('student.classrooms');
    }

    public function joinClassroom(): View
    {
        return view('student.join-classroom');
    }

    public function studentClassroom(string $classroom): View
    {
        return view('classrooms.show', ['portal' => 'student', 'classroomSlug' => $classroom]);
    }

    public function studentMessages(): View
    {
        return view('messages.index', ['portal' => 'student']);
    }

    public function teacherClassrooms(): View
    {
        return view('teacher.classrooms');
    }

    public function createClassroom(): View
    {
        return view('teacher.create-classroom');
    }

    public function teacherAssignments(): View
    {
        return view('teacher.assignments.index');
    }

    public function createAssignment(): View
    {
        return view('teacher.assignments.create');
    }

    public function assignmentDetails(string $assignment): View
    {
        return view('teacher.assignments.show', ['assignmentSlug' => $assignment]);
    }

    public function assignmentSubmissions(string $assignment): View
    {
        return view('teacher.assignments.submissions', ['assignmentSlug' => $assignment]);
    }

    public function teacherClassroom(string $classroom): View
    {
        return view('classrooms.show', ['portal' => 'teacher', 'classroomSlug' => $classroom]);
    }

    public function joiningRequests(): View
    {
        return view('teacher.joining-requests');
    }

    public function teacherMessages(): View
    {
        return view('messages.index', ['portal' => 'teacher']);
    }

    public function admin(): View
    {
        return view('admin.dashboard');
    }
}
