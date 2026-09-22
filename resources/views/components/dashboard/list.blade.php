@props(['items' => []])
<div class="detail-list">@foreach ($items as $item)<div class="detail-row"><div><strong>{{ $item['title'] }}</strong><p>{{ $item['detail'] }}</p></div>@if (isset($item['meta']))<span class="detail-meta">{{ $item['meta'] }}</span>@endif</div>@endforeach</div>
