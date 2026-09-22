@extends('layouts.app', ['portal' => 'admin', 'title' => 'Administrator dashboard', 'pageHeading' => 'Administrator dashboard'])
@section('content')
<div class="page-intro"><div><span class="eyebrow">Administrator portal · First semester</span><h1>Welcome, Jordan.</h1><p>An overview of academic activity across the college.</p></div><span class="semester-pill">Academic year 2026–2027</span></div>
<section class="stat-grid" aria-label="College summary">
    <x-dashboard.stat-card label="Registered students" value="1,248" detail="Current semester" icon="♧" />
    <x-dashboard.stat-card label="Active teachers" value="68" detail="Across departments" icon="◎" tone="green" />
    <x-dashboard.stat-card label="Academic programs" value="8" detail="Currently offered" icon="▤" />
    <x-dashboard.stat-card label="Active subjects" value="94" detail="First semester" icon="◫" tone="gold" />
</section>
<div class="dashboard-grid">
    <x-dashboard.panel title="Recent account registrations" eyebrow="New accounts"><x-dashboard.list :items="[
        ['title' => 'Taylor Mendoza', 'detail' => 'Student · BSIT 1A', 'meta' => 'Today'],
        ['title' => 'Prof. Celina Reyes', 'detail' => 'Teacher · General Education', 'meta' => 'Yesterday'],
        ['title' => 'Samira Dela Cruz', 'detail' => 'Student · BSEd 1B', 'meta' => 'Sep 20'],
    ]" /></x-dashboard.panel>
    <x-dashboard.panel title="Recent system activity" eyebrow="Activity overview"><x-dashboard.list :items="[
        ['title' => 'Learning module published', 'detail' => 'Introduction to IT · Module 4', 'meta' => 'Today'],
        ['title' => 'Subject roster updated', 'detail' => 'BSIT 1B · Computer Programming 1', 'meta' => 'Yesterday'],
        ['title' => 'Semester calendar revised', 'detail' => 'First semester 2026–2027', 'meta' => 'Sep 19'],
    ]" /></x-dashboard.panel>
    <x-dashboard.panel title="Academic announcements" eyebrow="Campus notices"><x-dashboard.list :items="[
        ['title' => 'Enrollment verification period', 'detail' => 'Departments may review first-semester rosters.', 'meta' => 'Sep 30'],
        ['title' => 'Midterm assessment week', 'detail' => 'Assessment schedules will be shared with faculty.', 'meta' => 'Oct 12'],
    ]" /></x-dashboard.panel>
</div>
@endsection
