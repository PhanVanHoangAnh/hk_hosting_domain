<!--begin::Toggle-->
@if (app()->getLocale() == 'vi')
    <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base"
        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
        <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3"
            src="{{ url('/core/assets/media/flags/vietnam.svg') }}" alt="" />
        <span data-kt-element="current-lang-name" class="me-1">Tiếng Việt</span>
        <span class="d-flex flex-center rotate-180">
            <i class="ki-outline ki-down fs-5 text-muted m-0"></i>
        </span>
    </button>
@else
    <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base"
        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
        <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3"
            src="{{ url('/core/assets/media/flags/united-states.svg') }}" alt="" />
        <span data-kt-element="current-lang-name" class="me-1">English</span>
        <span class="d-flex flex-center rotate-180">
            <i class="ki-outline ki-down fs-5 text-muted m-0"></i>
        </span>
    </button>
@endif

<!--end::Toggle-->
<!--begin::Menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7"
    data-kt-menu="true" id="kt_auth_lang_menu">

    @if (app()->getLocale() != 'en')
        <!--begin::Menu item-->
        <div class="menu-item px-3">
            <a data-action="under-construction" href="{{ route('setLocale', ['locale' => 'en']) }}"
                class="menu-link d-flex px-5" data-kt-lang="English">
                <span class="symbol symbol-20px me-4">
                    <img data-kt-element="lang-flag" class="rounded-1"
                        src="{{ url('/core/assets/media/flags/united-states.svg') }}" alt="" />
                </span>
                <span data-kt-element="lang-name">English</span>
            </a>
        </div>
        <!--end::Menu item-->
    @endif

    @if (app()->getLocale() != 'vi')
        <!--begin::Menu item-->
        <div class="menu-item px-3">
            <a data-action="under-construction" href="{{ route('setLocale', ['locale' => 'vi']) }}"
                class="menu-link d-flex px-5" data-kt-lang="English">
                <span class="symbol symbol-20px me-4">
                    <img data-kt-element="lang-flag" class="rounded-1"
                        src="{{ url('/core/assets/media/flags/vietnam.svg') }}" alt="" />
                </span>
                <span data-kt-element="lang-name">Tiếng Việt</span>
            </a>
        </div>
        <!--end::Menu item-->
    @endif
    {{-- <!--begin::Menu item-->
<div class="menu-item px-3">
<a href="#" class="menu-link d-flex px-5" data-kt-lang="Spanish">
    <span class="symbol symbol-20px me-4">
        <img data-kt-element="lang-flag" class="rounded-1" src="{{ url('/core/assets/media/flags/spain.svg') }}"
alt="" />
</span>
<span data-kt-element="lang-name">Spanish</span>
</a>
</div>
<!--end::Menu item-->
<!--begin::Menu item-->
<div class="menu-item px-3">
<a href="#" class="menu-link d-flex px-5" data-kt-lang="German">
    <span class="symbol symbol-20px me-4">
        <img data-kt-element="lang-flag" class="rounded-1"
            src="{{ url('/core/assets/media/flags/germany.svg') }}" alt="" />
    </span>
    <span data-kt-element="lang-name">German</span>
</a>
</div>
<!--end::Menu item-->
<!--begin::Menu item-->
<div class="menu-item px-3">
<a href="#" class="menu-link d-flex px-5" data-kt-lang="Japanese">
    <span class="symbol symbol-20px me-4">
        <img data-kt-element="lang-flag" class="rounded-1"
            src="{{ url('/core/assets/media/flags/japan.svg') }}" alt="" />
    </span>
    <span data-kt-element="lang-name">Japanese</span>
</a>
</div>
<!--end::Menu item-->
<!--begin::Menu item-->
<div class="menu-item px-3">
<a href="#" class="menu-link d-flex px-5" data-kt-lang="French">
    <span class="symbol symbol-20px me-4">
        <img data-kt-element="lang-flag" class="rounded-1"
            src="{{ url('/core/assets/media/flags/france.svg') }}" alt="" />
    </span>
    <span data-kt-element="lang-name">French</span>
</a>
</div>
<!--end::Menu item--> --}}
</div>
<!--end::Menu-->
