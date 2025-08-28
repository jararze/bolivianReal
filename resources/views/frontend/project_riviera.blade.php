<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Condominio Riviera 21 - Departamentos en Venta</title>

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

    <!-- Estilos existentes -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .particles-container {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .navbar-logo img {
            height: 50px;
        }

        .navbar-menu {
            display: flex;
            list-style: none;
            gap: 30px;
        }

        .navbar-menu a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        .navbar-menu a:hover {
            color: #0DBAE8;
        }

        .cta-button {
            background: linear-gradient(45deg, #0DBAE8, #17a2b8);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            cursor: pointer;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(13, 186, 232, 0.3);
        }

        /* Hero Section */
        .parallax-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .parallax-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 120%;
            background: linear-gradient(135deg, #0DBAE8 0%, #17a2b8 100%);
            z-index: -1;
        }

        .parallax-content {
            text-align: center;
            color: white;
            max-width: 800px;
            padding: 0 20px;
        }

        .parallax-content h1 {
            font-size: 4rem;
            margin-bottom: 20px;
            font-weight: 900;
        }

        .parallax-content p {
            font-size: 1.3rem;
            margin-bottom: 40px;
            opacity: 0.9;
        }

        .buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .hero-details {
            position: absolute;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 50px;
        }

        .hero-detail-item {
            display: flex;
            align-items: center;
            gap: 15px;
            color: white;
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }

        .hero-detail-item i {
            font-size: 2rem;
        }

        /* About Section */
        .about-section {
            padding: 100px 0;
            background: #f8f9fa;
        }

        .about-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            padding: 0 20px;
        }

        .about-image img {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .section-title {
            font-size: 2.5rem;
            margin-bottom: 30px;
            color: #333;
        }

        .about-content p {
            font-size: 1.1rem;
            margin-bottom: 20px;
            color: #666;
        }

        .about-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .about-feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #0DBAE8;
            font-weight: 500;
        }

        /* Features Section */
        .features-section {
            padding: 100px 0;
            position: relative;
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .features-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            background: linear-gradient(45deg, #0DBAE8, #17a2b8);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 2rem;
        }

        /* Unit Types Section */
        .unit-types-section {
            padding: 100px 0;
            background: #f8f9fa;
        }

        .unit-types-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .unit-types-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .unit-types-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
        }

        .unit-type-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .unit-type-card:hover {
            transform: translateY(-5px);
        }

        .unit-type-image {
            height: 250px;
            background: linear-gradient(45deg, #0DBAE8, #17a2b8);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        .unit-type-content {
            padding: 30px;
        }

        .unit-type-title {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: #333;
        }

        .unit-price {
            color: #0DBAE8;
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .unit-features {
            list-style: none;
            margin-bottom: 25px;
        }

        .unit-features li {
            padding: 8px 0;
            color: #666;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .unit-features i {
            color: #0DBAE8;
            width: 20px;
        }

        /* Towers Section */
        .towers-section {
            padding: 100px 0;
        }

        .towers-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .towers-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .towers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
        }

        .tower-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border: 3px solid transparent;
            transition: all 0.3s;
        }

        .tower-card.featured {
            border-color: #0DBAE8;
            transform: scale(1.05);
        }

        .tower-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
        }

        .tower-diamante {
            background: linear-gradient(45deg, #FFD700, #FFA500);
        }

        .tower-oro {
            background: linear-gradient(45deg, #FFD700, #DAA520);
        }

        .tower-plata {
            background: linear-gradient(45deg, #C0C0C0, #808080);
        }

        /* Location Section */
        .location-section {
            padding: 100px 0;
            background: #f8f9fa;
        }

        .location-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .location-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .location-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .location-map {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            height: 400px;
        }

        .location-map iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .location-features {
            display: grid;
            gap: 25px;
        }

        .location-feature-item {
            display: flex;
            align-items: flex-start;
            gap: 20px;
        }

        .location-feature-item i {
            background: #0DBAE8;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .feature-text h4 {
            margin-bottom: 8px;
            color: #333;
        }

        .feature-text p {
            color: #666;
        }

        /* Contact Section */
        .contact-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #0DBAE8 0%, #17a2b8 100%);
            color: white;
        }

        .contact-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .contact-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .contact-header h2 {
            color: white;
        }

        .contact-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
        }

        .contact-form {
            background: rgba(255,255,255,0.1);
            padding: 40px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            background: rgba(255,255,255,0.2);
            color: white;
            backdrop-filter: blur(10px);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: rgba(255,255,255,0.7);
        }

        .contact-button {
            background: white;
            color: #0DBAE8;
            padding: 15px 30px;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
        }

        .contact-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .contact-info {
            display: grid;
            gap: 30px;
        }

        .contact-info-item {
            display: flex;
            align-items: flex-start;
            gap: 20px;
        }

        .contact-info-item i {
            background: rgba(255,255,255,0.2);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Footer */
        .footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 50px 0;
        }

        .footer-logo img {
            height: 80px;
            margin-bottom: 20px;
            filter: brightness(0) invert(1);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 40px;
            border-radius: 20px;
            max-width: 500px;
            width: 90%;
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 2rem;
            cursor: pointer;
            color: #999;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-menu {
                display: none;
            }

            .parallax-content h1 {
                font-size: 2.5rem;
            }

            .hero-details {
                flex-direction: column;
                gap: 20px;
            }

            .about-container,
            .location-content,
            .contact-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .features-grid,
            .unit-types-grid,
            .towers-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<!-- Elementos de fondo y efectos -->
<div class="particles-container" id="particles-js"></div>

<!-- Navbar -->
<nav class="navbar">
    <div class="navbar-container">
        <a href="/" class="navbar-logo">
            <img src="{{ asset('assets/front/images/riviera/LogoRiviera21.jpg') }}" alt="Logo" />
        </a>

        <ul class="navbar-menu">
            <li><a href="#about">El Proyecto</a></li>
            <li><a href="#unit-types">Departamentos</a></li>
            <li><a href="#towers">Torres</a></li>
            <li><a href="#features">Características</a></li>
            <li><a href="#location">Ubicación</a></li>
            <li><a href="#contact">Contacto</a></li>
        </ul>

        <button class="cta-button open-modal">Solicitar Información</button>
    </div>
</nav>

<!-- Hero Section -->
<section class="parallax-section hero-section" id="home">
    <div class="parallax-bg"></div>
    <div class="parallax-content">
        <h1>Condominio Riviera 21</h1>
        <p>Departamentos exclusivos en venta en el corazón de La Paz</p>

        <div class="buttons">
            <a href="#unit-types" class="cta-button">Ver Departamentos</a>
            <a href="#contact" class="cta-button" style="background-color: transparent; border: 2px solid white;">Contactar</a>
        </div>
    </div>

    <div class="hero-details">
        <div class="hero-detail-item">
            <i class="fas fa-map-marker-alt"></i>
            <div class="detail-info">
                <h4>Ubicación</h4>
                <p>Calle Ecuador, La Paz</p>
            </div>
        </div>

        <div class="hero-detail-item">
            <i class="fas fa-building"></i>
            <div class="detail-info">
                <h4>Torres</h4>
                <p>3 Torres Premium</p>
            </div>
        </div>

        <div class="hero-detail-item">
            <i class="fas fa-home"></i>
            <div class="detail-info">
                <h4>Unidades</h4>
                <p>Desde $32,500 USD</p>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section" id="about">
    <div class="about-container">
        <div class="about-image" data-aos="fade-right" data-aos-duration="1000">
            <img src="{{ asset('assets/front/images/riviera/Riviera21.jpg') }}" alt="Condominio Riviera 21">
        </div>

        <div class="about-content" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
            <h2 class="section-title">El Proyecto</h2>
            <p>Condominio Riviera 21 representa la perfecta combinación entre diseño moderno y ubicación estratégica en La Paz. Con tres torres distintivas que albergan más de 240 unidades habitacionales.</p>

            <p>Ubicado en Calle Ecuador entre Avenida 20 de Octubre y Calle Sánchez Lima, ofrece fácil acceso tanto peatonal como vehicular, conectándolo perfectamente con toda la ciudad.</p>

            <div class="about-features">
                <div class="about-feature-item" data-aos="fade-up" data-aos-delay="300">
                    <i class="fas fa-check-circle"></i>
                    <span>3 Torres Premium</span>
                </div>
                <div class="about-feature-item" data-aos="fade-up" data-aos-delay="400">
                    <i class="fas fa-check-circle"></i>
                    <span>240+ Departamentos</span>
                </div>
                <div class="about-feature-item" data-aos="fade-up" data-aos-delay="500">
                    <i class="fas fa-check-circle"></i>
                    <span>60 Parqueos</span>
                </div>
                <div class="about-feature-item" data-aos="fade-up" data-aos-delay="600">
                    <i class="fas fa-check-circle"></i>
                    <span>Áreas Comunes</span>
                </div>
                <div class="about-feature-item" data-aos="fade-up" data-aos-delay="700">
                    <i class="fas fa-check-circle"></i>
                    <span>Parque Infantil</span>
                </div>
                <div class="about-feature-item" data-aos="fade-up" data-aos-delay="800">
                    <i class="fas fa-check-circle"></i>
                    <span>Locales Comerciales</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Unit Types Section -->
<section class="unit-types-section" id="unit-types">
    <div class="unit-types-container">
        <div class="unit-types-header" data-aos="fade-up">
            <h2 class="section-title">Tipos de Departamentos</h2>
            <p>Opciones diseñadas para cada estilo de vida</p>
        </div>

        <div class="unit-types-grid">
            <div class="unit-type-card" data-aos="fade-up" data-aos-delay="100">
                <div class="unit-type-image">
                    <i class="fas fa-bed"></i>
                </div>
                <div class="unit-type-content">
                    <h3 class="unit-type-title">Monoambiente</h3>
                    <div class="unit-price">Desde $28,600 USD</div>
                    <ul class="unit-features">
                        <li><i class="fas fa-home"></i>22 - 37 m² construidos</li>
                        <li><i class="fas fa-bed"></i>1 ambiente completo</li>
                        <li><i class="fas fa-bath"></i>1 baño</li>
                        <li><i class="fas fa-utensils"></i>Kitchenette</li>
                        <li><i class="fas fa-window-maximize"></i>Amplias ventanas</li>
                    </ul>
                    <a href="#contact" class="cta-button">Más Información</a>
                </div>
            </div>

            <div class="unit-type-card" data-aos="fade-up" data-aos-delay="200">
                <div class="unit-type-image">
                    <i class="fas fa-home"></i>
                </div>
                <div class="unit-type-content">
                    <h3 class="unit-type-title">1 Dormitorio</h3>
                    <div class="unit-price">Desde $61,640 USD</div>
                    <ul class="unit-features">
                        <li><i class="fas fa-home"></i>44 - 57 m² construidos</li>
                        <li><i class="fas fa-bed"></i>1 dormitorio</li>
                        <li><i class="fas fa-bath"></i>1 baño completo</li>
                        <li><i class="fas fa-utensils"></i>Cocina equipada</li>
                        <li><i class="fas fa-couch"></i>Sala-comedor</li>
                    </ul>
                    <a href="#contact" class="cta-button">Más Información</a>
                </div>
            </div>

            <div class="unit-type-card" data-aos="fade-up" data-aos-delay="300">
                <div class="unit-type-image">
                    <i class="fas fa-building"></i>
                </div>
                <div class="unit-type-content">
                    <h3 class="unit-type-title">2 Dormitorios</h3>
                    <div class="unit-price">Desde $105,860 USD</div>
                    <ul class="unit-features">
                        <li><i class="fas fa-home"></i>74 - 79 m² construidos</li>
                        <li><i class="fas fa-bed"></i>2 dormitorios</li>
                        <li><i class="fas fa-bath"></i>1-2 baños</li>
                        <li><i class="fas fa-utensils"></i>Cocina completa</li>
                        <li><i class="fas fa-couch"></i>Sala-comedor amplia</li>
                    </ul>
                    <a href="#contact" class="cta-button">Más Información</a>
                </div>
            </div>

            <div class="unit-type-card" data-aos="fade-up" data-aos-delay="400">
                <div class="unit-type-image">
                    <i class="fas fa-hotel"></i>
                </div>
                <div class="unit-type-content">
                    <h3 class="unit-type-title">3 Dormitorios</h3>
                    <div class="unit-price">Desde $127,260 USD</div>
                    <ul class="unit-features">
                        <li><i class="fas fa-home"></i>101 m² construidos</li>
                        <li><i class="fas fa-bed"></i>3 dormitorios</li>
                        <li><i class="fas fa-bath"></i>2 baños completos</li>
                        <li><i class="fas fa-utensils"></i>Cocina integral</li>
                        <li><i class="fas fa-couch"></i>Espacios amplios</li>
                    </ul>
                    <a href="#contact" class="cta-button">Más Información</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Towers Section -->
<section class="towers-section" id="towers">
    <div class="towers-container">
        <div class="towers-header" data-aos="fade-up">
            <h2 class="section-title">Nuestras Torres</h2>
            <p>Tres opciones premium para tu nueva vida</p>
        </div>

        <div class="towers-grid">
            <div class="tower-card" data-aos="fade-up" data-aos-delay="100">
                <div class="tower-icon tower-diamante">
                    <i class="fas fa-gem"></i>
                </div>
                <h3>Torre Diamante</h3>
                <p>La torre más exclusiva con acabados premium</p>
                <ul class="unit-features">
                    <li><i class="fas fa-building"></i>8 Locales Comerciales</li>
                    <li><i class="fas fa-briefcase"></i>3 Oficinas</li>
                    <li><i class="fas fa-home"></i>51 Deptos 1 dormitorio</li>
                    <li><i class="fas fa-home"></i>38 Deptos 2 dormitorios</li>
                </ul>
                <div class="unit-price">Desde $1,300/m²</div>
            </div>

            <div class="tower-card featured" data-aos="fade-up" data-aos-delay="200">
                <div class="tower-icon tower-oro">
                    <i class="fas fa-crown"></i>
                </div>
                <h3>Torre Oro</h3>
                <p>Elegancia y confort en cada detalle</p>
                <ul class="unit-features">
                    <li><i class="fas fa-home"></i>84 Deptos 1 dormitorio</li>
                    <li><i class="fas fa-home"></i>12 Deptos 3 dormitorios</li>
                    <li><i class="fas fa-star"></i>Ubicación central</li>
                    <li><i class="fas fa-elevator"></i>Ascensores rápidos</li>
                </ul>
                <div class="unit-price">Desde $1,260/m²</div>
            </div>

            <div class="tower-card" data-aos="fade-up" data-aos-delay="300">
                <div class="tower-icon tower-plata">
                    <i class="fas fa-building"></i>
                </div>
                <h3>Torre Plata</h3>
                <p>Calidad y precio en perfecta armonía</p>
                <ul class="unit-features">
                    <li><i class="fas fa-home"></i>108 Deptos 1 dormitorio</li>
                    <li><i class="fas fa-users"></i>Ideal para jóvenes</li>
                    <li><i class="fas fa-dollar-sign"></i>Mejor precio</li>
                    <li><i class="fas fa-chart-line"></i>Gran plusvalía</li>
                </ul>
                <div class="unit-price">Desde $950/m²</div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section" id="features">
    <div class="features-container">
        <div class="features-header" data-aos="fade-up">
            <h2 class="section-title">Características Premium</h2>
            <p>Todo lo que necesitas para tu nuevo hogar</p>
        </div>

        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon">
                    <i class="fas fa-building"></i>
                </div>
                <h3>Arquitectura Moderna</h3>
                <p>Diseño contemporáneo con acabados de primera calidad y espacios inteligentemente distribuidos.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Seguridad 24/7</h3>
                <p>Sistema integral de seguridad con control de acceso, cámaras y vigilancia permanente.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                    <i class="fas fa-car"></i>
                </div>
                <h3>Parqueaderos</h3>
                <p>60 espacios de estacionamiento disponibles con opción de compra independiente.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Áreas Comunes</h3>
                <p>Sala de copropietarios, recepción, terraza y espacios para reuniones sociales.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-icon">
                    <i class="fas fa-child"></i>
                </div>
                <h3>Parque Infantil</h3>
                <p>Área de juegos segura y moderna para el entretenimiento de los más pequeños.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="600">
                <div class="feature-icon">
                    <i class="fas fa-store"></i>
                </div>
                <h3>Locales Comerciales</h3>
                <p>8 locales comerciales en planta baja que brindan comodidad y servicios cercanos.</p>
            </div>
        </div>
    </div>
</section>

<!-- Location Section -->
<section class="location-section" id="location">
    <div class="location-container">
        <div class="location-header" data-aos="fade-up">
            <h2 class="section-title">Ubicación Privilegiada</h2>
            <p>En el corazón de La Paz con acceso a todo</p>
        </div>

        <div class="location-content">
            <div class="location-map" data-aos="fade-right" data-aos-delay="100">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3825.3!2d-68.136!3d-16.511!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x915eddb3c478619f%3A0xfa75ac9b8b6a60e4!2sCalle%20Ecuador%2C%20La%20Paz!5e0!3m2!1ses!2sbo!4v1711395182810!5m2!1ses!2sbo" allowfullscreen="" loading="lazy"></iframe>
            </div>

            <div class="location-info" data-aos="fade-left" data-aos-delay="200">
                <h3>Calle Ecuador - La Paz</h3>
                <p class="location-description">Ubicado estratégicamente entre Avenida 20 de Octubre y Calle Sánchez Lima, Riviera 21 te conecta con toda la ciudad desde una zona residencial premium.</p>

                <div class="location-features">
                    <div class="location-feature-item" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-graduation-cap"></i>
                        <div class="feature-text">
                            <h4>Plaza del Estudiante</h4>
                            <p>A minutos de universidades prestigiosas como UMSA, UCB y otras instituciones educativas.</p>
                        </div>
                    </div>

                    <div class="location-feature-item" data-aos="fade-up" data-aos-delay="400">
                        <i class="fas fa-shopping-cart"></i>
                        <div class="feature-text">
                            <h4>Centros Comerciales</h4>
                            <p>Acceso directo a mercados, supermercados y centros comerciales de la zona.</p>
                        </div>
                    </div>

                    <div class="location-feature-item" data-aos="fade-up" data-aos-delay="500">
                        <i class="fas fa-hospital"></i>
                        <div class="feature-text">
                            <h4>Servicios de Salud</h4>
                            <p>Hospitales y clínicas de primer nivel en el área cercana.</p>
                        </div>
                    </div>

                    <div class="location-feature-item" data-aos="fade-up" data-aos-delay="600">
                        <i class="fas fa-university"></i>
                        <div class="feature-text">
                            <h4>Servicios Bancarios</h4>
                            <p>Entidades financieras y bancarias para todas tus necesidades económicas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section" id="contact">
    <div class="contact-container">
        <div class="contact-header" data-aos="fade-up">
            <h2 class="section-title">Contáctanos</h2>
            <p>Da el primer paso hacia tu nuevo hogar</p>
        </div>

        <div class="contact-content">
            <div class="contact-form" data-aos="fade-right" data-aos-delay="100">
                <h3>Solicita información personalizada</h3>

                <form action="#" method="post">
                    <div class="form-group">
                        <label for="name">Nombre Completo</label>
                        <input type="text" id="name" name="name" placeholder="Tu nombre" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="tu@email.com" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Teléfono</label>
                        <input type="tel" id="phone" name="phone" placeholder="+591 XXXXXXXX" required>
                    </div>

                    <div class="form-group">
                        <label for="interest">Me interesa</label>
                        <select id="interest" name="interest" required>
                            <option value="">Selecciona una opción</option>
                            <option value="monoambiente">Monoambiente</option>
                            <option value="1dormitorio">1 Dormitorio</option>
                            <option value="2dormitorios">2 Dormitorios</option>
                            <option value="3dormitorios">3 Dormitorios</option>
                            <option value="local">Local Comercial</option>
                            <option value="parqueo">Parqueo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Mensaje</label>
                        <textarea id="message" name="message" rows="4" placeholder="Cuéntanos qué tipo de departamento buscas y cuándo te gustaría visitarnos"></textarea>
                    </div>

                    <button type="submit" class="contact-button">Solicitar Información</button>
                </form>
            </div>

            <div class="contact-info" data-aos="fade-left" data-aos-delay="200">
                <div class="contact-info-header">
                    <h3>Información de Contacto</h3>
                    <p>Nuestro equipo está listo para ayudarte a encontrar tu departamento ideal.</p>
                </div>

                <div class="contact-info-item" data-aos="fade-up" data-aos-delay="300">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="item-content">
                        <h4>Oficina de Ventas</h4>
                        <p>Calle Ecuador entre Av. 20 de Octubre<br>y Calle Sánchez Lima, La Paz</p>
                    </div>
                </div>

                <div class="contact-info-item" data-aos="fade-up" data-aos-delay="400">
                    <i class="fas fa-phone-alt"></i>
                    <div class="item-content">
                        <h4>Teléfonos</h4>
                        <p>+591 2 2445555</p>
                        <p>+591 70000000</p>
                    </div>
                </div>

                <div class="contact-info-item" data-aos="fade-up" data-aos-delay="500">
                    <i class="fas fa-envelope"></i>
                    <div class="item-content">
                        <h4>Email</h4>
                        <p>ventas@riviera21.com</p>
                        <p>info@riviera21.com</p>
                    </div>
                </div>

                <div class="contact-info-item" data-aos="fade-up" data-aos-delay="600">
                    <i class="fas fa-clock"></i>
                    <div class="item-content">
                        <h4>Horarios de Atención</h4>
                        <p>Lunes a Viernes: 9:00 - 18:00</p>
                        <p>Sábados: 9:00 - 14:00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-logo">
            <img src="/api/placeholder/200/80" alt="Riviera 21 Logo">
        </div>
        <p>&copy; 2025 Condominio Riviera 21. Todos los derechos reservados.</p>
        <p>Tu nuevo hogar en el corazón de La Paz</p>
    </div>
</footer>

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
                    <label for="modal-interest">Me interesa</label>
                    <select id="modal-interest" name="interest" required>
                        <option value="">Selecciona una opción</option>
                        <option value="monoambiente">Monoambiente</option>
                        <option value="1dormitorio">1 Dormitorio</option>
                        <option value="2dormitorios">2 Dormitorios</option>
                        <option value="3dormitorios">3 Dormitorios</option>
                    </select>
                </div>

                <button type="submit" class="contact-button">Enviar Solicitud</button>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize AOS
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

            // Parallax effect
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

            if ($target.length) {
                $('html, body').animate({
                    'scrollTop': $target.offset().top - 80
                }, 1000, 'swing');
            }
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

        // Create particles
        function createParticles() {
            const container = document.getElementById('particles-js');

            if (container && typeof particlesJS !== 'undefined') {
                particlesJS('particles-js', {
                    "particles": {
                        "number": {
                            "value": 80,
                            "density": {
                                "enable": true,
                                "value_area": 800
                            }
                        },
                        "color": {
                            "value": "#ffffff"
                        },
                        "shape": {
                            "type": "circle"
                        },
                        "opacity": {
                            "value": 0.5,
                            "random": false,
                            "anim": {
                                "enable": false,
                                "speed": 1,
                                "opacity_min": 0.1,
                                "sync": false
                            }
                        },
                        "size": {
                            "value": 3,
                            "random": true,
                            "anim": {
                                "enable": false,
                                "speed": 40,
                                "size_min": 0.1,
                                "sync": false
                            }
                        },
                        "line_linked": {
                            "enable": true,
                            "distance": 150,
                            "color": "#ffffff",
                            "opacity": 0.4,
                            "width": 1
                        },
                        "move": {
                            "enable": true,
                            "speed": 6,
                            "direction": "none",
                            "random": false,
                            "straight": false,
                            "out_mode": "out",
                            "bounce": false
                        }
                    },
                    "interactivity": {
                        "detect_on": "canvas",
                        "events": {
                            "onhover": {
                                "enable": true,
                                "mode": "repulse"
                            },
                            "onclick": {
                                "enable": true,
                                "mode": "push"
                            },
                            "resize": true
                        }
                    },
                    "retina_detect": true
                });
            }
        }

        // Initialize particles
        createParticles();
    });
</script>
</body>
</html>
