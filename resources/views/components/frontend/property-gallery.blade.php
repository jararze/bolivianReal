{{-- resources/views/components/property-gallery.blade.php --}}

@props(['images', 'principal'])

<div class="single-property-slider gallery-slider flexslider">
    <ul class="slides">
        <li>
            <a class="swipebox"
               data-rel="gallery"
               href="{{ asset('storage/' . $principal['thumbnail']) }}">
                <img src="{{ asset('storage/' . $principal['thumbnail']) }}"
                     alt="{{ $principal['slug'] }}"
                     style="height: 527px; width: 100%; object-fit: cover;">
            </a>
        </li>
        @foreach($images as $image)
{{--            @dd($image->name)--}}
            <li>
                <a class="swipebox"
                   data-rel="gallery"
                   href="{{ asset('storage/' . $image->name) }}">
                    <img src="{{ asset('storage/' . $image->name) }}"
                         style="height: 527px; width: 100%; object-fit: cover;"
                         alt="{{ $name }}">
                </a>
            </li>
        @endforeach
    </ul>
</div>
