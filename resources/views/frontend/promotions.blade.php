@push('styles')
    <style>
        .promotions-header {
            background: url('{{ asset('assets/front/images/banner2.jpg') }}') #494c53 no-repeat center top;
            background-size: cover;
            padding: 80px 0;
            position: relative;
            color: #fff;
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
        }

        .promo-filters {
            background-color: #f5f5f5;
            padding: 30px 0;
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
            background: url('{{ asset('assets/front/images/pattern.png') }}');
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
            padding: 60px 0;
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
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        .promo-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .promo-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .promo-card:hover .promo-image img {
            transform: scale(1.1);
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

        /* Estilos para la animación de "Hot Deal" */
        .hot-deal {
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filtro de promociones
            const filterButtons = document.querySelectorAll('.filter-button');
            const promoCards = document.querySelectorAll('.promo-card');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remover la clase activa de todos los botones
                    filterButtons.forEach(btn => btn.classList.remove('active'));

                    // Añadir la clase activa al botón clickeado
                    this.classList.add('active');

                    const filterValue = this.getAttribute('data-filter');

                    // Mostrar/ocultar tarjetas según el filtro seleccionado
                    promoCards.forEach(card => {
                        if (filterValue === 'all') {
                            card.style.display = 'block';
                        } else {
                            if (card.getAttribute('data-category') === filterValue) {
                                card.style.display = 'block';
                            } else {
                                card.style.display = 'none';
                            }
                        }
                    });
                });
            });

            // Contador de tiempo para ofertas
            function startCountdown() {
                // Fecha objetivo - ajusta esta fecha según tus necesidades
                const targetDate = new Date();
                targetDate.setDate(targetDate.getDate() + 5); // 5 días a partir de hoy

                // Actualizar el contador cada segundo
                const countdownInterval = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = targetDate - now;

                    // Calcular días, horas, minutos y segundos
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Actualizar elementos HTML
                    document.getElementById('countdown-days').textContent = days;
                    document.getElementById('countdown-hours').textContent = hours;
                    document.getElementById('countdown-minutes').textContent = minutes;
                    document.getElementById('countdown-seconds').textContent = seconds;

                    // Si el contador llega a cero
                    if (distance < 0) {
                        clearInterval(countdownInterval);
                        document.getElementById('countdown-container').innerHTML = "<p class='expired-text'>¡La promoción ha terminado!</p>";
                    }
                }, 1000);
            }

            // Iniciar contador
            startCountdown();

            // Inicializar contadores individuales para cada tarjeta
            document.querySelectorAll('.promo-timer').forEach(timer => {
                const endDate = timer.getAttribute('data-end-date');
                const timerElement = timer.querySelector('.timer-text');

                if (endDate && timerElement) {
                    const targetDate = new Date(endDate).getTime();

                    const timerInterval = setInterval(function() {
                        const now = new Date().getTime();
                        const distance = targetDate - now;

                        if (distance < 0) {
                            clearInterval(timerInterval);
                            timerElement.innerHTML = "¡Promoción finalizada!";
                            return;
                        }

                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

                        timerElement.innerHTML = `${days}d ${hours}h ${minutes}m restantes`;
                    }, 60000); // Actualizar cada minuto para no sobrecargar
                }
            });
        });
    </script>
@endpush

<x-frontend-layout>
    <div class="promotions-header">
        <div class="container">
            <div class="promotions-header-content text-center">
                <h1 class="page-title">Ofertas y Promociones</h1>
                <p class="lead">Descubre oportunidades únicas para invertir en bienes raíces con los mejores precios del mercado</p>
            </div>
        </div>
    </div>

    <div class="promo-filters">
        <div class="container">
            <div class="text-center">
                <button class="filter-button active" data-filter="all">Todas</button>
                <button class="filter-button" data-filter="sale">En Venta</button>
                <button class="filter-button" data-filter="rental">Alquiler</button>
                <button class="filter-button" data-filter="new">Nuevas</button>
                <button class="filter-button" data-filter="special">Especiales</button>
                <button class="filter-button" data-filter="limited">Tiempo Limitado</button>
            </div>
        </div>
    </div>

    <div class="promo-counter">
        <div class="container">
            <div class="counter-content">
                <h2 class="counter-title">Ofertas por Tiempo Limitado</h2>
                <p class="counter-description">No pierdas la oportunidad de aprovechar nuestras promociones especiales. Estas ofertas exclusivas terminan en:</p>

                <div id="countdown-container" class="countdown-container">
                    <div class="countdown-item">
                        <span id="countdown-days" class="countdown-value">5</span>
                        <span class="countdown-label">Días</span>
                    </div>
                    <div class="countdown-item">
                        <span id="countdown-hours" class="countdown-value">12</span>
                        <span class="countdown-label">Horas</span>
                    </div>
                    <div class="countdown-item">
                        <span id="countdown-minutes" class="countdown-value">45</span>
                        <span class="countdown-label">Minutos</span>
                    </div>
                    <div class="countdown-item">
                        <span id="countdown-seconds" class="countdown-value">30</span>
                        <span class="countdown-label">Segundos</span>
                    </div>
                </div>

                <a href="#promo-grid" class="counter-cta">Ver Ofertas Ahora</a>
            </div>
        </div>
    </div>

    <div id="promo-grid" class="promotions-grid">
        <div class="container">
            <div class="row">
                <!-- Promo 1 - Hot Deal -->
                <div class="col-md-4 col-sm-6">
                    <div class="promo-card hot-deal" data-category="sale">
                        <div class="promo-image">
                            <img src="{{ asset('assets/front/images/property/property-1-660x600.jpg') }}" alt="Promoción Apartamento">
                            <div class="promo-badge">HOT DEAL</div>
                            <div class="promo-tag">Venta</div>
                            <div class="promo-timer" data-end-date="2025-04-30T23:59:59">
                                <i class="fa fa-clock"></i>
                                <span class="timer-text">3d 12h 45m restantes</span>
                            </div>
                        </div>
                        <div class="promo-content">
                            <h3 class="promo-title">Apartamento de Lujo en Zona Exclusiva</h3>
                            <div class="promo-price">
                                <span class="original-price">$250,000</span>
                                <span class="discounted-price"><span class="price-currency">$</span>199,000</span>
                                <span class="discount-badge">-20%</span>
                            </div>
                            <div class="promo-details">
                                <p>Apartamento completamente amueblado con vistas panorámicas a la ciudad. Oportunidad única por tiempo limitado.</p>
                                <ul>
                                    <li>3 dormitorios, 2 baños</li>
                                    <li>120m² de superficie</li>
                                    <li>Estacionamiento privado</li>
                                </ul>
                            </div>
                            <a href="#" class="promo-cta">Ver Detalles</a>
                        </div>
                    </div>
                </div>

                <!-- Promo 2 -->
                <div class="col-md-4 col-sm-6">
                    <div class="promo-card" data-category="rental">
                        <div class="promo-image">
                            <img src="{{ asset('assets/front/images/property/property-2-660x600.jpg') }}" alt="Promoción Casa">
                            <div class="promo-tag">Alquiler</div>
                            <div class="promo-timer" data-end-date="2025-04-25T23:59:59">
                                <i class="fa fa-clock"></i>
                                <span class="timer-text">2d 18h 30m restantes</span>
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
                            <img src="{{ asset('assets/front/images/property/property-3-660x600.jpg') }}" alt="Promoción Loft">
                            <div class="promo-tag">Nuevo</div>
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
                        <div class="promo-image">
                            <img src="{{ asset('assets/front/images/property/property-4-660x600.jpg') }}" alt="Promoción Terreno">
                            <div class="promo-badge">EXCLUSIVO</div>
                            <div class="promo-tag">Especial</div>
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
                            <img src="{{ asset('assets/front/images/property/property-5-660x600.jpg') }}" alt="Promoción Oficina">
                            <div class="promo-tag">Tiempo Limitado</div>
                            <div class="promo-timer" data-end-date="2025-04-20T23:59:59">
                                <i class="fa fa-clock"></i>
                                <span class="timer-text">1d 8h 15m restantes</span>
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
                            <img src="{{ asset('assets/front/images/property/property-6-660x600.jpg') }}" alt="Promoción Villa">
                            <div class="promo-tag">Venta</div>
                        </div>
                        <div class="promo-content">
                            <h3 class="promo-title">Villa de Lujo con Piscina</h3>
                            <div class="promo-price">
                                <span class="original-price">$500,000</span>
                                <span class="discounted-price"><span class="price-currency">$</span>450,000</span>
                                <span class="discount-badge">-10%</span>
                            </div>
                            <div class="promo-details">
                                <p>Espectacular villa con piscina y jardín en zona residencial exclusiva.</p>
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
            </div>
        </div>
    </div>

    <div class="promo-newsletter">
        <div class="container">
            <h3 class="newsletter-title">Recibe Nuestras Promociones Exclusivas</h3>
            <p class="newsletter-description">Suscríbete a nuestro boletín y sé el primero en enterarte de nuestras ofertas especiales y propiedades destacadas.</p>

            <form class="newsletter-form">
                <input type="email" class="newsletter-input" placeholder="Tu correo electrónico">
                <button type="submit" class="newsletter-submit">Suscribirme</button>
            </form>
        </div>
    </div>
</x-frontend-layout>
