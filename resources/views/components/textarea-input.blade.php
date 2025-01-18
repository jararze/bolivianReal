@props(['id', 'name', 'placeholder' => '', 'rows' => 3, 'value' => ''])

<textarea
    id="{{ $id }}"
    name="{{ $name }}"
    {{ $attributes->merge(['class' => 'textarea']) }}
    placeholder="{{ $placeholder }}"
    rows="{{ $rows }}"
>{{ $value }}</textarea>
