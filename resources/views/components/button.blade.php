@props(['primary' => false, 'secondary' => false])

@php
$classes = [
    'px-4 py-2 inline-block shadow',
    'bg-sky-600 hover:bg-sky-700 text-white' => $primary,
    'bg-teal-500 hover:bg-teal-600 text-white' => $secondary
]
@endphp

@if ($attributes->has('href'))
<a {{ $attributes->class($classes) }}>
    {{ $slot }}
</a>
@else
<button {{ $attributes->class($classes)->merge(['type' => 'button']) }}>
    {{ $slot }}
</button>
@endif
