@props([
    'type' => 'success',
    'session',
    'title',
])

<div x-data>
    @if (session()->has($session))
        <div x-init="Swal.fire(`{{ $title }}`, `{{ session()->get($session) }}`, `{{ $type }}`)"></div>
    @endif
</div>
