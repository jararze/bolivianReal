<x-app-layout>

    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">
            {{ __('Configuracion') }}
        </h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.cities.index') }}">
                {{ __('Barrios') }}
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

            @if($neighborhoods->count() == 0)
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
                                    Crear un nuevo Barrio
                                </h2>
                                <p class="text-sm text-gray-800">
                                    Agrega fácilmente un nuevo barrio mejorar la organización y gestión de tus propiedades.
                                    <br/>
                                    Define ciudades específicas para tu catálogo inmobiliario de manera sencilla.
                                </p>
                            </div>
                            <div class="flex justify-center mb-5">
                                <a class="btn btn-primary" href="{{ route('backend.cities.create') }}">
                                    Crear nuevo barrio
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card card-grid min-w-full">
                    <div class="card-header flex-wrap py-5">
                        <h3 class="card-title">
                            Listado de barrios
                        </h3>
                        <div class="flex gap-6">
                            <div class="relative">
                                <i class="ki-filled ki-magnifier leading-none text-md text-gray-500 absolute top-1/2 start-0 -translate-y-1/2 ms-3">
                                </i>
                                <input class="input input-sm ps-8" data-datatable-search="#teams_table"
                                       placeholder="Buscar tipo de propiedad" type="text"/>
                            </div>
                            <a class="btn btn-primary" href="{{ route('backend.neighborhood.create') }}">
                                Agregar nuevo Barrio
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
                                        <th class="w-[250px]">
                                            <span class="sort asc"><span class="sort-label text-gray-700 font-normal">Ciudad</span><span
                                                    class="sort-icon"></span></span>
                                        </th>
                                        <th class="w-[60px]">
                                        </th>
                                        <th class="w-[60px]">
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($neighborhoods as $neighborhood)
                                        <tr>
                                            <td class="text-center">
                                                <input class="checkbox checkbox-sm" data-datatable-row-check="true"
                                                       type="checkbox" value="{{ $neighborhood->id }}"/>
                                            </td>
                                            <td>
                                                <div class="flex flex-col gap-1.5">
                                                    <a class="leading-none font-medium text-sm text-gray-900 hover:text-primary"
                                                       href="{{ route('backend.neighborhood.edit', $neighborhood->id) }}">
                                                        {{ $neighborhood->name }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex flex-col gap-1.5">
                                                    <a class="leading-none font-medium text-sm text-gray-900 hover:text-primary"
                                                       href="{{ route('backend.neighborhood.edit', $neighborhood->id) }}">
                                                        {{ $neighborhood->city->name }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-icon btn-clear btn-light"
                                                   href="{{ route('backend.neighborhood.edit', $neighborhood->id) }}">
                                                    <i class="ki-filled ki-notepad-edit">
                                                    </i>
                                                </a>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-icon btn-clear btn-light"
                                                        data-modal-toggle="#deleteModal"
                                                        data-title="{{ $neighborhood->name }}" data-id="{{ $neighborhood->id }}">
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
                        ¿Estás seguro de que deseas eliminar esta ciudad <strong
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
                        <!-- Pregunta 1 -->
                        <div class="accordion-item [&:not(:last-child)]:border-b border-b-gray-200" data-accordion-item="true">
                            <button class="accordion-toggle py-4" data-accordion-toggle="#faq_1_content">
                    <span class="text-base text-gray-900">
                        ¿Cómo puedo agregar una nueva ciudad?
                    </span>
                                <i class="ki-filled ki-plus text-gray-600 text-sm accordion-active:hidden block"></i>
                                <i class="ki-filled ki-minus text-gray-600 text-sm accordion-active:block hidden"></i>
                            </button>
                            <div class="accordion-content hidden" id="faq_1_content">
                                <div class="text-gray-700 text-md pb-4">
                                    Para agregar una nueva ciudad, ve al menú "Ciudades" y haz clic en "Agregar Nueva". Llena el formulario con el nombre de la ciudad y guarda los cambios.
                                </div>
                            </div>
                        </div>

                        <!-- Pregunta 2 -->
                        <div class="accordion-item [&:not(:last-child)]:border-b border-b-gray-200" data-accordion-item="true">
                            <button class="accordion-toggle py-4" data-accordion-toggle="#faq_2_content">
                    <span class="text-base text-gray-900">
                        ¿Qué información es obligatoria al crear una ciudad?
                    </span>
                                <i class="ki-filled ki-plus text-gray-600 text-sm accordion-active:hidden block"></i>
                                <i class="ki-filled ki-minus text-gray-600 text-sm accordion-active:block hidden"></i>
                            </button>
                            <div class="accordion-content hidden" id="faq_2_content">
                                <div class="text-gray-700 text-md pb-4">
                                    El único campo obligatorio es el "Nombre" de la ciudad, que debe ser único y no superar los 100 caracteres.
                                </div>
                            </div>
                        </div>

                        <!-- Pregunta 3 -->
                        <div class="accordion-item [&:not(:last-child)]:border-b border-b-gray-200" data-accordion-item="true">
                            <button class="accordion-toggle py-4" data-accordion-toggle="#faq_3_content">
                    <span class="text-base text-gray-900">
                        ¿Puedo editar una ciudad después de crearla?
                    </span>
                                <i class="ki-filled ki-plus text-gray-600 text-sm accordion-active:hidden block"></i>
                                <i class="ki-filled ki-minus text-gray-600 text-sm accordion-active:block hidden"></i>
                            </button>
                            <div class="accordion-content hidden" id="faq_3_content">
                                <div class="text-gray-700 text-md pb-4">
                                    Sí, puedes editar una ciudad en cualquier momento. Ve al listado de ciudades, selecciona la ciudad que deseas editar y haz clic en "Editar".
                                </div>
                            </div>
                        </div>

                        <!-- Pregunta 4 -->
                        <div class="accordion-item [&:not(:last-child)]:border-b border-b-gray-200" data-accordion-item="true">
                            <button class="accordion-toggle py-4" data-accordion-toggle="#faq_4_content">
                    <span class="text-base text-gray-900">
                        ¿Cómo puedo eliminar una ciudad?
                    </span>
                                <i class="ki-filled ki-plus text-gray-600 text-sm accordion-active:hidden block"></i>
                                <i class="ki-filled ki-minus text-gray-600 text-sm accordion-active:block hidden"></i>
                            </button>
                            <div class="accordion-content hidden" id="faq_4_content">
                                <div class="text-gray-700 text-md pb-4">
                                    Para eliminar una ciudad, selecciona el registro en la lista y haz clic en "Eliminar". Ten en cuenta que esta acción no se puede deshacer.
                                </div>
                            </div>
                        </div>

                        <!-- Pregunta 5 -->
                        <div class="accordion-item [&:not(:last-child)]:border-b border-b-gray-200" data-accordion-item="true">
                            <button class="accordion-toggle py-4" data-accordion-toggle="#faq_5_content">
                    <span class="text-base text-gray-900">
                        ¿Qué pasa si intento crear una ciudad con un nombre duplicado?
                    </span>
                                <i class="ki-filled ki-plus text-gray-600 text-sm accordion-active:hidden block"></i>
                                <i class="ki-filled ki-minus text-gray-600 text-sm accordion-active:block hidden"></i>
                            </button>
                            <div class="accordion-content hidden" id="faq_5_content">
                                <div class="text-gray-700 text-md pb-4">
                                    El sistema no permitirá crear una ciudad con un nombre duplicado. Recibirás un mensaje de error indicando que el nombre ya está en uso.
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
                    deleteForm.action = `/neighborhood/${id}`;
                });
            });
        });
    </script>


</x-app-layout>
