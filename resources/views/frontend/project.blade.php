<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exclusiva Propiedad en Alquiler</title>

    <!-- Fuentes -->
    <link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic,900' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Dosis:400,700,600,500' rel='stylesheet'>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Animaciones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- AOS (Animate On Scroll) -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Swiper CSS para sliders -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- Estilos existentes (mínimos para mantener consistencia en algunos elementos) -->
    <link href="{{ asset('assets/front/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/css/project.css') }}" rel="stylesheet">


</head>
<body>
<!-- Elementos de fondo y efectos -->
<div class="particles-container" id="particles-js"></div>

<!-- Navbar -->
<nav class="navbar">
    <div class="navbar-container">
        <a href="/" class="navbar-logo">
            <img src="{{ asset('assets/front/images/logoBlack.png') }}" alt="Logo" />
        </a>

        <ul class="navbar-menu">
            <li><a href="#about">La Propiedad</a></li>
            <li><a href="#features">Características</a></li>
            <li><a href="#gallery">Galería</a></li>
            <li><a href="#plans">Espacios</a></li>
            <li><a href="#location">Ubicación</a></li>
            <li><a href="#contact">Contacto</a></li>
        </ul>

        <button class="cta-button open-modal">Solicitar Visita</button>
    </div>
</nav>

<!-- Hero Section -->
<section class="parallax-section hero-section" id="home">
    <div class="parallax-bg"></div>
    <div class="parallax-content">
        <h1>Casa Plaza España</h1>
        <p>Un exclusivo espacio para oficinas en alquiler en la mejor zona de Sopocachi</p>

        <div class="buttons">
            <a href="#gallery" class="cta-button">Ver Galería</a>
            <a href="#contact" class="cta-button" style="background-color: transparent; border: 2px solid white;">Contactar</a>
        </div>
    </div>

    <div class="hero-details">
        <div class="hero-detail-item">
            <i class="fas fa-map-marker-alt"></i>
            <div class="detail-info">
                <h4>Ubicación</h4>
                <p>Sopocachi, Plaza España</p>
            </div>
        </div>

        <div class="hero-detail-item">
            <i class="fas fa-building"></i>
            <div class="detail-info">
                <h4>Superficie</h4>
                <p>1,164 m² construidos</p>
            </div>
        </div>

        <div class="hero-detail-item">
            <i class="fas fa-dollar-sign"></i>
            <div class="detail-info">
                <h4>Precio</h4>
                <p>$7,000 USD/mes</p>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section" id="about">
    <div class="about-container">
        <div class="about-image" data-aos="fade-right" data-aos-duration="1000">
            <img src="{{ asset('storage/project/1.jpg') }}" alt="Edificio Plaza España">
        </div>

        <div class="about-content" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
            <h2 class="section-title">Sobre la Propiedad</h2>
            <p>Esta magnífica propiedad ubicada en la exclusiva zona de Plaza España en Sopocachi, ofrece un espacio ideal para oficinas, fundaciones o universidades que buscan un ambiente de prestigio y elegancia.</p>

            <p>Con una superficie construida de 1,164 m² distribuidos en 2 plantas y altillo, esta casa de estilo clásico ha sido adaptada para proporcionar ambientes funcionales manteniendo su distinción arquitectónica. Cada espacio ha sido cuidadosamente diseñado para facilitar la operatividad de su empresa u organización.</p>

            <div class="about-features">
                <div class="about-feature-item" data-aos="fade-up" data-aos-delay="300">
                    <i class="fas fa-check-circle"></i>
                    <span>1,040 m² de terreno</span>
                </div>
                <div class="about-feature-item" data-aos="fade-up" data-aos-delay="400">
                    <i class="fas fa-check-circle"></i>
                    <span>14 ambientes de oficina</span>
                </div>
                <div class="about-feature-item" data-aos="fade-up" data-aos-delay="500">
                    <i class="fas fa-check-circle"></i>
                    <span>Amplio jardín lateral</span>
                </div>
                <div class="about-feature-item" data-aos="fade-up" data-aos-delay="600">
                    <i class="fas fa-check-circle"></i>
                    <span>2 salas de reuniones</span>
                </div>
                <div class="about-feature-item" data-aos="fade-up" data-aos-delay="700">
                    <i class="fas fa-check-circle"></i>
                    <span>2 aulas equipadas</span>
                </div>
                <div class="about-feature-item" data-aos="fade-up" data-aos-delay="800">
                    <i class="fas fa-check-circle"></i>
                    <span>Parqueo para 3 vehículos</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section" id="features">
    <div class="features-shape"></div>
    <div class="features-container">
        <div class="features-header" data-aos="fade-up">
            <h2 class="section-title">Características Destacadas</h2>
        </div>

        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon">
                    <i class="fas fa-building"></i>
                </div>
                <h3>Estructura Elegante</h3>
                <p>Arquitectura de estilo clásico con acabados de primera calidad, ideal para proyectar una imagen corporativa sólida y prestigiosa.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h3>Auditorio Amplio</h3>
                <p>Espacioso auditorio perfecto para conferencias, capacitaciones o eventos corporativos con capacidad para grupos numerosos.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Seguridad Integral</h3>
                <p>Sistema de seguridad con control de acceso y ubicación en zona vigilada para tranquilidad de su equipo y visitantes.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon">
                    <i class="fas fa-car"></i>
                </div>
                <h3>Parqueo Privado</h3>
                <p>Estacionamiento privado para 3 vehículos, un beneficio escaso en la zona céntrica de la ciudad.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <h3>Áreas Verdes</h3>
                <p>Amplios jardines laterales que proporcionan un entorno natural y relajante, ideal para pausas o pequeñas reuniones al aire libre.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="600">
                <div class="feature-icon">
                    <i class="fas fa-universal-access"></i>
                </div>
                <h3>Accesibilidad</h3>
                <p>Ubicación estratégica con fácil acceso al transporte público y principales vías de la ciudad, facilitando la llegada de clientes y empleados.</p>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section (Parallax) -->
<section class="parallax-section gallery-section" id="gallery">
    <div class="parallax-bg"></div>

    <div class="gallery-container">
        <div class="gallery-header" data-aos="fade-up">
            <h2 class="section-title" style="color: #0a9ac2">Galería de Imágenes</h2>
        </div>

        <div class="gallery-grid">
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="100">
                <img src="{{asset('storage/project/1.jpg')}}" alt="Sala de estar">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Sala de Recepción</h4>
                    <p>Elegante y espaciosa</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="200">
                <img src="{{asset('storage/project/2.jpg')}}" alt="Area común">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Área de Oficinas</h4>
                    <p>Ambiente amplio y luminoso</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="300">
                <img src="{{asset('storage/project/3.jpg')}}" alt="Jardín">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Jardín Lateral</h4>
                    <p>Espacio verde para descanso</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="400">
                <img src="{{asset('storage/project/4.jpg')}}" alt="Sala de conferencias">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Sala de Conferencias</h4>
                    <p>Espacio para reuniones importantes</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="100">
                <img src="{{asset('storage/project/5.jpg')}}" alt="Auditorio">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Auditorio</h4>
                    <p>Capacidad para eventos grandes</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="200">
                <img src="{{asset('storage/project/6.jpg')}}" alt="Pasillo">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Pasillo Principal</h4>
                    <p>Acabados de madera fina</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="300">
                <img src="{{asset('storage/project/7.jpg')}}" alt="Sala de reuniones">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Sala de Reuniones</h4>
                    <p>Moderna y equipada</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="400">
                <img src="{{asset('storage/project/8.jpg')}}" alt="Exterior">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Fachada Exterior</h4>
                    <p>Estilo clásico y elegante</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="100">
                <img src="{{asset('storage/project/9.jpg')}}" alt="Auditorio">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Auditorio</h4>
                    <p>Capacidad para eventos grandes</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="200">
                <img src="{{asset('storage/project/10.jpg')}}" alt="Pasillo">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Pasillo Principal</h4>
                    <p>Acabados de madera fina</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="300">
                <img src="{{asset('storage/project/11.jpg')}}" alt="Sala de reuniones">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Sala de Reuniones</h4>
                    <p>Moderna y equipada</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="400">
                <img src="{{asset('storage/project/13.jpg')}}" alt="Exterior">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Fachada Exterior</h4>
                    <p>Estilo clásico y elegante</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="100">
                <img src="{{asset('storage/project/14.jpg')}}" alt="Auditorio">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Auditorio</h4>
                    <p>Capacidad para eventos grandes</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="200">
                <img src="{{asset('storage/project/15.jpg')}}" alt="Pasillo">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Pasillo Principal</h4>
                    <p>Acabados de madera fina</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="300">
                <img src="{{asset('storage/project/16.jpg')}}" alt="Sala de reuniones">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Sala de Reuniones</h4>
                    <p>Moderna y equipada</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="400">
                <img src="{{asset('storage/project/17.jpg')}}" alt="Exterior">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Fachada Exterior</h4>
                    <p>Estilo clásico y elegante</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="100">
                <img src="{{asset('storage/project/18.jpg')}}" alt="Auditorio">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Auditorio</h4>
                    <p>Capacidad para eventos grandes</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="200">
                <img src="{{asset('storage/project/19.jpg')}}" alt="Pasillo">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Pasillo Principal</h4>
                    <p>Acabados de madera fina</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="300">
                <img src="{{asset('storage/project/20.jpg')}}" alt="Sala de reuniones">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Sala de Reuniones</h4>
                    <p>Moderna y equipada</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="400">
                <img src="{{asset('storage/project/21.jpg')}}" alt="Exterior">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Fachada Exterior</h4>
                    <p>Estilo clásico y elegante</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="100">
                <img src="{{asset('storage/project/22.jpg')}}" alt="Auditorio">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Auditorio</h4>
                    <p>Capacidad para eventos grandes</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="200">
                <img src="{{asset('storage/project/23.jpg')}}" alt="Pasillo">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Pasillo Principal</h4>
                    <p>Acabados de madera fina</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="300">
                <img src="{{asset('storage/project/24.jpg')}}" alt="Sala de reuniones">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Sala de Reuniones</h4>
                    <p>Moderna y equipada</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="400">
                <img src="{{asset('storage/project/25.jpg')}}" alt="Exterior">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Fachada Exterior</h4>
                    <p>Estilo clásico y elegante</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="100">
                <img src="{{asset('storage/project/26.jpg')}}" alt="Auditorio">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Auditorio</h4>
                    <p>Capacidad para eventos grandes</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="200">
                <img src="{{asset('storage/project/27.jpg')}}" alt="Pasillo">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Pasillo Principal</h4>
                    <p>Acabados de madera fina</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="300">
                <img src="{{asset('storage/project/28.jpg')}}" alt="Sala de reuniones">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Sala de Reuniones</h4>
                    <p>Moderna y equipada</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="400">
                <img src="{{asset('storage/project/29.jpg')}}" alt="Exterior">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Fachada Exterior</h4>
                    <p>Estilo clásico y elegante</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="400">
                <img src="{{asset('storage/project/30.jpg')}}" alt="Exterior">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Fachada Exterior</h4>
                    <p>Estilo clásico y elegante</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="section-divider">
    <div class="divider-icon">
        <i class="fas fa-building"></i>
    </div>
</div>

<!-- Spaces Section -->
<section class="plans-section" id="plans">
{{--    <div class="plans-shape-1"></div>--}}
{{--    <div class="plans-shape-2"></div>--}}
    <div class="plans-container">
        <div class="plans-header" data-aos="fade-up">
            <h2 class="section-title">Distribución de Espacios</h2>
        </div>

        <div class="plans-grid">
            <div class="plan-card" data-aos="fade-up" data-aos-delay="100">
                <div class="plan-image">
                    <img src="{{asset('storage/project/1.jpg')}}" alt="Planta Baja">
                    <span class="plan-badge">Planta Baja</span>
                </div>
                <div class="plan-content">
                    <h3>Áreas Sociales y Recepción</h3>
                    <div class="plan-details">
                        <div class="plan-detail-item">
                            <i class="fas fa-door-open"></i>
                            <span>Recepción amplia</span>
                        </div>
                        <div class="plan-detail-item">
                            <i class="fas fa-users"></i>
                            <span>Sala de espera</span>
                        </div>
                        <div class="plan-detail-item">
                            <i class="fas fa-chalkboard"></i>
                            <span>Aulas (2)</span>
                        </div>
                        <div class="plan-detail-item">
                            <i class="fas fa-toilet"></i>
                            <span>Baños completos</span>
                        </div>
                    </div>
                    <div class="plan-action">
                        <a href="#contact" class="cta-button">Agendar Visita</a>
                    </div>
                </div>
            </div>

            <div class="plan-card" data-aos="fade-up" data-aos-delay="200">
                <div class="plan-image">
                    <img src="{{asset('storage/project/2.jpg')}}" alt="Planta Alta">
                    <span class="plan-badge">Planta Alta</span>
                </div>
                <div class="plan-content">
                    <h3>Oficinas Principales</h3>
                    <div class="plan-details">
                        <div class="plan-detail-item">
                            <i class="fas fa-briefcase"></i>
                            <span>Oficinas ejecutivas</span>
                        </div>
                        <div class="plan-detail-item">
                            <i class="fas fa-handshake"></i>
                            <span>Salas de reuniones (2)</span>
                        </div>
                        <div class="plan-detail-item">
                            <i class="fas fa-users"></i>
                            <span>Área de trabajo abierta</span>
                        </div>
                        <div class="plan-detail-item">
                            <i class="fas fa-toilet"></i>
                            <span>Baños para personal</span>
                        </div>
                    </div>
                    <div class="plan-action">
                        <a href="#contact" class="cta-button">Agendar Visita</a>
                    </div>
                </div>
            </div>

            <div class="plan-card" data-aos="fade-up" data-aos-delay="300">
                <div class="plan-image">
                    <img src="{{asset('storage/project/3.jpg')}}" alt="Exterior">
                    <span class="plan-badge">Áreas Exteriores</span>
                </div>
                <div class="plan-content">
                    <h3>Jardín y Estacionamiento</h3>
                    <div class="plan-details">
                        <div class="plan-detail-item">
                            <i class="fas fa-tree"></i>
                            <span>Jardín lateral amplio</span>
                        </div>
                        <div class="plan-detail-item">
                            <i class="fas fa-car"></i>
                            <span>Parqueo para 3 vehículos</span>
                        </div>
                        <div class="plan-detail-item">
                            <i class="fas fa-warehouse"></i>
                            <span>Área de servicios</span>
                        </div>
                        <div class="plan-detail-item">
                            <i class="fas fa-door-open"></i>
                            <span>Acceso independiente</span>
                        </div>
                    </div>
                    <div class="plan-action">
                        <a href="#contact" class="cta-button">Agendar Visita</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Location Section -->
<section class="location-section" id="location">
    <div class="location-container">
        <div class="location-header" data-aos="fade-up">
            <h2 class="section-title">Ubicación Privilegiada</h2>
        </div>

        <div class="location-content">
            <div class="location-map" data-aos="fade-right" data-aos-delay="100">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3825.2953280869324!2d-68.13627462510964!3d-16.511380741595778!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x915eddb3c478619f%3A0xfa75ac9b8b6a60e4!2sPlaza%20Espa%C3%B1a%2C%20La%20Paz!5e0!3m2!1ses!2sbo!4v1711395182810!5m2!1ses!2sbo" allowfullscreen="" loading="lazy"></iframe>

                <div class="location-points">
                    <div class="location-point"></div>
                    <div class="location-point"></div>
                    <div class="location-point"></div>
                </div>
            </div>

            <div class="location-info" data-aos="fade-left" data-aos-delay="200">
                <h3>Sopocachi - Plaza España, La Paz</h3>
                <p class="location-description">La propiedad se encuentra ubicada en la exclusiva zona de Plaza España en Sopocachi, uno de los barrios más tradicionales y prestigiosos de La Paz. Esta ubicación estratégica combina el ambiente residencial con la cercanía a importantes centros comerciales, financieros y gubernamentales.</p>

                <div class="location-features">
                    <div class="location-feature-item" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-building"></i>
                        <div class="feature-text">
                            <h4>Distrito Financiero</h4>
                            <p>A pocos minutos de los principales bancos y oficinas corporativas de la ciudad.</p>
                        </div>
                    </div>

                    <div class="location-feature-item" data-aos="fade-up" data-aos-delay="400">
                        <i class="fas fa-university"></i>
                        <div class="feature-text">
                            <h4>Centros Educativos</h4>
                            <p>Cercano a universidades y colegios de prestigio como la UMSA y Ucatólica.</p>
                        </div>
                    </div>

                    <div class="location-feature-item" data-aos="fade-up" data-aos-delay="500">
                        <i class="fas fa-bus"></i>
                        <div class="feature-text">
                            <h4>Transporte</h4>
                            <p>Excelente conectividad con líneas de transporte público y principales vías de acceso.</p>
                        </div>
                    </div>

                    <div class="location-feature-item" data-aos="fade-up" data-aos-delay="600">
                        <i class="fas fa-utensils"></i>
                        <div class="feature-text">
                            <h4>Servicios</h4>
                            <p>Rodeado de restaurantes, cafés y servicios complementarios para empleados y clientes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Detalles del Alquiler -->
<section class="rent-details-section" id="rent-details">
    <div class="rent-shape"></div>

    <div class="rent-details-container">
        <div class="rent-details-header" data-aos="fade-up">
            <h2 class="section-title">Detalles del Alquiler</h2>
        </div>

        <div class="rent-details-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon">
                    <i class="fas fa-file-contract"></i>
                </div>
                <h3>Condiciones</h3>
                <p>Contrato mínimo de 2 años con opción de renovación. Incluye mantenimiento de áreas comunes.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h3>Precio</h3>
                <p>$7,000 USD mensuales. Depósito en garantía equivalente a 2 meses de alquiler.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h3>Disponibilidad</h3>
                <p>Disponible para ocupación inmediata. Posibilidad de coordinar modificaciones según necesidades.</p>
            </div>
        </div>
    </div>
</section>
<div class="section-divider">
    <div class="divider-icon">
        <i class="fas fa-building"></i>
    </div>
</div>


<!-- CTA Section (Parallax) -->
<section class="parallax-section cta-section">
    <div class="parallax-bg"></div>

    <div class="cta-container">
        <h2>El espacio ideal para su organización</h2>
        <p>No pierda la oportunidad de establecer su empresa u organización en esta magnífica propiedad en una de las mejores zonas de La Paz.</p>

        <div class="cta-buttons">
            <button class="cta-button open-modal">Solicitar Información</button>
            <a href="#gallery" class="cta-button secondary">Ver Más Fotos</a>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section" id="contact">
    <div class="contact-shape-1"></div>
    <div class="contact-shape-2"></div>

    <div class="contact-container">
        <div class="contact-header" data-aos="fade-up">
            <h2 class="section-title">Contáctanos</h2>
        </div>

        <div class="contact-content">
            <div class="contact-form" data-aos="fade-right" data-aos-delay="100">
                <h3>Solicita información o una visita</h3>

                <form action="#" method="post">
                    <div class="form-group">
                        <label for="name">Nombre Completo</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Teléfono</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>

                    <div class="form-group">
                        <label for="company">Empresa/Organización</label>
                        <input type="text" id="company" name="company">
                    </div>

                    <div class="form-group">
                        <label for="message">Mensaje</label>
                        <textarea id="message" name="message" placeholder="Cuéntanos sobre tu empresa y las necesidades específicas para tu espacio de oficinas"></textarea>
                    </div>

                    <button type="submit" class="contact-button">Enviar Solicitud</button>
                </form>
            </div>

            <div class="contact-info" data-aos="fade-left" data-aos-delay="200">
                <div class="contact-info-header">
                    <h3>Información de Contacto</h3>
                    <p>Estamos disponibles para atender tus consultas y coordinar una visita personalizada a esta exclusiva propiedad.</p>
                </div>

                <div class="contact-info-item" data-aos="fade-up" data-aos-delay="300">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="item-content">
                        <h4>Dirección de la Oficina</h4>
                        <p>Av. 6 de Agosto #2464, Edificio Los Jardines<br>La Paz, Bolivia</p>
                    </div>
                </div>

                <div class="contact-info-item" data-aos="fade-up" data-aos-delay="400">
                    <i class="fas fa-phone-alt"></i>
                    <div class="item-content">
                        <h4>Teléfono</h4>
                        <p>+591 2 2445555</p>
                        <p>+591 70000000</p>
                    </div>
                </div>

                <div class="contact-info-item" data-aos="fade-up" data-aos-delay="500">
                    <i class="fas fa-envelope"></i>
                    <div class="item-content">
                        <h4>Email</h4>
                        <p>comercial@inmobiliaria.com</p>
                    </div>
                </div>

                <div class="contact-social" data-aos="fade-up" data-aos-delay="600">
                    <h4>Síguenos</h4>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="footer-pattern"></div>
    <div class="footer-container">
        <div class="footer-logo">
            <img src="{{ asset('assets/front/images/logoBlack.png') }}" style="height: 150px;" alt="Logo">
        </div>

        <p>&copy; {{ date('Y') }} Inmobiliaria. Todos los derechos reservados.</p>
        <p>Especialistas en propiedades exclusivas en La Paz</p>
    </div>
</footer>

<!-- Back to Top Button -->
<div class="back-to-top">
    <i class="fas fa-arrow-up"></i>
</div>

<!-- Quick Contact Modal -->
<div class="modal" id="contact-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Solicitar Información</h3>
            <span class="modal-close">&times;</span>
        </div>

        <div class="modal-body">
            <form action="#" method="post">
                <div class="form-group">
                    <label for="modal-name">Nombre Completo</label>
                    <input type="text" id="modal-name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="modal-email">Email</label>
                    <input type="email" id="modal-email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="modal-phone">Teléfono</label>
                    <input type="tel" id="modal-phone" name="phone" required>
                </div>

                <div class="form-group">
                    <label for="modal-company">Empresa/Organización</label>
                    <input type="text" id="modal-company" name="company">
                </div>

                <div class="form-group">
                    <label for="modal-interest">Me interesa para</label>
                    <select id="modal-interest" name="interest" class="form-select">
                        <option value="oficina">Oficinas Corporativas</option>
                        <option value="fundacion">Fundación/ONG</option>
                        <option value="educacion">Centro Educativo/Universidad</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>

                <button type="submit" class="contact-button">Solicitar Visita</button>
            </form>
        </div>
    </div>
</div>

<!-- Scripts necesarios -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

<script>

    $(document).ready(function() {
        // Configuración
        const itemsPerPage = 8; // Número de imágenes por página
        const $galleryItems = $('.gallery-grid .gallery-item');
        const totalItems = $galleryItems.length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);

        // Ocultar todas las imágenes inicialmente excepto las primeras 8
        $galleryItems.hide();
        $galleryItems.slice(0, itemsPerPage).show();

        // Crear la paginación
        const $pagination = $('<div class="gallery-pagination"></div>');
        for (let i = 1; i <= totalPages; i++) {
            $pagination.append(`<a href="#" class="page-number ${i === 1 ? 'active' : ''}">${i}</a>`);
        }

        // Agregar paginación al DOM
        $('.gallery-container').append($pagination);

        // Manejar clic en los números de página
        $('.page-number').on('click', function(e) {
            e.preventDefault();

            // Actualizar estado activo
            $('.page-number').removeClass('active');
            $(this).addClass('active');

            // Mostrar imágenes correspondientes
            const pageNum = parseInt($(this).text());
            const start = (pageNum - 1) * itemsPerPage;
            const end = start + itemsPerPage;

            $galleryItems.hide();
            $galleryItems.slice(start, end).show();

            // Scroll hacia arriba de la galería
            $('html, body').animate({
                scrollTop: $('.gallery-section').offset().top - 100
            }, 500);
        });
    });

    $(document).ready(function() {
        // Inicializar AOS (Animate On Scroll)
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Navbar scroll effect
        $(window).scroll(function() {
            if ($(window).scrollTop() > 50) {
                $('.navbar').addClass('scrolled');
            } else {
                $('.navbar').removeClass('scrolled');
            }

            // Show/hide back to top button
            if ($(window).scrollTop() > 300) {
                $('.back-to-top').addClass('visible');
            } else {
                $('.back-to-top').removeClass('visible');
            }

            // Parallax efecto al hacer scroll
            const scrollTop = $(window).scrollTop();
            $('.parallax-bg').css({
                'transform': 'translateY(' + scrollTop * 0.3 + 'px)'
            });
        });

        // Smooth scroll for anchor links
        $('a[href^="#"]').on('click', function(e) {
            e.preventDefault();

            const target = this.hash;
            const $target = $(target);

            $('html, body').animate({
                'scrollTop': $target.offset().top - 70
            }, 1000, 'swing');
        });

        // Back to top button click
        $('.back-to-top').on('click', function() {
            $('html, body').animate({
                scrollTop: 0
            }, 800);
        });

        // Modal handling
        $('.open-modal').on('click', function() {
            $('#contact-modal').addClass('active');
        });

        $('.modal-close').on('click', function() {
            $('#contact-modal').removeClass('active');
        });

        $(document).on('click', function(e) {
            if ($(e.target).hasClass('modal')) {
                $('#contact-modal').removeClass('active');
            }
        });

        // Crear partículas flotantes
        function createParticles() {
            const container = document.getElementById('particles-js');

            if (container) {
                particlesJS('particles-js', {
                    "particles": {
                        "number": {
                            "value": 50,
                            "density": {
                                "enable": true,
                                "value_area": 800
                            }
                        },
                        "color": {
                            "value": "#0DBAE8"
                        },
                        "shape": {
                            "type": "circle",
                            "stroke": {
                                "width": 0,
                                "color": "#000000"
                            }
                        },
                        "opacity": {
                            "value": 0.3,
                            "random": true,
                            "anim": {
                                "enable": true,
                                "speed": 1,
                                "opacity_min": 0.1,
                                "sync": false
                            }
                        },
                        "size": {
                            "value": 5,
                            "random": true,
                            "anim": {
                                "enable": true,
                                "speed": 4,
                                "size_min": 0.3,
                                "sync": false
                            }
                        },
                        "line_linked": {
                            "enable": true,
                            "distance": 150,
                            "color": "#0DBAE8",
                            "opacity": 0.2,
                            "width": 1
                        },
                        "move": {
                            "enable": true,
                            "speed": 2,
                            "direction": "none",
                            "random": true,
                            "straight": false,
                            "out_mode": "out",
                            "bounce": false,
                            "attract": {
                                "enable": false,
                                "rotateX": 600,
                                "rotateY": 1200
                            }
                        }
                    },
                    "interactivity": {
                        "detect_on": "canvas",
                        "events": {
                            "onhover": {
                                "enable": true,
                                "mode": "bubble"
                            },
                            "onclick": {
                                "enable": true,
                                "mode": "push"
                            },
                            "resize": true
                        },
                        "modes": {
                            "bubble": {
                                "distance": 150,
                                "size": 6,
                                "duration": 2,
                                "opacity": 0.8,
                                "speed": 3
                            },
                            "push": {
                                "particles_nb": 4
                            }
                        }
                    },
                    "retina_detect": true
                });
            }
        }

        // Iniciar partículas
        createParticles();

        // Lightbox para imágenes de galería
        $('.gallery-item').on('click', function() {
            const imgSrc = $(this).find('img').attr('src');
            const imgAlt = $(this).find('img').attr('alt');

            // Aquí podrías implementar un lightbox personalizado
            alert(`Ver imagen ampliada: ${imgAlt}`);
        });
    });
</script>
</body>
</html>
