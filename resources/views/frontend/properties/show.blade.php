@push('scripts')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDAX9rEY00ajicFc0JZbwK4i-3HOQMBV78&callback=initializePropertyMap"></script>
    <script>
        function initializePropertyMap() {
            // Posición exacta de la propiedad (que no se mostrará directamente)
            const exactPosition = {
                lat: {{ $property->latitude }},
                lng: {{ $property->longitude }}
            };

            // Creamos el mapa centrado en la ubicación exacta
            const mapCanvas = document.getElementById('property-map');
            const mapOptions = {
                center: exactPosition,
                zoom: 14,
                zoomControl: true,
                panControl: false,
                mapTypeControl: true,
                scrollwheel: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
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

            // Dibujamos un círculo de 1 km alrededor de la ubicación exacta
            const locationCircle = new google.maps.Circle({
                strokeColor: '#0DBAE8',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#0DBAE8',
                fillOpacity: 0.15,
                map: map,
                center: exactPosition,
                radius: 1000, // 1 km en metros
                clickable: false
            });

            // Info window para el área
            const contentString = `
            <div class="map-info-window" style="width: 250px; padding: 10px;">
                <h5 style="margin-top: 0; color: #0DBAE8;">Zona aproximada</h5>
                <p style="margin-bottom: 5px;">{{ $property->neighborhood }}, {{ $property->whatcity?->name ?? 'Sin ciudad' }}</p>
                <p><strong>{{ $property->currency }} {{ number_format($property->lowest_price, 2) }}</strong></p>
                <p style="font-size: 12px; color: #777;">Contacte con el agente para obtener la ubicación exacta.</p>
            </div>
        `;

            const infowindow = new google.maps.InfoWindow({
                content: contentString,
                position: exactPosition
            });

            // Abrir info window por defecto
            infowindow.open(map);

            // Función para obtener una posición aleatoria dentro de un círculo
            function getRandomPositionInCircle(center, radius) {
                // Elegir un ángulo aleatorio
                const angle = Math.random() * Math.PI * 2;

                // Elegir una distancia aleatoria (distancia al cuadrado para distribución uniforme)
                const distance = Math.sqrt(Math.random()) * radius;

                // Convertir distancia de metros a grados (aproximadamente)
                const latRadians = center.lat * Math.PI / 180;
                const metersPerDegreeLat = 111111; // aproximadamente 111,111 metros por grado de latitud
                const metersPerDegreeLng = 111111 * Math.cos(latRadians); // varía según la latitud

                const latOffset = distance / metersPerDegreeLat;
                const lngOffset = distance / metersPerDegreeLng;

                // Calcular nueva posición usando trigonometría
                return {
                    lat: center.lat + latOffset * Math.cos(angle),
                    lng: center.lng + latOffset * Math.sin(angle)
                };
            }

            // Añadir lugares cercanos relevantes
            @if($property->facilities->count() > 0)
            @foreach($property->facilities as $index => $facility)
            var pos_{{ $index }} = getRandomPositionInCircle(exactPosition, 800);

            new google.maps.Marker({
                position: pos_{{ $index }},
                map: map,
                icon: {
                    url: "{{ asset('assets/front/images/map/marker-blue.png') }}", // Cambia esto a un icono que tengas
                    scaledSize: new google.maps.Size(24, 24)
                },
                title: '{{ $facility->name }}'
            });
            @endforeach
            @endif
        }
    </script>

    <script>
        $(document).ready(function() {
            // Inicializar la funcionalidad de copiar enlace
            $('#copyLinkBtn').on('click', function(e) {
                e.preventDefault();

                // Crear un elemento de texto temporal
                var tempInput = $('<input>');
                $('body').append(tempInput);
                tempInput.val($(this).data('clipboard-text')).select();

                // Copiar el texto al portapapeles
                document.execCommand('copy');

                // Eliminar el elemento temporal
                tempInput.remove();

                // Mostrar mensaje de confirmación
                var originalText = $(this).find('span').text();
                $(this).find('span').text('¡Enlace copiado!');
                $(this).addClass('copied');

                // Restaurar el texto original después de un tiempo
                setTimeout(function() {
                    $('#copyLinkBtn').find('span').text(originalText);
                    $('#copyLinkBtn').removeClass('copied');
                }, 2000);
            });
        });
    </script>
@endpush
@push('styles')
    <style>
        /* Estilos mejorados para página de detalles de propiedad */
        .location-disclaimer {
            margin-bottom: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            border-left: 4px solid #0DBAE8;
        }

        .location-disclaimer-content {
            display: flex;
            align-items: center;
        }

        .location-icon {
            background-color: rgba(13, 186, 232, 0.1);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .location-icon i {
            color: #0DBAE8;
            font-size: 24px;
        }

        .location-text h5 {
            margin-top: 0;
            margin-bottom: 5px;
            color: #333;
            font-weight: 600;
        }

        .location-text p {
            margin-bottom: 0;
            color: #666;
            line-height: 1.5;
            font-size: 14px;
        }
        /* Contenedor principal */

        /* Títulos con estilo */
        .single-property-title {
            /*font-size: 26px;*/
            /*font-weight: 700;*/
            color: #333;
            margin-bottom: 10px;
            position: relative;
            transition: color 0.3s ease;
        }

        .single-property-title:after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 50px;
            height: 3px;
            background: #0DBAE8;
            transition: width 0.3s ease;
        }

        .single-property-title:hover {
            color: #0DBAE8;
        }

        .single-property-title:hover:after {
            width: 100px;
        }

        /* Precio más destacado */
        .single-property-price {
            margin-top: 10px;
            font-weight: 700;
            color: #0DBAE8;
            display: inline-block;
            padding: 8px 15px;
            background-color: rgba(13, 186, 232, 0.1);
            border-radius: 6px;
        }

        /* Mejora para la galería de imágenes */
        .property-slider-wrapper {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        /* Estilos para las características (meta) */
        .property-meta {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-wrap: wrap;
            margin: 20px 0 0 0;
            padding: 0;
        }

        .property-meta .meta-item {
            flex: 1 0 33.333%;
            text-align: center;
            padding: 10px 8px;
            border-right: 1px solid #f0f0f0;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .property-meta .meta-item:hover {
            background-color: #f9f9f9;
            transform: translateY(-5px);
        }

        .property-meta .meta-item-icon {
            margin-bottom: 10px;
            transition: transform 0.3s ease;
        }

        .property-meta .meta-item:hover .meta-item-icon {
            transform: scale(1.1);
        }

        .property-meta .meta-item-label {
            display: block;
            font-size: 9px;
            color: #888;
            margin-bottom: 5px;
        }

        .property-meta .meta-item-value {
            display: block;
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .meta-icon-container {
            margin-bottom: 5px;
        }

        .meta-icon {
            transition: fill 0.3s ease;
        }

        .property-meta .meta-item:hover .meta-icon {
            fill: #0a8bff !important;
        }

        /* Estilo para el contenido principal */
        .property-single-content {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-top: 20px;
        }

        /* Mejora para los títulos de secciones */
        .fancy-title {
            position: relative;
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
            transition: width 0.3s ease;
        }

        .fancy-title:hover:after {
            width: 100px;
        }

         /*Mejora para listas de características*/
        .property-features-list {
            display: flex;
            flex-wrap: wrap;
            padding: 0;
            list-style: none;
        }

        .property-features-list li {
            flex: 0 0 calc(33.333% - 20px);
            margin: 10px;
            padding: 10px 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            transition: all 0.3s ease;
            position: relative;
            padding-left: 30px;
        }

        .property-features-list li:before {
            content: '✓';
            position: absolute;
            left: 10px;
            color: #0DBAE8;
            font-weight: bold;
        }

        .property-features-list li:hover {
            background-color: #e9f7fb;
            transform: translateX(5px);
        }

        /* Mejora para el mapa */
        .property-location-section {
            margin-top: 30px;
        }

        #property-map {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        #property-map:hover {
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        /* Botones para compartir */
        /* Estilos para botones de compartir en redes sociales */
        .property-share-networks {
            margin: 30px 0;
            padding: 25px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
        }

        .social-share-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 20px;
        }

        .social-share-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            border-radius: 30px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            min-width: 130px;
        }

        .social-share-btn i {
            margin-right: 8px;
            font-size: 16px;
        }

        .social-share-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.2);
            text-decoration: none;
            color: white;
        }

        /* Colores específicos para cada red social */
        .facebook-btn {
            background-color: #3b5998;
        }

        .facebook-btn:hover {
            background-color: #2d4373;
        }

        .twitter-btn {
            background-color: #1da1f2;
        }

        .twitter-btn:hover {
            background-color: #0c85d0;
        }

        .linkedin-btn {
            background-color: #0077b5;
        }

        .linkedin-btn:hover {
            background-color: #005e93;
        }

        .pinterest-btn {
            background-color: #bd081c;
        }

        .pinterest-btn:hover {
            background-color: #9e0818;
        }

        .whatsapp-btn {
            background-color: #25D366;
        }

        .whatsapp-btn:hover {
            background-color: #128C7E;
        }

        .email-btn {
            background-color: #848484;
        }

        .email-btn:hover {
            background-color: #6b6b6b;
        }

        .copy-link-btn {
            background-color: #6c757d;
            position: relative;
        }

        .copy-link-btn:hover {
            background-color: #5a6268;
        }

        .copy-link-btn.copied {
            background-color: #28a745;
        }

        /* Estilos mejorados para la sección del agente */
        .agent-sidebar-widget {
            border-radius: 10px;
            position: relative;
            margin-top: 20px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .agent-content-wrapper {
            padding: 25px 15px;
            background: linear-gradient(135deg, #00BCD4 0%, #03A9F4 100%);
            position: relative;
        }

        /* Mejora para la imagen del agente */
        .agent-image {
            text-align: center;
            margin-bottom: 15px;
        }

        .agent-image img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.3);
            object-fit: cover;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .agent-image img:hover {
            transform: scale(1.05);
            border-color: rgba(255, 255, 255, 0.6);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* Estilos para el nombre del agente */
        .agent-name {
            text-align: center;
            margin-bottom: 15px;
        }

        .agent-name a {
            font-size: 22px;
            font-weight: 600;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .agent-name a:hover {
            color: #e6f7ff;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            text-decoration: none;
        }

        .agent-name span {
            display: block;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.85);
            margin-top: 5px;
        }

        /* Redes sociales con mejor diseño */
        .agent-social-profiles {
            display: flex;
            justify-content: center;
            margin: 0 0 20px;
        }

        .agent-social-profiles a {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 6px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.15);
            color: #fff;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .agent-social-profiles a:hover {
            background-color: #fff;
            color: #03A9F4;
            transform: translateY(-3px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        /* Lista de contactos mejorada */
        .agent-contacts-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .agent-contacts-list li {
            padding: 12px 5px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }

        .agent-contacts-list li:last-child {
            border-bottom: none;
        }

        .agent-contacts-list li:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .contacts-icon-container {
            margin-right: 10px;
            opacity: 0.9;
        }

        .contacts-icon {
            fill: #fff;
        }

        .agent-contacts-list span {
            color: rgba(255, 255, 255, 0.7);
            margin-right: 5px;
        }

        /* Descripción del agente */
        .agent-content-wrapper p {
            color: #fff;
            margin: 15px 0;
            line-height: 1.6;
            font-size: 14px;
        }

        /* Botón mejorado */
        .show-details {
            display: inline-block;
            background-color: rgba(255, 255, 255, 0.15);
            color: #fff;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
            text-align: center;
            margin-top: 15px;
        }

        .show-details:hover {
            background-color: #fff;
            color: #03A9F4;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }

        .show-details i {
            margin-left: 5px;
            transition: transform 0.3s ease;
        }

        .show-details:hover i {
            transform: translateX(3px);
        }

        /* Formulario de contacto mejorado */
        .agent-contact-form {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
        }

        .agent-contact-form-title {
            font-size: 18px;
            color: #fff;
            margin-bottom: 15px;
            text-align: center;
            font-weight: 600;
        }

        .contact-form-small input[type="text"],
        .contact-form-small input[type="email"],
        .contact-form-small textarea {
            width: 100%;
            padding: 12px 15px;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: #fff;
            margin-bottom: 12px;
            transition: all 0.3s ease;
        }

        .contact-form-small input::placeholder,
        .contact-form-small textarea::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .contact-form-small input:focus,
        .contact-form-small textarea:focus {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.5);
            outline: none;
        }

        .contact-form-small input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: rgba(255, 255, 255, 0.15);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .contact-form-small input[type="submit"]:hover {
            background-color: #fff;
            color: #03A9F4;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }


        /* Estilos mejorados para propiedades similares */
        .similar-properties {
            margin-top: 20px;
            margin-bottom: 30px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
        }

        /* Header con navegación */
        .nav-and-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: linear-gradient(135deg, #00BCD4 0%, #03A9F4 100%);
            color: white;
        }

        .similar-properties .title {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
            color: white;
        }

        .similar-properties-carousel-nav {
            display: flex;
            align-items: center;
        }

        .similar-properties-carousel-nav a {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .similar-properties-carousel-nav a:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        .similar-properties-carousel-nav svg {
            width: 16px;
            height: 16px;
        }

        .similar-properties-carousel-nav .left-arrow,
        .similar-properties-carousel-nav .right-arrow {
            transition: fill 0.3s ease;
        }

        .similar-properties-carousel-nav a:hover .left-arrow,
        .similar-properties-carousel-nav a:hover .right-arrow {
            fill: #fff;
        }

        /* Contenedor del carrusel */
        .similar-properties-carousel {
            background-color: #fff;
            padding: 0;
        }

        /* Artículos de propiedad */
        .similar-properties article {
            margin-bottom: 0;
            border-radius: 0;
            box-shadow: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .property-thumbnail {
            position: relative;
            overflow: hidden;
            height: 200px; /* Altura fija para uniformidad */
        }

        .property-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .similar-properties article:hover .property-thumbnail img {
            transform: scale(1.1);
        }

        .property-description {
            padding: 20px;
            background-color: #fff;
            position: relative;
        }

        .property-description .arrow {
            position: absolute;
            top: -10px;
            left: 20px;
            width: 20px;
            height: 20px;
            background-color: #fff;
            transform: rotate(45deg);
        }

        .entry-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .entry-title a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .entry-title a:hover {
            color: #0DBAE8;
            text-decoration: none;
        }

        .price-and-status {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .price {
            font-size: 20px;
            font-weight: 700;
            color: #0DBAE8;
            margin-right: 10px;
        }

        .property-status-tag {
            display: inline-block;
            padding: 4px 12px;
            background-color: #0DBAE8;
            color: white;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .property-status-tag:hover {
            background-color: #0a8bff;
        }

        /* Meta información */
        .property-meta.entry-meta {
            display: flex;
            flex-wrap: wrap;
            padding: 0;
            margin: 0;
        }

        .property-meta .meta-item {
            flex: 1 0 33.333%;
            text-align: center;
            padding: 8px 5px;
            transition: all 0.3s ease;
        }

        .property-meta .meta-item:hover {
            background-color: #f9f9f9;
        }

        .property-meta .meta-item-icon {
            margin: 0 auto 5px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .property-meta .meta-icon-container {
            width: 24px;
            height: 24px;
        }

        .property-meta .meta-icon {
            transition: fill 0.3s ease;
        }

        .property-meta .meta-item:hover .meta-icon {
            fill: #0a8bff !important;
        }

        .property-meta .meta-inner-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .property-meta .meta-item-label {
            font-size: 10px;
            color: #888;
            margin-bottom: 2px;
        }

        .property-meta .meta-item-value {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .meta-item-unit {
            font-size: 10px;
            color: #888;
            margin-left: 2px;
        }

        /* Mejoras para el carrusel */
        .owl-carousel {
            position: relative;
        }

        .owl-carousel .owl-nav {
            position: absolute;
            top: 50%;
            width: 100%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .owl-carousel .owl-nav button.owl-prev,
        .owl-carousel .owl-nav button.owl-next {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 0;
            color: #333;
            font-size: 20px;
            pointer-events: auto;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .owl-carousel .owl-nav button.owl-prev {
            left: 10px;
        }

        .owl-carousel .owl-nav button.owl-next {
            right: 10px;
        }

        .owl-carousel .owl-nav button.owl-prev:hover,
        .owl-carousel .owl-nav button.owl-next:hover {
            background-color: #0DBAE8;
            color: white;
            transform: scale(1.1);
        }

        .owl-dots {
            text-align: center;
            margin-top: 10px;
            padding-bottom: 15px;
        }

        .owl-dots .owl-dot {
            display: inline-block;
            margin: 0 5px;
        }

        .owl-dots .owl-dot span {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #ccc;
            display: block;
            transition: all 0.3s ease;
        }

        .owl-dots .owl-dot.active span,
        .owl-dots .owl-dot:hover span {
            background-color: #0DBAE8;
            transform: scale(1.2);
        }

        /* Etiqueta destacada para propiedades */
        .property-featured {
            position: absolute;
            top: 15px;
            left: -30px;
            background-color: #FF9800;
            color: white;
            padding: 5px 30px;
            font-size: 12px;
            font-weight: 700;
            transform: rotate(-45deg);
            z-index: 1;
        }

        /* Calculadora de hipoteca */
        .widget_lidd_mc_widget {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-top: 30px;
            transition: all 0.3s ease;
        }

        .widget_lidd_mc_widget:hover {
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        }

        .widget_lidd_mc_widget .widget-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
            position: relative;
            padding-bottom: 10px;
        }

        .widget_lidd_mc_widget .widget-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: #0DBAE8;
            transition: width 0.3s ease;
        }

        .widget_lidd_mc_widget:hover .widget-title:after {
            width: 100px;
        }

        .lidd_mc_input {
            margin-bottom: 15px;
        }

        .lidd_mc_input label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #555;
        }

        .lidd_mc_input input[type="text"] {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .lidd_mc_input input[type="text"]:focus {
            border-color: #0DBAE8;
            box-shadow: 0 0 0 3px rgba(13, 186, 232, 0.15);
            outline: none;
        }

        #lidd_mc_submit {
            background-color: #0DBAE8;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        #lidd_mc_submit:hover {
            background-color: #0a8bff;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(13, 186, 232, 0.3);
        }

        #lidd_mc_results {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        @keyframes fadeInOut {
            0% { opacity: 0; }
            20% { opacity: 1; }
            80% { opacity: 1; }
            100% { opacity: 0; }
        }

        .copy-confirmation {
            position: absolute;
            top: -40px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            animation: fadeInOut 2s forwards;
            z-index: 10;
        }



        /* Responsive */
        @media (max-width: 991px) {
            .property-meta .meta-item {
                flex: 1 0 50%;
            }

            .property-features-list li {
                flex: 0 0 calc(50% - 20px);
            }
        }

        @media (max-width: 767px) {
            .property-meta .meta-item {
                flex: 1 0 50%;
            }

            .property-thumbnail {
                height: 180px;
            }

            .entry-title {
                font-size: 16px;
            }

            .price {
                font-size: 18px;
            }

            .social-share-buttons {
                justify-content: center;
            }

            .social-share-btn {
                min-width: calc(50% - 12px);
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .location-disclaimer-content {
                flex-direction: column;
                text-align: center;
            }

            .location-icon {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }

        @media (max-width: 480px) {
            .social-share-btn {
                min-width: 100%;
                justify-content: flex-start;
            }
        }

        /* Animaciones y efectos */
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

        .property-single-content {
            animation: fadeInUp 0.5s ease;
        }

        .property-meta .meta-item {
            transition: all 0.3s ease;
        }

        .property-features-list li {
            transition: all 0.3s ease;
        }

        /* Efectos para el tour virtual */
        .property-video .placeholder-thumb {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .property-video .placeholder-thumb:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
        }

        .property-video .placeholder-thumb img {
            transition: all 0.5s ease;
        }

        .property-video .placeholder-thumb:hover img {
            transform: scale(1.05);
        }

        .property-video .fa-play-circle-o {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 60px;
            color: white;
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .property-video .placeholder-thumb:hover .fa-play-circle-o {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1.1);
            color: #0DBAE8;
        }

        /* Destacar las flechas del carousel para propiedades similares */
        .similar-properties-carousel-nav .carousel-prev-item,
        .similar-properties-carousel-nav .carousel-next-item {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .similar-properties-carousel-nav .carousel-prev-item:hover,
        .similar-properties-carousel-nav .carousel-next-item:hover {
            background-color: #0DBAE8;
            transform: scale(1.1);
        }

        /* Botón flotante de acción rápida */
        .quick-action-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background-color: #0DBAE8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            box-shadow: 0 5px 15px rgba(13, 186, 232, 0.3);
            cursor: pointer;
            z-index: 999;
            transition: all 0.3s ease;
        }

        .quick-action-button:hover {
            transform: scale(1.1);
            background-color: #0a8bff;
            box-shadow: 0 8px 25px rgba(13, 186, 232, 0.4);
        }

        /* Hover effects para las imágenes en general */
        .img-responsive {
            transition: all 0.5s ease;
        }

        .img-responsive:hover {
            transform: scale(1.05);
        }




    </style>
@endpush

<x-frontend-layout>
    <div class="container">
        <div class="container-property-single clearfix">
            <div class="col-lg-8 zero-horizontal-padding property-slider-wrapper">
                <x-frontend.property-gallery :images="$property->images"/>
            </div>
            <div class="col-lg-4 zero-horizontal-padding property-title-wrapper">
                <div class="single-property-wrapper">
                    <header class="entry-header single-property-header">
                        <h1 class="entry-title single-property-title">{{ $property->name }}</h1>
                        <span class="single-property-price price">{{ $property->currency }} {{ number_format($property->lowest_price, 2) }}</span>
                    </header>
                    <div class="property-meta entry-meta clearfix ">
                        <div class="meta-item">
                            <i class="meta-item-icon icon-pid">
                                <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                    <path class="meta-icon" fill-rule="evenodd" clip-rule="evenodd" fill="#0DBAE8" d="M24 48c-13.255 0-24-10.744-24-24 0-13.255 10.745-24 24-24 13.256 0 24 10.746 24 24 0 13.256-10.744 24-24 24zm7.207-29.719h-.645l.365-2.163c.168-1.067-.699-2.107-1.795-2.107-.896 0-1.654.59-1.793 1.49l-.477 2.78h-3.787l.365-2.163c.167-1.067-.702-2.107-1.796-2.107-.897 0-1.653.59-1.795 1.49l-.477 2.78h-1.599c-.981 0-1.794.814-1.794 1.797s.813 1.798 1.794 1.798h.981l-.7 4.156h-1.263c-.981 0-1.794.814-1.794 1.797s.813 1.797 1.794 1.797h.646l-.39 2.274c-.197 1.18.701 2.105 1.794 2.105 1.01 0 1.655-.73 1.796-1.488l.504-2.893h3.786l-.393 2.276c-.197 1.066.7 2.105 1.796 2.105.896 0 1.654-.617 1.793-1.488l.506-2.893h1.6c.979 0 1.793-.814 1.793-1.797s-.814-1.797-1.793-1.797h-.984l.703-4.156h1.26c.984 0 1.797-.815 1.797-1.798s-.814-1.795-1.798-1.795zm-9.449 7.75l.702-4.156h3.784l-.699 4.156h-3.787z"></path>
                                </svg>
                            </i>
                            <div class="meta-inner-wrapper">
                                <span class="meta-item-label">ID Propiedad</span>
                                <span class="meta-item-value">{{ $property->code }}</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <i class="meta-item-icon icon-area">
                                <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                    <path class="meta-icon" fill="#0DBAE8" d="M46 16v-12c0-1.104-.896-2.001-2-2.001h-12c0-1.103-.896-1.999-2.002-1.999h-11.997c-1.105 0-2.001.896-2.001 1.999h-12c-1.104 0-2 .897-2 2.001v12c-1.104 0-2 .896-2 2v11.999c0 1.104.896 2 2 2v12.001c0 1.104.896 2 2 2h12c0 1.104.896 2 2.001 2h11.997c1.106 0 2.002-.896 2.002-2h12c1.104 0 2-.896 2-2v-12.001c1.104 0 2-.896 2-2v-11.999c0-1.104-.896-2-2-2zm-4.002 23.998c0 1.105-.895 2.002-2 2.002h-31.998c-1.105 0-2-.896-2-2.002v-31.999c0-1.104.895-1.999 2-1.999h31.998c1.105 0 2 .895 2 1.999v31.999zm-5.623-28.908c-.123-.051-.256-.078-.387-.078h-11.39c-.563 0-1.019.453-1.019 1.016 0 .562.456 1.017 1.019 1.017h8.935l-20.5 20.473v-8.926c0-.562-.455-1.017-1.018-1.017-.564 0-1.02.455-1.02 1.017v11.381c0 .562.455 1.016 1.02 1.016h11.39c.562 0 1.017-.454 1.017-1.016 0-.563-.455-1.019-1.017-1.019h-8.933l20.499-20.471v8.924c0 .563.452 1.018 1.018 1.018.561 0 1.016-.455 1.016-1.018v-11.379c0-.132-.025-.264-.076-.387-.107-.249-.304-.448-.554-.551z"></path>
                                </svg>
                            </i>
                            <div class="meta-inner-wrapper">
                                <span class="meta-item-label">Area</span>
                                <span class="meta-item-value">{{ $property->size }}<sub class="meta-item-unit">mt2</sub></span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <i class="meta-item-icon icon-bed">
                                <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                    <path class="meta-icon" fill="#0DBAE8" d="M21 48.001h-19c-1.104 0-2-.896-2-2v-31c0-1.104.896-2 2-2h19c1.106 0 2 .896 2 2v31c0 1.104-.895 2-2 2zm0-37.001h-19c-1.104 0-2-.895-2-1.999v-7.001c0-1.104.896-2 2-2h19c1.106 0 2 .896 2 2v7.001c0 1.104-.895 1.999-2 1.999zm25 37.001h-19c-1.104 0-2-.896-2-2v-31c0-1.104.896-2 2-2h19c1.104 0 2 .896 2 2v31c0 1.104-.896 2-2 2zm0-37.001h-19c-1.104 0-2-.895-2-1.999v-7.001c0-1.104.896-2 2-2h19c1.104 0 2 .896 2 2v7.001c0 1.104-.896 1.999-2 1.999z"></path>
                                </svg>
                            </i>
                            <div class="meta-inner-wrapper">
                                <span class="meta-item-label">Dormitorios</span>
                                <span class="meta-item-value">{{ $property->bedrooms }}</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <i class="meta-item-icon icon-bath">
                                <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                    <path class="meta-icon" fill="#0DBAE8" d="M37.003 48.016h-4v-3.002h-18v3.002h-4.001v-3.699c-4.66-1.65-8.002-6.083-8.002-11.305v-4.003h-3v-3h48.006v3h-3.001v4.003c0 5.223-3.343 9.655-8.002 11.305v3.699zm-30.002-24.008h-4.001v-17.005s0-7.003 8.001-7.003h1.004c.236 0 7.995.061 7.995 8.003l5.001 4h-14l5-4-.001.01.001-.009s.938-4.001-3.999-4.001h-1s-4 0-4 3v17.005000000000003h-.001z"></path>
                                </svg>
                            </i>
                            <div class="meta-inner-wrapper">
                                <span class="meta-item-label">Banos</span>
                                <span class="meta-item-value">{{ $property->bathrooms }}</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <i class="meta-item-icon icon-garage">
                                <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                    <path class="meta-icon" fill="#0DBAE8" d="M44 0h-40c-2.21 0-4 1.791-4 4v44h6v-40c0-1.106.895-2 2-2h31.999c1.106 0 2.001.895 2.001 2v40h6v-44c0-2.209-1.792-4-4-4zm-36 8.001h31.999v2.999h-31.999zm0 18h6v5.999h-2c-1.104 0-2 .896-2 2.001v6.001c0 1.103.896 1.998 2 1.998h2v2.001c0 1.104.896 2 2 2s2-.896 2-2v-2.001h11.999v2.001c0 1.104.896 2 2.001 2 1.104 0 2-.896 2-2v-2.001h2c1.104 0 2-.895 2-1.998v-6.001c0-1.105-.896-2.001-2-2.001h-2v-5.999h5.999v-3h-31.999v3zm8 12.999c-1.104 0-2-.895-2-1.999s.896-2 2-2 2 .896 2 2-.896 1.999-2 1.999zm10.5 2h-5c-.276 0-.5-.225-.5-.5 0-.273.224-.498.5-.498h5c.275 0 .5.225.5.498 0 .275-.225.5-.5.5zm1-2h-7c-.275 0-.5-.225-.5-.5s.226-.499.5-.499h7c.275 0 .5.224.5.499s-.225.5-.5.5zm-6.5-2.499c0-.276.224-.5.5-.5h5c.275 0 .5.224.5.5s-.225.5-.5.5h-5c-.277 0-.5-.224-.5-.5zm11 2.499c-1.104 0-2.001-.895-2.001-1.999s.896-2 2.001-2c1.104 0 2 .896 2 2s-.896 1.999-2 1.999zm0-12.999v5.999h-16v-5.999h16zm-24-13.001h31.999v3h-31.999zm0 5h31.999v3h-31.999z"></path>
                                </svg>
                            </i>
                            <div class="meta-inner-wrapper">
                                <span class="meta-item-label">Garajes</span>
                                <span class="meta-item-value">{{ $property->garage }}</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <i class="meta-item-icon icon-garage">
                                <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                    <path class="meta-icon" fill="#0DBAE8" d="M44 0h-40c-2.21 0-4 1.791-4 4v44h6v-40c0-1.106.895-2 2-2h31.999c1.106 0 2.001.895 2.001 2v40h6v-44c0-2.209-1.792-4-4-4zm-36 8.001h31.999v2.999h-31.999zm0 18h6v5.999h-2c-1.104 0-2 .896-2 2.001v6.001c0 1.103.896 1.998 2 1.998h2v2.001c0 1.104.896 2 2 2s2-.896 2-2v-2.001h11.999v2.001c0 1.104.896 2 2.001 2 1.104 0 2-.896 2-2v-2.001h2c1.104 0 2-.895 2-1.998v-6.001c0-1.105-.896-2.001-2-2.001h-2v-5.999h5.999v-3h-31.999v3zm8 12.999c-1.104 0-2-.895-2-1.999s.896-2 2-2 2 .896 2 2-.896 1.999-2 1.999zm10.5 2h-5c-.276 0-.5-.225-.5-.5 0-.273.224-.498.5-.498h5c.275 0 .5.225.5.498 0 .275-.225.5-.5.5zm1-2h-7c-.275 0-.5-.225-.5-.5s.226-.499.5-.499h7c.275 0 .5.224.5.499s-.225.5-.5.5zm-6.5-2.499c0-.276.224-.5.5-.5h5c.275 0 .5.224.5.5s-.225.5-.5.5h-5c-.277 0-.5-.224-.5-.5zm11 2.499c-1.104 0-2.001-.895-2.001-1.999s.896-2 2.001-2c1.104 0 2 .896 2 2s-.896 1.999-2 1.999zm0-12.999v5.999h-16v-5.999h16zm-24-13.001h31.999v3h-31.999zm0 5h31.999v3h-31.999z"></path>
                                </svg>
                            </i>
                            <div class="meta-inner-wrapper">
                                <span class="meta-item-label">Garaje</span>
                                <span class="meta-item-value">{{ $property->garage_size ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="meta-item meta-property-type">
                            <i class="meta-item-icon icon-ptype">
                                <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                    <path class="meta-icon" fill-rule="evenodd" clip-rule="evenodd" fill="#0DBAE8" d="M24 48.001c-13.255 0-24-10.745-24-24.001 0-13.254 10.745-24 24-24s24 10.746 24 24c0 13.256-10.745 24.001-24 24.001zm10-27.001l-10-8-10 8v11c0 1.03.888 2.001 2 2.001h3.999v-9h8.001v9h4c1.111 0 2-.839 2-2.001v-11z"></path>
                                </svg>
                            </i>
                            <div class="meta-inner-wrapper">
                                <span class="meta-item-label">Tipo</span>
                                <span class="meta-item-value">{{ $property->propertyType->type_name }}</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <i class="meta-item-icon icon-tag">
                                <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                    <path class="meta-icon" fill-rule="evenodd" clip-rule="evenodd" fill="#0DBAE8" d="M47.199 24.176l-23.552-23.392c-.504-.502-1.174-.778-1.897-.778l-19.087.09c-.236.003-.469.038-.696.1l-.251.1-.166.069c-.319.152-.564.321-.766.529-.497.502-.781 1.196-.778 1.907l.092 19.124c.003.711.283 1.385.795 1.901l23.549 23.389c.221.218.482.393.779.523l.224.092c.26.092.519.145.78.155l.121.009h.012c.239-.003.476-.037.693-.098l.195-.076.2-.084c.315-.145.573-.319.791-.539l18.976-19.214c.507-.511.785-1.188.781-1.908-.003-.72-.287-1.394-.795-1.899zm-35.198-9.17c-1.657 0-3-1.345-3-3 0-1.657 1.343-3 3-3 1.656 0 2.999 1.343 2.999 3 0 1.656-1.343 3-2.999 3z"></path>
                                </svg>
                            </i>
                            <div class="meta-inner-wrapper">
                                <span class="meta-item-label">Para</span>
                                <span class="meta-item-value">{{ $property->serviceType->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="favorite-and-print clearfix">
                    <a class="add-to-fav" href="#" data-toggle="modal"><i class="fa fa-star"></i>&nbsp;&nbsp;Agregar a favoritos</a>
                    <a class="printer-icon" href="javascript:window.print()"><i class="fa fa-print"></i>&nbsp;&nbsp;Imprimir</a>
                </div>
            </div>
            <div class="col-md-8 site-main-content property-single-content">
                <main id="main" class="site-main">
                    <article class="hentry clearfix">
                        <div class="entry-content clearfix">
                            <h4 class="fancy-title">Descripcion</h4>
                            <div class="property-content">
                                {!! $property->long_description !!}
                            </div>
                            <div class="property-additional-details clearfix">
                                <h4 class="fancy-title">Informacion adicional</h4>
                                <ul class="property-additional-details-list clearfix">
                                    <li>
                                        <dl>
                                            <dt>Dirección</dt>
                                            <dd>{{ $property->address }}</dd>
                                        </dl>
                                    </li>
                                    <li>
                                        <dl>
                                            <dt>Ciudad</dt>
                                            <dd>{{ $property->whatcity?->name ?? 'Sin ciudad' }}</dd>
                                        </dl>
                                    </li>
                                    <li>
                                        <dl>
                                            <dt>Pais</dt>
                                            <dd>{{ $property->country ?? 'Sin pais' }}</dd>
                                        </dl>
                                    </li>
                                    <li>
                                        <dl>
                                            <dt>Zona</dt>
                                            <dd>{{ $property->neighborhood }}</dd>
                                        </dl>
                                    </li>
                                </ul>
                            </div>

                            @if($property->amenities->count() > 0)
                                <div class="property-features">
                                    <h4 class="fancy-title">Características/Comodidades</h4>
                                    <ul class="property-features-list">
                                        @foreach($property->amenities as $amenity)
                                            <li>{{ $amenity->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if($property->facilities->count() > 0)
                                <div class="property-features">
                                    <h4 class="fancy-title">¿Qué hay cerca?</h4>
                                    <ul class="property-additional-details-list clearfix">
                                        @foreach($property->facilities as $feature)
                                            <li>
                                                <dl>
                                                    <dt>{{ $feature->name }}</dt>
                                                    <dd>{{ $feature->pivot->distance }}</dd>
                                                </dl>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <section class="property-video">
                                <h4 class="fancy-title">Tour Virtual</h4>
                                <div class="placeholder-thumb format-video">
                                    <a class="video-popup" href="https://www.youtube.com/watch?v=7CZz_QoWaV4" title="Virtual Tour">
                                        <i class="fa fa-play-circle-o"></i>
                                        <img width="850" height="570" src="{{ asset('storage/' . $property->thumbnail) }}" class="img-responsive wp-post-image" alt="Exterior">
                                    </a>
                                </div>
                            </section>
                        </div>
                    </article>

                    <section class="property-location-section clearfix">
                        <h4 class="fancy-title">Ubicación</h4>
                        <div class="location-disclaimer">
                            <div class="location-disclaimer-content">
                                <div class="location-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="location-text">
                                    <h5>Ubicación aproximada</h5>
                                    <p>Por razones de privacidad y seguridad, mostramos un área aproximada de 1 km alrededor de la propiedad. Contacte con nuestro agente para conocer la ubicación exacta.</p>
                                </div>
                            </div>
                        </div>
                        <div id="property-map" style="height: 400px"></div>
                    </section>
                    <div class="property-share-networks clearfix">
                        <h4 class="fancy-title">Compartir propiedad</h4>
                        <a href="https://wa.me/?text={{ urlencode('Mira esta propiedad: ' . $property->name . ' ' . url()->current()) }}" target="_blank" class="social-share-btn whatsapp-btn" title="Compartir por WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                            <span>WhatsApp</span>
                        </a>

                        <!-- Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="social-share-btn facebook-btn" title="Compartir en Facebook">
                            <i class="fab fa-facebook-f"></i>
                            <span>Facebook</span>
                        </a>

                        <!-- Correo electrónico -->
                        <a href="mailto:?subject={{ urlencode('Propiedad: ' . $property->name) }}&body={{ urlencode('Mira esta propiedad que encontré: ' . $property->name . ' ' . url()->current()) }}" class="social-share-btn email-btn" title="Compartir por Email">
                            <i class="far fa-envelope"></i>
                            <span>Email</span>
                        </a>

                        <!-- Copiar enlace -->
                        <a href="javascript:void(0);" class="social-share-btn copy-link-btn" id="copyLinkBtn" data-clipboard-text="{{ url()->current() }}" title="Copiar enlace">
                            <i class="far fa-copy"></i>
                            <span>Copiar enlace</span>
                        </a>
                    </div>
                </main>
                <!-- .site-main -->
            </div>
            <!-- .site-main-content -->
            <div class="col-md-4 zero-horizontal-padding">
                <aside class="sidebar sidebar-property-detail">
                    <section class="agent-sidebar-widget clearfix">
                        <div class="agent-content-wrapper agent-common-styles">
                            <div class="inner-wrapper clearfix">
                                <figure class="agent-image">
                                    <a href="agent-single.html">
                                        <img width="220" height="220" src="{{ asset('assets/front/images/agente.jpg') }}" class="img-circle wp-post-image" alt="Nathan James">
                                    </a>
                                </figure>
                                <h3 class="agent-name">
                                    <a href="agent-single.html">Pablo Jordan</a>
                                    <span>Agente Bolivian Real Estate</span>
                                </h3>
                                <div class="agent-social-profiles">
                                    <a class="facebook" target="_blank" href="https://www.facebook.com/envatomarket"><i class="fa fa-facebook"></i></a>
                                    <a class="pinterest" target="_blank" href="http://realplaces.inspirythemes.biz/"><i class="fa fa-pinterest"></i></a>
                                </div>
                            </div>
                            <ul class="agent-contacts-list">
                                <li class="office">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="contacts-icon-container" width="24" height="24" viewBox="0 0 24 24">
                                        <path class="contacts-icon" fill-rule="evenodd" clip-rule="evenodd" fill="#0080BC" d="M1.027 4.846l-.018.37.01.181c.068 9.565 7.003 17.42 15.919 18.48.338.075 1.253.129 1.614.129.359 0 .744-.021 1.313-.318.328-.172.448-.688.308-1.016-.227-.528-.531-.578-.87-.625-.435-.061-.905 0-1.521 0-1.859 0-3.486-.835-4.386-1.192l.002.003-.076-.034c-.387-.156-.696-.304-.924-.422-3.702-1.765-6.653-4.943-8.186-8.896-.258-.568-1.13-2.731-1.152-6.009h.003l-.022-.223c0-1.727 1.343-3.128 2.999-3.128 1.658 0 3.001 1.401 3.001 3.128 0 1.56-1.096 2.841-2.526 3.079l.001.014c-.513.046-.914.488-.914 1.033 0 .281.251 1.028.251 1.028.015 0 .131.188.119.188-.194-.539 1.669 5.201 7.021 7.849-.001.011.636.309.636.309.47.3 1.083.145 1.37-.347.09-.151.133-.32.14-.488.356-1.306 1.495-2.271 2.863-2.271 1.652 0 2.991 1.398 2.991 3.12 0 .346-.066.671-.164.981-.3.594-.412 1.21.077 1.699.769.769 1.442-.144 1.442-.144.408-.755.643-1.625.643-2.554 0-2.884-2.24-5.222-5.007-5.222-1.947 0-3.633 1.164-4.46 2.858-2.536-1.342-4.556-3.59-5.656-6.344 1.848-.769 3.154-2.647 3.154-4.849 0-2.884-2.241-5.222-5.007-5.222-2.41 0-4.422 1.777-4.897 4.144l-.091.711z"/>
                                    </svg>
                                    <span>Oficina:</span>1-234-456-789
                                </li>
                                <li class="mobile">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="contacts-icon-container" width="24" height="24" viewBox="0 0 24 24">
                                        <path class="contacts-icon" fill-rule="evenodd" clip-rule="evenodd" fill="#0DBAE8" d="M17.001 23.999h-10.001c-1.657 0-3-1.343-3-2.999v-18c0-1.656 1.343-3 3-3h10.001c1.655 0 2.999 1.344 2.999 3v18c0 1.656-1.344 2.999-2.999 2.999zm.999-19.999c0-1.105-.896-2-2-2h-8c-1.105 0-2 .896-2 2v16c0 1.104.895 2 2 2h8c1.104 0 2-.896 2-2v-16zm-4 1h-4c-.552 0-1-.447-1-1 0-.552.448-1 1-1h4c.553 0 1.001.448 1.001 1 0 .553-.448 1-1.001 1zm-2 13c1.105 0 2 .672 2 1.499 0 .829-.895 1.501-2 1.501s-2-.672-2-1.501c0-.827.895-1.499 2-1.499z"/>
                                    </svg>
                                    <span>Celular:</span>1-222-333-4444
                                </li>
                                <li class="fax">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="contacts-icon-container" width="24" height="24" viewBox="0 0 24 24">
                                        <path class="fax-fill-one" d="M6 20c0 1.105.896 2 2 2h8c1.104 0 2-.895 2-2v-8h-12v8zm2-6h8v2h-8v-2zm0 4h8v2h-8v-2zM17 2h-10c-1.104 0-2 .896-2 2v3h14v-3c0-1.105-.896-2-2-2z" fill="none"/>
                                        <circle cx="21" cy="11" r="1" fill="none"/>
                                        <path class="fax-fill-two" fill="#0080bc" d="M21.999 7h-.999v-5c0-1.105-.896-2-2-2h-14c-1.104 0-2 .895-2 2v5h-.999c-1.105 0-2 .896-2 2.001v7.999c0 1.104.895 2 2 2h.999v3c0 1.105.896 2 2 2h14c1.104 0 2-.895 2-2v-3h.999c1.104 0 2-.896 2-2v-7.999c0-1.105-.895-2.001-2-2.001zm-3.999 13c0 1.105-.896 2-2 2h-8c-1.104 0-2-.895-2-2v-8h12v8zm1-13h-14v-3c0-1.104.896-2 2-2h10c1.104 0 2 .895 2 2v3zm2 4.999c-.553 0-1-.448-1-1 0-.551.447-.999 1-.999s.999.448.999.999c0 .552-.446 1-.999 1zM8 14h8v2h-8zM8 18h8v2h-8z"/>
                                    </svg>
                                    <span>Fax:</span>1-333-444-5555
                                </li>
                                <li class="map-pin">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="contacts-icon-container" width="40" height="40" viewBox="0 0 24 24">
                                        <path class="contacts-icon" fill-rule="evenodd" clip-rule="evenodd" fill="#000000" d="M12 23.999c.048 0-8-11.582-8-15.999 0-4.419 3.581-8 8-8s8 3.581 8 8c0 4.417-8.084 15.999-8 15.999zm0-19.001c-1.658 0-3.002 1.345-3.002 3.002 0 1.657 1.344 3.002 3.002 3.002 1.657 0 3.002-1.345 3.002-3.002 0-1.658-1.345-3.002-3.002-3.002z"/>
                                    </svg>
                                    Direccion
                                </li>
                            </ul>
                            <p>Donec ullamcorper nulla non metus auctor fringilla. Curabitur blandit tempus porttitor. Duis mollis, est non…</p>
                            <a class="btn-default show-details" href="agent-single.html">Ver perfil<i class="fa fa-angle-right"></i></a>
                            <div class="agent-contact-form">
                                <h3 class="agent-contact-form-title">Contactar agente</h3>
                                <form id="agent-contact-form" class="contact-form-small" method="post" action="contact_form_handler.php" novalidate="novalidate">
                                    <div class="row">
                                        <div class="col-sm-6 left-field">
                                            <input type="text" name="name" placeholder="Name" class="required" title="* Please provide your name">
                                        </div>
                                        <div class="col-sm-6 right-field">
                                            <input type="text" name="email" placeholder="Email" class="email required" title="* Please provide valid email address">
                                        </div>
                                    </div>
                                    <textarea name="message" class="required" placeholder="Message" title="* Please provide your message"></textarea>
                                    <input type="submit" id="submit-button" name="submit" class="btn-default btn-round" value="Send Message">
                                    <img src="images/ajax-loader.gif" id="ajax-loader" alt="Loading...">
                                </form>
                                <div id="error-container"></div>
                                <div id="message-container">&nbsp;</div>
                            </div>
                        </div>
                    </section>
                    <section class="similar-properties meta-item-half clearfix">
                        <div class="nav-and-title clearfix">
                            <h3 class="title">Propiedades similares</h3>
                            <div class="similar-properties-carousel-nav carousel-nav">
                                <a class="carousel-prev-item prev">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-container" width="32" height="52" viewBox="0 0 32 52">
                                        <g class="left-arrow" fill="#fff">
                                            <path opacity=".5" d="M31.611 7.646l-6.787-7.057-24.435 25.406 6.787 7.057z"/>
                                            <path d="M.389 26.006l6.787-7.058 24.435 25.406-6.787 7.057z"/>
                                        </g>
                                    </svg>
                                </a>
                                <a class="carousel-next-item next">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-container" width="32" height="52" viewBox="0 0 32 52">
                                        <g class="right-arrow" fill-rule="evenodd" clip-rule="evenodd" fill="#fff">
                                            <path d="M.388 44.354l6.788 7.057 24.436-25.406-6.788-7.057-24.436 25.406z"/>
                                            <path opacity=".5" d="M31.612 25.994l-6.788 7.058-24.436-25.406 6.788-7.057 24.436 25.405z"/>
                                        </g>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="similar-properties-carousel">
                            <div class="owl-carousel">
                                <article class="hentry clearfix">
                                    <figure class="property-thumbnail">
                                        <a href="#">
                                            <img width="850" height="570" src="{{ asset('storage/properties/P250200001/thumbnails/img_67a0e2748719a.jpg') }}" class="img-responsive wp-post-image" alt="Property">
                                        </a>
                                    </figure>
                                    <div class="property-description">
                                        <div class="arrow"></div>
                                        <header class="entry-header">
                                            <h3 class="entry-title"><a href="#" rel="bookmark">Single Home at Florida 5, Pinecrest</a></h3>
                                            <div class="price-and-status">
                                                <span class="price">$580,000</span><a href="#"><span class="property-status-tag">For Sale</span></a>
                                            </div>
                                        </header>
                                        <div class="property-meta entry-meta clearfix ">
                                            <div class="meta-item">
                                                <i class="meta-item-icon icon-area">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                                        <path class="meta-icon" fill="#0DBAE8" d="M46 16v-12c0-1.104-.896-2.001-2-2.001h-12c0-1.103-.896-1.999-2.002-1.999h-11.997c-1.105 0-2.001.896-2.001 1.999h-12c-1.104 0-2 .897-2 2.001v12c-1.104 0-2 .896-2 2v11.999c0 1.104.896 2 2 2v12.001c0 1.104.896 2 2 2h12c0 1.104.896 2 2.001 2h11.997c1.106 0 2.002-.896 2.002-2h12c1.104 0 2-.896 2-2v-12.001c1.104 0 2-.896 2-2v-11.999c0-1.104-.896-2-2-2zm-4.002 23.998c0 1.105-.895 2.002-2 2.002h-31.998c-1.105 0-2-.896-2-2.002v-31.999c0-1.104.895-1.999 2-1.999h31.998c1.105 0 2 .895 2 1.999v31.999zm-5.623-28.908c-.123-.051-.256-.078-.387-.078h-11.39c-.563 0-1.019.453-1.019 1.016 0 .562.456 1.017 1.019 1.017h8.935l-20.5 20.473v-8.926c0-.562-.455-1.017-1.018-1.017-.564 0-1.02.455-1.02 1.017v11.381c0 .562.455 1.016 1.02 1.016h11.39c.562 0 1.017-.454 1.017-1.016 0-.563-.455-1.019-1.017-1.019h-8.933l20.499-20.471v8.924c0 .563.452 1.018 1.018 1.018.561 0 1.016-.455 1.016-1.018v-11.379c0-.132-.025-.264-.076-.387-.107-.249-.304-.448-.554-.551z"></path>
                                                    </svg>
                                                </i>
                                                <div class="meta-inner-wrapper">
                                                    <span class="meta-item-label">Area</span>
                                                    <span class="meta-item-value">5500<sub class="meta-item-unit">Sq Ft</sub></span>
                                                </div>
                                            </div>
                                            <div class="meta-item">
                                                <i class="meta-item-icon icon-bed">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                                        <path class="meta-icon" fill="#0DBAE8" d="M21 48.001h-19c-1.104 0-2-.896-2-2v-31c0-1.104.896-2 2-2h19c1.106 0 2 .896 2 2v31c0 1.104-.895 2-2 2zm0-37.001h-19c-1.104 0-2-.895-2-1.999v-7.001c0-1.104.896-2 2-2h19c1.106 0 2 .896 2 2v7.001c0 1.104-.895 1.999-2 1.999zm25 37.001h-19c-1.104 0-2-.896-2-2v-31c0-1.104.896-2 2-2h19c1.104 0 2 .896 2 2v31c0 1.104-.896 2-2 2zm0-37.001h-19c-1.104 0-2-.895-2-1.999v-7.001c0-1.104.896-2 2-2h19c1.104 0 2 .896 2 2v7.001c0 1.104-.896 1.999-2 1.999z"></path>
                                                    </svg>
                                                </i>
                                                <div class="meta-inner-wrapper">
                                                    <span class="meta-item-label">Bedrooms</span>
                                                    <span class="meta-item-value">4</span>
                                                </div>
                                            </div>
                                            <div class="meta-item">
                                                <i class="meta-item-icon icon-bath">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                                        <path class="meta-icon" fill="#0DBAE8" d="M37.003 48.016h-4v-3.002h-18v3.002h-4.001v-3.699c-4.66-1.65-8.002-6.083-8.002-11.305v-4.003h-3v-3h48.006v3h-3.001v4.003c0 5.223-3.343 9.655-8.002 11.305v3.699zm-30.002-24.008h-4.001v-17.005s0-7.003 8.001-7.003h1.004c.236 0 7.995.061 7.995 8.003l5.001 4h-14l5-4-.001.01.001-.009s.938-4.001-3.999-4.001h-1s-4 0-4 3v17.005000000000003h-.001z"></path>
                                                    </svg>
                                                </i>
                                                <div class="meta-inner-wrapper">
                                                    <span class="meta-item-label">Bathrooms</span>
                                                    <span class="meta-item-value">4</span>
                                                </div>
                                            </div>
                                            <div class="meta-item">
                                                <i class="meta-item-icon icon-garage">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                                        <path class="meta-icon" fill="#0DBAE8" d="M44 0h-40c-2.21 0-4 1.791-4 4v44h6v-40c0-1.106.895-2 2-2h31.999c1.106 0 2.001.895 2.001 2v40h6v-44c0-2.209-1.792-4-4-4zm-36 8.001h31.999v2.999h-31.999zm0 18h6v5.999h-2c-1.104 0-2 .896-2 2.001v6.001c0 1.103.896 1.998 2 1.998h2v2.001c0 1.104.896 2 2 2s2-.896 2-2v-2.001h11.999v2.001c0 1.104.896 2 2.001 2 1.104 0 2-.896 2-2v-2.001h2c1.104 0 2-.895 2-1.998v-6.001c0-1.105-.896-2.001-2-2.001h-2v-5.999h5.999v-3h-31.999v3zm8 12.999c-1.104 0-2-.895-2-1.999s.896-2 2-2 2 .896 2 2-.896 1.999-2 1.999zm10.5 2h-5c-.276 0-.5-.225-.5-.5 0-.273.224-.498.5-.498h5c.275 0 .5.225.5.498 0 .275-.225.5-.5.5zm1-2h-7c-.275 0-.5-.225-.5-.5s.226-.499.5-.499h7c.275 0 .5.224.5.499s-.225.5-.5.5zm-6.5-2.499c0-.276.224-.5.5-.5h5c.275 0 .5.224.5.5s-.225.5-.5.5h-5c-.277 0-.5-.224-.5-.5zm11 2.499c-1.104 0-2.001-.895-2.001-1.999s.896-2 2.001-2c1.104 0 2 .896 2 2s-.896 1.999-2 1.999zm0-12.999v5.999h-16v-5.999h16zm-24-13.001h31.999v3h-31.999zm0 5h31.999v3h-31.999z"></path>
                                                    </svg>
                                                </i>
                                                <div class="meta-inner-wrapper">
                                                    <span class="meta-item-label">Garages</span>
                                                    <span class="meta-item-value">2</span>
                                                </div>
                                            </div>
                                            <div class="meta-item meta-property-type">
                                                <i class="meta-item-icon icon-ptype">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                                        <path class="meta-icon" fill-rule="evenodd" clip-rule="evenodd" fill="#0DBAE8" d="M24 48.001c-13.255 0-24-10.745-24-24.001 0-13.254 10.745-24 24-24s24 10.746 24 24c0 13.256-10.745 24.001-24 24.001zm10-27.001l-10-8-10 8v11c0 1.03.888 2.001 2 2.001h3.999v-9h8.001v9h4c1.111 0 2-.839 2-2.001v-11z"></path>
                                                    </svg>
                                                </i>
                                                <div class="meta-inner-wrapper">
                                                    <span class="meta-item-label">Type</span>
                                                    <span class="meta-item-value">Single Family Home</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- .property-meta -->
                                    </div>
                                </article>
                                <article class="hentry clearfix">
                                    <figure class="property-thumbnail">
                                        <a href="#">
                                            <img width="850" height="570" src="{{ asset('storage/properties/P250200001/thumbnails/img_67a0e2748719a.jpg') }}" class="img-responsive wp-post-image" alt="property-13">
                                        </a>
                                    </figure>
                                    <div class="property-description">
                                        <div class="arrow"></div>
                                        <header class="entry-header">
                                            <h3 class="entry-title"><a href="#/" rel="bookmark">Building Having 15 Apartments</a></h3>
                                            <div class="price-and-status">
                                                <span class="price">$6,950,000</span><a href="#"><span class="property-status-tag">For Sale</span></a>
                                            </div>
                                        </header>
                                        <div class="property-meta entry-meta clearfix ">
                                            <div class="meta-item">
                                                <i class="meta-item-icon icon-area">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                                        <path class="meta-icon" fill="#0DBAE8" d="M46 16v-12c0-1.104-.896-2.001-2-2.001h-12c0-1.103-.896-1.999-2.002-1.999h-11.997c-1.105 0-2.001.896-2.001 1.999h-12c-1.104 0-2 .897-2 2.001v12c-1.104 0-2 .896-2 2v11.999c0 1.104.896 2 2 2v12.001c0 1.104.896 2 2 2h12c0 1.104.896 2 2.001 2h11.997c1.106 0 2.002-.896 2.002-2h12c1.104 0 2-.896 2-2v-12.001c1.104 0 2-.896 2-2v-11.999c0-1.104-.896-2-2-2zm-4.002 23.998c0 1.105-.895 2.002-2 2.002h-31.998c-1.105 0-2-.896-2-2.002v-31.999c0-1.104.895-1.999 2-1.999h31.998c1.105 0 2 .895 2 1.999v31.999zm-5.623-28.908c-.123-.051-.256-.078-.387-.078h-11.39c-.563 0-1.019.453-1.019 1.016 0 .562.456 1.017 1.019 1.017h8.935l-20.5 20.473v-8.926c0-.562-.455-1.017-1.018-1.017-.564 0-1.02.455-1.02 1.017v11.381c0 .562.455 1.016 1.02 1.016h11.39c.562 0 1.017-.454 1.017-1.016 0-.563-.455-1.019-1.017-1.019h-8.933l20.499-20.471v8.924c0 .563.452 1.018 1.018 1.018.561 0 1.016-.455 1.016-1.018v-11.379c0-.132-.025-.264-.076-.387-.107-.249-.304-.448-.554-.551z"></path>
                                                    </svg>
                                                </i>
                                                <div class="meta-inner-wrapper">
                                                    <span class="meta-item-label">Area</span>
                                                    <span class="meta-item-value">52000<sub class="meta-item-unit">Sq Ft</sub></span>
                                                </div>
                                            </div>
                                            <div class="meta-item meta-property-type">
                                                <i class="meta-item-icon icon-ptype">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                                        <path class="meta-icon" fill-rule="evenodd" clip-rule="evenodd" fill="#0DBAE8" d="M24 48.001c-13.255 0-24-10.745-24-24.001 0-13.254 10.745-24 24-24s24 10.746 24 24c0 13.256-10.745 24.001-24 24.001zm10-27.001l-10-8-10 8v11c0 1.03.888 2.001 2 2.001h3.999v-9h8.001v9h4c1.111 0 2-.839 2-2.001v-11z"></path>
                                                    </svg>
                                                </i>
                                                <div class="meta-inner-wrapper">
                                                    <span class="meta-item-label">Type</span>
                                                    <span class="meta-item-value">Apartment Building</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- .property-meta -->
                                    </div>
                                </article>
                                <article class="hentry clearfix">
                                    <figure class="property-thumbnail">
                                        <a href="#">
                                            <img width="850" height="570" src="{{ asset('storage/properties/P250200001/thumbnails/img_67a0e2748719a.jpg') }}" class="img-responsive wp-post-image" alt="">
                                        </a>
                                    </figure>
                                    <div class="property-description">
                                        <div class="arrow"></div>
                                        <header class="entry-header">
                                            <h3 class="entry-title"><a href="#" rel="bookmark">Home in Merrick Way</a></h3>
                                            <div class="price-and-status">
                                                <span class="price">$540,000</span><a href="#"><span class="property-status-tag">For Sale</span></a>
                                            </div>
                                        </header>
                                        <div class="property-meta entry-meta clearfix ">
                                            <div class="meta-item">
                                                <i class="meta-item-icon icon-area">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                                        <path class="meta-icon" fill="#0DBAE8" d="M46 16v-12c0-1.104-.896-2.001-2-2.001h-12c0-1.103-.896-1.999-2.002-1.999h-11.997c-1.105 0-2.001.896-2.001 1.999h-12c-1.104 0-2 .897-2 2.001v12c-1.104 0-2 .896-2 2v11.999c0 1.104.896 2 2 2v12.001c0 1.104.896 2 2 2h12c0 1.104.896 2 2.001 2h11.997c1.106 0 2.002-.896 2.002-2h12c1.104 0 2-.896 2-2v-12.001c1.104 0 2-.896 2-2v-11.999c0-1.104-.896-2-2-2zm-4.002 23.998c0 1.105-.895 2.002-2 2.002h-31.998c-1.105 0-2-.896-2-2.002v-31.999c0-1.104.895-1.999 2-1.999h31.998c1.105 0 2 .895 2 1.999v31.999zm-5.623-28.908c-.123-.051-.256-.078-.387-.078h-11.39c-.563 0-1.019.453-1.019 1.016 0 .562.456 1.017 1.019 1.017h8.935l-20.5 20.473v-8.926c0-.562-.455-1.017-1.018-1.017-.564 0-1.02.455-1.02 1.017v11.381c0 .562.455 1.016 1.02 1.016h11.39c.562 0 1.017-.454 1.017-1.016 0-.563-.455-1.019-1.017-1.019h-8.933l20.499-20.471v8.924c0 .563.452 1.018 1.018 1.018.561 0 1.016-.455 1.016-1.018v-11.379c0-.132-.025-.264-.076-.387-.107-.249-.304-.448-.554-.551z"></path>
                                                    </svg>
                                                </i>
                                                <div class="meta-inner-wrapper">
                                                    <span class="meta-item-label">Area</span>
                                                    <span class="meta-item-value">4300<sub class="meta-item-unit">Sq Ft</sub></span>
                                                </div>
                                            </div>
                                            <div class="meta-item">
                                                <i class="meta-item-icon icon-bed">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                                        <path class="meta-icon" fill="#0DBAE8" d="M21 48.001h-19c-1.104 0-2-.896-2-2v-31c0-1.104.896-2 2-2h19c1.106 0 2 .896 2 2v31c0 1.104-.895 2-2 2zm0-37.001h-19c-1.104 0-2-.895-2-1.999v-7.001c0-1.104.896-2 2-2h19c1.106 0 2 .896 2 2v7.001c0 1.104-.895 1.999-2 1.999zm25 37.001h-19c-1.104 0-2-.896-2-2v-31c0-1.104.896-2 2-2h19c1.104 0 2 .896 2 2v31c0 1.104-.896 2-2 2zm0-37.001h-19c-1.104 0-2-.895-2-1.999v-7.001c0-1.104.896-2 2-2h19c1.104 0 2 .896 2 2v7.001c0 1.104-.896 1.999-2 1.999z"></path>
                                                    </svg>
                                                </i>
                                                <div class="meta-inner-wrapper">
                                                    <span class="meta-item-label">Bedrooms</span>
                                                    <span class="meta-item-value">3</span>
                                                </div>
                                            </div>
                                            <div class="meta-item">
                                                <i class="meta-item-icon icon-bath">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                                        <path class="meta-icon" fill="#0DBAE8" d="M37.003 48.016h-4v-3.002h-18v3.002h-4.001v-3.699c-4.66-1.65-8.002-6.083-8.002-11.305v-4.003h-3v-3h48.006v3h-3.001v4.003c0 5.223-3.343 9.655-8.002 11.305v3.699zm-30.002-24.008h-4.001v-17.005s0-7.003 8.001-7.003h1.004c.236 0 7.995.061 7.995 8.003l5.001 4h-14l5-4-.001.01.001-.009s.938-4.001-3.999-4.001h-1s-4 0-4 3v17.005000000000003h-.001z"></path>
                                                    </svg>
                                                </i>
                                                <div class="meta-inner-wrapper">
                                                    <span class="meta-item-label">Bathrooms</span>
                                                    <span class="meta-item-value">3</span>
                                                </div>
                                            </div>
                                            <div class="meta-item">
                                                <i class="meta-item-icon icon-garage">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                                        <path class="meta-icon" fill="#0DBAE8" d="M44 0h-40c-2.21 0-4 1.791-4 4v44h6v-40c0-1.106.895-2 2-2h31.999c1.106 0 2.001.895 2.001 2v40h6v-44c0-2.209-1.792-4-4-4zm-36 8.001h31.999v2.999h-31.999zm0 18h6v5.999h-2c-1.104 0-2 .896-2 2.001v6.001c0 1.103.896 1.998 2 1.998h2v2.001c0 1.104.896 2 2 2s2-.896 2-2v-2.001h11.999v2.001c0 1.104.896 2 2.001 2 1.104 0 2-.896 2-2v-2.001h2c1.104 0 2-.895 2-1.998v-6.001c0-1.105-.896-2.001-2-2.001h-2v-5.999h5.999v-3h-31.999v3zm8 12.999c-1.104 0-2-.895-2-1.999s.896-2 2-2 2 .896 2 2-.896 1.999-2 1.999zm10.5 2h-5c-.276 0-.5-.225-.5-.5 0-.273.224-.498.5-.498h5c.275 0 .5.225.5.498 0 .275-.225.5-.5.5zm1-2h-7c-.275 0-.5-.225-.5-.5s.226-.499.5-.499h7c.275 0 .5.224.5.499s-.225.5-.5.5zm-6.5-2.499c0-.276.224-.5.5-.5h5c.275 0 .5.224.5.5s-.225.5-.5.5h-5c-.277 0-.5-.224-.5-.5zm11 2.499c-1.104 0-2.001-.895-2.001-1.999s.896-2 2.001-2c1.104 0 2 .896 2 2s-.896 1.999-2 1.999zm0-12.999v5.999h-16v-5.999h16zm-24-13.001h31.999v3h-31.999zm0 5h31.999v3h-31.999z"></path>
                                                    </svg>
                                                </i>
                                                <div class="meta-inner-wrapper">
                                                    <span class="meta-item-label">Garages</span>
                                                    <span class="meta-item-value">2</span>
                                                </div>
                                            </div>
                                            <div class="meta-item meta-property-type">
                                                <i class="meta-item-icon icon-ptype">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                                        <path class="meta-icon" fill-rule="evenodd" clip-rule="evenodd" fill="#0DBAE8" d="M24 48.001c-13.255 0-24-10.745-24-24.001 0-13.254 10.745-24 24-24s24 10.746 24 24c0 13.256-10.745 24.001-24 24.001zm10-27.001l-10-8-10 8v11c0 1.03.888 2.001 2 2.001h3.999v-9h8.001v9h4c1.111 0 2-.839 2-2.001v-11z"></path>
                                                    </svg>
                                                </i>
                                                <div class="meta-inner-wrapper">
                                                    <span class="meta-item-label">Type</span>
                                                    <span class="meta-item-value">Single Family Home</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- .property-meta -->
                                    </div>
                                </article>
                            </div>
                        </div>
                    </section>
                    <section id="lidd_mc_widget-2" class="widget clearfix widget_lidd_mc_widget">
                        <h3 class="widget-title">Mortgage Calculator</h3>
                        <form action="#" id="lidd_mc_form" class="lidd_mc_form" method="post">
                            <div class="lidd_mc_input lidd_mc_input_light lidd_mc_input_responsive">
                                <label for="lidd_mc_total_amount">Total Amount</label>
                                <input type="text" name="lidd_mc_total_amount" id="lidd_mc_total_amount" placeholder="$">
                                <span id="lidd_mc_total_amount-error"></span>
                            </div>
                            <div class="lidd_mc_input lidd_mc_input_light lidd_mc_input_responsive"><label for="lidd_mc_down_payment">Down
                                    Payment</label>
                                <input type="text" name="lidd_mc_down_payment" id="lidd_mc_down_payment" placeholder="$">
                                <span id="lidd_mc_down_payment-error"></span>
                            </div>
                            <div class="lidd_mc_input lidd_mc_input_light lidd_mc_input_responsive">
                                <label for="lidd_mc_interest_rate">Interest Rate</label>
                                <input type="text" name="lidd_mc_interest_rate" id="lidd_mc_interest_rate" placeholder="%">
                                <span id="lidd_mc_interest_rate-error"></span>
                            </div>
                            <div class="lidd_mc_input lidd_mc_input_light lidd_mc_input_responsive">
                                <label for="lidd_mc_amortization_period">Amortization Period</label>
                                <input type="text" name="lidd_mc_amortization_period" id="lidd_mc_amortization_period" placeholder="years">
                                <span id="lidd_mc_amortization_period-error"></span>
                            </div>
                            <div class="lidd_mc_input lidd_mc_input_light lidd_mc_input_responsive">
                                <label for="lidd_mc_payment_period">Payment Period</label>
                                <span class="lidd_mc_select lidd_mc_select_fancy_light">
                                    <select name="lidd_mc_payment_period" id="lidd_mc_payment_period">
                                        <option value="12">Monthly</option>
                                        <option value="26">Bi-Weekly</option>
                                        <option value="52">Weekly</option>
                                    </select>
                                 </span>
                                <span id="lidd_mc_payment_period-error"></span>
                            </div>
                            <input type="hidden" name="lidd_mc_compounding_period" id="lidd_mc_compounding_period" value="2">
                            <input type="hidden" name="lidd_mc_currency" id="lidd_mc_currency" value="$">
                            <input type="hidden" name="lidd_mc_currency_code" id="lidd_mc_currency_code" value="">
                            <div class="lidd_mc_input">
                                <input type="submit" name="lidd_mc_submit" id="lidd_mc_submit" value="Calculate" class="real-btn">
                            </div>
                        </form>
                        <div id="lidd_mc_details" style="display: none;">
                            <div id="lidd_mc_results">
                                <p>Monthly Payment: <b class="lidd_mc_b">$1,242.86 </b></p>
                            </div>
                            <img id="lidd_mc_inspector" src="images/icon_inspector.png" alt="Details">
                            <div id="lidd_mc_summary" class="lidd_mc_summary lidd_mc_summary_light" style="display: none;">
                                <p>For a mortgage of <b class="lidd_mc_b">$</b><b class="lidd_mc_b">54,654.00</b> amortized over
                                    <b class="lidd_mc_b">4</b> years, your <b class="lidd_mc_b">Monthly</b> payment is:
                                </p>
                                <p>Mortgage Payment: <b class="lidd_mc_b"><b class="lidd_mc_b">$1,242.86 </b></b></p>
                                <p>Total Mortgage with Interest: <b class="lidd_mc_b"><b class="lidd_mc_b">$59,657.50 </b></b></p>
                            </div>
                        </div>
                    </section>
                </aside>
                <!-- .sidebar -->
            </div>
            <!-- .site-sidebar-content -->
        </div>
        <!-- .container-property-single -->
    </div>
</x-frontend-layout>
