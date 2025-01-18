<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary']) }}
        name="{{ $name ?? '' }}"
        value="{{ $value ?? '' }}">
    {{ $slot }}
</button>
