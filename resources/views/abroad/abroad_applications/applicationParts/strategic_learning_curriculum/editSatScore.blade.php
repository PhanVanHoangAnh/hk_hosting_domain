@extends('layouts.main.popup')

@section('title')
    Thêm mới điểm thi Sat
@endsection

@php
    $createSatCorePopup = 'createSatCorePopup_' . uniqid();
@endphp

@section('content')
<div>
    <form id="{{ $createSatCorePopup }}" method="POST" tabindex="-1" enctype="multipart/form-data" 
    action="{{ action([App\Http\Controllers\Abroad\LoTrinhChienLuocController::class, 'doneEditSatScore'], ['id' => $sat->id]) }}">
        <div data-form="create-letter-form" >
            @csrf
            <div class="scroll-y px-7 py-10 px-lg-17">
                <div class="row mb-4">
                   
                  
                    <div class="col-lg-4 col-md-6 col-sm-6 col-6 mb-2">
                        <div class="form-outline">
                            <label class="required fs-6 fw-semibold">Lần thi</label>
                            <input name="exam_times" type="number" value="{{$sat->exam_times ?? ''}}" class="form-control" placeholder="Nhập lần thi thứ...">
                            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-6 mb-2">
                        <div class="form-outline">
                            <label class="required fs-6 fw-semibold">Điểm thi</label>
                            <input name="sat_score" type="text" value="{{$sat->sat_score ?? ''}}" class="form-control" placeholder="Điểm thi Sat...">
                            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                        </div>
                    </div>
        
                    <div class="col-lg-4 col-md-6 col-sm-6 col-6 mb-2">
                        <div class="form-outline">
                            <label class="required fs-6 fw-semibold">Ngày thi</label>
                            <input name="date" type="date" value="{{$sat->test_day}}" class="form-control" placeholder="Ngày thi...">
                            <x-input-error :messages="$errors->get('date')" class="mt-2"/>
                        </div>
                    </div>
                </div>
        
                <div id="error-message-sat" class="error-message-sat text-danger mt-4" style="display: none;"></div>
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button data-action="edit-btn" class="btn btn-primary">
                        <span class="indicator-label">Cập nhật</span>
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
    var editSatScoreManager;

    $(() => {
        editSatScoreManager = new editSatScoreManager({
            container: $('#{{ $createSatCorePopup }}')
        })
    })

    var editSatScoreManager = class {
        constructor(options) {
            this.container = options.container;

            this.events();
        }

        getContainer() {
            return this.container;
        }

        getSaveDataBtn() {
            return this.getContainer()[0].querySelector('[data-action="edit-btn"]');
        }

        addSubmitEffect() {
            this.getSaveDataBtn().setAttribute('data-kt-indicator', 'on');
            this.getSaveDataBtn().setAttribute('disabled', true);
        };

        removeSubmitEffect() {
            this.getSaveDataBtn().removeAttribute('data-kt-indicator');
            this.getSaveDataBtn().removeAttribute('disabled');
        };
        hasInput() {
                const inputPage = document.querySelector('[name="sat_score"]').value;
                return inputPage == '';
            }
        submit(data) { 
            const _this = this;
            if (_this.hasInput()) {
                    const errorContainer = document.getElementById('error-message-sat');
                   
                    errorContainer.textContent =
                        'Vui lòng nhập điểm!';
                    errorContainer.style.display = 'block';
                    return;
                }
            this.addSubmitEffect();

            $.ajax({
                url: _this.getContainer().attr('action'),
                method: 'POST',
                data: data,
                processData: false,
                contentType: false
            }).done(response => {
                this.removeSubmitEffect();
                SatScorePopup.getUpdatePopup().hide();
                
                ASTool.alert({
                    message: response.message,
                    ok: () => {
                        scorePopup.getPopup().load();
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

                _this.submit(formData);
            })
        }
    }
</script>

@endsection