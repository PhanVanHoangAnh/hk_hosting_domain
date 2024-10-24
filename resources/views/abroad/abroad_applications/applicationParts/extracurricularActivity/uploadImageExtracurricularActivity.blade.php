@extends('layouts.main.popup', [
    'size' => 'full',
])

@section('title')
   Hình ảnh ngoại khóa
@endsection
@php
    $formId = 'upload-image-exreacurricualar-' . uniqid();
@endphp
@section('content')
    <!--begin::Card body--> 
    <form id="{{$formId}}" tabindex="-1" class="pe-7 py-10 px-lg-17" >
        @csrf 
        <div class="" form-data="exreacurricualar-student-manager-container"
            data-upload-url="{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'storeUploadImageExtracurricularActivity'], ['id' => $extracurricularStudent->id]) }}"
            data-delete-url="{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'deleteUploadImageExtracurricularActivity'], ['id' => $extracurricularStudent->id]) }}">
            <div class="row d-flex justify-content-around">
                
                <div class="col-md-8">
                    <label class="fs-6 fw-bold fs-4 px-10">
                        <button action-control="upload-exreacurricualar-student-btn"
                            class="fs-6 fw-bold btn btn-info btn-outline-secondary btn-sm fs-4 min-w-125px">Tải ảnh</button>
                    </label>
                    
                </div>
                
            </div>
            <div class=" row d-flex justify-content-around flex-wrap ">
                <div class=" col-md-8 ">
                    <input type="file" action-control="exreacurricualar-student-input" class="d-none">
                    <div class="d-flex flex-wrap"> 
                        @if (isset($paths) && count($paths) > 0)
                            @foreach ($paths as $path)
                            <div class="p-10 position-relative" data-file-name="{{ basename($path) }}" data-control="exreacurricualar-student-file">
                                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('  {{ ($path) }}')">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-200px h-200px" style="background-image: url('  {{ ($path) }}')">
                                    </div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary position-absolute top-0 end-0 w-25px h-25px bg-body shadow" action-control="delete" data-bs-toggle="tooltip" aria-label="Change avatar" data-bs-original-title="Change avatar" data-kt-initialized="1">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </label>
                                </div>                                    
                            </div>
                            @endforeach
                        @else
                            <div class="row my-2">
                                <div class="col-md-12 pe-0 cursor-pointer d-flex justify-content-center align-items-center">
                                    <div style="font-style: italic;">Chưa có File!</div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                </div>
            </div> 
        </div>
    </form>
    <!--end::Card body-->

    <script>
      var manager;

$(() => {
    manager = new Manager({
        container: $('#{{$formId}}')
    });
})

var File = class {
    constructor(options) {
        this.container = options.container;
        this.manager = options.manager;

        this.init();
    }

    getManager() {
        return this.manager;
    }

    getContainer() {
        return this.container;
    }

    getName() {
        return $(this.getContainer()).attr('data-file-name');
    }
 
    getDeleteBtn() {
        return $(this.getContainer()).find('[action-control="delete"]');
    }

    delete() {
        const _this = this;

        const formData = new FormData();
        const csrfToken = '{{ csrf_token() }}';
        const name = this.getName();

        formData.append('_token', csrfToken);
        formData.append('fileName', name);

        $.ajax({
            url: _this.getManager().getDeleteUrl(),
            method: 'post',
            data: formData,
            contentType: false,
            processData: false
        }).done(response => {
            ASTool.alert({
                icon: 'success',
                message: response.messages,
                ok: () => {
                    // Reload letter content
                    CreateSocialNetworkPopup.getUpdatePopup().load();
                }
            });
        }).fail(response => {
            ASTool.alert({
                icon: 'warning',
                message: JSON.parse(response.responseText).messages,
                ok: () => {
                    // Reload letter content
                    CreateSocialNetworkPopup.getUpdatePopup().load();
                }
            });
        })
    }

    deleteHandle() {
        ASTool.confirm({
            icon: 'warning',
            message: "Bạn có chắc muốn xóa hình này không?",
            ok: () => {
                this.delete();
            },
            cancel: () => {}
        })
    }

    init() { 
        this.events();
    }

    events() {
        const _this = this;
        _this.getDeleteBtn().on('click', function(e) {
    
            e.preventDefault();
            _this.deleteHandle();
        });
    }
}

var Manager = class {
    constructor(options) {
        this.container = options.container;

        this.init();
    }

    getContainer() {
        return this.container;
    }

    getForm() {
        return this.getContainer().find('[form-data="exreacurricualar-student-manager-container"]');
    }

    getUploadUrl() {
        return this.getForm().attr('data-upload-url');
    }

    getDeleteUrl() {
        return this.getForm().attr('data-delete-url');
    }

    getImageExtracurricularStudentFileElements() {
        return this.getForm().find('[data-control="exreacurricualar-student-file"]').toArray();
    }

    createFileInstances(elements, status) {
        const _this = this;

        elements.forEach(elm => {
            new File({
                container: elm,
                manager: _this
            }); 
        });
    }


    getUpLoadImageExtracurricularStudentBtn() {
        return this.getForm().find('[action-control="upload-exreacurricualar-student-btn"]');
    }

    getImageExtracurricularStudentInput() {
        return this.getForm().find('[action-control="exreacurricualar-student-input"]');
    }

    upload() {
        const _this = this;
        const formData = new FormData();
        const csrfToken = '{{ csrf_token() }}';
        const file = this.getImageExtracurricularStudentInput().prop('files')[0];

        formData.append('_token', csrfToken);
        formData.append('file', file);

        $.ajax({
            url: _this.getUploadUrl(),
            data: formData,
            method: 'POST',
            contentType: false,
            processData: false
        }).done(response => {
            // Reload letter content
            CreateSocialNetworkPopup.getUpdatePopup().load();
        }).fail(response => {
            ASTool.alert({
                icon: 'warning',
                message: JSON.parse(response.responseText).messages,
                ok: () => {
                    // Reload letter content
                    CreateSocialNetworkPopup.getUpdatePopup().load();
                }
            });
        })
    }

    init() {
        const imageExtracurricularStudentElements = this.getImageExtracurricularStudentFileElements();

        this.createFileInstances(imageExtracurricularStudentElements);
        this.events();
    }

    events() {
        const _this = this;

        _this.getUpLoadImageExtracurricularStudentBtn().on('click', function(e) {
            e.preventDefault();
            _this.getImageExtracurricularStudentInput().click();
        })

        _this.getImageExtracurricularStudentInput().on('change', function(e) {
            e.preventDefault();
            _this.upload();
        })
    }
}

    </script>
    
@endsection
