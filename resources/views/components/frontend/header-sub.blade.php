<div id="mobile-header" class="mobile-header hidden-md hidden-lg">
    <div class="contact-number">
        <svg xmlns="http://www.w3.org/2000/svg" class="contacts-icon-container" width="24" height="24" viewBox="0 0 24 24">
            <path class="contacts-icon" fill-rule="evenodd" clip-rule="evenodd" fill="#0080BC" d="M1.027 4.846l-.018.37.01.181c.068 9.565 7.003 17.42 15.919 18.48.338.075 1.253.129 1.614.129.359 0 .744-.021 1.313-.318.328-.172.448-.688.308-1.016-.227-.528-.531-.578-.87-.625-.435-.061-.905 0-1.521 0-1.859 0-3.486-.835-4.386-1.192l.002.003-.076-.034c-.387-.156-.696-.304-.924-.422-3.702-1.765-6.653-4.943-8.186-8.896-.258-.568-1.13-2.731-1.152-6.009h.003l-.022-.223c0-1.727 1.343-3.128 2.999-3.128 1.658 0 3.001 1.401 3.001 3.128 0 1.56-1.096 2.841-2.526 3.079l.001.014c-.513.046-.914.488-.914 1.033 0 .281.251 1.028.251 1.028.015 0 .131.188.119.188-.194-.539 1.669 5.201 7.021 7.849-.001.011.636.309.636.309.47.3 1.083.145 1.37-.347.09-.151.133-.32.14-.488.356-1.306 1.495-2.271 2.863-2.271 1.652 0 2.991 1.398 2.991 3.12 0 .346-.066.671-.164.981-.3.594-.412 1.21.077 1.699.769.769 1.442-.144 1.442-.144.408-.755.643-1.625.643-2.554 0-2.884-2.24-5.222-5.007-5.222-1.947 0-3.633 1.164-4.46 2.858-2.536-1.342-4.556-3.59-5.656-6.344 1.848-.769 3.154-2.647 3.154-4.849 0-2.884-2.241-5.222-5.007-5.222-2.41 0-4.422 1.777-4.897 4.144l-.091.711z"/>
        </svg>
        <span class="desktop-version hidden-xs">{{ site_config('general_info.phone', '') }}</span>
        <a class="mobile-version visible-xs-inline-block" href="tel:{{ site_config('general_info.phone', '') }}" title="Realizar una llamada">{{ site_config('general_info.phone', '') }}</a>
    </div>
    <!-- .contact-number -->
    <div class="mobile-header-nav">
        <ul class="user-nav">
            <li><a class="login-register-link" href="#login-modal" data-toggle="modal"><i class="fa fa-sign-in"></i>Iniciar sesión / Registrarse</a></li>
            <!--<li><a href="index.html"><i class="fa fa-sign-out"></i>Cerrar sesión</a></li>-->
            <li><a href="profile.html"><i class="fa fa-user"></i>Perfil</a></li>
            <li><a href="my-properties.html"><i class="fa fa-th-list"></i>Mis Propiedades</a></li>
            <li><a href="favorites.html"><i class="fa fa-star"></i>Favoritos</a></li>
            <li><a class="submit-property-link" href="submit-property.html"><i class="fa fa-plus-circle"></i>Enviar Propiedad</a></li>
        </ul>
        <!-- .user-nav -->
        <div class="social-networks header-social-nav">
            <a class="tiktok" target="_blank" href="https://www.tiktok.com/@bolivianrealestate"><i class="fa fa-tiktok"></i></a><a class="facebook" target="_blank" href="https://www.facebook.com/bolivianrealestate"><i class="fa fa-facebook"></i></a><a class="instagram" target="_blank" href="https://www.instagram.com/bolivianrealestate.srl"><i class="fa fa-instagram"></i></a>
        </div>
        <!-- .social-networks -->
    </div>
</div>

<header class="site-header header header-variation-two">
    <!-- MENÚ PRINCIPAL CON FONDO AL 100% PERO CONTENIDO ALINEADO A CONTAINER -->
    <div class="container-fluid" style="background-color: #494c53;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav id="site-main-nav" class="site-main-nav" style="float: left !important;">
                        <ul class="main-menu clearfix" style="display: flex; justify-content: flex-start;">
                            <li class="{{ Route::currentRouteName() == 'frontend.home' ? 'current-menu-item' : '' }}">
                                <a href="{{ route('frontend.home') }}" style="padding: 15px 30px; color: #fff;">Inicio</a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'frontend.properties.search' ? 'current-menu-item' : '' }}">
                                <a href="{{ route('frontend.properties.search') }}" style="padding: 15px 30px; color: #fff;">Propiedades</a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'frontend.about' ? 'current-menu-item' : '' }}">
                                <a href="{{ route('frontend.about') }}" style="padding: 15px 30px; color: #fff;">Quienes somos</a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'frontend.services' ? 'current-menu-item' : '' }}">
                                <a href="{{ route('frontend.services') }}" style="padding: 15px 30px; color: #fff;">Servicios</a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'frontend.promotions' ? 'current-menu-item' : '' }}">
                                <a href="{{ route('frontend.promotions') }}" style="padding: 15px 30px; color: #fff;">Promociones</a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'frontend.contact' ? 'current-menu-item' : '' }}">
                                <a href="{{ route('frontend.contact') }}" style="padding: 15px 30px; color: #fff;">Contáctanos</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN DEL MENÚ PRINCIPAL -->

    <!-- ESTRUCTURA ORIGINAL -->
    <div class="container">
        <div class="row zero-horizontal-margin">
            <div class="col-lg-3 zero-horizontal-padding" style="width: 17% !important;">
                <div id="site-logo" class="site-logo" style="min-height: 100px !important; padding-bottom: 0 !important; height: 100px !important;">
                    <div class="logo-inner-wrapper" style="display: block !important;">
                        <a href="{{ route('frontend.home') }}">
                            <img src="{{ asset(site_config('appearance_settings.logo.path', 'default-logo.png')) }}"
                                 alt="{{ site_config('appearance_settings.site_name', 'Logo') }}"
                                 style="height: 90px; vertical-align: top"/>
                        </a>
                    </div>
                </div>
            </div>
            <!-- .left-column -->
            <div class="col-lg-9 zero-horizontal-padding hidden-xs hidden-sm" style="width: 83% !important;">
                <div class="header-top clearfix" style="margin-bottom: 47px !important;">
                    <div class="social-networks header-social-nav">
                        <a class="tiktok" target="_blank" href="https://www.tiktok.com/@bolivianrealestate"><i class="fa fa-tiktok"></i></a>
                        <a class="facebook" target="_blank" href="https://www.facebook.com/bolivianrealestate"><i class="fa fa-facebook"></i></a>
                        <a class="instagram" target="_blank" href="https://www.instagram.com/bolivianrealestate.srl"><i class="fa fa-instagram"></i></a>
                        <!--<a class="twitter" target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                        <a class="facebook" target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                        <a class="gplus" target="_blank" href="#"><i class="fa fa-google-plus"></i></a>-->
                    </div>
                    <!-- .social-networks -->
                    <ul class="user-nav">
                        @auth
                            <!-- Usuario logueado -->
                            <li><a class="login-register-link" href="{{ route('dashboard') }}"><i class="fa fa-user"></i>Mi Perfil</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <a class="login-register-link" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="fa fa-sign-out"></i>Cerrar Sesión
                                    </a>
                                </form>
                            </li>
                        @else
                            <!-- Usuario no logueado -->
                            <li><a class="login-register-link" href="{{ route("login") }}" data-toggle="modal"><i class="fa fa-sign-in"></i>Entrar</a></li>
                            <li><a class="login-register-link" href="#login-modal" data-toggle="modal"><i class="fa fa-sign-in"></i>Registrate</a></li>
                        @endauth
                        <li><a class="submit-property-link" href="{{ route("frontend.project") }}"><i class="fa fa-star"></i>Proyecto</a></li>
                        <li><a class="submit-property-link" href="{{ route("frontend.submit-property") }}"><i class="fa fa-plus-circle"></i>Quieres vender/alquilar</a></li>
                    </ul>
                    <!-- .user-nav -->
                    <div class="contact-number">
                        <svg xmlns="http://www.w3.org/2000/svg" class="contacts-icon-container" width="24" height="24" viewBox="0 0 24 24">
                            <path class="contacts-icon" fill-rule="evenodd" clip-rule="evenodd" fill="#0080BC" d="M1.027 4.846l-.018.37.01.181c.068 9.565 7.003 17.42 15.919 18.48.338.075 1.253.129 1.614.129.359 0 .744-.021 1.313-.318.328-.172.448-.688.308-1.016-.227-.528-.531-.578-.87-.625-.435-.061-.905 0-1.521 0-1.859 0-3.486-.835-4.386-1.192l.002.003-.076-.034c-.387-.156-.696-.304-.924-.422-3.702-1.765-6.653-4.943-8.186-8.896-.258-.568-1.13-2.731-1.152-6.009h.003l-.022-.223c0-1.727 1.343-3.128 2.999-3.128 1.658 0 3.001 1.401 3.001 3.128 0 1.56-1.096 2.841-2.526 3.079l.001.014c-.513.046-.914.488-.914 1.033 0 .281.251 1.028.251 1.028.015 0 .131.188.119.188-.194-.539 1.669 5.201 7.021 7.849-.001.011.636.309.636.309.47.3 1.083.145 1.37-.347.09-.151.133-.32.14-.488.356-1.306 1.495-2.271 2.863-2.271 1.652 0 2.991 1.398 2.991 3.12 0 .346-.066.671-.164.981-.3.594-.412 1.21.077 1.699.769.769 1.442-.144 1.442-.144.408-.755.643-1.625.643-2.554 0-2.884-2.24-5.222-5.007-5.222-1.947 0-3.633 1.164-4.46 2.858-2.536-1.342-4.556-3.59-5.656-6.344 1.848-.769 3.154-2.647 3.154-4.849 0-2.884-2.241-5.222-5.007-5.222-2.41 0-4.422 1.777-4.897 4.144l-.091.711z"/>
                        </svg>
                        <span class="desktop-version hidden-xs">{{ site_config('general_info.phone', '') }}</span>
                        <a class="mobile-version visible-xs-inline-block" href="tel:{{ site_config('general_info.phone', '') }}" title="Make a Call">{{ site_config('general_info.phone', '') }}</a>
                    </div>
                    <!-- .contact-number -->
                </div>
                <!-- .header-top -->
                <div class="header-bottom clearfix" style="top: 53px; position: absolute !important; z-index: 1050; width: 83% !important;">
                    <div class="advance-search header-advance-search">
                        <form class="advance-search-form" action="{{ route('frontend.properties.search') }}" method="get">
                            <div class="inline-fields clearfix">
                                <div class="option-bar property-location">
                                    <select name="location" id="location" class="search-select">
                                        <option value="any">CIUDAD</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="option-bar property-neighborhood">
                                    <select name="neighborhood_id" id="neighborhood" class="search-select">
                                        <option value="any">ZONA</option>
                                        @foreach($neighborhoods as $neighborhood)
                                            <option value="{{ $neighborhood->id }}" data-city="{{ $neighborhood->city_id }}">{{ $neighborhood->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="option-bar property-type">
                                    <select name="propertytype_id" id="select-property-type" class="search-select">
                                        <option value="any">TIPO DE PROPIEDAD</option>
                                        @foreach($propertyTypes as $propertyType)
                                            <option value="{{ $propertyType->id }}">{{ $propertyType->type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="option-bar property-status">
                                    <select name="service_type_id" id="select-status" class="search-select">
                                        <option value="any">ESTADO</option>
                                        @foreach($serviceTypes as $serviceType)
                                            <option value="{{ $serviceType->id }}">{{ $serviceType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="option-bar form-control-buttons">
                                    <a class="hidden-fields-reveal-btn" href="#" id="toggle-advanced-search">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-plus-container" width="20" height="20" viewBox="0 0 20 20">
                                            <g fill="#C15302">
                                                <path class="icon icon-minus" d="M10.035 20.035c-2.092 0-4.313-.563-5.688-1.938-.406-.406-.688-.73-.688-1.141 0-.424.266-.859.891-.797.257.025.585.172.75.347 1.327.969 2.967 1.529 4.735 1.529 4.437 0 8.001-3.564 8.001-8.001 0-4.436-3.564-8-8.001-8-4.436 0-8 3.564-8 8 0 1.226.337 2.306.829 3.344 0 .001.277.495.313.938.04.491-.234.703-.656.875-.377.153-.859-.109-1.083-.452-.87-1.335-1.403-2.999-1.403-4.704 0-5.414 4.586-10 10-10 5.413 0 10 4.586 10 10 0 5.413-4.587 10-10 10zm-12-14v8-8zm16 5h-8c-.553 0-1-.447-1-1 0-.553.447-1 1-1h8c.553 0 1 .447 1 1 0 .553-.447 1-1 1z"/>
                                                <path class="icon icon-plus" d="M10.226 15.035c-.553 0-1-.447-1-1v-8c0-.553.447-1 1-1 .553 0 1 .447 1 1v8c0 .553-.447 1-1 1z"/>
                                            </g>
                                        </svg>
                                    </a>
                                    <input type="submit" value="BUSCAR" class="form-submit-btn">
                                </div>
                            </div>
                            <!-- .inline-fields -->

                            <div id="advanced-search-fields" style="display: none;" class="hidden-fields clearfix">
                                <!-- Campos de precio -->
                                <div class="option-bar property-price-range">
                                    <select name="price_range" id="select-price-range" class="search-select">
                                        <option value="any">Rango de precio</option>
                                        <option value="0-50000">Hasta $50,000</option>
                                        <option value="50000-100000">$50,000 - $100,000</option>
                                        <option value="100000-200000">$100,000 - $200,000</option>
                                        <option value="200000-300000">$200,000 - $300,000</option>
                                        <option value="300000-500000">$300,000 - $500,000</option>
                                        <option value="500000-1000000">$500,000 - $1,000,000</option>
                                        <option value="1000000-0">Más de $1,000,000</option>
                                    </select>
                                </div>

                                <!-- Campos de búsqueda por tamaño -->
                                <div class="option-bar property-size-range">
                                    <select name="size_range" id="select-size-range" class="search-select">
                                        <option value="any">Superficie (m²)</option>
                                        <option value="0-50">Hasta 50 m²</option>
                                        <option value="50-100">50 - 100 m²</option>
                                        <option value="100-150">100 - 150 m²</option>
                                        <option value="150-200">150 - 200 m²</option>
                                        <option value="200-300">200 - 300 m²</option>
                                        <option value="300-500">300 - 500 m²</option>
                                        <option value="500-0">Más de 500 m²</option>
                                    </select>
                                </div>

                                <!-- Dormitorios -->
                                <div class="option-bar property-bedrooms">
                                    <select name="bedrooms" id="select-bedrooms" class="search-select">
                                        <option value="any">Dormitorios</option>
                                        <option value="1">Al menos 1</option>
                                        <option value="2">Al menos 2</option>
                                        <option value="3">Al menos 3</option>
                                        <option value="4">Al menos 4</option>
                                        <option value="5">5 o más</option>
                                    </select>
                                </div>

                                <!-- Baños -->
                                <div class="option-bar property-bathrooms">
                                    <select name="bathrooms" id="select-bathrooms" class="search-select">
                                        <option value="any">Baños</option>
                                        <option value="1">Al menos 1</option>
                                        <option value="2">Al menos 2</option>
                                        <option value="3">Al menos 3</option>
                                        <option value="4">4 o más</option>
                                    </select>
                                </div>

                                <!-- Garajes -->
                                <div class="option-bar property-garage">
                                    <select name="garage" id="select-garage" class="search-select">
                                        <option value="any">Garajes</option>
                                        <option value="1">Al menos 1</option>
                                        <option value="2">Al menos 2</option>
                                        <option value="3">3 o más</option>
                                    </select>
                                </div>

                                <!-- Tipos de propiedad específicos -->
                                <div class="option-bar property-is-project">
                                    <select name="is_project" id="select-is-project" class="search-select">
                                        <option value="any">Categoría</option>
                                        <option value="1">Proyecto en construcción</option>
                                        <option value="0">Propiedad terminada</option>
                                    </select>
                                </div>

                                <div class="option-bar property-age">
                                    <select name="property_age" id="select-property-age" class="search-select">
                                        <option value="any">ANTIGÜEDAD</option>
                                        <option value="new">A estrenar</option>
                                        <option value="less-than-5">Menos de 5 años</option>
                                        <option value="5-to-10">Entre 5 y 10 años</option>
                                        <option value="10-to-20">Entre 10 y 20 años</option>
                                        <option value="more-than-20">Más de 20 años</option>
                                    </select>
                                </div>

                                <!-- Estado de destacados -->
                                <div class="option-bar property-featured">
                                    <select name="featured" id="select-featured" class="search-select">
                                        <option value="any">Mostrar solo</option>
                                        <option value="1">Propiedades destacadas</option>
                                        <option value="hot">Propiedades en demanda</option>
                                    </select>
                                </div>

                                <!-- Palabra clave para búsqueda en descripción, nombre, etc. -->
                                <div class="option-bar property-keyword">
                                    <input type="text" name="keyword" id="keyword-txt" value="" placeholder="Palabra clave o dirección">
                                </div>

                                <!-- Código de propiedad para búsqueda directa -->
                                <div class="option-bar property-id">
                                    <input type="text" name="code" id="property-id-txt" value="" placeholder="Código de propiedad">
                                </div>
                            </div>
                            <!-- .hidden-fields -->
                        </form>
                        <!-- .advance-search-form -->
                    </div>
                </div>
                <!-- .header-bottom -->
            </div>
            <!-- .right-column -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container -->
</header>





{{--<div class="page-head " style="background: url(images/banner.jpg) #494c53 no-repeat center top;  background-size: cover;">--}}
{{--    <div class="breadcrumb-wrapper">--}}
{{--        <div class="container">--}}
{{--            <nav>--}}
{{--                <ol class="breadcrumb">--}}
{{--                    <li><a href="#">Home</a></li>--}}
{{--                    <li><a href="#">Residential</a></li>--}}
{{--                    <li><a href="#">Villa</a></li>--}}
{{--                    <li class="active">Villa in Coral Gables</li>--}}
{{--                </ol>--}}
{{--            </nav>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <!-- .breadcrumb-wrapper -->--}}
{{--</div>--}}
