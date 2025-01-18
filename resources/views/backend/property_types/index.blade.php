<x-app-layout>

    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">
            {{ __('Configuracion') }}
        </h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.property-types.index') }}">
                {{ __('Tipos de propiedades') }}
            </a>
            <span class="text-gray-400 text-sm">
            /
           </span>
            <span class="text-gray-700">
            Listado
           </span>
        </div>
    </x-slot>


    <div class="container-fixed">
        <div class="grid gap-5 lg:gap-7.5">

            @if($propertyTypes->count() == 0)
                <div class="card">
                    <div class="card-body flex flex-col items-center gap-2.5 py-7.5">
                        <div class="flex justify-center p-7.5 py-9">
                            <img alt="image" class="dark:hidden max-h-[230px]" src="assets/media/illustrations/32.svg"/>
                            <img alt="image" class="light:hidden max-h-[230px]"
                                 src="assets/media/illustrations/32-dark.svg"/>
                        </div>
                        <div class="flex flex-col gap-5 lg:gap-7.5">
                            <div class="flex flex-col gap-3 text-center">
                                <h2 class="text-1.5xl font-semibold text-gray-900">
                                    Crear un Nuevo Tipo de Propiedad
                                </h2>
                                <p class="text-sm text-gray-800">
                                    Agrega fácilmente un nuevo tipo de propiedad como edificio, departamento, casa,
                                    <br/>
                                    u otra categoría personalizada para tu catálogo inmobiliario.
                                </p>
                            </div>
                            <div class="flex justify-center mb-5">
                                <a class="btn btn-primary" href="{{ route('backend.property-types.create') }}">
                                    Crear nuevo tipo de propiedad
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card card-grid min-w-full">
                    <div class="card-header flex-wrap py-5">
                        <h3 class="card-title">
                            Propiedades por tipos
                        </h3>

                        <div class="flex gap-6 items-center">
                            <div class="relative flex items-center">
                                <i class="ki-filled ki-magnifier text-md text-gray-500 absolute left-3">
                                </i>
                                <input class="input input-sm pl-8"
                                       data-datatable-search="#teams_table"
                                       placeholder="Buscar tipo de propiedad"
                                       type="text"/>
                            </div>
                            <label class="switch switch-sm">
                                <input class="order-2" name="check" type="checkbox" value="1" id="onlyActive"/>
                                <span class="switch-label order-1">Solo activos</span>
                            </label>
                            <a class="btn btn-primary" href="{{ route('backend.property-types.create') }}">
                                Agregar nuevo tipo de propiedad
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
                                        <th class="w-[250px]">
                                            <span class="sort asc"><span class="sort-label text-gray-700 font-normal">Nombre</span><span
                                                    class="sort-icon"></span></span>
                                        </th>
                                        <th class="w-[150px]">
                                            <span class="sort"><span
                                                    class="sort-label text-gray-700 font-normal">Icono</span><span
                                                    class="sort-icon"></span></span></th>
                                        <th class="w-[200px]">
                                            <span class="sort"><span class="sort-label text-gray-700 font-normal">Descripcion</span><span
                                                    class="sort-icon"></span></span>
                                        </th>
                                        <th class="w-[150px]">
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
                                    @foreach($propertyTypes as $type)
                                        <tr>
                                            <td class="text-center">
                                                <input class="checkbox checkbox-sm" data-datatable-row-check="true"
                                                       type="checkbox" value="{{ $type->id }}"/>
                                            </td>
                                            <td>
                                                <div class="flex flex-col gap-1.5">
                                                    <a class="leading-none font-medium text-sm text-gray-900 hover:text-primary"
                                                       href="{{ route("backend.property-types.edit", $type->id) }}">
                                                        {{ $type->type_name }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex flex-col gap-1.5">
                                                    <span class="text-sm text-gray-800 font-normal">
                                                        <i class="{{ $type->type_icon }}"></i>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-sm text-gray-800 font-normal">
                                                {{ $type->description }}
                                            </td>
                                            <td>
                                                @if($type->status == 0)
                                                    <span class="badge badge-outline badge-danger">Inactivo</span>
                                                @else
                                                    <span class="badge badge-outline badge-success">Activo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-icon btn-clear btn-light"
                                                   href="{{ route('backend.property-types.edit', $type->id) }}">
                                                    <i class="ki-filled ki-notepad-edit">
                                                    </i>
                                                </a>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-icon btn-clear btn-light"
                                                        data-modal-toggle="#deleteModal"
                                                        data-title="{{ $type->type_name }}" data-id="{{ $type->id }}">
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
                        Preguntas Frecuentes (FAQ)
                    </h3>
                </div>
                <div class="card-body py-3">
                    <div data-accordion="true" data-accordion-expand-all="true">
                        <div class="accordion-item [&:not(:last-child)]:border-b border-b-gray-200"
                             data-accordion-item="true">
                            <button class="accordion-toggle py-4" data-accordion-toggle="#faq_1_content">
                    <span class="text-base text-gray-900">
                        ¿Cómo creo un nuevo tipo de propiedad?
                    </span>
                                <i class="ki-filled ki-plus text-gray-600 text-sm accordion-active:hidden block"></i>
                                <i class="ki-filled ki-minus text-gray-600 text-sm accordion-active:block hidden"></i>
                            </button>
                            <div class="accordion-content hidden" id="faq_1_content">
                                <div class="text-gray-700 text-md pb-4">
                                    Para crear un nuevo tipo de propiedad, ve al menú "Tipos de Propiedad" y haz clic en
                                    "Agregar Nuevo". Llena el formulario con el nombre, ícono, estado y descripción del
                                    tipo de propiedad, luego guarda los cambios.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item [&:not(:last-child)]:border-b border-b-gray-200"
                             data-accordion-item="true">
                            <button class="accordion-toggle py-4" data-accordion-toggle="#faq_2_content">
                    <span class="text-base text-gray-900">
                        ¿Dónde puedo encontrar íconos para asignar al tipo de propiedad?
                    </span>
                                <i class="ki-filled ki-plus text-gray-600 text-sm accordion-active:hidden block"></i>
                                <i class="ki-filled ki-minus text-gray-600 text-sm accordion-active:block hidden"></i>
                            </button>
                            <div class="accordion-content hidden" id="faq_2_content">
                                <div class="text-gray-700 text-md pb-4">
                                    Puedes buscar íconos en las siguientes páginas:
                                    <ul class="list-disc list-inside">
                                        <li><a href="https://fontawesome.com/search?q=house&o=r" target="_blank"
                                               class="text-blue-500 hover:underline">FontAwesome</a></li>
                                        <li><a href="https://icons.getbootstrap.com/" target="_blank"
                                               class="text-blue-500 hover:underline">Bootstrap Icons</a></li>
                                    </ul>
                                    Una vez encuentres el ícono deseado, copia el contenido de la etiqueta <code>&lt;i&gt;</code>
                                    y pégalo en el campo de ícono al crear o editar un tipo de propiedad.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item [&:not(:last-child)]:border-b border-b-gray-200"
                             data-accordion-item="true">
                            <button class="accordion-toggle py-4" data-accordion-toggle="#faq_3_content">
                    <span class="text-base text-gray-900">
                        ¿Qué información es obligatoria al crear un tipo de propiedad?
                    </span>
                                <i class="ki-filled ki-plus text-gray-600 text-sm accordion-active:hidden block"></i>
                                <i class="ki-filled ki-minus text-gray-600 text-sm accordion-active:block hidden"></i>
                            </button>
                            <div class="accordion-content hidden" id="faq_3_content">
                                <div class="text-gray-700 text-md pb-4">
                                    El campo "Nombre" es obligatorio y debe ser único. Los demás campos, como "Ícono",
                                    "Estado" y "Descripción", son opcionales pero recomendados para una mejor
                                    organización.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item [&:not(:last-child)]:border-b border-b-gray-200"
                             data-accordion-item="true">
                            <button class="accordion-toggle py-4" data-accordion-toggle="#faq_4_content">
                    <span class="text-base text-gray-900">
                        ¿Qué significan los estados "Activo" e "Inactivo"?
                    </span>
                                <i class="ki-filled ki-plus text-gray-600 text-sm accordion-active:hidden block"></i>
                                <i class="ki-filled ki-minus text-gray-600 text-sm accordion-active:block hidden"></i>
                            </button>
                            <div class="accordion-content hidden" id="faq_4_content">
                                <div class="text-gray-700 text-md pb-4">
                                    El estado "Activo" indica que el tipo de propiedad está disponible para ser
                                    utilizado en el sistema, mientras que "Inactivo" lo oculta temporalmente sin
                                    eliminarlo.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item [&:not(:last-child)]:border-b border-b-gray-200"
                             data-accordion-item="true">
                            <button class="accordion-toggle py-4" data-accordion-toggle="#faq_5_content">
                    <span class="text-base text-gray-900">
                        ¿Puedo editar un tipo de propiedad después de crearlo?
                    </span>
                                <i class="ki-filled ki-plus text-gray-600 text-sm accordion-active:hidden block"></i>
                                <i class="ki-filled ki-minus text-gray-600 text-sm accordion-active:block hidden"></i>
                            </button>
                            <div class="accordion-content hidden" id="faq_5_content">
                                <div class="text-gray-700 text-md pb-4">
                                    Sí, puedes editar un tipo de propiedad en cualquier momento. Simplemente selecciona
                                    el tipo de propiedad en la lista, haz clic en "Editar" y realiza los cambios
                                    necesarios.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item [&:not(:last-child)]:border-b border-b-gray-200"
                             data-accordion-item="true">
                            <button class="accordion-toggle py-4" data-accordion-toggle="#faq_6_content">
                    <span class="text-base text-gray-900">
                        ¿Cómo elimino un tipo de propiedad?
                    </span>
                                <i class="ki-filled ki-plus text-gray-600 text-sm accordion-active:hidden block"></i>
                                <i class="ki-filled ki-minus text-gray-600 text-sm accordion-active:block hidden"></i>
                            </button>
                            <div class="accordion-content hidden" id="faq_6_content">
                                <div class="text-gray-700 text-md pb-4">
                                    Para eliminar un tipo de propiedad, selecciona el registro en la lista y haz clic en
                                    "Eliminar". Ten en cuenta que esta acción no se puede deshacer.
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
                const isChecked = this.checked;
                const rows = document.querySelectorAll('#teams_table tbody tr');
                rows.forEach(row => {
                    const statusBadge = row.querySelector('td:nth-child(5) .badge');
                    if (statusBadge) {
                        const isActive = statusBadge.classList.contains('badge-success');
                        row.style.display = (isChecked && !isActive) ? 'none' : '';
                    }
                });
            });


            const deleteModal = document.querySelector('#deleteModal');
            const titlePlaceholder = document.querySelector('#modal-title-placeholder');
            const idPlaceholder = document.querySelector('#modal-id-placeholder');
            const deleteForm = document.getElementById('deleteForm');

            document.querySelectorAll('[data-modal-toggle="#deleteModal"]').forEach(button => {
                button.addEventListener('click', function () {
                    const title = this.getAttribute('data-title');
                    const id = this.getAttribute('data-id');

                    // Update modal content
                    titlePlaceholder.textContent = title;
                    idPlaceholder.textContent = id;

                    // Update form action
                    deleteForm.action = `/property-types/${id}`;
                });
            });
        });
    </script>


</x-app-layout>
