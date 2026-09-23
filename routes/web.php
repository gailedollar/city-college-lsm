<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\StudentAccountController;
use App\Http\Controllers\Admin\TeacherAccountController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\Dev\PortalPreviewController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => redirect()->route(request()->user()->role.'.dashboard'))->name('dashboard');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::view('/dashboard', 'student.dashboard', ['portal' => 'student', 'preview' => false])->name('dashboard');
        Route::get('/classrooms', [ClassroomController::class, 'studentIndex'])->name('classrooms');
        Route::get('/classrooms/join', [ClassroomController::class, 'join'])->name('classrooms.join');
        Route::post('/classrooms/{classroom}/join', [EnrollmentController::class, 'store'])->name('classrooms.enroll');
        Route::get('/classrooms/{classroom}', [ClassroomController::class, 'studentShow'])->name('classrooms.show');
        Route::view('/messages', 'messages.index', ['portal' => 'student', 'preview' => false])->name('messages');
    });

    Route::middleware('role:teacher')->prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/dashboard', TeacherDashboardController::class)->name('dashboard');
        Route::get('/classrooms', [ClassroomController::class, 'teacherIndex'])->name('classrooms');
        Route::get('/classrooms/create', [ClassroomController::class, 'create'])->name('classrooms.create');
        Route::post('/classrooms', [ClassroomController::class, 'store'])->name('classrooms.store');
        Route::get('/classrooms/{classroom}', [ClassroomController::class, 'teacherShow'])->name('classrooms.show');
        Route::get('/joining-requests', [EnrollmentController::class, 'index'])->name('requests');
        Route::patch('/joining-requests/{enrollment}', [EnrollmentController::class, 'update'])->name('requests.update');
        Route::view('/messages', 'messages.index', ['portal' => 'teacher', 'preview' => false])->name('messages');
        Route::view('/assignments', 'teacher.assignments.index', ['portal' => 'teacher', 'preview' => false])->name('assignments');
        Route::view('/assignments/create', 'teacher.assignments.create', ['portal' => 'teacher', 'preview' => false])->name('assignments.create');
        Route::view('/assignments/{assignment}/submissions', 'teacher.assignments.submissions', ['portal' => 'teacher', 'preview' => false])->name('assignments.submissions');
        Route::view('/assignments/{assignment}', 'teacher.assignments.show', ['portal' => 'teacher', 'preview' => false])->name('assignments.show');
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        Route::get('/students', [StudentAccountController::class, 'index'])->name('students.index');
        Route::get('/students/create', [StudentAccountController::class, 'create'])->name('students.create');
        Route::post('/students', [StudentAccountController::class, 'store'])->name('students.store');
        Route::get('/teachers', [TeacherAccountController::class, 'index'])->name('teachers.index');
        Route::get('/teachers/create', [TeacherAccountController::class, 'create'])->name('teachers.create');
        Route::post('/teachers', [TeacherAccountController::class, 'store'])->name('teachers.store');
    });
});

if (app()->environment('local') && config('app.debug')) {
    Route::get('/dev/student', [PortalPreviewController::class, 'student'])->name('dev.preview.student');
    Route::get('/dev/student/classrooms', [PortalPreviewController::class, 'studentClassrooms'])->name('dev.preview.student.classrooms');
    Route::get('/dev/student/classrooms/join', [PortalPreviewController::class, 'joinClassroom'])->name('dev.preview.student.join');
    Route::get('/dev/student/messages', [PortalPreviewController::class, 'studentMessages'])->name('dev.preview.student.messages');
    Route::get('/dev/student/classrooms/{classroom}', [PortalPreviewController::class, 'studentClassroom'])->name('dev.preview.student.classroom');
    Route::get('/dev/teacher', [PortalPreviewController::class, 'teacher'])->name('dev.preview.teacher');
    Route::get('/dev/teacher/classrooms', [PortalPreviewController::class, 'teacherClassrooms'])->name('dev.preview.teacher.classrooms');
    Route::get('/dev/teacher/classrooms/create', [PortalPreviewController::class, 'createClassroom'])->name('dev.preview.teacher.classrooms.create');
    Route::get('/dev/teacher/assignments', [PortalPreviewController::class, 'teacherAssignments'])->name('dev.preview.teacher.assignments');
    Route::get('/dev/teacher/assignments/create', [PortalPreviewController::class, 'createAssignment'])->name('dev.preview.teacher.assignments.create');
    Route::get('/dev/teacher/assignments/{assignment}/submissions', [PortalPreviewController::class, 'assignmentSubmissions'])->name('dev.preview.teacher.assignments.submissions');
    Route::get('/dev/teacher/assignments/{assignment}', [PortalPreviewController::class, 'assignmentDetails'])->name('dev.preview.teacher.assignments.show');
    Route::get('/dev/teacher/messages', [PortalPreviewController::class, 'teacherMessages'])->name('dev.preview.teacher.messages');
    Route::get('/dev/teacher/classrooms/{classroom}', [PortalPreviewController::class, 'teacherClassroom'])->name('dev.preview.teacher.classroom');
    Route::get('/dev/teacher/joining-requests', [PortalPreviewController::class, 'joiningRequests'])->name('dev.preview.teacher.requests');
    Route::get('/dev/admin', [PortalPreviewController::class, 'admin'])->name('dev.preview.admin');
}
