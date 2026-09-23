<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $classrooms = $request->user()->ownedClassrooms()
            ->withCount(['enrollments as enrolled_students_count' => fn ($query) => $query->where('status', 'approved')])
            ->latest()
            ->get();

        $pendingEnrollments = Enrollment::query()
            ->with(['student', 'classroom'])
            ->where('status', 'pending')
            ->whereHas('classroom', fn ($query) => $query->where('teacher_id', $request->user()->id))
            ->latest()
            ->limit(5)
            ->get();

        $totalStudents = Enrollment::query()
            ->where('status', 'approved')
            ->whereHas('classroom', fn ($query) => $query->where('teacher_id', $request->user()->id))
            ->distinct('student_id')
            ->count('student_id');

        return view('teacher.dashboard', [
            'portal' => 'teacher',
            'preview' => false,
            'classrooms' => $classrooms,
            'pendingEnrollments' => $pendingEnrollments,
            'totalStudents' => $totalStudents,
        ]);
    }
}
