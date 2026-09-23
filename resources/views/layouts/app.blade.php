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
    $preview = $preview ?? ($portal !== null);
    $labels = match ($portal) {
        'student' => ['Dashboard', 'My Classrooms', 'Join Classroom', 'Learning Modules', 'Assignments', 'My Progress', 'Announcements', 'Messages', 'My Profile'],
        'teacher' => ['Dashboard', 'My Classrooms', 'Create Classroom', 'Joining Requests', 'Module Management', 'Assignments & Quizzes', 'Attendance', 'My Students', 'Grades & Progress', 'Announcements', 'Messages', 'My Profile'],
        'admin' => ['Dashboard', 'Student Accounts', 'Teacher Accounts'],
        default => ['Dashboard', 'My courses', 'Learning modules', 'Calendar', 'Profile', 'Settings'],
    };
    $icons = ['▦', '▤', '+', '◫', '□', '◎', '◷', '◉', '♧', '≡', '✉', '⚙'];
    $navigation = array_map(fn ($label, $index) => ['label' => $label, 'icon' => $icons[$index], 'active' => $index === 0], $labels, array_keys($labels));
    if ($portal === 'student') {
        $navigation[0]['url'] = route($preview ? 'dev.preview.student' : 'student.dashboard');
        $navigation[1]['url'] = route($preview ? 'dev.preview.student.classrooms' : 'student.classrooms');
        $navigation[2]['url'] = route($preview ? 'dev.preview.student.join' : 'student.classrooms.join');
        $navigation[7]['url'] = route($preview ? 'dev.preview.student.messages' : 'student.messages');
    }
    if ($portal === 'teacher') {
        $navigation[0]['url'] = route($preview ? 'dev.preview.teacher' : 'teacher.dashboard');
        $navigation[1]['url'] = route($preview ? 'dev.preview.teacher.classrooms' : 'teacher.classrooms');
        $navigation[2]['url'] = route($preview ? 'dev.preview.teacher.classrooms.create' : 'teacher.classrooms.create');
        $navigation[3]['url'] = route($preview ? 'dev.preview.teacher.requests' : 'teacher.requests');
        $navigation[5]['url'] = route($preview ? 'dev.preview.teacher.assignments' : 'teacher.assignments');
        $navigation[10]['url'] = route($preview ? 'dev.preview.teacher.messages' : 'teacher.messages');
    }
    if ($portal === 'admin' && ! $preview) {
        $navigation[0]['url'] = route('admin.dashboard');
        $navigation[1]['url'] = route('admin.students.index');
        $navigation[2]['url'] = route('admin.teachers.index');
    }
    foreach ($navigation as $index => $item) {
        $navigation[$index]['active'] = isset($item['url']) && url()->current() === $item['url'];
    }
    if (! $preview && $portal === null) {
        $navigation[1]['url'] = '#courses';
        $navigation[2]['url'] = '#modules';
    }
    $userName = $preview ? match ($portal) {'student' => 'Alex Rivera', 'teacher' => 'Prof. Mira Santos', default => 'Jordan Cruz'} : auth()->user()->name;
    $userRole = $preview ? ucfirst($portal) : ucfirst(auth()->user()->role);
    $homeUrl = $navigation[0]['url'] ?? route('dashboard');
@endphp
<body class="app-page">
    <div class="app-shell">
        <x-dashboard.sidebar :portal="$portal" :navigation="$navigation" :preview="$preview" :home-url="$homeUrl" />
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
