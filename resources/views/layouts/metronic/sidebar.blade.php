<div
    class="fixed top-0 bottom-0 z-20 hidden lg:flex flex-col items-stretch shrink-0 bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark]"
    data-drawer="true" data-drawer-class="drawer drawer-start flex" data-drawer-enable="true|lg:false" id="sidebar">
    <div class="hidden lg:flex items-center justify-center shrink-0 pt-8 pb-3.5" id="sidebar_header">
        <a href="{{ route('dashboard') }}">
            @if($logo_internal)
                <img class="dark:hidden min-h-[42px] max-h-[42px] w-auto"
                     src="{{ asset($logo_internal['path']) }}"
                     alt="{{ config('app.name') }}"/>
                <img class="hidden dark:block mmin-h-[42px] max-h-[42px] w-auto"
                     src="{{ asset('assets/media/app/mini-logo-gray-dark.svg') }}" alt=""/>
            @else
                <!-- Fallback to default logos if no custom logo is set -->
                <img class="dark:hidden min-h-[42px]" src="{{ asset('assets/media/app/mini-logo-gray.svg') }}" alt=""/>
                <img class="hidden dark:block min-h-[42px]"
                     src="{{ asset('assets/media/app/mini-logo-gray-dark.svg') }}" alt=""/>
            @endif
        </a>
    </div>
    <div class="scrollable-y-hover grow gap-2.5 shrink-0 flex items-center pt-5 lg:pt-0 ps-3 pe-3 lg:pe-0 flex-col"
         data-scrollable="true" data-scrollable-dependencies="#sidebar_header,#sidebar_footer"
         data-scrollable-height="auto" data-scrollable-offset="80px" data-scrollable-wrappers="#sidebar_menu_wrapper"
         id="sidebar_menu_wrapper">
        <!-- Sidebar Menu -->
        <div class="menu flex flex-col gap-2.5 grow" data-menu="true" id="sidebar_menu">
            <div class="menu-item">
                <a class="menu-link rounded-[9px] border border-transparent menu-item-active:border-gray-200 menu-item-active:bg-light menu-link-hover:bg-light menu-link-hover:border-gray-200 w-[62px] h-[60px] flex flex-col justify-center items-center gap-1 p-2"
                   href="{{ route('dashboard') }}">
                  <span
                      class="menu-icon menu-item-here:text-primary menu-item-active:text-primary menu-link-hover:text-primary text-gray-600">
                    <i class="ki-filled ki-chart-line-star text-1.5xl"></i>
                  </span>
                    <span
                        class="menu-title text-xs menu-item-here:text-primary menu-item-active:text-primary menu-link-hover:text-primary text-gray-600 font-medium"> Tablero </span>
                </a>
            </div>

            <!-- ============================================ -->
            <!-- MENÚ DE CLIENTES -->
            <!-- ============================================ -->
            <div class="menu-item" data-menu-item-offset="-10px, 14px" data-menu-item-overflow="true"
                 data-menu-item-placement="right-start" data-menu-item-toggle="dropdown"
                 data-menu-item-trigger="click|lg:hover">
                <div class="menu-link rounded-[9px] border border-transparent menu-item-here:border-gray-200 menu-item-here:bg-light menu-link-hover:bg-light menu-link-hover:border-gray-200 w-[62px] h-[60px] flex flex-col justify-center items-center gap-1 p-2 grow">
        <span class="menu-icon menu-item-here:text-primary menu-item-active:text-primary menu-link-hover:text-primary text-gray-600">
            <i class="ki-filled ki-people text-1.5xl"></i>
        </span>
                    <span class="menu-title menu-item-here:text-primary menu-item-active:text-primary menu-link-hover:text-primary font-medium text-xs text-gray-600">
            Clientes
        </span>
                </div>
                <div class="menu-default menu-dropdown gap-0.5 w-[220px] scrollable-y-auto lg:overflow-visible max-h-[50vh]">
                    <!-- Todos los Clientes -->
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('backend.clients.index') }}">
                <span class="menu-icon">
                    <i class="ki-filled ki-people"></i>
                </span>
                            <span class="menu-title">Todos los Clientes</span>
                        </a>
                    </div>

                    <!-- Nuevo Cliente -->
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('backend.clients.create') }}">
                <span class="menu-icon">
                    <i class="ki-filled ki-plus-circle"></i>
                </span>
                            <span class="menu-title">Nuevo Cliente</span>
                        </a>
                    </div>

                    <div class="menu-separator"></div>

                    <!-- Filtros Rápidos -->
                    <div class="menu-item" data-menu-item-placement="right-start"
                         data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">
                        <div class="menu-link grow cursor-pointer">
                <span class="menu-icon">
                    <i class="ki-filled ki-filter"></i>
                </span>
                            <span class="menu-title">Filtros Rápidos</span>
                            <span class="menu-arrow">
                    <i class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i>
                </span>
                        </div>
                        <div class="menu-default menu-dropdown gap-0.5 w-[220px]">
                            <!-- Propietarios -->
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.clients.index', ['client_type' => 'owner']) }}">
                        <span class="menu-icon">
                            <i class="ki-filled ki-home"></i>
                        </span>
                                    <span class="menu-title">Propietarios</span>
                                </a>
                            </div>

                            <!-- Compradores -->
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.clients.index', ['client_type' => 'buyer']) }}">
                        <span class="menu-icon">
                            <i class="ki-filled ki-dollar"></i>
                        </span>
                                    <span class="menu-title">Compradores</span>
                                </a>
                            </div>

                            <!-- Inquilinos -->
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.clients.index', ['client_type' => 'tenant']) }}">
                        <span class="menu-icon">
                            <i class="ki-filled ki-security-user"></i>
                        </span>
                                    <span class="menu-title">Inquilinos</span>
                                </a>
                            </div>

                            <div class="menu-separator"></div>

                            <!-- Con Propiedades -->
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.clients.index') }}">
                        <span class="menu-icon">
                            <i class="ki-filled ki-chart-line-up-2"></i>
                        </span>
                                    <span class="menu-title">Con Propiedades</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="menu-separator"></div>

                    <!-- Estado -->
                    <div class="menu-item" data-menu-item-placement="right-start"
                         data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">
                        <div class="menu-link grow cursor-pointer">
                <span class="menu-icon">
                    <i class="ki-filled ki-toggle-on"></i>
                </span>
                            <span class="menu-title">Por Estado</span>
                            <span class="menu-arrow">
                    <i class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i>
                </span>
                        </div>
                        <div class="menu-default menu-dropdown gap-0.5 w-[220px]">
                            <!-- Activos -->
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.clients.index', ['status' => '1']) }}">
                        <span class="menu-icon">
                            <i class="ki-filled ki-check-circle text-success"></i>
                        </span>
                                    <span class="menu-title">Activos</span>
                                </a>
                            </div>

                            <!-- Inactivos -->
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.clients.index', ['status' => '0']) }}">
                        <span class="menu-icon">
                            <i class="ki-filled ki-cross-circle text-danger"></i>
                        </span>
                                    <span class="menu-title">Inactivos</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- MENÚ DE USUARIOS -->
            <!-- ============================================ -->
            <div class="menu-item" data-menu-item-offset="-10px, 14px" data-menu-item-overflow="true"
                 data-menu-item-placement="right-start" data-menu-item-toggle="dropdown"
                 data-menu-item-trigger="click|lg:hover">
                <div class="menu-link rounded-[9px] border border-transparent menu-item-here:border-gray-200 menu-item-here:bg-light menu-link-hover:bg-light menu-link-hover:border-gray-200 w-[62px] h-[60px] flex flex-col justify-center items-center gap-1 p-2 grow">
        <span class="menu-icon menu-item-here:text-primary menu-item-active:text-primary menu-link-hover:text-primary text-gray-600">
            <i class="ki-filled ki-address-book text-1.5xl"></i>
        </span>
                    <span class="menu-title menu-item-here:text-primary menu-item-active:text-primary menu-link-hover:text-primary font-medium text-xs text-gray-600">
            Usuarios
        </span>
                </div>
                <div class="menu-default menu-dropdown gap-0.5 w-[220px] scrollable-y-auto lg:overflow-visible max-h-[50vh]">
                    <!-- Todos los Usuarios -->
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('backend.users.index') }}">
                <span class="menu-icon">
                    <i class="ki-filled ki-people"></i>
                </span>
                            <span class="menu-title">Todos los Usuarios</span>
                        </a>
                    </div>

                    <!-- Nuevo Usuario -->
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('backend.users.create') }}">
                <span class="menu-icon">
                    <i class="ki-filled ki-plus-circle"></i>
                </span>
                            <span class="menu-title">Nuevo Usuario</span>
                        </a>
                    </div>

                    <div class="menu-separator"></div>

                    <!-- Por Rol -->
                    <div class="menu-item" data-menu-item-placement="right-start"
                         data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">
                        <div class="menu-link grow cursor-pointer">
                <span class="menu-icon">
                    <i class="ki-filled ki-badge"></i>
                </span>
                            <span class="menu-title">Por Rol</span>
                            <span class="menu-arrow">
                    <i class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i>
                </span>
                        </div>
                        <div class="menu-default menu-dropdown gap-0.5 w-[220px]">
                            <!-- Administradores -->
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.users.index', ['role' => 'admin']) }}">
                        <span class="menu-icon">
                            <i class="ki-filled ki-shield-tick text-danger"></i>
                        </span>
                                    <span class="menu-title">Administradores</span>
                                </a>
                            </div>

                            <!-- Agentes -->
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.users.index', ['role' => 'agent']) }}">
                        <span class="menu-icon">
                            <i class="ki-filled ki-user-tick text-primary"></i>
                        </span>
                                    <span class="menu-title">Agentes</span>
                                </a>
                            </div>

                            <!-- Usuarios -->
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.users.index', ['role' => 'user']) }}">
                        <span class="menu-icon">
                            <i class="ki-filled ki-profile-circle text-info"></i>
                        </span>
                                    <span class="menu-title">Usuarios</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="menu-separator"></div>

                    <!-- Por Estado -->
                    <div class="menu-item" data-menu-item-placement="right-start"
                         data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">
                        <div class="menu-link grow cursor-pointer">
                <span class="menu-icon">
                    <i class="ki-filled ki-toggle-on"></i>
                </span>
                            <span class="menu-title">Por Estado</span>
                            <span class="menu-arrow">
                    <i class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i>
                </span>
                        </div>
                        <div class="menu-default menu-dropdown gap-0.5 w-[220px]">
                            <!-- Activos -->
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.users.index', ['status' => 'active']) }}">
                        <span class="menu-icon">
                            <i class="ki-filled ki-check-circle text-success"></i>
                        </span>
                                    <span class="menu-title">Activos</span>
                                </a>
                            </div>

                            <!-- Inactivos -->
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.users.index', ['status' => 'inactive']) }}">
                        <span class="menu-icon">
                            <i class="ki-filled ki-cross-circle text-danger"></i>
                        </span>
                                    <span class="menu-title">Inactivos</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- MENÚ DE INQUILINOS (desde contratos) -->
            <!-- ============================================ -->
            <div class="menu-item" data-menu-item-offset="-10px, 14px" data-menu-item-overflow="true"
                 data-menu-item-placement="right-start" data-menu-item-toggle="dropdown"
                 data-menu-item-trigger="click|lg:hover">
                <div class="menu-link rounded-[9px] border border-transparent menu-item-here:border-gray-200 menu-item-here:bg-light menu-link-hover:bg-light menu-link-hover:border-gray-200 w-[62px] h-[60px] flex flex-col justify-center items-center gap-1 p-2 grow">
        <span class="menu-icon menu-item-here:text-primary menu-item-active:text-primary menu-link-hover:text-primary text-gray-600">
            <i class="ki-filled ki-security-user text-1.5xl"></i>
        </span>
                    <span class="menu-title menu-item-here:text-primary menu-item-active:text-primary menu-link-hover:text-primary font-medium text-xs text-gray-600">
            Inquilinos
        </span>
                </div>
                <div class="menu-default menu-dropdown gap-0.5 w-[220px] scrollable-y-auto lg:overflow-visible max-h-[50vh]">
                    <!-- Todos los Contratos -->
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('backend.tenants.index') }}">
                <span class="menu-icon">
                    <i class="ki-filled ki-document"></i>
                </span>
                            <span class="menu-title">Todos los Contratos</span>
                        </a>
                    </div>

                    <!-- Inquilinos Únicos -->
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('backend.tenants.list') }}">
                <span class="menu-icon">
                    <i class="ki-filled ki-people"></i>
                </span>
                            <span class="menu-title">Inquilinos Únicos</span>
                        </a>
                    </div>

                    <div class="menu-separator"></div>

                    <!-- Por Estado de Contrato -->
                    <div class="menu-item" data-menu-item-placement="right-start"
                         data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">
                        <div class="menu-link grow cursor-pointer">
                <span class="menu-icon">
                    <i class="ki-filled ki-chart-simple"></i>
                </span>
                            <span class="menu-title">Por Estado</span>
                            <span class="menu-arrow">
                    <i class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i>
                </span>
                        </div>
                        <div class="menu-default menu-dropdown gap-0.5 w-[220px]">
                            <!-- Contratos Activos -->
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.tenants.index', ['status' => 'active']) }}">
                        <span class="menu-icon">
                            <i class="ki-filled ki-check-circle text-success"></i>
                        </span>
                                    <span class="menu-title">Activos</span>
                                </a>
                            </div>

                            <!-- Contratos Expirados -->
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.tenants.index', ['status' => 'expired']) }}">
                        <span class="menu-icon">
                            <i class="ki-filled ki-cross-circle text-danger"></i>
                        </span>
                                    <span class="menu-title">Expirados</span>
                                </a>
                            </div>

                            <!-- Contratos Terminados -->
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.tenants.index', ['status' => 'terminated']) }}">
                        <span class="menu-icon">
                            <i class="ki-filled ki-minus-circle text-gray-500"></i>
                        </span>
                                    <span class="menu-title">Terminados</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="menu-separator"></div>

                    <!-- Por Tipo de Contrato -->
                    <div class="menu-item" data-menu-item-placement="right-start"
                         data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">
                        <div class="menu-link grow cursor-pointer">
                <span class="menu-icon">
                    <i class="ki-filled ki-category"></i>
                </span>
                            <span class="menu-title">Tipo de Contrato</span>
                            <span class="menu-arrow">
                    <i class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i>
                </span>
                        </div>
                        <div class="menu-default menu-dropdown gap-0.5 w-[220px]">
                            <!-- Alquileres -->
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.tenants.index', ['contract_type' => 'rent']) }}">
                        <span class="menu-icon">
                            <i class="ki-filled ki-home-2 text-primary"></i>
                        </span>
                                    <span class="menu-title">Alquileres</span>
                                </a>
                            </div>

                            <!-- Anticréticos -->
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.tenants.index', ['contract_type' => 'anticretico']) }}">
                        <span class="menu-icon">
                            <i class="ki-filled ki-dollar text-warning"></i>
                        </span>
                                    <span class="menu-title">Anticréticos</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="menu-separator"></div>

                    <!-- Exportar -->
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('backend.tenants.export', 'csv') }}">
                <span class="menu-icon">
                    <i class="ki-filled ki-file-down"></i>
                </span>
                            <span class="menu-title">Exportar a CSV</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="menu-item" data-menu-item-offset="-10px, 14px" data-menu-item-overflow="true"
                 data-menu-item-placement="right-start" data-menu-item-toggle="dropdown"
                 data-menu-item-trigger="click|lg:hover">
                <div
                    class="menu-link rounded-[9px] border border-transparent menu-item-here:border-gray-200 menu-item-here:bg-light menu-link-hover:bg-light menu-link-hover:border-gray-200 w-[62px] h-[60px] flex flex-col justify-center items-center gap-1 p-2 grow">
          <span
              class="menu-icon menu-item-here:text-primary menu-item-active:text-primary menu-link-hover:text-primary text-gray-600">
            <i class="ki-filled ki-setting-2 text-1.5xl"></i>
          </span>
                    <span
                        class="menu-title menu-item-here:text-primary menu-item-active:text-primary menu-link-hover:text-primary font-medium text-xs text-gray-600"> Config </span>
                </div>
                <div
                    class="menu-default menu-dropdown gap-0.5 w-[220px] scrollable-y-auto lg:overflow-visible max-h-[50vh]">

                    <div class="menu-item" data-menu-item-placement="right-start"
                         data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">
                        <div class="menu-link grow cursor-pointer">
                            <span class="menu-title"> Tipo de servicios </span>
                            <span class="menu-arrow"><i
                                    class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i></span>
                        </div>
                        <div class="menu-default menu-dropdown gap-0.5 w-[220px]">
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.service-types.index') }}">
                                    <span class="menu-title"> Listado </span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.service-types.create') }}">
                                    <span class="menu-title"> Agregar </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="menu-item" data-menu-item-placement="right-start"
                         data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">
                        <div class="menu-link grow cursor-pointer">
                            <span class="menu-title"> Tipo de propiedades </span>
                            <span class="menu-arrow"><i
                                    class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i></span>
                        </div>
                        <div class="menu-default menu-dropdown gap-0.5 w-[220px]">
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.property-types.index') }}">
                                    <span class="menu-title"> Listado </span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.property-types.create') }}">
                                    <span class="menu-title"> Agregar </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="menu-item" data-menu-item-placement="right-start"
                         data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">
                        <div class="menu-link grow cursor-pointer">
                            <span class="menu-title"> Ciudades </span>
                            <span class="menu-arrow"><i
                                    class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i></span>
                        </div>
                        <div class="menu-default menu-dropdown gap-0.5 w-[220px]">
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.cities.index') }}">
                                    <span class="menu-title"> Listado </span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.cities.create') }}">
                                    <span class="menu-title"> Agregar </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="menu-item" data-menu-item-placement="right-start"
                         data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">
                        <div class="menu-link grow cursor-pointer">
                            <span class="menu-title"> Barrios </span>
                            <span class="menu-arrow"><i
                                    class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i></span>
                        </div>
                        <div class="menu-default menu-dropdown gap-0.5 w-[220px]">
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.neighborhood.index') }}">
                                    <span class="menu-title"> Listado </span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.neighborhood.create') }}">
                                    <span class="menu-title"> Agregar </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="menu-item" data-menu-item-placement="right-start"
                         data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">
                        <div class="menu-link grow cursor-pointer">
                            <span class="menu-title"> Amenities </span>
                            <span class="menu-arrow"><i
                                    class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i></span>
                        </div>
                        <div class="menu-default menu-dropdown gap-0.5 w-[220px]">
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.amenities.index') }}">
                                    <span class="menu-title"> Listado </span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.amenities.create') }}">
                                    <span class="menu-title"> Agregar </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="menu-item" data-menu-item-placement="right-start"
                         data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">
                        <div class="menu-link grow cursor-pointer">
                            <span class="menu-title"> Servicios cercanos </span>
                            <span class="menu-arrow"><i
                                    class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i></span>
                        </div>
                        <div class="menu-default menu-dropdown gap-0.5 w-[220px]">
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.facilities.index') }}">
                                    <span class="menu-title"> Listado </span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.facilities.create') }}">
                                    <span class="menu-title"> Agregar </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="menu-item" data-menu-item-placement="right-start"
                         data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">
                        <div class="menu-link grow cursor-pointer">
                            <span class="menu-title"> Paquetes </span>
                            <span class="menu-arrow"><i
                                    class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i></span>
                        </div>
                        <div class="menu-default menu-dropdown gap-0.5 w-[220px]">
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.packages.index') }}">
                                    <span class="menu-title"> Listado </span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.packages.create') }}">
                                    <span class="menu-title"> Agregar </span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('backend.configurations.index') }}">
                            <span class="menu-title"> FrontEnd(WEB) </span>
                        </a>
                    </div>


                </div>
            </div>


            <div class="menu-item" data-menu-item-offset="-10px, 14px" data-menu-item-overflow="true"
                 data-menu-item-placement="right-start" data-menu-item-toggle="dropdown"
                 data-menu-item-trigger="click|lg:hover">
                <div
                    class="menu-link rounded-[9px] border border-transparent menu-item-here:border-gray-200 menu-item-here:bg-light menu-link-hover:bg-light menu-link-hover:border-gray-200 w-[62px] h-[60px] flex flex-col justify-center items-center gap-1 p-2 grow">
                      <span
                          class="menu-icon menu-item-here:text-primary menu-item-active:text-primary menu-link-hover:text-primary text-gray-600">
                        <i class="ki-filled ki-users text-1.5xl"></i>
                      </span><span class="menu-title menu-item-here:text-primary menu-item-active:text-primary menu-link-hover:text-primary font-medium text-xs text-gray-600"> Residencias </span>
                </div>
                <div
                    class="menu-default menu-dropdown gap-0.5 w-[220px] scrollable-y-auto lg:overflow-visible max-h-[50vh]">
                    <div class="menu-item" data-menu-item-placement="right-start"
                         data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">
                        <div class="menu-link grow cursor-pointer">
                            <span class="menu-title"> Propiedades </span>
                            <span class="menu-arrow"><i
                                    class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i></span>
                        </div>
                        <div class="menu-default menu-dropdown gap-0.5 w-[220px]">
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.properties.index') }}">
                                    <span class="menu-title"> Listado </span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.properties.create') }}">
                                    <span class="menu-title"> Agregar </span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="html/demo8/network/user-cards/author.html">
                                    <span class="menu-title"> Solo Mias </span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="html/demo8/network/user-cards/nft.html">
                                    <span class="menu-title"> Inactivas </span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="html/demo8/network/user-cards/social.html">
                                    <span class="menu-title"> Cerradas </span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="html/demo8/network/user-cards/social.html">
                                    <span class="menu-title"> Canceladas </span>
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="menu-item" data-menu-item-placement="right-start"
                         data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">
                        <div class="menu-link grow cursor-pointer">
                            <span class="menu-title"> Proyectos </span>
                            <span class="menu-arrow"><i class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i></span>
                        </div>
                        <div class="menu-default menu-dropdown gap-0.5 w-[220px]">
                            <div class="menu-item">
                                <a class="menu-link" href="html/demo8/network/user-cards/mini-cards.html">
                                    <span class="menu-title"> Listado </span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="html/demo8/network/user-cards/team-crew.html">
                                    <span class="menu-title"> Agregar </span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="html/demo8/network/user-cards/author.html">
                                    <span class="menu-title"> Solo Mias </span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="html/demo8/network/user-cards/nft.html">
                                    <span class="menu-title"> Inactivas </span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="html/demo8/network/user-cards/social.html">
                                    <span class="menu-title"> Cerradas </span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="html/demo8/network/user-cards/social.html">
                                    <span class="menu-title"> Canceladas </span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('backend.properties.lastPhase.index') }}">
                            <span class="menu-title"> Residencias-Contrato </span>
                        </a>
                    </div>


                </div>
            </div>

            <div class="menu-item" data-menu-item-offset="-10px, 14px" data-menu-item-overflow="true"
                 data-menu-item-placement="right-start" data-menu-item-toggle="dropdown"
                 data-menu-item-trigger="click|lg:hover">
                <div
                    class="menu-link rounded-[9px] border border-transparent menu-item-here:border-gray-200 menu-item-here:bg-light menu-link-hover:bg-light menu-link-hover:border-gray-200 w-[62px] h-[60px] flex flex-col justify-center items-center gap-1 p-2 grow">
        <span
            class="menu-icon menu-item-here:text-primary menu-item-active:text-primary menu-link-hover:text-primary text-gray-600">
            <i class="ki-filled ki-document text-1.5xl"></i>
        </span>
                    <span
                        class="menu-title menu-item-here:text-primary menu-item-active:text-primary menu-link-hover:text-primary font-medium text-xs text-gray-600">
            Contratos
        </span>
                </div>

                <div class="menu-default menu-dropdown gap-0.5 w-[240px] scrollable-y-auto lg:overflow-visible max-h-[50vh]">

                    <!-- Ver todos los contratos -->
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('backend.contracts.index') }}">
                <span class="menu-icon">
                    <i class="ki-filled ki-file-sheet text-lg"></i>
                </span>
                            <span class="menu-title">Todos los Contratos</span>
                        </a>
                    </div>

                    <div class="menu-separator"></div>

                    <!-- Reportes -->
                    <div class="menu-item" data-menu-item-placement="right-start"
                         data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">
                        <div class="menu-link grow cursor-pointer">
                <span class="menu-icon">
                    <i class="ki-filled ki-chart-line text-lg"></i>
                </span>
                            <span class="menu-title">Reportes</span>
                            <span class="menu-arrow">
                    <i class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i>
                </span>
                        </div>
                        <div class="menu-default menu-dropdown gap-0.5 w-[220px]">
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.contracts.report', ['type' => 'active']) }}">
                                    <span class="menu-title">Contratos Activos</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.contracts.report', ['type' => 'expiring']) }}">
                                    <span class="menu-title">Por Vencer (3 meses)</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.contracts.report', ['type' => 'expired']) }}">
                                    <span class="menu-title">Vencidos</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.contracts.report', ['type' => 'rent']) }}">
                                    <span class="menu-title">Solo Alquileres</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.contracts.report', ['type' => 'anticretico']) }}">
                                    <span class="menu-title">Solo Anticréticos</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="menu-separator"></div>

                    <!-- Exportar -->
                    <div class="menu-item" data-menu-item-placement="right-start"
                         data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">
                        <div class="menu-link grow cursor-pointer">
                <span class="menu-icon">
                    <i class="ki-filled ki-exit-down text-lg"></i>
                </span>
                            <span class="menu-title">Exportar</span>
                            <span class="menu-arrow">
                    <i class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i>
                </span>
                        </div>
                        <div class="menu-default menu-dropdown gap-0.5 w-[200px]">
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.contracts.export', ['format' => 'excel']) }}">
                        <span class="menu-icon">
                            <i class="ki-filled ki-file-down text-success"></i>
                        </span>
                                    <span class="menu-title">Excel (.xlsx)</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.contracts.export', ['format' => 'pdf']) }}">
                        <span class="menu-icon">
                            <i class="ki-filled ki-file-down text-danger"></i>
                        </span>
                                    <span class="menu-title">PDF</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.contracts.export', ['format' => 'csv']) }}">
                        <span class="menu-icon">
                            <i class="ki-filled ki-file-down text-info"></i>
                        </span>
                                    <span class="menu-title">CSV</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="menu-separator"></div>

                    <!-- Alertas y Configuración -->
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('backend.contracts.alerts') }}">
                <span class="menu-icon">
                    <i class="ki-filled ki-notification-on text-lg"></i>
                </span>
                            <span class="menu-title">Alertas de Vencimiento</span>
                            @php
                                $alertCount = \App\Models\PropertyContract::expiringIn(3)->count();
                            @endphp
                            @if($alertCount > 0)
                                <span class="badge badge-sm badge-warning">{{ $alertCount }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Sidebar Menu -->
    </div>


    <!-- ============================================ -->
    <!-- SIDEBAR FOOTER - Menú de Perfil de Usuario -->
    <!-- ============================================ -->
    <div class="flex flex-col gap-5 items-center shrink-0 pb-4" id="sidebar_footer">
        <div class="menu" data-menu="true">
            <div class="menu-item" data-menu-item-offset="-20px, 28px" data-menu-item-overflow="true"
                 data-menu-item-placement="right-end" data-menu-item-toggle="dropdown"
                 data-menu-item-trigger="click|lg:click">
                <div class="menu-toggle btn btn-icon">
                    @if(auth()->user()->photo)
                        <img alt="{{ auth()->user()->full_name }}"
                             class="size-8 justify-center rounded-lg border border-gray-500 shrink-0"
                             src="{{ asset('storage/' . auth()->user()->photo) }}">
                    @else
                        <div class="size-8 justify-center rounded-lg border border-gray-500 shrink-0 bg-primary-light flex items-center">
                            <span class="text-primary font-bold text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                    @endif
                </div>
                <div class="menu-dropdown menu-default light:border-gray-300 w-screen max-w-[250px]">
                    <!-- Header con info del usuario -->
                    <div class="flex items-center justify-between px-5 py-1.5 gap-1.5">
                        <div class="flex items-center gap-2">
                            @if(auth()->user()->photo)
                                <img alt="{{ auth()->user()->full_name }}"
                                     class="size-9 rounded-full border-2 border-success"
                                     src="{{ asset('storage/' . auth()->user()->photo) }}">
                            @else
                                <div class="size-9 rounded-full border-2 border-success bg-primary-light flex items-center justify-center">
                                    <span class="text-primary font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <div class="flex flex-col gap-1.5">
                                <span class="text-sm text-gray-800 font-semibold leading-none">{{ auth()->user()->full_name }}</span>
                                <a class="text-xs text-gray-600 hover:text-primary font-medium leading-none"
                                   href="{{ route('profile.edit') }}">{{ auth()->user()->email }}</a>
                            </div>
                        </div>
                        @php
                            $roleColors = [
                                'admin' => 'danger',
                                'agent' => 'primary',
                                'user' => 'info'
                            ];
                            $roleLabels = [
                                'admin' => 'Admin',
                                'agent' => 'Agente',
                                'user' => 'Usuario'
                            ];
                        @endphp
                        <span class="badge badge-xs badge-{{ $roleColors[auth()->user()->role] ?? 'light' }} badge-outline">
                        {{ $roleLabels[auth()->user()->role] ?? 'Usuario' }}
                    </span>
                    </div>
                    <div class="menu-separator"></div>

                    <!-- Menú Principal -->
                    <div class="flex flex-col">
                        <!-- Mi Perfil -->
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('profile.edit') }}">
                            <span class="menu-icon">
                                <i class="ki-filled ki-profile-circle"></i>
                            </span>
                                <span class="menu-title">Mi Perfil</span>
                            </a>
                        </div>

                        <!-- Mis Propiedades (solo para agentes) -->
                        @if(auth()->user()->role === 'agent')
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.properties.index', ['agent_id' => auth()->id()]) }}">
                            <span class="menu-icon">
                                <i class="ki-filled ki-home-2"></i>
                            </span>
                                    <span class="menu-title">Mis Propiedades</span>
                                    <span class="badge badge-sm badge-primary">
                                {{ auth()->user()->properties()->count() }}
                            </span>
                                </a>
                            </div>
                        @endif

                        <!-- Mi Cuenta (Submenu) -->
                        <div class="menu-item" data-menu-item-offset="-50px, 0" data-menu-item-placement="left-start"
                             data-menu-item-placement-rtl="right-start" data-menu-item-toggle="dropdown"
                             data-menu-item-trigger="click|lg:hover">
                            <div class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-filled ki-setting-2"></i>
                            </span>
                                <span class="menu-title">Mi Cuenta</span>
                                <span class="menu-arrow">
                                <i class="ki-filled ki-right text-3xs rtl:transform rtl:rotate-180"></i>
                            </span>
                            </div>
                            <div class="menu-dropdown menu-default light:border-gray-300 w-full max-w-[220px]">
                                <!-- Información Personal -->
                                <div class="menu-item">
                                    <a class="menu-link" href="{{ route('profile.edit') }}">
                                    <span class="menu-icon">
                                        <i class="ki-filled ki-profile-user"></i>
                                    </span>
                                        <span class="menu-title">Información Personal</span>
                                    </a>
                                </div>

                                <!-- Cambiar Contraseña -->
                                <div class="menu-item">
                                    <a class="menu-link" href="{{ route('profile.edit') }}#password">
                                    <span class="menu-icon">
                                        <i class="ki-filled ki-key"></i>
                                    </span>
                                        <span class="menu-title">Cambiar Contraseña</span>
                                    </a>
                                </div>

                                <!-- Mi Paquete -->
                                @if(auth()->user()->package)
                                    <div class="menu-item">
                                        <a class="menu-link" href="#">
                                    <span class="menu-icon">
                                        <i class="ki-filled ki-award"></i>
                                    </span>
                                            <span class="menu-title">Mi Paquete</span>
                                            <span class="badge badge-sm badge-success">
                                        {{ auth()->user()->package->name }}
                                    </span>
                                        </a>
                                    </div>
                                @endif

                                <div class="menu-separator"></div>

                                <!-- Estadísticas (solo agentes) -->
                                @if(auth()->user()->role === 'agent')
                                    <div class="menu-item">
                                        <a class="menu-link" href="{{ route('backend.properties.index') }}">
                                    <span class="menu-icon">
                                        <i class="ki-filled ki-chart-line"></i>
                                    </span>
                                            <span class="menu-title">Mis Estadísticas</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Gestión de Usuarios (solo admins) -->
                        @if(auth()->user()->role === 'admin')
                            <div class="menu-separator"></div>
                            <div class="menu-item">
                                <a class="menu-link" href="{{ route('backend.users.index') }}">
                            <span class="menu-icon">
                                <i class="ki-filled ki-people"></i>
                            </span>
                                    <span class="menu-title">Gestionar Usuarios</span>
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="menu-separator"></div>

                    <!-- Dark Mode y Logout -->
                    <div class="flex flex-col">
                        <div class="menu-item mb-0.5">
                            <div class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-filled ki-moon"></i>
                            </span>
                                <span class="menu-title">Modo Oscuro</span>
                                <label class="switch switch-sm">
                                    <input data-theme-state="dark" data-theme-toggle="true" name="check" type="checkbox" value="1">
                                </label>
                            </div>
                        </div>
                        <div class="menu-item px-4 py-1.5">
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-light justify-center w-full">
                                    <i class="ki-filled ki-exit-left"></i>
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
