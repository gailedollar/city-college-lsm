@extends('layouts.app', ['portal' => 'teacher', 'title' => 'Teacher dashboard', 'pageHeading' => 'Teacher dashboard'])
@section('content')
<div class="page-intro"><div><span class="eyebrow">Teacher portal</span><h1>Good day, {{ ($preview ?? true) ? 'Prof. Santos' : auth()->user()->name }}.</h1><p>Review your classrooms and enrollment requests.</p></div><div class="page-actions"><a class="button button-primary" href="{{ route(($preview ?? true) ? 'dev.preview.teacher.classrooms.create' : 'teacher.classrooms.create') }}">+ Create Classroom</a><a class="button button-secondary" href="{{ route(($preview ?? true) ? 'dev.preview.teacher.classrooms' : 'teacher.classrooms') }}">My Classrooms</a></div></div>
<section class="stat-grid" aria-label="Teaching summary">
    <x-dashboard.stat-card label="Active classrooms" :value="($classrooms ?? collect())->count()" detail="Created classrooms" icon="▤" />
    <x-dashboard.stat-card label="Published modules" value="0" detail="No modules published" icon="◫" tone="green" />
    <x-dashboard.stat-card label="Total students" :value="$totalStudents ?? 0" detail="Approved enrollments" icon="♧" />
    <x-dashboard.stat-card label="Pending submissions" value="0" detail="No submissions awaiting review" icon="◷" tone="gold" />
</section>
<div class="dashboard-grid">
    <x-dashboard.panel title="Pending enrollment requests" eyebrow="Needs review">
        @if (($pendingEnrollments ?? collect())->isEmpty())
            <p class="empty-filter">No pending enrollment requests.</p>
        @else
            <x-dashboard.list :items="$pendingEnrollments->map(fn ($enrollment) => ['title' => $enrollment->student->name, 'detail' => $enrollment->classroom->name, 'meta' => 'Pending'])" />
        @endif
    </x-dashboard.panel>
    <x-dashboard.panel title="Assigned classes" eyebrow="My teaching load">
        @if (($classrooms ?? collect())->isEmpty())
            <p class="empty-filter">No classrooms created yet.</p>
        @else
            <x-dashboard.list :items="$classrooms->map(fn ($classroom) => ['title' => $classroom->name, 'detail' => $classroom->section, 'meta' => $classroom->enrolled_students_count.' students'])" />
        @endif
    </x-dashboard.panel>
    <x-dashboard.panel title="Upcoming class activities" eyebrow="On the calendar"><p class="empty-filter">No upcoming class activities.</p></x-dashboard.panel>
    <x-dashboard.panel title="Recent student activities" eyebrow="Latest updates"><p class="empty-filter">No recent student activity.</p></x-dashboard.panel>
</div>
@endsection
