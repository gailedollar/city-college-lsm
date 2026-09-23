<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Enrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    public function store(Request $request, Classroom $classroom): RedirectResponse
    {
        $enrollment = Enrollment::firstOrCreate(['classroom_id' => $classroom->id, 'student_id' => $request->user()->id], ['status' => 'pending']);

        return redirect()->route('student.classrooms')->with('status', $enrollment->wasRecentlyCreated ? 'Joining request submitted for teacher approval.' : 'You already have a request for this classroom.');
    }

    public function index(Request $request): View
    {
        $requests = Enrollment::with(['student', 'classroom'])->where('status', 'pending')->whereHas('classroom', fn ($query) => $query->where('teacher_id', $request->user()->id))->latest()->get();

        return view('teacher.joining-requests', ['requests' => $requests, 'preview' => false]);
    }

    public function update(Request $request, Enrollment $enrollment): RedirectResponse
    {
        abort_unless($enrollment->classroom()->where('teacher_id', $request->user()->id)->exists(), 403);
        $validated = $request->validate(['status' => ['required', 'in:approved,declined']]);
        $enrollment->update(['status' => $validated['status'], 'decided_at' => now()]);

        return back()->with('status', 'Enrollment request '.$validated['status'].'.');
    }
}
