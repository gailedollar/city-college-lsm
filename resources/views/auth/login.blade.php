@extends('layouts.guest')

@section('content')
    <div class="auth-card">
        <div class="auth-brand"><span class="brand-mark" aria-hidden="true">CC</span><span>City College<br><strong>Learning Module System</strong></span></div>
        <div class="auth-heading">
            <span class="eyebrow">Your campus, online</span>
            <h2>Welcome back</h2>
            <p>Sign in with your City College account to continue.</p>
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
                <label for="email">Email address</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" placeholder="you@citycollege.edu.ph" @error('email') aria-invalid="true" aria-describedby="email-error" @enderror required autofocus>
                @error('email') <small class="field-error" id="email-error">{{ $message }}</small> @enderror
            </div>

            <div class="field-group">
                <div class="field-label-row">
                    <label for="password">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>
                <div class="password-field"><input id="password" name="password" type="password" autocomplete="current-password" placeholder="Enter your password" @error('password') aria-invalid="true" aria-describedby="password-error" @enderror required><button type="button" class="password-toggle" data-password-toggle aria-controls="password" aria-pressed="false" aria-label="Show password">Show</button></div>
                @error('password') <small class="field-error" id="password-error">{{ $message }}</small> @enderror
            </div>

            <label class="checkbox-label" for="remember">
                <input id="remember" name="remember" type="checkbox" value="1">
                <span>Remember me</span>
            </label>

            <button class="button button-primary button-full" type="submit">Sign In <span aria-hidden="true">→</span></button>
        </form>

        <p class="auth-note">Having trouble accessing your account? <a href="mailto:support@citycollege.edu.ph">Contact support</a>.</p>
        <p class="auth-footer">A learning space for the City College community.</p>
    </div>
@endsection
