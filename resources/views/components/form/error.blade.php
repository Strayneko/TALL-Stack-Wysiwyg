@props(['model'])
@error($model)
    <span {{ $attributes->merge([
        'class' => 'text-red-500',
    ]) }}>{{ $message }}</span>
@enderror
