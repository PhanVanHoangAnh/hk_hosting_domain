<div class="mb-10">
    @if ($currentCourses->count())
        <div class="form-outline mb-7">
            <div class="d-flex align-items-center">
                <label for="" class="form-label fw-semibold text-info">Học viên sẽ bị xoá ra khỏi lớp</label>
            </div>

            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">

                <table class="table table-row-bordered table-hover table-bordered table-fixed">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">

                            <th class="text-nowrap text-white">Tên lớp học</th>
                            <th class="text-nowrap text-white">Môn học</th>
                            <th class="text-nowrap text-white">Tổng giờ học</th>
                            <th class="text-nowrap text-white">Đã học</th>
                            <th class="text-nowrap text-white">Còn lại</th>

                            <th class="text-nowrap text-white">Loại hình</th>

                            <th class="text-nowrap text-white">Chủ nhiệm</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($currentCourses as $currentCourse)
                            <tr sdata-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="left"
                                data-bs-dismiss="click" data-bs-original-title="Nhấn để chọn lớp học" class="bg-light">
                                {{-- <td>
                                    <div
                                        class="form-check form-check-sm form-check-custom d-flex justify-content-center">
                                        <input request-control="select-radio" name="current_course_id"
                                            list-action="check-item" class="form-check-input" type="checkbox"
                                            value="{{ $currentCourse->id }}" checked />
                                    </div>
                                </td> --}}

                                <td>{{ $currentCourse->code }}</td>
                                <td>{{ $currentCourse->subject->name }}</td>
                                <td>
                                    {{-- {{ $currentCourse->total_hours }}  --}}
                                    {{ number_format(\App\Models\StudentSection::calculateTotalHours($studentId, $currentCourse->id), 2) }}
                                    Giờ
                                </td>
                                <td>
                                    {{ \App\Models\StudentSection::calculateTotalHoursStudied($studentId, $currentCourse->id) }}
                                    Giờ
                                </td>
                                @php
                                    $hoursRemain = number_format(\App\Models\StudentSection::calculateTotalHours($studentId, $currentCourse->id) - \App\Models\StudentSection::calculateTotalHoursStudied($studentId, $currentCourse->id), 2);
                                @endphp

                                <td>{{ $hoursRemain }} Giờ</td>
                                <td>{{ $currentCourse->study_method }}</td>
                                <td>{{ $currentCourse->teacher->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="">
            <div class="form-outline">
                <span class="d-flex align-items-center">
                    <span class="material-symbols-rounded me-2 ms-4" style="vertical-align: middle;">
                        error
                    </span>
                    <span>Chưa có lớp đang học</span>
                </span>
            </div>
        </div>
    @endif
</div>

<div class="mt-10">
    <script>
        var OrderForm = class {
                #url = "{{ action('App\Http\Controllers\Sales\OrderController@saveOrderItemData') }}";
                #orderId = "{{ 1 }}";

                constructor(options) {
                    this.form = options.form;
                    this.submitBtnId = options.submitBtnId;
                    // this.popup = options.popup;
                    this.orderItemId = options.orderItemId;
                    this.orderFormEvents();
                };

                getFormData() {
                    return this.form.serialize();
                };

                getSaveDataBtn() {
                    return document.querySelector(`#${this.submitBtnId}`);
                };

                // loadOrderItemsContent(content) {
                //     let updateContent = $(content).find('#orderItemsListContent');
                //     let updatePriceContent = $(content).find('#finalPriceContainer');

                //     $('#orderItemsListContent').html(updateContent);
                //     $('#finalPriceContainer').html(updatePriceContent);
                    
                //     KTComponents.init();
                //     createManage.events();
                //     createManage.initEvents();

                //     if ($('#create-constract-content')[0]) {
                //         initJs($('#create-constract-content')[0]);
                //     };
                // };

                addSubmitEffect() {
                    this.getSaveDataBtn().setAttribute('data-kt-indicator', 'on');
                    this.getSaveDataBtn().setAttribute('disabled', true);
                };

                removeSubmitEffect() {
                    this.getSaveDataBtn().removeAttribute('data-kt-indicator');
                    this.getSaveDataBtn().removeAttribute('disabled');
                };

                /**
                 * Save order item data
                 * @param formData order item data in form (popup)
                 * @return void
                 */ 
                saveDataIntoOrder(formData) {
                    var _this = this;

                    formData += `&order_id=${this.#orderId}&order_item_id=${this.orderItemId}`;

                    this.addSubmitEffect();

                    $.ajax({
                        url: this.#url,
                        method: "POST",
                        data: formData
                    }).done(response => {
                        const orderId = this.#orderId;
                        
                        this.removeSubmitEffect();
                        // this.popup.hide();

                        ASTool.alert({
                            message: response.message,
                            ok: () => {
                                // this.loadOrderItemsContent(response);

                                if (eduPriceManager) {
                                    eduPriceManager.loadOrderPrice();
                                }

                                if (abroadPriceManager) {
                                    abroadPriceManager.loadOrderPrice();
                                }

                                if (extraPriceManager) {
                                    extraPriceManager.loadOrderPrice();
                                }
                            }
                        });
                    }).fail(response => {
                        this.removeSubmitEffect();
                        // this.popup.setContent(response.responseText);
                        
                        if (this.getSaveDataBtn()) {
                            this.getSaveDataBtn().addEventListener('click', e => {
                                e.preventDefault();

                                this.saveDataIntoOrder(this.getFormData());
                            });
                        };
                    });
                };

                orderFormEvents() {
                    if (this.getSaveDataBtn()) {
                        this.getSaveDataBtn().outerHTML = this.getSaveDataBtn().outerHTML;

                        // Click save order item
                        this.getSaveDataBtn().addEventListener('click', e => {
                            e.preventDefault();
                            
                            this.saveDataIntoOrder(this.getFormData());
                        });
                    }
                };
            };
    </script>

    @if (isset($orderItem))

        @include('edu.students._new_edu_order_item_to_transfer_cost')

        <div class="mb-10">
            {{-- <div class="row"> --}}
            {{-- <div class="col-6"> --}}
            <div class="form-outline">
                <label class="required fs-6 fw-semibold mb-2">Chọn thời điểm yêu cầu chuyển phí</label>
                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                    <input data-control="input" value="{{ date('Y-m-d') }}" name="reserve_start_at"
                        id="reserve_start_at" placeholder="=asas" type="date" class="form-control">
                    <span data-control="clear" class="material-symbols-rounded clear-button"
                        style="display:none;">close</span>
                </div>
            </div>
            {{-- </div> --}}
            {{-- <div class="col-6"> --}}
            <!--begin::Label-->
            <label class="fs-6 fw-semibold mb-2 mt-4">
                <span class="">Lý do chuyển phí</span>
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <textarea class="form-control" name="reason" placeholder="Nhập lý do chuyển phí!" rows="5" cols="40"></textarea>
            <!--end::Input-->
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
            {{-- </div> --}}
        </div>
    @endif
</div>
