<div class="card-body pt-0 mt-5">
    @if ($contacts->count())
        <div class="table-responsive table-head-sticky freeze-column" style="max-height:calc(100vh - 420px);">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_contacts_table">
                <thead>
                    <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 text-nowrap">
                        <th class="w-10px pe-2 ps-1">
                            <div class="form-check form-check-sm form-check-custom">
                                <input list-action="check-all" class="form-check-input" type="checkbox" />
                            </div>
                        </th>
                        @if (in_array('code', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="code"
                                sort-direction="{{ $sortColumn == 'code' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="code">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mã
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'code' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('name', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="name" data-control="freeze-column"
                                sort-direction="{{ $sortColumn == 'name' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8 bg-info" data-column="name">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tên liên hệ
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'name' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif


                        @if (in_array('company_name', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="company_name" data-control="freeze-column"
                                sort-direction="{{ $sortColumn == 'company_name' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8 bg-info" data-column="company_name">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Công ty
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'company_name' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('type_of_business', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="type_of_business" data-control="freeze-column"
                                sort-direction="{{ $sortColumn == 'type_of_business' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8 bg-info" data-column="type_of_business">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Loại hình kinh doanh
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'type_of_business' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('tax_identification_number', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="tax_identification_number" data-control="freeze-column"
                                sort-direction="{{ $sortColumn == 'tax_identification_number' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8 bg-info" data-column="tax_identification_number">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mã số thuế
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'tax_identification_number' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('phone', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="phone"
                                sort-direction="{{ $sortColumn == 'phone' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="phone">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Điện thoại
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'phone' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('age', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="age"
                                sort-direction="{{ $sortColumn == 'age' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="age">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Độ tuổi
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'age' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('birthday', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="birthday"
                                sort-direction="{{ $sortColumn == 'birthday' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="birthday">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ngày sinh
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'birthday' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('email', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="email"
                                sort-direction="{{ $sortColumn == 'email' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="email">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Email
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'email' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('address', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="address"
                                sort-direction="{{ $sortColumn == 'address' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="address">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Địa Chỉ
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'address' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('country', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="country"
                                sort-direction="{{ $sortColumn == 'country' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="country">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Quốc gia
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'country' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('city', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="city"
                                sort-direction="{{ $sortColumn == 'city' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="city">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thành phố
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'city' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('district', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="district"
                                sort-direction="{{ $sortColumn == 'district' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="district">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Quận/ Huyện
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'district' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('ward', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="ward"
                                sort-direction="{{ $sortColumn == 'ward' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="ward">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Phường
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'ward' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif


                        @if (in_array('school', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="school"
                                sort-direction="{{ $sortColumn == 'school' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="school">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Trường
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'school' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('created_at', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="created_at"
                                sort-direction="{{ $sortColumn == 'created_at' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="created_at">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ngày tạo
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'created_at' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('updated_at', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="updated_at"
                                sort-direction="{{ $sortColumn == 'updated_at' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="updated_at">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ngày cập nhật
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'updated_at' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        <th class="min-w-125px text-left">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @foreach ($contacts as $contact)
                        <tr list-control="item">
                            <td class="ps-1">
                                <div class="form-check form-check-sm form-check-custom">
                                    <input data-item-id="{{ $contact->id }}" list-action="check-item"
                                        class="form-check-input" type="checkbox" value="{{ $contact->id }}" />
                                </div>
                            </td>
                            @if ((in_array('code', $columns) || in_array('all', $columns)) && \App\Models\User::first()->can('update', $contact))
                                <td data-column="code">
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex flex-column">
                                            <a row-action="update"
                                                href="{{ action(
                                                    [App\Http\Controllers\Hk\ContactController::class, 'edit'],
                                                    [
                                                        'id' => $contact->id,
                                                    ],
                                                ) }}"
                                                class="mb-1 text-nowrap">{{ $contact->code }}</a>
                                        </div>
                                    </div>
                                </td>
                            @endif
                            @if ((in_array('name', $columns) || in_array('all', $columns)) && \App\Models\User::first()->can('update', $contact))
                                <td data-column="name" data-control="freeze-column">
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex flex-column">
                                            <a row-action="update"
                                                href="{{ action(
                                                    [App\Http\Controllers\Hk\ContactController::class, 'edit'],
                                                    [
                                                        'id' => $contact->id,
                                                    ],
                                                ) }}"
                                                class="mb-1 fw-bold text-nowrap">{{ $contact->name }}</a>
                                        </div>
                                    </div>
                                </td>
                            @endif

                            @if (in_array('company_name', $columns) || in_array('all', $columns))
                                <td data-column="company_name">{{ $contact->company_name }}</td>
                            @endif

                            @if (in_array('type_of_business', $columns) || in_array('all', $columns))
                                <td data-column="type_of_business">{{ $contact->type_of_business }}</td>
                            @endif

                            @if (in_array('tax_identification_number', $columns) || in_array('all', $columns))
                                <td data-column="tax_identification_number">{{ $contact->tax_identification_number }}</td>
                            @endif

                            @if (in_array('phone', $columns) || in_array('all', $columns))
                                <td data-column="phone" list-control="phone-inline-edit"
                                    data-url="{{ action('\App\Http\Controllers\Hk\ContactController@save', [
                                        'id' => $contact->id,
                                    ]) }}"
                                    class="text-nowrap">
                                    <div>
                                        <div class="text-nowrap">
                                            <span inline-control="data-phone">
                                                @if ($contact->phone)
                                                    {{ $contact->displayPhoneNumberByUser(\App\Models\User::first()) }}
                                                @else
                                                    <span class="text-gray-500">Chưa có số điện thoại</span>
                                                @endif
                                            </span>
                                            <a href="javascript:;" inline-control="edit-button-phone">
                                                <span class="material-symbols-rounded fs-6 inline-edit-button">
                                                    edit
                                                </span>
                                            </a>
                                            <div inline-control="form-edit-phone" style="display:none;">
                                                <div class="d-flex align-items-center">
                                                    <input type="text" class="form-control" name="phone"
                                                        placeholder="" value="{{ $contact->displayPhoneNumberByUser(\App\Models\User::first()) }}"
                                                        inline-control="input-edit-phone" />
                                                    <button inline-control="close-button-phone" type="button"
                                                        class="btn btn-icon">
                                                        <span class="material-symbols-rounded">
                                                            close
                                                        </span>
                                                    </button>
                                                    <button type="button" inline-control="done-button-phone"
                                                        class="btn btn-icon">
                                                        <span class="material-symbols-rounded">
                                                            done
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @endif
                            @if (in_array('age', $columns) || in_array('all', $columns))
                                <td data-column="age">{{ $contact->age }}</td>
                            @endif
                            @if (in_array('birthday', $columns) || in_array('all', $columns))
                                <td data-column="birthday">
                                    {{ $contact->birthday ? date('d/m/Y', strtotime($contact->birthday)) : '--' }}</td>
                            @endif
                            @if (in_array('email', $columns) || in_array('all', $columns))
                                <td data-column="email" list-control="email-inline-edit"
                                    data-url="{{ action('\App\Http\Controllers\Hk\ContactController@save', [
                                        'id' => $contact->id,
                                    ]) }}"
                                    class="text-nowrap">
                                    <div>
                                        <div>
                                            <span inline-control="data-email">
                                                @if ($contact->email)
                                                    {{ $contact->email }}
                                                @else
                                                    <span class="text-gray-500">Chưa có email</span>
                                                @endif
                                            </span>
                                            <a href="javascript:;" inline-control="edit-button-email">
                                                <span class="material-symbols-rounded fs-6 inline-edit-button">
                                                    edit
                                                </span>
                                            </a>
                                            <div inline-control="form-edit-email" style="display:none;">
                                                <div class="d-flex align-items-center">
                                                    <input type="email" class="form-control" name="email"
                                                        placeholder="e.g., sean@dellito.com"
                                                        value="{{ $contact->email }}"
                                                        inline-control="input-edit-email" />
                                                    <button inline-control="close-button-email" type="button"
                                                        class="btn btn-icon">
                                                        <span class="material-symbols-rounded">
                                                            close
                                                        </span>
                                                    </button>
                                                    <button type="button" inline-control="done-button-email"
                                                        class="btn btn-icon">
                                                        <span class="material-symbols-rounded">
                                                            done
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @endif
                            @if (in_array('address', $columns) || in_array('all', $columns))
                                <td data-column="address">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contact->address }}</a>
                                </td>
                            @endif

                            @if (in_array('country', $columns) || in_array('all', $columns))
                                <td data-column="country">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contact->country }}</a>
                                </td>
                            @endif

                            @if (in_array('city', $columns) || in_array('all', $columns))
                                <td data-column="city">
                                    <a href="javascript:;" class="text-hover-primary mb-1">{{ $contact->city }}</a>
                                </td>
                            @endif
                            @if (in_array('district', $columns) || in_array('all', $columns))
                                <td data-column="district">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contact->district }}</a>
                                </td>
                            @endif
                            @if (in_array('ward', $columns) || in_array('all', $columns))
                                <td data-column="ward">
                                    <a href="javascript:;" class="text-hover-primary mb-1">{{ $contact->ward }}</a>
                                </td>
                            @endif
                            @if (in_array('school', $columns) || in_array('all', $columns))
                                <td data-column="school">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contact->school }}</a>
                                </td>
                            @endif
                            @if (in_array('created_at', $columns) || in_array('all', $columns))
                                <td data-filter="mastercard" data-column="created_at">
                                    {{ $contact->created_at->format('d/m/Y') }}
                                </td>
                            @endif
                            @if (in_array('updated_at', $columns) || in_array('all', $columns))
                                <td data-filter="mastercard" data-column="updated_at">
                                    {{ $contact->updated_at->format('d/m/Y') }}
                                </td>
                            @endif
                            <td data-column="action">
                                <a href="javascript:;"
                                    class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    Thao tác
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                    data-kt-menu="true">
                                    <div class="menu-item px-3 d-none">
                                        <a href="{{ action(
                                            [App\Http\Controllers\Hk\ContactController::class, 'show'],
                                            [
                                                'id' => $contact->id,
                                            ],
                                        ) }}"
                                            class="menu-link px-3">Xem</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a row-action="update"
                                            href="{{ action(
                                                [App\Http\Controllers\Hk\ContactController::class, 'edit'],
                                                [
                                                    'id' => $contact->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Chỉnh sửa</a>
                                    </div>
                                    <div class="menu-item px-3 ">
                                        <a row-action="delete"
                                            href="{{ action(
                                                [App\Http\Controllers\Hk\ContactController::class, 'destroy'],
                                                [
                                                    'id' => $contact->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Xóa</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end::Table-->
        </div>

        <div class="mt-5">
            {{ $contacts->links() }}
        </div>
    @else
        <div class="py-15">
            <div class="text-center mb-7">
                <svg style="width:120px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 173.8 173.8">
                    <g style="isolation:isolate">
                        <g id="Layer_2" data-name="Layer 2">
                            <g id="layer1">
                                <path
                                    d="M173.8,86.9A86.9,86.9,0,0,1,0,86.9,86,86,0,0,1,20.3,31.2a66.6,66.6,0,0,1,5-5.6A87.3,87.3,0,0,1,44.1,11.3,90.6,90.6,0,0,1,58.6,4.7a87.6,87.6,0,0,1,56.6,0,90.6,90.6,0,0,1,14.5,6.6A85.2,85.2,0,0,1,141,18.8a89.3,89.3,0,0,1,18.5,20.3A86.2,86.2,0,0,1,173.8,86.9Z"
                                    style="fill:#cdcdcd" />
                                <path
                                    d="M159.5,39.1V127a5.5,5.5,0,0,1-5.5,5.5H81.3l-7.1,29.2c-.7,2.8-4.6,4.3-8.6,3.3s-6.7-4.1-6.1-6.9l6.3-25.6h-35a5.5,5.5,0,0,1-5.5-5.5V16.8a5.5,5.5,0,0,1,5.5-5.5h98.9A85.2,85.2,0,0,1,141,18.8,89.3,89.3,0,0,1,159.5,39.1Z"
                                    style="fill:#6a6a6a;mix-blend-mode:color-burn;opacity:0.2" />
                                <path d="M23.3,22.7V123a5.5,5.5,0,0,0,5.5,5.5H152a5.5,5.5,0,0,0,5.5-5.5V22.7Z"
                                    style="fill:#f5f5f5" />
                                <rect x="31.7" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <rect x="73.6" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <rect x="115.5" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <rect x="31.7" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <rect x="73.6" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <rect x="115.5" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <path d="M157.5,12.8A5.4,5.4,0,0,0,152,7.3H28.8a5.5,5.5,0,0,0-5.5,5.5v9.9H157.5Z"
                                    style="fill:#dbdbdb" />
                                <path d="M147.7,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,147.7,15Z"
                                    style="fill:#f5f5f5" />
                                <path d="M138.3,15a3.4,3.4,0,1,1,6.7,0,3.4,3.4,0,0,1-6.7,0Z" style="fill:#f5f5f5" />
                                <path d="M129,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,129,15Z" style="fill:#f5f5f5" />
                                <rect x="32.1" y="29.8" width="116.6" height="3.85" style="fill:#dbdbdb" />
                                <rect x="32.1" y="36.7" width="116.6" height="3.85" style="fill:#dbdbdb" />
                                <rect x="73.3" y="96.7" width="10.1" height="8.42"
                                    transform="translate(-38.3 152.9) rotate(-76.2)" style="fill:#595959" />
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
                Không có liên hệ!
            </p>
            <p class="text-center d-none">
                <a class="btn btn-outline btn-outline-default" id="addMarketingContact">
                    <span class="d-flex align-items-center">
                        <span class="material-symbols-rounded me-2">
                            person_add
                        </span>
                        <span>Thêm liên hệ mới</span>
                    </span>
                </a>
            </p>
        </div>
    @endif
</div>
<!--end::Card body-->
</div>
<script>
    $(function() {
        // check if add contact button exists. when list is empty.
        if (document.getElementById('addMarketingContact') !== null) {
            AddContact.init();
        }

        // set sort
        SortManager.setSort('{{ $sortColumn }}', '{{ $sortDirection }}');

        // vấn đề: khi list scroll qua trái, load lại list thì nó scroll lại cột đầu tiên
        // sửa: lưu lại vị trí khi sroll. sau khi load list thì scroll lại vị trí trước đó
        HorizonScrollFix.init();

        // ContactsList js
        ContactsListInline.init();

        // inside filter
        ContactsInsideFilter.init();
    });

    var ContactsInsideFilter = function() {
        var getSelectedValuesFromMultiSelect = function(select) {
            // Get an array of selected option elements
            var selectedOptions = Array.from(select.selectedOptions);

            // Extract values from selected options
            var selectedValues = selectedOptions
                .filter(function(option) {
                    return option.value.trim() !== ''; // Filter out empty values
                }).map(function(option) {
                    return option.value;
                });

            return selectedValues;
        };

        return {
            init: function() {
                // lead status fitler
                $('[list-control="lead-status-filter"]').on('change', function() {
                    var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                    ContactsList.getList().setLeadStatus(selectedValues);

                    // load list
                    ContactsList.getList().load();
                });

                // Phân loại nguồn fitler
                $('[list-control="source-type-filter"]').on('change', function() {
                    var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                    ContactsList.getList().setMarketingType(selectedValues);

                    // load list
                    ContactsList.getList().load();
                });
            }
        }
    }();

    var HorizonScrollFix = function() {
        var box;

        var setScroll = function(left) {
            window.contactsListScrollLeft = left;
        };

        var applyScroll = function() {
            box.scrollLeft(window.contactsListScrollLeft);
        }

        return {
            init: function() {
                box = $('.table-responsive');

                // apply current scroll
                applyScroll();

                // 
                box.on('scroll', function() {
                    setScroll(box.scrollLeft());
                });
            }
        }
    }();

    var AddContact = function() {
        return {
            init: function() {
                btnSubmit = document.getElementById('addMarketingContact');

                // click on create contact button in the empty list
                btnSubmit.addEventListener('click', function() {
                    CreateContactPopup.getPopup().load();
                })
            }
        }
    }();

    //
    var ContactsListInline = function() {
        return {
            init: function() {
                // salesperson inline edit
                document.querySelectorAll('[list-control="salepersion-inline-edit"]').forEach(control => {
                    var url = control.getAttribute('data-url');
                    var salespersonInlineEdit = new SalespersonInlineEdit({
                        container: control,
                        url: url,
                    });
                });

                // Email inline edit
                document.querySelectorAll('[list-control="email-inline-edit"]').forEach(control => {
                    var url = control.getAttribute('data-url');
                    var emailInlineEdit = new EmailInlineEdit({
                        container: control,
                        url: url,
                    });
                });

                //Phone inline edit
                document.querySelectorAll('[list-control="phone-inline-edit"]').forEach(control => {
                    var url = control.getAttribute('data-url');
                    var phoneInlineEdit = new PhoneInlineEdit({
                        container: control,
                        url: url,
                    });
                });

                //lead_status Inline edit
                document.querySelectorAll('[list-control="lead_status-inline-edit"]').forEach(control => {
                    var url = control.getAttribute('data-url');
                    var leadStatusInlineEdit = new LeadStatusInlineEdit({
                        container: control,
                        url: url,
                    });
                });
            }
        };
    }();

    var SalespersonInlineEdit = class {
        constructor(options) {
            this.container = options.container;
            this.saveUrl = options.url;

            //
            this.events();
        }

        getEditButton() {
            return this.container.querySelector('[inline-control="edit-button"]');
        }

        showFormBox() {
            this.getFormBox().style.display = 'inline-block';
        }

        hideFormBox() {
            this.getFormBox().style.display = 'none';
        }

        getFormBox() {
            return this.container.querySelector('[inline-control="form"]');
        }

        getDataContainer() {
            return this.container.querySelector('[inline-control="data"]')
        }

        hideDataContainer() {
            this.getDataContainer().style.display = 'none';
        }

        showDataContainer() {
            this.getDataContainer().style.display = 'inline-block';
        }

        updateDataBox(salepersone_name) {
            this.getDataContainer().innerHTML = salepersone_name;
        }

        getInputControl() {
            return this.container.querySelector('[inline-control="input"]');
        }

        getSaleperSonid() {
            return this.getInputControl().value;
        }

        hideEditButton() {
            this.getEditButton().style.display = 'none';
        }

        showEditButton() {
            this.getEditButton().style.display = 'inline-block';
        }

        getCloseButton() {
            return this.container.querySelector('[ inline-control="close"]');
        }

        save(afterSave) {
            var _this = this;
            // const that = this;
            $.ajax({
                method: 'POST',
                url: this.saveUrl,
                data: {
                    _token: "{{ csrf_token() }}",
                    salesperson_id: this.getSaleperSonid(),
                },
            }).done(function(response) {
                _this.updateDataBox(response.salepersone_name);

                // afterSave
                if (typeof(afterSave) !== 'undefined') {
                    afterSave();
                }
            }).fail(function() {

            });
        }

        setEditMode() {
            this.showFormBox();
            this.hideDataContainer();
            this.hideEditButton();
        }

        closeEditMode() {
            this.hideFormBox();
            this.showDataContainer();
            this.showEditButton();
        }

        events() {
            var _this = this;

            //click
            this.getEditButton().addEventListener('click', (e) => {
                this.setEditMode();
            })

            // close
            this.getCloseButton().addEventListener('click', (e) => {
                this.closeEditMode();
            });

            // Click để lưu thay đổi
            $(this.getInputControl()).on('change', (e) => {
                this.save(function() {
                    //
                    ASTool.alert({
                        message: 'Đã cập nhật nhân viên sales thành công!',
                        ok: function() {
                            // close box
                            _this.closeEditMode();

                            
                        }
                    });
                });
            });
        }
    };

    var EmailInlineEdit = class {
        constructor(options) {
            this.container = options.container;
            this.saveUrl = options.url;

            //
            this.events();
        }

        getEditButtonEmail() {
            return this.container.querySelector('[inline-control="edit-button-email"]');
        }
        hideEditButtonEmail() {
            this.getEditButtonEmail().style.display = 'none';
        }
        showEditButtonEmail() {
            this.getEditButtonEmail().style.display = 'inline-block';
        }

        getFormBoxEditEmail() {
            return this.container.querySelector('[inline-control="form-edit-email"]');
        }
        showFormBoxEditEmail() {
            this.getFormBoxEditEmail().style.display = 'inline-block';
        }
        hideFormBoxEditEmail() {
            this.getFormBoxEditEmail().style.display = 'none';
        }

        getDataContainerEmail() {
            return this.container.querySelector('[inline-control="data-email"]')
        }

        hideDataContainerEmail() {
            this.getDataContainerEmail().style.display = 'none';
        }

        showDataContainerEmail() {
            this.getDataContainerEmail().style.display = 'inline-block';
        }

        updateEmail(email) {
            this.getDataContainerEmail().innerHTML = email;
        }

        getInputControlEditEmail() {
            return this.container.querySelector('[inline-control="input-edit-email"]');
        }

        getCloseButtonEmail() {
            return this.container.querySelector('[inline-control="close-button-email"]');
        }

        // getEmail() {
        //     return this.getInputControlEditEmail().value;
        // }

        getDoneButtonEmail() {
            return this.container.querySelector('[inline-control="done-button-email"]');
        }

        save(afterSave) {
            var _this = this;
            // const that = this;
            $.ajax({
                method: 'POST',
                url: this.saveUrl,
                data: {
                    _token: "{{ csrf_token() }}",
                    // salesperson_id: this.getSaleperSonid(),
                    // email: this.getEmail(),
                    email: this.getInputControlEditEmail().value,
                },
            }).done(function(response) {
                _this.updateEmail(response.email);

                // afterSave
                if (typeof(afterSave) !== 'undefined') {
                    afterSave();
                }
            }).fail(function() {

            });
        }

        setEditEmail() {
            this.showFormBoxEditEmail();
            this.hideDataContainerEmail();
            this.hideEditButtonEmail();
        }

        closeEditEmail() {
            this.hideFormBoxEditEmail();
            this.showDataContainerEmail();
            this.showEditButtonEmail();
        }

        events() {
            var _this = this;

            //click
            this.getEditButtonEmail().addEventListener('click', (e) => {
                this.setEditEmail();
            })

            // close
            this.getCloseButtonEmail().addEventListener('click', (e) => {
                this.closeEditEmail();
            });

            // Click để lưu thay đổi
            $(this.getDoneButtonEmail()).on('click', (e) => {
                this.save(function() {
                    //
                    ASTool.alert({
                        message: 'Đã cập nhật email thành công!',
                        ok: function() {
                            // close box
                            _this.closeEditEmail();
                        }
                    });
                });
            });
        }
    };

    var PhoneInlineEdit = class {
        constructor(options) {
            this.container = options.container;
            this.saveUrl = options.url;

            //
            this.events();
        }

        getEditButtonPhone() {
            return this.container.querySelector('[inline-control="edit-button-phone"]');
        }
        hideEditButtonPhone() {
            this.getEditButtonPhone().style.display = 'none';
        }
        showEditButtonPhone() {
            this.getEditButtonPhone().style.display = 'inline-block';
        }

        getFormBoxEditPhone() {
            return this.container.querySelector('[inline-control="form-edit-phone"]');
        }
        showFormBoxEditPhone() {
            this.getFormBoxEditPhone().style.display = 'inline-block';
        }
        hideFormBoxEditPhone() {
            this.getFormBoxEditPhone().style.display = 'none';
        }

        getDataContainerPhone() {
            return this.container.querySelector('[inline-control="data-phone"]')
        }

        hideDataContainerPhone() {
            this.getDataContainerPhone().style.display = 'none';
        }

        showDataContainerPhone() {
            this.getDataContainerPhone().style.display = 'inline-block';
        }

        updatePhone(phone) {
            this.getDataContainerPhone().innerHTML = phone;
        }

        getInputControlEditPhone() {
            return this.container.querySelector('[inline-control="input-edit-phone"]');
        }

        getCloseButtonPhone() {
            return this.container.querySelector('[inline-control="close-button-phone"]');
        }

        getDoneButtonPhone() {
            return this.container.querySelector('[inline-control="done-button-phone"]');
        }

        save(afterSave) {
            var _this = this;
            $.ajax({
                method: 'POST',
                url: this.saveUrl,
                data: {
                    _token: "{{ csrf_token() }}",
                    phone: this.getInputControlEditPhone().value,
                },
            }).done(function(response) {
                _this.updatePhone(response.phone);

                // afterSave
                if (typeof(afterSave) !== 'undefined') {
                    afterSave();
                }
            }).fail(function() {

            });
        }

        setEditPhone() {
            this.showFormBoxEditPhone();
            this.hideDataContainerPhone();
            this.hideEditButtonPhone();
        }

        closeEditPhone() {
            this.hideFormBoxEditPhone();
            this.showDataContainerPhone();
            this.showEditButtonPhone();
        }

        events() {
            var _this = this;

            //click
            this.getEditButtonPhone().addEventListener('click', (e) => {
                this.setEditPhone();
            })

            // close
            this.getCloseButtonPhone().addEventListener('click', (e) => {
                this.closeEditPhone();
            });

            // Click để lưu thay đổi
            $(this.getDoneButtonPhone()).on('click', (e) => {
                this.save(function() {
                    //
                    ASTool.alert({
                        message: 'Đã cập nhật phone thành công!',
                        ok: function() {
                            // close box
                            _this.closeEditPhone();
                        }
                    });
                });
            });
        }
    };

    //
    var LeadStatusInlineEdit = class {
        constructor(options) {
            this.container = options.container;
            this.saveUrl = options.url;

            //
            this.events();
        }

        getEditButtonLeadStatus() {
            return this.container.querySelector('[inline-control="edit-button-lead_status"]');
        }

        showFormBoxLeadStatus() {
            this.getFormBoxLeadStatus().style.display = 'inline-block';
        }

        hideFormBoxLeadStatus() {
            this.getFormBoxLeadStatus().style.display = 'none';
        }

        getFormBoxLeadStatus() {
            return this.container.querySelector('[inline-control="form-lead_status"]');
        }

        getDataContainerLeadStatus() {
            return this.container.querySelector('[inline-control="data-lead_status"]')
        }

        hideDataContainerLeadStatus() {
            this.getDataContainerLeadStatus().style.display = 'none';
        }

        showDataContainerLeadStatus() {
            this.getDataContainerLeadStatus().style.display = 'inline-block';
        }

        updateLeadStatus(lead_status) {
            this.getDataContainerLeadStatus().innerHTML = lead_status;
        }

        getInputControlLeadStatus() {
            return this.container.querySelector('[inline-control="input-lead_status"]');
        }

        getLeadStatus() {
            return this.getInputControlLeadStatus().value;
        }

        hideEditButtonLeadStatus() {
            this.getEditButtonLeadStatus().style.display = 'none';
        }

        showEditButtonLeadStatus() {
            this.getEditButtonLeadStatus().style.display = 'inline-block';
        }

        getCloseButtonLeadStatus() {
            return this.container.querySelector('[ inline-control="close-lead_status"]');
        }

        save(afterSave) {
            var _this = this;
            // const that = this;
            $.ajax({
                method: 'POST',
                url: this.saveUrl,
                data: {
                    _token: "{{ csrf_token() }}",
                    lead_status: this.getLeadStatus(),
                },
            }).done(function(response) {
                _this.updateLeadStatus(response.lead_status);

                // afterSave
                if (typeof(afterSave) !== 'undefined') {
                    afterSave();
                }
            }).fail(function() {

            });
        }

        setEditModeLeadStatus() {
            this.showFormBoxLeadStatus();
            this.hideDataContainerLeadStatus();
            this.hideEditButtonLeadStatus();
        }

        closeEditModeLeadStatus() {
            this.hideFormBoxLeadStatus();
            this.showDataContainerLeadStatus();
            this.showEditButtonLeadStatus();
        }

        events() {
            var _this = this;

            //click
            this.getEditButtonLeadStatus().addEventListener('click', (e) => {
                this.setEditModeLeadStatus();
            })

            // close
            this.getCloseButtonLeadStatus().addEventListener('click', (e) => {
                this.closeEditModeLeadStatus();
            });

            // Click để lưu thay đổi
            $(this.getInputControlLeadStatus()).on('change', (e) => {
                this.save(function() {
                    //
                    ASTool.alert({
                        message: 'Đã cập nhật Lead Status thành công!',
                        ok: function() {
                            // close box
                            _this.closeEditModeLeadStatus();
                        }
                    });
                });
            });
        }
    };
</script>
<!--end::Card-->
