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

        .about-us-header {
            background: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80') #494c53 no-repeat center top;
            background-size: cover;
            padding: 60px 0;
            position: relative;
            color: #fff;
            margin-bottom: 0;
        }

        .about-us-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
        }

        .about-us-header-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .about-us-header-content h1 {
            font-weight: 600;
            margin-bottom: 10px;
            font-family: 'Dosis', sans-serif;
        }

        .about-us-header-content p {
            font-size: 18px;
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

        .section-subtitle {
            color: #555;
            font-size: 16px;
            margin-bottom: 30px;
            text-align: center;
        }

        .about-us-section {
            padding: 40px 0;
            background-color: #f7f7f7;
        }

        .about-us-section p {
            margin-bottom: 15px;
            line-height: 1.6;
            color: #555;
        }

        .about-us-image {
            margin-bottom: 20px;
            overflow: hidden;
        }

        .about-us-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .about-us-history-image {
            height: 320px;
        }

        .pillars-section {
            padding: 40px 0;
            background-color: #fff;
        }

        .pillar-box {
            text-align: center;
            height: 100%;
            padding: 0 15px;
        }

        .pillar-box h3 {
            color: #0DBAE8;
            margin-bottom: 15px;
            font-weight: 600;
            text-transform: uppercase;
            font-family: 'Dosis', sans-serif;
        }

        .pillar-box p {
            color: #555;
            line-height: 1.6;
            font-size: 14px;
        }

        .values-section {
            padding: 40px 0;
            background-color: #f7f7f7;
        }

        .value-item {
            text-align: center;
            margin-bottom: 30px;
        }

        .value-icon {
            width: 60px;
            height: 60px;
            line-height: 60px;
            font-size: 24px;
            color: #fff;
            background: #0DBAE8;
            border-radius: 50%;
            margin: 0 auto 15px;
        }

        .value-item h4 {
            color: #333;
            margin: 10px 0;
            font-weight: 600;
            font-family: 'Dosis', sans-serif;
        }

        .value-item p {
            color: #555;
            font-size: 14px;
            line-height: 1.6;
        }

        .stats-section {
            background: url('https://images.unsplash.com/photo-1560520031-3a4dc4e9de0c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80') no-repeat center center;
            background-size: cover;
            padding: 60px 0;
            position: relative;
            color: #fff;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
        }

        .stats-container {
            position: relative;
            z-index: 2;
        }

        .stat-item {
            text-align: center;
            margin-bottom: 20px;
        }

        .stat-number {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 10px;
            font-family: 'Dosis', sans-serif;
            color: #0DBAE8;
        }

        .stat-label {
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .team-section {
            padding: 40px 0;
            background-color: #fff;
        }

        .team-member {
            margin-bottom: 30px;
            text-align: center;
        }

        .team-member-image {
            overflow: hidden;
            height: 220px;
            margin-bottom: 15px;
        }

        .team-member-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .team-member h4 {
            color: #333;
            margin: 10px 0 0;
            font-weight: 600;
            font-family: 'Dosis', sans-serif;
        }

        .team-member-position {
            color: #0DBAE8;
            font-size: 14px;
            margin-bottom: 10px;
            display: block;
        }

        .team-member p {
            color: #555;
            font-size: 14px;
            line-height: 1.5;
        }

        .team-member-social {
            margin-top: 10px;
        }

        .team-member-social a {
            color: #555;
            margin: 0 5px;
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .stat-number {
                font-size: 36px;
            }
            .stat-label {
                font-size: 14px;
            }
        }
    </style>
@endpush

<x-frontend-layout>
    <div class="about-us-header">
        <div class="container">
            <div class="about-us-header-content">
                <h1>¡BIENVENIDOS A BOLIVIAN REAL ESTATE!</h1>
                <p>Tu socio inmobiliario de confianza en La Paz desde 1990</p>
            </div>
        </div>
    </div>

    <div class="about-us-section">
        <div class="section-container">
            <h2 class="section-title">NUESTRA HISTORIA</h2>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>BOLIVIAN REAL ESTATE</strong> es una empresa especializada en el área de bienes raíces, que inició sus actividades en 1990 con la misión de constituirse en una instancia asesora en la compra, venta, alquiler y anticréticos de bienes inmuebles en la ciudad de La Paz.</p>

                    <p>Constituida hace más de 35 años, considerada desde sus inicios como empresa líder en el mercado, BRE ha sabido adaptarse exitosamente ante las diferentes adversidades que se han presentado durante toda su trayectoria.</p>

                    <p>Somos una empresa familiar que ha crecido con La Paz, entendiendo las necesidades cambiantes del mercado inmobiliario y adaptándonos para ofrecer siempre el mejor servicio.</p>

                    <p>Hoy nos encontramos con más fuerza, con nuevas ambiciones y nuevos objetivos, porque sabemos que podemos más, porque sabemos que podemos ser mejores para nosotros y para ti.</p>
                </div>
                <div class="col-md-6">
                    <div class="about-us-image about-us-history-image">
                        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80" alt="Edificio en La Paz">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="about-us-image">
                                <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80" alt="Oficina BRE">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="about-us-image">
                                <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80" alt="Servicio al cliente">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pillars-section">
        <div class="section-container">
            <h2 class="section-title">NUESTROS PILARES</h2>
            <p class="section-subtitle">Los fundamentos que sostienen nuestra empresa y servicio</p>

            <div class="row">
                <div class="col-md-4">
                    <div class="pillar-box">
                        <h3>MISIÓN</h3>
                        <p>Ofrecer soluciones efectivas que prioricen la satisfacción de nuestros clientes, mediante la atención personalizada con excelencia y calidad.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="pillar-box">
                        <h3>VISIÓN</h3>
                        <p>Ser la empresa líder en el mercado inmobiliario de la ciudad de La Paz, generando seguridad, confianza y lealtad de nuestros clientes.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="pillar-box">
                        <h3>COMPROMISO</h3>
                        <p>La calidad y especialización del personal con que cuenta la empresa se constituye en el capital más preciado, que garantiza la excelencia del servicio ofertado.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="values-section">
        <div class="section-container">
            <h2 class="section-title">NUESTROS VALORES</h2>
            <p class="section-subtitle">Los principios que guían nuestro trabajo diario</p>

            <div class="row">
                <div class="col-md-4">
                    <div class="value-item">
                        <div class="value-icon">
                            <i class="fa fa-star"></i>
                        </div>
                        <h4>Excelencia</h4>
                        <p>Se manifiesta en la satisfacción total del cliente. Nuestros servicios están garantizados por el compromiso de nuestra empresa de presentar el mejor resultado posible, manteniendo la mayor ética profesional.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="value-item">
                        <div class="value-icon">
                            <i class="fa fa-handshake"></i>
                        </div>
                        <h4>Ética</h4>
                        <p>Destacamos un comportamiento honesto, respetuoso y verídico sobre cada oferta y servicio proporcionado, generando confianza y transparencia en todas nuestras operaciones.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="value-item">
                        <div class="value-icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <h4>Compromiso</h4>
                        <p>Mostrado a través de nuestra búsqueda constante de ofrecer resultados concretos para atender demandas específicas de cada uno de nuestros clientes con dedicación y perseverancia.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="stats-section">
        <div class="section-container">
            <div class="stats-container">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-item">
                            <div class="stat-number">35+</div>
                            <div class="stat-label">AÑOS DE EXPERIENCIA</div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="stat-item">
                            <div class="stat-number">1500+</div>
                            <div class="stat-label">PROPIEDADES GESTIONADAS</div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="stat-item">
                            <div class="stat-number">3000+</div>
                            <div class="stat-label">CLIENTES SATISFECHOS</div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="stat-item">
                            <div class="stat-number">15+</div>
                            <div class="stat-label">PROFESIONALES ESPECIALIZADOS</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-section">
        <div class="section-container">
            <h2 class="section-title">NUESTRO EQUIPO</h2>
            <p class="section-subtitle">BOLIVIAN REAL ESTATE SRL cuenta con un equipo de profesionales del más alto nivel comprometidos en cumplir el objetivo prioritario de ofrecer las soluciones más efectivas para sus clientes.</p>

            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="team-member">
                        <div class="team-member-image">
                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-1.2.1&auto=format&fit=crop&w=668&q=80" alt="Director General">
                        </div>
                        <h4>Fernando Mendoza</h4>
                        <span class="team-member-position">Director General</span>
                        <p>Fundador de BRE, cuenta con más de 35 años de experiencia en el mercado inmobiliario paceño.</p>
                        <div class="team-member-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-envelope"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="team-member">
                        <div class="team-member-image">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-1.2.1&auto=format&fit=crop&w=668&q=80" alt="Gerente de Operaciones">
                        </div>
                        <h4>Carla Fernández</h4>
                        <span class="team-member-position">Gerente de Operaciones</span>
                        <p>Especialista en gestión de propiedades de lujo y desarrollo de proyectos inmobiliarios.</p>
                        <div class="team-member-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-envelope"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="team-member">
                        <div class="team-member-image">
                            <img src="https://images.unsplash.com/photo-1556157382-97eda2d62296?ixlib=rb-1.2.1&auto=format&fit=crop&w=668&q=80" alt="Asesor Inmobiliario">
                        </div>
                        <h4>Ricardo Torrez</h4>
                        <span class="team-member-position">Asesor Inmobiliario Senior</span>
                        <p>Experto en propiedades comerciales y oficinas en las zonas más exclusivas de La Paz.</p>
                        <div class="team-member-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-envelope"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="team-member">
                        <div class="team-member-image">
                            <img src="https://images.unsplash.com/photo-1580894732444-8ecded7900cd?ixlib=rb-1.2.1&auto=format&fit=crop&w=668&q=80" alt="Asesora Financiera">
                        </div>
                        <h4>Sofía Vargas</h4>
                        <span class="team-member-position">Asesora Financiera</span>
                        <p>Especialista en financiamiento inmobiliario, anticréticos y modelos de inversión en bienes raíces.</p>
                        <div class="team-member-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-layout>
