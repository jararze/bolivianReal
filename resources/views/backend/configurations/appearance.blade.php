<x-app-layout>


    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">
            {{ __('Configuracion') }}
        </h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a class="text-gray-700 hover:text-primary" href="{{ route('backend.configurations.index') }}">
                {{ __('Pagina principal') }}
            </a>
            <span class="text-gray-400 text-sm">
            /
           </span>
            <span class="text-gray-700">
            {{ __('Ajustes de la página principal') }}
           </span>
            <span class="text-gray-400 text-sm">
            /
           </span>
            <span class="text-gray-700">
            {{ __('Apariencia') }}
           </span>
        </div>
    </x-slot>

    <div class="container-fixed">
        <!-- begin: grid -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 lg:gap-7.5">
            <div class="col-span-2">
                <div class="flex flex-col gap-5 lg:gap-7.5">

                    <div class="card min-w-full">
                        <div class="card-header">
                            <h3 class="card-title">
                                Apariencia del portal
                            </h3>
                        </div>
                        <style>
                            .branding-bg {
                                background-image: url('{{ asset('assets/media/images/2600x1200/bg-5.png') }}');
                            }

                            .dark .branding-bg {
                                background-image: url('{{ asset('assets/media/images/2600x1200/bg-5-dark.png') }}');
                            }
                        </style>
                        <form method="post" action="{{ route('backend.configurations.appearance.update') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="card-body lg:py-7.5 py-5">

                                <div class="flex flex-wrap justify-between gap-5">
                                    <div class="flex flex-col">
                                        <div class="text-gray-900 text-sm font-medium">
                                            Logotipo
                                        </div>
                                        <x-input-error class="mt-2" :messages="$errors->get('logo')"/>
                                    </div>
                                    <div class="flex flex-wrap sm:flex-nowrap gap-5 lg:gap-7.5 max-w-96 w-full">
                                        <img id="logo-preview"
                                             class="h-[35px] mt-2"
                                             src="{{ file_exists(public_path($values['logo']['path'] ?? '')) ? asset($values['logo']['path']) : asset('assets/media/logo/notAvailable.svg') }}"
                                             alt="Logo preview"/>

                                        <div
                                            class="flex bg-center w-full p-5 lg:p-7 bg-no-repeat bg-[length:550px] border border-gray-300 rounded-xl border-dashed branding-bg">
                                            <div
                                                class="flex flex-col place-items-center place-content-center text-center rounded-xl w-full">
                                                <input type="file"
                                                       id="logo"
                                                       name="logo"
                                                       class="hidden"
                                                       accept="image/*"
                                                       onchange="previewImage(this, 'logo-preview')">
                                                <label for="logo" class="cursor-pointer w-full">
                                                    <div class="flex items-center mb-2.5">
                                                        <div class="relative size-11 shrink-0">
                                                            <svg class="w-full h-full stroke-brand-clarity fill-light"
                                                                 fill="none" height="48" viewbox="0 0 44 48" width="44"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M16 2.4641C19.7128 0.320509 24.2872 0.320508 28 2.4641L37.6506 8.0359C41.3634 10.1795 43.6506 14.141 43.6506 18.4282V29.5718C43.6506 33.859 41.3634 37.8205 37.6506 39.9641L28 45.5359C24.2872 47.6795 19.7128 47.6795 16 45.5359L6.34937 39.9641C2.63655 37.8205 0.349365 33.859 0.349365 29.5718V18.4282C0.349365 14.141 2.63655 10.1795 6.34937 8.0359L16 2.4641Z"
                                                                    fill="">
                                                                </path>
                                                                <path
                                                                    d="M16.25 2.89711C19.8081 0.842838 24.1919 0.842837 27.75 2.89711L37.4006 8.46891C40.9587 10.5232 43.1506 14.3196 43.1506 18.4282V29.5718C43.1506 33.6804 40.9587 37.4768 37.4006 39.5311L27.75 45.1029C24.1919 47.1572 19.8081 47.1572 16.25 45.1029L6.59937 39.5311C3.04125 37.4768 0.849365 33.6803 0.849365 29.5718V18.4282C0.849365 14.3196 3.04125 10.5232 6.59937 8.46891L16.25 2.89711Z"
                                                                    stroke="" stroke-opacity="0.2">
                                                                </path>
                                                            </svg>
                                                            <div
                                                                class="absolute leading-none left-2/4 top-2/4 -translate-y-2/4 -translate-x-2/4">
                                                                <i class="ki-filled ki-picture text-xl ps-px text-brand"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span
                                                        class="text-gray-900 text-xs font-medium hover:text-primary-active mb-px block">Click or Drag & Drop</span>
                                                    <span class="text-2xs text-gray-700 text-nowrap">SVG,PNG, JPG (max. 800x400)</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="flex flex-wrap justify-between gap-y-5 my-5">
                                    <div class="flex flex-col">
                                        <div class="text-gray-900 text-sm font-medium">
                                            Logotipo Interno
                                        </div>
                                        <x-input-error class="mt-2" :messages="$errors->get('logo_internal')"/>
                                    </div>
                                    <div class="flex flex-wrap sm:flex-nowrap gap-5 lg:gap-7.5 max-w-96 w-full">
                                        <img id="logo_internal-preview"
                                             class="h-[35px] mt-2"
                                             src="{{ file_exists(public_path($values['logo_internal']['path'] ?? '')) ? asset($values['logo_internal']['path']) : asset('assets/media/logo/notAvailable.svg') }}"
                                             alt="Logo preview"/>

                                        <div
                                            class="flex bg-center w-full p-5 lg:p-7 bg-no-repeat bg-[length:550px] border border-gray-300 rounded-xl border-dashed branding-bg">
                                            <div
                                                class="flex flex-col place-items-center place-content-center text-center rounded-xl w-full">
                                                <input type="file"
                                                       id="logo_internal"
                                                       name="logo_internal"
                                                       class="hidden"
                                                       accept="image/*"
                                                       onchange="previewImage(this, 'logo_internal-preview')">
                                                <label for="logo_internal" class="cursor-pointer w-full">
                                                    <div class="flex items-center mb-2.5">
                                                        <div class="relative size-11 shrink-0">
                                                            <svg class="w-full h-full stroke-brand-clarity fill-light"
                                                                 fill="none" height="48" viewbox="0 0 44 48" width="44"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M16 2.4641C19.7128 0.320509 24.2872 0.320508 28 2.4641L37.6506 8.0359C41.3634 10.1795 43.6506 14.141 43.6506 18.4282V29.5718C43.6506 33.859 41.3634 37.8205 37.6506 39.9641L28 45.5359C24.2872 47.6795 19.7128 47.6795 16 45.5359L6.34937 39.9641C2.63655 37.8205 0.349365 33.859 0.349365 29.5718V18.4282C0.349365 14.141 2.63655 10.1795 6.34937 8.0359L16 2.4641Z"
                                                                    fill="">
                                                                </path>
                                                                <path
                                                                    d="M16.25 2.89711C19.8081 0.842838 24.1919 0.842837 27.75 2.89711L37.4006 8.46891C40.9587 10.5232 43.1506 14.3196 43.1506 18.4282V29.5718C43.1506 33.6804 40.9587 37.4768 37.4006 39.5311L27.75 45.1029C24.1919 47.1572 19.8081 47.1572 16.25 45.1029L6.59937 39.5311C3.04125 37.4768 0.849365 33.6803 0.849365 29.5718V18.4282C0.849365 14.3196 3.04125 10.5232 6.59937 8.46891L16.25 2.89711Z"
                                                                    stroke="" stroke-opacity="0.2">
                                                                </path>
                                                            </svg>
                                                            <div
                                                                class="absolute leading-none left-2/4 top-2/4 -translate-y-2/4 -translate-x-2/4">
                                                                <i class="ki-filled ki-picture text-xl ps-px text-brand"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span
                                                        class="text-gray-900 text-xs font-medium hover:text-primary-active mb-px block">Click or Drag & Drop</span>
                                                    <span class="text-2xs text-gray-700 text-nowrap">SVG,PNG, JPG (max. 800x400)</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-wrap justify-between gap-5">
                                    <div class="flex flex-col">
                                        <div class="text-gray-900 text-sm font-medium">
                                            Favicon
                                        </div>
                                        <x-input-error class="mt-2" :messages="$errors->get('favicon')"/>
                                    </div>
                                    <div class="flex flex-wrap sm:flex-nowrap gap-5 lg:gap-7.5 max-w-96 w-full">
                                        <img id="favicon-preview"
                                             class="h-[35px] mt-2"
                                             src="{{ file_exists(public_path($values['favicon']['path'] ?? '')) ? asset($values['favicon']['path']) : asset('assets/media/logo/notAvailable.svg') }}"
                                             alt="Logo preview"/>

                                        <div
                                            class="flex bg-center w-full p-5 lg:p-7 bg-no-repeat bg-[length:550px] border border-gray-300 rounded-xl border-dashed branding-bg">
                                            <div
                                                class="flex flex-col place-items-center place-content-center text-center rounded-xl w-full">
                                                <input type="file"
                                                       id="favicon"
                                                       name="favicon"
                                                       class="hidden"
                                                       accept="image/*"
                                                       onchange="previewImage(this, 'favicon-preview')">
                                                <label for="favicon" class="cursor-pointer w-full">
                                                    <div class="flex items-center mb-2.5">
                                                        <div class="relative size-11 shrink-0">
                                                            <svg class="w-full h-full stroke-brand-clarity fill-light"
                                                                 fill="none" height="48" viewbox="0 0 44 48" width="44"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M16 2.4641C19.7128 0.320509 24.2872 0.320508 28 2.4641L37.6506 8.0359C41.3634 10.1795 43.6506 14.141 43.6506 18.4282V29.5718C43.6506 33.859 41.3634 37.8205 37.6506 39.9641L28 45.5359C24.2872 47.6795 19.7128 47.6795 16 45.5359L6.34937 39.9641C2.63655 37.8205 0.349365 33.859 0.349365 29.5718V18.4282C0.349365 14.141 2.63655 10.1795 6.34937 8.0359L16 2.4641Z"
                                                                    fill="">
                                                                </path>
                                                                <path
                                                                    d="M16.25 2.89711C19.8081 0.842838 24.1919 0.842837 27.75 2.89711L37.4006 8.46891C40.9587 10.5232 43.1506 14.3196 43.1506 18.4282V29.5718C43.1506 33.6804 40.9587 37.4768 37.4006 39.5311L27.75 45.1029C24.1919 47.1572 19.8081 47.1572 16.25 45.1029L6.59937 39.5311C3.04125 37.4768 0.849365 33.6803 0.849365 29.5718V18.4282C0.849365 14.3196 3.04125 10.5232 6.59937 8.46891L16.25 2.89711Z"
                                                                    stroke="" stroke-opacity="0.2">
                                                                </path>
                                                            </svg>
                                                            <div
                                                                class="absolute leading-none left-2/4 top-2/4 -translate-y-2/4 -translate-x-2/4">
                                                                <i class="ki-filled ki-picture text-xl ps-px text-brand"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span
                                                        class="text-gray-900 text-xs font-medium hover:text-primary-active mb-px block">Click or Drag & Drop</span>
                                                    <span class="text-2xs text-gray-700 text-nowrap">SVG,PNG, JPG (max. 800x400)</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="border-t border-gray-200 my-7.5"></div>

                                <div class="flex items-center gap-5">
                                    <div class="w-1/3 text-gray-900 text-sm font-medium">
                                        <x-input-label for="site_name" :value="__('Nombre del sitio')"
                                                       class="text-gray-900 text-sm font-medium"/>
                                    </div>
                                    <div class="w-2/3">
                                        <x-text-input id="site_name" name="site_name" type="text"
                                                      :value="old('site_name', $values['site_name'])"
                                                      autofocus required autocomplete="site_name" class="input w-full"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('site_name')"/>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 my-7.5"></div>

                                <div class="flex flex-col gap-y-5">
                                    <div class="flex flex-wrap justify-between gap-5">
                                        <div class="flex flex-col">
                                            <div class="text-gray-900 text-sm font-medium">
                                                <x-input-label for="primary_color" :value="__('Color primario')"
                                                               class="text-gray-900 text-sm font-medium"/>
                                            </div>
                                            <span
                                                class="text-gray-700 text-2sm">El color principal</span>
                                        </div>
                                        <label class="input sm:max-w-full xl:max-w-96 w-full">
                                            <i class="ki-solid ki-mouse-square text-[#48a640]"></i>
                                            <x-text-input id="primary_color" name="primary_color" type="text"
                                                          :value="old('#48a640', $values['primary_color'])"
                                                          autofocus required autocomplete="primary_color"
                                                          class="input w-full"/>
                                        </label>
                                        <x-input-error class="mt-2" :messages="$errors->get('primary_color')"/>
                                    </div>
                                    <div class="flex flex-wrap justify-between gap-5">
                                        <div class="flex flex-col">
                                            <div class="text-gray-900 text-sm font-medium">
                                                <x-input-label for="secondary_color" :value="__('Color Secundario')"
                                                               class="text-gray-900 text-sm font-medium"/>
                                            </div>
                                            <span class="text-gray-700 text-2sm">El color de apoyo </span>
                                        </div>
                                        <label class="input sm:max-w-full xl:max-w-96 w-full">
                                            <i class="ki-solid ki-mouse-square text-[#0dbae8]"></i>
                                            <x-text-input id="secondary_color" name="secondary_color" type="text"
                                                          :value="old('#0dbae8', $values['secondary_color'])"
                                                          autofocus required autocomplete="secondary_color"
                                                          class="input w-full"/>
                                        </label>
                                        <x-input-error class="mt-2" :messages="$errors->get('secondary_color')"/>
                                    </div>
                                    <div class="flex flex-wrap justify-between gap-5">
                                        <div class="flex flex-col">
                                            <div class="text-gray-900 text-sm font-medium">
                                                <x-input-label for="support_color" :value="__('Color Apoyo')"
                                                               class="text-gray-900 text-sm font-medium"/>
                                            </div>
                                            <span class="text-gray-700 text-2sm">El color adicional </span>
                                        </div>
                                        <label class="input sm:max-w-full xl:max-w-96 w-full">
                                            <i class="ki-solid ki-mouse-square text-[#f4903f]"></i>
                                            <x-text-input id="support_color" name="support_color" type="text"
                                                          :value="old('#f4903f', $values['support_color'])"
                                                          autofocus required autocomplete="support_color"
                                                          class="input w-full"/>
                                        </label>
                                        <x-input-error class="mt-2" :messages="$errors->get('support_color')"/>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 my-7.5"></div>

                                <div class="flex justify-end">
                                    <div class="flex justify-end">
                                        <x-primary-button name="action">Guardar Cambios</x-primary-button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>


                </div>
            </div>
            @include('layouts.metronic.backend.sidebar')

        </div>
        <!-- end: grid -->
    </div>

    <script>
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(file);
            }
        }

        // Drag and drop functionality
        document.querySelectorAll('.border-dashed').forEach(dropZone => {
            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.classList.add('border-primary');
            });

            dropZone.addEventListener('dragleave', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-primary');
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-primary');

                const fileInput = dropZone.querySelector('input[type="file"]');
                const files = e.dataTransfer.files;

                if (files.length > 0 && files[0].type.startsWith('image/')) {
                    fileInput.files = files;
                    const event = new Event('change');
                    fileInput.dispatchEvent(event);
                }
            });
        });
    </script>


</x-app-layout>
