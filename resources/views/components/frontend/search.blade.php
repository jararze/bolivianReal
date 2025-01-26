<section class="advance-search main-advance-search">
    <div class="container">
        <h3 class="search-title">Busqueda</h3>
        <form class="advance-search-form" action="#" method="get">
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
                <h5 class="title"><span class="text-wrapper">Buscando características específicas</span></h5>
                <ul class="features-checkboxes-wrapper list-unstyled clearfix">
                    <li><span class="option-set"><input type="checkbox" name="features[]" id="feature-2-stories" value="2-stories"><label for="feature-2-stories">2 Pisos<small>(6)</small></label></span></li>
                    <li><span class="option-set"><input type="checkbox" name="features[]" id="feature-26-ceilings" value="26-ceilings"><label for="feature-26-ceilings">Techos de 26'<small>(1)</small></label></span></li>
                    <li><span class="option-set"><input type="checkbox" name="features[]" id="feature-bike-path" value="bike-path"><label for="feature-bike-path">Ciclovía<small>(1)</small></label></span></li>
                    <li><span class="option-set"><input type="checkbox" name="features[]" id="feature-central-cooling" value="central-cooling"><label for="feature-central-cooling">Aire Acondicionado Central<small>(4)</small></label></span></li>
                    <li><span class="option-set"><input type="checkbox" name="features[]" id="feature-central-heating" value="central-heating"><label for="feature-central-heating">Calefacción Central<small>(3)</small></label></span></li>
                    <li><span class="option-set"><input type="checkbox" name="features[]" id="feature-dual-sinks" value="dual-sinks"><label for="feature-dual-sinks">Lavabos Dobles<small>(5)</small></label></span></li>
                    <li><span class="option-set"><input type="checkbox" name="features[]" id="feature-electric-range" value="electric-range"><label for="feature-electric-range">Estufa Eléctrica<small>(5)</small></label></span></li>
                    <li><span class="option-set"><input type="checkbox" name="features[]" id="feature-emergency-exit" value="emergency-exit"><label for="feature-emergency-exit">Salida de Emergencia<small>(2)</small></label></span></li>
                    <li><span class="option-set"><input type="checkbox" name="features[]" id="feature-fire-alarm" value="fire-alarm"><label for="feature-fire-alarm">Alarma de Incendio<small>(3)</small></label></span></li>
                    <li><span class="option-set"><input type="checkbox" name="features[]" id="feature-fire-place" value="fire-place"><label for="feature-fire-place">Chimenea<small>(4)</small></label></span></li>
                    <li><span class="option-set"><input type="checkbox" name="features[]" id="feature-home-theater" value="home-theater"><label for="feature-home-theater">Cine en Casa<small>(3)</small></label></span></li>
                    <li><span class="option-set"><input type="checkbox" name="features[]" id="feature-hurricane-shutters" value="hurricane-shutters"><label for="feature-hurricane-shutters">Persianas Anti-Huracanes<small>(1)</small></label></span></li>
                    <li><span class="option-set"><input type="checkbox" name="features[]" id="feature-jog-path" value="jog-path"><label for="feature-jog-path">Pista para Correr<small>(1)</small></label></span></li>
                    <li><span class="option-set"><input type="checkbox" name="features[]" id="feature-laundry-room" value="laundry-room"><label for="feature-laundry-room">Cuarto de Lavado<small>(3)</small></label></span></li>
                    <li><span class="option-set"><input type="checkbox" name="features[]" id="feature-lawn" value="lawn"><label for="feature-lawn">Césped<small>(5)</small></label></span></li>
                    <li><span class="option-set"><input type="checkbox" name="features[]" id="feature-marble-floors" value="marble-floors"><label for="feature-marble-floors">Pisos de Mármol<small>(5)</small></label></span></li>
                    <li><span class="option-set"><input type="checkbox" name="features[]" id="feature-next-to-busy-way" value="next-to-busy-way"><label for="feature-next-to-busy-way">Junto a Vía Principal<small>(1)</small></label></span></li>
                    <li><span class="option-set"><input type="checkbox" name="features[]" id="feature-swimming-pool" value="swimming-pool"><label for="feature-swimming-pool">Piscina<small>(4)</small></label></span></li>
                </ul>
            </div>
            <!-- .extra-search-fields -->
        </form>
        <!-- .advance-search-form -->
    </div>
    <!-- .container -->
</section>
