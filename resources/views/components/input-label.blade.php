@props(['value'])

<label {{ $attributes->merge(['class' => 'form-label max-w-56']) }}>
    {{ $value ?? $slot }}
</label>
