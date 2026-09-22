<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} | City College LMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $portal = $portal ?? null;
    $preview = $portal !== null;
    $labels = match ($portal) {
        'student' => ['Dashboard', 'My Subjects', 'Learning Modules', 'Assignments', 'My Progress', 'Announcements', 'My Profile'],
        'teacher' => ['Dashboard', 'My Classes', 'Module Management', 'Assignments & Quizzes', 'My Students', 'Grades & Progress', 'Announcements', 'My Profile'],
        'admin' => ['Dashboard', 'User Management', 'Student Management', 'Teacher Management', 'Programs & Subjects', 'Academic Year & Semester', 'Roles & Permissions', 'Activity Logs', 'System Settings'],
        default => ['Dashboard', 'My courses', 'Learning modules', 'Calendar', 'Profile', 'Settings'],
    };
    $icons = ['▦', '▤', '◫', '□', '◎', '◉', '♧', '≡', '⚙'];
    $navigation = array_map(fn ($label, $index) => ['label' => $label, 'icon' => $icons[$index], 'active' => $index === 0], $labels, array_keys($labels));
    if (! $preview) {
        $navigation[1]['url'] = '#courses';
        $navigation[2]['url'] = '#modules';
    }
    $userName = $preview ? match ($portal) {'student' => 'Alex Rivera', 'teacher' => 'Prof. Mira Santos', default => 'Jordan Cruz'} : (auth()->user()->name ?? 'Student User');
    $userRole = $preview ? ucfirst($portal) : (auth()->user()->role ?? 'Learner');
@endphp
<body class="app-page">
    <div class="app-shell">
        <x-dashboard.sidebar :portal="$portal" :navigation="$navigation" />
        <div class="app-main">
            <x-dashboard.topbar :heading="$pageHeading ?? 'Learning overview'" :user-name="$userName" :user-role="$userRole" :preview="$preview" />
            <main class="page-content" id="main-content">
                @if ($preview)
                    <div class="preview-banner" role="status"><strong>Development preview</strong><span>Demonstration data only. This is not an authenticated session.</span></div>
                    <nav class="portal-switcher" aria-label="Development portal switcher"><span>Preview portal:</span>@foreach (['student' => 'Student', 'teacher' => 'Teacher', 'admin' => 'Administrator'] as $key => $label)<a href="{{ route('dev.preview.'.$key) }}" @if ($portal === $key) aria-current="page" @endif>{{ $label }}</a>@endforeach</nav>
                @endif
                @if (session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
                @yield('content')
            </main>
        </div>
    </div>
    <div class="sidebar-overlay" data-sidebar-overlay></div>
</body>
</html>
