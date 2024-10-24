{{-- auto form (Channel, sub-channel) --}}
<div class="col-md-6 col-6 col-xl-6 col-lg-6 col-xs-6">
    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <label class="fs-6 fw-semibold mb-2">Phân loại nguồn</label>
        <input class="bg-light form-control border-0 pe-none rounded fw-bold" type="text" name="source_type" value="{{ $sourceType }}">
    </div>
</div>

<div class="col-md-6 col-6 col-xl-6 col-lg-6 col-xs-6">
    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <label class="fs-6 fw-semibold mb-2">Channel</label>
        <input class="bg-light form-control border-0 pe-none rounded fw-bold" type="text" name="channel" value="{{ $channel }}">
    </div>
</div>

@if ($sourceType && !in_array($sourceType, \App\Helpers\SourceDataFunctions::SOURCE_TYPES_THAT_NOT_SHOW_DETAIL_DATA))
    <div class="row p-0 m-0" id="source-data-form">
        <hr class="mt-5 mb-7 fs-1 fw-bold m-auto" style="max-width: 97%">
        <div class="col-md-6" list-action='show'>
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Adset</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text"
                    data-source="source-item"
                    class="form-control rounded @if ($errors->has('adset')) is-invalid @endif" name="adset"
                    placeholder="" value="{{ isset($contactRequestData['adset']) ? $contactRequestData['adset'] : '' }}"/>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        <div class="col-md-6 " list-action='show'>
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Ads</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text"
                    data-source="source-item"
                    class="form-control rounded @if ($errors->has('ads')) is-invalid @endif" name="ads"
                    placeholder="" value="{{ isset($contactRequestData['ads']) ? $contactRequestData['ads'] : '' }}"/>
                <!--end::Input-->
            </div>
        </div>
        
        <div class="col-md-6" list-action='show'>
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Term</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text"
                    data-source="source-item"
                    class="form-control rounded @if ($errors->has('term')) is-invalid @endif" name="term"
                    placeholder="" value="{{ isset($contactRequestData['term']) ? $contactRequestData['term'] : '' }}"/>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        <div class="col-md-6" list-action='show'>
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Type Match</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text"
                    data-source="source-item"
                    class="form-control rounded @if ($errors->has('type_match')) is-invalid @endif"
                    name="type_match" placeholder="" value="{{ isset($contactRequestData['type_match']) ? $contactRequestData['type_match'] : '' }}"/>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        <div class="col-md-6" list-action='show'>
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">First URL</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text"
                    data-source="source-item"
                    class="form-control rounded @if ($errors->has('first_url')) is-invalid @endif"
                    name="first_url" placeholder="" value="{{ isset($contactRequestData['first_url']) ? $contactRequestData['first_url'] : '' }}"/>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        <div class="col-md-6" list-action='show'>
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Conversion Url</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text"
                    data-source="source-item"
                    class="form-control rounded @if ($errors->has('last_url')) is-invalid @endif" name="last_url"
                    placeholder="" value="{{ isset($contactRequestData['last_url']) ? $contactRequestData['last_url'] : '' }}"/>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
    </div>
@endif