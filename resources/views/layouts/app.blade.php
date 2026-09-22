<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} | City College LMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-page">
    <div class="app-shell">
        <aside class="sidebar" data-sidebar>
            <div class="sidebar-inner">
                <a class="brand" href="{{ route('dashboard') }}">
                    <span class="brand-mark" aria-hidden="true">CC</span>
                    <span>
                        <strong>City College</strong>
                        <small>LMS Portal</small>
                    </span>
                </a>

                <nav class="main-nav" aria-label="Main navigation">
                    <span class="nav-label">Workspace</span>
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}" href="{{ route('dashboard') }}">
                        <span class="nav-icon" aria-hidden="true">▦</span>
                        <span>Dashboard</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('courses.*') ? 'is-active' : '' }}" href="#courses">
                        <span class="nav-icon" aria-hidden="true">▤</span>
                        <span>My courses</span>
                    </a>
                    <a class="nav-link" href="#modules">
                        <span class="nav-icon" aria-hidden="true">◫</span>
                        <span>Learning modules</span>
                    </a>
                    <a class="nav-link" href="#calendar">
                        <span class="nav-icon" aria-hidden="true">□</span>
                        <span>Calendar</span>
                    </a>

                    <span class="nav-label nav-label-spaced">Account</span>
                    <a class="nav-link" href="#profile">
                        <span class="nav-icon" aria-hidden="true">◎</span>
                        <span>Profile</span>
                    </a>
                    <a class="nav-link" href="#settings">
                        <span class="nav-icon" aria-hidden="true">⚙</span>
                        <span>Settings</span>
                    </a>
                </nav>

                <div class="sidebar-help">
                    <span class="help-icon" aria-hidden="true">?</span>
                    <strong>Need help?</strong>
                    <p>Reach out to your college support team.</p>
                    <a href="mailto:support@citycollege.edu.ph">Contact support</a>
                </div>
            </div>
        </aside>

        <div class="app-main">
            <header class="topbar">
                <button class="menu-toggle" type="button" aria-label="Open navigation" aria-expanded="false" data-menu-toggle>
                    <span></span><span></span><span></span>
                </button>
                <div class="topbar-heading">
                    <span class="topbar-kicker">City College of Cagayan de Oro</span>
                    <strong>{{ $pageHeading ?? 'Learning overview' }}</strong>
                </div>
                <div class="topbar-actions">
                    <button class="icon-button" type="button" aria-label="View notifications">
                        <span aria-hidden="true">♢</span>
                        <span class="notification-dot"></span>
                    </button>
                    <div class="profile-chip">
                        <span class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'Student', 0, 1)) }}</span>
                        <span class="profile-copy">
                            <strong>{{ auth()->user()->name ?? 'Student User' }}</strong>
                            <small>{{ auth()->user()->role ?? 'Learner' }}</small>
                        </span>
                    </div>
                </div>
            </header>

            <main class="page-content">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    <div class="sidebar-overlay" data-sidebar-overlay></div>
</body>
</html>
