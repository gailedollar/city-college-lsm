<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeacherAccountRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeacherAccountController extends Controller
{
    public function index(): View
    {
        $teachers = User::query()->where('role', 'teacher')->latest()->paginate(12);

        return view('admin.teachers.index', compact('teachers'));
    }

    public function create(): View
    {
        return view('admin.teachers.create');
    }

    public function store(StoreTeacherAccountRequest $request): RedirectResponse
    {
        $teacher = User::create([...$request->validated(), 'role' => 'teacher', 'student_id' => null]);

        return redirect()->route('admin.teachers.index')->with('status', "Teacher account created for {$teacher->name}.");
    }
}
