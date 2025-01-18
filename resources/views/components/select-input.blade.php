@props(['name', 'options' => [], 'selected' => null])

<select {{ $attributes->merge(['class' => 'select']) }} name="{{ $name }}">
    @foreach ($options as $value => $text)
        <option value="{{ $value }}" @if ($selected == $value) selected @endif>
            {{ $text }}
        </option>
    @endforeach
</select>
