<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $recentAccounts = User::query()
            ->whereIn('role', ['student', 'teacher'])
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn (User $user): array => [
                'title' => $user->name,
                'detail' => ucfirst($user->role),
                'meta' => $user->created_at->diffForHumans(),
            ]);

        return view('admin.dashboard', [
            'portal' => 'admin',
            'preview' => false,
            'registeredStudents' => User::query()->where('role', 'student')->count(),
            'activeTeachers' => User::query()->where('role', 'teacher')->count(),
            'recentAccounts' => $recentAccounts,
        ]);
    }
}
