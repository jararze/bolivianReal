<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bienes Raíces')</title>

    <!-- Google font -->
    <link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet'>
    <link
        href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic,900'
        rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Dosis:400,700,600,500' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Estilos existentes -->
    <link href="{{ asset('assets/front/js/flexslider/flexslider.css') }}" rel="stylesheet">
    <link href="{{ asset("assets/front/js/lightslider/css/lightslider.min.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/front/js/owl.carousel/owl.carousel.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/front/js/swipebox/css/swipebox.min.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/front/js/select2/select2.css") }}" rel="stylesheet">
    <link href="{{ asset('assets/front/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset("assets/front/js/magnific-popup/magnific-popup.css")}}" rel="stylesheet">
    <link href="{{ asset('assets/front/css/main.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="{{ asset('assets/front/css/theme.css') }}" rel="stylesheet">

    <link href="{{ route('theme.dynamic.css') }}" rel="stylesheet">

    @stack('styles')
    <style>
        /* Mejoras para el header existente */
        .site-header.header-variation-two {
            position: relative;
            z-index: 1000;
        }

        .site-header .container-fluid {
            background: rgba(0, 0, 0, 0.9) !important;
            transition: all 0.3s ease;
        }

        /* Mejoras para el logo */
        .site-logo img {
            transition: transform 0.3s ease !important;
        }

        .site-logo:hover img {
            transform: scale(1.05) !important;
        }

        /* Mejoras para el menú principal */
        .main-menu {
            align-items: center !important;
            height: 80px;
        }

        .main-menu li {
            position: relative;
            margin: 0 2px;
        }

        .main-menu li a {
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            font-weight: 500 !important;
            position: relative !important;
            text-decoration: none !important;
        }

        .main-menu li a:hover {
            background: rgba(255, 255, 255, 0.15) !important;
            transform: translateY(-2px) !important;
            color: #f8f9fa !important;
        }

        /* Efecto de línea inferior para enlaces activos */
        .main-menu li a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 8px;
            left: 50%;
            background: linear-gradient(90deg, #007bff, #0056b3);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .main-menu li a:hover::after,
        .main-menu li.current-menu-item a::after {
            width: 70%;
        }

        /* Estado activo mejorado */
        .main-menu li.current-menu-item a {
            background: rgba(0, 123, 255, 0.2) !important;
            color: #ffffff !important;
        }

        /* Animación de entrada */
        .site-header {
            animation: slideDown 0.6s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Responsive improvements */
        @media (max-width: 1200px) {
            .main-menu li a {
                padding: 15px 20px !important;
            }
        }

        @media (max-width: 992px) {
            .site-logo {
                min-height: 80px !important;
                height: 80px !important;
            }

            .site-logo img {
                height: 70px !important;
            }

            .main-menu {
                flex-wrap: wrap !important;
                height: auto !important;
                padding: 10px 0 !important;
            }

            .main-menu li a {
                padding: 12px 15px !important;
                font-size: 14px !important;
            }
        }

        @media (max-width: 768px) {
            .col-lg-3[style*="width: 17%"] {
                width: 100% !important;
                text-align: center;
                margin-bottom: 15px;
            }

            .site-main-nav {
                float: none !important;
                width: 100% !important;
            }

            .main-menu {
                justify-content: center !important;
                flex-direction: column !important;
                gap: 5px;
            }

            .main-menu li {
                width: 100%;
                text-align: center;
            }

            .main-menu li a {
                display: block !important;
                padding: 12px 20px !important;
                margin: 2px 0 !important;
            }
        }

        /* Efecto hover mejorado para móviles */
        @media (hover: none) {
            .main-menu li a:hover {
                transform: none !important;
            }
        }
    </style>
    <style>
        /* Contenedor principal del buscador */
        .advance-search.main-advance-search {
            background: linear-gradient(135deg, #dee7ee, #dee7ee);
            padding: 20px 0;
            margin: 0;
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
        }

        .advance-search.main-advance-search .search-fields-grid .option-bar {
            width: 100% !important;
        }

        .advance-search.main-advance-search .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Título mejorado */
        .ssearch-title {
            color: #ffffff !important;
            font-size: 2rem !important;
            font-weight: 700 !important;
            text-align: center !important;
            margin-bottom: 25px !important;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5) !important;
            line-height: 1.2 !important;
        }

        /* Grid principal para los campos */
        .search-fields-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            align-items: end;
            margin-bottom: 20px;
        }

        /* Área de botones separada */
        .search-buttons-area {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
        }

        /* Estilos para los campos */
        .option-bar {
            position: relative;
        }

        .option-bar select,
        .option-bar input[type="text"] {
            width: 100%;
            padding: 10px 14px;
            border: none;
            border-bottom: 2px solid rgba(255, 255, 255, 0.7);
            border-radius: 0;
            font-size: 14px;
            background: transparent;
            color: rgba(0, 0, 0, 0.6) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: inherit;
            appearance: none;
            box-shadow: none;
        }

        .option-bar select:focus,
        .option-bar input[type="text"]:focus {
            outline: none;
            border-bottom-color: #ffffff;
            background: transparent;
            box-shadow: none;
            transform: none;
        }

        .option-bar select::placeholder,
        .option-bar input[type="text"]::placeholder {
            color: rgba(0, 0, 0, 0.6) !important;
        }

        .option-bar select option {
            background: #dee7ee;
            color: #333;
        }

        .option-bar select:focus option {
            background: #dee7ee !important;
        }

        /* Icono de flecha para selects */
        .option-bar select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='white' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e") !important;
            /*background-position: right 12px center;*/
            /*background-repeat: no-repeat;*/
            /*background-size: 16px;*/
            /*padding-right: 40px;*/
        }

        /* Botón de más opciones mejorado */
        .more-options-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #34495e, #2c3e50);
            border: none;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            box-shadow: 0 3px 10px rgba(44, 62, 80, 0.3);
        }

        .more-options-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(44, 62, 80, 0.4);
            background: linear-gradient(135deg, #2c3e50, #34495e);
        }

        .more-options-btn svg {
            transition: transform 0.3s ease;
            width: 18px;
            height: 18px;
        }

        .more-options-btn.active svg {
            transform: rotate(45deg);
        }

        /* Botón de búsqueda mejorado */
        .form-submit-btn {
            background: linear-gradient(135deg, #5a6c7d, #34495e) !important;
            color: white !important;
            border: none !important;
            padding: 10px 30px !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: 0 3px 10px rgba(52, 73, 94, 0.3) !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }

        .form-submit-btn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 15px rgba(52, 73, 94, 0.4) !important;
            background: linear-gradient(135deg, #34495e, #5a6c7d) !important;
        }

        /* Sección de opciones adicionales */
        .extra-search-fields {
            max-height: 0;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            margin-top: 0;
        }

        .extra-search-fields.show {
            max-height: 1000px;
            opacity: 1;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 2px solid rgba(255, 255, 255, 0.3);
        }

        .extra-search-fields .title {
            color: #ffffff;
            font-size: 1.2rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
        }

        .hidden-options-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .hidden-option-item select,
        .hidden-option-item input {
            width: 100%;
            padding: 10px 14px;
            border: none;
            border-bottom: 2px solid rgba(255, 255, 255, 0.7);
            border-radius: 0;
            font-size: 14px;
            background: transparent;
            color: black;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: none;
            appearance: none;
        }

        .hidden-option-item select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='white' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 40px;
        }

        .hidden-option-item select:focus,
        .hidden-option-item input:focus {
            outline: none;
            border-bottom-color: #ffffff;
            background: transparent;
            box-shadow: none;
            transform: none;
        }

        .hidden-option-item select::placeholder,
        .hidden-option-item input::placeholder {
            color: rgba(0, 0, 0, 0.8);
        }

        .hidden-option-item select option {
            background: white;
            color: #333;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .advance-search.main-advance-search {
                padding: 20px;
                margin: 10px;
                border-radius: 8px;
            }

            .ssearch-title {
                font-size: 2rem !important;
                margin-bottom: 20px !important;
            }

            .search-fields-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .search-buttons-area {
                flex-direction: column;
                gap: 15px;
            }

            .more-options-btn,
            .form-submit-btn {
                width: 100%;
                max-width: 300px;
            }

            .hidden-options-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .search-fields-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .advance-search.main-advance-search {
                padding: 15px;
            }

            .ssearch-title {
                font-size: 1.8rem !important;
            }

            .option-bar select,
            .option-bar input[type="text"],
            .hidden-option-item select,
            .hidden-option-item input {
                padding: 12px 14px;
                font-size: 14px;
            }
        }

        /* Animación de entrada */
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

        .advance-search.main-advance-search {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

    </style>


</head>
<body class="inspiry-slider-two">
<div class="page-loader">
    <img class="page-loader-img" src="{{ asset('assets/front/images/page-loader-img.gif') }}" alt="Cargando..."/>
</div>


<x-frontend.header-sub/>
{{--    <x-frontend.header/>--}}
@if(request()->routeIs('frontend.home'))

    <x-frontend.slider/>

@endif

@isset($header)
    <div class="page-head "
         style="background: url({{ asset('assets/front/images/banner2.jpg')}}) #494c53 no-repeat center top;  background-size: cover;">
        <div class="container">
            <div class="page-head-content">
                <h1 class="page-title"><span>{{ $header }}</span></h1>
            </div>
        </div>
    </div>
@endisset

<div id="content-wrapper" class="site-content-wrapper {{ (request()->routeIs('frontend.home')) ? '' : 'site-pages' }}">
    <div id="content" class="site-content {{ (request()->routeIs('frontend.home')) ? 'layout-wide' : 'layout-boxed' }}">

        @if(request()->routeIs('frontend.home'))
            <main id="main" class="site-main">
                <x-frontend.search/>
                {{ $slot }}
            </main>
        @else
            <div class="container">
                {{ $slot }}
            </div>
        @endif


    </div>
</div>

<x-frontend.footer/>


<!-- Modal de login -->
<x-frontend.auth-modal/>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Scripts -->
<script src="{{ asset('assets/front/js/jquery-1.12.3.min.js') }}"></script>
<script src="{{ asset('assets/front/js/flexslider/jquery.flexslider-min.js') }}"></script>
<script src="{{ asset("assets/front/js/lightslider/js/lightslider.min.js") }}"></script>
<script src="{{ asset("assets/front/js/select2/select2.min.js") }}"></script>
<script src="{{ asset("assets/front/js/owl.carousel/owl.carousel.min.js") }}"></script>
<script src="{{ asset("assets/front/js/swipebox/js/jquery.swipebox.min.js") }}"></script>
<script src="{{ asset("assets/front/js/jquery.hoverIntent.js") }}"></script>
<script src="{{ asset("assets/front/js/jquery.validate.min.js") }}"></script>
<script src="{{ asset("assets/front/js/jquery.form.js") }}"></script>
<script src="{{ asset("assets/front/js/transition.js") }}"></script>
<script src="{{ asset("assets/front/js/jquery.appear.js") }}"></script>
<script src="{{ asset("assets/front/js/modal.js") }}"></script>
<script src="{{ asset("assets/front/js/meanmenu/jquery.meanmenu.min.js") }}"></script>
<script src="{{ asset('assets/front/js/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
<script src="{{ asset("assets/front/js/jquery.placeholder.min.js") }}"></script>
<script src="{{ asset('assets/front/js/custom.js') }}"></script>
@stack('scripts')
<script>
    (function ($) {
        "use strict";

        if (jQuery().validate) {

            //Login
            $('#login-form').validate();

            //Register
            $('#register-form').validate();

            //Forgot Password
            $('#forgot-form').validate();
        }

        /*-----------------------------------------------------------------------------------*/
        /* Modal dialog for Login and Register
         /*-----------------------------------------------------------------------------------*/
        var loginModal = $('#login-modal'),
            modalSections = loginModal.find('.modal-section');

        $('.activate-section').on('click', function (event) {
            var targetSection = $(this).data('section');
            modalSections.slideUp();
            loginModal.find('.' + targetSection).slideDown();
            event.preventDefault();
        });

    })(jQuery);
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll para enlaces internos (si los tienes)
        const menuLinks = document.querySelectorAll('.main-menu a[href^="#"]');
        menuLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Agregar efecto de "loading" al hacer click en enlaces
        const allMenuLinks = document.querySelectorAll('.main-menu a');
        allMenuLinks.forEach(link => {
            link.addEventListener('click', function() {
                // Solo si no es un enlace interno
                if (!this.href.includes('#')) {
                    this.style.opacity = '0.7';
                    this.style.transform = 'scale(0.95)';
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        // Inicializar Select2 si está disponible
        if ($.fn.select2) {
            $('.search-select').select2({
                dropdownAutoWidth: true,
                width: '100%',
                minimumResultsForSearch: 6
            });

            // Filtrado de vecindarios basado en la ciudad seleccionada
            const $citySelect = $('#location');
            const $neighborhoodSelect = $('#neighborhood');

            function filterNeighborhoods() {
                const cityId = $citySelect.val();

                // Obtener todos los vecindarios originales si no los tenemos guardados
                if (!window.allNeighborhoods) {
                    window.allNeighborhoods = [];
                    $neighborhoodSelect.find('option').each(function () {
                        window.allNeighborhoods.push({
                            value: $(this).val(),
                            text: $(this).text(),
                            cityId: $(this).data('city')
                        });
                    });
                }

                // Limpiar el select de vecindarios
                $neighborhoodSelect.empty();

                // Filtrar y añadir las opciones relevantes
                window.allNeighborhoods.forEach(function (neighborhood) {
                    if (neighborhood.value === 'any' || cityId === 'any' || neighborhood.cityId == cityId) {
                        $neighborhoodSelect.append(new Option(neighborhood.text, neighborhood.value));
                    }
                });

                // Actualizar el Select2 para reflejar los cambios
                $neighborhoodSelect.val('any').trigger('change');
            }

            // Aplicar filtro inicial
            filterNeighborhoods();

            // Filtrar cuando cambie la ciudad
            $citySelect.on('change', filterNeighborhoods);
        }

        // Aplicar parámetros de URL a los selects si existen
        function applyUrlParams() {
            const urlParams = new URLSearchParams(window.location.search);

            // Para cada parámetro en la URL, establecer el valor en el select correspondiente
            for (const [key, value] of urlParams.entries()) {
                const $element = $('[name="' + key + '"]');
                if ($element.length > 0) {
                    $element.val(value);

                    // Si es un select2, disparar el evento change
                    if ($element.hasClass('search-select')) {
                        $element.trigger('change');
                    }
                }
            }

            // Si hay parámetros avanzados, mostrar los campos avanzados
            const hasAdvancedParams = [
                'price_range', 'size_range', 'bedrooms', 'bathrooms', 'garage',
                'is_project', 'property_age', 'featured', 'keyword', 'code'
            ].some(param => urlParams.has(param) && urlParams.get(param) !== 'any' && urlParams.get(param) !== '');

            if (hasAdvancedParams) {
                $('#advanced-search-fields').show();
                $('#toggle-advanced-search i').removeClass('fa-plus').addClass('fa-minus');
            }
        }

        // Aplicar parámetros de URL cuando se carga la página
        applyUrlParams();
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('toggle-more-options');
        const moreOptions = document.getElementById('more-options');

        if (toggleBtn && moreOptions) {
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Toggle la clase show con animación
                moreOptions.classList.toggle('show');
                toggleBtn.classList.toggle('active');

                // Cambiar el icono con animación suave
                const svg = toggleBtn.querySelector('svg path');
                if (moreOptions.classList.contains('show')) {
                    // Icono de cerrar (X)
                    svg.setAttribute('d', 'M15.898 4.045c.39-.39.39-1.024 0-1.414s-1.024-.39-1.414 0L10 7.115 5.516 2.631c-.39-.39-1.024-.39-1.414 0s-.39 1.024 0 1.414L8.586 8.529 4.102 13.013c-.39.39-.39 1.024 0 1.414.195.195.451.293.707.293s.512-.098.707-.293L10 9.943l4.484 4.484c.195.195.451.293.707.293s.512-.098.707-.293c.39-.39.39-1.024 0-1.414L11.414 8.529l4.484-4.484z');
                    toggleBtn.setAttribute('title', 'Ocultar opciones');
                } else {
                    // Icono de más (+)
                    svg.setAttribute('d', 'M10 0c.553 0 1 .447 1 1v8h8c.553 0 1 .447 1 1s-.447 1-1 1h-8v8c0 .553-.447 1-1 1s-1-.447-1-1v-8H1c-.553 0-1-.447-1-1s.447-1 1-1h8V1c0-.553.447-1 1-1z');
                    toggleBtn.setAttribute('title', 'Más opciones');
                }
            });

            // Smooth scroll cuando se abre
            toggleBtn.addEventListener('click', function() {
                setTimeout(() => {
                    if (moreOptions.classList.contains('show')) {
                        moreOptions.scrollIntoView({
                            behavior: 'smooth',
                            block: 'nearest'
                        });
                    }
                }, 200);
            });
        }
    });
</script>
</body>
</html>
