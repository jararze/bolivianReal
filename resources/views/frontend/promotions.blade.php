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

        .promotions-header {
            background: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80') #494c53 no-repeat center top;
            background-size: cover;
            padding: 60px 0;
            position: relative;
            color: #fff;
            margin-bottom: 0;
        }

        .promotions-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
        }

        .promotions-header-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .promotions-header-content h1 {
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

        .promo-filters {
            background-color: #f5f5f5;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .filter-button {
            background-color: #fff;
            border: 2px solid #0DBAE8;
            color: #0DBAE8;
            padding: 8px 20px;
            border-radius: 50px;
            margin: 0 5px 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .filter-button:hover, .filter-button.active {
            background-color: #0DBAE8;
            color: #fff;
        }

        .promo-counter {
            background: linear-gradient(135deg, #0DBAE8 0%, #0a8dac 100%);
            padding: 50px 0;
            color: #fff;
            position: relative;
        }

        .promo-counter::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1579621970795-87facc2f976d?ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80');
            background-size: cover;
            background-position: center;
            opacity: 0.1;
        }

        .counter-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .counter-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 15px;
            font-family: 'Dosis', sans-serif;
        }

        .counter-description {
            font-size: 16px;
            margin-bottom: 30px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .countdown-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .countdown-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            padding: 15px 10px;
            margin: 0 10px 10px;
            min-width: 100px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .countdown-value {
            font-size: 40px;
            font-weight: 700;
            display: block;
            line-height: 1;
            font-family: 'Dosis', sans-serif;
        }

        .countdown-label {
            font-size: 14px;
            text-transform: uppercase;
            margin-top: 5px;
            display: block;
        }

        .counter-cta {
            display: inline-block;
            background: #fff;
            color: #0DBAE8;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-top: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .counter-cta:hover {
            background: #f2f2f2;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        .promotions-grid {
            padding: 40px 0;
        }

        .promo-card {
            margin-bottom: 30px;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
            background: #fff;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .promo-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        .promo-image {
            position: relative;
            height: 250px;
            overflow: hidden;
        }

        .promo-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .promo-card:hover .promo-image img {
            transform: scale(1.05);
        }

        .promo-tag {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #0DBAE8;
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            padding: 5px 15px;
            border-radius: 50px;
            text-transform: uppercase;
            z-index: 2;
        }

        .promo-badge {
            position: absolute;
            top: 20px;
            left: -30px;
            background: #ff3b30;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            padding: 5px 40px;
            transform: rotate(-45deg);
            text-transform: uppercase;
            z-index: 2;
            box-shadow: 0 3px 10px rgba(255, 59, 48, 0.3);
        }

        .promo-timer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.7);
            color: #fff;
            padding: 10px;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
        }

        .promo-timer i {
            margin-right: 5px;
            color: #ff3b30;
        }

        .promo-content {
            padding: 25px 20px;
            min-height: 220px;
            display: flex;
            flex-direction: column;
        }

        .promo-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
            font-family: 'Dosis', sans-serif;
        }

        .promo-price {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .original-price {
            text-decoration: line-through;
            color: #999;
            font-size: 16px;
            margin-right: 15px;
        }

        .discounted-price {
            color: #ff3b30;
            font-size: 22px;
            font-weight: 700;
        }

        .price-currency {
            font-size: 14px;
            vertical-align: top;
        }

        .discount-badge {
            background: #ff3b30;
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 3px;
            margin-left: 10px;
        }

        .promo-details {
            margin-bottom: 20px;
            color: #555;
            flex-grow: 1;
        }

        .promo-details ul {
            padding-left: 20px;
            margin-top: 10px;
        }

        .promo-details li {
            margin-bottom: 5px;
        }

        .promo-cta {
            display: inline-block;
            background: #0DBAE8;
            color: #fff;
            padding: 10px 25px;
            border-radius: 5px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            text-align: center;
        }

        .promo-cta:hover {
            background: #0a8dac;
        }

        .promo-newsletter {
            background-color: #f8f9fa;
            padding: 60px 0;
            border-top: 1px solid #eee;
            text-align: center;
        }

        .newsletter-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            font-family: 'Dosis', sans-serif;
            color: #333;
        }

        .newsletter-description {
            max-width: 600px;
            margin: 0 auto 30px;
            color: #555;
        }

        .newsletter-form {
            max-width: 500px;
            margin: 0 auto;
            position: relative;
        }

        .newsletter-input {
            width: 100%;
            padding: 15px 20px;
            border: 1px solid #ddd;
            border-radius: 50px;
            background: #fff;
            font-size: 16px;
        }

        .newsletter-submit {
            position: absolute;
            right: 5px;
            top: 5px;
            background: #0DBAE8;
            color: #fff;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .newsletter-submit:hover {
            background: #0a8dac;
        }

        /* Estilos para la etiqueta "Hot Deal" */
        .hot-deal {
            position: relative;
            overflow: hidden;
        }

        .hot-deal-badge {
            position: absolute;
            top: 55px;
            left: 11px;
            width: 200px;
            background: #ff3b30;
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            padding: 10px 0;
            text-align: center;
            transform: rotate(-45deg) translateX(-70px) translateY(-20px);
            transform-origin: top left;
            z-index: 10;
            box-shadow: 0 3px 10px rgba(255, 59, 48, 0.3);
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: rotate(-45deg) translateX(-70px) translateY(-20px) scale(1);
            }
            50% {
                transform: rotate(-45deg) translateX(-70px) translateY(-20px) scale(1.05);
            }
            100% {
                transform: rotate(-45deg) translateX(-70px) translateY(-20px) scale(1);
            }
        }

        /* Estilos para la etiqueta "Exclusivo" */
        .exclusive-badge {
            position: absolute;
            top: 0;
            left: 0;
            width: 200px;
            background: #ff3b30;
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            padding: 10px 0;
            text-align: center;
            transform: rotate(-45deg) translateX(-70px) translateY(-20px);
            transform-origin: top left;
            z-index: 10;
            box-shadow: 0 3px 10px rgba(255, 59, 48, 0.3);
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .promotions-header {
                padding: 60px 0;
            }

            .countdown-value {
                font-size: 30px;
            }

            .countdown-item {
                min-width: 80px;
            }
        }
    </style>
@endpush

@push('scripts')

@endpush

<x-frontend-layout>
    <div class="promotions-header">
        <div class="container">
            <div class="promotions-header-content">
                <h1 class="page-title">Proyectos Bolivian Rean Estate</h1>
                <p class="lead">Descubre oportunidades únicas para invertir en bienes raíces con los mejores precios del mercado</p>
            </div>
        </div>
    </div>

    <div id="promo-grid" class="promotions-grid">
        <div class="section-container">
            <div class="row">
                <!-- Promo 1 - Hot Deal -->
                <div class="col-md-4 col-sm-6">
                    <div class="promo-card" data-category="rent">
                        <div class="promo-image exclusive-property">
                            <img src="{{ asset('storage/project/1.jpg') }}" alt="Casa Plaza España - Oficinas en Alquiler">
                            <div class="promo-tag">ALQUILER</div>
                            <div class="property-type">
                                <i class="fa fa-building"></i>
                                <span>OFICINAS</span>
                            </div>
                        </div>
                        <div class="promo-content">
                            <h3 class="promo-title">Casa Plaza España</h3>
                            <div class="promo-price">
                                <span class="rental-price"><span class="price-currency">$</span>7,000</span>
                                <span class="price-period">/mes</span>
                            </div>
                            <div class="promo-details">
                                <p>Exclusivo espacio para oficinas en la prestigiosa zona de Sopocachi, Plaza España.</p>
                                <ul>
                                    <li>1,164 m² construidos</li>
                                    <li>14 ambientes de oficina</li>
                                    <li>2 salas de reuniones + auditorio</li>
                                    <li>Parqueo para 3 vehículos</li>
                                    <li>Amplio jardín lateral</li>
                                </ul>
                            </div>
                            <a href="{{ route('frontend.project.casa_plaza_espana') }}" class="promo-cta">Ver Detalles</a>
                        </div>
                    </div>
                </div>

                <!-- Promo 2 -->
                <div class="col-md-4 col-sm-6">
                    <div class="promo-card" data-category="rental">
                        <div class="promo-image">
                            <img src="https://images.unsplash.com/photo-1558036117-15d82a90b9b1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80" alt="Casa Familiar con Jardín">
                            <div class="promo-tag">ALQUILER</div>
                            <div class="promo-timer" data-end-date="2025-04-25T23:59:59">
                                <i class="fa fa-clock"></i>
                                <span class="timer-text">36d 1h 14m restantes</span>
                            </div>
                        </div>
                        <div class="promo-content">
                            <h3 class="promo-title">Casa Familiar con Jardín</h3>
                            <div class="promo-price">
                                <span class="original-price">$1,500/mes</span>
                                <span class="discounted-price"><span class="price-currency">$</span>1,200/mes</span>
                                <span class="discount-badge">-20%</span>
                            </div>
                            <div class="promo-details">
                                <p>Amplia casa con jardín ideal para familias. Primer mes con descuento especial.</p>
                                <ul>
                                    <li>4 dormitorios, 3 baños</li>
                                    <li>200m² de superficie</li>
                                    <li>Jardín y área de BBQ</li>
                                </ul>
                            </div>
                            <a href="#" class="promo-cta">Ver Detalles</a>
                        </div>
                    </div>
                </div>

                <!-- Promo 3 -->
                <div class="col-md-4 col-sm-6">
                    <div class="promo-card" data-category="new">
                        <div class="promo-image">
                            <img src="https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80" alt="Loft Moderno en el Centro">
                            <div class="promo-tag">NUEVO</div>
                        </div>
                        <div class="promo-content">
                            <h3 class="promo-title">Loft Moderno en el Centro</h3>
                            <div class="promo-price">
                                <span class="original-price">$180,000</span>
                                <span class="discounted-price"><span class="price-currency">$</span>165,000</span>
                                <span class="discount-badge">-8%</span>
                            </div>
                            <div class="promo-details">
                                <p>Loft de diseño moderno en pleno centro de la ciudad. Acabados de primera calidad.</p>
                                <ul>
                                    <li>1 dormitorio, 1 baño</li>
                                    <li>80m² de superficie</li>
                                    <li>Terraza privada</li>
                                </ul>
                            </div>
                            <a href="#" class="promo-cta">Ver Detalles</a>
                        </div>
                    </div>
                </div>

                <!-- Promo 4 -->
                <div class="col-md-4 col-sm-6">
                    <div class="promo-card" data-category="special">
                        <div class="promo-image hot-deal">
                            <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80" alt="Terreno con Vista al Mar">
                            <div class="hot-deal-badge">EXCLUSIVO</div>
                            <div class="promo-tag">ESPECIAL</div>
                        </div>
                        <div class="promo-content">
                            <h3 class="promo-title">Terreno con Vista al Mar</h3>
                            <div class="promo-price">
                                <span class="original-price">$350,000</span>
                                <span class="discounted-price"><span class="price-currency">$</span>299,000</span>
                                <span class="discount-badge">-15%</span>
                            </div>
                            <div class="promo-details">
                                <p>Amplio terreno con impresionantes vistas al mar. Ideal para construir la casa de tus sueños.</p>
                                <ul>
                                    <li>1,000m² de superficie</li>
                                    <li>Servicios urbanos disponibles</li>
                                    <li>Zona exclusiva y segura</li>
                                </ul>
                            </div>
                            <a href="#" class="promo-cta">Ver Detalles</a>
                        </div>
                    </div>
                </div>

                <!-- Promo 5 -->
                <div class="col-md-4 col-sm-6">
                    <div class="promo-card" data-category="limited">
                        <div class="promo-image">
                            <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80" alt="Oficina Corporativa Premium">
                            <div class="promo-tag">TIEMPO LIMITADO</div>
                            <div class="promo-timer" data-end-date="2025-04-20T23:59:59">
                                <i class="fa fa-clock"></i>
                                <span class="timer-text">31d 1h 14m restantes</span>
                            </div>
                        </div>
                        <div class="promo-content">
                            <h3 class="promo-title">Oficina Corporativa Premium</h3>
                            <div class="promo-price">
                                <span class="original-price">$2,000/mes</span>
                                <span class="discounted-price"><span class="price-currency">$</span>1,600/mes</span>
                                <span class="discount-badge">-20%</span>
                            </div>
                            <div class="promo-details">
                                <p>Moderna oficina corporativa completamente equipada. Primeros 3 meses con descuento especial.</p>
                                <ul>
                                    <li>150m² de superficie</li>
                                    <li>Sala de reuniones y recepción</li>
                                    <li>Ubicación estratégica</li>
                                </ul>
                            </div>
                            <a href="#" class="promo-cta">Ver Detalles</a>
                        </div>
                    </div>
                </div>

                <!-- Promo 6 -->
                <div class="col-md-4 col-sm-6">
                    <div class="promo-card" data-category="sale">
                        <div class="promo-image">
                            <img src="https://images.unsplash.com/photo-1613977257363-707ba9348227?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80" alt="Villa de Lujo con Piscina">
                            <div class="promo-tag">VENTA</div>
                        </div>
                        <div class="promo-content">
                            <h3 class="promo-title">Villa de Lujo con Piscina</h3>
                            <div class="promo-price">
                                <span class="original-price">$500,000</span>
                                <span class="discounted-price"><span class="price-currency">$</span>450,000</span>
                                <span class="discount-badge">-10%</span>
                            </div>
                            <div class="promo-details">
                                <p>Espectacular villa con piscina y jardín en zona residencial exclusiva. Oportunidad única por tiempo limitado.</p>
                                <ul>
                                    <li>5 dormitorios, 4 baños</li>
                                    <li>350m² de superficie</li>
                                    <li>Piscina privada y área de entretenimiento</li>
                                </ul>
                            </div>
                            <a href="#" class="promo-cta">Ver Detalles</a>
                        </div>
                    </div>
                </div>

                <!-- Promo 7 -->
                <div class="col-md-4 col-sm-6">
                    <div class="promo-card" data-category="rental">
                        <div class="promo-image">
                            <img src="https://images.unsplash.com/photo-1600607687644-c7513dba89c6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80" alt="Departamento Amoblado">
                            <div class="promo-tag">ALQUILER</div>
                        </div>
                        <div class="promo-content">
                            <h3 class="promo-title">Departamento Amoblado</h3>
                            <div class="promo-price">
                                <span class="original-price">$900/mes</span>
                                <span class="discounted-price"><span class="price-currency">$</span>750/mes</span>
                                <span class="discount-badge">-17%</span>
                            </div>
                            <div class="promo-details">
                                <p>Moderno departamento completamente amoblado, ideal para parejas o ejecutivos.</p>
                                <ul>
                                    <li>2 dormitorios, 1 baño</li>
                                    <li>90m² de superficie</li>
                                    <li>Ubicación céntrica con excelente vista</li>
                                </ul>
                            </div>
                            <a href="#" class="promo-cta">Ver Detalles</a>
                        </div>
                    </div>
                </div>

                <!-- Promo 8 -->
                <div class="col-md-4 col-sm-6">
                    <div class="promo-card" data-category="special">
                        <div class="promo-image">
                            <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80" alt="Casa de Dos Pisos">
                            <div class="promo-tag">ESPECIAL</div>
                        </div>
                        <div class="promo-content">
                            <h3 class="promo-title">Casa de Dos Pisos en Achumani</h3>
                            <div class="promo-price">
                                <span class="original-price">$320,000</span>
                                <span class="discounted-price"><span class="price-currency">$</span>280,000</span>
                                <span class="discount-badge">-12.5%</span>
                            </div>
                            <div class="promo-details">
                                <p>Hermosa casa en exclusivo barrio residencial con excelente distribución y acabados.</p>
                                <ul>
                                    <li>4 dormitorios, 3 baños</li>
                                    <li>280m² de superficie</li>
                                    <li>Garaje para 2 vehículos y jardín trasero</li>
                                </ul>
                            </div>
                            <a href="#" class="promo-cta">Ver Detalles</a>
                        </div>
                    </div>
                </div>

                <!-- Promo 9 -->
                <div class="col-md-4 col-sm-6">
                    <div class="promo-card" data-category="new">
                        <div class="promo-image hot-deal">
                            <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80" alt="Casa Moderna">
                            <div class="hot-deal-badge">NUEVO</div>
                            <div class="promo-tag">NUEVO</div>
                        </div>
                        <div class="promo-content">
                            <h3 class="promo-title">Casa Moderna en Calacoto</h3>
                            <div class="promo-price">
                                <span class="original-price">$420,000</span>
                                <span class="discounted-price"><span class="price-currency">$</span>395,000</span>
                                <span class="discount-badge">-6%</span>
                            </div>
                            <div class="promo-details">
                                <p>Impresionante casa de diseño contemporáneo con amplios espacios y mucha luz natural.</p>
                                <ul>
                                    <li>4 dormitorios, 3.5 baños</li>
                                    <li>320m² de superficie</li>
                                    <li>Diseño arquitectónico moderno y eficiente</li>
                                </ul>
                            </div>
                            <a href="#" class="promo-cta">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="promo-newsletter">
        <div class="section-container">
            <h3 class="newsletter-title">Recibe Nuestras Promociones Exclusivas</h3>
            <p class="newsletter-description">Suscríbete a nuestro boletín y sé el primero en enterarte de nuestras ofertas especiales y propiedades destacadas.</p>

            <form class="newsletter-form">
                <input type="email" class="newsletter-input" placeholder="Tu correo electrónico">
                <button type="submit" class="newsletter-submit">Suscribirme</button>
            </form>
        </div>
    </div>
</x-frontend-layout>
