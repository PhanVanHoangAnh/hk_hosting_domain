<!--begin::Javascript-->
<script>
    var hostUrl = "{{ url('/core/assets/') }}";
    var leadStatusValues = {!! json_encode(config('leadStatusValues')) !!}
    var contactSources = {!! json_encode(App\Helpers\Functions::getJsSourceTypes()) !!}
</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ url('/core/assets/plugins/global/plugins.bundle.js') }}?v=1"></script>
<script src="{{ url('/core/assets/js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->

<!--begin::Global Javascript AS(mandatory for all pages)-->
<script src="{{ url('/js/popup.js') }}?v=13"></script>
<script src="{{ url('/js/SourceDataManager.js') }}?v=1"></script>
<script src="{{ url('/js/ScrollToErrorManager.js') }}"></script>
<script src="{{ url('/js/astool.js') }}"></script>
<script src="{{ url('/js/anotify.js') }}?v=16"></script>
<!--end::Global Javascript AS-->