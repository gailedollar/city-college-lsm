<?php

use App\Http\Controllers\Dev\PortalPreviewController;
use Illuminate\Support\Facades\Route;

Route::view('/login', 'auth.login')->name('login');

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
});

if (app()->environment('local') && config('app.debug')) {
    Route::get('/dev/student', [PortalPreviewController::class, 'student'])->name('dev.preview.student');
    Route::get('/dev/teacher', [PortalPreviewController::class, 'teacher'])->name('dev.preview.teacher');
    Route::get('/dev/admin', [PortalPreviewController::class, 'admin'])->name('dev.preview.admin');
}
