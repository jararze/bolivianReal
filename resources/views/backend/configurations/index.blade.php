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
        </div>
    </x-slot>


    <div class="container-fixed">
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-5 lg:gap-7.5">
            <div class="card p-5 lg:p-7.5 lg:pt-7">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between gap-2">
                        <i class="ki-filled ki-badge text-2xl link">
                        </i>

                    </div>
                    <div class="flex flex-col gap-3">
                        <a class="text-base font-medium leading-none text-gray-900 hover:text-primary-active"
                           href="{{ route('backend.configurations.general') }}">
                            Informacion de la empresa
                        </a>
                        <span class="text-2sm text-gray-700 leading-5">Aqui podra modificar y/o agregar informacion de la empresa, como los logos, colores, textos, redes sociales.</span>
                    </div>
                </div>
            </div>
            <div class="card p-5 lg:p-7.5 lg:pt-7">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between gap-2">
                        <i class="ki-filled ki-security-user text-2xl link"></i>
                    </div>
                    <div class="flex flex-col gap-3">
                        <a class="text-base font-medium leading-none text-gray-900 hover:text-primary-active"
                           href="{{ route('backend.configurations.appearance') }}">
                            Apariencia
                        </a>
                        <span class="text-2sm text-gray-700 leading-5">Modifica el logo, los colores principales y el nombre del sitio para adaptarlo a tu marca.</span>
                    </div>
                </div>
            </div>

            <div class="card p-5 lg:p-7.5 lg:pt-7">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between gap-2">
                        <i class="ki-filled ki-cheque text-2xl link">
                        </i>
                    </div>
                    <div class="flex flex-col gap-3">
                        <a class="text-base font-medium leading-none text-gray-900 hover:text-primary-active"
                           href="{{ route('backend.configurations.home-slider') }}">
                            Carrusel de propiedades
                        </a>
                        <span class="text-2sm text-gray-700 leading-5">Selecciona las propiedades que se mostrarán en la página principal para captar la atención de tus clientes.</span>
                    </div>
                </div>
            </div>
            <div class="card p-5 lg:p-7.5 lg:pt-7">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between gap-2">
                        <i class="ki-filled ki-notification-on text-2xl link">
                        </i>
                        <div class="menu" data-menu="true">
                            <div class="menu-item" data-menu-item-offset="0, 10px" data-menu-item-placement="bottom-end"
                                 data-menu-item-placement-rtl="bottom-start" data-menu-item-toggle="dropdown"
                                 data-menu-item-trigger="click|lg:click">
                                <button class="menu-toggle btn btn-sm btn-icon btn-light btn-clear">
                                    <i class="ki-filled ki-dots-vertical">
                                    </i>
                                </button>
                                <div class="menu-dropdown menu-default w-full max-w-[200px]" data-menu-dismiss="true">
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/home/settings-enterprise.html">
									<span class="menu-icon">
									<i class="ki-filled ki-setting-3">
									</i>
									</span>
                                            <span class="menu-title">
									Settings
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/members/import-members.html">
									<span class="menu-icon">
									<i class="ki-filled ki-some-files">
									</i>
									</span>
                                            <span class="menu-title">
									Import
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/activity.html">
									<span class="menu-icon">
									<i class="ki-filled ki-cloud-change">
									</i>
									</span>
                                            <span class="menu-title">
									Activity
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" data-modal-toggle="#report_user_modal" href="#">
									<span class="menu-icon">
									<i class="ki-filled ki-dislike">
									</i>
									</span>
                                            <span class="menu-title">
									Report
									</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <a class="text-base font-medium leading-none text-gray-900 hover:text-primary-active"
                           href="html/demo8/account/notifications.html">
                            Notifications
                        </a>
                        <span class="text-2sm text-gray-700 leading-5">
					Keep updated with important notices and event reminders.
					</span>
                    </div>
                </div>
            </div>
            <div class="card p-5 lg:p-7.5 lg:pt-7">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between gap-2">
                        <i class="ki-filled ki-dropbox text-2xl link">
                        </i>
                        <div class="menu" data-menu="true">
                            <div class="menu-item" data-menu-item-offset="0, 10px" data-menu-item-placement="bottom-end"
                                 data-menu-item-placement-rtl="bottom-start" data-menu-item-toggle="dropdown"
                                 data-menu-item-trigger="click|lg:click">
                                <button class="menu-toggle btn btn-sm btn-icon btn-light btn-clear">
                                    <i class="ki-filled ki-dots-vertical">
                                    </i>
                                </button>
                                <div class="menu-dropdown menu-default w-full max-w-[200px]" data-menu-dismiss="true">
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/home/settings-enterprise.html">
									<span class="menu-icon">
									<i class="ki-filled ki-setting-3">
									</i>
									</span>
                                            <span class="menu-title">
									Settings
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/members/import-members.html">
									<span class="menu-icon">
									<i class="ki-filled ki-some-files">
									</i>
									</span>
                                            <span class="menu-title">
									Import
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/activity.html">
									<span class="menu-icon">
									<i class="ki-filled ki-cloud-change">
									</i>
									</span>
                                            <span class="menu-title">
									Activity
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" data-modal-toggle="#report_user_modal" href="#">
									<span class="menu-icon">
									<i class="ki-filled ki-dislike">
									</i>
									</span>
                                            <span class="menu-title">
									Report
									</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <a class="text-base font-medium leading-none text-gray-900 hover:text-primary-active"
                           href="html/demo8/account/integrations.html">
                            Integrations
                        </a>
                        <span class="text-2sm text-gray-700 leading-5">
					Enhance Workflows with Advanced Integrations.
					</span>
                    </div>
                </div>
            </div>
            <div class="card p-5 lg:p-7.5 lg:pt-7">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between gap-2">
                        <i class="ki-filled ki-user text-2xl link">
                        </i>
                        <div class="menu" data-menu="true">
                            <div class="menu-item" data-menu-item-offset="0, 10px" data-menu-item-placement="bottom-end"
                                 data-menu-item-placement-rtl="bottom-start" data-menu-item-toggle="dropdown"
                                 data-menu-item-trigger="click|lg:click">
                                <button class="menu-toggle btn btn-sm btn-icon btn-light btn-clear">
                                    <i class="ki-filled ki-dots-vertical">
                                    </i>
                                </button>
                                <div class="menu-dropdown menu-default w-full max-w-[200px]" data-menu-dismiss="true">
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/home/settings-enterprise.html">
									<span class="menu-icon">
									<i class="ki-filled ki-setting-3">
									</i>
									</span>
                                            <span class="menu-title">
									Settings
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/members/import-members.html">
									<span class="menu-icon">
									<i class="ki-filled ki-some-files">
									</i>
									</span>
                                            <span class="menu-title">
									Import
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/activity.html">
									<span class="menu-icon">
									<i class="ki-filled ki-cloud-change">
									</i>
									</span>
                                            <span class="menu-title">
									Activity
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" data-modal-toggle="#report_user_modal" href="#">
									<span class="menu-icon">
									<i class="ki-filled ki-dislike">
									</i>
									</span>
                                            <span class="menu-title">
									Report
									</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <a class="text-base font-medium leading-none text-gray-900 hover:text-primary-active"
                           href="html/demo8/account/members/roles.html">
                            Members, Teams & Roles
                        </a>
                        <span class="text-2sm text-gray-700 leading-5">
					Efficient management of members, teams, and roles.
					</span>
                    </div>
                </div>
            </div>
            <div class="card p-5 lg:p-7.5 lg:pt-7">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between gap-2">
                        <i class="ki-filled ki-key-square text-2xl link">
                        </i>
                        <div class="menu" data-menu="true">
                            <div class="menu-item" data-menu-item-offset="0, 10px" data-menu-item-placement="bottom-end"
                                 data-menu-item-placement-rtl="bottom-start" data-menu-item-toggle="dropdown"
                                 data-menu-item-trigger="click|lg:click">
                                <button class="menu-toggle btn btn-sm btn-icon btn-light btn-clear">
                                    <i class="ki-filled ki-dots-vertical">
                                    </i>
                                </button>
                                <div class="menu-dropdown menu-default w-full max-w-[200px]" data-menu-dismiss="true">
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/home/settings-enterprise.html">
									<span class="menu-icon">
									<i class="ki-filled ki-setting-3">
									</i>
									</span>
                                            <span class="menu-title">
									Settings
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/members/import-members.html">
									<span class="menu-icon">
									<i class="ki-filled ki-some-files">
									</i>
									</span>
                                            <span class="menu-title">
									Import
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/activity.html">
									<span class="menu-icon">
									<i class="ki-filled ki-cloud-change">
									</i>
									</span>
                                            <span class="menu-title">
									Activity
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" data-modal-toggle="#report_user_modal" href="#">
									<span class="menu-icon">
									<i class="ki-filled ki-dislike">
									</i>
									</span>
                                            <span class="menu-title">
									Report
									</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <a class="text-base font-medium leading-none text-gray-900 hover:text-primary-active"
                           href="html/demo8/account/api-keys.html">
                            API Keys
                        </a>
                        <span class="text-2sm text-gray-700 leading-5">
					Secure and manage Your API Keys effectively and efficiently.
					</span>
                    </div>
                </div>
            </div>
            <div class="card p-5 lg:p-7.5 lg:pt-7">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between gap-2">
                        <i class="ki-filled ki-mouse-square text-2xl link">
                        </i>
                        <div class="menu" data-menu="true">
                            <div class="menu-item" data-menu-item-offset="0, 10px" data-menu-item-placement="bottom-end"
                                 data-menu-item-placement-rtl="bottom-start" data-menu-item-toggle="dropdown"
                                 data-menu-item-trigger="click|lg:click">
                                <button class="menu-toggle btn btn-sm btn-icon btn-light btn-clear">
                                    <i class="ki-filled ki-dots-vertical">
                                    </i>
                                </button>
                                <div class="menu-dropdown menu-default w-full max-w-[200px]" data-menu-dismiss="true">
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/home/settings-enterprise.html">
									<span class="menu-icon">
									<i class="ki-filled ki-setting-3">
									</i>
									</span>
                                            <span class="menu-title">
									Settings
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/members/import-members.html">
									<span class="menu-icon">
									<i class="ki-filled ki-some-files">
									</i>
									</span>
                                            <span class="menu-title">
									Import
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/activity.html">
									<span class="menu-icon">
									<i class="ki-filled ki-cloud-change">
									</i>
									</span>
                                            <span class="menu-title">
									Activity
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" data-modal-toggle="#report_user_modal" href="#">
									<span class="menu-icon">
									<i class="ki-filled ki-dislike">
									</i>
									</span>
                                            <span class="menu-title">
									Report
									</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <a class="text-base font-medium leading-none text-gray-900 hover:text-primary-active"
                           href="html/demo8/account/appearance.html">
                            Appearance
                        </a>
                        <span class="text-2sm text-gray-700 leading-5">
					Transforming your online presence with flawless appearance.
					</span>
                    </div>
                </div>
            </div>
            <div class="card p-5 lg:p-7.5 lg:pt-7">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between gap-2">
                        <i class="ki-filled ki-desktop-mobile text-2xl link">
                        </i>
                        <div class="menu" data-menu="true">
                            <div class="menu-item" data-menu-item-offset="0, 10px" data-menu-item-placement="bottom-end"
                                 data-menu-item-placement-rtl="bottom-start" data-menu-item-toggle="dropdown"
                                 data-menu-item-trigger="click|lg:click">
                                <button class="menu-toggle btn btn-sm btn-icon btn-light btn-clear">
                                    <i class="ki-filled ki-dots-vertical">
                                    </i>
                                </button>
                                <div class="menu-dropdown menu-default w-full max-w-[200px]" data-menu-dismiss="true">
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/home/settings-enterprise.html">
									<span class="menu-icon">
									<i class="ki-filled ki-setting-3">
									</i>
									</span>
                                            <span class="menu-title">
									Settings
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/members/import-members.html">
									<span class="menu-icon">
									<i class="ki-filled ki-some-files">
									</i>
									</span>
                                            <span class="menu-title">
									Import
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/activity.html">
									<span class="menu-icon">
									<i class="ki-filled ki-cloud-change">
									</i>
									</span>
                                            <span class="menu-title">
									Activity
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" data-modal-toggle="#report_user_modal" href="#">
									<span class="menu-icon">
									<i class="ki-filled ki-dislike">
									</i>
									</span>
                                            <span class="menu-title">
									Report
									</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <a class="text-base font-medium leading-none text-gray-900 hover:text-primary-active"
                           href="html/demo8.html">
                            Devices
                        </a>
                        <span class="text-2sm text-gray-700 leading-5">
					Stay ahead with the latest devices and innovations news
					</span>
                    </div>
                </div>
            </div>
            <div class="card p-5 lg:p-7.5 lg:pt-7">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between gap-2">
                        <i class="ki-filled ki-color-swatch text-2xl link">
                        </i>
                        <div class="menu" data-menu="true">
                            <div class="menu-item" data-menu-item-offset="0, 10px" data-menu-item-placement="bottom-end"
                                 data-menu-item-placement-rtl="bottom-start" data-menu-item-toggle="dropdown"
                                 data-menu-item-trigger="click|lg:click">
                                <button class="menu-toggle btn btn-sm btn-icon btn-light btn-clear">
                                    <i class="ki-filled ki-dots-vertical">
                                    </i>
                                </button>
                                <div class="menu-dropdown menu-default w-full max-w-[200px]" data-menu-dismiss="true">
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/home/settings-enterprise.html">
									<span class="menu-icon">
									<i class="ki-filled ki-setting-3">
									</i>
									</span>
                                            <span class="menu-title">
									Settings
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/members/import-members.html">
									<span class="menu-icon">
									<i class="ki-filled ki-some-files">
									</i>
									</span>
                                            <span class="menu-title">
									Import
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/activity.html">
									<span class="menu-icon">
									<i class="ki-filled ki-cloud-change">
									</i>
									</span>
                                            <span class="menu-title">
									Activity
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" data-modal-toggle="#report_user_modal" href="#">
									<span class="menu-icon">
									<i class="ki-filled ki-dislike">
									</i>
									</span>
                                            <span class="menu-title">
									Report
									</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <a class="text-base font-medium leading-none text-gray-900 hover:text-primary-active"
                           href="html/demo8/account/invite-a-friend.html">
                            Brand
                        </a>
                        <span class="text-2sm text-gray-700 leading-5">
					Trending brand designs, identities, and logos.
					</span>
                    </div>
                </div>
            </div>
            <div class="card p-5 lg:p-7.5 lg:pt-7">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between gap-2">
                        <i class="ki-filled ki-chart-line-star text-2xl link">
                        </i>
                        <div class="menu" data-menu="true">
                            <div class="menu-item" data-menu-item-offset="0, 10px" data-menu-item-placement="bottom-end"
                                 data-menu-item-placement-rtl="bottom-start" data-menu-item-toggle="dropdown"
                                 data-menu-item-trigger="click|lg:click">
                                <button class="menu-toggle btn btn-sm btn-icon btn-light btn-clear">
                                    <i class="ki-filled ki-dots-vertical">
                                    </i>
                                </button>
                                <div class="menu-dropdown menu-default w-full max-w-[200px]" data-menu-dismiss="true">
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/home/settings-enterprise.html">
									<span class="menu-icon">
									<i class="ki-filled ki-setting-3">
									</i>
									</span>
                                            <span class="menu-title">
									Settings
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/members/import-members.html">
									<span class="menu-icon">
									<i class="ki-filled ki-some-files">
									</i>
									</span>
                                            <span class="menu-title">
									Import
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="html/demo8/account/activity.html">
									<span class="menu-icon">
									<i class="ki-filled ki-cloud-change">
									</i>
									</span>
                                            <span class="menu-title">
									Activity
									</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" data-modal-toggle="#report_user_modal" href="#">
									<span class="menu-icon">
									<i class="ki-filled ki-dislike">
									</i>
									</span>
                                            <span class="menu-title">
									Report
									</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <a class="text-base font-medium leading-none text-gray-900 hover:text-primary-active"
                           href="html/demo8/account/activity.html">
                            Activity
                        </a>
                        <span class="text-2sm text-gray-700 leading-5">
					Central Hub for Personal Customization.
					</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
