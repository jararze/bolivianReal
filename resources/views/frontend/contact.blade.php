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

        .contact-header {
            background: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80') #494c53 no-repeat center top;
            background-size: cover;
            padding: 60px 0;
            position: relative;
            color: #fff;
            margin-bottom: 0;
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
            text-align: center;
        }

        .contact-header-content h1 {
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

        .contact-map-container {
            width: 100%;
            height: 450px;
            position: relative;
            margin-bottom: 0;
        }

        .contact-map-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .contact-content {
            padding: 40px 0;
            background-color: #f7f7f7;
        }

        .contact-info-box {
            background: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            height: 100%;
        }

        .contact-heading {
            font-size: 20px;
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
            font-size: 20px;
            min-width: 30px;
            margin-right: 15px;
        }

        .contact-details-text {
            color: #555;
            line-height: 1.6;
        }

        .contact-details-text strong {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .contact-form-box {
            background: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            height: 100%;
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
            background: #0DBAE8;
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
            background: #0a8dac;
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
            <div class="contact-header-content">
                <h1 class="page-title">CONTÁCTANOS</h1>
                <p class="lead">Estamos aquí para ayudarte con cualquier consulta inmobiliaria</p>
            </div>
        </div>
    </div>

    <div class="contact-map-container">
        <!-- Google Maps de la ubicación en La Paz, Bolivia (Torre Cesur) -->
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3825.2924766664097!2d-68.07835102402495!3d-16.53930933898842!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x915f2072f8545115%3A0xa1ca4468bfa57c06!2sAv.%20Ballivian%201578%2C%20La%20Paz!5e0!3m2!1ses!2sbo!4v1711045391387!5m2!1ses!2sbo"
            allowfullscreen=""
            loading="lazy">
        </iframe>
    </div>

    <div class="contact-content">
        <div class="section-container">
            <div class="row">
                <div class="col-md-5">
                    <div class="contact-info-box">
                        <h3 class="section-title">INFORMACIÓN DE CONTACTO</h3>

                        <div class="contact-details-item">
                            <div class="contact-details-icon">
                                <i class="fa fa-building"></i>
                            </div>
                            <div class="contact-details-text">
                                <strong>Nombre o Razón Social</strong>
                                BOLIVIAN REAL ESTATE SRL
                            </div>
                        </div>

                        <div class="contact-details-item">
                            <div class="contact-details-icon">
                                <i class="fa fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-details-text">
                                <strong>Oficina Central</strong>
                                Calacoto, Av. Ballivián N° 1578 <br>
                                Edif. Torre Cesur piso 5 Of. 508<br>
                                La Paz, Bolivia
                            </div>
                        </div>

                        <div class="contact-details-item">
                            <div class="contact-details-icon">
                                <i class="fa fa-phone-alt"></i>
                            </div>
                            <div class="contact-details-text">
                                <strong>Teléfonos</strong>
                                (591) 2794041 – (591) 2774229
                            </div>
                        </div>

                        <div class="contact-details-item">
                            <div class="contact-details-icon">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div class="contact-details-text">
                                <strong>WhatsApp</strong>
                                (591) 79684093
                            </div>
                        </div>

                        <div class="contact-details-item">
                            <div class="contact-details-icon">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="contact-details-text">
                                <strong>Email</strong>
                                info@bolivianrealestate.com
                            </div>
                        </div>

                        <div class="working-hours">
                            <h3 class="contact-heading">Horario de Atención</h3>

                            <div class="working-hours-item">
                                <div class="working-hours-icon">
                                    <i class="fa fa-clock"></i>
                                </div>
                                <div class="contact-details-text">
                                    Lunes - Viernes: 9:00 am a 6:00 pm
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
                                <a href="https://www.facebook.com/bolivianrealestate" class="social-link"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://www.instagram.com/bolivianrealestate.srl" class="social-link"><i class="fab fa-instagram"></i></a>
                                <a href="https://www.youtube.com/@bolivianrealestate-bienesr7310" class="social-link"><i class="fab fa-youtube"></i></a>
                                <a href="https://www.tiktok.com/@bolivianrealestate" class="social-link"><i class="fab fa-tiktok"></i></a>
                                <!-- <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="contact-form-box">
                        <h3 class="section-title">ENVÍANOS UN MENSAJE</h3>

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

                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="phone" class="form-control" placeholder="Teléfono*" required>
                                </div>
                                <div class="col-md-6">
                                    <select name="inquiry_type" class="form-control" required>
                                        <option value="">Tipo de consulta*</option>
                                        <option value="compra">Compra de propiedad</option>
                                        <option value="venta">Venta de propiedad</option>
                                        <option value="alquiler">Alquiler</option>
                                        <option value="anticresis">Anticrético</option>
                                        <option value="otros">Otra consulta</option>
                                    </select>
                                </div>
                            </div>

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
