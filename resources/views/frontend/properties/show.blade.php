@push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDAX9rEY00ajicFc0JZbwK4i-3HOQMBV78"></script>
    <script>
        function initialize() {
            const myLatlng = new google.maps.LatLng({{ $property->latitude }}, {{ $property->longitude }});
            const mapCanvas = document.getElementById('property-map');
            const mapOptions = {
                center: myLatlng,
                zoom: 15,
                zoomControl: true,
                panControl: false,
                mapTypeControl: true,
                scrollwheel: false,
                styles: [
                    {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [{"color": "#e9e9e9"}, {"lightness": 17}]
                    },
                    {
                        "featureType": "landscape",
                        "elementType": "geometry",
                        "stylers": [{"color": "#f5f5f5"}, {"lightness": 20}]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "geometry.fill",
                        "stylers": [{"color": "#ffffff"}, {"lightness": 17}]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "geometry.stroke",
                        "stylers": [{"color": "#ffffff"}, {"lightness": 29}, {"weight": 0.2}]
                    },
                    {
                        "featureType": "road.arterial",
                        "elementType": "geometry",
                        "stylers": [{"color": "#ffffff"}, {"lightness": 18}]
                    },
                    {
                        "featureType": "road.local",
                        "elementType": "geometry",
                        "stylers": [{"color": "#ffffff"}, {"lightness": 16}]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "geometry",
                        "stylers": [{"color": "#f5f5f5"}, {"lightness": 21}]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "geometry",
                        "stylers": [{"color": "#dedede"}, {"lightness": 21}]
                    },
                    {
                        "elementType": "labels.text.stroke",
                        "stylers": [{"visibility": "on"}, {"color": "#ffffff"}, {"lightness": 16}]
                    },
                    {
                        "elementType": "labels.text.fill",
                        "stylers": [{"saturation": 36}, {"color": "#333333"}, {"lightness": 40}]
                    },
                    {
                        "elementType": "labels.icon",
                        "stylers": [{"visibility": "off"}]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "geometry",
                        "stylers": [{"color": "#f2f2f2"}, {"lightness": 19}]
                    },
                    {
                        "featureType": "administrative",
                        "elementType": "geometry.fill",
                        "stylers": [{"color": "#fefefe"}, {"lightness": 20}]
                    },
                    {
                        "featureType": "administrative",
                        "elementType": "geometry.stroke",
                        "stylers": [{"color": "#fefefe"}, {"lightness": 17}, {"weight": 1.2}]
                    }
                ]
            };

            const map = new google.maps.Map(mapCanvas, mapOptions);

            // Marker personalizado
            const marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                icon: {
                    url: "{{ asset('assets/front/images/map/single-family-home-map-icon.png') }}",
                    scaledSize: new google.maps.Size(40, 40)
                },
                title: '{{ $property->name }}',
                animation: google.maps.Animation.DROP
            });

            // Agregar lugares cercanos si existen
            @if($property->facilities->count() > 0)
            @foreach($property->facilities as $facility)
            // Aquí deberíamos tener lat/lng para cada facilidad
            // Por ahora, simulamos posiciones relativas
            const facilityLatLng = new google.maps.LatLng(
                {{ $property->latitude }} + (Math.random() - 0.5) * 0.01,
                {{ $property->longitude }} + (Math.random() - 0.5) * 0.01
            );

            new google.maps.Marker({
                position: facilityLatLng,
                map: map,
                icon: {
                    url: "{{ asset('assets/front/images/map/facility-icon.png') }}", // Deberías crear estos iconos
                    scaledSize: new google.maps.Size(24, 24)
                },
                title: '{{ $facility->name }}'
            });
            @endforeach
            @endif

            // Info window para el marker principal
            const contentString = `
                <div class="map-info-window" style="width: 250px;">
                    <h5 style="margin-top: 0;">{{ $property->name }}</h5>
                    <p>{{ $property->address }}</p>
                    <p><strong>{{ $property->currency }} {{ number_format($property->lowest_price, 2) }}</strong></p>
                </div>
            `;

            const infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });

            // Abrir info window por defecto
            infowindow.open(map, marker);
        }

        // Inicializar mapa al cargar la página
        google.maps.event.addDomListener(window, 'load', initialize);

        // Inicializar pestañas
        $(document).ready(function() {
            // Activar la primera pestaña
            $('#propertyTabs a:first').tab('show');

            // Galería mejorada
            $('.property-gallery').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
            });

            // Animar contadores de características
            $('.count-number').each(function() {
                $(this).prop('Counter', 0).animate({
                    Counter: $(this).text()
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function(now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            });

            // Scroll suave para las pestañas
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                history.pushState({}, '', e.target.hash);
            });

            if (window.location.hash) {
                $('#propertyTabs a[href="' + window.location.hash + '"]').tab('show');
                $('html, body').animate({
                    scrollTop: $('#propertyTabs').offset().top - 100
                }, 800);
            }

            // Inicializar carrusel de propiedades similares
            $('.similar-properties-carousel .owl-carousel').owlCarousel({
                items: 1,
                loop: true,
                margin: 20,
                nav: true,
                dots: false,
                navText: [
                    '<i class="fa fa-chevron-left"></i>',
                    '<i class="fa fa-chevron-right"></i>'
                ],
                responsive: {
                    0: { items: 1 },
                    768: { items: 2 },
                    992: { items: 1 }
                },
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true
            });

            // Inicializar efecto de zoom en imágenes
            $('.property-image-zoom').zoom({
                magnify: 1.5
            });

            // Botón flotante de contacto
            $('.contact-main-btn').on('click', function() {
                $('.contact-buttons').toggleClass('active');
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Estilos adicionales para la página de propiedades */

        /* Animaciones para elementos */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animated {
            animation-duration: 0.6s;
            animation-fill-mode: both;
        }

        .fadeInUp {
            animation-name: fadeInUp;
        }

        /* Estilos para la galería */
        .property-gallery-wrapper {
            position: relative;
            height: 500px;
            overflow: hidden;
            border-radius: 10px 10px 0 0;
        }

        .property-gallery-wrapper .carousel-item {
            height: 500px;
            background-position: center;
            background-size: cover;
        }

        .property-gallery-wrapper .carousel-item img {
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .property-gallery-wrapper:hover .carousel-item img {
            transform: scale(1.05);
        }

        .carousel-indicators {
            margin-bottom: 20px;
        }

        .carousel-indicators li {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 5px;
            background-color: rgba(255, 255, 255, 0.5);
        }

        .carousel-indicators li.active {
            background-color: #0DBAE8;
        }

        /* Estilos para la tarjeta de propiedad */
        .property-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .property-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .property-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
        }

        .property-price {
            font-size: 22px;
            font-weight: 700;
            color: #0DBAE8;
        }

        .property-location {
            font-size: 14px;
            color: #777;
        }

        /* Estilos para las pestañas */
        .nav-tabs {
            border: none;
            background: #f8f9fa;
            border-radius: 10px 10px 0 0;
            overflow: hidden;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #666;
            font-weight: 500;
            padding: 15px 20px;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            color: #0DBAE8;
            background: #fff;
            border-bottom: 3px solid #0DBAE8;
        }

        .nav-tabs .nav-link:hover:not(.active) {
            background: rgba(13, 186, 232, 0.1);
        }

        /* Estilos para el contenido de las pestañas */
        .tab-content {
            background: #fff;
            border-radius: 0 0 10px 10px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        /* Estilos para los elementos de características */
        .meta-item {
            text-align: center;
            padding: 15px;
            transition: all 0.3s ease;
            border-radius: 10px;
        }

        .meta-item:hover {
            background: #f8f9fa;
            transform: translateY(-5px);
        }

        .meta-item-icon {
            font-size: 32px;
            color: #0DBAE8;
            margin-bottom: 10px;
            display: block;
        }

        .meta-item-label {
            font-size: 13px;
            color: #888;
            margin-bottom: 5px;
        }

        .meta-item-value {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        /* Estilos para las características en la pestaña de detalles */
        .feature-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: #f8f9fa;
            transform: translateX(5px);
        }

        .feature-icon {
            color: #0DBAE8;
            font-size: 18px;
            margin-right: 10px;
        }

        /* Estilos para la tarjeta del agente */
        .agent-card-sticky {
            position: sticky;
            top: 30px;
        }

        .agent-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid #0DBAE8;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .agent-avatar:hover {
            transform: scale(1.05);
        }

        .agent-contact-list li {
            padding: 10px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .agent-contact-list li:hover {
            background: #f8f9fa;
        }

        .agent-social-profiles a {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .agent-social-profiles a:hover {
            background: #0DBAE8;
            color: white;
            border-color: #0DBAE8;
        }

        /* Estilos para los botones flotantes */
        .floating-contact {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 999;
        }

        .contact-main-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #0DBAE8;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .contact-main-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        }

        .contact-buttons {
            position: absolute;
            bottom: 70px;
            right: 5px;
        }

        .contact-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-bottom: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .contact-btn:hover {
            transform: scale(1.1);
        }

        /* Efectos para el tour virtual */
        .property-video-thumbnails .play-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .property-video-thumbnails a {
            position: relative;
            display: block;
        }

        .property-video-thumbnails a:hover .play-overlay {
            opacity: 1;
        }

        .property-video-thumbnails .fa-play-circle {
            font-size: 48px;
            color: white;
        }

        /* Estilos para el mapa */
        .property-map-container {
            height: 450px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        /* Estilos para propiedades similares */
        .similar-property-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .similar-property-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .similar-property-card img {
            height: 180px;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .similar-property-card:hover img {
            transform: scale(1.1);
        }

        /* Calculadora de hipoteca mejorada */
        .mortgage-results {
            animation: fadeInUp 0.5s ease;
        }

        /* Efectos para la calculadora */
        .form-control:focus {
            border-color: #0DBAE8;
            box-shadow: 0 0 0 0.2rem rgba(13, 186, 232, 0.25);
        }

        /* Efectos para los botones */
        .btn-primary {
            background-color: #0DBAE8;
            border-color: #0DBAE8;
        }

        .btn-primary:hover {
            background-color: #0A9BBF;
            border-color: #0A9BBF;
        }

        .btn-outline-primary {
            color: #0DBAE8;
            border-color: #0DBAE8;
        }

        .btn-outline-primary:hover {
            background-color: #0DBAE8;
            color: white;
        }

        /* Media queries para responsividad */
        @media (max-width: 991px) {
            .agent-card-sticky {
                position: relative;
                top: 0;
            }

            .property-gallery-wrapper {
                height: 350px;
            }

            .property-gallery-wrapper .carousel-item {
                height: 350px;
            }

            .meta-item {
                max-width: 50%;
            }
        }

        @media (max-width: 767px) {
            .property-gallery-wrapper {
                height: 280px;
            }

            .property-gallery-wrapper .carousel-item {
                height: 280px;
            }

            .meta-item {
                max-width: 50%;
            }

            .property-header {
                flex-direction: column;
            }

            .property-title {
                font-size: 20px;
            }

            .property-price {
                font-size: 18px;
            }

            .nav-tabs .nav-link {
                padding: 10px 15px;
                font-size: 14px;
            }
        }

        @media (max-width: 575px) {
            .meta-item {
                max-width: 100%;
            }
        }
        /* Estilos generales mejorados */
        .property-page-container {
            background-color: #f8f9fa;
            padding-top: 30px;
            padding-bottom: 60px;
        }

        .property-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .property-card:hover {
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transform: translateY(-5px);
        }

        .fancy-title {
            position: relative;
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 25px;
            padding-bottom: 10px;
            color: #333;
        }

        .fancy-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: #0DBAE8;
        }

        /* Estilo para la galería mejorada */
        .property-gallery-wrapper {
            position: relative;
            height: 450px;
            overflow: hidden;
            border-radius: 10px 10px 0 0;
        }

        /* Mejora de los iconos de metadatos */
        .property-meta.entry-meta {
            display: flex;
            flex-wrap: wrap;
            padding: 20px 0;
        }

        .meta-item {
            flex: 1 0 auto;
            max-width: 33.33%;
            text-align: center;
            padding: 15px 10px;
            transition: all 0.3s ease;
            margin-bottom: 10px;
        }

        .meta-item:hover {
            background-color: #f8f9fa;
            transform: scale(1.05);
        }

        .meta-item-icon {
            display: block;
            margin: 0 auto 10px;
            width: 40px;
            height: 40px;
        }

        .meta-item-label {
            display: block;
            font-size: 12px;
            color: #777;
            margin-bottom: 5px;
        }

        .meta-item-value {
            display: block;
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        /* Estilo para las pestañas */
        .property-tabs {
            margin-top: 30px;
        }

        .nav-tabs {
            border: none;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .nav-tabs .nav-item {
            margin: 0;
        }

        .nav-tabs .nav-link {
            border: none;
            padding: 15px 20px;
            font-weight: 500;
            color: #555;
            border-radius: 0;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            color: #0DBAE8;
            background: #fff;
            box-shadow: 0 -3px 0 #0DBAE8 inset;
        }

        .tab-content {
            background: #fff;
            padding: 30px;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        /* Botones flotantes de contacto */
        .floating-contact {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 999;
        }

        .contact-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #0DBAE8;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .contact-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        /* Tarjeta de agente flotante */
        .agent-card-sticky {
            position: sticky;
            top: 30px;
        }

        /* Mejoras en la sección de propiedades similares */
        .similar-property-card {
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .similar-property-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        /* Mapa mejorado */
        .property-map-container {
            height: 400px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
@endpush
<x-frontend-layout>
    <div class="container property-page-container">
        <!-- Header de la propiedad con breadcrumbs -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('frontend.properties.search') }}">Propiedades</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $property->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Sección principal de la propiedad -->
        <div class="row">
            <!-- Columna izquierda: galería y detalles principales -->
            <div class="col-lg-8">
                <div class="property-card">
                    <!-- Galería principal con indicadores -->
                    <div class="property-gallery-wrapper">
                        <div id="propertyGallery" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach($property->images as $index => $image)
                                    <li data-target="#propertyGallery" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                                @endforeach
                            </ol>
                            <div class="carousel-inner">
                                @foreach($property->images as $index => $image)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <a href="{{ asset('storage/' . $image->path) }}" class="property-gallery">
                                            <img src="{{ asset('storage/' . $image->path) }}" class="d-block w-100 property-image-zoom" alt="Imagen de propiedad">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#propertyGallery" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Anterior</span>
                            </a>
                            <a class="carousel-control-next" href="#propertyGallery" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Siguiente</span>
                            </a>
                        </div>
                    </div>

                    <!-- Header de información básica -->
                    <div class="property-header p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="property-title mb-0">{{ $property->name }}</h1>
                            <div class="property-price">
                                <span class="badge badge-primary p-2">{{ $property->serviceType->name }}</span>
                                <span class="h3 ml-2 text-primary">{{ $property->currency }} {{ number_format($property->lowest_price, 2) }}</span>
                            </div>
                        </div>
                        <p class="property-location mt-2 mb-0">
                            <i class="fa fa-map-marker-alt text-primary mr-2"></i>
                            {{ $property->address }}, {{ $property->neighborhood }}, {{ $property->whatcity?->name ?? 'Sin ciudad' }}
                        </p>
                    </div>

                    <!-- Características principales con iconos modernos -->
                    <div class="property-meta entry-meta clearfix">
                        <div class="meta-item">
                            <i class="meta-item-icon">
                                <i class="fa fa-ruler-combined fa-2x text-primary"></i>
                            </i>
                            <div class="meta-inner-wrapper">
                                <span class="meta-item-label">Área</span>
                                <span class="meta-item-value count-number">{{ $property->size }}</span>
                                <span class="meta-item-unit">m²</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <i class="meta-item-icon">
                                <i class="fa fa-bed fa-2x text-primary"></i>
                            </i>
                            <div class="meta-inner-wrapper">
                                <span class="meta-item-label">Dormitorios</span>
                                <span class="meta-item-value count-number">{{ $property->bedrooms }}</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <i class="meta-item-icon">
                                <i class="fa fa-bath fa-2x text-primary"></i>
                            </i>
                            <div class="meta-inner-wrapper">
                                <span class="meta-item-label">Baños</span>
                                <span class="meta-item-value count-number">{{ $property->bathrooms }}</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <i class="meta-item-icon">
                                <i class="fa fa-car fa-2x text-primary"></i>
                            </i>
                            <div class="meta-inner-wrapper">
                                <span class="meta-item-label">Garajes</span>
                                <span class="meta-item-value count-number">{{ $property->garage }}</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <i class="meta-item-icon">
                                <i class="fa fa-home fa-2x text-primary"></i>
                            </i>
                            <div class="meta-inner-wrapper">
                                <span class="meta-item-label">Tipo</span>
                                <span class="meta-item-value">{{ $property->propertyType->type_name }}</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <i class="meta-item-icon">
                                <i class="fa fa-tag fa-2x text-primary"></i>
                            </i>
                            <div class="meta-inner-wrapper">
                                <span class="meta-item-label">ID</span>
                                <span class="meta-item-value">{{ $property->code }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones rápidas -->
                    <div class="property-actions d-flex justify-content-between p-4 bg-light">
                        <a class="btn btn-outline-primary" href="#" data-toggle="modal">
                            <i class="fa fa-star mr-2"></i>Agregar a favoritos
                        </a>
                        <a class="btn btn-outline-primary" href="javascript:window.print()">
                            <i class="fa fa-print mr-2"></i>Imprimir
                        </a>
                        <a class="btn btn-outline-primary" href="https://wa.me/?text={{ urlencode(url()->current()) }}" target="_blank">
                            <i class="fa fa-share-alt mr-2"></i>Compartir
                        </a>
                    </div>
                </div>

                <!-- Pestañas para información detallada -->
                <div class="property-tabs">
                    <ul class="nav nav-tabs" id="propertyTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">
                                <i class="fa fa-info-circle mr-2"></i>Descripción
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="features-tab" data-toggle="tab" href="#features" role="tab" aria-controls="features" aria-selected="false">
                                <i class="fa fa-list-ul mr-2"></i>Características
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="location-tab" data-toggle="tab" href="#location" role="tab" aria-controls="location" aria-selected="false">
                                <i class="fa fa-map-marker-alt mr-2"></i>Ubicación
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="video-tab" data-toggle="tab" href="#video" role="tab" aria-controls="video" aria-selected="false">
                                <i class="fa fa-video mr-2"></i>Tour Virtual
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="propertyTabsContent">
                        <!-- Pestaña de descripción -->
                        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                            <h4 class="fancy-title">Descripción</h4>
                            <div class="property-content">
                                {!! $property->long_description !!}
                            </div>

                            <div class="property-additional-details mt-5">
                                <h4 class="fancy-title">Información adicional</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-striped">
                                            <tr>
                                                <th>Dirección</th>
                                                <td>{{ $property->address }}</td>
                                            </tr>
                                            <tr>
                                                <th>Ciudad</th>
                                                <td>{{ $property->whatcity?->name ?? 'Sin ciudad' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-striped">
                                            <tr>
                                                <th>País</th>
                                                <td>{{ $property->country ?? 'Sin país' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Zona</th>
                                                <td>{{ $property->neighborhood }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pestaña de características -->
                        <div class="tab-pane fade" id="features" role="tabpanel" aria-labelledby="features-tab">
                            @if($property->amenities->count() > 0)
                                <h4 class="fancy-title">Características/Comodidades</h4>
                                <div class="row">
                                    @foreach($property->amenities as $amenity)
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-check-circle text-success mr-2"></i>
                                                <span>{{ $amenity->name }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if($property->facilities->count() > 0)
                                <h4 class="fancy-title mt-5">¿Qué hay cerca?</h4>
                                <div class="row">
                                    @foreach($property->facilities as $feature)
                                        <div class="col-md-6 mb-3">
                                            <div class="card">
                                                <div class="card-body d-flex align-items-center">
                                                    <i class="fa fa-map-pin text-primary mr-3"></i>
                                                    <div>
                                                        <h5 class="mb-1">{{ $feature->name }}</h5>
                                                        <p class="mb-0 text-muted">{{ $feature->pivot->distance }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Pestaña de ubicación -->
                        <div class="tab-pane fade" id="location" role="tabpanel" aria-labelledby="location-tab">
                            <h4 class="fancy-title">Ubicación</h4>
                            <div class="property-map-container">
                                <div id="property-map" style="height: 100%"></div>
                            </div>

                            <div class="property-location-info mt-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h5 class="card-title"><i class="fa fa-map-marker-alt text-primary mr-2"></i>Dirección</h5>
                                                <p class="card-text">{{ $property->address }}, {{ $property->whatcity?->name ?? 'Sin ciudad' }}, {{ $property->country ?? 'Sin país' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h5 class="card-title"><i class="fa fa-compass text-primary mr-2"></i>Zona</h5>
                                                <p class="card-text">{{ $property->neighborhood }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pestaña de tour virtual -->
                        <div class="tab-pane fade" id="video" role="tabpanel" aria-labelledby="video-tab">
                            <h4 class="fancy-title">Tour Virtual</h4>
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/7CZz_QoWaV4" allowfullscreen></iframe>
                            </div>

                            <div class="property-video-thumbnails mt-4">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <a href="#" class="d-block">
                                            <img src="{{ asset('storage/' . $property->thumbnail) }}" class="img-fluid rounded" alt="Thumbnail">
                                            <div class="play-overlay">
                                                <i class="fa fa-play-circle"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna derecha: información del agente y más detalles -->
            <div class="col-lg-4">
                <!-- Tarjeta del agente -->
                <div class="agent-card-sticky">
                    <div class="property-card mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0"><i class="fa fa-user mr-2"></i>Información del Agente</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <img src="{{ asset('assets/front/images/agente.jpg') }}" class="img-fluid rounded-circle agent-avatar" alt="Agente" style="width: 120px; height: 120px; object-fit: cover;">
                                <h4 class="mt-3 mb-0">Pablo Jordan</h4>
                                <p class="text-muted">Agente Bolivian Real Estate</p>
                            </div>

                            <ul class="list-unstyled agent-contact-list">
                                <li class="d-flex align-items-center mb-3">
                                    <i class="fa fa-phone-alt text-primary mr-3"></i>
                                    <div>
                                        <small class="d-block text-muted">Teléfono</small>
                                        <span>1-234-456-789</span>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center mb-3">
                                    <i class="fa fa-mobile-alt text-primary mr-3"></i>
                                    <div>
                                        <small class="d-block text-muted">Celular</small>
                                        <span>1-222-333-4444</span>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center mb-3">
                                    <i class="fa fa-envelope text-primary mr-3"></i>
                                    <div>
                                        <small class="d-block text-muted">Email</small>
                                        <span>agente@example.com</span>
                                    </div>
                                </li>
                            </ul>

                            <div class="agent-social-profiles mb-4 text-center">
                                <a class="btn btn-outline-primary btn-sm mr-2" target="_blank" href="#"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-outline-primary btn-sm mr-2" target="_blank" href="#"><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-outline-primary btn-sm mr-2" target="_blank" href="#"><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-outline-primary btn-sm" target="_blank" href="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>

                            <div class="contact-agent-form">
                                <h5 class="mb-3">Contactar agente</h5>
                                <form id="agent-contact-form" method="post" action="contact_form_handler.php">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name" placeholder="Nombre" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="tel" class="form-control" name="phone" placeholder="Teléfono">
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="4" name="message" placeholder="Mensaje" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">Enviar Mensaje</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Calculadora de hipoteca -->
                    <div class="property-card mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0"><i class="fa fa-calculator mr-2"></i>Calculadora de Hipoteca</h5>
                        </div>
                        <div class="card-body">
                            <form id="mortgage-calculator">
                                <div class="form-group">
                                    <label for="property-price">Precio de la propiedad</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" class="form-control" id="property-price" value="{{ $property->lowest_price }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="down-payment">Pago inicial</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" class="form-control" id="down-payment" value="{{ round($property->lowest_price * 0.2) }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="interest-rate">Tasa de interés</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="interest-rate" value="5.5" step="0.1">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="loan-term">Plazo del préstamo</label>
                                    <select class="form-control" id="loan-term">
                                        <option value="15">15 años</option>
                                        <option value="20">20 años</option>
                                        <option value="25">25 años</option>
                                        <option value="30" selected>30 años</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-primary btn-block" id="calculate-mortgage">Calcular</button>

                                <div class="mortgage-results mt-4" style="display: none;">
                                    <div class="alert alert-info">
                                        <h6 class="alert-heading">Pago mensual estimado:</h6>
                                        <h4 class="text-center monthly-payment">$0</h4>
                                        <hr>
                                        <div class="row">
                                            <div class="col-6">
                                                <small>Préstamo principal:</small>
                                                <p class="loan-amount">$0</p>
                                            </div>
                                            <div class="col-6">
                                                <small>Total intereses:</small>
                                                <p class="total-interest">$0</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Propiedades similares -->
                    <div class="property-card">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0"><i class="fa fa-home mr-2"></i>Propiedades Similares</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="similar-properties-carousel">
                                <div class="owl-carousel">
                                    <div class="similar-property-card">
                                        <img src="{{ asset('storage/properties/images/img_3P2bdDIpOV.jpg') }}" class="img-fluid" alt="Propiedad similar">
                                        <div class="property-info p-3">
                                            <h5>Single Home at Florida 5, Pinecrest</h5>
                                            <p class="text-primary mb-2">$580,000</p>
                                            <div class="d-flex justify-content-between text-muted">
                                                <small><i class="fa fa-bed mr-1"></i> 4</small>
                                                <small><i class="fa fa-bath mr-1"></i> 4</small>
                                                <small><i class="fa fa-ruler-combined mr-1"></i> 5500 m²</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="similar-property-card">
                                        <img src="{{ asset('storage/properties/images/img_1IbjDev6pH.jpg') }}" class="img-fluid" alt="Propiedad similar">
                                        <div class="property-info p-3">
                                            <h5>Building Having 15 Apartments</h5>
                                            <p class="text-primary mb-2">$6,950,000</p>
                                            <div class="d-flex justify-content-between text-muted">
                                                <small><i class="fa fa-building mr-1"></i> Apartamentos</small>
                                                <small><i class="fa fa-ruler-combined mr-1"></i> 52000 m²</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="similar-property-card">
                                        <img src="{{ asset('storage/properties/images/img_0QcvRjyjLU.jpg') }}" class="img-fluid" alt="Propiedad similar">
                                        <div class="property-info p-3">
                                            <h5>Home in Merrick Way</h5>
                                            <p class="text-primary mb-2">$540,000</p>
                                            <div class="d-flex justify-content-between text-muted">
                                                <small><i class="fa fa-bed mr-1"></i> 3</small>
                                                <small><i class="fa fa-bath mr-1"></i> 3</small>
                                                <small><i class="fa fa-ruler-combined mr-1"></i> 4300 m²</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botones flotantes de contacto -->
    <div class="floating-contact">
        <div class="contact-buttons" style="display: none;">
            <a href="tel:1-222-333-4444" class="contact-btn bg-success">
                <i class="fa fa-phone-alt"></i>
            </a>
            <a href="https://wa.me/12223334444" target="_blank" class="contact-btn" style="background-color: #25D366;">
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
        <div class="contact-main-btn" style="width: 60px; height: 60px; background: #0DBAE8; cursor: pointer;">
            <i class="fa fa-comments fa-lg text-white"></i>
        </div>
    </div>

    <!-- Script para la calculadora de hipoteca -->
    @push('scripts')
        <script>
            $(document).ready(function() {
                // Calculadora de hipoteca
                $('#calculate-mortgage').on('click', function() {
                    var propertyPrice = parseFloat($('#property-price').val());
                    var downPayment = parseFloat($('#down-payment').val());
                    var interestRate = parseFloat($('#interest-rate').val());
                    var loanTerm = parseInt($('#loan-term').val());

                    var loanAmount = propertyPrice - downPayment;
                    var monthlyInterest = interestRate / 100 / 12;
                    var numberOfPayments = loanTerm * 12;

                    var monthlyPayment = loanAmount * monthlyInterest * Math.pow(1 + monthlyInterest, numberOfPayments) /
                        (Math.pow(1 + monthlyInterest, numberOfPayments) - 1);

                    var totalInterest = (monthlyPayment * numberOfPayments) - loanAmount;

                    $('.monthly-payment').text(' + monthlyPayment.toFixed(2));
                    $('.loan-amount').text(' + loanAmount.toFixed(2));
                    $('.total-interest').text(' + totalInterest.toFixed(2));

                    $('.mortgage-results').slideDown();
                });

                // Botones flotantes
                $('.contact-main-btn').on('click', function() {
                    $('.contact-buttons').slideToggle();
                });
            });
        </script>
    @endpush
</x-frontend-layout>
