@extends('layouts.app', ['portal' => 'student', 'title' => 'Student dashboard', 'pageHeading' => 'Student dashboard'])
@section('content')
<div class="page-intro"><div><span class="eyebrow">Student portal · First semester</span><h1>Welcome back, Alex.</h1><p>Stay on track with your subjects and learning modules.</p></div><span class="semester-pill">Academic year 2026–2027</span></div>
<section class="stat-grid" aria-label="Learning summary">
    <x-dashboard.stat-card label="Enrolled subjects" value="6" detail="Current semester" icon="▤" />
    <x-dashboard.stat-card label="Available modules" value="18" detail="Across your subjects" icon="◫" tone="green" />
    <x-dashboard.stat-card label="Pending assignments" value="3" detail="Next due September 25" icon="◷" tone="gold" />
    <x-dashboard.stat-card label="Overall progress" value="72%" detail="Modules completed" icon="✓" />
</section>
<div class="dashboard-grid">
    <x-dashboard.panel title="Enrolled subjects" eyebrow="This semester"><x-dashboard.list :items="[
        ['title' => 'Introduction to Information Technology', 'detail' => 'BSIT 1A · Prof. Mira Santos', 'meta' => '78% complete'],
        ['title' => 'Purposive Communication', 'detail' => 'BSIT 1A · Prof. Leah Ramos', 'meta' => '64% complete'],
        ['title' => 'Mathematics in the Modern World', 'detail' => 'BSIT 1A · Prof. Nico Villanueva', 'meta' => '73% complete'],
    ]" /></x-dashboard.panel>
    <x-dashboard.panel title="Upcoming deadlines" eyebrow="Plan ahead"><x-dashboard.list :items="[
        ['title' => 'Digital literacy reflection', 'detail' => 'Introduction to Information Technology', 'meta' => 'Sep 25'],
        ['title' => 'Speech outline', 'detail' => 'Purposive Communication', 'meta' => 'Sep 28'],
        ['title' => 'Problem set 03', 'detail' => 'Mathematics in the Modern World', 'meta' => 'Oct 2'],
    ]" /></x-dashboard.panel>
    <x-dashboard.panel title="Recent learning materials" eyebrow="New for you"><x-dashboard.list :items="[
        ['title' => 'Computer Systems Fundamentals', 'detail' => 'Reading · Introduction to IT', 'meta' => 'Sep 20'],
        ['title' => 'Communicating Across Cultures', 'detail' => 'Video · Purposive Communication', 'meta' => 'Sep 19'],
        ['title' => 'Logic and Sets', 'detail' => 'Worksheet · Mathematics', 'meta' => 'Sep 17'],
    ]" /></x-dashboard.panel>
    <x-dashboard.panel title="Announcements" eyebrow="College updates"><x-dashboard.list :items="[
        ['title' => 'Library orientation', 'detail' => 'Join the library team for an online orientation.', 'meta' => 'Sep 26'],
        ['title' => 'Midterm study week', 'detail' => 'Review sessions begin next week.', 'meta' => 'Oct 5'],
    ]" /></x-dashboard.panel>
</div>
@endsection
