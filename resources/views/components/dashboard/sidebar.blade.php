@props(['portal' => null, 'navigation' => []])
<aside class="sidebar" id="portal-sidebar" data-sidebar aria-label="Portal navigation">
    <div class="sidebar-inner">
        <div class="sidebar-head">
            <a class="brand brand-light" href="{{ $portal ? route('dev.preview.'.$portal) : route('dashboard') }}">
                <span class="brand-mark" aria-hidden="true">CC</span>
                <span><strong>City College</strong><small>LMS Portal</small></span>
            </a>
            <button class="sidebar-close" type="button" aria-label="Close navigation" data-menu-close>×</button>
        </div>
        <nav class="main-nav" aria-label="Main navigation">
            <span class="nav-label">{{ $portal ? ucfirst($portal).' portal' : 'Workspace' }}</span>
            @foreach ($navigation as $item)
                @if ($item['active'])
                    <a class="nav-link is-active" href="{{ $portal ? route('dev.preview.'.$portal) : route('dashboard') }}" aria-current="page">
                        <span class="nav-icon" aria-hidden="true">{{ $item['icon'] }}</span><span>{{ $item['label'] }}</span>
                    </a>
                @elseif (isset($item['url']))
                    <a class="nav-link" href="{{ $item['url'] }}"><span class="nav-icon" aria-hidden="true">{{ $item['icon'] }}</span><span>{{ $item['label'] }}</span></a>
                @else
                    <span class="nav-link is-disabled" aria-disabled="true"><span class="nav-icon" aria-hidden="true">{{ $item['icon'] }}</span><span>{{ $item['label'] }}</span><small>Coming soon</small></span>
                @endif
            @endforeach
        </nav>
        <div class="sidebar-help"><span class="help-icon" aria-hidden="true">?</span><strong>Need help?</strong><p>Reach out to your college support team.</p><a href="mailto:support@citycollege.edu.ph">Contact support</a></div>
    </div>
</aside>
