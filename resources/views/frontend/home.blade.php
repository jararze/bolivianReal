@php
    $refreshTime = site_config('home_info.refresh_time', 60) * 1000; // Convertir a milisegundos
@endphp
@push('scripts')
    <script>
        function refreshRandomProperties() {
            const container = document.getElementById('random-properties-section');

            if (!container) {
                console.error('No se encontró el contenedor de propiedades aleatorias');
                return;
            }

            fetch('/api/refresh-random-properties')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(html => {
                    container.innerHTML = html;
                    // Reinicializar los sliders después de actualizar el contenido
                    if (typeof $ !== 'undefined') {
                        $('.gallery-slider-two').flexslider({
                            animation: "slide",
                            controlNav: true,
                            directionNav: false
                        });
                        $('.swipebox').swipebox();
                    }
                })
                .catch(error => {
                    console.error('Error al actualizar las propiedades:', error);
                });
        }

        // Esperar a que el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {

            const refreshTime = {{ $refreshTime }}; // Usar el valor de la configuración
            // Primera actualización después del tiempo configurado
            setTimeout(refreshRandomProperties, refreshTime);
            // Luego, actualizar según el tiempo configurado
            setInterval(refreshRandomProperties, refreshTime);
        });
    </script>
@endpush

@push('styles')
    <style>
        .video-section {
            position: relative;
            width: 100%;
            background-color: #2e3740;
        }

        .video-title-wrapper {
            background: rgba(0,0,0,0.8);
            padding: 20px 0;
        }

        .video-section .title {
            color: #fff;
            font-size: 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .full-width-video-wrapper {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 56.25%; /* Proporción 16:9 */
            background: #000;
        }

        .video-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .video-description {
            color: #333;
            font-size: 1.1rem;
            line-height: 1.6;
            margin: 0;
            padding: 20px 0;
        }

        @media (max-width: 768px) {
            .video-section .title {
                font-size: 1.5rem;
            }

            .video-description {
                font-size: 1rem;
                padding: 15px;
            }
        }

        @media (min-width: 1920px) {
            .full-width-video-wrapper {
                padding-bottom: 42.85%; /* Ajuste para pantallas más anchas */
            }
        }
    </style>
@endpush

<x-frontend-layout>

    @include('frontend.partials.random-properties')


    <section class="submit-property submit-property-one"
             style="background: url({{ asset('assets/front/images/demo/hiw-bg.jpg') }}) no-repeat center top; background-size: cover;">
        <div class="container">
            <header class="submit-property-header">
                <h3 class="sub-title">{{ site_config('home_info.upload_property_title', '¿Quieres vender o alquilar?') }}</h3>
                <p>
                    {{ site_config('home_info.upload_property_description', 'Contamos con una amplia base de clientes y las herramientas necesarias para encontrar el comprador ideal para tu propiedad.') }}
                </p>
            </header>
            <div class="row submit-property-placeholders">
                @foreach(site_config('home_info.steps', []) as $index => $step)
                    <div class="col-sm-4 submit-property-placeholder">
                        <div class="image-wrapper">
                            <img src="{{ asset('assets/front/images/demo/icon-'.($index + 1).'.svg') }}" alt="{{ $step['title'] ?? '' }}"/>
                        </div>
                        <h3 class="submit-property-title">{{ $step['title'] ?? '' }}</h3>
                        <p>
                            {{ $step['description'] ?? '' }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="featured-properties featured-properties-one">
        <div class="container">
            <header class="section-header" style="margin-top: 10px">
                <h3 class="section-title">Propiedades demandadas</h3>
            </header>
            <div class="row zero-horizontal-margin">
                @foreach($hotProperties as $property)
                    <div class="zero-horizontal-padding col-xs-6 col-md-3">
                        <article class="hentry featured-property-post featured-property-post-{{ $loop->iteration % 2 == 0 ? 'even' : 'odd' }}">
                            <div class="property-thumbnail">
                                <a href="{{ route('frontend.properties.show', $property->slug) }}">
                                    @if($property->thumbnail)
                                        <img class="img-responsive"
                                             src="{{ asset($property->thumbnail) }}"
                                             alt="{{ $property->name }}"
                                             style="width: 100%; height: 200px; object-fit: cover;">
                                    @else
                                        <img class="img-responsive"
                                             src="{{ asset('assets/front/images/property/property-12-660x600.jpg') }}"
                                             alt="{{ $property->name }}"
                                             style="width: 100%; height: 200px; object-fit: cover;">
                                    @endif
                                </a>
{{--                                @if($property->is_project)--}}
{{--                                    <div class="property-label">--}}
{{--                                        <span class="label label-success">PROYECTO</span>--}}
{{--                                    </div>--}}
{{--                                @endif--}}
                            </div>
                            <div class="property-description">
                                <header class="entry-header">
                                    <h4 class="entry-title">
                                        <a href="{{ route('frontend.properties.show', $property->slug) }}" rel="bookmark">
                                            {{ Str::limit($property->name, 30) }}
                                        </a>
                                    </h4>
                                    <div class="price-and-status">
                                    <span class="price">
                                        {{ $property->currency == '$us' ? '$' : 'Bs.' }}
                                        {{ number_format($property->lowest_price, 2) }}
                                    </span>
                                        <a href="#">
                                        <span class="property-status-tag">
                                            {{ $property->is_project ? 'PROYECTO' : 'EN VENTA' }}
                                        </span>
                                        </a>
                                    </div>
                                    @if($property->short_description)
                                        <p class="property-short-desc">
                                            {{ Str::limit($property->short_description, 100) }}
                                        </p>
                                    @endif
                                </header>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <section class="video-section" style="margin: 20px 0px">
        <div class="video-title-wrapper">
            <h2 class="title text-center mb-0">
                Conoce más sobre nosotros
            </h2>
        </div>

        <div class="full-width-video-wrapper">
            <div class="video-container">
                @php
                    $videoUrl = site_config('home_info.video_url');
                @endphp
                @if($videoUrl)
                    <iframe
                        src="{{ $videoUrl }}"
                        title="Video Corporativo"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                @else
                    {{-- Video por defecto o mensaje --}}
                    <iframe
                        src="https://www.youtube.com/embed/xBUtsWEU39I?si=nFadO4VcgPfW0GnB"
                        title="Video Corporativo"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                @endif
            </div>
        </div>

    </section>

    <div class="featured-properties meta-item-half featured-properties-two">
        <div class="container">
            <header class="section-header">
                <h3 class="section-title">{{ site_config('featured_properties.title', 'Propiedades destacadas') }}</h3>
            </header>
            <div class="row">
                @foreach($featuredProperties as $property)
                    <div class="col-xs-6 col-md-4">
                        <article class="hentry featured-property-post">
                            <div class="property-thumbnail">
                                <a href="{{ route('frontend.properties.show', $property->slug) }}">
                                    @if($property->thumbnail)
                                        <img class="img-responsive"
                                             src="{{ asset($property->thumbnail) }}"
                                             alt="{{ $property->name }}"
                                             style="width: 100%; height: 350px; object-fit: cover;">
                                    @else
                                        <img class="img-responsive"
                                             src="{{ asset('assets/front/images/property/property-12-660x600.jpg') }}"
                                             alt="{{ $property->name }}"
                                             style="width: 100%; height: 350px; object-fit: cover;">
                                    @endif
                                </a>
                            </div>
                            <div class="property-description">
                                <header class="entry-header">
                                    <h4 class="entry-title">
                                        <a href="{{ route('frontend.properties.show', $property->slug) }}" rel="bookmark">
                                            {{ Str::limit($property->name, 30) }}
                                        </a>
                                    </h4>
                                    <div class="price-and-status">
                                    <span class="price">
                                        {{ $property->currency == '$us' ? '$' : 'Bs.' }}
                                        {{ number_format($property->lowest_price, 2) }}
                                    </span>
                                        <a href="#">
                                        <span class="property-status-tag">
                                            {{ $property->is_project ? 'PROYECTO' : 'EN VENTA' }}
                                        </span>
                                        </a>
                                    </div>
                                </header>
                                <div class="property-meta entry-meta clearfix">
                                    @if($property->size)
                                        <div class="meta-item">
                                            <i class="meta-item-icon icon-area">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                                    <path class="meta-icon" fill="#0DBAE8" d="M46 16v-12c0-1.104-.896-2.001-2-2.001h-12c0-1.103-.896-1.999-2.002-1.999h-11.997c-1.105 0-2.001.896-2.001 1.999h-12c-1.104 0-2 .897-2 2.001v12c-1.104 0-2 .896-2 2v11.999c0 1.104.896 2 2 2v12.001c0 1.104.896 2 2 2h12c0 1.104.896 2 2.001 2h11.997c1.106 0 2.002-.896 2.002-2h12c1.104 0 2-.896 2-2v-12.001c1.104 0 2-.896 2-2v-11.999c0-1.104-.896-2-2-2zm-4.002 23.998c0 1.105-.895 2.002-2 2.002h-31.998c-1.105 0-2-.896-2-2.002v-31.999c0-1.104.895-1.999 2-1.999h31.998c1.105 0 2 .895 2 1.999v31.999z"/>
                                                </svg>
                                            </i>
                                            <div class="meta-inner-wrapper">
                                                <span class="meta-item-label">Área</span>
                                                <span class="meta-item-value">{{ $property->size }}<sub class="meta-item-unit">m²</sub></span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($property->bedrooms)
                                        <div class="meta-item">
                                            <i class="meta-item-icon icon-bed">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                                    <path class="meta-icon" fill="#0DBAE8" d="M21 48.001h-19c-1.104 0-2-.896-2-2v-31c0-1.104.896-2 2-2h19c1.106 0 2 .896 2 2v31c0 1.104-.895 2-2 2zm0-37.001h-19c-1.104 0-2-.895-2-1.999v-7.001c0-1.104.896-2 2-2h19c1.106 0 2 .896 2 2v7.001c0 1.104-.895 1.999-2 1.999zm25 37.001h-19c-1.104 0-2-.896-2-2v-31c0-1.104.896-2 2-2h19c1.104 0 2 .896 2 2v31c0 1.104-.896 2-2 2zm0-37.001h-19c-1.104 0-2-.895-2-1.999v-7.001c0-1.104.896-2 2-2h19c1.104 0 2 .896 2 2v7.001c0 1.104-.896 1.999-2 1.999z"/>
                                                </svg>
                                            </i>
                                            <div class="meta-inner-wrapper">
                                                <span class="meta-item-label">Dormitorios</span>
                                                <span class="meta-item-value">{{ $property->bedrooms }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($property->bathrooms)
                                        <div class="meta-item">
                                            <i class="meta-item-icon icon-bath">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                                    <path class="meta-icon" fill="#0DBAE8" d="M37.003 48.016h-4v-3.002h-18v3.002h-4.001v-3.699c-4.66-1.65-8.002-6.083-8.002-11.305v-4.003h-3v-3h48.006v3h-3.001v4.003c0 5.223-3.343 9.655-8.002 11.305v3.699zm-30.002-24.008h-4.001v-17.005s0-7.003 8.001-7.003h1.004c.236 0 7.995.061 7.995 8.003l5.001 4h-14l5-4-.001.01.001-.009s.938-4.001-3.999-4.001h-1s-4 0-4 3v17.005000000000003h-.001z"/>
                                                </svg>
                                            </i>
                                            <div class="meta-inner-wrapper">
                                                <span class="meta-item-label">Baños</span>
                                                <span class="meta-item-value">{{ $property->bathrooms }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($property->garage)
                                        <div class="meta-item">
                                            <i class="meta-item-icon icon-garage">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                                    <path class="meta-icon" fill="#0DBAE8" d="M44 0h-40c-2.21 0-4 1.791-4 4v44h6v-40c0-1.106.895-2 2-2h31.999c1.106 0 2.001.895 2.001 2v40h6v-44c0-2.209-1.792-4-4-4zm-36 8.001h31.999v2.999h-31.999zm0 18h6v5.999h-2c-1.104 0-2 .896-2 2.001v6.001c0 1.103.896 1.998 2 1.998h2v2.001c0 1.104.896 2 2 2s2-.896 2-2v-2.001h11.999v2.001c0 1.104.896 2 2.001 2 1.104 0 2-.896 2-2v-2.001h2c1.104 0 2-.895 2-1.998v-6.001c0-1.105-.896-2.001-2-2.001h-2v-5.999h5.999v-3h-31.999v3z"/>
                                                </svg>
                                            </i>
                                            <div class="meta-inner-wrapper">
                                                <span class="meta-item-label">Garajes</span>
                                                <span class="meta-item-value">{{ $property->garage }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($property->propertytype)
                                        <div class="meta-item">
                                            <i class="meta-item-icon icon-ptype">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon-container" width="30" height="30" viewBox="0 0 48 48">
                                                    <path class="meta-icon" fill-rule="evenodd" clip-rule="evenodd" fill="#0DBAE8" d="M24 48.001c-13.255 0-24-10.745-24-24.001 0-13.254 10.745-24 24-24s24 10.746 24 24c0 13.256-10.745 24.001-24 24.001zm10-27.001l-10-8-10 8v11c0 1.03.888 2.001 2 2.001h3.999v-9h8.001v9h4c1.111 0 2-.839 2-2.001v-11z"/>
                                                </svg>
                                            </i>
                                            <div class="meta-inner-wrapper">
                                                <span class="meta-item-label">Tipo</span>
                                                <span class="meta-item-value">{{ $property->propertytype->name }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </div>



{{--    <section class="home-recent-posts">--}}
{{--        <div class="container">--}}
{{--            <header class="section-header">--}}
{{--                <h3 class="section-title">Latest News</h3>--}}
{{--                <div class="recent-posts-carousel-nav carousel-nav">--}}
{{--                    <a class="carousel-prev-item prev">--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg" class="arrow-container" width="32" height="52" viewBox="0 0 32 52">--}}
{{--                            <g class="left-arrow" fill="#fff">--}}
{{--                                <path opacity=".5" d="M31.611 7.646l-6.787-7.057-24.435 25.406 6.787 7.057z"/>--}}
{{--                                <path d="M.389 26.006l6.787-7.058 24.435 25.406-6.787 7.057z"/>--}}
{{--                            </g>--}}
{{--                        </svg>--}}
{{--                    </a>--}}
{{--                    <a class="carousel-next-item next">--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg" class="arrow-container" width="32" height="52" viewBox="0 0 32 52">--}}
{{--                            <g class="right-arrow" fill-rule="evenodd" clip-rule="evenodd" fill="#fff">--}}
{{--                                <path d="M.388 44.354l6.788 7.057 24.436-25.406-6.788-7.057-24.436 25.406z"/>--}}
{{--                                <path opacity=".5" d="M31.612 25.994l-6.788 7.058-24.436-25.406 6.788-7.057 24.436 25.405z"/>--}}
{{--                            </g>--}}
{{--                        </svg>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </header>--}}
{{--            <div class="recent-posts-carousel">--}}
{{--                <div class="owl-carousel">--}}
{{--                    <div class="recent-posts-item">--}}
{{--                        <article class="clearfix format-gallery hentry">--}}
{{--                            <div class="post-thumbnail-container">--}}
{{--                                <div class="gallery-slider-two flexslider">--}}
{{--                                    <ul class="slides">--}}
{{--                                        <li>--}}
{{--                                            <a title="Feature Image" data-rel="gallery-1" class="swipebox" href="{{ asset("assets/front/images/news/news-post-7-660x600.jpg")}}">--}}
{{--                                                <img  src="{{ asset("assets/front/images/news/news-post-7-660x600.jpg")}}" alt="Thumbnail">--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a title="Feature Image" data-rel="gallery-1" class="swipebox" href="{{ asset("assets/front/images/news/news-post-5-660x600.jpg")}}">--}}
{{--                                                <img  src="{{ asset("assets/front/images/news/news-post-5-660x600.jpg")}}" alt="Thumbnail">--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a title="Feature Image" data-rel="gallery-1" class="swipebox" href="{{ asset("assets/front/images/news/news-post-4-660x600.jpg")}}">--}}
{{--                                                <img  src="{{ asset("assets/front/images/news/news-post-4-660x600.jpg")}}" alt="Thumbnail">--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="post-content-wrapper">--}}
{{--                                <div class="post-header entry-header">--}}
{{--                                    <h4 class="post-title entry-title"> <a href="#">Gallery Post Format</a></h4>--}}
{{--                                    <div class="post-meta entry-meta">--}}
{{--                                        <span class="author-link">By <a rel="author" href="#">John Doe</a></span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <p>Competently harness enterprise vortals via revolutionary e-tailers. Monotonectally recaptiualize one-to-one relationships whereas ubiquitous…</p>--}}
{{--                                <a class="read-more" href="#">More <i class="fa fa-arrow-circle-o-right"></i></a>--}}
{{--                            </div>--}}
{{--                            <!-- .post-content-wrapper -->--}}
{{--                        </article>--}}
{{--                    </div>--}}
{{--                    <div class="recent-posts-item">--}}
{{--                        <article class="clearfix format-image hentry">--}}
{{--                            <div class="post-thumbnail-container">--}}
{{--                                <figure class="post-thumbnail">--}}
{{--                                    <a href="#"><img src="{{ asset("assets/front/images/news/news-post-3-660x600.jpg")}}" class="img-responsive wp-post-image" alt="News Post"></a>--}}
{{--                                </figure>--}}
{{--                            </div>--}}
{{--                            <!-- .post-thumbnail-container -->--}}
{{--                            <div class="post-content-wrapper">--}}
{{--                                <div class="post-header entry-header">--}}
{{--                                    <h4 class="post-title entry-title"><a href="#">Image Post Format</a></h4>--}}
{{--                                    <div class="post-meta entry-meta">--}}
{{--                                        <span class="author-link">By <a rel="author" href="#">John Doe</a></span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <p>Enthusiastically disintermediate progressive innovation before high-payoff metrics. Intrinsicly generate sticky services without B2B…</p>--}}
{{--                                <a class="read-more" href="#">More <i class="fa fa-arrow-circle-o-right"></i></a>--}}
{{--                            </div>--}}
{{--                            <!-- .post-content-wrapper -->--}}
{{--                        </article>--}}
{{--                    </div>--}}
{{--                    <div class="recent-posts-item">--}}
{{--                        <article class="clearfix format-video hentry">--}}
{{--                            <div class="post-thumbnail-container">--}}
{{--                                <div class="embed-responsive embed-responsive-4by3">--}}
{{--                                    <iframe src="https://player.vimeo.com/video/89541885?title=0&amp;byline=0&amp;portrait=0"></iframe>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="post-content-wrapper">--}}
{{--                                <div class="post-header entry-header">--}}
{{--                                    <h4 class="post-title entry-title"><a href="#">Video Post Format</a></h4>--}}
{{--                                    <div class="post-meta entry-meta">--}}
{{--                                        <span class="author-link">By <a rel="author" href="#">John Doe</a></span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <p>Uniquely customize future-proof niche markets via worldwide users. Proactively negotiate user-centric schemas after…</p>--}}
{{--                                <a class="read-more" href="#">More <i class="fa fa-arrow-circle-o-right"></i></a>--}}
{{--                            </div>--}}
{{--                            <!-- .post-content-wrapper -->--}}
{{--                        </article>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- .container -->--}}
{{--    </section>--}}

</x-frontend-layout>

