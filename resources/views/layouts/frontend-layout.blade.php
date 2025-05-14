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
                {{--                    <x-frontend.search/>--}}
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
    $(document).ready(function() {
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
                    $neighborhoodSelect.find('option').each(function() {
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
                window.allNeighborhoods.forEach(function(neighborhood) {
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
</body>
</html>
