<div class="container" id="random-properties-section">
    <div class="row row-odd zero-horizontal-margin">
        @foreach($randomProperties->chunk(2) as $chunk)
            @foreach($chunk as $index => $property)
                <div class="col-xs-6 custom-col-xs-12">
                    <article
                        class="row property-post-{{ $loop->parent->iteration % 2 == 1 ? 'odd' : 'even' }} hentry property-listing-home property-listing-one meta-item-half">
                        {{-- Para las propiedades en posición impar, imagen a la izquierda --}}
                        @if($loop->parent->iteration % 2 == 1)
                            <div class="property-thumbnail zero-horizontal-padding col-lg-6">
                                @if($property->images->count() >= 3)
                                    <div class="gallery-slider-two flexslider">
                                        <ul class="slides">
                                            @foreach($property->images->take(3) as $image)
                                                <li>
                                                    <a title="Feature Image" data-rel="gallery-{{ $property->id }}"
                                                       class="swipebox"
                                                       href="{{ asset('storage/' . $image->name) }}">
                                                        <img class="img-responsive"
                                                             src="{{ asset('storage/' . $image->name) }}"
                                                             alt="{{ $property->name }}"
                                                             style="height: 225px;"
                                                        >
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <a href="{{ route('frontend.properties.show', $property->slug) }}">
                                        <img class="img-responsive"
                                             src="{{ $property->thumbnail ? asset('storage/' . $property->thumbnail) : asset('assets/front/images/property/property-12-660x600.jpg') }}"
                                             alt="{{ $property->name }}"
                                             style="height: 225px;"
                                        >
                                    </a>
                                @endif
                            </div>
                        @endif

                        <div class="property-description clearfix col-lg-6">
                            <header class="entry-header">
                                <h3 class="entry-title">
                                    <a href="{{ route('frontend.properties.show', $property->slug) }}"
                                       rel="bookmark">{{ $property->name }}</a>
                                </h3>
                                <div class="price-and-status">
                                    <span class="price">
                                        {{ $property->currency == '$us' ? '$' : 'Bs.' }}
                                        {{ number_format($property->lowest_price, 2) }}
                                    </span>
                                    <a href="#"><span
                                            class="property-status-tag">{{ $property->serviceType->name }}</span></a>
                                </div>
                            </header>
                            <div class="property-meta entry-meta clearfix">
                                @switch($property->propertyType->type_name)
                                    @case('Casa')
                                        {{-- Mostrar campos para Casa --}}
                                        @include('frontend.partials.property-meta.casa-fields')
                                        @break

                                    @case('Departamento')
                                        {{-- Mostrar campos para Departamento --}}
                                        @include('frontend.partials.property-meta.departamento-fields')
                                        @break

                                    @case('Oficina')
                                        {{-- Mostrar campos para Oficina --}}
                                        @include('frontend.partials.property-meta.oficina-fields')
                                        @break

                                    @case('Terreno')
                                        {{-- Mostrar campos para Terreno --}}
                                        @include('frontend.partials.property-meta.terreno-fields')
                                        @break

                                    @default
                                        {{-- Campos por defecto --}}
                                        @include('frontend.partials.property-meta.default-fields')
                                @endswitch
                            </div>
                        </div>

                        {{-- Para las propiedades en posición par, imagen a la derecha --}}
                        @if($loop->parent->iteration % 2 == 0)
                            <div class="property-thumbnail zero-horizontal-padding col-lg-6">
                                @if($property->images->count() >= 3)
                                    <div class="gallery-slider-two flexslider">
                                        <ul class="slides">
                                            @foreach($property->images->take(3) as $image)
                                                <li>
                                                    <a title="Feature Image" data-rel="gallery-{{ $property->id }}"
                                                       class="swipebox"
                                                       href="{{ asset('storage/' .  $image->name) }}">
                                                        <img class="img-responsive"
                                                             src="{{ asset('storage/' .  $image->name) }}"
                                                             alt="{{ $property->name }}"
                                                             style="height: 225px;"
                                                        >
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <a href="{{ route('frontend.properties.show', $property->slug) }}">
                                        <img class="img-responsive"
                                             src="{{ $property->thumbnail ? asset('storage/' .  $property->thumbnail) : asset('assets/front/images/property/property-12-660x600.jpg') }}"
                                             alt="{{ $property->name }}"
                                             style="height: 225px;"
                                        >
                                    </a>
                                @endif
                            </div>
                        @endif
                    </article>
                </div>
            @endforeach
    </div>
    @if(!$loop->last)
        <div class="row row-{{ $loop->iteration % 2 == 0 ? 'even' : 'odd' }} zero-horizontal-margin">
            @endif
            @endforeach
        </div>



        @push('scripts')
            <script>
                $(document).ready(function () {
                    if ($('.gallery-slider-two').length > 0) {
                        $('.gallery-slider-two').flexslider({
                            animation: "slide",
                            controlNav: true,
                            directionNav: false
                        });
                    }

                    $('.swipebox').swipebox();
                });
            </script>
@endpush
