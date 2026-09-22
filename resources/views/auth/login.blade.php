@extends('layouts.guest')

@section('content')
    <div class="auth-card">
        <div class="auth-heading">
            <span class="eyebrow">Welcome back</span>
            <h2>Sign in to your account</h2>
            <p>Use your City College credentials to continue learning.</p>
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
                <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" placeholder="you@citycollege.edu.ph" required autofocus>
            </div>

            <div class="field-group">
                <div class="field-label-row">
                    <label for="password">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>
                <input id="password" name="password" type="password" autocomplete="current-password" placeholder="Enter your password" required>
            </div>

            <label class="checkbox-label" for="remember">
                <input id="remember" name="remember" type="checkbox" value="1">
                <span>Keep me signed in</span>
            </label>

            <button class="button button-primary button-full" type="submit">Sign in <span aria-hidden="true">→</span></button>
        </form>

        <p class="auth-note">Having trouble accessing your account? <a href="mailto:support@citycollege.edu.ph">Contact support</a>.</p>
    </div>
@endsection
