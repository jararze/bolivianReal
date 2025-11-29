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

{{--            <div class="menu-item" data-menu-item-offset="-10px, 14px" data-menu-item-overflow="true"--}}
{{--                 data-menu-item-placement="right-start" data-menu-item-toggle="dropdown"--}}
{{--                 data-menu-item-trigger="click|lg:hover">--}}
{{--                <div--}}
{{--                    class="menu-link rounded-[9px] border border-transparent menu-item-here:border-gray-200 menu-item-here:bg-light menu-link-hover:bg-light menu-link-hover:border-gray-200 w-[62px] h-[60px] flex flex-col justify-center items-center gap-1 p-2 grow">--}}
{{--                      <span--}}
{{--                          class="menu-icon menu-item-here:text-primary menu-item-active:text-primary menu-link-hover:text-primary text-gray-600">--}}
{{--                        <i class="ki-filled ki-profile-circle text-1.5xl"></i>--}}
{{--                      </span>--}}
{{--                    <span--}}
{{--                        class="menu-title menu-item-here:text-primary menu-item-active:text-primary menu-link-hover:text-primary font-medium text-xs text-gray-600"> Profiles </span>--}}
{{--                </div>--}}
{{--                <div--}}
{{--                    class="menu-default menu-dropdown gap-0.5 w-[220px] scrollable-y-auto lg:overflow-visible max-h-[50vh]">--}}
{{--                    <div class="menu-item" data-menu-item-placement="right-start"--}}
{{--                         data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">--}}
{{--                        <div class="menu-link grow cursor-pointer">--}}
{{--                            <span class="menu-title"> Profiles </span>--}}
{{--                            <span class="menu-arrow"><i--}}
{{--                                    class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i></span>--}}
{{--                        </div>--}}
{{--                        <div class="menu-default menu-dropdown gap-0.5 w-[220px]">--}}
{{--                            <div class="menu-item">--}}
{{--                                <a class="menu-link" href="html/demo8/public-profile/profiles/default.html">--}}
{{--                                    <span class="menu-title"> Default </span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="menu-item">--}}
{{--                                <a class="menu-link" href="html/demo8/public-profile/profiles/creator.html">--}}
{{--                                    <span class="menu-title"> Creator </span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="menu-item">--}}
{{--                                <a class="menu-link" href="html/demo8/public-profile/profiles/company.html">--}}
{{--                                    <span class="menu-title"> Company </span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="menu-item">--}}
{{--                                <a class="menu-link" href="html/demo8/public-profile/profiles/nft.html">--}}
{{--                                    <span class="menu-title"> NFT </span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="menu-item">--}}
{{--                                <a class="menu-link" href="html/demo8/public-profile/profiles/blogger.html">--}}
{{--                                    <span class="menu-title"> Blogger </span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="menu-item">--}}
{{--                                <a class="menu-link" href="html/demo8/public-profile/profiles/crm.html">--}}
{{--                                    <span class="menu-title"> CRM </span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="menu-item" data-menu-item-placement="right-start"--}}
{{--                                 data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">--}}
{{--                                <div class="menu-link grow cursor-pointer">--}}
{{--                                    <span class="menu-title"> More </span>--}}
{{--                                    <span class="menu-arrow">--}}
{{--                    <i class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i>--}}
{{--                  </span>--}}
{{--                                </div>--}}
{{--                                <div class="menu-default menu-dropdown gap-0.5 w-[220px]">--}}
{{--                                    <div class="menu-item">--}}
{{--                                        <a class="menu-link" href="html/demo8/public-profile/profiles/gamer.html">--}}
{{--                                            <span class="menu-title"> Gamer </span>--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                    <div class="menu-item">--}}
{{--                                        <a class="menu-link" href="html/demo8/public-profile/profiles/feeds.html">--}}
{{--                                            <span class="menu-title"> Feeds </span>--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                    <div class="menu-item">--}}
{{--                                        <a class="menu-link" href="html/demo8/public-profile/profiles/plain.html">--}}
{{--                                            <span class="menu-title"> Plain </span>--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                    <div class="menu-item">--}}
{{--                                        <a class="menu-link" href="html/demo8/public-profile/profiles/modal.html">--}}
{{--                                            <span class="menu-title"> Modal </span>--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="menu-item" data-menu-item-placement="right-start"--}}
{{--                         data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">--}}
{{--                        <div class="menu-link grow cursor-pointer">--}}
{{--                            <span class="menu-title"> Projects </span>--}}
{{--                            <span class="menu-arrow">--}}
{{--                <i class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i>--}}
{{--              </span>--}}
{{--                        </div>--}}
{{--                        <div class="menu-default menu-dropdown gap-0.5 w-[220px]">--}}
{{--                            <div class="menu-item">--}}
{{--                                <a class="menu-link" href="html/demo8/public-profile/projects/3-columns.html">--}}
{{--                                    <span class="menu-title"> 3 Columns </span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="menu-item">--}}
{{--                                <a class="menu-link" href="html/demo8/public-profile/projects/2-columns.html">--}}
{{--                                    <span class="menu-title"> 2 Columns </span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="menu-item">--}}
{{--                        <a class="menu-link" href="html/demo8/public-profile/works.html">--}}
{{--                            <span class="menu-title"> Works </span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <div class="menu-item">--}}
{{--                        <a class="menu-link" href="html/demo8/public-profile/teams.html">--}}
{{--                            <span class="menu-title"> Teams </span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <div class="menu-item">--}}
{{--                        <a class="menu-link" href="html/demo8/public-profile/network.html">--}}
{{--                            <span class="menu-title"> Network </span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <div class="menu-item">--}}
{{--                        <a class="menu-link" href="html/demo8/public-profile/activity.html">--}}
{{--                            <span class="menu-title"> Activity </span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <div class="menu-item" data-menu-item-placement="right-start"--}}
{{--                         data-menu-item-toggle="accordion|lg:dropdown" data-menu-item-trigger="click|lg:hover">--}}
{{--                        <div class="menu-link grow cursor-pointer">--}}
{{--                            <span class="menu-title"> More </span>--}}
{{--                            <span class="menu-arrow">--}}
{{--                <i class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"></i>--}}
{{--              </span>--}}
{{--                        </div>--}}
{{--                        <div class="menu-default menu-dropdown gap-0.5 w-[220px]">--}}
{{--                            <div class="menu-item">--}}
{{--                                <a class="menu-link" href="html/demo8/public-profile/campaigns/card.html">--}}
{{--                                    <span class="menu-title"> Campaigns - Card </span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="menu-item">--}}
{{--                                <a class="menu-link" href="html/demo8/public-profile/campaigns/list.html">--}}
{{--                                    <span class="menu-title"> Campaigns - List </span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="menu-item">--}}
{{--                                <a class="menu-link" href="html/demo8/public-profile/empty.html">--}}
{{--                                    <span class="menu-title"> Empty </span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

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


    <div class="flex flex-col gap-5 items-center shrink-0 pb-4" id="sidebar_footer">
        <div class="menu" data-menu="true">
            <div class="menu-item" data-menu-item-offset="-20px, 28px" data-menu-item-overflow="true"
                 data-menu-item-placement="right-end" data-menu-item-toggle="dropdown"
                 data-menu-item-trigger="click|lg:click">
                <div class="menu-toggle btn btn-icon">
                    <img alt="" class="size-8 justify-center rounded-lg border border-gray-500 shrink-0"
                         src="assets/media/avatars/gray/5.png"></img>
                </div>
                <div class="menu-dropdown menu-default light:border-gray-300 w-screen max-w-[250px]">
                    <div class="flex items-center justify-between px-5 py-1.5 gap-1.5">
                        <div class="flex items-center gap-2">
                            <img alt="" class="size-9 rounded-full border-2 border-success"
                                 src="assets/media/avatars/300-2.png">
                            <div class="flex flex-col gap-1.5">
                                <span class="text-sm text-gray-800 font-semibold leading-none"> Cody Fisher </span>
                                <a class="text-xs text-gray-600 hover:text-primary font-medium leading-none"
                                   href="html/demo8/account/home/get-started.html"> c.fisher@gmail.com </a>
                            </div>
                            </img>
                        </div>
                        <span class="badge badge-xs badge-primary badge-outline"> Pro </span>
                    </div>
                    <div class="menu-separator"></div>
                    <div class="flex flex-col">
                        <div class="menu-item">
                            <a class="menu-link" href="html/demo8/public-profile/profiles/default.html">
                <span class="menu-icon">
                  <i class="ki-filled ki-badge"></i>
                </span>
                                <span class="menu-title"> Public Profile </span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="html/demo8/account/home/user-profile.html">
                <span class="menu-icon">
                  <i class="ki-filled ki-profile-circle"></i>
                </span>
                                <span class="menu-title"> My Profile </span>
                            </a>
                        </div>
                        <div class="menu-item" data-menu-item-offset="-50px, 0" data-menu-item-placement="left-start"
                             data-menu-item-placement-rtl="right-start" data-menu-item-toggle="dropdown"
                             data-menu-item-trigger="click|lg:hover">
                            <div class="menu-link">
                <span class="menu-icon">
                  <i class="ki-filled ki-setting-2"></i>
                </span>
                                <span class="menu-title"> My Account </span>
                                <span class="menu-arrow">
                  <i class="ki-filled ki-right text-3xs rtl:transform rtl:rotate-180"></i>
                </span>
                            </div>
                            <div class="menu-dropdown menu-default light:border-gray-300 w-full max-w-[220px]">
                                <div class="menu-item">
                                    <a class="menu-link" href="html/demo8/account/home/get-started.html">
                    <span class="menu-icon">
                      <i class="ki-filled ki-coffee"></i>
                    </span>
                                        <span class="menu-title"> Get Started </span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link" href="html/demo8/account/home/user-profile.html">
                    <span class="menu-icon">
                      <i class="ki-filled ki-some-files"></i>
                    </span>
                                        <span class="menu-title"> My Profile </span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link" href="#">
                    <span class="menu-icon">
                      <i class="ki-filled ki-icon"></i>
                    </span>
                                        <span class="menu-title"> Billing </span>
                                        <span class="menu-badge" data-tooltip="true" data-tooltip-placement="top">
                      <i class="ki-filled ki-information-2 text-md text-gray-500"></i>
                      <span class="tooltip" data-tooltip-content="true"> Payment and subscription info </span>
                    </span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link" href="html/demo8/account/security/overview.html">
                    <span class="menu-icon">
                      <i class="ki-filled ki-medal-star"></i>
                    </span>
                                        <span class="menu-title"> Security </span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link" href="html/demo8/account/members/teams.html">
                    <span class="menu-icon">
                      <i class="ki-filled ki-setting"></i>
                    </span>
                                        <span class="menu-title"> Members & Roles </span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link" href="html/demo8/account/integrations.html">
                    <span class="menu-icon">
                      <i class="ki-filled ki-switch"></i>
                    </span>
                                        <span class="menu-title"> Integrations </span>
                                    </a>
                                </div>
                                <div class="menu-separator"></div>
                                <div class="menu-item">
                                    <a class="menu-link" href="html/demo8/account/security/overview.html">
                    <span class="menu-icon">
                      <i class="ki-filled ki-shield-tick"></i>
                    </span>
                                        <span class="menu-title"> Notifications </span>
                                        <label class="switch switch-sm">
                                            <input checked="" name="check" type="checkbox" value="1"></input>
                                        </label>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="https://devs.keenthemes.com">
                <span class="menu-icon">
                  <i class="ki-filled ki-message-programming"></i>
                </span>
                                <span class="menu-title"> Dev Forum </span>
                            </a>
                        </div>
                        <div class="menu-item" data-menu-item-offset="-10px, 0" data-menu-item-placement="left-start"
                             data-menu-item-toggle="dropdown" data-menu-item-trigger="click|lg:hover">
                            <div class="menu-link">
                <span class="menu-icon">
                  <i class="ki-filled ki-icon"></i>
                </span>
                                <span class="menu-title"> Language </span>
                                <div
                                    class="flex items-center gap-1.5 rounded-md border border-gray-300 text-gray-600 p-1.5 text-2xs font-medium shrink-0">
                                    English <img alt="" class="inline-block size-3.5 rounded-full"
                                                 src="assets/media/flags/united-states.svg"/>
                                </div>
                            </div>
                            <div class="menu-dropdown menu-default light:border-gray-300 w-full max-w-[170px]">
                                <div class="menu-item active">
                                    <a class="menu-link h-10" href="?dir=ltr">
                    <span class="menu-icon">
                      <img alt="" class="inline-block size-4 rounded-full" src="assets/media/flags/united-states.svg"/>
                    </span>
                                        <span class="menu-title"> English </span>
                                        <span class="menu-badge">
                      <i class="ki-solid ki-check-circle text-success text-base"></i>
                    </span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link h-10" href="?dir=rtl">
                    <span class="menu-icon">
                      <img alt="" class="inline-block size-4 rounded-full" src="assets/media/flags/saudi-arabia.svg"/>
                    </span>
                                        <span class="menu-title"> Arabic(Saudi) </span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link h-10" href="?dir=ltr">
                    <span class="menu-icon">
                      <img alt="" class="inline-block size-4 rounded-full" src="assets/media/flags/spain.svg"/>
                    </span>
                                        <span class="menu-title"> Spanish </span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link h-10" href="?dir=ltr">
                    <span class="menu-icon">
                      <img alt="" class="inline-block size-4 rounded-full" src="assets/media/flags/germany.svg"/>
                    </span>
                                        <span class="menu-title"> German </span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link h-10" href="?dir=ltr">
                    <span class="menu-icon">
                      <img alt="" class="inline-block size-4 rounded-full" src="assets/media/flags/japan.svg"/>
                    </span>
                                        <span class="menu-title"> Japanese </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="menu-separator"></div>
                    <div class="flex flex-col">
                        <div class="menu-item mb-0.5">
                            <div class="menu-link">
                <span class="menu-icon">
                  <i class="ki-filled ki-moon"></i>
                </span>
                                <span class="menu-title"> Dark Mode </span>
                                <label class="switch switch-sm">
                                    <input data-theme-state="dark" data-theme-toggle="true" name="check" type="checkbox"
                                           value="1"></input>
                                </label>
                            </div>
                        </div>
                        <div class="menu-item px-4 py-1.5">
                            <a class="btn btn-sm btn-light justify-center"
                               href="html/demo8/authentication/classic/sign-in.html"> Log out </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
