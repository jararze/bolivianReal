@push('styles')
    <style>
        .submit-property-header {
            background: #f5f5f5;
            padding: 30px 0;
            margin-bottom: 30px;
        }

        .submit-property-header h1 {
            margin: 0;
            text-align: center;
            color: #333;
            font-size: 28px;
            font-weight: 600;
        }

        .submit-property-content {
            padding: 0 0 60px;
            background: #f9f9f9;
        }

        .property-form-container {
            background: #fff;
            border-radius: 5px;
            padding: 30px;
            box-shadow: 0 1px 10px rgba(0,0,0,0.05);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #0DBAE8;
            outline: none;
            box-shadow: 0 0 8px rgba(13, 186, 232, 0.1);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .map-container {
            position: relative;
            height: 300px;
            background-color: #f5f5f5;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 4px;
        }

        .find-address-btn {
            background: #0DBAE8;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 5px;
        }

        .find-address-btn:hover {
            background: #0a9ac2;
        }

        .section-heading {
            font-size: 16px;
            font-weight: 600;
            margin: 30px 0 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            color: #333;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .feature-checkbox {
            display: flex;
            align-items: center;
        }

        .feature-checkbox input {
            margin-right: 8px;
        }

        .additional-details {
            margin-top: 30px;
        }

        .detail-row {
            display: flex;
            margin-bottom: 10px;
        }

        .detail-title {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-right: none;
            border-radius: 4px 0 0 4px;
            background: #f9f9f9;
        }

        .detail-value {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 0 4px 4px 0;
        }

        .add-detail-btn, .remove-detail-btn {
            background: #f5f5f5;
            border: 1px solid #ddd;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .add-detail-btn:hover {
            background: #0DBAE8;
            color: #fff;
            border-color: #0DBAE8;
        }

        .remove-detail-btn:hover {
            background: #ff5252;
            color: #fff;
            border-color: #ff5252;
        }

        .image-upload-area {
            border: 2px dashed #ddd;
            padding: 30px;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .image-upload-area:hover {
            border-color: #0DBAE8;
        }

        .image-upload-text {
            color: #777;
            margin-bottom: 15px;
        }

        .image-upload-note {
            font-size: 12px;
            color: #999;
            margin-top: 15px;
        }

        .select-images-btn {
            background: #ff7e00;
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
            display: inline-block;
        }

        .select-images-btn:hover {
            background: #e67200;
        }

        .message-textarea {
            min-height: 120px;
        }

        .submit-property-btn {
            background: #ff7e00;
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 20px;
            font-size: 16px;
        }

        .submit-property-btn:hover {
            background: #e67200;
        }

        @media (max-width: 768px) {
            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Para agregar y quitar filas de detalles adicionales
            const addDetailBtn = document.getElementById('add-detail');
            const detailsContainer = document.getElementById('additional-details-container');
            let detailRowCount = 1;

            addDetailBtn.addEventListener('click', function() {
                const detailRow = document.createElement('div');
                detailRow.className = 'detail-row';
                detailRow.innerHTML = `
                <input type="text" class="detail-title" name="detail_title[]" placeholder="Título">
                <input type="text" class="detail-value" name="detail_value[]" placeholder="Valor">
                <button type="button" class="remove-detail-btn">-</button>
            `;
                detailsContainer.appendChild(detailRow);

                // Agregar evento para eliminar esta fila
                const removeBtn = detailRow.querySelector('.remove-detail-btn');
                removeBtn.addEventListener('click', function() {
                    detailsContainer.removeChild(detailRow);
                });

                detailRowCount++;
            });

            // Para la selección de imágenes
            const imageInput = document.getElementById('property-images');
            const selectImagesBtn = document.getElementById('select-images-btn');
            const imageUploadArea = document.getElementById('image-upload-area');

            selectImagesBtn.addEventListener('click', function(e) {
                e.preventDefault();
                imageInput.click();
            });

            imageUploadArea.addEventListener('click', function(e) {
                if (e.target !== selectImagesBtn) {
                    imageInput.click();
                }
            });

            imageInput.addEventListener('change', function() {
                const fileCount = this.files.length;
                if (fileCount > 0) {
                    document.getElementById('image-count').textContent = fileCount + ' ' + (fileCount === 1 ? 'imagen seleccionada' : 'imágenes seleccionadas');
                } else {
                    document.getElementById('image-count').textContent = 'Ninguna imagen seleccionada';
                }
            });
        });
    </script>
@endpush

<x-frontend-layout>
    <div class="submit-property-header">
        <div class="container">
            <h1>Enviar Propiedad</h1>
        </div>
    </div>

    <div class="submit-property-content">
        <div class="container">
            <div class="property-form-container">
                <form action="{{ route('frontend.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Título de la Propiedad</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Dirección</label>
                                <input type="text" name="address" class="form-control" required>
                                <button type="button" class="find-address-btn">Encontrar Dirección</button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Descripción de la Propiedad</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>

                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15104.971087630703!2d-68.15239015541992!3d-16.50589950000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x915edf0a04f5a40f%3A0x57dbfc76b4458ab3!2sLa%20Paz!5e0!3m2!1ses!2sbo!4v1616005910683!5m2!1ses!2sbo"
                            allowfullscreen=""
                            loading="lazy">
                        </iframe>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Tipo</label>
                                <select name="type" class="form-control" required>
                                    <option value="">Ninguno</option>
                                    <option value="house">Casa</option>
                                    <option value="apartment">Apartamento</option>
                                    <option value="land">Terreno</option>
                                    <option value="commercial">Comercial</option>
                                    <option value="office">Oficina</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Ubicación</label>
                                <select name="location" class="form-control">
                                    <option value="">Ninguno</option>
                                    <option value="central">Zona Central</option>
                                    <option value="north">Zona Norte</option>
                                    <option value="south">Zona Sur</option>
                                    <option value="east">Zona Este</option>
                                    <option value="west">Zona Oeste</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Estado</label>
                                <select name="status" class="form-control">
                                    <option value="">Ninguno</option>
                                    <option value="sale">En Venta</option>
                                    <option value="rent">En Alquiler</option>
                                    <option value="sold">Vendido</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Dormitorios</label>
                                <input type="number" name="bedrooms" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Baños</label>
                                <input type="number" name="bathrooms" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Garajes</label>
                                <input type="number" name="garages" class="form-control" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Precio de Venta</label>
                                <input type="number" name="sale_price" class="form-control" step="0.01" min="0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Precio Posfijo</label>
                                <input type="text" name="price_postfix" class="form-control" placeholder="Ej: /mes, negociable">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Área (m²)</label>
                                <input type="number" name="area" class="form-control" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Área Posfijo</label>
                                <input type="text" name="area_postfix" class="form-control" placeholder="Ej: m², ha">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">ID de la Propiedad</label>
                                <input type="text" name="property_id" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">URL del Tour Virtual</label>
                        <input type="url" name="video_url" class="form-control" placeholder="Ej: https://youtube.com/...">
                    </div>

                    <div class="form-group">
                        <div class="section-heading">Información del Agente</div>

                        <div class="agent-options">
                            <div class="mb-3">
                                <label>
                                    <input type="radio" name="agent_display" value="none" checked>
                                    Ninguno (No se mostrará información)
                                </label>
                            </div>
                            <div class="mb-3">
                                <label>
                                    <input type="radio" name="agent_display" value="profile">
                                    Mi Información de Perfil
                                </label>
                            </div>
                            <div class="mb-3">
                                <label>
                                    <input type="radio" name="agent_display" value="custom">
                                    Mostrar Información de Agente
                                </label>

                                <select name="agent_id" class="form-control mt-2">
                                    <option value="">Seleccionar Agente</option>
                                    <option value="1">Nathan James</option>
                                    <option value="2">Rosa Parks</option>
                                    <option value="3">John Smith</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-check mt-3">
                            <label>
                                <input type="checkbox" name="featured_property">
                                Marcar esta propiedad como destacada
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="section-heading">Características</div>

                        <div class="features-grid">
                            <div class="feature-checkbox">
                                <input type="checkbox" name="features[]" value="2_stories">
                                <label>2 Plantas</label>
                            </div>
                            <div class="feature-checkbox">
                                <input type="checkbox" name="features[]" value="high_ceiling">
                                <label>Techos Altos</label>
                            </div>
                            <div class="feature-checkbox">
                                <input type="checkbox" name="features[]" value="bike_path">
                                <label>Ciclovía</label>
                            </div>
                            <div class="feature-checkbox">
                                <input type="checkbox" name="features[]" value="central_cooling">
                                <label>Aire Central</label>
                            </div>
                            <div class="feature-checkbox">
                                <input type="checkbox" name="features[]" value="central_heating">
                                <label>Calefacción Central</label>
                            </div>
                            <div class="feature-checkbox">
                                <input type="checkbox" name="features[]" value="dual_sinks">
                                <label>Doble Lavamanos</label>
                            </div>
                            <div class="feature-checkbox">
                                <input type="checkbox" name="features[]" value="electric_range">
                                <label>Cocina Eléctrica</label>
                            </div>
                            <div class="feature-checkbox">
                                <input type="checkbox" name="features[]" value="emergency_exit">
                                <label>Salida de Emergencia</label>
                            </div>
                            <div class="feature-checkbox">
                                <input type="checkbox" name="features[]" value="fire_alarm">
                                <label>Alarma de Incendio</label>
                            </div>
                            <div class="feature-checkbox">
                                <input type="checkbox" name="features[]" value="fire_place">
                                <label>Chimenea</label>
                            </div>
                            <div class="feature-checkbox">
                                <input type="checkbox" name="features[]" value="home_theater">
                                <label>Sala de Cine</label>
                            </div>
                            <div class="feature-checkbox">
                                <input type="checkbox" name="features[]" value="hurricane_shutters">
                                <label>Persianas para Huracanes</label>
                            </div>
                            <div class="feature-checkbox">
                                <input type="checkbox" name="features[]" value="jog_path">
                                <label>Sendero para Correr</label>
                            </div>
                            <div class="feature-checkbox">
                                <input type="checkbox" name="features[]" value="laundry_room">
                                <label>Cuarto de Lavandería</label>
                            </div>
                            <div class="feature-checkbox">
                                <input type="checkbox" name="features[]" value="lawn">
                                <label>Césped</label>
                            </div>
                            <div class="feature-checkbox">
                                <input type="checkbox" name="features[]" value="marble_floors">
                                <label>Pisos de Mármol</label>
                            </div>
                            <div class="feature-checkbox">
                                <input type="checkbox" name="features[]" value="next_to_busy_way">
                                <label>Junto a Vía Principal</label>
                            </div>
                            <div class="feature-checkbox">
                                <input type="checkbox" name="features[]" value="swimming_pool">
                                <label>Piscina</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group additional-details">
                        <div class="section-heading">Detalles Adicionales</div>

                        <div id="additional-details-container">
                            <div class="detail-row">
                                <input type="text" class="detail-title" name="detail_title[]" placeholder="Título">
                                <input type="text" class="detail-value" name="detail_value[]" placeholder="Valor">
                                <button type="button" class="add-detail-btn" id="add-detail">+</button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="section-heading">Imágenes de la Propiedad</div>

                        <input type="file" id="property-images" name="images[]" multiple accept="image/*" style="display: none;">

                        <div class="image-upload-area" id="image-upload-area">
                            <div class="image-upload-text">Arrastra y suelta imágenes aquí</div>
                            <button type="button" class="select-images-btn" id="select-images-btn">Seleccionar Imágenes</button>
                            <div class="image-upload-note">
                                * Las imágenes deben tener un ancho mínimo de 800px y una altura mínima de 600px
                                <div id="image-count">Ninguna imagen seleccionada</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="section-heading">Mensaje para el Revisor</div>
                        <textarea name="reviewer_message" class="form-control message-textarea"></textarea>
                    </div>

                    <button type="submit" class="submit-property-btn">Enviar Propiedad</button>
                </form>
            </div>
        </div>
    </div>
</x-frontend-layout>
