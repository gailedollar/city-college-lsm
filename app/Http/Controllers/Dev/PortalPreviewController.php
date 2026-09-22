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

    public function admin(): View
    {
        return view('admin.dashboard');
    }
}
