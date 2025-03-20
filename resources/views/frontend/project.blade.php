<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Residencial Las Palmas - Desarrollo Exclusivo</title>

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

    <style>
        /* Estilos para la landing parallax */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            font-family: 'Roboto', sans-serif;
            color: #333;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            padding: 15px 0;
            transition: all 0.4s ease;
        }

        .navbar.scrolled {
            background-color: rgba(0, 0, 0, 0.9);
            padding: 10px 0;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        .navbar-container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-logo {
            color: white;
            font-size: 24px;
            font-weight: 600;
            text-decoration: none;
            font-family: 'Dosis', sans-serif;
        }

        .navbar-logo img {
            height: 40px;
        }

        .navbar-menu {
            display: flex;
            list-style: none;
        }

        .navbar-menu li {
            margin-left: 30px;
        }

        .navbar-menu a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
            position: relative;
            padding: 5px 0;
            transition: all 0.3s ease;
        }

        .navbar-menu a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #0DBAE8;
            transition: width 0.3s ease;
        }

        .navbar-menu a:hover {
            color: #0DBAE8;
        }

        .navbar-menu a:hover::after {
            width: 100%;
        }

        .cta-button {
            background-color: #ff7e00;
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .cta-button:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.6s ease;
            z-index: -1;
        }

        .cta-button:hover:before {
            left: 100%;
        }

        .cta-button:hover {
            background-color: #e67200;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 126, 0, 0.3);
        }

        /* Secciones Parallax */
        .parallax-section {
            position: relative;
            height: 100vh;
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
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            transform: translateZ(0);
            will-change: transform;
        }

        .parallax-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            max-width: 800px;
            padding: 0 20px;
        }

        .hero-section .parallax-bg {
            background-image: url('https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80');
            filter: brightness(0.7);
        }

        .hero-section .parallax-content h1 {
            font-size: 56px;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            font-family: 'Dosis', sans-serif;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease forwards 0.5s;
        }

        .hero-section .parallax-content p {
            font-size: 20px;
            margin-bottom: 30px;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease forwards 0.8s;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-section .parallax-content .buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease forwards 1.1s;
        }

        .hero-details {
            position: absolute;
            bottom: 30px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 30px;
            opacity: 0;
            animation: fadeIn 1s ease forwards 1.5s;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .hero-detail-item {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 15px 25px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        .hero-detail-item:hover {
            transform: translateY(-5px);
            background-color: rgba(13, 186, 232, 0.8);
        }

        .hero-detail-item i {
            font-size: 24px;
            margin-right: 10px;
            color: #0DBAE8;
        }

        .hero-detail-item:hover i {
            color: white;
        }

        .hero-detail-item .detail-info h4 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .hero-detail-item .detail-info p {
            font-size: 14px;
            opacity: 0.8;
        }

        /* Sección About */
        .about-section {
            background-color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .about-section::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(13, 186, 232, 0.05);
            border-radius: 50%;
            top: -150px;
            left: -150px;
        }

        .about-section::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 126, 0, 0.05);
            border-radius: 50%;
            bottom: -250px;
            right: -250px;
        }

        .about-container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 60px;
            position: relative;
            z-index: 2;
        }

        .about-image {
            flex: 1;
            position: relative;
        }

        .about-image img {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.1);
            transition: all 0.5s ease;
        }

        .about-image:hover img {
            transform: scale(1.02);
        }

        .about-image::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border: 3px solid #0DBAE8;
            top: -20px;
            left: -20px;
            border-radius: 10px;
            z-index: -1;
            transition: all 0.3s ease;
        }

        .about-image:hover::before {
            top: -10px;
            left: -10px;
        }

        .about-content {
            flex: 1;
        }

        .section-title {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #333;
            position: relative;
            padding-bottom: 15px;
            font-family: 'Dosis', sans-serif;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: #0DBAE8;
            transition: width 0.3s ease;
        }

        .section-title:hover::after {
            width: 100px;
        }

        .about-content p {
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 20px;
            color: #666;
        }

        .about-features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        .about-feature-item {
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            padding: 10px;
            border-radius: 5px;
        }

        .about-feature-item:hover {
            background-color: rgba(13, 186, 232, 0.05);
            transform: translateX(5px);
        }

        .about-feature-item i {
            font-size: 18px;
            color: #0DBAE8;
            margin-right: 10px;
        }

        /* Sección Features con animaciones */
        .features-section {
            background-color: #f8f9fa;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .features-shape {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(13, 186, 232, 0.1), rgba(255, 126, 0, 0.1));
            top: -150px;
            right: -150px;
            animation: float 15s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(50px, 50px) rotate(5deg); }
            50% { transform: translate(0, 100px) rotate(0deg); }
            75% { transform: translate(-50px, 50px) rotate(-5deg); }
        }

        .features-container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .features-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .features-header .section-title {
            display: inline-block;
        }

        .features-header .section-title::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .feature-card {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            overflow: hidden;
            z-index: 1;
            border-bottom: 3px solid transparent;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(13, 186, 232, 0.05), rgba(255, 126, 0, 0.05));
            opacity: 0;
            z-index: -1;
            transition: opacity 0.5s ease;
        }

        .feature-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-bottom: 3px solid #0DBAE8;
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background-color: rgba(13, 186, 232, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            background-color: #0DBAE8;
            transform: scale(1.1) rotate(10deg);
        }

        .feature-icon i {
            font-size: 30px;
            color: #0DBAE8;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon i {
            color: white;
        }

        .feature-card h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
            transition: all 0.3s ease;
        }

        .feature-card:hover h3 {
            color: #0DBAE8;
        }

        .feature-card p {
            font-size: 15px;
            line-height: 1.7;
            color: #666;
        }

        /* Sección Gallery Parallax con animaciones */
        .gallery-section .parallax-bg {
            background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80');
            filter: brightness(0.3);
        }

        .gallery-container {
            position: relative;
            z-index: 2;
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .gallery-header {
            text-align: center;
            color: white;
            margin-bottom: 50px;
        }

        .gallery-header .section-title {
            color: white;
            display: inline-block;
        }

        .gallery-header .section-title::after {
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            height: 200px;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .gallery-item:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            z-index: 3;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-item::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-item:hover::after {
            opacity: 1;
        }

        .gallery-item-overlay {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
            color: white;
            z-index: 3;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
        }

        .gallery-item:hover .gallery-item-overlay {
            opacity: 1;
            transform: translateY(0);
        }

        .gallery-item-overlay h4 {
            font-size: 16px;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .gallery-item-overlay p {
            font-size: 12px;
            opacity: 0.8;
        }

        .gallery-zoom {
            position: absolute;
            top: 15px;
            right: 15px;
            color: white;
            font-size: 24px;
            z-index: 3;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .gallery-item:hover .gallery-zoom {
            opacity: 1;
            transform: translateY(0);
        }

        /* Sección Planos con animaciones 3D */
        .plans-section {
            background-color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .plans-shape-1 {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(13, 186, 232, 0.05) 0%, rgba(13, 186, 232, 0) 70%);
            border-radius: 50%;
            top: -200px;
            left: -200px;
        }

        .plans-shape-2 {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 126, 0, 0.05) 0%, rgba(255, 126, 0, 0) 70%);
            border-radius: 50%;
            bottom: -150px;
            right: -150px;
        }

        .plans-container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .plans-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .plans-header .section-title {
            display: inline-block;
        }

        .plans-header .section-title::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .plans-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .plan-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .plan-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .plan-image {
            height: 220px;
            position: relative;
            overflow: hidden;
        }

        .plan-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .plan-card:hover .plan-image img {
            transform: scale(1.1);
        }

        .plan-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: #0DBAE8;
            color: white;
            padding: 5px 15px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            box-shadow: 0 3px 10px rgba(13, 186, 232, 0.3);
            z-index: 2;
            transform: translateZ(30px);
        }

        .plan-content {
            padding: 25px;
            transform: translateZ(20px);
        }

        .plan-card h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
            transition: all 0.3s ease;
        }

        .plan-card:hover h3 {
            color: #0DBAE8;
        }

        .plan-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .plan-detail-item {
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .plan-detail-item i {
            color: #0DBAE8;
            margin-right: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .plan-card:hover .plan-detail-item i {
            transform: scale(1.2);
        }

        .plan-action {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .plan-price {
            font-size: 22px;
            font-weight: 700;
            color: #333;
            transition: all 0.3s ease;
        }

        .plan-card:hover .plan-price {
            color: #0DBAE8;
            transform: scale(1.05);
        }

        .plan-price small {
            font-size: 14px;
            font-weight: 400;
            color: #777;
        }

        /* Botón de planos 3D */
        .plan-3d-button {
            position: absolute;
            bottom: 15px;
            right: 15px;
            background-color: rgba(255, 126, 0, 0.9);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            transform: translateY(50px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .plan-image:hover .plan-3d-button {
            transform: translateY(0);
            opacity: 1;
        }

        /* Sección Ubicación con animaciones */
        .location-section {
            background-color: #f8f9fa;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .location-container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .location-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .location-header .section-title {
            display: inline-block;
        }

        .location-header .section-title::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .location-content {
            display: flex;
            gap: 50px;
        }

        .location-map {
            flex: 1;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            height: 450px;
            position: relative;
            transition: all 0.5s ease;
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .location-map:hover {
            transform: rotate3d(1, 1, 0, 5deg);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        .location-map iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .location-map::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, transparent 50%, rgba(0, 0, 0, 0.05) 100%);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .location-map:hover::after {
            opacity: 1;
        }

        .location-info {
            flex: 1;
        }

        .location-info h3 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
        }

        ..location-info h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: #0DBAE8;
            transition: width 0.3s ease;
        }

        .location-info h3:hover::after {
            width: 100%;
        }

        .location-description {
            font-size: 16px;
            line-height: 1.8;
            color: #666;
            margin-bottom: 30px;
        }

        .location-features {
            margin-top: 30px;
        }

        .location-feature-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            padding: 10px;
            border-radius: 8px;
        }

        .location-feature-item:hover {
            background-color: rgba(13, 186, 232, 0.05);
            transform: translateX(10px);
        }

        .location-feature-item i {
            font-size: 24px;
            color: #0DBAE8;
            margin-right: 15px;
            margin-top: 3px;
            transition: all 0.3s ease;
        }

        .location-feature-item:hover i {
            transform: scale(1.2);
        }

        .location-feature-item .feature-text h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
            transition: all 0.3s ease;
        }

        .location-feature-item:hover .feature-text h4 {
            color: #0DBAE8;
        }

        .location-feature-item .feature-text p {
            font-size: 15px;
            color: #666;
            line-height: 1.6;
        }

        /* Markers de ubicación animados */
        .location-points {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
        }

        .location-point {
            position: absolute;
            width: 20px;
            height: 20px;
            background-color: rgba(13, 186, 232, 0.7);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
        }

        .location-point::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(13, 186, 232, 0.4);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.7;
            }
            70% {
                transform: scale(3);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 0;
            }
        }

        .location-point:nth-child(1) {
            top: 40%;
            left: 35%;
            animation-delay: 0s;
        }

        .location-point:nth-child(2) {
            top: 60%;
            left: 50%;
            animation-delay: 0.5s;
        }

        .location-point:nth-child(3) {
            top: 30%;
            left: 65%;
            animation-delay: 1s;
        }

        /* Sección CTA Parallax con animación */
        .cta-section .parallax-bg {
            background-image: url('https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80');
            filter: brightness(0.4);
        }

        .cta-container {
            position: relative;
            z-index: 2;
            width: 90%;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            color: white;
        }

        .cta-container h2 {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
            font-family: 'Dosis', sans-serif;
            opacity: 0;
            transform: translateY(30px);
            animation: cta-fade-in 1s ease forwards 0.3s;
        }

        @keyframes cta-fade-in {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cta-container p {
            font-size: 18px;
            margin-bottom: 30px;
            text-shadow: 0 2px 3px rgba(0, 0, 0, 0.5);
            opacity: 0;
            transform: translateY(30px);
            animation: cta-fade-in 1s ease forwards 0.6s;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            opacity: 0;
            transform: translateY(30px);
            animation: cta-fade-in 1s ease forwards 0.9s;
        }

        .cta-buttons .cta-button.secondary {
            background-color: transparent;
            border: 2px solid white;
            transition: all 0.3s ease;
        }

        .cta-buttons .cta-button.secondary:hover {
            background-color: white;
            color: #333;
            transform: translateY(-3px);
        }

        /* Rayos de luz animados */
        .light-rays {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .light-ray {
            position: absolute;
            width: 4px;
            height: 100vh;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.2), transparent);
            transform-origin: top;
            animation: light-ray-animation 8s infinite linear;
            opacity: 0.3;
        }

        @keyframes light-ray-animation {
            0% {
                transform: translateX(-100vh) rotate(45deg);
                opacity: 0;
            }
            20% {
                opacity: 0.3;
            }
            80% {
                opacity: 0.3;
            }
            100% {
                transform: translateX(100vh) rotate(45deg);
                opacity: 0;
            }
        }

        .light-ray:nth-child(1) {
            left: 10%;
            animation-delay: 0s;
        }

        .light-ray:nth-child(2) {
            left: 30%;
            animation-delay: 2s;
        }

        .light-ray:nth-child(3) {
            left: 50%;
            animation-delay: 4s;
        }

        .light-ray:nth-child(4) {
            left: 70%;
            animation-delay: 6s;
        }

        .light-ray:nth-child(5) {
            left: 90%;
            animation-delay: 8s;
        }

        /* Sección Testimonios con animaciones */
        .testimonials-section {
            background-color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .testimonial-shape {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(13, 186, 232, 0.05) 0%, rgba(13, 186, 232, 0) 70%);
            border-radius: 50%;
            top: -200px;
            right: -200px;
        }

        .testimonials-container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .testimonials-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .testimonials-header .section-title {
            display: inline-block;
        }

        .testimonials-header .section-title::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .swiper-testimonials {
            overflow: visible !important;
            padding: 30px 0 !important;
        }

        .testimonial-item {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            transform: scale(0.9);
            opacity: 0.7;
        }

        .swiper-slide-active .testimonial-item {
            transform: scale(1);
            opacity: 1;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .testimonial-quote {
            font-size: 18px;
            line-height: 1.8;
            color: #555;
            margin-bottom: 30px;
            position: relative;
        }

        .testimonial-quote::before,
        .testimonial-quote::after {
            content: '"';
            font-size: 60px;
            line-height: 0;
            color: #0DBAE8;
            opacity: 0.3;
            position: absolute;
        }

        .testimonial-quote::before {
            top: 15px;
            left: -15px;
        }

        .testimonial-quote::after {
            bottom: -15px;
            right: -15px;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .testimonial-author-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 15px;
            border: 3px solid white;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .testimonial-item:hover .testimonial-author-image {
            transform: scale(1.1);
            border-color: #0DBAE8;
        }

        .testimonial-author-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .testimonial-author-info h4 {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .testimonial-author-info p {
            font-size: 14px;
            color: #777;
        }

        .swiper-pagination {
            position: relative;
            margin-top: 40px;
        }

        .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background-color: #ddd;
            opacity: 1;
            transition: all 0.3s ease;
        }

        .swiper-pagination-bullet-active {
            background-color: #0DBAE8;
            transform: scale(1.3);
        }

        /* Quote marks flotantes */
        .floating-quote {
            position: absolute;
            font-size: 120px;
            color: rgba(13, 186, 232, 0.05);
            z-index: -1;
            font-family: 'Georgia', serif;
        }

        .floating-quote:nth-child(1) {
            top: 20%;
            left: 5%;
            animation: float-1 15s infinite ease-in-out;
        }

        .floating-quote:nth-child(2) {
            bottom: 20%;
            right: 5%;
            animation: float-2 18s infinite ease-in-out;
        }

        @keyframes float-1 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(20px, 10px) rotate(5deg); }
            50% { transform: translate(0, 20px) rotate(0deg); }
            75% { transform: translate(-20px, 10px) rotate(-5deg); }
        }

        @keyframes float-2 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(-20px, -10px) rotate(-5deg); }
            50% { transform: translate(0, -20px) rotate(0deg); }
            75% { transform: translate(20px, -10px) rotate(5deg); }
        }

        /* Sección de Contacto con animaciones */
        .contact-section {
            background-color: #f8f9fa;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .contact-shape-1 {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(13, 186, 232, 0.05) 0%, rgba(13, 186, 232, 0) 70%);
            border-radius: 50%;
            bottom: -150px;
            left: -150px;
        }

        .contact-shape-2 {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 126, 0, 0.05) 0%, rgba(255, 126, 0, 0) 70%);
            border-radius: 50%;
            top: -200px;
            right: -200px;
        }

        .contact-container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .contact-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .contact-header .section-title {
            display: inline-block;
        }

        .contact-header .section-title::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .contact-content {
            display: flex;
            gap: 50px;
        }

        .contact-form {
            flex: 1;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            transform: translateZ(0);
        }

        .contact-form:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .contact-form h3 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #333;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
            position: relative;
        }

        .contact-form h3::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: #0DBAE8;
            transition: width 0.3s ease;
        }

        .contact-form:hover h3::after {
            width: 100px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
            transition: all 0.3s ease;
        }

        .form-group input:focus + label,
        .form-group textarea:focus + label {
            color: #0DBAE8;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: #0DBAE8;
            outline: none;
            box-shadow: 0 0 0 3px rgba(13, 186, 232, 0.1);
        }

        .form-group textarea {
            height: 120px;
            resize: vertical;
        }

        .form-group input:focus::placeholder,
        .form-group textarea:focus::placeholder {
            opacity: 0.5;
        }

        .contact-button {
            background-color: #0DBAE8;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .contact-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.6s ease;
            z-index: -1;
        }

        .contact-button:hover::before {
            left: 100%;
        }

        .contact-button:hover {
            background-color: #0a9ac2;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(13, 186, 232, 0.3);
        }

        .contact-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .contact-info-header h3 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
        }

        .contact-info-header h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: #0DBAE8;
            transition: width 0.3s ease;
        }

        .contact-info-header h3:hover::after {
            width: 100%;
        }

        .contact-info-header p {
            font-size: 16px;
            line-height: 1.8;
            color: #666;
            margin-bottom: 30px;
        }

        .contact-info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
            transition: all 0.3s ease;
            padding: 15px;
            border-radius: 10px;
        }

        .contact-info-item:hover {
            background-color: white;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transform: translateY(-5px);
        }

        .contact-info-item i {
            font-size: 24px;
            color: #0DBAE8;
            margin-right: 15px;
            margin-top: 3px;
            transition: all 0.3s ease;
        }

        .contact-info-item:hover i {
            transform: scale(1.2);
        }

        .contact-info-item .item-content h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
            transition: all 0.3s ease;
        }

        .contact-info-item:hover .item-content h4 {
            color: #0DBAE8;
        }

        .contact-info-item .item-content p {
            font-size: 15px;
            color: #666;
            line-height: 1.6;
        }

        .contact-social {
            margin-top: 30px;
        }

        .contact-social h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
            position: relative;
            display: inline-block;
            padding-bottom: 8px;
        }

        .contact-social h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 30px;
            height: 2px;
            background-color: #0DBAE8;
            transition: width 0.3s ease;
        }

        .contact-social h4:hover::after {
            width: 100%;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: #f1f1f1;
            border-radius: 50%;
            color: #555;
            font-size: 18px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .social-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #0DBAE8;
            transform: scale(0);
            transition: all 0.3s ease;
            border-radius: 50%;
            z-index: -1;
        }

        .social-link:hover {
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 5px 10px rgba(13, 186, 232, 0.3);
        }

        .social-link:hover::before {
            transform: scale(1);
        }

        /* Footer con animaciones */
        .footer {
            background-color: #333;
            color: white;
            padding: 30px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #0DBAE8, #ff7e00, #0DBAE8);
            background-size: 200% 100%;
            animation: gradient-move 10s infinite linear;
        }

        @keyframes gradient-move {
            0% {
                background-position: 0% 50%;
            }
            100% {
                background-position: 200% 50%;
            }
        }

        .footer-container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .footer-logo {
            margin-bottom: 20px;
        }

        .footer-logo img {
            height: 40px;
            transition: all 0.3s ease;
        }

        .footer-logo:hover img {
            transform: scale(1.1);
        }

        .footer p {
            font-size: 14px;
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .footer p:hover {
            opacity: 1;
        }

        /* Patrón de fondo del footer */
        .footer-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.1;
        }

        /* Botón de regreso arriba con animación */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background-color: #0DBAE8;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            z-index: 999;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            transform: translateY(30px) scale(0.5);
        }

        .back-to-top.visible {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .back-to-top:hover {
            background-color: #0a9ac2;
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .back-to-top i {
            transition: all 0.3s ease;
        }

        .back-to-top:hover i {
            transform: translateY(-3px);
        }

        /* Efecto de partículas */
        .particles-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .particle {
            position: absolute;
            width: 5px;
            height: 5px;
            background-color: rgba(13, 186, 232, 0.5);
            border-radius: 50%;
            pointer-events: none;
            opacity: 0;
            animation: particle-float 15s infinite linear;
        }

        @keyframes particle-float {
            0% {
                transform: translate(0, 0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.8;
            }
            90% {
                opacity: 0.8;
            }
            100% {
                transform: translate(var(--end-x), var(--end-y)) rotate(360deg);
                opacity: 0;
            }
        }

        /* Modal de Contacto Rápido con animaciones */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .modal.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background-color: white;
            width: 90%;
            max-width: 500px;
            border-radius: 10px;
            overflow: hidden;
            transform: scale(0.8) translateY(30px);
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }

        .modal.active .modal-content {
            transform: scale(1) translateY(0);
        }

        .modal-header {
            background: linear-gradient(135deg, #0DBAE8, #0a9ac2);
            color: white;
            padding: 20px;
            position: relative;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            color: white;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 30px;
        }

        /* Animaciones para elementos cuando aparecen */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .fade-in.appear {
            opacity: 1;
            transform: translateY(0);
        }

        /* Partículas flotantes y brillos */
        .floating-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .floating-particle {
            position: absolute;
            background-color: rgba(13, 186, 232, 0.2);
            border-radius: 50%;
            pointer-events: none;
        }

        /* Animación de contador */
        .stat-counter {
            display: inline-block;
            font-weight: 700;
            color: #0DBAE8;
        }

        /* Animación de texto escritura */
        .typing-text {
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
            border-right: 2px solid #0DBAE8;
            animation: typing 3.5s steps(40, end), blink-caret 0.75s step-end infinite;
        }

        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }

        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: #0DBAE8 }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .about-container {
                flex-direction: column;
                gap: 40px;
            }

            .about-image::before {
                display: none;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .gallery-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .plans-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .location-content {
                flex-direction: column;
            }

            .contact-content {
                flex-direction: column;
            }
        }

        @media (max-width: 768px) {
            .navbar-menu {
                display: none;
            }

            .hero-section .parallax-content h1 {
                font-size: 40px;
            }

            .hero-section .parallax-content p {
                font-size: 18px;
            }

            .hero-details {
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }

            .hero-detail-item {
                width: 100%;
                max-width: 300px;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .plans-grid {
                grid-template-columns: 1fr;
            }

            .cta-buttons {
                flex-direction: column;
                gap: 15px;
            }
        }

        @media (max-width: 480px) {
            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .hero-section .parallax-content .buttons {
                flex-direction: column;
                gap: 15px;
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
        <a href="#" class="navbar-logo">
            <img src="https://via.placeholder.com/150x50?text=LOGO" alt="Logo" />
        </a>

        <ul class="navbar-menu">
            <li><a href="#about">Acerca de</a></li>
            <li><a href="#features">Características</a></li>
            <li><a href="#gallery">Galería</a></li>
            <li><a href="#plans">Planos</a></li>
            <li><a href="#location">Ubicación</a></li>
            <li><a href="#contact">Contacto</a></li>
        </ul>

        <button class="cta-button open-modal">Solicitar Info</button>
    </div>
</nav>

<!-- Hero Section -->
<section class="parallax-section hero-section" id="home">
    <div class="parallax-bg"></div>
    <div class="parallax-content">
        <h1>Residencial Las Palmas</h1>
        <p>Un exclusivo conjunto residencial que combina elegancia, confort y la mejor ubicación</p>

        <div class="buttons">
            <a href="#plans" class="cta-button">Ver Planos</a>
            <a href="#gallery" class="cta-button" style="background-color: transparent; border: 2px solid white;">Galería</a>
        </div>
    </div>

    <div class="hero-details">
        <div class="hero-detail-item">
            <i class="fas fa-map-marker-alt"></i>
            <div class="detail-info">
                <h4>Ubicación</h4>
                <p>Zona Norte, Santa Cruz</p>
            </div>
        </div>

        <div class="hero-detail-item">
            <i class="fas fa-home"></i>
            <div class="detail-info">
                <h4>Tipo</h4>
                <p>Departamentos de Lujo</p>
            </div>
        </div>

        <div class="hero-detail-item">
            <i class="fas fa-calendar-alt"></i>
            <div class="detail-info">
                <h4>Entrega</h4>
                <p>Diciembre 2025</p>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section" id="about">
    <div class="about-container">
        <div class="about-image" data-aos="fade-right" data-aos-duration="1000">
            <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" alt="About Project">
        </div>

        <div class="about-content" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
            <h2 class="section-title">Acerca del Proyecto</h2>
            <p>Residencial Las Palmas es un exclusivo desarrollo inmobiliario diseñado para ofrecer el más alto estándar de vida urbana. Situado en una de las zonas más privilegiadas de la ciudad, combina elegancia arquitectónica con funcionalidad y confort.</p>

            <p>Cada espacio ha sido meticulosamente pensado para brindar la máxima comodidad a sus residentes, integrando elementos de diseño contemporáneo con acabados de primera calidad y tecnología de vanguardia.</p>

            <div class="about-features">
                <div class="about-feature-item" data-aos="fade-up" data-aos-delay="300">
                    <i class="fas fa-check-circle"></i>
                    <span>Arquitectura moderna</span>
                </div>
                <div class="about-feature-item" data-aos="fade-up" data-aos-delay="400">
                    <i class="fas fa-check-circle"></i>
                    <span>Materiales premium</span>
                </div>
                <div class="about-feature-item" data-aos="fade-up" data-aos-delay="500">
                    <i class="fas fa-check-circle"></i>
                    <span>Áreas verdes</span>
                </div>
                <div class="about-feature-item" data-aos="fade-up" data-aos-delay="600">
                    <i class="fas fa-check-circle"></i>
                    <span>Seguridad 24/7</span>
                </div>
                <div class="about-feature-item" data-aos="fade-up" data-aos-delay="700">
                    <i class="fas fa-check-circle"></i>
                    <span>Amenidades de lujo</span>
                </div>
                <div class="about-feature-item" data-aos="fade-up" data-aos-delay="800">
                    <i class="fas fa-check-circle"></i>
                    <span>Eficiencia energética</span>
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
                    <i class="fas fa-swimming-pool"></i>
                </div>
                <h3>Piscina Infinity</h3>
                <p>Disfruta de momentos de relajación en nuestra piscina con vista panorámica a la ciudad.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                    <i class="fas fa-dumbbell"></i>
                </div>
                <h3>Gimnasio Completo</h3>
                <p>Equipado con lo último en tecnología para mantener tu rutina de ejercicios sin salir del complejo.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Seguridad Integral</h3>
                <p>Sistema de vigilancia 24/7, acceso controlado y personal de seguridad capacitado.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon">
                    <i class="fas fa-car"></i>
                </div>
                <h3>Estacionamiento Privado</h3>
                <p>Cada unidad cuenta con espacios de estacionamiento asignados y seguridad garantizada.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <h3>Áreas Verdes</h3>
                <p>Amplios jardines y espacios de recreación para disfrutar de momentos al aire libre.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="600">
                <div class="feature-icon">
                    <i class="fas fa-wifi"></i>
                </div>
                <h3>Smart Building</h3>
                <p>Tecnología integrada para el control de iluminación, climatización y seguridad desde tu smartphone.</p>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section (Parallax) -->
<section class="parallax-section gallery-section" id="gallery">
    <div class="parallax-bg"></div>

    <div class="gallery-container">
        <div class="gallery-header" data-aos="fade-up">
            <h2 class="section-title">Galería de Imágenes</h2>
        </div>

        <div class="gallery-grid">
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="100">
                <img src="https://images.unsplash.com/photo-1523217582562-09d0def993a6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2320&q=80" alt="Fachada">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Fachada Principal</h4>
                    <p>Diseño arquitectónico moderno</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="200">
                <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" alt="Sala de estar">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Sala de Estar</h4>
                    <p>Espacios amplios y luminosos</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="300">
                <img src="https://images.unsplash.com/photo-1565538810643-b5bdb714032a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" alt="Cocina">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Cocina Integral</h4>
                    <p>Acabados de alta calidad</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="400">
                <img src="https://images.unsplash.com/photo-1540518614846-7eded433c457?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1739&q=80" alt="Dormitorio">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Dormitorio Principal</h4>
                    <p>Confort y elegancia</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="100">
                <img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" alt="Baño">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Baño de Lujo</h4>
                    <p>Diseño y funcionalidad</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="200">
                <img src="https://images.unsplash.com/photo-1572331165267-854da2b10ccc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" alt="Terraza">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Terraza Privada</h4>
                    <p>Vistas panorámicas</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="300">
                <img src="https://images.unsplash.com/photo-1551958219-acbc608c6377?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" alt="Gimnasio">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Gimnasio</h4>
                    <p>Equipamiento de última generación</p>
                </div>
            </div>

            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="400">
                <img src="https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" alt="Piscina">
                <div class="gallery-zoom">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="gallery-item-overlay">
                    <h4>Piscina Infinity</h4>
                    <p>Relax y entretenimiento</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Plans Section -->
<section class="plans-section" id="plans">
    <div class="plans-shape-1"></div>
    <div class="plans-shape-2"></div>
    <div class="plans-container">
        <div class="plans-header" data-aos="fade-up">
            <h2 class="section-title">Nuestros Planos</h2>
        </div>

        <div class="plans-grid">
            <div class="plan-card" data-aos="fade-up" data-aos-delay="100">
                <div class="plan-image">
                    <img src="https://images.unsplash.com/photo-1600585153490-76fb20a32601?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" alt="Tipo A">
                    <span class="plan-badge">Tipo A</span>
                    <div class="plan-3d-button">
                        <i class="fas fa-cube"></i> Ver en 3D
                    </div>
                </div>
                <div class="plan-content">
                    <h3>Apartamento de 2 Dormitorios</h3>
                    <div class="plan-details">
                        <div class="plan-detail-item">
                            <i class="fas fa-home"></i>
                            <span>120 m²</span>
                        </div>
                        <div class="plan-detail-item">
                            <i class="fas fa-bed"></i>
                            <span>2 Dormitorios</span>
                        </div>
                        <div class="plan-detail-item">
                            <i class="fas fa-bath"></i>
                            <span>2 Baños</span>
                        </div>
                        <div class="plan-detail-item">
                            <i class="fas fa-car"></i>
                            <span>1 Garaje</span>
                        </div>
                    </div>
                    <div class="plan-action">
                        <div class="plan-price">
                            $120,000 <small>USD</small>
                        </div>
                        <a href="#" class="cta-button">Ver Detalles</a>
                    </div>
                </div>
            </div>

            <div class="plan-card" data-aos="fade-up" data-aos-delay="200">
                <div class="plan-image">
                    <img src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" alt="Tipo B">
                    <span class="plan-badge">Tipo B</span>
                    <div class="plan-3d-button">
                        <i class="fas fa-cube"></i> Ver en 3D
                    </div>
                </div>
                <div class="plan-content">
                    <h3>Apartamento de 3 Dormitorios</h3>
                    <div class="plan-details">
                        <div class="plan-detail-item">
                            <i class="fas fa-home"></i>
                            <span>150 m²</span>
                        </div>
                        <div class="plan-detail-item">
                            <i class="fas fa-bed"></i>
                            <span>3 Dormitorios</span>
                        </div>
                        <div class="plan-detail-item">
                            <i class="fas fa-bath"></i>
                            <span>2 Baños</span>
                        </div>
                        <div class="plan-detail-item">
                            <i class="fas fa-car"></i>
                            <span>2 Garajes</span>
                        </div>
                    </div>
                    <div class="plan-action">
                        <div class="plan-price">
                            $160,000 <small>USD</small>
                        </div>
                        <a href="#" class="cta-button">Ver Detalles</a>
                    </div>
                </div>
            </div>

            <div class="plan-card" data-aos="fade-up" data-aos-delay="300">
                <div class="plan-image">
                    <img src="https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" alt="Tipo C">
                    <span class="plan-badge">Tipo C</span>
                    <div class="plan-3d-button">
                        <i class="fas fa-cube"></i> Ver en 3D
                    </div>
                </div>
                <div class="plan-content">
                    <h3>Penthouse de Lujo</h3>
                    <div class="plan-details">
                        <div class="plan-detail-item">
                            <i class="fas fa-home"></i>
                            <span>200 m²</span>
                        </div>
                        <div class="plan-detail-item">
                            <i class="fas fa-bed"></i>
                            <span>4 Dormitorios</span>
                        </div>
                        <div class="plan-detail-item">
                            <i class="fas fa-bath"></i>
                            <span>3 Baños</span>
                        </div>
                        <div class="plan-detail-item">
                            <i class="fas fa-car"></i>
                            <span>2 Garajes</span>
                        </div>
                    </div>
                    <div class="plan-action">
                        <div class="plan-price">
                            $220,000 <small>USD</small>
                        </div>
                        <a href="#" class="cta-button">Ver Detalles</a>
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
            <h2 class="section-title">Ubicación Estratégica</h2>
        </div>

        <div class="location-content">
            <div class="location-map" data-aos="fade-right" data-aos-delay="100">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d121863.79585177159!2d-63.21339546219482!3d-17.783774896235023!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x93f1e81ca7a0b26b%3A0xb61f89dd3fb25643!2sSanta%20Cruz%20de%20la%20Sierra%2C%20Bolivia!5e0!3m2!1ses!2ses!4v1616084043697!5m2!1ses!2ses" allowfullscreen="" loading="lazy"></iframe>

                <div class="location-points">
                    <div class="location-point"></div>
                    <div class="location-point"></div>
                    <div class="location-point"></div>
                </div>
            </div>

            <div class="location-info" data-aos="fade-left" data-aos-delay="200">
                <h3>Un Lugar Privilegiado</h3>
                <p class="location-description">Residencial Las Palmas se encuentra ubicado en una de las zonas más exclusivas y de mayor crecimiento de la ciudad, combinando tranquilidad con accesibilidad a todos los servicios urbanos esenciales.</p>

                <div class="location-features">
                    <div class="location-feature-item" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-shopping-cart"></i>
                        <div class="feature-text">
                            <h4>Centros Comerciales</h4>
                            <p>A solo 5 minutos del centro comercial más grande de la ciudad.</p>
                        </div>
                    </div>

                    <div class="location-feature-item" data-aos="fade-up" data-aos-delay="400">
                        <i class="fas fa-hospital"></i>
                        <div class="feature-text">
                            <h4>Servicios Médicos</h4>
                            <p>Hospitales y clínicas privadas a menos de 10 minutos.</p>
                        </div>
                    </div>

                    <div class="location-feature-item" data-aos="fade-up" data-aos-delay="500">
                        <i class="fas fa-graduation-cap"></i>
                        <div class="feature-text">
                            <h4>Educación</h4>
                            <p>Prestigiosos colegios y universidades en los alrededores.</p>
                        </div>
                    </div>

                    <div class="location-feature-item" data-aos="fade-up" data-aos-delay="600">
                        <i class="fas fa-tree"></i>
                        <div class="feature-text">
                            <h4>Áreas Verdes</h4>
                            <p>Parques y reservas naturales cercanas para disfrutar de la naturaleza.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section (Parallax) -->
<section class="parallax-section cta-section">
    <div class="parallax-bg"></div>
    <div class="light-rays">
        <div class="light-ray"></div>
        <div class="light-ray"></div>
        <div class="light-ray"></div>
        <div class="light-ray"></div>
        <div class="light-ray"></div>
    </div>

    <div class="cta-container">
        <h2>¿Listo para Vivir la Experiencia?</h2>
        <p>Aprovecha nuestras promociones de preventa y asegura tu lugar en el desarrollo residencial más exclusivo de la ciudad.</p>

        <div class="cta-buttons">
            <button class="cta-button open-modal">Solicitar Información</button>
            <a href="#plans" class="cta-button secondary">Ver Planos</a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section" id="testimonials">
    <div class="testimonial-shape"></div>
    <div class="floating-quote">"</div>
    <div class="floating-quote">"</div>

    <div class="testimonials-container">
        <div class="testimonials-header" data-aos="fade-up">
            <h2 class="section-title">Testimonios</h2>
        </div>

        <div class="swiper-container swiper-testimonials" data-aos="fade-up" data-aos-delay="200">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <p class="testimonial-quote">Decidir invertir en Residencial Las Palmas fue una de las mejores decisiones. La calidad de construcción, los acabados y la ubicación superaron todas mis expectativas.</p>

                        <div class="testimonial-author">
                            <div class="testimonial-author-image">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Testimonial Author">
                            </div>
                            <div class="testimonial-author-info">
                                <h4>Carlos Rodríguez</h4>
                                <p>Propietario</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <p class="testimonial-quote">El proceso de compra fue muy profesional, siempre con atención personalizada y transparencia en toda la información. Ahora disfruto de mi apartamento con unas vistas increíbles.</p>

                        <div class="testimonial-author">
                            <div class="testimonial-author-image">
                                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Testimonial Author">
                            </div>
                            <div class="testimonial-author-info">
                                <h4>Ana García</h4>
                                <p>Propietaria</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <p class="testimonial-quote">Las áreas comunes son espectaculares, especialmente la piscina y el gimnasio. La seguridad y el mantenimiento son impecables. Recomiendo este proyecto sin dudarlo.</p>

                        <div class="testimonial-author">
                            <div class="testimonial-author-image">
                                <img src="https://randomuser.me/api/portraits/men/67.jpg" alt="Testimonial Author">
                            </div>
                            <div class="testimonial-author-info">
                                <h4>Juan Pérez</h4>
                                <p>Propietario</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-pagination"></div>
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
                <h3>Envíanos un Mensaje</h3>

                <form action="#" method="post">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Teléfono</label>
                        <input type="tel" id="phone" name="phone">
                    </div>

                    <div class="form-group">
                        <label for="message">Mensaje</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>

                    <button type="submit" class="contact-button">Enviar Mensaje</button>
                </form>
            </div>

            <div class="contact-info" data-aos="fade-left" data-aos-delay="200">
                <div class="contact-info-header">
                    <h3>Información de Contacto</h3>
                    <p>Estamos disponibles para responder todas tus consultas y brindarte la información que necesitas sobre nuestros proyectos inmobiliarios.</p>
                </div>

                <div class="contact-info-item" data-aos="fade-up" data-aos-delay="300">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="item-content">
                        <h4>Dirección</h4>
                        <p>Av. Principal #123, Zona Norte<br>Santa Cruz, Bolivia</p>
                    </div>
                </div>

                <div class="contact-info-item" data-aos="fade-up" data-aos-delay="400">
                    <i class="fas fa-phone-alt"></i>
                    <div class="item-content">
                        <h4>Teléfono</h4>
                        <p>+591 3 333-4444</p>
                    </div>
                </div>

                <div class="contact-info-item" data-aos="fade-up" data-aos-delay="500">
                    <i class="fas fa-envelope"></i>
                    <div class="item-content">
                        <h4>Email</h4>
                        <p>info@residenciallaspalmas.com</p>
                    </div>
                </div>

                <div class="contact-social" data-aos="fade-up" data-aos-delay="600">
                    <h4>Síguenos</h4>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
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
            <img src="https://via.placeholder.com/150x50?text=LOGO" alt="Logo">
        </div>

        <p>&copy; {{ date('Y') }} Residencial Las Palmas. Todos los derechos reservados.</p>
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
                    <label for="modal-name">Nombre</label>
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
                    <select id="modal-interest" name="interest" class="form-select">
                        <option value="tipo-a">Apartamento Tipo A</option>
                        <option value="tipo-b">Apartamento Tipo B</option>
                        <option value="tipo-c">Penthouse</option>
                        <option value="general">Información General</option>
                    </select>
                </div>

                <button type="submit" class="contact-button">Enviar</button>
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
        // Inicializar AOS (Animate On Scroll)
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Inicializar Swiper para testimonios
        var testimonialSwiper = new Swiper('.swiper-testimonials', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            }
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

        // Efecto 3D en tarjetas de planos
        $('.plan-card').on('mousemove', function(e) {
            const card = $(this);
            const cardWidth = card.width();
            const cardHeight = card.height();
            const centerX = card.offset().left + cardWidth / 2;
            const centerY = card.offset().top + cardHeight / 2;
            const posX = e.pageX - centerX;
            const posY = e.pageY - centerY;
            const rotateX = (posY / (cardHeight / 2)) * -5;
            const rotateY = (posX / (cardWidth / 2)) * 5;

            card.css('transform', `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`);
        });

        $('.plan-card').on('mouseleave', function() {
            $(this).css('transform', 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)');
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
            // Por ahora, solo una alerta
            alert(`Ver imagen ampliada: ${imgAlt}`);
        });
    });
</script>
</body>
</html>
