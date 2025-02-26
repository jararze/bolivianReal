{{-- resources/views/components/property-gallery.blade.php --}}
<div class="single-property-slider gallery-slider flexslider">
    <ul class="slides">
{{--        @dd($images)--}}
        @foreach($images as $image)
            <li>
                <a class="swipebox"
                   data-rel="gallery"
                   href="{{ $image->image_url }}">
                    <img src="{{ asset('storage/' . $image->image_url) }}"
                         style="height: 510px; width: 100%; object-fit: cover;"
                         alt="{{ $name }}">
                </a>
            </li>
        @endforeach
    </ul>
</div>
