<header class="flex lg:hidden items-center fixed z-10 top-0 start-0 end-0 shrink-0 bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark] h-[--tw-header-height]" id="header">
    <!-- Container -->
    <div class="container-fixed flex items-center justify-between flex-wrap gap-3">
        <a href="{{ route('dashboard') }}">
            @if($logo_internal)
                <img class="min-h-[30px] max-h-[35px] w-auto"
                     src="{{ asset($logo_internal['path']) }}"
                     alt="{{ config('app.name') }}"/>
            @else
                <!-- Fallback to default logos if no custom logo is set -->
                <img class="dark:hidden min-h-[30px]" src="{{ asset('assets/media/app/mini-logo-gray.svg') }}" alt=""/>
                <img class="hidden dark:block min-h-[30px]" src="{{ asset('assets/media/app/mini-logo-gray-dark.svg') }}" alt=""/>
            @endif
        </a>
        <button class="btn btn-icon btn-light btn-clear btn-sm -me-1" data-drawer-toggle="#sidebar">
            <i class="ki-filled ki-menu">
            </i>
        </button>
    </div>
    <!-- End of Container -->
</header>
