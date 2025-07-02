{{-- resources/views/components/frontend/property-gallery.blade.php --}}

@props(['images', 'principal'])

<div class="single-property-slider gallery-slider flexslider">
    <ul class="slides">
        {{-- SIEMPRE MOSTRAR THUMBNAIL PRIMERO --}}
        @if($principal['thumbnail'])
            <li>
                <a class="swipebox"
                   data-rel="gallery"
                   href="{{ asset('storage/' . $principal['thumbnail']) }}">
                    <img src="{{ asset('storage/' . $principal['thumbnail']) }}"
                         alt="{{ $principal['slug'] }} - Imagen principal"
                         style="height: 527px; width: 100%; object-fit: cover;">
                </a>
            </li>
        @endif

        {{-- LUEGO LAS IMÁGENES ADICIONALES ORDENADAS --}}
        @foreach($images as $image)
            <li>
                <a class="swipebox"
                   data-rel="gallery"
                   href="{{ asset('storage/' . $image->name) }}">
                    <img src="{{ asset('storage/' . $image->name) }}"
                         style="height: 527px; width: 100%; object-fit: cover;"
                         alt="{{ $principal['slug'] }} - Imagen {{ $loop->iteration + 1 }}">
                </a>
            </li>
        @endforeach
    </ul>
</div>
