<section class="advance-search main-advance-search">
    <div class="container">
{{--        <h3 class="ssearch-title">Búsqueda</h3>--}}

        <form class="advance-search-form" action="{{ route('frontend.properties.search') }}" method="get">
            <!-- Campos principales en grid -->
            <div class="search-fields-grid">
                <div class="option-bar property-location">
                    <select name="location" id="location" class="search-select">
                        <option value="any" {{ !request('location') || request('location') == 'any' ? 'selected' : '' }}>Ciudad</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ request('location') == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="option-bar property-type">
                    <select name="type" id="select-property-type" class="search-select">
                        <option value="any" selected="selected">Tipo de inmueble</option>
                        @foreach($propertyTypes as $propertyType)
                            <option value="{{ $propertyType->id }}">{{ $propertyType->type_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="option-bar property-status">
                    <select name="status" id="select-status" class="search-select">
                        <option value="any" selected="selected">Tipo de transacción</option>
                        @foreach($serviceTypes as $serviceType)
                            <option value="{{ $serviceType->id }}">{{ $serviceType->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="option-bar property-neighborhood">
                    <div class="neighborhood-dropdown" id="neighborhood-dropdown">
                        <button type="button" class="neighborhood-toggle" id="neighborhood-toggle">
                            <span id="neighborhood-label">Zona</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
                                <path fill="currentColor" d="M6 9L1 4h10z"/>
                            </svg>
                        </button>
                        <div class="neighborhood-options" id="neighborhood-options">
                            <div class="neighborhood-search">
                                <input type="text" id="neighborhood-search-input" placeholder="Buscar zona...">
                            </div>
                            <div class="neighborhood-list">
                                <label class="neighborhood-item" data-city="any">
                                    <input type="radio"
                                           name="neighborhood_id"
                                           value="any"
                                        {{ !request('neighborhood_id') || request('neighborhood_id') == 'any' ? 'checked' : '' }}>
                                    <span>Todas las zonas</span>
                                </label>
                                @foreach($neighborhoods as $neighborhood)
                                    <label class="neighborhood-item" data-city="{{ $neighborhood->city_id }}">
                                        <input type="radio"
                                               name="neighborhood_id"
                                               value="{{ $neighborhood->id }}"
                                            {{ request('neighborhood_id') == $neighborhood->id ? 'checked' : '' }}>
                                        <span>{{ $neighborhood->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Área de botones centrada -->
            <div class="search-buttons-area">
                <button type="button" class="more-options-btn" id="toggle-more-options" title="Más opciones">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 20 20">
                        <path fill="white" d="M10 0c.553 0 1 .447 1 1v8h8c.553 0 1 .447 1 1s-.447 1-1 1h-8v8c0 .553-.447 1-1 1s-1-.447-1-1v-8H1c-.553 0-1-.447-1-1s.447-1 1-1h8V1c0-.553.447-1 1-1z"/>
                    </svg>
                </button>

                <input type="submit" value="Buscar" class="form-submit-btn">
            </div>

            <!-- Opciones adicionales -->
            <div class="extra-search-fields" id="more-options">
                <div class="hidden-options-grid">
                    <div class="hidden-option-item">
                        <select name="bedrooms" id="select-bedrooms">
                            <option value="any" selected="selected">Dormitorios mínimos</option>
                            <option value="1">1 dormitorio</option>
                            <option value="2">2 dormitorios</option>
                            <option value="3">3 dormitorios</option>
                            <option value="4">4 dormitorios</option>
                            <option value="5">5 dormitorios</option>
                            <option value="6">6+ dormitorios</option>
                        </select>
                    </div>

                    <div class="hidden-option-item">
                        <select name="bathrooms" id="select-bathrooms">
                            <option value="any" selected="selected">Baños mínimos</option>
                            <option value="1">1 baño</option>
                            <option value="2">2 baños</option>
                            <option value="3">3 baños</option>
                            <option value="4">4 baños</option>
                            <option value="5">5+ baños</option>
                        </select>
                    </div>

                    <div class="hidden-option-item">
                        <select name="min-price" id="select-min-price">
                            <option value="any" selected="selected">Precio mínimo</option>
                            <option value="10000">$10,000</option>
                            <option value="25000">$25,000</option>
                            <option value="50000">$50,000</option>
                            <option value="75000">$75,000</option>
                            <option value="100000">$100,000</option>
                            <option value="150000">$150,000</option>
                            <option value="200000">$200,000</option>
                            <option value="300000">$300,000</option>
                            <option value="500000">$500,000</option>
                            <option value="750000">$750,000</option>
                            <option value="1000000">$1,000,000</option>
                        </select>
                    </div>

                    <div class="hidden-option-item">
                        <select name="max-price" id="select-max-price">
                            <option value="any" selected="selected">Precio máximo</option>
                            <option value="25000">$25,000</option>
                            <option value="50000">$50,000</option>
                            <option value="75000">$75,000</option>
                            <option value="100000">$100,000</option>
                            <option value="150000">$150,000</option>
                            <option value="200000">$200,000</option>
                            <option value="300000">$300,000</option>
                            <option value="500000">$500,000</option>
                            <option value="750000">$750,000</option>
                            <option value="1000000">$1,000,000</option>
                            <option value="2000000">$2,000,000+</option>
                        </select>
                    </div>

                    <div class="hidden-option-item">
                        <input type="text" name="property-id" id="property-id-txt" placeholder="ID específico de propiedad">
                    </div>

                    <div class="hidden-option-item">
                        <input type="number" name="min-area" id="min-area" placeholder="Área mínima (m²)" min="1">
                    </div>

                    <div class="hidden-option-item">
                        <input type="number" name="max-area" id="max-area" placeholder="Área máxima (m²)" min="1">
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
