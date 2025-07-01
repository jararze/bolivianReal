<x-app-layout>

    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">
            {{ __('Configuracion') }}
        </h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.properties.index') }}">
                {{ __('Residencias') }}
            </a>
            <span class="text-gray-400 text-sm">/</span>
            <span class="text-gray-700">Propiedades</span>
        </div>
    </x-slot>


    <div class="container-fixed">
        <div class="grid gap-5 lg:gap-7.5">

            @if($properties->count() == 0)
                <div class="card">
                    <div class="card-body flex flex-col items-center gap-2.5 py-7.5">
                        <div class="flex justify-center p-7.5 py-9">
                            <img alt="image" class="dark:hidden max-h-[230px]"
                                 src="{{ asset('assets/media/illustrations/22.svg') }}"/>
                            <img alt="image" class="light:hidden max-h-[230px]"
                                 src="{{ asset('assets/media/illustrations/22-dark.svg') }}"/>
                        </div>
                        <div class="flex flex-col gap-5 lg:gap-7.5">
                            <div class="flex flex-col gap-3 text-center">
                                <h2 class="text-1.5xl font-semibold text-gray-900">
                                    Crear una nueva propiedad
                                </h2>
                                <p class="text-sm text-gray-800">
                                    Publica una nueva propiedad seleccionando el tipo (casa, departamento, etc.) y
                                    <br/>
                                    especificando si es para alquiler o venta. También puedes subir imágenes para
                                    destacar sus características.
                                </p>
                            </div>
                            <div class="flex justify-center mb-5">
                                <a class="btn btn-primary" href="{{ route('backend.properties.create') }}">
                                    Crear nueva Propiedad
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <div class="card card-grid min-w-full">
                    <div class="card-header flex-wrap py-5">
                        <h3 class="card-title">
                            Propiedades
                        </h3>

                        <div class="flex gap-6 items-center">
                            <div class="relative flex items-center">
                                <i class="ki-filled ki-magnifier text-md text-gray-500 absolute left-3">
                                </i>
                                <input class="input input-sm pl-8"
                                       data-datatable-search="#teams_table"
                                       placeholder="Buscar..."
                                       type="text"/>
                            </div>
                            <div class="relative">
                                <select class="select select-sm w-48" id="propertyTypeFilter">
                                    <option value="">Todos los tipos</option>
                                    @foreach($propertiesTypes as $type)
                                        <option value="{{ $type->type_name }}">{{ $type->type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="switch switch-sm">
                                <input class="order-2" name="check" type="checkbox" value="1" id="onlyActive"/>
                                <span class="switch-label order-1">Solo activos</span>
                            </label>
                            <a class="btn btn-primary" href="{{ route('backend.properties.create') }}">
                                Agregar nueva propiedad
                            </a>
                        </div>

                    </div>
                    <div class="card-body">
                        <div data-datatable="true" data-datatable-page-size="10" id="teams_table">
                            <div class="scrollable-x-auto">
                                <table class="table table-fixed table-border" data-datatable-table="true">
                                    <thead>
                                    <tr>
                                        <th class="w-[60px] text-center">
                                            <input class="checkbox checkbox-sm" data-datatable-check="true"
                                                   type="checkbox"/>
                                        </th>
                                        <th class="w-[170px]">
                                            <span class="sort asc"><span class="sort-label text-gray-700 font-normal">Nombre</span><span
                                                    class="sort-icon"></span></span>
                                        </th>
                                        <th class="w-[120px]">
                                            <span class="sort asc"><span class="sort-label text-gray-700 font-normal">Codigo</span><span
                                                    class="sort-icon"></span></span>
                                        </th>
                                        <th class="w-[200px]">
                                            <span class="sort"><span
                                                    class="sort-label text-gray-700 font-normal">Descripcion</span><span
                                                    class="sort-icon"></span></span></th>
                                        <th class="w-[100px]">
                                            <span class="sort"><span
                                                    class="sort-label text-gray-700 font-normal">Precio</span><span
                                                    class="sort-icon"></span></span>
                                        </th>
                                        <th class="w-[150px]">
                                            <span class="sort"><span class="sort-label text-gray-700 font-normal">Propiedad</span><span
                                                    class="sort-icon"></span></span>
                                        </th>
                                        <th class="w-[100px]">
                                            <span class="sort"><span class="sort-label text-gray-700 font-normal">Tipo</span><span
                                                    class="sort-icon"></span></span>
                                        </th>
                                        <th class="w-[90px]">
                                            <span class="sort asc"><span class="sort-label text-gray-700 font-normal">Estatus</span><span
                                                    class="sort-icon"></span></span>
                                        </th>

                                        <th class="w-[60px]">
                                        </th>
                                        <th class="w-[60px]">
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($properties as $package)
                                        <tr>
                                            <td class="text-center">
                                                <input class="checkbox checkbox-sm" data-datatable-row-check="true"
                                                       type="checkbox" value="{{ $package->id }}"/>
                                            </td>
                                            <td>
                                                <div class="flex flex-col gap-1.5">
                                                    <a class="leading-none font-medium text-sm text-gray-900 hover:text-primary"
                                                       href="{{ route("backend.properties.edit", $package->slug) }}">
                                                        {{ $package->name }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex flex-col gap-1.5">
                                                    <span class="text-sm text-gray-800 font-normal">
                                                        {{ $package->code }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex flex-col gap-1.5">
                                                    <span class="text-sm text-gray-800 font-normal">
                                                        {{ $package->short_description }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-sm text-gray-800 font-normal">
                                                {{ $package->max_price }}
                                            </td>
                                            <td data-property-type="{{ $package->propertyType->type_name }}">
                                                {{ $package->propertyType->type_name }}
                                            </td>
                                            <td class="text-sm text-gray-800 font-normal">
                                                {{ $package->serviceType->name }}
                                            </td>
                                            <td>
                                                @if($package->status == 0)
                                                    <span class="badge badge-outline badge-danger">Inactivo</span>
                                                @else
                                                    <span class="badge badge-outline badge-success">Activo</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a class="btn btn-sm btn-icon btn-clear btn-light"
                                                   href="{{ route('backend.properties.edit', $package->slug) }}">
                                                    <i class="ki-filled ki-notepad-edit">
                                                    </i>
                                                </a>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-icon btn-clear btn-light"
                                                        data-modal-toggle="#deleteModal"
                                                        data-title="{{ $package->name }}" data-id="{{ $package->id }}">
                                                    <i class="ki-filled ki-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div
                                class="card-footer justify-center md:justify-between flex-col md:flex-row gap-5 text-gray-600 text-2sm font-medium">
                                <div class="flex items-center gap-2 order-2 md:order-1">
                                    Mostrar
                                    <select class="select select-sm w-16" data-datatable-size="true" name="perpage">
                                    </select>
                                    por pagina
                                </div>
                                <div class="flex items-center gap-4 order-1 md:order-2">
                                    <span data-datatable-info="true"></span>
                                    <div class="pagination" data-datatable-pagination="true">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Modal -->
            <div id="deleteModal" class="modal" data-modal-backdrop-static="true" data-modal="true">


                <div class="modal-content max-w-[600px] top-[10%]">
                    <div class="modal-header">
                        <h3 class="modal-title">
                            Confirmar Eliminación
                        </h3>
                        <button class="btn btn-xs btn-icon btn-light" data-modal-dismiss="true">
                            <i class="ki-outline ki-cross">
                            </i>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que deseas eliminar este tipo de propiedad <strong
                            id="modal-title-placeholder"></strong> con ID <strong id="modal-id-placeholder"></strong>?
                        Esta acción no se puede deshacer.
                    </div>
                    <div class="modal-footer justify-end">
                        <div class="flex gap-4">
                            <button class="btn btn-light" data-modal-dismiss="true">
                                Cancel
                            </button>
                            <form id="deleteForm" method="POST" action="">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Preguntas Frecuentes (FAQ) - Cómo Dar de Alta Propiedades
                    </h3>
                </div>
                <div class="card-body py-3">
                    <div data-accordion="true" data-accordion-expand-all="true">

                        <!-- Pregunta 1 -->
                        <div class="accordion-item [&:not(:last-child)]:border-b border-b-gray-200"
                             data-accordion-item="true">
                            <button class="accordion-toggle py-4" data-accordion-toggle="#faq_1_content">
                    <span class="text-base font-medium text-gray-900">
                        ¿Cómo puedo dar de alta una nueva propiedad?
                    </span>
                                <i class="ki-filled ki-plus text-gray-600 text-sm accordion-active:hidden block"></i>
                                <i class="ki-filled ki-minus text-gray-600 text-sm accordion-active:block hidden"></i>
                            </button>
                            <div class="accordion-content hidden" id="faq_1_content">
                                <div class="text-gray-700 text-md pb-4">
                                    Para dar de alta una nueva propiedad, accede a tu panel de control y selecciona la
                                    opción "Crear nueva propiedad". Completa los campos requeridos, como tipo de
                                    propiedad, ubicación, precio y sube las imágenes correspondientes.
                                </div>
                            </div>
                        </div>

                        <!-- Pregunta 2 -->
                        <div class="accordion-item [&:not(:last-child)]:border-b border-b-gray-200"
                             data-accordion-item="true">
                            <button class="accordion-toggle py-4" data-accordion-toggle="#faq_2_content">
                    <span class="text-base font-medium text-gray-900">
                        ¿Qué información necesito para dar de alta una propiedad?
                    </span>
                                <i class="ki-filled ki-plus text-gray-600 text-sm accordion-active:hidden block"></i>
                                <i class="ki-filled ki-minus text-gray-600 text-sm accordion-active:block hidden"></i>
                            </button>
                            <div class="accordion-content hidden" id="faq_2_content">
                                <div class="text-gray-700 text-md pb-4">
                                    Necesitarás detalles como: tipo de propiedad (casa, departamento, etc.), ubicación
                                    exacta, descripción, precio, condiciones (alquiler o venta) y al menos una imagen de
                                    la propiedad.
                                </div>
                            </div>
                        </div>

                        <!-- Pregunta 3 -->
                        <div class="accordion-item [&:not(:last-child)]:border-b border-b-gray-200"
                             data-accordion-item="true">
                            <button class="accordion-toggle py-4" data-accordion-toggle="#faq_3_content">
                    <span class="text-base font-medium text-gray-900">
                        ¿Puedo editar una propiedad después de darla de alta?
                    </span>
                                <i class="ki-filled ki-plus text-gray-600 text-sm accordion-active:hidden block"></i>
                                <i class="ki-filled ki-minus text-gray-600 text-sm accordion-active:block hidden"></i>
                            </button>
                            <div class="accordion-content hidden" id="faq_3_content">
                                <div class="text-gray-700 text-md pb-4">
                                    Sí, puedes editar cualquier propiedad que hayas dado de alta. Ve a la sección "Mis
                                    propiedades", selecciona la propiedad que deseas editar y realiza los cambios
                                    necesarios.
                                </div>
                            </div>
                        </div>

                        <!-- Pregunta 4 -->
                        <div class="accordion-item [&:not(:last-child)]:border-b border-b-gray-200"
                             data-accordion-item="true">
                            <button class="accordion-toggle py-4" data-accordion-toggle="#faq_4_content">
                    <span class="text-base font-medium text-gray-900">
                        ¿Cuántas imágenes puedo subir al dar de alta una propiedad?
                    </span>
                                <i class="ki-filled ki-plus text-gray-600 text-sm accordion-active:hidden block"></i>
                                <i class="ki-filled ki-minus text-gray-600 text-sm accordion-active:block hidden"></i>
                            </button>
                            <div class="accordion-content hidden" id="faq_4_content">
                                <div class="text-gray-700 text-md pb-4">
                                    Puedes subir hasta 10 imágenes por propiedad. Te recomendamos incluir fotos de alta
                                    calidad que resalten las características principales, como la fachada, las
                                    habitaciones y los espacios comunes.
                                </div>
                            </div>
                        </div>

                        <!-- Pregunta 5 -->
                        <div class="accordion-item [&:not(:last-child)]:border-b border-b-gray-200"
                             data-accordion-item="true">
                            <button class="accordion-toggle py-4" data-accordion-toggle="#faq_5_content">
                    <span class="text-base font-medium text-gray-900">
                        ¿Qué debo hacer si no puedo dar de alta una propiedad?
                    </span>
                                <i class="ki-filled ki-plus text-gray-600 text-sm accordion-active:hidden block"></i>
                                <i class="ki-filled ki-minus text-gray-600 text-sm accordion-active:block hidden"></i>
                            </button>
                            <div class="accordion-content hidden" id="faq_5_content">
                                <div class="text-gray-700 text-md pb-4">
                                    Si tienes problemas para dar de alta una propiedad, revisa que todos los campos
                                    obligatorios estén completos. Si el problema persiste, contacta a nuestro equipo de
                                    soporte técnico a través del chat de la plataforma o al correo
                                    soporte@tuinmobiliaria.com.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="grid lg:grid-cols-2 gap-5 lg:gap-7.5">
                <!-- Sección Questions -->
                <div class="card">
                    <div class="card-body px-10 py-7.5 lg:pr-12.5">
                        <div class="flex flex-wrap md:flex-nowrap items-center gap-6 md:gap-10">
                            <div class="flex flex-col items-start gap-3">
                                <h2 class="text-1.5xl font-medium text-gray-900">
                                    ¿Preguntas?
                                </h2>
                                <p class="text-sm text-gray-800 leading-5.5 mb-2.5">
                                    Consulta nuestra sección de Preguntas Frecuentes para resolver dudas comunes sobre
                                    nuestros servicios, procesos y características.
                                </p>
                            </div>
                            <img alt="image" class="dark:hidden max-h-[150px]" src="assets/media/illustrations/29.svg"/>
                            <img alt="image" class="light:hidden max-h-[150px]"
                                 src="assets/media/illustrations/29-dark.svg"/>
                        </div>
                    </div>
                    <div class="card-footer justify-center">
                        <a class="btn btn-link" href="/faq">
                            Ir a Preguntas Frecuentes
                        </a>
                    </div>
                </div>

                <!-- Sección Contact Support -->
                <div class="card">
                    <div class="card-body px-10 py-7.5 lg:pr-12.5">
                        <div class="flex flex-wrap md:flex-nowrap items-center gap-6 md:gap-10">
                            <div class="flex flex-col items-start gap-3">
                                <h2 class="text-1.5xl font-medium text-gray-900">
                                    ¿Necesitas Ayuda?
                                </h2>
                                <p class="text-sm text-gray-800 leading-5.5 mb-2.5">
                                    Si tienes alguna pregunta o necesitas asistencia personalizada, no dudes en
                                    contactarnos. Estamos aquí para ayudarte.
                                </p>
                            </div>
                            <img alt="image" class="dark:hidden max-h-[150px]" src="assets/media/illustrations/31.svg"/>
                            <img alt="image" class="light:hidden max-h-[150px]"
                                 src="assets/media/illustrations/31-dark.svg"/>
                        </div>
                    </div>
                    <div class="card-footer justify-center">
                        <a class="btn btn-link" href="/contact">
                            Contáctanos
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {


            document.getElementById('onlyActive').addEventListener('change', function () {
                filterTable();
            });

            document.getElementById('propertyTypeFilter').addEventListener('change', function () {
                filterTable();
            });

            function filterTable() {
                const isActiveChecked = document.getElementById('onlyActive').checked;
                const selectedPropertyType = document.getElementById('propertyTypeFilter').value;
                const rows = document.querySelectorAll('#teams_table tbody tr');

                rows.forEach(row => {
                    let showRow = true;

                    // Filtro por estado activo
                    const statusBadge = row.querySelector('td:nth-child(8) .badge');
                    if (statusBadge && isActiveChecked) {
                        const isActive = statusBadge.classList.contains('badge-success');
                        if (!isActive) showRow = false;
                    }

                    // Filtro por tipo de propiedad
                    if (selectedPropertyType && showRow) {
                        const propertyTypeCell = row.querySelector('td[data-property-type]');
                        const propertyType = propertyTypeCell ? propertyTypeCell.getAttribute('data-property-type') : '';
                        if (propertyType !== selectedPropertyType) showRow = false;
                    }

                    // Mostrar u ocultar la fila
                    row.style.display = showRow ? '' : 'none';
                });

                // Actualizar contador de resultados (opcional)
                updateResultsCounter();
            }

            function updateResultsCounter() {
                const totalRows = document.querySelectorAll('#teams_table tbody tr').length;
                const visibleRows = document.querySelectorAll('#teams_table tbody tr[style=""]').length +
                    document.querySelectorAll('#teams_table tbody tr:not([style])').length -
                    document.querySelectorAll('#teams_table tbody tr[style*="none"]').length;

                // Crear o actualizar elemento contador si no existe
                let counterEl = document.getElementById('results-counter');
                if (!counterEl) {
                    counterEl = document.createElement('div');
                    counterEl.id = 'results-counter';
                    counterEl.className = 'text-sm text-gray-600 px-5 py-2';
                    document.querySelector('#teams_table .card-body').prepend(counterEl);
                }

                counterEl.textContent = `Mostrando ${visibleRows} de ${totalRows} propiedades`;
            }


            const deleteModal = document.querySelector('#deleteModal');
            const titlePlaceholder = document.querySelector('#modal-title-placeholder');
            const idPlaceholder = document.querySelector('#modal-id-placeholder');
            const deleteForm = document.getElementById('deleteForm');

            document.querySelectorAll('[data-modal-toggle="#deleteModal"]').forEach(button => {
                button.addEventListener('click', function () {
                    const title = this.getAttribute('data-title');
                    const id = this.getAttribute('data-id');

                    titlePlaceholder.textContent = title;
                    idPlaceholder.textContent = id;
                    deleteForm.action = `/properties/${id}`;
                });
            });

            updateResultsCounter();
        });
    </script>


</x-app-layout>
