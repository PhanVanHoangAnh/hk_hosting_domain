<div class="image-uploder">
    <!--begin::Label-->
    <label class="required fs-6 fw-semibold mb-2">Hình ảnh</label>
    <!--end::Label-->
    <div>
        <!--begin::Image input-->
        <div class="image-input image-input-empty" data-kt-image-input="true">
            
            <!--begin::Image preview wrapper-->
            <div class="image-input-placeholder image-input-wrapper w-125px h-125px border">
            </div>
            <!--end::Image preview wrapper-->

            @if ($noteLog->hasImage())
                <div class="current-image d-flex justify-content-center" style="
    position: absolute;
    top: 0;">
                    <img class="border rounded" src="{{ $noteLog->getUploadImage() }}?v={{ now()->timestamp }}" style="
                        max-width: 125px;
                        max-height: 125px;
                        min-height: 100px;
                    ">
                </div>
            @endif

            <!--begin::Edit button-->
            <label
                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click"
                title="Change image">
                <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span
                        class="path2"></span></i>

                <!--begin::Inputs-->
                <input type="file" name="image" accept=".png, .jpg, .jpeg" onchange="$(this).closest('.image-uploder').find('.current-image').remove();" />
                <input type="hidden" name="image_remove" />
                <!--end::Inputs-->
            </label>
            <!--end::Edit button-->

            <!--begin::Cancel button-->
            <span
                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                data-kt-image-input-action="cancel" data-bs-dismiss="click"
                title="">
                <i class="ki-outline ki-cross fs-3"></i>
            </span>
            <!--end::Cancel button-->
        </div>
        <!--end::Image input-->
    </div>
    <x-input-error :messages="$errors->get('image')" class="mt-2" />
</div>