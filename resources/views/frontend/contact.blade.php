@push('styles')
    <style>
        .contact-header {
            background: url('{{ asset('assets/front/images/banner2.jpg') }}') #494c53 no-repeat center top;
            background-size: cover;
            padding: 60px 0;
            position: relative;
            color: #fff;
        }

        .contact-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
        }

        .contact-header-content {
            position: relative;
            z-index: 2;
        }

        .contact-map-container {
            width: 100%;
            height: 450px;
            position: relative;
        }

        .contact-map-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .contact-content {
            padding: 60px 0;
            background: #fff;
        }

        .contact-info-box {
            background: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }

        .contact-heading {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 25px;
            color: #333;
            font-family: 'Dosis', sans-serif;
        }

        .contact-details-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .contact-details-icon {
            color: #0DBAE8;
            font-size: 22px;
            min-width: 30px;
            margin-right: 15px;
        }

        .contact-details-text {
            color: #555;
        }

        .contact-details-text strong {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .contact-form-box {
            background: #4a5262;
            padding: 30px;
            border-radius: 5px;
            color: #fff;
        }

        .contact-form .form-control {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 12px 15px;
            margin-bottom: 20px;
            width: 100%;
        }

        .contact-form textarea.form-control {
            height: 140px;
            resize: vertical;
        }

        .contact-form .form-control:focus {
            border-color: #0DBAE8;
            box-shadow: 0 0 8px rgba(13, 186, 232, 0.1);
        }

        .contact-form .btn-submit {
            background: #ff7e00;
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            font-weight: 600;
            text-transform: uppercase;
            float: right;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .contact-form .btn-submit:hover {
            background: #e67200;
        }

        .working-hours {
            margin-top: 30px;
        }

        .working-hours-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .working-hours-icon {
            color: #0DBAE8;
            font-size: 18px;
            min-width: 30px;
            margin-right: 15px;
        }

        .contact-social {
            margin-top: 30px;
        }

        .social-links {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: #f5f5f5;
            color: #333;
            border-radius: 50%;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: #0DBAE8;
            color: #fff;
        }

        @media (max-width: 768px) {
            .contact-map-container {
                height: 350px;
            }

            .contact-content {
                padding: 40px 0;
            }

            .contact-form-box {
                margin-top: 30px;
            }
        }
    </style>
@endpush

<x-frontend-layout>
    <div class="contact-header">
        <div class="container">
            <div class="contact-header-content text-center">
                <h1 class="page-title">Contáctanos</h1>
                <p class="lead">Estamos aquí para ayudarte con cualquier consulta inmobiliaria</p>
            </div>
        </div>
    </div>

    <div class="contact-map-container">
        <!-- Reemplaza con tu clave de API de Google Maps y la ubicación correcta -->
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3591.979219447789!2d-80.19362048456688!3d25.781950383634235!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88d9b6823bb2dd99%3A0x3a8e29d1c1cb79e!2s900%20Biscayne%20Blvd%2C%20Miami%2C%20FL%2033132%2C%20EE.%20UU.!5e0!3m2!1ses!2ses!4v1616005910683!5m2!1ses!2ses"
            allowfullscreen=""
            loading="lazy">
        </iframe>
    </div>

    <div class="contact-content">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="contact-info-box">
                        <h3 class="contact-heading">Dirección</h3>

                        <div class="contact-details-item">
                            <div class="contact-details-icon">
                                <i class="fa fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-details-text">
                                <strong>Oficina Principal</strong>
                                Calle Principal #123, Zona Centro<br>
                                Santa Cruz, Bolivia
                            </div>
                        </div>

                        <h3 class="contact-heading">Detalles de Contacto</h3>

                        <div class="contact-details-item">
                            <div class="contact-details-icon">
                                <i class="fa fa-phone-alt"></i>
                            </div>
                            <div class="contact-details-text">
                                <strong>Teléfono</strong>
                                +591 3 333-4444
                            </div>
                        </div>

                        <div class="contact-details-item">
                            <div class="contact-details-icon">
                                <i class="fa fa-mobile-alt"></i>
                            </div>
                            <div class="contact-details-text">
                                <strong>Celular</strong>
                                +591 7 777-8888
                            </div>
                        </div>

                        <div class="contact-details-item">
                            <div class="contact-details-icon">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="contact-details-text">
                                <strong>Email</strong>
                                info@tuempresa.com
                            </div>
                        </div>

                        <div class="working-hours">
                            <h3 class="contact-heading">Horario de Atención</h3>

                            <div class="working-hours-item">
                                <div class="working-hours-icon">
                                    <i class="fa fa-clock"></i>
                                </div>
                                <div class="contact-details-text">
                                    Lunes - Viernes: 8:30 am a 6:00 pm
                                </div>
                            </div>

                            <div class="working-hours-item">
                                <div class="working-hours-icon">
                                    <i class="fa fa-clock"></i>
                                </div>
                                <div class="contact-details-text">
                                    Sábados: 9:00 am a 1:00 pm
                                </div>
                            </div>
                        </div>

                        <div class="contact-social">
                            <h3 class="contact-heading">Síguenos</h3>
                            <div class="social-links">
                                <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="contact-form-box">
                        <h3 class="contact-heading">Envíanos un Mensaje</h3>

                        <form class="contact-form" action="#" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Nombre*" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control" placeholder="Email*" required>
                                </div>
                            </div>

                            <input type="text" name="phone" class="form-control" placeholder="Teléfono">
                            <input type="text" name="subject" class="form-control" placeholder="Asunto">

                            <textarea name="message" class="form-control" placeholder="Mensaje*" required></textarea>

                            <button type="submit" class="btn-submit">Enviar Mensaje</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-layout>
