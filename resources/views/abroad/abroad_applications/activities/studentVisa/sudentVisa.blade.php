<div class="row">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">4</span>
            </div>
            <div class="fw-semibold">
                Visa cho học sinh
            </div>
        </div>
    </div>

    <div class="col-md-9" form-data="student-visa-manager-container"
        data-upload-url="{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'storeStudentVisaFile'], ['id' => $abroadApplication->id]) }}"
        data-delete-url="{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'deleteStudentVisaFile'], ['id' => $abroadApplication->id]) }}">
        <div class="row d-flex justify-content-around">
            <div class="col-md-4">
                <label class="fs-6 fw-bold fs-4">
                    <label class="fs-6 fw-bold fs-4">Tình trạng/Kết quả:</label>
                </label>
            </div>
            <div class="col-md-8">
                <label class="fs-6 fw-bold fs-4">
                    <button action-control="upload-file-btn"
                        class="fs-6 fw-bold btn btn-info btn-outline-secondary btn-sm fs-4">Tải Visa học sinh</button>
                </label>
            </div>
        </div>
        <form form-data="student-visa-form" method="POST"
            action="{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'updateStudentVisaData'], ['id' => $abroadApplication->id]) }}"
            class="row d-flex justify-content-around">
            @csrf
            <div class="col-md-4">
                <select class="form-select form-control" data-control="select2" name="student_visa_status"
                    id="">

                    @foreach (\App\Models\AbroadApplication::getAllStudentVisaFeeStatus() as $status)
                        <option value="{{ $status }}"
                            {{ isset($abroadApplication->student_visa_status) && $abroadApplication->student_visa_status == $status ? 'selected' : '' }}>
                            {{ trans('messages.student_visa.' . $status) }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('student_visa_status')" class="mt-2" />
            </div>
            <div class="col-md-8">
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
    var studentVisaFeeManager;

    $(() => {
        studentVisaFeeManager = new StudentVisaFeeManager({
            container: $('[form-data="student-visa-manager-container"]')
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
                        studentVisaManager.load();
                        initJs(_this.getManager().getContainer()[0]);
                    }
                });
            }).fail(response => {
                ASTool.alert({
                    icon: 'warning',
                    message: JSON.parse(response.responseText).messages,
                    ok: () => {
                        // Reload letter content
                        studentVisaManager.load();
                        initJs(_this.getManager().getContainer()[0]);
                    }
                });
            })
        }

        deleteHandle() {
            ASTool.confirm({
                icon: 'warning',
                message: "Bạn có chắc muốn xóa bản scan visa này không?",
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

    var StudentVisaFeeManager = class {
        constructor(options) {
            this.container = options.container;

            this.init();
        }

        getContainer() {
            return this.container;
        }

        getForm() {
            return this.getContainer().find('[form-data="student-visa-form"]');
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
            return this.getContainer().find('[name="student_visa_status"]');
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
                studentVisaManager.load();
            }).fail(response => {
                ASTool.alert({
                    icon: 'warning',
                    message: JSON.parse(response.responseText).messages,
                    ok: () => {
                        // Reload letter content
                        studentVisaManager.load();
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
                // studentVisaManager.load();
            }).fail(response => {
                // studentVisaManager.updateContent(response.responseText);
            })
        }



        init() {
            const cvElements = this.getFileElements();

            // this.assignMask();
            this.createFileInstances(cvElements);
            this.events();
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

        }
    }
</script>
