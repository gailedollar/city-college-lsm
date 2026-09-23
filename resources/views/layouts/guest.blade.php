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
                    <img src="{{ asset('images/city-college-horizontal-logo.png') }}" alt="City College of Cagayan de Oro" width="2170" height="725">
                </a>
            </div>
        </header>

        <main class="login-main">
            <section class="login-form-column" aria-label="Sign in">
                @yield('content')
                <p class="login-copyright">© {{ date('Y') }} City College of Cagayan de Oro</p>
            </section>
            <aside class="login-visual" aria-label="Learning community illustration">
                <article class="campus-update" aria-labelledby="campus-update-title">
                    <div class="campus-update-header">
                        <span class="campus-update-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 11v2a2 2 0 0 0 2 2h2l4 4V5L7 9H5a2 2 0 0 0-2 2Z"/>
                                <path d="M11 9c3.8 0 6.8-1.5 9-4v14c-2.2-2.5-5.2-4-9-4"/>
                                <path d="M5.5 15 7 20h3"/>
                            </svg>
                        </span>
                        <span class="campus-update-badge">Campus Update</span>
                    </div>
                    <h2 id="campus-update-title">Stay connected with your classes</h2>
                    <p>Access your learning materials, check announcements from your instructors, and stay updated on your academic activities.</p>
                    <footer>City College LMS <span aria-hidden="true">|</span> Academic Updates</footer>
                </article>
                <img src="{{ asset('images/portal-roles-illustration.png') }}" alt="A student, teacher, and administrator working together" width="1223" height="1286">
            </aside>
        </main>
    </div>
</body>
</html>
