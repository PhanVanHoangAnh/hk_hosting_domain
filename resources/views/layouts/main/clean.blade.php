<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic
Product Version: 8.2.0
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
	<!--begin::Head-->
	<head><base href="../../../"/>
		<title>HKI - Hoàng Khang Incotech</title>
		<meta charset="utf-8" />

		<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
		<link rel="shortcut icon" href="{{ url('/core/assets/media/logos/favicon.ico') }}?v=2" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ url('/core/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ url('/core/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
		<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>

        <!--begin::ASMS Bundle(mandatory for all pages)-->
        <link href="{{ url('/css/asms.css') }}?v={{ \App\Helpers\Functions::assetVersion() }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

        <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"
            integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
        <!--end::ASMS Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank">
		@include('layouts.main._login_back')
		
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->

        @yield('content')

		<!--begin::Javascript-->
		<script>var hostUrl = "{{ url('/core/assets/') }}";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{ url('/core/assets/plugins/global/plugins.bundle.js') }}?v=1"></script>
		<script src="{{ url('/core/assets/js/scripts.bundle.js') }}"></script>
		<!--end::Global Javascript Bundle-->

        <!--begin::Global Javascript AS(mandatory for all pages)-->
        <script src="{{ url('/js/popup.js') }}?v=13"></script>
        <script src="{{ url('/js/astool.js') }}"></script>
        <!--end::Global Javascript AS-->

        @section('footer')

		<!--end::Javascript-->

        <!--begin::Custom Script-->
        <script>
            $(function() {
				@if (config('app.demo'))
					$(document).on('click', '[data-action="under-construction"]', function(e) {
						e.preventDefault();
						var popup = new Popup({
							url: '{{ action([App\Http\Controllers\Controller::class, 'underConstruction']) }}',
						});
						popup.load();
					});
				@endif
            });
        </script>
        <!--end::Custom Script-->
	</body>
	<!--end::Body-->
</html>