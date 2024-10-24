<!--begin::Post-->
@extends('hk.layouts.main.app', [])
@section('content')
    <div class="row" id="software-request-detail-view">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card-body pt-9 pb-0">
                @include('hk.software_requests._detail', [
                    'detail' => 'show',
                ])
            </div>
            <div class="flex-row-fluid">
                @include('hk.software_requests._consultingHistory', [])
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <form data-form="software-request-detail"
                action="{{ action(
                    [App\Http\Controllers\Hk\SoftwareRequestController::class, 'update'],
                    [
                        'id' => $softwareRequest->id,
                    ],
                ) }}">
                @csrf
                @include('hk.software_requests._form_detail_content')
            </form>

            <div class="fs-4 d-flex justify-content-end align-items-end mb-2 card-body">
                <button action-control="save-data-btn" id="UpdateNoteLogSubmitButton" type="submit" class="btn btn-primary">
                    <span class="indicator-label">Lưu thông tin</span>
                    <span class="indicator-progress">Đang xử lý...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </div>
    <script>
        $(() => {
            // UpdateSoftwareRequest.init();
            new SoftwareRequestManager({
                container: () => $('#software-request-detail-view')
            });
        })

        var SoftwareRequestManager = class {
            constructor(options) {
                this.container = options.container;
                this.events();
            }

            getForm() {
                return this.container().find('[data-form="software-request-detail"]');
            }

            getUrl() {
                return this.getForm().attr('action');
            }

            getSaveDataBtn() {
                return this.container().find('[action-control="save-data-btn"]');
            }

            update() {
                const _this = this;
                const data = $(_this.getForm()).serialize();

                $.ajax({
                    url: _this.getUrl(),
                    method: 'POST',
                    data: data
                }).done(res => {
                    ASTool.alert({
                        icon: 'success',
                        message: "Đã lưu thông tin thành công!",
                        ok: () => {
                            window.location.href =
                                "{{ action('\App\Http\Controllers\Hk\SoftwareRequestController@index') }}";
                        }
                    })
                }).fail(res => {
                    console.log(res)
                    _this.getForm().html(res.responseText);
                })
            }

            events() {
                const _this = this;

                _this.getSaveDataBtn().on('click', e => {
                    e.preventDefault();
                    _this.update();
                })
            }
        }
    </script>
@endsection
