@extends('layouts.app', ['portal' => 'admin', 'title' => 'Administrator dashboard', 'pageHeading' => 'Administrator dashboard'])
@section('content')
<div class="page-intro"><div><span class="eyebrow">Administrator portal</span><h1>Welcome, {{ ($preview ?? true) ? 'Jordan' : auth()->user()->name }}.</h1><p>Create and review Student and Teacher accounts.</p></div></div>
<section class="stat-grid" aria-label="Account summary">
    <x-dashboard.stat-card label="Student accounts" :value="$registeredStudents ?? 0" detail="Registered students" icon="♧" />
    <x-dashboard.stat-card label="Teacher accounts" :value="$activeTeachers ?? 0" detail="Registered teachers" icon="◎" tone="green" />
</section>
<div class="dashboard-grid">
    @unless ($preview ?? true)
    <x-dashboard.panel title="Create an account" eyebrow="Account management">
        <div class="card-actions"><a class="button button-primary" href="{{ route('admin.students.create') }}">+ Create Student Account</a><a class="button button-secondary" href="{{ route('admin.teachers.create') }}">+ Create Teacher Account</a></div>
    </x-dashboard.panel>
    @endunless
    <x-dashboard.panel title="Recent account registrations" eyebrow="New accounts">
        @if (($recentAccounts ?? collect())->isEmpty())<p class="empty-filter">No Student or Teacher accounts have been registered.</p>@else<x-dashboard.list :items="$recentAccounts" />@endif
    </x-dashboard.panel>
</div>
@endsection
