@extends('layouts.app', ['portal' => 'teacher', 'title' => 'Teacher dashboard', 'pageHeading' => 'Teacher dashboard'])
@section('content')
<div class="page-intro"><div><span class="eyebrow">Teacher portal · First semester</span><h1>Good day, Prof. Santos.</h1><p>Review your classes, modules, and student submissions.</p></div><span class="semester-pill">Academic year 2026–2027</span></div>
<section class="stat-grid" aria-label="Teaching summary">
    <x-dashboard.stat-card label="Assigned classes" value="4" detail="Two BSIT sections" icon="▤" />
    <x-dashboard.stat-card label="Published modules" value="12" detail="Ready for students" icon="◫" tone="green" />
    <x-dashboard.stat-card label="Total students" value="126" detail="Across all classes" icon="♧" />
    <x-dashboard.stat-card label="Pending submissions" value="18" detail="Awaiting review" icon="◷" tone="gold" />
</section>
<div class="dashboard-grid">
    <x-dashboard.panel title="Assigned classes" eyebrow="My teaching load"><x-dashboard.list :items="[
        ['title' => 'Introduction to Information Technology', 'detail' => 'BSIT 1A · Mon/Wed 9:00 AM', 'meta' => '34 students'],
        ['title' => 'Introduction to Information Technology', 'detail' => 'BSIT 1B · Tue/Thu 10:30 AM', 'meta' => '32 students'],
        ['title' => 'Computer Programming 1', 'detail' => 'BSIT 1A · Tue/Thu 1:00 PM', 'meta' => '30 students'],
        ['title' => 'Computer Programming 1', 'detail' => 'BSIT 1B · Fri 8:00 AM', 'meta' => '30 students'],
    ]" /></x-dashboard.panel>
    <x-dashboard.panel title="Upcoming class activities" eyebrow="On the calendar"><x-dashboard.list :items="[
        ['title' => 'Digital literacy reflection due', 'detail' => 'Introduction to IT · BSIT 1A', 'meta' => 'Sep 25'],
        ['title' => 'Programming lab 04', 'detail' => 'Computer Programming 1 · BSIT 1B', 'meta' => 'Sep 29'],
        ['title' => 'Module 5 discussion', 'detail' => 'Introduction to IT · BSIT 1B', 'meta' => 'Oct 1'],
    ]" /></x-dashboard.panel>
    <x-dashboard.panel title="Recent student activities" eyebrow="Latest updates"><x-dashboard.list :items="[
        ['title' => '18 new assignment submissions', 'detail' => 'Digital literacy reflection', 'meta' => 'Today'],
        ['title' => 'Module 4 completed', 'detail' => 'BSIT 1A · 27 students', 'meta' => 'Yesterday'],
        ['title' => 'Quiz 03 submitted', 'detail' => 'Computer Programming 1', 'meta' => 'Sep 20'],
    ]" /></x-dashboard.panel>
    <x-dashboard.panel title="Announcements" eyebrow="Faculty notices"><x-dashboard.list :items="[
        ['title' => 'Faculty planning meeting', 'detail' => 'Department meeting in the faculty room.', 'meta' => 'Sep 27'],
        ['title' => 'Midterm assessment schedule', 'detail' => 'Draft schedules are available for review.', 'meta' => 'Oct 3'],
    ]" /></x-dashboard.panel>
</div>
@endsection
