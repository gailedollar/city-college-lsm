@extends('layouts.app', ['portal' => 'teacher', 'title' => 'My Classrooms', 'pageHeading' => 'My Classrooms'])
@section('content')
<div class="page-intro"><div><span class="eyebrow">Teacher portal</span><h1>My Classrooms</h1><p>Create subjects, share joining codes, and review enrollment activity.</p></div><a class="button button-primary" href="{{ route(($preview ?? true) ? 'dev.preview.teacher.classrooms.create' : 'teacher.classrooms.create') }}">+ Create Classroom</a></div>
@if (! ($preview ?? true))
<section class="classroom-grid" aria-label="Your classrooms">@forelse ($classrooms as $classroom)<article class="classroom-card"><div class="classroom-card-accent"></div><span class="eyebrow">{{ $classroom->subject_code }}</span><h2>{{ $classroom->subject_name }}</h2><p>{{ $classroom->section }} · {{ $classroom->semester }} · AY {{ $classroom->academic_year }}</p><p>{{ $classroom->class_schedule }}</p><dl class="classroom-stats"><div><dt>Instructor</dt><dd>{{ auth()->user()->name }}</dd></div><div><dt>Students</dt><dd>{{ $classroom->enrolled_students_count }}</dd></div><div><dt>Pending</dt><dd>{{ $classroom->pending_requests_count }}</dd></div></dl><div class="join-code"><span>Joining code</span><strong>{{ $classroom->joining_code }}</strong><button type="button" data-copy-code="{{ $classroom->joining_code }}">Copy</button></div><a class="button button-primary button-full" href="{{ route('teacher.classrooms.show', $classroom) }}">Open Classroom</a></article>@empty<div class="coming-soon"><h2>No classrooms yet</h2><p>Create your first classroom to generate a joining code.</p></div>@endforelse</section>
@else
<div class="prototype-note"><strong>Demonstration only</strong><span>Classrooms and joining codes shown here are fictional and are not saved to a database.</span></div>
<section class="classroom-grid" aria-label="Your classrooms">
@foreach ([
 ['slug'=>'introduction-to-it','name'=>'Introduction to Information Technology','code'=>'IT 101','section'=>'BSIT 1A','term'=>'First semester · AY 2026–2027','schedule'=>'Mon/Wed · 9:00–10:30 AM','join'=>'CCIT-2026','students'=>34,'pending'=>2],
 ['slug'=>'computer-programming','name'=>'Computer Programming 1','code'=>'CC 102','section'=>'BSIT 1B','term'=>'First semester · AY 2026–2027','schedule'=>'Tue/Thu · 1:00–2:30 PM','join'=>'CODE-1B26','students'=>30,'pending'=>1],
] as $classroom)
<article class="classroom-card"><div class="classroom-card-accent"></div><span class="eyebrow">{{ $classroom['code'] }}</span><h2>{{ $classroom['name'] }}</h2><p>{{ $classroom['section'] }} · {{ $classroom['term'] }}</p><p>{{ $classroom['schedule'] }}</p><dl class="classroom-stats"><div><dt>Instructor</dt><dd>Prof. Mira Santos</dd></div><div><dt>Students</dt><dd>{{ $classroom['students'] }}</dd></div><div><dt>Pending</dt><dd>{{ $classroom['pending'] }}</dd></div></dl><div class="join-code"><span>Joining code</span><strong>{{ $classroom['join'] }}</strong><button type="button" data-copy-code="{{ $classroom['join'] }}">Copy</button></div><a class="button button-primary button-full" href="{{ route('dev.preview.teacher.classroom', $classroom['slug']) }}">Open Classroom</a></article>
@endforeach
</section>
@endif
@endsection
