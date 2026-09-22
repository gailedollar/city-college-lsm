@extends('layouts.guest')

@section('content')
    <div class="auth-card">
        <div class="auth-heading">
            <h1>Hello there!</h1>
            <p>Please log in to get started.</p>
        </div>

        <div class="login-announcement">
            <span class="login-announcement-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6.5c-2.4-1.5-5.5-1.8-9-1v12c3.5-.8 6.6-.5 9 1 2.4-1.5 5.5-1.8 9-1v-12c-3.5-.8-6.6-.5-9 1Z"/><path d="M12 6.5v12"/></svg>
            </span>
            <div><strong>Your learning space, anytime.</strong><p>Access modules, manage activities, and stay connected with your classes.</p></div>
        </div>

        @if ($errors->any())
            <div class="alert alert-error" role="alert">
                <strong>We couldn't sign you in.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="auth-form" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="field-group">
                <label for="login-role">User type</label>
                <select id="login-role" name="login_role" @error('login_role') aria-invalid="true" aria-describedby="login-role-error" @enderror required autofocus>
                    <option value="" disabled @selected(! old('login_role'))>Select user type</option>
                    <option value="student" @selected(old('login_role') === 'student')>Student</option>
                    <option value="teacher" @selected(old('login_role') === 'teacher')>Teacher</option>
                    <option value="admin" @selected(old('login_role') === 'admin')>Administrator</option>
                </select>
                @error('login_role') <small class="field-error" id="login-role-error">{{ $message }}</small> @enderror
            </div>
            <div class="field-group">
                <label for="login-id" data-login-id-label>Student ID</label>
                <input id="login-id" name="login_id" type="text" value="{{ old('login_id') }}" autocomplete="username" placeholder="Student ID" data-login-id-input @error('login_id') aria-invalid="true" aria-describedby="login-id-error" @enderror required>
                @error('login_id') <small class="field-error" id="login-id-error">{{ $message }}</small> @enderror
            </div>

            <div class="field-group">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" autocomplete="current-password" placeholder="Password" @error('password') aria-invalid="true" aria-describedby="password-error" @enderror required>
                @error('password') <small class="field-error" id="password-error">{{ $message }}</small> @enderror
            </div>

            <div class="auth-options">
                <label class="checkbox-label" for="show-password">
                    <input id="show-password" type="checkbox" data-password-toggle aria-controls="password">
                    <span>Show password</span>
                </label>
                <label class="checkbox-label" for="remember">
                    <input id="remember" name="remember" type="checkbox" value="1">
                    <span>Remember me</span>
                </label>
            </div>

            @if (Route::has('password.request'))
                <a class="forgot-password-link" href="{{ route('password.request') }}">Forgot password?</a>
            @endif

            <button class="button button-primary login-submit" type="submit">Sign In</button>
        </form>

        <p class="auth-note">Need help? <a href="mailto:support@citycollege.edu.ph">Contact support</a>.</p>
    </div>
@endsection
