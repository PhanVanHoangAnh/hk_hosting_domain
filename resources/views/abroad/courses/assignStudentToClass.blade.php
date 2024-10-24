@extends('layouts.main.popup', [
    'size' => 'full',
])

@section('title')
    Xếp học viên vào lớp {{ $course->code }}
@endsection

@php
    $stoppedClassPopupUniqId = 'stoppedClass_' . uniqid();
@endphp

@section('content')
    <div id="{{ $stoppedClassPopupUniqId }}">
        <form data-action="form" action="{{ action('\App\Http\Controllers\Abroad\CourseController@doneAssignStudentToClass') }}"
            method="post">
            @csrf
            <div class="py-10">
                <div class="row w-100 px-15 mx-auto d-flex justify-content-around mb-10">
                    <div class="col-12">
                        <div class="mb-10">
                            @if (count($orderItems) > 0)
                                <div class="form-outline mb-7">
                                    <div class="d-flex align-items-center">
                                        <label for="" class="form-label fw-semibold text-info">Danh sách học viên
                                            phù hợp với lớp học</label>
                                    </div>

                                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">

                                        <table class="table table-row-bordered table-hover table-bordered table-fixed">
                                            <thead>
                                                <tr
                                                    class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">

                                                    <th class="text-nowrap text-white">Xếp lớp</th>
                                                    <th class="text-nowrap text-white">Tên học viên</th>
                                                    <th class="text-nowrap text-white">Mã hợp đồng</th>
                                                    <th class="text-nowrap text-white">Môn học</th>
                                                    <th class="text-nowrap text-white">Lớp học</th>
                                                    {{-- <th class="text-nowrap text-white">Giá dịch vụ</th> --}}
                                                    <th class="text-nowrap text-white">Trình độ</th>
                                                    <th class="text-nowrap text-white">Chủ nhiệm đề xuất</th>
                                                    <th class="text-nowrap text-white">Hình thức học</th>
                                                    <th class="text-nowrap text-white">Giờ giáo viên Việt Nam còn lại</th>
                                                    <th class="text-nowrap text-white">Giờ giáo viên nước ngoài còn lại</th>
                                                    <th class="text-nowrap text-white">Giờ gia sư còn lại</th>
                                                    <th class="text-nowrap text-white">Chi nhánh</th>
                                                    <th class="text-nowrap text-white">Điểm target</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                                @foreach ($orderItems as $orderItem)
                                                    <tr data-bs-placement="left" data-bs-dismiss="click">
                                                        <td class="ps-1">
                                                            <div
                                                                class="form-check form-check-sm form-check-custom justify-content-center">
                                                                <input data-item-id="{{ $orderItem->id }}"
                                                                    list-action="check-item" name="order_item_ids[]"
                                                                    class="form-check-input" type="checkbox"
                                                                    value="{{ $orderItem->id }}" />

                                                            </div>
                                                        </td>
                                                        <td>{{ $orderItem->order->student->name }}</td>
                                                        <td>{{ $orderItem->orders->code }}</td>
                                                        <td>{{ $orderItem->subject->name }}</td>
                                                        @php
                                                            $classFit = App\Models\Course::getCoursesBySubjects(
                                                                $orderItem->subject->name,
                                                                $orderItem->getStudent()->id,
                                                                $orderItem,
                                                            )->count();

                                                        @endphp
                                                        <td>{{ $classFit }}</td>
                                                        {{-- <td>{{ $orderItem->price }}</td> --}}
                                                        <td>{{ $orderItem->level }}</td>
                                                        <td
                                                            {{ isset($orderItem->homeRoom) ? 'style="font-style: italic"' : '' }}>
                                                            {{ isset($orderItem->homeRoom) ? $orderItem->homeRoom->name : 'Chưa chọn chủ nhiệm đề xuất' }}
                                                        </td>
                                                        <td>{{ $orderItem->study_type }}</td>
                                                        @php
                                                            $sumMinutesForeignTeacher =
                                                                $orderItem->getTotalForeignMinutes() -
                                                                $orderItem->studyHours(
                                                                    $orderItem,
                                                                    $orderItem->orders->contacts,
                                                                )['sumMinutesForeignTeacher'];

                                                            $hourForeignTeacher = floor($sumMinutesForeignTeacher / 60);
                                                            $minutisForeignTeacher =
                                                                $orderItem->getTotalForeignMinutes() % 60;

                                                            $sumMinutesVNTeacher =
                                                                $orderItem->getTotalVnMinutes() -
                                                                $orderItem->studyHours(
                                                                    $orderItem,
                                                                    $orderItem->orders->contacts,
                                                                )['sumMinutesVNTeacher'];

                                                            $hourVNTeacher = floor($sumMinutesVNTeacher / 60);
                                                            $minutisVNTeacher = $orderItem->getTotalVnMinutes() % 60;

                                                            $sumMinutesTutal =
                                                                $orderItem->getTotalTutorMinutes() -
                                                                $orderItem->studyHours(
                                                                    $orderItem,
                                                                    $orderItem->orders->contacts,
                                                                )['sumMinutesTutor'];
                                                            $hourTutal = floor($sumMinutesTutal / 60);
                                                            $minutisTutal = $orderItem->getTotalTutorMinutes() % 60;
                                                        @endphp
                                                        <td>{{ $hourVNTeacher }} giờ {{ $minutisVNTeacher }} phút</td>
                                                        <td>{{ $hourForeignTeacher }} giờ {{ $minutisForeignTeacher }}
                                                            phút</td>
                                                        <td>{{ $hourTutal }} giờ {{ $minutisTutal }} phút</td>
                                                        <td>{{ $orderItem->branch }}</td>
                                                        <td>{{ $orderItem->target }}</td>

                                                    </tr>
                                                    {{-- <input type="hidden" name="order_item_ids" value="{{ $orderItem->id }}"> --}}
                                                @endforeach

                                            </tbody>
                                        </table>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                            <label class="fs-6 fw-bold fs-4">Chọn thời điểm bắt đầu học</label>
                                            <input type="date" class="form-control" name="assignment_date">
                                        </div>
                                        
                                    </div>
                                </div>
                            @else
                                <div class="py-15">
                                    <div class="text-center mb-7">
                                        <svg style="width:120px;" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 173.8 173.8">
                                            <g style="isolation:isolate">
                                                <g id="Layer_2" data-name="Layer 2">
                                                    <g id="layer1">
                                                        <path
                                                            d="M173.8,86.9A86.9,86.9,0,0,1,0,86.9,86,86,0,0,1,20.3,31.2a66.6,66.6,0,0,1,5-5.6A87.3,87.3,0,0,1,44.1,11.3,90.6,90.6,0,0,1,58.6,4.7a87.6,87.6,0,0,1,56.6,0,90.6,90.6,0,0,1,14.5,6.6A85.2,85.2,0,0,1,141,18.8a89.3,89.3,0,0,1,18.5,20.3A86.2,86.2,0,0,1,173.8,86.9Z"
                                                            style="fill:#cdcdcd" />
                                                        <path
                                                            d="M159.5,39.1V127a5.5,5.5,0,0,1-5.5,5.5H81.3l-7.1,29.2c-.7,2.8-4.6,4.3-8.6,3.3s-6.7-4.1-6.1-6.9l6.3-25.6h-35a5.5,5.5,0,0,1-5.5-5.5V16.8a5.5,5.5,0,0,1,5.5-5.5h98.9A85.2,85.2,0,0,1,141,18.8,89.3,89.3,0,0,1,159.5,39.1Z"
                                                            style="fill:#6a6a6a;mix-blend-mode:color-burn;opacity:0.2" />
                                                        <path
                                                            d="M23.3,22.7V123a5.5,5.5,0,0,0,5.5,5.5H152a5.5,5.5,0,0,0,5.5-5.5V22.7Z"
                                                            style="fill:#f5f5f5" />
                                                        <rect x="31.7" y="44.7" width="33.7" height="34.51"
                                                            style="fill:#dbdbdb" />
                                                        <rect x="73.6" y="44.7" width="33.7" height="34.51"
                                                            style="fill:#dbdbdb" />
                                                        <rect x="115.5" y="44.7" width="33.7" height="34.51"
                                                            style="fill:#dbdbdb" />
                                                        <rect x="31.7" y="84.1" width="33.7" height="34.51"
                                                            style="fill:#dbdbdb" />
                                                        <rect x="73.6" y="84.1" width="33.7" height="34.51"
                                                            style="fill:#dbdbdb" />
                                                        <rect x="115.5" y="84.1" width="33.7" height="34.51"
                                                            style="fill:#dbdbdb" />
                                                        <path
                                                            d="M157.5,12.8A5.4,5.4,0,0,0,152,7.3H28.8a5.5,5.5,0,0,0-5.5,5.5v9.9H157.5Z"
                                                            style="fill:#dbdbdb" />
                                                        <path d="M147.7,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,147.7,15Z"
                                                            style="fill:#f5f5f5" />
                                                        <path d="M138.3,15a3.4,3.4,0,1,1,6.7,0,3.4,3.4,0,0,1-6.7,0Z"
                                                            style="fill:#f5f5f5" />
                                                        <path d="M129,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,129,15Z"
                                                            style="fill:#f5f5f5" />
                                                        <rect x="32.1" y="29.8" width="116.6" height="3.85"
                                                            style="fill:#dbdbdb" />
                                                        <rect x="32.1" y="36.7" width="116.6" height="3.85"
                                                            style="fill:#dbdbdb" />
                                                        <rect x="73.3" y="96.7" width="10.1" height="8.42"
                                                            transform="translate(-38.3 152.9) rotate(-76.2)"
                                                            style="fill:#595959" />
                                                        <path
                                                            d="M94.4,35.7a33.2,33.2,0,1,0,24.3,40.1A33.1,33.1,0,0,0,94.4,35.7ZM80.5,92.2a25,25,0,1,1,30.2-18.3A25.1,25.1,0,0,1,80.5,92.2Z"
                                                            style="fill:#f8a11f" />
                                                        <path
                                                            d="M57.6,154.1c-.7,2.8,2,5.9,6,6.9h0c4,1,7.9-.5,8.6-3.3l11.4-46.6c.7-2.8-2-5.9-6-6.9h0c-4.1-1-7.9.5-8.6,3.3Z"
                                                            style="fill:#253f8e" />
                                                        <path d="M62.2,61.9A25,25,0,1,1,80.5,92.2,25,25,0,0,1,62.2,61.9Z"
                                                            style="fill:#fff;mix-blend-mode:screen;opacity:0.6000000000000001" />
                                                        <path
                                                            d="M107.6,72.9a12.1,12.1,0,0,1-.5,1.8A21.7,21.7,0,0,0,65,64.4a11.6,11.6,0,0,1,.4-1.8,21.7,21.7,0,1,1,42.2,10.3Z"
                                                            style="fill:#dbdbdb" />
                                                        <path
                                                            d="M54.3,60A33.1,33.1,0,0,0,74.5,98.8l-1.2,5.3c-2.2.4-3.9,1.7-4.3,3.4L57.6,154.1c-.7,2.8,2,5.9,6,6.9L94.4,35.7A33.1,33.1,0,0,0,54.3,60Z"
                                                            style="fill:#dbdbdb;mix-blend-mode:screen;opacity:0.2" />
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <p class="fs-4 text-center mb-5">
                                        Không có học viên nào phù hợp
                                    </p>

                                </div>
                            @endif
                        </div>

                    </div>
                    <div id="error-message" class="error-message text-danger" style="display: none;"></div>
                </div>
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="submit" popup-control="save" class="btn btn-primary">
                        <span class="indicator-label">Xếp lớp</span>
                        <span class="indicator-progress">Đang xử lý...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="reset" id="kt_modal_add_contact_cancel" class="btn btn-light me-3"
                        data-bs-dismiss="modal">Hủy</button>
                    <!--end::Button-->
                </div>
            </div>
        </form>
    </div>
    <script>
        var stoppedClassManager;

        $(() => {
            stoppedClassManager = new StoppedClassManager({
                container: document.querySelector('#{{ $stoppedClassPopupUniqId }}')
            })
        });

        var StoppedClassManager = class {
            constructor(options) {
                this.container = options.container;

                this.events();
            };

            getContainer() {
                return this.container;
            };

            getForm() {
                return this.getContainer().querySelector('[data-action="form"]');
            };


            hasCheckOrderItem() {
                return $('input[name="order_item_ids[]"]:checked').length > 0;
            }
            hasSelectDate() {
                const selectedStudent = this.getContainer().querySelector('[name="assignment_date"]').value;
                return selectedStudent !== '';
               
            }

            hideErrorMessage() {
                const errorContainer = document.getElementById('error-message');
                errorContainer.style.display = 'none';
            }
            events() {
                const _this = this;


                _this.getForm().addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (!_this.hasCheckOrderItem()) {
                        const errorContainer = document.getElementById('error-message');
                        errorContainer.textContent =
                            'Vui lòng chọn học viên để xếp lớp!';
                        errorContainer.style.display = 'block';
                        return;
                    }
                    if (!_this.hasSelectDate()) {
                        const errorContainer = document.getElementById('error-message');
                        errorContainer.textContent =
                            'Vui lòng chọn thời điểm bắt đầu học để xếp lớp!';
                        errorContainer.style.display = 'block';
                        return;
                    }

                    const url = _this.getForm().getAttribute('action');
                    const data = $(_this.getForm()).serialize();
                    $.ajax({
                        url: url,
                        method: 'post',
                        data: data
                    }).done(response => {
                        ShowOrderPopup.getPopup().hide();

                        ASTool.alert({
                            message: response.message,
                            ok: () => {
                                AssignToClassPopup.getPopup().hide();
                                if (typeof CoursesList !== 'undefined' &&
                                    CoursesList && typeof CoursesList.getList ===
                                    'function') {
                                    CoursesList.getList().load();
                                }
                                if (typeof StaffsList !== 'undefined' &&
                                    StaffsList && typeof StaffsList.getList ===
                                    'function') {
                                    StaffsList.getList().load();
                                }

                            }
                        });
                    }).fail(response => {
                        throw new Error(response);
                    })
                });
            };
        };
    </script>
@endsection
