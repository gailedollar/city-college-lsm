<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(['login_role' => ['required', 'in:student,teacher,admin'], 'login_id' => ['required', 'string', 'max:255'], 'password' => ['required', 'string'], 'remember' => ['nullable', 'boolean']]);
        $key = Str::transliterate(Str::lower($validated['login_role'].'|'.$validated['login_id']).'|'.$request->ip());
        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages(['login_id' => 'Too many login attempts. Try again in '.RateLimiter::availableIn($key).' seconds.']);
        }
        $identifier = match ($validated['login_role']) {
            'student' => 'student_id', 'teacher' => 'employee_id', 'admin' => 'username'
        };
        if (! Auth::attempt([$identifier => $validated['login_id'], 'role' => $validated['login_role'], 'password' => $validated['password']], $request->boolean('remember'))) {
            RateLimiter::hit($key, 60);
            throw ValidationException::withMessages(['login_id' => 'The selected role or account credentials are invalid.']);
        }
        RateLimiter::clear($key);
        $request->session()->regenerate();

        return redirect()->intended(route($validated['login_role'].'.dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
