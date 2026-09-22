@props(['title', 'eyebrow' => null])
<section {{ $attributes->class(['content-panel']) }}><div class="panel-heading"><div>@if ($eyebrow)<span class="eyebrow">{{ $eyebrow }}</span>@endif<h2>{{ $title }}</h2></div></div>{{ $slot }}</section>
