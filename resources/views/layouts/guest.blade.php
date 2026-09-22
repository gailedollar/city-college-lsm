<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Sign in' }} | City College LMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="guest-page">
    <div class="login-shell">
        <header class="login-header">
            <div class="login-header-inner">
                <a class="login-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/city-college-logo.png') }}" alt="" width="50" height="42">
                    <span><strong>City College</strong><small>Learning Module System</small></span>
                </a>
                <span class="login-header-label">City College of Cagayan de Oro</span>
            </div>
        </header>

        <main class="login-main">
            <section class="login-form-column" aria-label="Sign in">
                @yield('content')
                <p class="login-copyright">© {{ date('Y') }} City College of Cagayan de Oro</p>
            </section>
            <aside class="login-visual" aria-label="Learning community illustration">
                <img src="{{ asset('images/portal-roles-illustration.png') }}" alt="A student, teacher, and administrator working together" width="1223" height="1286">
            </aside>
        </main>
    </div>
</body>
</html>
