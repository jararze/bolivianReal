@push('styles')
    <style>
        /* Estilos para asegurar que los placeholders de selects se vean correctamente */
        .search-sidebar select.form-control option:first-child {
            color: #333;
            font-weight: 500;
        }

        .search-sidebar select.form-control,
        .search-sidebar input.form-control {
            height: 40px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        /* Estilos para selectores Select2 si los usas */
        .search-sidebar .select2-container--default .select2-selection--single {
            height: 40px;
            margin-bottom: 10px;
        }

        .search-sidebar .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px;
            color: #333;
        }

        .search-sidebar .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
        }
    </style>
@endpush

<x-frontend-layout>

    <x-slot name="header">
        {{ __('Resultados de Búsqueda ') }}
    </x-slot>

    <div class="row">
        <div class="col-md-9 site-main-content">
            <main id="main" class="site-main">
                <div class="page-listing-control clearfix">
                    <div class="row">
                        <div class="col-xs-6 col-lg-7">
                            <h3>{{ $properties->total() }} Propiedades encontradas</h3>
                        </div>
                        <div class="col-xs-6 col-lg-5 page-controls-wrapper">
                            <div class="sort-controls">
                                <select name="sort" class="form-control" onchange="this.form.submit()">
                                    <option value="date-desc" {{ request('sort') == 'date-desc' ? 'selected' : '' }}>Más
                                        recientes
                                    </option>
                                    <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>
                                        Menor precio
                                    </option>
                                    <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>
                                        Mayor precio
                                    </option>
                                </select>
                            </div>
                            <!-- .sort-controls -->
                        </div>
                        <!-- .page-controls-wrapper -->
                    </div>
                    <!-- .row -->
                </div>
                <!-- .page-listing-control -->
                @forelse($properties as $property)
                    <article class="property-listing-simple property-listing-simple-2 hentry clearfix">
                        <div class="property-thumbnail col-sm-5 zero-horizontal-padding">
                            <div class="price-wrapper">
                                <span class="price" style="color: white">{{ $property->currency }} {{ number_format($property->max_price, 2) }} </span>
                            </div>
                            <div class="gallery-slider-two flexslider">
                                <ul class="slides">
                                    @if($property->images_ordered->count() >= 3)
                                        <div class="gallery-slider-two flexslider">
                                            <ul class="slides">
                                                {{-- SIEMPRE MOSTRAR THUMBNAIL PRIMERO --}}
                                                @if($property->thumbnail)
                                                    <li>
                                                        <a title="Feature Image"
                                                           href="{{ route('frontend.properties.show', $property->slug) }}">
                                                            <img class="img-responsive"
                                                                 src="{{ asset('storage/' . $property->thumbnail) }}"
                                                                 alt="{{ $property->name }}"
                                                                 style="height: 325px;"
                                                            >
                                                        </a>
                                                    </li>
                                                @endif

                                                {{-- LUEGO LAS IMÁGENES ORDENADAS (TOMAR 2 MÁS SI YA MOSTRÉ THUMBNAIL) --}}
                                                @php
                                                    $imagesToShow = $property->thumbnail ? 2 : 3;
                                                @endphp

                                                @foreach($property->images_ordered->take($imagesToShow) as $image)
                                                    <li>
                                                        <a title="Image {{ $loop->iteration + ($property->thumbnail ? 1 : 0) }}"
                                                           href="{{ route('frontend.properties.show', $property->slug) }}">
                                                            <img class="img-responsive"
                                                                 src="{{ asset('storage/' . $image->name) }}"
                                                                 alt="{{ $property->name }}"
                                                                 style="height: 325px;"
                                                            >
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <li>
                                            <a href="{{ route('frontend.properties.show', $property->slug) }}">
                                                <img class="img-responsive"
                                                     src="{{ $property->thumbnail ? asset('storage/' . $property->thumbnail) : asset('assets/front/images/property/property-12-660x600.jpg') }}"
                                                     alt="{{ $property->name }}"
                                                     style="height: 400px;"
                                                >
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <!-- .property-thumbnail -->
                        <div class="title-and-meta col-sm-7">
                            <header class="entry-header">
                                <h3 class="entry-title" style="margin-bottom: 3px">
                                    <a href="{{ route('frontend.properties.show', $property->slug) }}">
                                        {{ $property->name }}
                                    </a>
                                </h3>
                                <p class="location">{{ $property->address }}, {{ $property->neighborhood }}
                                    , {{ $property->citys->name }}</p>
                            </header>
                            <div class="property-meta entry-meta clearfix">
                                @switch($property->propertyType->type_name)
                                    @case('Casa')
                                        {{-- Mostrar campos para Casa --}}
                                        @include('frontend.partials.property-meta-complete.casa-fields')
                                        @break

                                    @case('Departamento')
                                        {{-- Mostrar campos para Departamento --}}
                                        @include('frontend.partials.property-meta-complete.departamento-fields')
                                        @break

                                    @case('Oficina')
                                        {{-- Mostrar campos para Oficina --}}
                                        @include('frontend.partials.property-meta-complete.oficina-fields')
                                        @break

                                    @case('Terreno')
                                        {{-- Mostrar campos para Terreno --}}
                                        @include('frontend.partials.property-meta-complete.terreno-fields')
                                        @break

                                    @default
                                        {{-- Campos por defecto --}}
                                        @include('frontend.partials.property-meta-complete.default-fields')
                                @endswitch

                                <p class="description" style="clear: both !important; margin-top: 10px">{{ Str::limit($property->short_description, 150) }}</p>
                            </div>
                            <!-- .property-meta -->
                        </div>
                        <!-- .title-and-meta -->
                    </article>
                @empty
                    <div class="no-results">
                        <h3>No se encontraron propiedades</h3>
                        <p>Intenta ajustar los filtros de búsqueda</p>
                    </div>
                @endforelse

                <div class="pagination-wrapper">
                    {{ $properties->links('vendor.pagination.default') }}
                </div>
                <!-- .pagination -->
            </main>
            <!-- .site-main -->
        </div>
        <!-- .site-main-content -->
        <div class="col-md-3 site-sidebar-content">
            <aside class="sidebar">
                <section class="widget widget-advance-search advance-search">
                    <h3 class="advance-search-widget-title"><i class="fa fa-search"></i>Busca tu propiedad</h3>
                    <form action="{{ route('frontend.properties.search') }}" method="GET" class="search-sidebar">
                        <div class="row field-wrap">
                            <!-- Ciudad -->
                            <div class="option-bar col-xs-12 property-location">
                                <select name="location" class="form-control search-select">
                                    <option value="any" {{ !request('location') || request('location') == 'any' ? 'selected' : '' }}>Ciudad</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ request('location') == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Zona (nuevo) -->
                            <div class="option-bar col-xs-12 property-neighborhood">
                                <select name="neighborhood_id" id="neighborhood" class="form-control search-select">
                                    <option value="any" {{ !request('neighborhood_id') || request('neighborhood_id') == 'any' ? 'selected' : '' }}>Zona</option>
                                    @foreach($neighborhoods as $neighborhood)
                                        <option value="{{ $neighborhood->id }}"
                                                data-city="{{ $neighborhood->city_id }}"
                                            {{ request('neighborhood_id') == $neighborhood->id ? 'selected' : '' }}>
                                            {{ $neighborhood->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tipo de propiedad -->
                            <div class="option-bar col-xs-12 property-type">
                                <select name="type" class="form-control search-select">
                                    <option value="any" {{ !request('type') || request('type') == 'any' ? 'selected' : '' }}>Tipo de propiedad</option>
                                    @foreach($propertyTypes as $type)
                                        <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                                            {{ $type->type_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Estado de la propiedad -->
                            <div class="option-bar col-xs-12 property-status">
                                <select name="status" class="form-control search-select">
                                    <option value="any" {{ !request('status') || request('status') == 'any' ? 'selected' : '' }}>Estado</option>
                                    @foreach($serviceTypes as $type2)
                                        <option value="{{ $type2->id }}" {{ request('status') == $type2->id ? 'selected' : '' }}>
                                            {{ $type2->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Categoría: Proyecto o Propiedad (nuevo) -->
                            <div class="option-bar col-xs-12 property-is-project">
                                <select name="is_project" class="form-control search-select">
                                    <option value="any" {{ !request('is_project') || request('is_project') == 'any' ? 'selected' : '' }}>Categoría</option>
                                    <option value="1" {{ request('is_project') == '1' ? 'selected' : '' }}>Proyecto en construcción</option>
                                    <option value="0" {{ request('is_project') == '0' ? 'selected' : '' }}>Propiedad terminada</option>
                                </select>
                            </div>

                            <!-- Palabra clave -->
                            <div class="option-bar col-xs-12 property-keyword">
                                <input type="text" name="keyword" id="keyword-txt"
                                       value="{{ request('keyword') }}"
                                       placeholder="Palabra clave (ej: nombre, dirección)"
                                       class="form-control">
                            </div>

                            <!-- Código de propiedad -->
                            <div class="option-bar col-xs-12 property-id">
                                <input type="text" name="code" id="property-id-txt"
                                       value="{{ request('code') ?? request('property_id') }}"
                                       placeholder="Código de propiedad"
                                       class="form-control">
                            </div>

                            <!-- Dormitorios -->
                            <div class="option-bar col-xs-12 property-bedrooms">
                                <select name="bedrooms" id="select-bedrooms" class="form-control search-select">
                                    <option value="any" {{ !request('bedrooms') || request('bedrooms') == 'any' ? 'selected' : '' }}>Dormitorios</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ request('bedrooms') == $i ? 'selected' : '' }}>
                                            Al menos {{ $i }} {{ $i == 1 ? 'dormitorio' : 'dormitorios' }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Baños -->
                            <div class="option-bar col-xs-12 property-bathrooms">
                                <select name="bathrooms" id="select-bathrooms" class="form-control search-select">
                                    <option value="any" {{ !request('bathrooms') || request('bathrooms') == 'any' ? 'selected' : '' }}>Baños</option>
                                    @for($i = 1; $i <= 4; $i++)
                                        <option value="{{ $i }}" {{ request('bathrooms') == $i ? 'selected' : '' }}>
                                            Al menos {{ $i }} {{ $i == 1 ? 'baño' : 'baños' }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Garajes (nuevo) -->
                            <div class="option-bar col-xs-12 property-garage">
                                <select name="garage" id="select-garage" class="form-control search-select">
                                    <option value="any" {{ !request('garage') || request('garage') == 'any' ? 'selected' : '' }}>Garajes</option>
                                    @for($i = 1; $i <= 3; $i++)
                                        <option value="{{ $i }}" {{ request('garage') == $i ? 'selected' : '' }}>
                                            Al menos {{ $i }} {{ $i == 1 ? 'garaje' : 'garajes' }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Rango de precios (reemplaza min/max price) -->
                            <div class="option-bar col-xs-12 property-price-range">
                                <select name="price_range" class="form-control search-select">
                                    <option value="any" {{ !request('price_range') || request('price_range') == 'any' ? 'selected' : '' }}>Rango de precio</option>
                                    <option value="0-50000" {{ request('price_range') == '0-50000' ? 'selected' : '' }}>Hasta $50,000</option>
                                    <option value="50000-100000" {{ request('price_range') == '50000-100000' ? 'selected' : '' }}>$50,000 - $100,000</option>
                                    <option value="100000-200000" {{ request('price_range') == '100000-200000' ? 'selected' : '' }}>$100,000 - $200,000</option>
                                    <option value="200000-300000" {{ request('price_range') == '200000-300000' ? 'selected' : '' }}>$200,000 - $300,000</option>
                                    <option value="300000-500000" {{ request('price_range') == '300000-500000' ? 'selected' : '' }}>$300,000 - $500,000</option>
                                    <option value="500000-1000000" {{ request('price_range') == '500000-1000000' ? 'selected' : '' }}>$500,000 - $1,000,000</option>
                                    <option value="1000000-0" {{ request('price_range') == '1000000-0' ? 'selected' : '' }}>Más de $1,000,000</option>
                                </select>
                            </div>

                            <!-- Rango de superficie (reemplaza min/max area) -->
                            <div class="option-bar col-xs-12 property-size-range">
                                <select name="size_range" class="form-control search-select">
                                    <option value="any" {{ !request('size_range') || request('size_range') == 'any' ? 'selected' : '' }}>Superficie</option>
                                    <option value="0-50" {{ request('size_range') == '0-50' ? 'selected' : '' }}>Hasta 50 m²</option>
                                    <option value="50-100" {{ request('size_range') == '50-100' ? 'selected' : '' }}>50 - 100 m²</option>
                                    <option value="100-150" {{ request('size_range') == '100-150' ? 'selected' : '' }}>100 - 150 m²</option>
                                    <option value="150-200" {{ request('size_range') == '150-200' ? 'selected' : '' }}>150 - 200 m²</option>
                                    <option value="200-300" {{ request('size_range') == '200-300' ? 'selected' : '' }}>200 - 300 m²</option>
                                    <option value="300-500" {{ request('size_range') == '300-500' ? 'selected' : '' }}>300 - 500 m²</option>
                                    <option value="500-0" {{ request('size_range') == '500-0' ? 'selected' : '' }}>Más de 500 m²</option>
                                </select>
                            </div>

                            <!-- Antigüedad (nuevo) -->
                            <div class="option-bar col-xs-12 property-age">
                                <select name="property_age" class="form-control search-select">
                                    <option value="any" {{ !request('property_age') || request('property_age') == 'any' ? 'selected' : '' }}>Antigüedad</option>
                                    <option value="new" {{ request('property_age') == 'new' ? 'selected' : '' }}>A estrenar</option>
                                    <option value="less-than-5" {{ request('property_age') == 'less-than-5' ? 'selected' : '' }}>Menos de 5 años</option>
                                    <option value="5-to-10" {{ request('property_age') == '5-to-10' ? 'selected' : '' }}>Entre 5 y 10 años</option>
                                    <option value="10-to-20" {{ request('property_age') == '10-to-20' ? 'selected' : '' }}>Entre 10 y 20 años</option>
                                    <option value="more-than-20" {{ request('property_age') == 'more-than-20' ? 'selected' : '' }}>Más de 20 años</option>
                                </select>
                            </div>

                            <!-- Propiedades destacadas o en demanda (nuevo) -->
                            <div class="option-bar col-xs-12 property-featured">
                                <select name="featured" class="form-control search-select">
                                    <option value="any" {{ !request('featured') || request('featured') == 'any' ? 'selected' : '' }}>Tipo de listado</option>
                                    <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Propiedades destacadas</option>
                                    <option value="hot" {{ request('featured') == 'hot' ? 'selected' : '' }}>Propiedades en demanda</option>
                                </select>
                            </div>

                            <!-- Mantener compatibilidad con min/max price y min/max area -->
                            <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                            <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                            <input type="hidden" name="min_area" value="{{ request('min_area') }}">
                            <input type="hidden" name="max_area" value="{{ request('max_area') }}">

                            <!-- Botón de búsqueda -->
                            <div class="option-bar col-xs-12 submit-btn-wrappe">
                                <input type="submit" value="Buscar" class="form-submit-btn">
                            </div>
                        </div>
                        <!-- .field-wrap -->

                        <!-- Características adicionales (amenidades) -->
                        <div class="extra-search-fields">
                            <h5 class="title">
                                <span class="text-wrapper">Características adicionales</span>
                            </h5>
                            <ul class="features-checkboxes-wrapper list-unstyled clearfix">
                                @foreach($amenities as $amenity)
                                    <li>
                                <span class="option-set">
                                    <input type="checkbox"
                                           name="amenities[]"
                                           id="feature-{{ $amenity->id }}"
                                           value="{{ $amenity->id }}"
                                           {{ in_array($amenity->id, (array)request('amenities')) ? 'checked' : '' }}>
                                    <label for="feature-{{ $amenity->id }}">
                                        {{ $amenity->name }}
                                    </label>
                                </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- .extra-search-fields -->
                    </form>
                    <!-- .advance-search-form -->
                </section>

                <!-- Propiedades destacadas -->
                <section class="widget widget-featured-properties">
                    <h3 class="advance-search-widget-title" style="line-height: 35px; padding-left: 5px; height: 35px">Propiedades Destacadas</h3>
                    <ul class="widget-featured-properties">
                        @forelse($featuredProperties as $property)
                            <li>
                                <figure class="featured-properties-thumbnail">
                            <span class="price">
                                {{ $property->currency }} {{ number_format($property->lowest_price, 2) }}
                                @if($property->serviceType)
                                    {{ $property->serviceType->name }}
                                @endif
                            </span>
                                    <a href="{{ route('frontend.properties.show', $property->slug) }}">
                                        @if($property->images->first())
                                            <img class="img-responsive"
                                                 src="{{ asset($property->images->first()->name) }}"
                                                 alt="{{ $property->name }}">
                                        @else
                                            <img class="img-responsive"
                                                 src="{{ asset('images/no-image.jpg') }}"
                                                 alt="No image available">
                                        @endif
                                    </a>
                                </figure>
                                <h4 class="featured-properties-title">
                                    <a href="{{ route('frontend.properties.show', $property->slug) }}">
                                        {{ $property->name }}
                                    </a>
                                </h4>
                                <p>
                                    {{ Str::limit($property->short_description, 100) }}
                                    <a href="{{ route('frontend.properties.show', $property->slug) }}"
                                       class="read-more-link">
                                        Saber más
                                    </a>
                                </p>
                            </li>
                        @empty
                            <li>No hay propiedades destacadas disponibles</li>
                        @endforelse
                    </ul>
                </section>
            </aside>
            <!-- .sidebar -->
        </div>
        <!-- .site-sidebar-content -->
    </div>
</x-frontend-layout>
