<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreStudentAccountRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StudentAccountController extends Controller
{
    public function index(): View
    {
        $students = User::query()->where('role', 'student')->latest()->paginate(12);

        return view('admin.students.index', compact('students'));
    }

    public function create(): View
    {
        return view('admin.students.create');
    }

    public function store(StoreStudentAccountRequest $request): RedirectResponse
    {
        $student = User::create([...$request->validated(), 'role' => 'student', 'employee_id' => null]);

        return redirect()->route('admin.students.index')->with('status', "Student account created for {$student->name}.");
    }
}
