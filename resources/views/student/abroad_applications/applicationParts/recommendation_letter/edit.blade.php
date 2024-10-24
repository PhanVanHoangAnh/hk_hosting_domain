@extends('layouts.main.popup')

@section('title')
    Chỉnh sửa thư giới thiệu
@endsection

@php
    $editRecommendationLetterPopup = 'editRecommendationLetterPopup_' . uniqid();
@endphp

@section('content')
<div>
    <form id="{{ $editRecommendationLetterPopup }}" method="POST" tabindex="-1" enctype="multipart/form-data" 
        action="{{ action([App\Http\Controllers\Student\AbroadController::class, 'updateRecommendationLetter'], ['id' => $recommendationLetter->id]) }}">
        <div data-form="create-letter-form">
            @csrf
            <div class="scroll-y px-7 py-10 px-lg-17">
                <div class="row mb-6">
                    <input type="hidden" name="abroad_application_id" value="{{ $abroadApplication->id }}"> {{-- Abroad Application --}}
                    <input type="hidden" name="account_id" value="{{ $account->id }}"> {{-- Account --}}
        
                    <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-2">
                        <div class="form-outline">
                            <label class="required fs-6 fw-semibold mb-4">Tên thư giới thiệu</label>
                            <input name="name" type="text" value="{{ isset($recommendationLetter->name) ? $recommendationLetter->name : '' }}" class="form-control" placeholder="Tên thư giới thiệu...">
                            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                        </div>
                    </div>
        
                    <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-2">
                        <div class="form-outline">
                            <label class="required fs-6 fw-semibold mb-4">Ngày tạo thư</label>
                            <input name="date" type="date" value="{{ isset($recommendationLetter->date) ? $recommendationLetter->date : '' }}" class="form-control" placeholder="Ngày tạo thư...">
                            <x-input-error :messages="$errors->get('date')" class="mt-2"/>
                        </div>
                    </div>
                </div>
        
                <div class="row mb-6">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-2">
                        <div class="form-outline">
                            <label class="fs-6 fw-semibold mb-4">File thư hiện tại</label>
                            <br>
                            <img style="width:40px; height:40px" src="{{ url('/core/assets/media/logos/word.png') }}" alt="Word Icon">
                            @php
                                $path = $recommendationLetter->path;
                                $filename = basename($path);
                                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                                $filenameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME);

                            @endphp
                            <span>{{ $filename }}</span>
                            <a class="fw-bold" href="/{{ $recommendationLetter->path }}" download="{{ $filename }}">
                                Tải xuống
                                <span class="material-symbols-rounded pt-2">
                                    arrow_downward
                                </span>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-8 col-md-8 col-sm-8 col-8 mb-2">
                        <div class="form-outline">
                            <label class="required fs-6 fw-semibold mb-4">Tải thư khác</label>
                            <input name="file" type="file" class="form-control">
                            <x-input-error :messages="$errors->get('file')" class="mt-2"/>
                        </div>
                    </div>
                </div>
        
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button data-action="create-btn" class="btn btn-primary">
                        <span class="indicator-label">Lưu</span>
                        <span class="indicator-progress">Đang xử lý...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3"
                        data-bs-dismiss="modal">Hủy</button>
                    <!--end::Button-->
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    var editRecommendationLetterManager;

    $(() => {
        editRecommendationLetterManager = new EditRecommendationLetterManager({
            container: $('#{{ $editRecommendationLetterPopup }}')
        })
    })

    var EditRecommendationLetterManager = class {
        constructor(options) {
            this.container = options.container;

            this.events();
        }

        getContainer() {
            return this.container;
        }

        getSaveDataBtn() {
            return this.getContainer()[0].querySelector('[data-action="create-btn"]');
        }

        addSubmitEffect() {
            this.getSaveDataBtn().setAttribute('data-kt-indicator', 'on');
            this.getSaveDataBtn().setAttribute('disabled', true);
        };

        removeSubmitEffect() {
            this.getSaveDataBtn().removeAttribute('data-kt-indicator');
            this.getSaveDataBtn().removeAttribute('disabled');
        };

        submit(data) { 
            const _this = this;

            this.addSubmitEffect();

            $.ajax({
                url: _this.getContainer().attr('action'),
                method: 'POST',
                data: data,
                processData: false,
                contentType: false
            }).done(response => {
                this.removeSubmitEffect();
                editPopup.getPopup().hide();
                
                ASTool.alert({
                    message: response.message,
                    ok: () => {
                        recommendationLetter.load();
                    }
                });
            }).fail(response => {
                $(_this.getContainer()).html($(response.responseText)[2].querySelector('[data-form="create-letter-form"]'));
                
                this.removeSubmitEffect();
            })
        }

        events() {
            const _this = this;

            _this.getContainer().on('submit', e => {
                e.preventDefault();

                const formData = new FormData(_this.getContainer()[0]);

                ASTool.confirm({
                    message: "Khi lưu thì file cũ sẽ được thay thế bởi file mới tải lên, bạn có chắc muốn lưu không?",
                    ok: () => {
                        _this.submit(formData);
                    }
                })
            })
        }
    }
</script>

@endsection