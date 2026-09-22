@props(['heading' => 'Learning overview', 'userName' => 'Student User', 'userRole' => 'Learner', 'preview' => false])
<header class="topbar">
    <button class="menu-toggle" type="button" aria-label="Open navigation" aria-controls="portal-sidebar" aria-expanded="false" data-menu-toggle><span></span><span></span><span></span></button>
    <div class="topbar-heading"><span class="topbar-kicker">City College of Cagayan de Oro</span><strong>{{ $heading }}</strong></div>
    <div class="topbar-actions"><div class="profile-chip"><span class="avatar" aria-hidden="true">{{ strtoupper(substr($userName, 0, 1)) }}</span><span class="profile-copy"><strong>{{ $userName }}</strong><small>{{ $userRole }}{{ $preview ? ' · Demo' : '' }}</small></span></div></div>
</header>
