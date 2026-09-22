@extends('layouts.app')

@section('content')
    <div class="page-intro">
        <div>
            <span class="eyebrow">Tuesday, {{ now()->format('F j, Y') }}</span>
            <h1>Good morning, {{ explode(' ', auth()->user()->name ?? 'Student')[0] }}.</h1>
            <p>Here’s a clear view of your learning progress today.</p>
        </div>
        <a class="button button-secondary" href="#courses"><span aria-hidden="true">+</span> Browse courses</a>
    </div>

    <section class="stat-grid" aria-label="Learning summary">
        <article class="stat-card">
            <span class="stat-icon stat-icon-blue" aria-hidden="true">▤</span>
            <div><span class="stat-label">Active courses</span><strong>04</strong><small>+1 this semester</small></div>
        </article>
        <article class="stat-card">
            <span class="stat-icon stat-icon-green" aria-hidden="true">✓</span>
            <div><span class="stat-label">Modules completed</span><strong>18</strong><small>of 24 assigned</small></div>
        </article>
        <article class="stat-card">
            <span class="stat-icon stat-icon-gold" aria-hidden="true">◷</span>
            <div><span class="stat-label">Learning hours</span><strong>12.5</strong><small>+2.5 this week</small></div>
        </article>
    </section>

    <div class="dashboard-grid">
        <section class="content-panel course-panel" id="courses">
            <div class="panel-heading">
                <div><span class="eyebrow">Keep going</span><h2>Continue learning</h2></div>
                <a href="#all-courses">View all <span aria-hidden="true">→</span></a>
            </div>
            <div class="course-list">
                <article class="course-row">
                    <span class="course-number">01</span><div class="course-copy"><strong>Introduction to Information Technology</strong><span>Module 4 of 8 · 65% complete</span><div class="progress"><span style="width: 65%"></span></div></div><span class="course-arrow" aria-hidden="true">→</span>
                </article>
                <article class="course-row">
                    <span class="course-number">02</span><div class="course-copy"><strong>Communication Skills</strong><span>Module 2 of 6 · 32% complete</span><div class="progress"><span style="width: 32%"></span></div></div><span class="course-arrow" aria-hidden="true">→</span>
                </article>
                <article class="course-row">
                    <span class="course-number">03</span><div class="course-copy"><strong>Understanding Philippine History</strong><span>Module 5 of 5 · 92% complete</span><div class="progress"><span style="width: 92%"></span></div></div><span class="course-arrow" aria-hidden="true">→</span>
                </article>
            </div>
        </section>

        <section class="content-panel activity-panel" id="modules">
            <div class="panel-heading"><div><span class="eyebrow">Your timeline</span><h2>Recent activity</h2></div></div>
            <div class="activity-list">
                <div class="activity-item"><span class="activity-marker marker-blue"></span><div><strong>Module completed</strong><p>Computer Systems Fundamentals</p><small>Today, 9:42 AM</small></div></div>
                <div class="activity-item"><span class="activity-marker marker-green"></span><div><strong>Assignment submitted</strong><p>Communication Skills · Activity 02</p><small>Yesterday, 3:18 PM</small></div></div>
                <div class="activity-item"><span class="activity-marker marker-gold"></span><div><strong>Course joined</strong><p>Understanding Philippine History</p><small>September 18, 2025</small></div></div>
            </div>
        </section>
    </div>
@endsection
