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
    <main class="guest-shell">
        <section class="guest-brand-panel" aria-label="City College of Cagayan de Oro">
            <a class="brand" href="{{ url('/') }}">
                <span class="brand-mark" aria-hidden="true">CC</span>
                <span>
                    <strong>City College</strong>
                    <small>of Cagayan de Oro</small>
                </span>
            </a>
            <div class="brand-message">
                <span class="eyebrow">Your learning space</span>
                <h1>Where every lesson moves you forward<span class="gold-period">.</span></h1>
                <p>Everything you need to learn, teach, and grow in one welcoming place.</p>
            </div>
            <div class="illustration-scene" aria-hidden="true">
                <span class="illustration-orbit orbit-one"></span>
                <span class="illustration-orbit orbit-two"></span>
                <span class="floating-academic-icon floating-book">▤</span>
                <span class="floating-academic-icon floating-spark">✦</span>
                <img src="{{ asset('images/student-learning-illustration.png') }}" alt="" fetchpriority="high">
            </div>
            <p class="brand-footer">© {{ date('Y') }} City College of Cagayan de Oro</p>
        </section>

        <section class="guest-content">
            @yield('content')
        </section>
    </main>
</body>
</html>
