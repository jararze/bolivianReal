@push('styles')
    <style>
        body {
            background-color: #f7f7f7;
        }

        .section-container {
            width: 100%;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            padding: 0 20px;
        }

        .services-header {
            background: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80') #494c53 no-repeat center top;
            background-size: cover;
            padding: 60px 0;
            position: relative;
            color: #fff;
            margin-bottom: 0;
        }

        .services-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
        }

        .services-header-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .services-header-content h1 {
            font-weight: 600;
            margin-bottom: 10px;
            font-family: 'Dosis', sans-serif;
        }

        .section-title {
            color: #0DBAE8;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 25px;
            font-family: 'Dosis', sans-serif;
            text-transform: uppercase;
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
        }

        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background-color: #0DBAE8;
        }

        .services-intro {
            padding: 40px 0;
            background-color: #f7f7f7;
        }

        .services-intro p {
            margin-bottom: 15px;
            line-height: 1.6;
            color: #555;
        }

        .services-list {
            margin-top: 30px;
        }

        .services-list ul {
            list-style-type: none;
            padding-left: 0;
            margin-bottom: 30px;
        }

        .services-list ul li {
            position: relative;
            padding-left: 25px;
            margin-bottom: 10px;
            color: #555;
        }

        .services-list ul li:before {
            content: '•';
            color: #0DBAE8;
            font-size: 20px;
            position: absolute;
            left: 0;
            top: -2px;
        }

        .service-row {
            background-color: #fff;
            padding: 40px 0;
            margin-bottom: 0;
        }

        .service-row:nth-child(even) {
            background-color: #f7f7f7;
        }

        .service-card {
            display: flex;
            margin-bottom: 40px;
            background-color: #fff;
            border-radius: 0;
            box-shadow: none;
            overflow: hidden;
        }

        .service-row:nth-child(even) .service-card {
            background-color: #f7f7f7;
        }

        .service-image {
            flex: 0 0 30%;
            position: relative;
            overflow: hidden;
        }

        .service-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .service-icon {
            position: absolute;
            bottom: 15px;
            right: 15px;
            width: 50px;
            height: 50px;
            background: #0DBAE8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 20px;
            box-shadow: 0 2px 10px rgba(13, 186, 232, 0.3);
        }

        .service-content {
            flex: 0 0 65%;
            padding: 30px;
        }

        .service-content h3 {
            color: #333;
            margin-bottom: 15px;
            font-weight: 600;
            font-family: 'Dosis', sans-serif;
            font-size: 22px;
        }

        .service-content p {
            color: #555;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .service-details ul {
            list-style-type: none;
            padding-left: 0;
            margin-top: 15px;
        }

        .service-details ul li {
            position: relative;
            padding-left: 20px;
            margin-bottom: 8px;
            color: #555;
        }

        .service-details ul li:before {
            content: '•';
            color: #0DBAE8;
            position: absolute;
            left: 0;
            top: 0;
        }

        .promotion-channels {
            margin-top: 15px;
        }

        .promotion-channels ul {
            list-style-type: none;
            padding-left: 0;
        }

        .promotion-channels ul li {
            position: relative;
            padding-left: 20px;
            margin-bottom: 5px;
            color: #555;
        }

        .promotion-channels ul li:before {
            content: '•';
            color: #0DBAE8;
            position: absolute;
            left: 0;
            top: 0;
        }

        .why-choose-section {
            padding: 40px 0;
            background-color: #f7f7f7;
        }

        .why-choose-item {
            margin-bottom: 20px;
            padding-left: 30px;
            position: relative;
        }

        .why-choose-item:before {
            content: '\f00c';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            color: #0DBAE8;
            position: absolute;
            left: 0;
            top: 3px;
        }

        .why-choose-item p {
            color: #555;
            line-height: 1.6;
            margin-bottom: 0;
        }

        .service-cta {
            background: linear-gradient(135deg, #0DBAE8 0%, #0a8dac 100%);
            padding: 60px 0;
            color: #fff;
            text-align: center;
        }

        .service-cta h2 {
            font-family: 'Dosis', sans-serif;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .service-cta p {
            max-width: 700px;
            margin: 0 auto 30px;
            font-size: 18px;
        }

        .cta-button {
            display: inline-block;
            background: #fff;
            color: #0DBAE8;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .cta-button:hover {
            background: #f2f2f2;
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(0,0,0,0.2);
        }

        @media (max-width: 768px) {
            .service-card {
                flex-direction: column;
            }

            .service-image {
                flex: 0 0 200px;
            }

            .service-content {
                flex: 0 0 auto;
                padding: 20px;
            }
        }
    </style>
@endpush

<x-frontend-layout>
    <div class="services-header">
        <div class="container">
            <div class="services-header-content">
                <h1 class="page-title">NUESTROS SERVICIOS</h1>
                <p class="lead">Soluciones inmobiliarias integrales para todas tus necesidades</p>
            </div>
        </div>
    </div>

    <div class="services-intro">
        <div class="section-container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <h2 class="section-title">SERVICIOS PRINCIPALES</h2>

                    <p>En BOLIVIAN REAL ESTATE asesoramos a nuestros clientes en:</p>

                    <div class="services-list">
                        <ul>
                            <li>Compra – Venta</li>
                            <li>Alquiler</li>
                            <li>Anticrético</li>
                        </ul>
                        <p>De todo tipo de inmuebles.</p>
                        <p>También ofrecemos nuestros servicios especializados para cubrir todas sus necesidades inmobiliarias:</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Servicio 1: Avalúo -->
    <div class="service-row">
        <div class="section-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="{{ asset('assets/front/images/avaluo.jpg') }}"  style="width:750px; height: 80px" alt="Avalúo de inmuebles">
                            <div class="service-icon">
                                <i class="fa fa-calculator"></i>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3>Avalúo de inmuebles</h3>
                            <p>Nuestros profesionales le ofrecerán un avalúo de mercado basado en las características del inmueble, antigüedad, ubicación, acabados, superficie, etc., con el fin de guiar a los propietarios en el valor de mercado adecuado.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Servicio 2: Promoción -->
    <div class="service-row">
        <div class="section-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80" alt="Promoción de inmuebles">
                            <div class="service-icon">
                                <i class="fa fa-bullhorn"></i>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3>Promoción de inmuebles</h3>
                            <p>Nos encargamos de las estrategias de promoción para captar clientes potenciales, asegurando el mayor alcance posible de la propiedad.</p>
                            <p>Contamos con una cartera de clientes amplia que nos permite contactar directamente a los que creemos son nuestros clientes potenciales para cada inmueble (empresarios, constructores, etc.).</p>

                            <div class="promotion-channels">
                                <p>Actualmente nos encontramos en todos los medios que existen en Bolivia:</p>
                                <ul>
                                    <li>Página web de la empresa</li>
                                    <li>Grupos de WhatsApp</li>
                                    <li>Páginas especializadas en la promoción de inmuebles</li>
                                    <li>Plataformas Digitales (Ultracasas)</li>
                                    <li>Redes sociales (Facebook, Instagram, TikTok, WhatsApp, YouTube)</li>
                                    <li>Videos y carruseles promocionales</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Servicio 3: Gestión de visitas -->
    <div class="service-row">
        <div class="section-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1560520031-3a4dc4e9de0c?ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80" alt="Gestión de visitas">
                            <div class="service-icon">
                                <i class="fa fa-home"></i>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3>Gestión de visitas</h3>
                            <p>Coordinamos citas para que los clientes potenciales puedan visitar la propiedad. Nos aseguramos previamente a la visita de haber brindado toda la información del bien. Cualquier duda o curiosidad es subsanada antes o durante la misma.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Servicio 4: Documentación -->
    <div class="service-row">
        <div class="section-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80" alt="Documentación">
                            <div class="service-icon">
                                <i class="fa fa-file-alt"></i>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3>Documentación</h3>
                            <p>Realizamos la revisión de toda la documentación de la propiedad, asegurándonos que esté correcta. Si existiera alguna observación, nos encargamos de asesorar y acompañar en el proceso para subsanar la misma.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Servicio 5: Asesoramiento legal -->
    <div class="service-row">
        <div class="section-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80" alt="Asesoramiento en el área legal">
                            <div class="service-icon">
                                <i class="fa fa-gavel"></i>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3>Asesoramiento en el área legal</h3>
                            <p>Contamos con un equipo de abogados y notarios expertos en el área de bienes raíces, que lo asesorarán en la elaboración de todo tipo de contratos, minutas, protocolos, reconocimiento de firmas, revisión y regularización de la documentación legal de inmuebles.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Servicio 6: Gestiones municipales -->
    <div class="service-row">
        <div class="section-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1577415124269-fc1140a69e91?ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80" alt="Asesoramiento en gestiones municipales">
                            <div class="service-icon">
                                <i class="fa fa-city"></i>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3>Asesoramiento en gestiones municipales</h3>
                            <p>Le ayudamos a realizar todo tipo de trámites en el municipio como ser catastro, impuestos, transferencias, fraccionamiento, etc.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Servicio 7: Asesoramiento financiero -->
    <div class="service-row">
        <div class="section-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1563986768494-4dee2763ff3f?ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80" alt="Asesoramiento financiero">
                            <div class="service-icon">
                                <i class="fa fa-chart-line"></i>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3>Asesoramiento financiero</h3>
                            <p>Asesoramos a nuestros clientes en todo lo relativo a créditos hipotecarios de las diversas instituciones financieras, con las mejores tasas del mercado de acuerdo con sus posibilidades.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Servicio 8: Negociación/Intermediación -->
    <div class="service-row">
        <div class="section-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80" alt="Negociación/Intermediación experta">
                            <div class="service-icon">
                                <i class="fa fa-handshake"></i>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3>Negociación/Intermediación experta</h3>
                            <p>Actuamos como intermediarios y negociamos entre los propietarios y los futuros compradores o arrendatarios para llegar a un acuerdo final. Escuchamos y conocemos las necesidades de ambas partes e intentamos encontrar un compromiso, un acuerdo que satisfaga las expectativas de ambas partes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Servicio 9: Administración de inmuebles -->
    <div class="service-row">
        <div class="section-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1556912172-45b7abe8b7e1?ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80" alt="Administración de inmuebles">
                            <div class="service-icon">
                                <i class="fa fa-tasks"></i>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3>Administración de inmuebles</h3>
                            <p>Muchos de nuestros clientes han confiado en nuestra empresa no solo en la compra de inmuebles sino también en el alquiler y administración de estos a través de nuestra gerencia general.</p>
                            <p>Nos aseguramos de administrar tu propiedad, realizando tareas administrativas (pagos, cobros), mantenimiento (arreglos), atención al cliente, etc.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Servicio 10: Elaboración de proyectos -->
    <div class="service-row">
        <div class="section-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80" alt="Elaboración de proyectos arquitectónicos">
                            <div class="service-icon">
                                <i class="fa fa-drafting-compass"></i>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3>Elaboración de proyectos arquitectónicos y Remodelación</h3>
                            <p>Nuestra área de proyectos ofrece a nuestros clientes el asesoramiento y diseño arquitectónico de acuerdo con sus necesidades y requerimientos.</p>
                            <p>Así mismo nos encargamos de la refacción y remodelación de los inmuebles.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="why-choose-section">
        <div class="section-container">
            <h2 class="section-title">RAZONES PARA ELEGIR BOLIVIAN REAL ESTATE</h2>

            <div class="row">
                <div class="col-md-6">
                    <div class="why-choose-item">
                        <p>BRE, empresa líder en el rubro inmobiliario.</p>
                    </div>
                    <div class="why-choose-item">
                        <p>En Bolivian Real Estate trabajamos para ti, para lograr alquilar, vender o administrar tu propiedad.</p>
                    </div>
                    <div class="why-choose-item">
                        <p>Trabajamos para ti, para ayudarte a encontrar el inmueble que buscas, para que sea tu hogar, tu oficina, tu espacio personal.</p>
                    </div>
                    <div class="why-choose-item">
                        <p>Trabajamos para ti, para ser quien te acompañe en tu búsqueda y en el encuentro de lo que deseas y mereces, ya sea comprando, alquilando o vendiendo, porque nosotros crecemos cuando TÚ lo haces.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="why-choose-item">
                        <p>Tenemos objetivos claros, liderar el mercado, dando el mejor servicio posible, por lo tanto, nuestro personal está continuamente capacitado en las diferentes herramientas (Marketing, ventas, servicio al cliente, área legal, audiovisual, etc).</p>
                    </div>
                    <div class="why-choose-item">
                        <p>Contamos con agentes eficientes, capacitados, honestos, educados, dinámicos, amables, con empatía hacia los clientes.</p>
                    </div>
                    <div class="why-choose-item">
                        <p>Contamos con socios estratégicos que nos ayudan en el proceso y que nos dan una ventaja competitiva sobre otras empresas en el rubro (bancos, transporte, diseño de interiores, arquitectos, abogados, tramitadores, constructores, etc).</p>
                    </div>
                    <div class="why-choose-item">
                        <p>Trabajamos con empresas reconocidas en el mercado, organismos internacionales (OEA, BID, UN, Embajadas), emprendedores y jóvenes.</p>
                    </div>
                    <div class="why-choose-item">
                        <p>Los clientes terminan satisfechos con el servicio brindado.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="service-cta">
        <div class="section-container">
            <h2>¿Necesitas Asesoría Personalizada?</h2>
            <p>Nuestro equipo de expertos está listo para ayudarte con todas tus necesidades inmobiliarias. Contáctanos hoy mismo y descubre por qué somos líderes en el mercado.</p>
            <a href="#" class="cta-button">Contáctanos Ahora</a>
        </div>
    </div>
</x-frontend-layout>
