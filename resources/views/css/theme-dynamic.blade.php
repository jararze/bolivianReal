{{-- resources/views/css/theme-dynamic.blade.php --}}
/* Debug */
/* {{ print_r($settings, true) }} */

:root {
--primary-color: {{ $settings['primary_color'] ?? '#48a640' }};
--secondary-color: {{ $settings['secondary_color'] ?? '#0dbae8' }};
--support-color: {{ $settings['support_color'] ?? '#f4903f' }};
}

/* Resto de tus estilos usando las variables... */
/* Links y elementos comunes */
a:hover {
color: var(--secondary-color) !important;
}

.button-menu-reveal {
background-color: var(--primary-color) !important;
color: #ffffff !important;
}

/* Si quieres también el hover */
.button-menu-reveal:hover {
background-color: var(--primary-color) !important;
opacity: 0.9;
color: #ffffff !important;
}

.hidden-fields-reveal-btn {
background-color: var(--support-color) !important;
}

.hidden-fields-reveal-btn:hover {
background-color: var(--secondary-color) !important;
}

/* Si el ícono dentro del botón también necesita cambiar */
.hidden-fields-reveal-btn .icon {
fill: #ffffff !important;
}

.header-variation-one .sub-menu {
background-color: var(--primary-color) !important;
opacity: 0.9;
}

.header-variation-one .sub-menu a {
color: #ffffff !important;
}

.header-variation-one .sub-menu a:after {
background-color: var(--primary-color) !important;
opacity: 0.8;
}

.meta-icon {
fill: var(--secondary-color) !important;
}

/* Botones y elementos de formulario */
.btn-default:hover,
.button:hover,
.submit-property-link:hover {
background-color: var(--secondary-color) !important;
color: #ffffff !important;
}

/* Header y navegación */
.header-variation-one .contact-number {
background-color: var(--secondary-color) !important;
}

.header-variation-one .site-main-nav {
background-color: var(--primary-color) !important;
}

.header-variation-one .main-menu > li:hover > a,
.header-variation-one .main-menu > .current-menu-item > a {
background-color: var(--primary-color) !important;
opacity: 0.9;
}

/* Etiquetas y estados */
.property-status-tag:hover {
background-color: var(--support-color) !important;
}

.property-status-tag:hover:before {
border-right-color: var(--support-color) !important;
}

/* Precios y elementos destacados */
.price,
.single-property-price,
.property-listing-three-post .price,
.featured-properties-one .price,
.featured-properties-two .price,
.featured-properties-three .featured-property-post .price {
{{--color: var(--secondary-color) !important;--}}
}

/* Elementos de búsqueda */
.advance-search .form-submit-btn {
background-color: var(--primary-color) !important;
}

.advance-search .form-submit-btn:hover {
background-color: var(--primary-color) !important;
opacity: 0.9;
}

/* Elementos de propiedad */
.property-listing-three-post .property-status {
background-color: var(--primary-color) !important;
}

.property-listing-three-post .meta-value {
color: var(--primary-color) !important;
}

/* Formularios y botones */
.widget_lc_taxonomy input[type="submit"],
.post-password-form input[type="submit"],
.wpcf7-submit {
background-color: var(--primary-color) !important;
border-color: var(--primary-color) !important;
}

.widget_lc_taxonomy input[type="submit"]:hover,
.post-password-form input[type="submit"]:hover,
.wpcf7-submit:hover {
opacity: 0.9;
}

/* Elementos del slider */
.slide-overlay .meta-icon {
fill: var(--support-color) !important;
}

.slider-variation-three .property-status-tag {
background-color: var(--primary-color) !important;
}

.slider-variation-three .property-status-tag:before {
border-right-color: var(--primary-color) !important;
}

/* Elementos del footer */
.site-footer a:hover {
color: var(--secondary-color) !important;
}

/* Elementos de blog y noticias */
.blog-post .entry-title a:hover,
.home-recent-posts .post-meta a {
color: var(--secondary-color) !important;
}

/* Elementos de paginación */
.pagination .page-numbers:hover,
.pagination .current {
background-color: var(--secondary-color) !important;
}

/* Elementos de modal y formularios */
.login-form-submit {
background-color: var(--support-color) !important;
}

.login-form-submit:hover {
background-color: var(--support-color) !important;
opacity: 0.9;
}

/* Elementos de widgets */
.widget .tagcloud a {
background-color: var(--secondary-color) !important;
}

.widget .tagcloud a:hover {
opacity: 0.9;
}

/* Elementos de características de propiedad */
.property-features-list a:hover:after {
background-color: var(--secondary-color) !important;
}

/* Elementos de agente */
.agent-common-styles .agent-contacts-list .contacts-icon {
fill: var(--secondary-color) !important;
}

/* Elementos de títulos */
.fancy-title {
color: var(--secondary-color) !important;
}

/* Elementos de búsqueda avanzada */
.advance-search-widget-title {
background-color: var(--secondary-color) !important;
}

/* Elementos de comentarios */
#comments a {
color: var(--secondary-color) !important;
}

/* Elementos de navegación del carrusel */
.recent-posts-carousel-nav .arrow-container:hover .left-arrow,
.recent-posts-carousel-nav .arrow-container:hover .right-arrow {
fill: var(--secondary-color) !important;
}

/* Elementos de testimonios */
.qe-testimonial-wrapper .qe-testimonial-img img.avatar {
border-color: var(--secondary-color) !important;
}

.qe-testimonial-wrapper .qe-testimonial-img img.avatar:hover {
border-color: var(--support-color) !important;
}

/* Elementos de galerías */
.search-plus:hover,
.external-link:hover {
background-color: var(--support-color) !important;
}
