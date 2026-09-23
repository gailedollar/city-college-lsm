<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ClassroomController extends Controller
{
    public function teacherIndex(Request $request): View
    {
        $classrooms = $request->user()->ownedClassrooms()->withCount(['enrollments as enrolled_students_count' => fn ($query) => $query->where('status', 'approved'), 'enrollments as pending_requests_count' => fn ($query) => $query->where('status', 'pending')])->latest()->get();

        return view('teacher.classrooms', ['classrooms' => $classrooms, 'preview' => false]);
    }

    public function create(): View
    {
        return view('teacher.create-classroom', ['preview' => false]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(['name' => ['required', 'string', 'max:255'], 'section' => ['required', 'string', 'max:100'], 'academic_year' => ['required', 'string', 'max:20'], 'semester' => ['required', 'string', 'max:50'], 'class_schedule' => ['required', 'string', 'max:255'], 'description' => ['required', 'string', 'max:2000']]);
        do {
            $code = Str::upper(Str::random(10));
        } while (Classroom::where('joining_code', $code)->exists());
        $classroom = $request->user()->ownedClassrooms()->create([...$validated, 'joining_code' => $code]);

        return redirect()->route('teacher.classrooms.show', $classroom)->with('status', 'Classroom created. Joining code: '.$code);
    }

    public function teacherShow(Request $request, Classroom $classroom): View
    {
        abort_unless($classroom->teacher_id === $request->user()->id, 403);

        return view('classrooms.show', ['portal' => 'teacher', 'classroom' => $classroom, 'preview' => false]);
    }

    public function studentIndex(Request $request): View
    {
        $enrollments = $request->user()->enrollments()->with('classroom.teacher')->latest()->get();

        return view('student.classrooms', ['enrollments' => $enrollments, 'preview' => false]);
    }

    public function join(Request $request): View
    {
        $classroom = null;
        if ($request->filled('code')) {
            $request->validate(['code' => ['string', 'max:32']]);
            $classroom = Classroom::with('teacher')->where('joining_code', Str::upper($request->string('code')->toString()))->first();
        }

        return view('student.join-classroom', ['classroom' => $classroom, 'preview' => false]);
    }

    public function studentShow(Request $request, Classroom $classroom): View
    {
        abort_unless($request->user()->enrollments()->where('classroom_id', $classroom->id)->where('status', 'approved')->exists(), 403);

        return view('classrooms.show', ['portal' => 'student', 'classroom' => $classroom, 'preview' => false]);
    }
}
