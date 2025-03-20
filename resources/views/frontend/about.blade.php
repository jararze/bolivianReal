@push('styles')
    <style>
        .about-us-header {
            background: url('{{ asset('assets/front/images/banner2.jpg') }}') #494c53 no-repeat center top;
            background-size: cover;
            padding: 80px 0;
            position: relative;
            color: #fff;
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
        }

        .about-us-section {
            padding: 60px 0;
        }

        .about-us-section h2 {
            color: #0DBAE8;
            font-weight: 600;
            margin-bottom: 30px;
            font-family: 'Dosis', sans-serif;
            text-transform: uppercase;
        }

        .about-us-section h3 {
            font-family: 'Dosis', sans-serif;
            color: #333;
            margin: 25px 0 15px;
        }

        .about-us-section p {
            margin-bottom: 20px;
            line-height: 1.7;
            color: #555;
        }

        .about-us-image {
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .about-us-image img {
            width: 100%;
            height: auto;
            transition: transform 0.3s ease;
        }

        .about-us-image:hover img {
            transform: scale(1.03);
        }

        .team-section {
            background-color: #f9f9f9;
            padding: 60px 0;
        }

        .team-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .team-header h2 {
            color: #0DBAE8;
            font-weight: 600;
            font-family: 'Dosis', sans-serif;
            text-transform: uppercase;
        }

        .team-header p {
            max-width: 700px;
            margin: 0 auto;
            color: #555;
        }

        .team-member {
            margin-bottom: 30px;
            text-align: center;
            background: #fff;
            border-radius: 5px;
            padding-bottom: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .team-member:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .team-member-image {
            border-radius: 5px 5px 0 0;
            overflow: hidden;
            height: 250px;
            margin-bottom: 20px;
        }

        .team-member-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .team-member h4 {
            color: #333;
            margin: 10px 0 5px;
            font-weight: 600;
        }

        .team-member-position {
            color: #0DBAE8;
            font-size: 14px;
            margin-bottom: 15px;
            display: block;
        }

        .team-member-social {
            margin-top: 15px;
        }

        .team-member-social a {
            color: #555;
            margin: 0 5px;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .team-member-social a:hover {
            color: #0DBAE8;
        }

        .values-section {
            padding: 60px 0;
        }

        .values-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .values-header h2 {
            color: #0DBAE8;
            font-weight: 600;
            font-family: 'Dosis', sans-serif;
            text-transform: uppercase;
        }

        .value-item {
            text-align: center;
            margin-bottom: 40px;
        }

        .value-icon {
            width: 80px;
            height: 80px;
            line-height: 80px;
            font-size: 36px;
            color: #fff;
            background: #0DBAE8;
            border-radius: 50%;
            margin: 0 auto 20px;
        }

        .value-item h4 {
            color: #333;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .value-item p {
            color: #555;
        }

        .stats-section {
            background: url('{{ asset('assets/front/images/demo/hiw-bg.jpg') }}') no-repeat center center;
            background-size: cover;
            padding: 80px 0;
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
            margin-bottom: 30px;
        }

        .stat-number {
            font-size: 50px;
            font-weight: 700;
            margin-bottom: 10px;
            font-family: 'Dosis', sans-serif;
            color: #0DBAE8;
        }

        .stat-label {
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        @media (max-width: 768px) {
            .about-us-header {
                padding: 60px 0;
            }

            .stat-number {
                font-size: 36px;
            }

            .stat-label {
                font-size: 16px;
            }
        }
    </style>
@endpush

<x-frontend-layout>
    <div class="about-us-header">
        <div class="container">
            <div class="about-us-header-content text-center">
                <h1 class="page-title">Quiénes Somos</h1>
                <p class="lead">Tu socio de confianza en el mundo de los bienes raíces</p>
            </div>
        </div>
    </div>

    <div class="about-us-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>Nuestra Historia</h2>
                    <p>Fundada en [año de fundación], [Nombre de tu empresa] ha sido pionera en el mercado inmobiliario de [tu ciudad/región] ofreciendo soluciones innovadoras y personalizadas para cada cliente.</p>

                    <p>A lo largo de los años, hemos construido una reputación basada en la excelencia, la integridad y el profundo conocimiento del mercado local. Nuestro compromiso con la satisfacción del cliente nos ha permitido crecer y convertirnos en líderes del sector.</p>

                    <h3>Nuestra Misión</h3>
                    <p>Facilitar transacciones inmobiliarias exitosas mediante un servicio personalizado y profesional, garantizando una experiencia satisfactoria tanto para compradores como para vendedores.</p>

                    <h3>Nuestra Visión</h3>
                    <p>Ser reconocidos como la empresa de bienes raíces más confiable y eficiente del mercado, innovando constantemente para superar las expectativas de nuestros clientes.</p>
                </div>
                <div class="col-md-6">
                    <div class="about-us-image">
                        <img src="{{ asset('assets/front/images/property/property-12-660x600.jpg') }}" alt="Nuestra Oficina">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="values-section">
        <div class="container">
            <div class="values-header">
                <h2>Nuestros Valores</h2>
                <p>Los principios que guían nuestro trabajo diario</p>
            </div>

            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="value-item">
                        <div class="value-icon">
                            <i class="fa fa-handshake"></i>
                        </div>
                        <h4>Integridad</h4>
                        <p>Mantenemos los más altos estándares éticos en todas nuestras operaciones, garantizando transparencia y honestidad.</p>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="value-item">
                        <div class="value-icon">
                            <i class="fa fa-star"></i>
                        </div>
                        <h4>Excelencia</h4>
                        <p>Nos esforzamos por ofrecer un servicio excepcional, superando expectativas y manteniendo un alto nivel de profesionalismo.</p>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="value-item">
                        <div class="value-icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <h4>Compromiso</h4>
                        <p>Nos dedicamos plenamente a entender y satisfacer las necesidades específicas de cada cliente.</p>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="value-item">
                        <div class="value-icon">
                            <i class="fa fa-lightbulb"></i>
                        </div>
                        <h4>Innovación</h4>
                        <p>Adoptamos nuevas tecnologías y métodos para mejorar constantemente nuestros servicios y procesos.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="stats-section">
        <div class="container">
            <div class="stats-container">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-item">
                            <div class="stat-number">250+</div>
                            <div class="stat-label">Propiedades Vendidas</div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="stat-item">
                            <div class="stat-number">15+</div>
                            <div class="stat-label">Años de Experiencia</div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="stat-item">
                            <div class="stat-number">500+</div>
                            <div class="stat-label">Clientes Satisfechos</div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="stat-item">
                            <div class="stat-number">20+</div>
                            <div class="stat-label">Agentes Profesionales</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-section">
        <div class="container">
            <div class="team-header">
                <h2>Nuestro Equipo</h2>
                <p>Profesionales apasionados y dedicados a hacer realidad tus sueños inmobiliarios</p>
            </div>

            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="team-member">
                        <div class="team-member-image">
                            <img src="{{ asset('assets/front/images/demo/agent-1.jpg') }}" alt="Miembro del Equipo">
                        </div>
                        <h4>Juan Pérez</h4>
                        <span class="team-member-position">Director General</span>
                        <p>Más de 15 años de experiencia en el sector inmobiliario con especialización en propiedades de lujo.</p>
                        <div class="team-member-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="team-member">
                        <div class="team-member-image">
                            <img src="{{ asset('assets/front/images/demo/agent-2.jpg') }}" alt="Miembro del Equipo">
                        </div>
                        <h4>María Gómez</h4>
                        <span class="team-member-position">Jefe de Ventas</span>
                        <p>Especialista en propiedades residenciales y comerciales con amplio conocimiento del mercado local.</p>
                        <div class="team-member-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="team-member">
                        <div class="team-member-image">
                            <img src="{{ asset('assets/front/images/demo/agent-3.jpg') }}" alt="Miembro del Equipo">
                        </div>
                        <h4>Carlos Rodríguez</h4>
                        <span class="team-member-position">Asesor Inmobiliario</span>
                        <p>Dedicado a encontrar la propiedad perfecta para cada cliente, con enfoque en el servicio personalizado.</p>
                        <div class="team-member-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="team-member">
                        <div class="team-member-image">
                            <img src="{{ asset('assets/front/images/demo/agent-4.jpg') }}" alt="Miembro del Equipo">
                        </div>
                        <h4>Ana Martínez</h4>
                        <span class="team-member-position">Asesora Financiera</span>
                        <p>Experta en asesoramiento financiero para inversiones inmobiliarias y financiación de propiedades.</p>
                        <div class="team-member-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-layout>
