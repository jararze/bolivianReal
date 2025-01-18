@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1 block']) }} style="display: block; width: 100%;">
        @foreach ((array) $messages as $message)
            <li>
                <span class="badge badge-outline badge-danger">
                    {{ $message }}
                </span>
            </li>
        @endforeach
    </ul>
@endif
