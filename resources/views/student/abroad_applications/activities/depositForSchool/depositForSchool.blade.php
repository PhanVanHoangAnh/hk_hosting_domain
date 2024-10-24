<div class="row" id="deposit_for_school">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">2</span>
            </div>
            <div class="fw-semibold">
                Đặt cọc cho trường
                <div class="mt-1">
                    <span
                        class="badge badge-{{ $abroadApplication->isDoneDepositForSchool() ? 'success' : 'primary' }}">{{ $abroadApplication->isDoneDepositForSchool() ? 'Hoàn thành' : 'Chưa hoàn thành' }}</span>
                    <button value="deposit_for_school" action-control="deposit_for_school" type="button"
                        class="badge badge-success d-none {{ $abroadApplication->isDoneDepositForSchool() ? 'd-none' : '' }}"
                        data-bs-toggle="tooltip" data-bs-placement="right" title="Bấm vào đây nếu đã hoàn thành">
                        &#10004;
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9" form-data="deposit-manager-container"
        data-upload-url="{{ action([App\Http\Controllers\Student\AbroadController::class, 'storeDepositFile'], ['id' => $abroadApplication->id]) }}"
        data-delete-url="{{ action([App\Http\Controllers\Student\AbroadController::class, 'deleteDepositFile'], ['id' => $abroadApplication->id]) }}">
        <div class="row d-flex justify-content-around">
            <div class="col-md-4">
                <label class="fs-6 fw-bold fs-4">Số tiền $</label>
            </div>
            <div class="col-md-4">
                <label class="fs-6 fw-bold fs-4">
                    <label class="fs-6 fw-bold fs-4">Ngày đặt cọc:</label>
                </label>
            </div>
            <div class="col-md-4 invisible">
                <label class="fs-6 fw-bold fs-4">
                    <button action-control="upload-file-btn"
                        class="fs-6 fw-bold btn btn-info btn-outline-secondary btn-sm fs-4">Tải file phiếu đặt
                        cọc</button>
                </label>
            </div>
        </div>
        <form form-data="deposit-for-school-form" method="POST" action="{{ action([App\Http\Controllers\Student\AbroadController::class, 'updateDepositForSchool'], ['id' => $abroadApplication->id]) }}" class="row d-flex justify-content-around">
            @csrf
            <div class="col-md-4">
                {{ isset($abroadApplication->deposit_cost) ? $abroadApplication->deposit_cost : '' }}
            </div>
            <div class="col-md-4">
                {{ isset($abroadApplication->deposit_school_date) ? $abroadApplication->deposit_school_date : '' }}
            </div>
            <div class="col-md-4">
                <input type="file" action-control="file-input" class="d-none">
                <div class="form-control px-10">
                    @if (isset($paths) && count($paths) > 0)
                        @foreach ($paths as $path)
                            <div data-file-name="{{ basename($path) }}" data-control="file" class="row my-2">
                                <div
                                    class="col-md-9 pe-0 cursor-pointer bg-secondary d-flex justify-content-start align-items-center">
                                    <span class="material-symbols-rounded">description</span>&nbsp;&nbsp;&nbsp;
                                    <a class="cursor-pointer" href="{{ $path }}"
                                        download="{{ basename($path) }}">
                                        {{ basename($path) }}
                                        <span class="material-symbols-rounded pt-2">
                                            arrow_downward
                                        </span>
                                    </a>
                                </div>
                                <div class="col-md-3 ps-0 d-flex justify-content-start align-items-center">
                                    <button action-control="delete" class="btn btn-danger btn-sm">Xóa</button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="row my-2">
                            <div class="col-md-12 pe-0 cursor-pointer d-flex justify-content-center align-items-center">
                                <div style="font-style: italic;">Chưa có file nào!</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    var depositForSchoolManager;

    $(() => {
        depositForSchoolManager = new DepositForSchoolManager({
            container: $('#deposit_for_school')
        // extracurricularPlanManager = new DepositFeeManager({
        //     container: $('#deposit_for_school')
        // });
        
        // certificationsPopup = new CertificationsPopup();
    })
});


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
                        depositForSchool.load();
                        initJs(_this.getManager().getContainer()[0]);
                    }
                });
            }).fail(response => {
                ASTool.alert({
                    icon: 'warning',
                    message: JSON.parse(response.responseText).messages,
                    ok: () => {
                        // Reload letter content
                        depositForSchool.load();
                        initJs(_this.getManager().getContainer()[0]);
                    }
                });
            })
        }

        deleteHandle() {
            ASTool.confirm({
                icon: 'warning',
                message: "Bạn có chắc muốn xóa phiếu đặt cọc này không?",
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
            })
        }
    }

    var DepositForSchoolManager = class {
        constructor(options) {
            this.container = options.container;

            this.init();
        }
        getContainer() {
            return this.container;
        }

        getForm() {
            return this.getContainer().find('[form-data="deposit-for-school-form"]');
        }

        getFormData() {
            return this.getForm().serialize();
        }

        getUpdateDataUrl() {
            return this.getForm().attr('action');
        }

        getUploadUrl() {
            return this.getContainer().attr('data-upload-url');
        }

        getDeleteUrl() {
            return this.getContainer().attr('data-delete-url');
        }

        getFileElements() {
            return this.getContainer().find('[data-control="file"]').toArray();
        }

        getStatusSelect() {
            return this.getContainer().find('[name="deposit_school_date"]');
        }

        getCostInput() {
            return this.getContainer().find('[name="deposit_school_cost"]');
        }

        createFileInstances(elements, status) {
            const _this = this;

            elements.forEach(elm => {
                new File({
                    container: elm,
                    manager: _this
                })
            })
        }

        getUpLoadFileBtn() {
            return this.getContainer().find('[action-control="upload-file-btn"]');
        }

        getFileInput() {
            return this.getContainer().find('[action-control="file-input"]');
        }

        upload() {
            const _this = this;
            const formData = new FormData();
            const csrfToken = '{{ csrf_token() }}';
            const file = this.getFileInput().prop('files')[0];

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
                depositForSchool.load();
            }).fail(response => {
                ASTool.alert({
                    icon: 'warning',
                    message: JSON.parse(response.responseText).messages,
                    ok: () => {
                        // Reload letter content
                        depositForSchool.load();
                    }
                });
            })
        }

        updateData() {
            const _this = this;

            $.ajax({
                url: _this.getUpdateDataUrl(),
                method: 'post',
                data: _this.getFormData()
            }).done(response => {
                depositForSchool.load();
            }).fail(response => {
                depositForSchool.updateContent(response.responseText);
            })
        }

        assignMask() {
            const _this = this;

            IMask(_this.getCostInput()[0], {
                mask: Number,
                scale: 2,
                thousandsSeparator: ',',
                padFractionalZeros: false,
                normalizeZeros: true,
                radix: ',',
                mapToRadix: ['.'],
                min: 0,
                max: 999999999999,
            });
        }

        init() {
            const cvElements = this.getFileElements();
            
            // this.assignMask();
            this.createFileInstances(cvElements);
            this.events();
        }
        getDoneBtn() {
            return this.getContainer().find('[action-control="deposit_for_school"]');
        }
        clickDoneBtn() {

            var updateFinishDay = this.getDoneBtn().val();
            var abroadApplicationId = '{{ $abroadApplication->id }}';
            $.ajax({
                url: '{{ action([App\Http\Controllers\Student\AbroadApplicationStatusController::class, 'updateDoneAbroadApplication'], ['id' => ':id']) }}'
                    .replace(':id', abroadApplicationId),
                method: 'PUT',
                data: {
                    updateFinishDay: updateFinishDay,
                    abroadApplicationId: abroadApplicationId,
                    _token: '{{ csrf_token() }}'
                },
            }).done(response => {
                depositForSchool.load();

            }).fail(message => {
                // Xử lý khi yêu cầu thất bại
                throw new Error(message); // In ra thông báo lỗi
            });

        }

        events() {
            const _this = this;

            _this.getUpLoadFileBtn().on('click', function(e) {
                e.preventDefault();

                _this.getFileInput().click();
            })

            _this.getFileInput().on('change', function(e) {
                e.preventDefault();

                _this.upload();
            })

            _this.getStatusSelect().on('change', function(e) {
                e.preventDefault();

                _this.updateData();
            })

            // Handle when enter on cost input
            _this.getCostInput().on('keydown', function(e) {
                if (e.keyCode === 13) {
                    e.preventDefault();

                    _this.updateData();
                }
            });

            _this.getCostInput().on('change', function(e) {
                e.preventDefault();

                _this.updateData();
            })
            _this.getDoneBtn().on('click', function(e) {
                e.preventDefault();
                _this.clickDoneBtn();
            })
        }
    }

</script>
