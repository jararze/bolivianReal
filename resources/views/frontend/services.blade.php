@push('styles')
    <style>
        .services-header {
            background: url('{{ asset('assets/front/images/banner2.jpg') }}') #494c53 no-repeat center top;
            background-size: cover;
            padding: 80px 0;
            position: relative;
            color: #fff;
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
        }

        .services-intro {
            padding: 60px 0;
            background-color: #f9f9f9;
        }

        .services-intro h2 {
            color: #0DBAE8;
            font-weight: 600;
            margin-bottom: 30px;
            font-family: 'Dosis', sans-serif;
            text-transform: uppercase;
        }

        .services-intro p {
            margin-bottom: 20px;
            line-height: 1.7;
            color: #555;
        }

        .services-grid {
            padding: 60px 0;
        }

        .service-item {
            margin-bottom: 40px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: #fff;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        }

        .service-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .service-image {
            position: relative;
            overflow: hidden;
            height: 200px;
        }

        .service-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .service-item:hover .service-image img {
            transform: scale(1.1);
        }

        .service-icon {
            position: absolute;
            bottom: -25px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: #0DBAE8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 24px;
            box-shadow: 0 2px 10px rgba(13, 186, 232, 0.3);
        }

        .service-content {
            padding: 30px 20px 20px;
        }

        .service-content h3 {
            color: #333;
            margin-bottom: 15px;
            font-weight: 600;
            font-family: 'Dosis', sans-serif;
        }

        .service-content p {
            color: #555;
            margin-bottom: 20px;
        }

        .service-link {
            color: #0DBAE8;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: color 0.3s ease;
        }

        .service-link:hover {
            color: #0a8dac;
        }

        .service-link i {
            margin-left: 5px;
            transition: transform 0.3s ease;
        }

        .service-link:hover i {
            transform: translateX(3px);
        }

        .service-cta {
            background: linear-gradient(135deg, #0DBAE8 0%, #0a8dac 100%);
            padding: 80px 0;
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

        .faq-section {
            padding: 60px 0;
            background-color: #f9f9f9;
        }

        .faq-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .faq-header h2 {
            color: #0DBAE8;
            font-weight: 600;
            margin-bottom: 15px;
            font-family: 'Dosis', sans-serif;
            text-transform: uppercase;
        }

        .accordion-item {
            margin-bottom: 15px;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .accordion-header {
            background: #fff;
            padding: 15px 20px;
            cursor: pointer;
            position: relative;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .accordion-header:hover {
            background: #f5f5f5;
        }

        .accordion-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            transition: transform 0.3s ease;
        }

        .active .accordion-icon {
            transform: translateY(-50%) rotate(180deg);
        }

        .accordion-content {
            background: #fff;
            padding: 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
        }

        .accordion-content-inner {
            padding: 0 20px;
        }

        .active .accordion-content {
            padding: 15px 20px;
            max-height: 1000px;
        }

        @media (max-width: 768px) {
            .services-header {
                padding: 60px 0;
            }

            .service-image {
                height: 180px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Manejar el acordeón de preguntas frecuentes
            const accordionHeaders = document.querySelectorAll('.accordion-header');

            accordionHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    // Cerrar todos los otros elementos
                    accordionHeaders.forEach(item => {
                        if (item !== header) {
                            item.classList.remove('active');
                            item.nextElementSibling.style.maxHeight = '0';
                            item.nextElementSibling.style.padding = '0 20px';
                        }
                    });

                    // Abrir/cerrar el elemento actual
                    this.classList.toggle('active');
                    const content = this.nextElementSibling;

                    if (this.classList.contains('active')) {
                        content.style.maxHeight = content.scrollHeight + 'px';
                        content.style.padding = '15px 20px';
                    } else {
                        content.style.maxHeight = '0';
                        content.style.padding = '0 20px';
                    }
                });
            });

            // Abrir el primer elemento por defecto
            if (accordionHeaders.length > 0) {
                accordionHeaders[0].click();
            }
        });
    </script>
@endpush

<x-frontend-layout>
    <div class="services-header">
        <div class="container">
            <div class="services-header-content text-center">
                <h1 class="page-title">Nuestros Servicios</h1>
                <p class="lead">Soluciones inmobiliarias a medida para todas tus necesidades</p>
            </div>
        </div>
    </div>

    <div class="services-intro">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center">
                    <h2>Experiencia Inmobiliaria a tu Servicio</h2>
                    <p>En [Nombre de tu Empresa], ofrecemos un conjunto completo de servicios inmobiliarios diseñados para hacer que tu experiencia de compra, venta o alquiler sea lo más fluida y exitosa posible. Nuestros expertos están comprometidos con la excelencia y la satisfacción del cliente, brindando asesoramiento personalizado en cada paso del proceso.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="services-grid">
        <div class="container">
            <div class="row">
                <!-- Servicio 1 -->
                <div class="col-md-4">
                    <div class="service-item">
                        <div class="service-image">
                            <img src="{{ asset('assets/front/images/property/property-1-660x600.jpg') }}" alt="Compra de Propiedades">
                            <div class="service-icon">
                                <i class="fa fa-home"></i>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3>Compra de Propiedades</h3>
                            <p>Te ayudamos a encontrar la propiedad perfecta que se ajuste a tus necesidades y presupuesto, guiándote en todo el proceso de compra.</p>
                            <a href="#" class="service-link">Más información <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Servicio 2 -->
                <div class="col-md-4">
                    <div class="service-item">
                        <div class="service-image">
                            <img src="{{ asset('assets/front/images/property/property-2-660x600.jpg') }}" alt="Venta de Propiedades">
                            <div class="service-icon">
                                <i class="fa fa-tag"></i>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3>Venta de Propiedades</h3>
                            <p>Maximizamos el valor de tu propiedad con estrategias de marketing efectivas y una red de compradores potenciales.</p>
                            <a href="#" class="service-link">Más información <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Servicio 3 -->
                <div class="col-md-4">
                    <div class="service-item">
                        <div class="service-image">
                            <img src="{{ asset('assets/front/images/property/property-3-660x600.jpg') }}" alt="Alquiler de Propiedades">
                            <div class="service-icon">
                                <i class="fa fa-key"></i>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3>Alquiler de Propiedades</h3>
                            <p>Gestionamos todo el proceso de alquiler, desde la búsqueda de inquilinos hasta la administración continua de la propiedad.</p>
                            <a href="#" class="service-link">Más información <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Servicio 4 -->
                <div class="col-md-4">
                    <div class="service-item">
                        <div class="service-image">
                            <img src="{{ asset('assets/front/images/property/property-4-660x600.jpg') }}" alt="Asesoría Inmobiliaria">
                            <div class="service-icon">
                                <i class="fa fa-comments"></i>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3>Asesoría Inmobiliaria</h3>
                            <p>Ofrecemos orientación profesional en todos los aspectos del mercado inmobiliario para ayudarte a tomar decisiones informadas.</p>
                            <a href="#" class="service-link">Más información <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Servicio 5 -->
                <div class="col-md-4">
                    <div class="service-item">
                        <div class="service-image">
                            <img src="{{ asset('assets/front/images/property/property-5-660x600.jpg') }}" alt="Inversiones Inmobiliarias">
                            <div class="service-icon">
                                <i class="fa fa-chart-line"></i>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3>Inversiones Inmobiliarias</h3>
                            <p>Identificamos oportunidades de inversión con alto potencial de rentabilidad y te guiamos en el proceso de adquisición.</p>
                            <a href="#" class="service-link">Más información <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Servicio 6 -->
                <div class="col-md-4">
                    <div class="service-item">
                        <div class="service-image">
                            <img src="{{ asset('assets/front/images/property/property-6-660x600.jpg') }}" alt="Desarrollo de Proyectos">
                            <div class="service-icon">
                                <i class="fa fa-building"></i>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3>Desarrollo de Proyectos</h3>
                            <p>Asesoramos en proyectos de desarrollo inmobiliario desde la conceptualización hasta la comercialización del producto final.</p>
                            <a href="#" class="service-link">Más información <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="service-cta">
        <div class="container">
            <h2>¿Necesitas Asesoría Personalizada?</h2>
            <p>Nuestro equipo de expertos está listo para ayudarte a encontrar la solución inmobiliaria perfecta para ti. Contáctanos hoy mismo y descubre cómo podemos hacer realidad tus objetivos inmobiliarios.</p>
            <a href="#" class="cta-button">Contáctanos Ahora</a>
        </div>
    </div>

    <div class="faq-section">
        <div class="container">
            <div class="faq-header">
                <h2>Preguntas Frecuentes</h2>
                <p>Respuestas a las dudas más comunes sobre nuestros servicios</p>
            </div>

            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <!-- Pregunta 1 -->
                    <div class="accordion-item">
                        <div class="accordion-header">
                            ¿Cómo puedo iniciar el proceso de compra de una propiedad?
                            <span class="accordion-icon"><i class="fa fa-chevron-down"></i></span>
                        </div>
                        <div class="accordion-content">
                            <div class="accordion-content-inner">
                                <p>Para iniciar el proceso de compra, te recomendamos contactar a uno de nuestros agentes inmobiliarios, quien evaluará tus necesidades y presupuesto. Luego, te presentaremos una selección de propiedades que se ajusten a tus criterios y te acompañaremos en las visitas. Una vez que encuentres la propiedad adecuada, te asesoraremos en todo el proceso de negociación, financiamiento y trámites legales.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pregunta 2 -->
                    <div class="accordion-item">
                        <div class="accordion-header">
                            ¿Qué documentos necesito para vender mi propiedad?
                            <span class="accordion-icon"><i class="fa fa-chevron-down"></i></span>
                        </div>
                        <div class="accordion-content">
                            <div class="accordion-content-inner">
                                <p>Para vender tu propiedad, generalmente necesitarás los siguientes documentos:</p>
                                <ul>
                                    <li>Título de propiedad o escritura</li>
                                    <li>Certificado de libertad de gravamen</li>
                                    <li>Comprobantes de pago de impuestos prediales</li>
                                    <li>Comprobantes de servicios públicos al corriente</li>
                                    <li>Identificación oficial</li>
                                    <li>En caso de propiedad en condominio, comprobante de no adeudo de cuotas</li>
                                </ul>
                                <p>Nuestros asesores te guiarán para asegurar que tengas toda la documentación necesaria según tu caso específico.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pregunta 3 -->
                    <div class="accordion-item">
                        <div class="accordion-header">
                            ¿Cuál es el proceso para alquilar una propiedad a través de ustedes?
                            <span class="accordion-icon"><i class="fa fa-chevron-down"></i></span>
                        </div>
                        <div class="accordion-content">
                            <div class="accordion-content-inner">
                                <p>El proceso de alquiler incluye los siguientes pasos:</p>
                                <ol>
                                    <li>Identificación de tus necesidades y presupuesto</li>
                                    <li>Selección de propiedades que cumplan con tus requisitos</li>
                                    <li>Coordinación de visitas a las propiedades seleccionadas</li>
                                    <li>Una vez elegida la propiedad, presentación de documentación requerida</li>
                                    <li>Verificación de antecedentes y capacidad de pago</li>
                                    <li>Negociación de términos del contrato</li>
                                    <li>Firma del contrato y entrega de la propiedad</li>
                                </ol>
                                <p>Adicionalmente, ofrecemos servicios de administración de propiedades para propietarios que desean delegar la gestión del alquiler.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pregunta 4 -->
                    <div class="accordion-item">
                        <div class="accordion-header">
                            ¿Ofrecen asesoría para financiamiento hipotecario?
                            <span class="accordion-icon"><i class="fa fa-chevron-down"></i></span>
                        </div>
                        <div class="accordion-content">
                            <div class="accordion-content-inner">
                                <p>Sí, contamos con asesores financieros especializados que te pueden orientar sobre las diferentes opciones de financiamiento disponibles en el mercado. Trabajamos en colaboración con diversas instituciones financieras y podemos ayudarte a encontrar la opción que mejor se adapte a tu situación económica y objetivos. Nuestro servicio incluye pre-calificación, comparación de tasas y condiciones, y acompañamiento en el proceso de solicitud y aprobación del crédito.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pregunta 5 -->
                    <div class="accordion-item">
                        <div class="accordion-header">
                            ¿Cuáles son sus comisiones por los servicios de compra-venta?
                            <span class="accordion-icon"><i class="fa fa-chevron-down"></i></span>
                        </div>
                        <div class="accordion-content">
                            <div class="accordion-content-inner">
                                <p>Nuestras comisiones varían según el tipo de servicio y las características de la propiedad. En general, para servicios de venta, la comisión estándar es un porcentaje del valor de la transacción. Para servicios de compra, ofrecemos diferentes paquetes según el nivel de asesoría requerido. Te invitamos a contactarnos para una consulta personalizada donde podemos proporcionarte información detallada sobre nuestras tarifas y servicios específicos para tu caso.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-layout>
