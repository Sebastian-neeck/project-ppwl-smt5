@props(['tagsCsv'])

@php
$tags = explode(',', $tagsCsv);
@endphp

<div class="flex flex-wrap gap-2">
    @foreach ($tags as $tag)
        <a href="/?tag={{ trim($tag) }}" class="px-3 py-1 bg-blue-50 text-blue-600 text-xs font-medium rounded-full hover:bg-blue-100 transition-colors">
            {{ trim($tag) }}
        </a>
    @endforeach
</div>