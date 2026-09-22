@props(['label', 'value', 'detail', 'icon' => '▦', 'tone' => 'blue'])
<article class="stat-card"><span class="stat-icon stat-icon-{{ $tone }}" aria-hidden="true">{{ $icon }}</span><div><span class="stat-label">{{ $label }}</span><strong>{{ $value }}</strong><small>{{ $detail }}</small></div></article>
