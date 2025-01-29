<section class="advance-search main-advance-search" >
    <div class="container">
        <h3 class="search-title">Busqueda</h3>
        <form class="advance-search-form" action="{{ route('frontend.properties.search') }}" method="get">
            <div class="option-bar property-location">
                <select name="location" id="location" class="search-select">
                    <option value="any">Ubicación (Cualquiera)</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="option-bar property-type">
                <select name="type" id="select-property-type" class="search-select">
                    <option value="any" selected="selected">Tipo de inmueble (Cualquiera)</option>
                    @foreach($propertyTypes as $propertyType)
                        <option value="{{ $propertyType->id }}">{{ $propertyType->type_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="option-bar property-status">
                <select name="status" id="select-status" class="search-select">
                    <option value="any" selected="selected">Tipo de transaccion (Cualquiera)</option>
                    @foreach($serviceTypes as $serviceType)
                        <option value="{{ $serviceType->id }}">{{ $serviceType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="option-bar property-keyword">
                <input type="text" name="keyword" id="keyword-txt" value="" placeholder="Zona">
            </div>
            <div class="option-bar form-control-buttons">
                <input type="submit" value="Buscar" class="form-submit-btn">
            </div>
            <div class="extra-search-fields">
                <h5 class="title"><span class="text-wrapper">Características específicas</span></h5>
                <ul class="features-checkboxes-wrapper list-unstyled clearfix">
                    @foreach($amenities as $amenity)
                        <li>
                <span class="option-set">
                    <input type="checkbox"
                           name="features[]"
                           id="feature-{{ $amenity->id }}"
                           value="{{ $amenity->id }}"
                           {{ in_array($amenity->id, request('features', [])) ? 'checked' : '' }}>
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
    </div>
    <!-- .container -->
</section>
