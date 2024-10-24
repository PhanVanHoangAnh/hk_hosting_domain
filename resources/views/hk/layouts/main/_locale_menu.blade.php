<div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
    data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">

    @if (app()->getLocale() == 'vi')
        <a data-action="under-construction" href="{{ route('setLocale', ['locale' => 'vi']) }}" class="menu-link px-5">
            <span class="menu-title position-relative">Ngôn ngữ
                <span
                    class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">Tiếng
                    Việt
                    <img class="w-15px h-15px rounded-1 ms-2"
                        src="{{ url('/core/assets/media/flags/vietnam.svg') }}"
                        alt="" /></span></span>
        </a>
    @else
        <a data-action="under-construction" href="{{ route('setLocale', ['locale' => 'en']) }}" class="menu-link px-5">
            <span class="menu-title position-relative">Ngôn ngữ
                <span
                    class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">English
                    <img class="w-15px h-15px rounded-1 ms-2"
                        src="{{ url('/core/assets/media/flags/united-states.svg') }}"
                        alt="" /></span></span>
        </a>
    @endif
    <!--begin::Menu sub-->
    <div class="menu-sub menu-sub-dropdown w-175px py-4">
        <!--begin::Menu item-->
        <div class="menu-item px-3">
            <a href="{{ route('setLocale', ['locale' => 'vi']) }}" class="menu-link d-flex px-5 {{ app()->getLocale() == 'vi' ? 'active' : '' }}">
                <span class="symbol symbol-20px me-4">
                    <img class="rounded-1"
                        src="{{ url('/core/assets/media/flags/vietnam.svg') }}"
                        alt="" />
                </span>Tiếng Việt</a>
        </div>
        <div class="menu-item px-3">
            <a data-action="under-construction" href="{{ route('setLocale', ['locale' => 'en']) }}"
                class="menu-link d-flex px-5  {{ app()->getLocale() == 'en' ? 'active' : '' }}">
                <span class="symbol symbol-20px me-4">
                    <img class="rounded-1"
                        src="{{ url('/core/assets/media/flags/united-states.svg') }}"
                        alt="" />
                </span>English</a>
        </div>
        <!--end::Menu item-->

    </div>
    <!--end::Menu sub-->
</div>