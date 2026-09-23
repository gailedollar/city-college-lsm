
@extends('layouts.app', [
    'portal' => 'student',
    'title' => 'Student dashboard',
    'pageHeading' => 'Student dashboard'
])

@section('content')

{{-- PAGE HEADER --}}
<div class="page-intro">

    <div>
        <span class="eyebrow">
            Student portal · First semester
        </span>

        <h1>
            Welcome back,
            {{ auth()->user()?->name ? explode(' ', trim(auth()->user()->name))[0] : 'Student' }}.
        </h1>

        <p>
            Stay on track with your classrooms and learning modules.
        </p>
    </div>

    <div class="page-actions">

        <a
            class="button button-primary"
            href="{{ route(($preview ?? false) ? 'dev.preview.student.join' : 'student.classrooms.join') }}"
        >
            + Join Classroom
        </a>

        <a
            class="button button-secondary"
            href="{{ route(($preview ?? false) ? 'dev.preview.student.classrooms' : 'student.classrooms') }}"
        >
            My Classrooms
        </a>

    </div>

</div>


{{-- DASHBOARD STATISTICS --}}

<section class="stat-grid" aria-label="Learning summary">

    <x-dashboard.stat-card
        label="Enrolled subjects"
        value="0"
        detail="Current semester"
        icon="▤"
    />

    <x-dashboard.stat-card
        label="Available modules"
        value="0"
        detail="Across your subjects"
        icon="◫"
        tone="green"
    />

    <x-dashboard.stat-card
        label="Pending assignments"
        value="0"
        detail="No pending assignments"
        icon="◷"
        tone="gold"
    />

    <x-dashboard.stat-card
        label="Overall progress"
        value="0%"
        detail="Modules completed"
        icon="✓"
    />

</section>


{{-- DASHBOARD PANELS --}}

<div class="dashboard-grid">

    {{-- MY CLASSROOMS --}}

    <x-dashboard.panel
        title="My Classrooms"
        eyebrow="Approved access"
    >

        <p>
            You have not joined any classrooms yet.
        </p>

    </x-dashboard.panel>


    {{-- PENDING JOINING REQUESTS --}}

    <x-dashboard.panel
        title="Pending joining requests"
        eyebrow="Teacher approval required"
    >

        <p>
            No pending joining requests.
        </p>

    </x-dashboard.panel>


    {{-- ENROLLED SUBJECTS --}}

    <x-dashboard.panel
        title="Enrolled subjects"
        eyebrow="This semester"
    >

        <p>
            No enrolled subjects yet.
        </p>

    </x-dashboard.panel>


    {{-- UPCOMING DEADLINES --}}

    <x-dashboard.panel
        title="Upcoming deadlines"
        eyebrow="Plan ahead"
    >

        <p>
            No upcoming deadlines.
        </p>

    </x-dashboard.panel>


    {{-- RECENT LEARNING MATERIALS --}}

    <x-dashboard.panel
        title="Recent learning materials"
        eyebrow="New for you"
    >

        <p>
            No learning materials available yet.
        </p>

    </x-dashboard.panel>


    {{-- ANNOUNCEMENTS --}}

    <x-dashboard.panel
        title="Announcements"
        eyebrow="College updates"
    >

        <p>
            No announcements available.
        </p>

    </x-dashboard.panel>

</div>

@endsection