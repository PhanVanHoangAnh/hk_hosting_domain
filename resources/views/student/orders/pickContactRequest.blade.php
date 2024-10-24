@if (isset(request()->contact_ids))
    @if (!$newContactRequests->count())
        <div class="">
            <div class="d-flex align-items-center alert alert-dismissible bg-light-primary border border-primary  d-flex flex-column flex-sm-row w-100 p-5 mb-10">
                <!--begin::Icon-->
                <span class="material-symbols-rounded me-4">
                    info
                </span>
                <!--end::Icon-->
                <!--begin::Content-->
                <div class="d-flex flex-column pe-0 pe-sm-10">
                    <p class="mb-0">
                        Chưa có đơn hàng nào mới trên hệ thống.
                        @if (Auth::user()->can('create', App\Models\ContactRequest::class))
                            @php
                                $addContactRequestBtnUniqId = 'add_contact_request_btn_uniq_id' . uniqId();
                            @endphp
                            <button contact-control="add" type="button" id="{{ $addContactRequestBtnUniqId }}"
                                class="btn btn-light btn-sm btn-icon ms-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                data-bs-placement="right" data-bs-dismiss="click" data-bs-original-title="Thêm mới đơn hàng cho người này?">
                                <span class="material-symbols-rounded">add</span>
                            <script>
                                $(() => {
                                    addNewContactRequestPopup = new AddNewContactRequestPopup();

                                    setTimeout(() => {
                                        new AddContactRequestBtn({
                                            self: () => {
                                                return $('#{{ $addContactRequestBtnUniqId }}');
                                            },
                                            popup: () => {
                                                return addNewContactRequestPopup;
                                            }
                                        })
                                    }, 0);
                                })

                                var addNewContactRequestPopup;
                                var AddNewContactRequestPopup = class {
                                    constructor(options) {
                                        this.popup = new Popup();
                                    }
                                    
                                    updateUrl(newUrl) {
                                        this.popup.url = newUrl;
                                        this.popup.load();
                                    }

                                    getPopup() {
                                        return this.popup;
                                    }

                                    hide() {
                                        this.popup.hide();
                                    }
                                }

                                var AddContactRequestBtn = class {
                                    constructor(options) {
                                        this.self = options.self;
                                        this.popup = options.popup;
                                        this.events();
                                    }

                                    getUrl() {
                                        return "{!! action([\App\Http\Controllers\Student\ContactRequestController::class, 'create'], ['contact_id' => isset($contactIds) && $contactIds ? $contactIds[0] : null, 'orderType' => isset($orderType) ? $orderType : null]) !!}";
                                    }

                                    clickHandle() {
                                        const newUrl = this.getUrl();
                                        this.popup().updateUrl(newUrl);
                                    }

                                    events() {
                                        this.self().on('click', e => {
                                            e.preventDefault();

                                            this.clickHandle();
                                        })
                                    }
                                }
                            </script>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if ($newContactRequests->count())
        <style>
            [request-control="row"] {
                cursor: pointer;
            }
        </style>
        <div class="">
            <label for="" class="form-label fw-semibold">Danh sách đơn hàng có thể chọn</label>
            <p>
                Liên hệ/Khách hàng đang có
                <strong>{{ $newContactRequests->count() }}</strong> đơn hàng chưa phát sinh hợp đồng.
                Vui lòng chọn đơn hàng cho hợp đồng này.
            </p>
            <div class="table-responsive">
                <table class="table table-row-bordered table-hover table-bordered">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                            <th style="width:1%"></th>
                            <th class="text-nowrap text-white">Liên hệ/Khách hàng</th>
                            <th class="text-nowrap text-white">Đơn hàng</th>
                            <th class="text-nowrap text-white">Hợp đồng</th>
                            <th class="text-nowrap text-white">Lead Status</th>
                            <th class="text-nowrap text-white">Nhân viên phụ trách</th>
                            <th class="text-nowrap text-white">Ghi chú</th>
                            <th class="text-nowrap text-white">Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($newContactRequests->get() as $request)
                            <tr request-control="row" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                data-bs-placement="left" data-bs-dismiss="click"
                                data-bs-original-title="Nhấn để chọn đơn hàng cho hợp đồng"
                                class="{{ $contactRequestId == $request->id ? 'bg-light-warning pe-none' : '' }}"
                            >
                                <td>
                                    @if (!$request->hasOrders())
                                        <label class="form-check form-check-custom form-check-solid">
                                            <input {{ $contactRequestId == $request->id ? 'checked' : '' }} request-control="select-radio" name="contact_request_id" value="{{ $request->id }}" class="form-check-input" type="radio" value=""/>
                                            <span class="form-check-label">
                                                
                                            </span>
                                        </label>
                                    @else
                                        <span class="material-symbols-rounded text-danger">
                                            block
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $request->contact->name }}</td>
                                <td>{{ $request->demand }}</td>
                                <td>
                                    @if (!$request->hasOrders())
                                        Chưa có hợp đồng
                                    @else
                                        <div><a
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Nhấn để chỉnh sửa hợp đồng này"
                                            href="{{ action([OrderController::class, 'showFormCreateConstract'], [
                                            'orderId' => $request->getOrder()->id,
                                            'actionType' => 'update',
                                        ]) }}">{{ $request->getOrder()->code }}</a>
                                        </div>
                                        <span
                                            class="badge bg-secondary">
                                                {{ trans('messages.order.status.' . $request->getOrder()->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $request->contact->lead_status }}</td>
                                <td>
                                    @if ($request->contact->account)
                                        {{ $request->contact->account->name }}
                                    @else
                                        <span class="text-gray-500">Chưa bàn giao</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($request->contact->getLastNoteLog()) 
                                        {!! $request->contact->getLastNoteLog()->content !!}
                                    @else
                                        Chưa có ghi chú
                                    @endif
                                </td>
                                <td>{{ $request->contact->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    
    @if ($contactRequests->count())
        <style>
            [request-control="row"] {
                cursor: pointer;
            }
        </style>
        <div class="">
            <label for="" class="form-label fw-semibold">Đơn hàng đang xử lý</label>

            <p>
                Liên hệ/Khách hàng đang có
                <strong>{{ $contactRequests->count() }}</strong> đơn hàng đã phát sinh hợp đồng đang soạn.
            </p>

            <div class="table-responsive">
                <table class="table table-row-bordered table-hover table-bordered">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                            <th style="width:1%"></th>
                            <th class="text-nowrap text-white">Liên hệ/Khách hàng</th>
                            <th class="text-nowrap text-white">Đơn hàng</th>
                            <th class="text-nowrap text-white">Hợp đồng</th>
                            <th class="text-nowrap text-white">Người soạn HĐ</th>
                            <th class="text-nowrap text-white">Lead Status</th>
                            <th class="text-nowrap text-white">Ghi chú</th>
                            <th class="text-nowrap text-white">Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contactRequests->get() as $request)
                            <tr request-control="row" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                data-bs-placement="left" data-bs-dismiss="click"
                                data-bs-original-title="Không thể chọn request này do đã có hợp đồng!"
                                class="{{ $contactRequestId == $request->id ? 'bg-light-warning pe-none' : '' }} bg-light">
                                <td>
                                    <span class="material-symbols-rounded text-danger">
                                        block
                                    </span>
                                </td>
                                <td>{{ $request->contact->name }}</td>
                                <td>{{ $request->demand }}</td>
                                <td>
                                    @if (!$request->hasOrders())
                                        Chưa có hợp đồng
                                    @else
                                        <div><a class="fw-semibold text-info"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" title="Nhấn để chỉnh sửa hợp đồng này"
                                            href="{{ action([App\Http\Controllers\Student\OrderController::class, 'showFormCreateConstract'], [
                                                'orderId' => $request->getOrder()->id,
                                                'actionType' => 'update',
                                            ]) }}">{{ $request->getOrder()->code }}</a>
                                        </div>
                                        <span
                                            class="badge bg-secondary">
                                                {{ trans('messages.order.status.' . $request->getOrder()->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($request->getOrder()->salesperson)
                                        {{ $request->getOrder()->salesperson->name }}
                                    @else
                                        <span class="text-gray-500">Chưa bàn giao</span>
                                    @endif
                                </td>
                                <td>{{ $request->contact->lead_status }}</td>
                                <td>
                                    @if ($request->contact->getLastNoteLog()) 
                                        {!! $request->contact->getLastNoteLog()->content !!}
                                    @else
                                        Chưa có ghi chú
                                    @endif
                                </td>
                                <td>{{ $request->contact->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@else

@endif