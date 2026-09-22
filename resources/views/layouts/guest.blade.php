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
            <a class="brand brand-light" href="{{ url('/') }}">
                <span class="brand-mark" aria-hidden="true">CC</span>
                <span>
                    <strong>City College</strong>
                    <small>of Cagayan de Oro</small>
                </span>
            </a>
            <div class="brand-message">
                <span class="eyebrow">Learning Module System</span>
                <h1>Keep learning moving forward.</h1>
                <p>One calm, focused space for courses, modules, and academic progress.</p>
            </div>
            <p class="brand-footer">© {{ date('Y') }} City College of Cagayan de Oro</p>
        </section>

        <section class="guest-content">
            @yield('content')
        </section>
    </main>
</body>
</html>
