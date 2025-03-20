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
                                <span
                                    class="price">{{ $property->currency }} {{ number_format($property->max_price, 2) }} </span>
                            </div>
                            <div class="gallery-slider-two flexslider">
                                <ul class="slides">
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
                                                                 style="height: 300px;"
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
                                                     src="{{ $property->thumbnail ? asset('storage/' .  $property->thumbnail) : asset('assets/front/images/property/property-12-660x600.jpg') }}"
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
                                <div class="meta-item">
                                    <i class="meta-item-icon icon-area">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30"
                                             height="30" viewBox="0 0 48 48">
                                            <path class="meta-icon" fill="#0DBAE8"
                                                  d="M46 16v-12c0-1.104-.896-2.001-2-2.001h-12c0-1.103-.896-1.999-2.002-1.999h-11.997c-1.105 0-2.001.896-2.001 1.999h-12c-1.104 0-2 .897-2 2.001v12c-1.104 0-2 .896-2 2v11.999c0 1.104.896 2 2 2v12.001c0 1.104.896 2 2 2h12c0 1.104.896 2 2.001 2h11.997c1.106 0 2.002-.896 2.002-2h12c1.104 0 2-.896 2-2v-12.001c1.104 0 2-.896 2-2v-11.999c0-1.104-.896-2-2-2zm-4.002 23.998c0 1.105-.895 2.002-2 2.002h-31.998c-1.105 0-2-.896-2-2.002v-31.999c0-1.104.895-1.999 2-1.999h31.998c1.105 0 2 .895 2 1.999v31.999zm-5.623-28.908c-.123-.051-.256-.078-.387-.078h-11.39c-.563 0-1.019.453-1.019 1.016 0 .562.456 1.017 1.019 1.017h8.935l-20.5 20.473v-8.926c0-.562-.455-1.017-1.018-1.017-.564 0-1.02.455-1.02 1.017v11.381c0 .562.455 1.016 1.02 1.016h11.39c.562 0 1.017-.454 1.017-1.016 0-.563-.455-1.019-1.017-1.019h-8.933l20.499-20.471v8.924c0 .563.452 1.018 1.018 1.018.561 0 1.016-.455 1.016-1.018v-11.379c0-.132-.025-.264-.076-.387-.107-.249-.304-.448-.554-.551z"/>
                                        </svg>
                                    </i>
                                    <div class="meta-inner-wrapper">
                                        <span class="meta-item-label">Superficie</span>
                                        <span class="meta-item-value">{{ $property->size }} <sub class="meta-item-unit">m²</sub></span>
                                    </div>
                                </div>
                                <div class="meta-item">
                                    <i class="meta-item-icon icon-bed">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30"
                                             height="30" viewBox="0 0 48 48">
                                            <path class="meta-icon" fill="#0DBAE8"
                                                  d="M21 48.001h-19c-1.104 0-2-.896-2-2v-31c0-1.104.896-2 2-2h19c1.106 0 2 .896 2 2v31c0 1.104-.895 2-2 2zm0-37.001h-19c-1.104 0-2-.895-2-1.999v-7.001c0-1.104.896-2 2-2h19c1.106 0 2 .896 2 2v7.001c0 1.104-.895 1.999-2 1.999zm25 37.001h-19c-1.104 0-2-.896-2-2v-31c0-1.104.896-2 2-2h19c1.104 0 2 .896 2 2v31c0 1.104-.896 2-2 2zm0-37.001h-19c-1.104 0-2-.895-2-1.999v-7.001c0-1.104.896-2 2-2h19c1.104 0 2 .896 2 2v7.001c0 1.104-.896 1.999-2 1.999z"/>
                                        </svg>
                                    </i>
                                    <div class="meta-inner-wrapper">
                                        <span class="meta-item-label">Dormitorios</span>
                                        <span class="meta-item-value">{{ $property->bedrooms }}</span>
                                    </div>
                                </div>
                                <div class="meta-item">
                                    <i class="meta-item-icon icon-bath">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30"
                                             height="30" viewBox="0 0 48 48">
                                            <path class="meta-icon" fill="#0DBAE8"
                                                  d="M37.003 48.016h-4v-3.002h-18v3.002h-4.001v-3.699c-4.66-1.65-8.002-6.083-8.002-11.305v-4.003h-3v-3h48.006v3h-3.001v4.003c0 5.223-3.343 9.655-8.002 11.305v3.699zm-30.002-24.008h-4.001v-17.005s0-7.003 8.001-7.003h1.004c.236 0 7.995.061 7.995 8.003l5.001 4h-14l5-4-.001.01.001-.009s.938-4.001-3.999-4.001h-1s-4 0-4 3v17.005000000000003h-.001z"/>
                                        </svg>
                                    </i>
                                    <div class="meta-inner-wrapper">
                                        <span class="meta-item-label">Banos</span>
                                        <span class="meta-item-value">{{ $property->bathrooms }}</span>
                                    </div>
                                </div>
                                <div class="meta-item">
                                    <i class="meta-item-icon icon-garage">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30"
                                             height="30" viewBox="0 0 48 48">
                                            <path class="meta-icon" fill="#0DBAE8"
                                                  d="M44 0h-40c-2.21 0-4 1.791-4 4v44h6v-40c0-1.106.895-2 2-2h31.999c1.106 0 2.001.895 2.001 2v40h6v-44c0-2.209-1.792-4-4-4zm-36 8.001h31.999v2.999h-31.999zm0 18h6v5.999h-2c-1.104 0-2 .896-2 2.001v6.001c0 1.103.896 1.998 2 1.998h2v2.001c0 1.104.896 2 2 2s2-.896 2-2v-2.001h11.999v2.001c0 1.104.896 2 2.001 2 1.104 0 2-.896 2-2v-2.001h2c1.104 0 2-.895 2-1.998v-6.001c0-1.105-.896-2.001-2-2.001h-2v-5.999h5.999v-3h-31.999v3zm8 12.999c-1.104 0-2-.895-2-1.999s.896-2 2-2 2 .896 2 2-.896 1.999-2 1.999zm10.5 2h-5c-.276 0-.5-.225-.5-.5 0-.273.224-.498.5-.498h5c.275 0 .5.225.5.498 0 .275-.225.5-.5.5zm1-2h-7c-.275 0-.5-.225-.5-.5s.226-.499.5-.499h7c.275 0 .5.224.5.499s-.225.5-.5.5zm-6.5-2.499c0-.276.224-.5.5-.5h5c.275 0 .5.224.5.5s-.225.5-.5.5h-5c-.277 0-.5-.224-.5-.5zm11 2.499c-1.104 0-2.001-.895-2.001-1.999s.896-2 2.001-2c1.104 0 2 .896 2 2s-.896 1.999-2 1.999zm0-12.999v5.999h-16v-5.999h16zm-24-13.001h31.999v3h-31.999zm0 5h31.999v3h-31.999z"/>
                                        </svg>
                                    </i>
                                    <div class="meta-inner-wrapper">
                                        <span class="meta-item-label">Garajes</span>
                                        <span class="meta-item-value">{{ $property->garage }}</span>
                                    </div>
                                </div>
                                <div class="meta-item">
                                    <i class="meta-item-icon icon-ptype">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30"
                                             height="30" viewBox="0 0 48 48">
                                            <path class="meta-icon" fill-rule="evenodd" clip-rule="evenodd"
                                                  fill="#0DBAE8"
                                                  d="M24 48.001c-13.255 0-24-10.745-24-24.001 0-13.254 10.745-24 24-24s24 10.746 24 24c0 13.256-10.745 24.001-24 24.001zm10-27.001l-10-8-10 8v11c0 1.03.888 2.001 2 2.001h3.999v-9h8.001v9h4c1.111 0 2-.839 2-2.001v-11z"/>
                                        </svg>
                                    </i>
                                    <div class="meta-inner-wrapper">
                                        <span class="meta-item-label">Tipo</span>
                                        <span class="meta-item-value">{{ $property->propertyType->type_name }}</span>
                                    </div>
                                </div>
                                <div class="meta-item">
                                    <i class="meta-item-icon icon-tag">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30"
                                             height="30" viewBox="0 0 48 48">
                                            <path class="meta-icon" fill-rule="evenodd" clip-rule="evenodd"
                                                  fill="#0DBAE8"
                                                  d="M47.199 24.176l-23.552-23.392c-.504-.502-1.174-.778-1.897-.778l-19.087.09c-.236.003-.469.038-.696.1l-.251.1-.166.069c-.319.152-.564.321-.766.529-.497.502-.781 1.196-.778 1.907l.092 19.124c.003.711.283 1.385.795 1.901l23.549 23.389c.221.218.482.393.779.523l.224.092c.26.092.519.145.78.155l.121.009h.012c.239-.003.476-.037.693-.098l.195-.076.2-.084c.315-.145.573-.319.791-.539l18.976-19.214c.507-.511.785-1.188.781-1.908-.003-.72-.287-1.394-.795-1.899zm-35.198-9.17c-1.657 0-3-1.345-3-3 0-1.657 1.343-3 3-3 1.656 0 2.999 1.343 2.999 3 0 1.656-1.343 3-2.999 3z"/>
                                        </svg>
                                    </i>
                                    <div class="meta-inner-wrapper">
                                        <span class="meta-item-label">Transaccion</span>
                                        <span class="meta-item-value">{{ $property->serviceType->name }}</span>
                                    </div>

                                </div>
                                <p class="description">{{ Str::limit($property->short_description, 150) }}</p>
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
                            <div class="option-bar col-xs-12 property-location">
                                <select name="location" class="form-control search-select">
                                    <option value="">Cualquier ubicación</option>
                                    @foreach($cities as $city)
                                        <option
                                            value="{{ $city->id }}" {{ request('location') == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="option-bar col-xs-12 property-type">
                                <select name="type" class="form-control search-select">
                                    <option value="">Cualquier tipo</option>
                                    @foreach($propertyTypes as $type)
                                        <option
                                            value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                                            {{ $type->type_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="option-bar col-xs-12 property-status">
                                <select name="status" class="form-control search-select">
                                    <option value="">Cualquier tipo</option>
                                    @foreach($serviceTypes as $type2)
                                        <option
                                            value="{{ $type2->id }}" {{ request('status') == $type2->id ? 'selected' : '' }}>
                                            {{ $type2->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="option-bar col-xs-12 property-keyword">
                                <input type="text" name="keyword" id="keyword-txt"
                                       value="{{ request('keyword') }}"
                                       placeholder="Palabra clave (ej: nombre, dirección)">
                            </div>
                            <div class="option-bar col-xs-12 property-id">
                                <input type="text" name="property_id" id="property-id-txt"
                                       value="{{ request('property_id') }}"
                                       placeholder="Código de propiedad">
                            </div>
                            <div class="option-bar col-xs-12 property-bedrooms">
                                <select name="bedrooms" id="select-bedrooms" class="search-select">
                                    <option value="">Dormitorios (Mínimo)</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ request('bedrooms') == $i ? 'selected' : '' }}>
                                            {{ $i }} {{ $i == 1 ? 'dormitorio' : 'dormitorios' }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="option-bar col-xs-12 property-bathrooms">
                                <select name="bathrooms" id="select-bathrooms" class="search-select">
                                    <option value="">Baños (Mínimo)</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ request('bathrooms') == $i ? 'selected' : '' }}>
                                            {{ $i }} {{ $i == 1 ? 'baño' : 'baños' }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="option-bar col-xs-12 property-min-price">
                                <select name="min_price" id="select-min-price" class="search-select">
                                    <option value="">Precio mínimo</option>
                                    @foreach([1000, 5000, 10000, 50000, 100000, 200000, 300000, 400000, 500000,
                                             600000, 700000, 800000, 900000, 1000000, 1500000, 2000000, 2500000, 5000000] as $price)
                                        <option
                                            value="{{ $price }}" {{ request('min_price') == $price ? 'selected' : '' }}>
                                            {{ number_format($price, 0) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="option-bar col-xs-12 property-max-price">
                                <select name="max_price" id="select-max-price" class="search-select">
                                    <option value="">Precio máximo</option>
                                    @foreach([5000, 10000, 50000, 100000, 200000, 300000, 400000, 500000,
                                             600000, 700000, 800000, 900000, 1000000, 1500000, 2000000, 2500000, 5000000, 10000000] as $price)
                                        <option
                                            value="{{ $price }}" {{ request('max_price') == $price ? 'selected' : '' }}>
                                            {{ number_format($price, 0) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="option-bar col-xs-12 property-min-area">
                                <input type="text" name="min_area" id="min-area"
                                       value="{{ request('min_area') }}"
                                       pattern="[0-9]+"
                                       placeholder="Área mínima (m²)"
                                       title="Por favor, ingrese solo números">
                            </div>
                            <div class="option-bar col-xs-12 property-max-area">
                                <input type="text" name="max_area" id="max-area"
                                       value="{{ request('max_area') }}"
                                       pattern="[0-9]+"
                                       placeholder="Área máxima (m²)"
                                       title="Por favor, ingrese solo números">
                            </div>
                            <div class="option-bar col-xs-12 submit-btn-wrappe">
                                <input type="submit" value="Buscar" class="form-submit-btn">
                            </div>
                        </div>
                        <!-- .field-wrap -->
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
                <section class="widget widget-featured-properties">
                    <h3 class="widget-title">Propiedades Destacadas</h3>
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
