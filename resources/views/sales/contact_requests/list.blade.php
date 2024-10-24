<!--begin::Card body-->
<div class="card-body pt-0 mt-5">
    @if ($contactRequests->count())
        <div class="table-responsive table-head-sticky freeze-column" style="max-height:calc(100vh - 420px);">
            <!--begin::Table-->
            {{-- <table class="table table-striped table-bordered table-hover table-header-fixed dataTable no-footer" id="kt_contacts_table"> --}}
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_contacts_table">
                <thead>
                    <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 text-nowrap">
                        <th class="w-10px pe-2 ps-1">
                            <div class="form-check form-check-sm form-check-custom">
                                <input list-action="check-all" class="form-check-input" type="checkbox" />
                            </div>
                        </th>

                        @if (in_array('code', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="id"
                                sort-direction="{{ $sortColumn == 'id' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="code">
                                <span class="d-flex align-items-center">
                                    <span>
                                        {{ trans('messages.contact_request.code') }}
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'id' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('name', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="contacts.name" data-control="freeze-column"
                                sort-direction="{{ $sortColumn == 'contacts.name' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8 bg-info" data-column="name">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Khách hàng/Liên hệ
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'contacts.name' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('phone', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="contacts.phone"
                                sort-direction="{{ $sortColumn == 'contacts.phone' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="phone">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Điện thoại
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'contacts.phone' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('father', $columns) || in_array('all', $columns))
                            <th class="min-w-100px fs-8" data-column="father">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Cha
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('mother', $columns) || in_array('all', $columns))
                            <th class="min-w-100px fs-8" data-column="mother">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mẹ
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('time_to_call', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="time_to_call"
                                sort-direction="{{ $sortColumn == 'time_to_call' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="time_to_call">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thời gian phù hợp
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'time_to_call' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('birthday', $columns) || in_array('birthday', $columns))
                            <th list-action="sort" sort-by="contacts.birthday"
                                sort-direction="{{ $sortColumn == 'contacts.birthday' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="birthday">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ngày sinh
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'contacts.birthday' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('age', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="contacts.age"
                                sort-direction="{{ $sortColumn == 'contacts.age' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="age">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Độ tuổi học sinh
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'contacts.age' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('email', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="contacts.email"
                                sort-direction="{{ $sortColumn == 'contacts.email' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="email">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Email
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'contacts.email' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('address', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="contacts.address"
                                sort-direction="{{ $sortColumn == 'contacts.address' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="address">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Địa Chỉ
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'contacts.address' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('deadline', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="assigned_at"
                                sort-direction="{{ $sortColumn == 'deadline' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="deadline">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thời hạn
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'deadline' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('demand', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="demand" style="min-width:200px!important;"
                                sort-direction="{{ $sortColumn == 'demand' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="demand">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Đơn hàng
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'demand' ? '' : 'text-muted' }}">
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
                            <th list-action="sort" sort-by="contacts.city"
                                sort-direction="{{ $sortColumn == 'contacts.city' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="city">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thành phố
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'contacts.city' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('district', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="contacts.district"
                                sort-direction="{{ $sortColumn == 'contacts.district' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="district">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Quận/ Huyện
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'contacts.district' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('ward', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="contacts.ward"
                                sort-direction="{{ $sortColumn == 'contacts.ward' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="ward">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Phường
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'contacts.ward' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('order', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="order"
                                sort-direction="{{ $sortColumn == 'order' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="order">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Hợp đồng
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'order' ? '' : 'text-muted' }}">
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

                        @if (in_array('efc', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="efc"
                                sort-direction="{{ $sortColumn == 'efc' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="efc">
                                <span class="d-flex align-items-center">
                                    <span>
                                        EFC
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'efc' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('list', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="list"
                                sort-direction="{{ $sortColumn == 'list' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="list">
                                <span class="d-flex align-items-center">
                                    <span>
                                        List
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'list' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('target', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="target"
                                sort-direction="{{ $sortColumn == 'target' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="target">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Target
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'target' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('source_type', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="source_type"
                                sort-direction="{{ $sortColumn == 'source_type' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="source_type">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Phân loại nguồn
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'source_type' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('channel', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="channel"
                                sort-direction="{{ $sortColumn == 'channel' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="channel">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Channel
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'channel' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('sub_channel', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="sub_channel"
                                sort-direction="{{ $sortColumn == 'sub_channel' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="sub_channel">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Sub-Channel
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'sub_channel' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('account_id', $columns) || in_array('all', $columns))
                            {{-- <th class="min-w-125px fs-8" data-column="sale_person">Salesperson</th> --}}
                            <th list-action="sort" sort-by="account_id"
                                sort-direction="{{ $sortColumn == 'account_id' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="account_id">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Salesperson
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'account_id' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif


                        @if (in_array('campaign', $columns) || in_array('all', $columns))
                            {{-- <th class="min-w-125px fs-8" data-column="campaign">Chiến dịch</th> --}}
                            <th list-action="sort" sort-by="campaign"
                                sort-direction="{{ $sortColumn == 'campaign' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="campaign">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Campaign
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'campaign' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('adset', $columns) || in_array('all', $columns))
                            {{-- <th class="min-w-125px fs-8" data-column="adset">Bộ quảng cáo</th> --}}
                            <th list-action="sort" sort-by="adset"
                                sort-direction="{{ $sortColumn == 'adset' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="adset">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Adset
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'adset' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('ads', $columns) || in_array('all', $columns))
                            {{-- <th class="min-w-125px fs-8" data-column="ads">Tên quảng cáo</th> --}}
                            <th list-action="sort" sort-by="ads"
                                sort-direction="{{ $sortColumn == 'ads' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="ads">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ads
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'ads' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('device', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="device"
                                sort-direction="{{ $sortColumn == 'device' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="device">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Device
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'device' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('placement', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="placement"
                                sort-direction="{{ $sortColumn == 'placement' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="placement">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Placement
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'placement' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('term', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="term"
                                sort-direction="{{ $sortColumn == 'term' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="term">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Term
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'term' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('type_match', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="type_match"
                                sort-direction="{{ $sortColumn == 'type_match' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="type_match">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Type Match
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'type_match' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('first_url', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="first_url"
                                sort-direction="{{ $sortColumn == 'first_url' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="first_url">
                                <span class="d-flex align-items-center">
                                    <span>
                                        First URL
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'first_url' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('last_url', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="last_url"
                                sort-direction="{{ $sortColumn == 'last_url' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="last_url">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Conversion Url
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'last_url' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif


                        @if (in_array('contact_owner', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="contact_owner"
                                sort-direction="{{ $sortColumn == 'contact_owner' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="contact_owner">
                                <span class="d-flex align-items-center">
                                    <span>
                                        ContactRequest Owner
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'contact_owner' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('lead_status', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="lead_status"
                                sort-direction="{{ $sortColumn == 'lead_status' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="lead_status">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Lead Status
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'lead_status' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('lifecycle_stage', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="lifecycle_stage"
                                sort-direction="{{ $sortColumn == 'lifecycle_stage' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="lifecycle_stage">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Lifecycle stage
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'lifecycle_stage' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('gclid', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="gclid"
                                sort-direction="{{ $sortColumn == 'gclid' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="gclid">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Gclid
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'gclid' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('fbcid', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="fbcid"
                                sort-direction="{{ $sortColumn == 'fbcid' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="fbcid">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Fbclid
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'fbcid' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('reminder', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="reminder"
                                sort-direction="{{ $sortColumn == 'reminder' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="reminder">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Đặt lịch
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'reminder' ? '' : 'text-muted' }}">
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
                        @if (in_array('assigned_at', $columns) || in_array('all', $columns))
                            <th 
                                class="min-w-100px fs-8" data-column="assigned_at">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thời điểm bàn giao
                                    </span>
                                    
                                </span>
                            </th>
                        @endif

                        @if (in_array('tag', $columns) || in_array('all', $columns))
                            {{-- <th class="min-w-75px fs-8" data-column="tag">Tag</th> --}}
                            <th list-action="sort" sort-by="tag"
                                sort-direction="{{ $sortColumn == 'tag' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="tag">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tag
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'tag' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('pic', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="pic"
                                sort-direction="{{ $sortColumn == 'pic' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="pic">
                                <span class="d-flex align-items-center">
                                    <span>
                                        PIC
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'pic' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('note_log', $columns) || in_array('all', $columns))
                            <th class="min-w-100px fs-8" data-column="note_log">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ghi chú
                                    </span>

                                </span>
                            </th>
                        @endif

                        <th class="min-w-125px text-left ">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @foreach ($contactRequests as $contactRequest)
                        <tr list-control="item">
                            <td class="ps-1">
                                <div class="form-check form-check-sm form-check-custom">
                                    <input data-item-id="{{ $contactRequest->id }}" list-action="check-item"
                                        class="form-check-input" type="checkbox"
                                        value="{{ $contactRequest->id }}" />
                                </div>
                            </td>
                            @if (in_array('code', $columns) || in_array('all', $columns))
                                <td data-column="code">{{ $contactRequest->code }}</td>
                            @endif
                            @if (in_array('name', $columns) || in_array('all', $columns))
                                <td data-column="name" data-control="freeze-column">
                                    <div class="d-flex align-items-center">
                                        <!--begin:: Avatar -->
                                        {{-- <div class="symbol symbol-30px overflow-hidden me-5">
                                            <a href="javascript:;">
                                                <div class="symbol-label">
                                                    <img src="{{ url('/core/assets/media/avatars/blank.png') }}"
                            alt="image" class="w-100" alt="{{ $contactRequest->contact->name }}" />
                        </div>
                        </a>
    </div> --}}
                                        <!--end::Avatar-->
                                        <!--begin::User details-->
                                        <div class="d-flex flex-column">
                                            <span
                                                class="mb-1 fw-bold text-nowrap">{{ $contactRequest->contact->name }}
                                            </span>
                                            {{-- <span class="text-gray-600">{{ $contactRequest->contact->email }}</span> --}}
                                        </div>
                                        <!--begin::User details-->
                                    </div>


                                </td>
                            @endif
                            @if (in_array('phone', $columns) || in_array('all', $columns))
                                {{-- <td data-column="phone">{{ $contactRequest->contact->phone }}</td> --}}
                                <td data-column="phone" list-control="phone-inline-edit"
                                    data-url="{{ action('\App\Http\Controllers\Sales\ContactController@save', [
                                        'id' => $contactRequest->contact->id,
                                    ]) }}"
                                    class="text-nowrap">
                                    {{-- <a href="javascript:;" class="text-hover-primary mb-1">{{ $contactRequest->contact->email }}</a> --}}
                                    <div>
                                        <div class="text-nowrap">
                                            <span inline-control="data-phone">
                                                @if ($contactRequest->contact->phone)
                                                    {{ $contactRequest->contact->phone }}
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
                                                        placeholder="" value="{{ $contactRequest->contact->phone }}"
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
                            @if (in_array('father', $columns) || in_array('all', $columns))
                                <td class="text-nowrap" data-column="father">
                                    @if ($contactRequest->contact->getFather())
                                        {{ $contactRequest->contact->getFather()->name }}
                                        @if ($contactRequest->contact->getFather()->phone)
                                            <div>
                                                (📱 {{ $contactRequest->contact->getFather()->phone }})
                                            </div>
                                        @endif
                                    @endif
                                </td>
                            @endif
                            @if (in_array('mother', $columns) || in_array('all', $columns))
                                <td class="text-nowrap" data-column="mother">
                                    @if ($contactRequest->contact->getMother())
                                        {{ $contactRequest->contact->getMother()->name }}
                                        @if ($contactRequest->contact->getMother()->phone)
                                            <div>
                                                (📱 {{ $contactRequest->contact->getMother()->phone }})
                                            </div>
                                        @endif
                                    @endif
                                </td>
                            @endif
                            @if (in_array('time_to_call', $columns) || in_array('all', $columns))
                                <td data-column="time_to_call">{{ $contactRequest->time_to_call }}</td>
                            @endif

                            @if (in_array('birthday', $columns) || in_array('all', $columns))
                                <td data-column="birthday">
                                    {{ $contactRequest->contact->birthday ? date('d/m/Y', strtotime($contactRequest->contact->birthday)) : '--' }}
                                    
                                </td>
                            @endif
                            @if (in_array('age', $columns) || in_array('all', $columns))
                                <td data-column="age">{{ $contactRequest->contact->age }}</td>
                            @endif
                            @if (in_array('email', $columns) || in_array('all', $columns))
                                <td data-column="email" list-control="email-inline-edit"
                                    data-url="{{ action('\App\Http\Controllers\Sales\ContactController@save', [
                                        'id' => $contactRequest->contact->id,
                                    ]) }}"
                                    class="text-nowrap">
                                    {{-- <a href="javascript:;" class="text-hover-primary mb-1">{{ $contactRequest->contact->email }}</a> --}}
                                    <div>
                                        <div>
                                            <span inline-control="data-email">
                                                @if ($contactRequest->contact->email)
                                                    {{ $contactRequest->contact->email }}
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
                                                        value="{{ $contactRequest->contact->email }}"
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
                                        class="text-hover-primary mb-1">{{ $contactRequest->address }}</a>
                                </td>
                            @endif

                            @if (in_array('deadline', $columns) || in_array('all', $columns))
                                <td data-column="deadline" class="text-nowrap">
                                    @if ($contactRequest->assigned_at)
                                        <span
                                            class="{{ $contactRequest->isOutdated() ? 'text-danger' : '' }}">{{ $contactRequest->getDeadlineCountDownInMinutes() }}</span>
                                    @else
                                        <span class="text-muted">--</span>
                                    @endif
                                </td>
                            @endif

                            @if (in_array('demand', $columns) || in_array('all', $columns))
                                <td data-column="demand">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contactRequest->demand }}</a>
                                </td>
                            @endif

                            @if (in_array('country', $columns) || in_array('all', $columns))
                                <td data-column="country">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contactRequest->country }}</a>
                                </td>
                            @endif

                            @if (in_array('city', $columns) || in_array('all', $columns))
                                <td data-column="city">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contactRequest->city }}</a>
                                </td>
                            @endif
                            @if (in_array('district', $columns) || in_array('all', $columns))
                                <td data-column="district">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contactRequest->district }}</a>
                                </td>
                            @endif
                            @if (in_array('ward', $columns) || in_array('all', $columns))
                                <td data-column="ward">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contactRequest->ward }}</a>
                                </td>
                            @endif
                            @if (in_array('order', $columns) || in_array('all', $columns))
                                <td data-column="order">
                                    <span class="">
                                        @if ($contactRequest->orders()->count())
                                            <span class="badge badge-info">Đã có HĐ</span>
                                        @else
                                            <span class="badge badge-primary">Chưa có HĐ</span>
                                        @endif
                                    </span>
                                </td>
                            @endif
                            @if (in_array('school', $columns) || in_array('all', $columns))
                                <td data-column="school">
                                    <a href=""
                                        class="text-hover-primary mb-1">{{ $contactRequest->school }}</a>
                                </td>
                            @endif
                            @if (in_array('efc', $columns) || in_array('all', $columns))
                                <td data-column="efc">
                                    <a href="javascript:;" class="text-hover-primary mb-1">
                                        @if (isset($contactRequest->efc) && $contactRequest->efc !== '')
                                            {{ $contactRequest->efc . ' $' }}
                                        @else
                                            {{ $contactRequest->efc }}
                                        @endif
                                    </a>
                                </td>
                            @endif
                            @if (in_array('list', $columns) || in_array('all', $columns))
                                <td data-column="list">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contactRequest->list }}</a>
                                </td>
                            @endif
                            @if (in_array('target', $columns) || in_array('all', $columns))
                                <td data-column="target">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contactRequest->target }}</a>
                                </td>
                            @endif
                            @if (in_array('source_type', $columns) || in_array('all', $columns))
                                <td class="text-nowrap" data-column="source_type">
                                    {{ trans('messages.contact_request.source_type.' . $contactRequest->source_type) }}
                                    {{-- {{ $contactRequest->source_type }} --}}
                                </td>
                            @endif
                            @if (in_array('channel', $columns) || in_array('all', $columns))
                                <td class="text-nowrap" data-column="channel">
                                    {{ $contactRequest->channel }}</td>
                            @endif
                            @if (in_array('sub_channel', $columns) || in_array('all', $columns))
                                <td class="text-nowrap" data-column="sub_channel">
                                    {{ $contactRequest->sub_channel }}</td>
                            @endif
                            @if (in_array('reminder', $columns) || in_array('all', $columns))
                                <td class="text-nowrap" data-column="reminder">
                                    {{ $contactRequest->reminder ? \Carbon\Carbon::parse($contactRequest->reminder)->format('H:i d/m/Y') : '--' }}
                                </td>
                            @endif
                            @if (in_array('account_id', $columns) || in_array('all', $columns))
                                <td data-column="account_id" list-control="salepersion-inline-edit"
                                    data-url="{{ action('\App\Http\Controllers\Sales\ContactRequestController@save', [
                                        'id' => $contactRequest->id,
                                    ]) }}"
                                    class="text-nowrap">
                                    <div>
                                        <div>
                                            <span inline-control="data">
                                                @if ($contactRequest->account)
                                                    {{ $contactRequest->account->name }}
                                                @else
                                                    <span class="text-gray-500">Chưa bàn giao</span>
                                                @endif
                                            </span>
                                            <a href="javascript:;" inline-control="edit-button">
                                                <span class="material-symbols-rounded fs-6 inline-edit-button">
                                                    edit
                                                </span>
                                            </a>
                                            <div inline-control="form" style="display:none;">
                                                <div class="d-flex align-items-center">
                                                    <select inline-control="input" class="form-select"
                                                        data-control="select2" data-placeholder="Select an option">
                                                        <option value="unassign">Chưa bàn giao</option>
                                                        @foreach ($accounts as $account)
                                                            <option
                                                                {{ $contactRequest->account_id == $account->id ? 'selected' : '' }}
                                                                value="{{ $account->id }}">{{ $account->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <button inline-control="close" type="button"
                                                        class="btn btn-icon">
                                                        <span class="material-symbols-rounded">
                                                            close
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @endif
                            @if (in_array('campaign', $columns) || in_array('all', $columns))
                                <td data-column="campaign">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contactRequest->campaign }}</a>
                                </td>
                            @endif
                            @if (in_array('adset', $columns) || in_array('all', $columns))
                                <td data-column="adset">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contactRequest->adset }}</a>
                                </td>
                            @endif
                            @if (in_array('ads', $columns) || in_array('all', $columns))
                                <td data-column="ads">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contactRequest->ads }}</a>
                                </td>
                            @endif
                            @if (in_array('device', $columns) || in_array('all', $columns))
                                <td data-column="device">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contactRequest->device }}</a>
                                </td>
                            @endif
                            @if (in_array('placement', $columns) || in_array('all', $columns))
                                <td data-column="placement">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contactRequest->placement }}</a>
                                </td>
                            @endif
                            @if (in_array('term', $columns) || in_array('all', $columns))
                                <td data-column="term">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contactRequest->term }}</a>
                                </td>
                            @endif
                            @if (in_array('type_match', $columns) || in_array('all', $columns))
                                <td data-column="type_match">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contactRequest->type_match }}</a>
                                </td>
                            @endif
                            @if (in_array('first_url', $columns) || in_array('all', $columns))
                                <td data-column="first_url">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contactRequest->first_url }}</a>
                                </td>
                            @endif
                            @if (in_array('last_url', $columns) || in_array('all', $columns))
                                <td data-column="last_url">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contactRequest->last_url }}</a>
                                </td>
                            @endif
                            @if (in_array('contact_owner', $columns) || in_array('all', $columns))
                                <td data-column="contact_owner">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contactRequest->contact_owner }}</a>
                                </td>
                            @endif
                            @if (in_array('lead_status', $columns) || in_array('all', $columns))
                                <td data-column="lead_status"
                                    @if (Auth::user()->can('updateLeadStatus', $contactRequest)) list-control="lead_status-inline-edit" @endif
                                    data-url="{{ action('\App\Http\Controllers\Sales\ContactRequestController@save', [
                                        'id' => $contactRequest->id,
                                    ]) }}"
                                    class="text-nowrap">
                                    <div>
                                        <div>
                                            <span inline-control="data-lead_status" class="badge bg-secondary">
                                                @if($contactRequest->lead_status)
                                                    {!! '<span class="text-gray-500">' . trans('messages.contact_request.lead_status.' . $contactRequest->lead_status) . '</span>' !!}
                                                @else
                                                    {!! '<span class="text-danger">Chưa khai thác</span>' !!}
                                                @endif
                                            </span>

                                            @if (Auth::user()->can('updateLeadStatus', $contactRequest))
                                                <a href="javascript:;" inline-control="edit-button-lead_status">
                                                    <span class="material-symbols-rounded fs-6 inline-edit-button">
                                                        edit
                                                    </span>
                                                </a>
                                                <div inline-control="form-lead_status" style="display:none; width: 100%;">
                                                    <div class="d-flex align-items-center">
                                                        <select inline-control="input-lead_status" class="form-select"
                                                            data-control="select2"
                                                            data-placeholder="Select an option">
                                                            <option value="">Select an option</option>
                                                            @foreach (App\Models\ContactRequest::getEditableLeadStatuses() as $type)
                                                                <option value="{{ $type }}"
                                                                    {{ $contactRequest->lead_status === $type ? 'selected' : '' }}>
                                                                    {{  trans('messages.contact_request.lead_status.' . $type) ?? 'None' }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <button inline-control="close-lead_status" type="button"
                                                            class="btn btn-icon">
                                                            <span class="material-symbols-rounded">
                                                                close
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            @endif
                            @if (in_array('lifecycle_stage', $columns) || in_array('all', $columns))
                                <td class="text-nowrap" data-column="lifecycle_stage">
                                    {{ $contactRequest->lifecycle_stage }}
                                </td>
                            @endif
                            @if (in_array('gclid', $columns) || in_array('all', $columns))
                                <td class="text-nowrap" data-column="gclid">
                                    {{ $contactRequest->gclid }}
                                </td>
                            @endif
                            @if (in_array('fbcid', $columns) || in_array('all', $columns))
                                <td class="text-nowrap" data-column="fbcid">
                                    {{ $contactRequest->fbcid }}
                                </td>
                            @endif
                            @if (in_array('created_at', $columns) || in_array('all', $columns))
                                <td data-filter="mastercard" data-column="created_at">
                                    {{ $contactRequest->created_at->format('d/m/Y') }}
                                </td>
                            @endif
                            @if (in_array('updated_at', $columns) || in_array('all', $columns))
                                <td data-filter="mastercard" data-column="updated_at">
                                    {{ $contactRequest->updated_at->format('d/m/Y') }}
                                </td>
                            @endif
                            @if (in_array('assigned_at', $columns) || in_array('all', $columns))
                                <td data-filter="mastercard" data-column="assigned_at">
                                    {{ $contactRequest->assigned_at ? \Carbon\Carbon::parse($contactRequest->assigned_at)->format('H:i d/m/Y') : '' }}

                                </td>
                            @endif
                            @if (in_array('tag', $columns) || in_array('all', $columns))
                                <td class="min-w-125px fs-8" data-column="tag">
                                    @foreach ($contactRequest->tags as $tag)
                                        <span class="badge badge-primary">{{ $tag->name }}</span>
                                    @endforeach
                                </td>
                            @endif
                            @if (in_array('pic', $columns) || in_array('all', $columns))
                                <td data-column="pic">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $contactRequest->pic }}</a>
                                </td>
                            @endif
                            @if (in_array('note_log', $columns) || in_array('all', $columns))
                                <td class="text-nowrap" style="width: auto" data-column="note_log">
                                    <div class="d-flex">
                                        <span class="d-inline-block  text-truncate w-100 pe-3 list-note-log-col">
                                            <?php
                                            // $content = DB::table('note_logs')
                                            //     ->where('contact_id', $contactRequest->contact->id)
                                            //     ->where('status', 'active')
                                            //     ->where('system_add','false')
                                            //     ->orderBy('updated_at', 'desc')
                                            //     ->value('content');
                                            // echo $content;
                                            $content = DB::table('note_logs')
                                                ->where('status', 'active')
                                                ->where('contact_request_id', $contactRequest->id)
                                                ->orderBy('updated_at', 'desc')
                                                ->value('content');
                                            ?>
                                            <span data-bs-toggle="tooltip" title="{{ strip_tags($content) }}">
                                                @if ($content)
                                                    {{ strip_tags($content) }}
                                                @else
                                                    <span class="text-muted small text-center d-block" style="color:#aaa!important">Chưa có ghi chú trên hệ thống</span>
                                                @endif
                                            </span>
                                        </span>
                                        <a row-action="note-logs-contact"
                                            href="{{ action(
                                                [App\Http\Controllers\Sales\NoteLogController::class, 'noteLogsPopup'],
                                                [
                                                    'id' => $contactRequest->id,
                                                ],
                                            ) }}">
                                            <span class="material-symbols-rounded fs-2 text-dark inline-edit-button">
                                                other_admission
                                            </span>
                                        </a>
                                    </div>
                                    @if ($contactRequest->note_sales)
                                        <div class="mt-2 px-2 py-0 border bg-light d-flex align-items-center" data-bs-toggle="tooltip" title="(I): {{ strip_tags($contactRequest->note_sales) }}">
                                            <span class="d-inline-block text-truncate list-note-log-col">(I): {{ $contactRequest->note_sales }}</span>
                                        </div>
                                    @endif
                                </td>
                            @endif
                            <td data-column="action">
                                <a href="javascript:;"
                                    class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    Thao tác
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4 {{ $contactRequest->status == App\Models\ContactRequest::STATUS_DELETED ? 'd-none': ''}}"
                                    data-kt-menu="true">
                                    @if (!$contactRequest->hasOrders())
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a list-action="add-order"
                                                href="{{ action(
                                                    [App\Http\Controllers\Sales\OrderController::class, 'pickContact'],
                                                    [
                                                        'contact_request_id' => $contactRequest->id,
                                                    ],
                                                ) }}"
                                                class="menu-link px-3">Thêm hợp đồng</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a list-action="add-order"
                                                href="{{ action(
                                                    [App\Http\Controllers\Sales\OrderController::class, 'pickContactForRequestDemo'],
                                                    [
                                                        'contact_request_id' => $contactRequest->id,
                                                    ],
                                                ) }}"
                                                class="menu-link px-3">Yêu cầu học thử</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        
                                        <!--end::Menu item-->
                                    @endif
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3 d-none">
                                        <a href="{{ action(
                                            [App\Http\Controllers\Sales\ContactRequestController::class, 'show'],
                                            [
                                                'id' => $contactRequest->id,
                                            ],
                                        ) }}"
                                            class="menu-link px-3">Xem</a>
                                    </div>
                                    <!--end::Menu item-->
                                    @if (Auth::user()->can('update', $contactRequest))
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a row-action="update"
                                                href="{{ action(
                                                    [App\Http\Controllers\Sales\ContactRequestController::class, 'edit'],
                                                    [
                                                        'id' => $contactRequest->id,
                                                    ],
                                                ) }}"
                                                class="menu-link px-3">Chỉnh sửa</a>
                                        </div>
                                        <!--end::Menu item-->
                                    @endif
                                    <div class="menu-item px-3 d-none">
                                        <a row-action="update"
                                            href="{{ action(
                                                [App\Http\Controllers\Sales\ContactRequestController::class, 'showFreeTimeSchedule'],
                                                [
                                                    'id' => $contactRequest->contact->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Thêm lịch rảnh</a>
                                    </div>
                                    <div class="menu-item px-3 ">
                                        <a row-action="update"
                                            href="{{ action(
                                                [App\Http\Controllers\AccountKpiNoteController::class, 'create'],
                                                [
                                                    'id' => $contactRequest->contact->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Thêm dự thu</a>
                                    </div>
                                    <!--begin::Menu item-->

                                    @if (Auth()->user()->can('delete', $contactRequest))
                                        <div class="menu-item px-3">
                                            <a row-action="delete"
                                                href="{{ action(
                                                    [App\Http\Controllers\Sales\ContactRequestController::class, 'destroy'],
                                                    [
                                                        'id' => $contactRequest->id,
                                                    ],
                                                ) }}"
                                                class="menu-link px-3">Xóa</a>
                                        </div>
                                    @endif

                                    <div class="menu-item px-3 text-start d-none">
                                        <a row-action="handover-contact"
                                            href="{{ action(
                                                [App\Http\Controllers\Sales\ContactRequestController::class, 'addHandover'],
                                                [
                                                    'id' => $contactRequest->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Bàn giao nhân viên sales</a>
                                    </div>


                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end::Table-->
        </div>

        <div class="mt-5">
            {{ $contactRequests->links() }}
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
                Không có đơn hàng!
            </p>
            <p class="text-center">
                <a class="btn btn-outline btn-outline-default" id="addMarketingContactRequest">
                    <span class="d-flex align-items-center">
                        <span class="material-symbols-rounded me-2">
                            person_add
                        </span>
                        <span>Thêm đơn hàng mới</span>
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
        if (document.getElementById('addMarketingContactRequest') !== null) {
            AddContactRequest.init();
        }

        // set sort
        SortManager.setSort('{{ $sortColumn }}', '{{ $sortDirection }}');

        // vấn đề: khi list scroll qua trái, load lại list thì nó scroll lại cột đầu tiên
        // sửa: lưu lại vị trí khi sroll. sau khi load list thì scroll lại vị trí trước đó
        HorizonScrollFix.init();

        // ContactRequestsList js
        ContactRequestsListInline.init();

        // inside filter
        ContactRequestsInsideFilter.init();

        //
        new AddOrderPopup({
            links: document.querySelectorAll('[list-action="add-order"]'),
            popup: pickContactPopup,
        });
    });

    var AddOrderPopup = class {
        constructor(options) {
            this.links = options.links;
            this.popup = options.popup;

            //
            this.events();
        }

        events() {
            this.links.forEach((link) => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    var url = link.getAttribute('href');

                    this.popup.getPopup().url = url;
                    this.popup.getPopup().load();
                });
            });
        }
    }

    var ContactRequestsInsideFilter = function() {
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

                    ContactRequestsList.getList().setLeadStatus(selectedValues);

                    // load list
                    if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                });

                // Phân loại nguồn fitler
                $('[list-control="source-type-filter"]').on('change', function() {
                    var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                    ContactRequestsList.getList().setMarketingType(selectedValues);

                    // load list
                    if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
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

    var AddContactRequest = function() {
        return {
            init: function() {
                btnSubmit = document.getElementById('addMarketingContactRequest');

                // click on create contact button in the empty list
                btnSubmit.addEventListener('click', function() {
                    CreateContactRequestPopup.getPopup().load();
                })
            }
        }
    }();

    //
    var ContactRequestsListInline = function() {
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

                    // reload sidebar
                    aSidebar.reloadCounters();
                });
            });
        }
    };
</script>
<!--end::Card-->
