@props([
    'buttonType' => 'primary',
])

{{-- define button type class --}}
@php
    $classes = [
        'primary' => 'bg-primary border-primary hover:bg-primary/70 active:bg-primary/70 focus:bg-primary/70',
        'danger' => 'bg-red-500 border-red-500 hover:bg-red-500/70 active:bg-red-500/70 focus:bg-red-500/70',
        'info' => 'bg-lime-500 border-green-300 hover:bg-lime-500/70 active:bg-lime-500/70 focus:bg-lime-500/70',
    ];
@endphp

<x-button {{ $attributes->merge([
    'class' => $classes[$buttonType] ?? '',
]) }}>
    {{ $slot }}
</x-button>
