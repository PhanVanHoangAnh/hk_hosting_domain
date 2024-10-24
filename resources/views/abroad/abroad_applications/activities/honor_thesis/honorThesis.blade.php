<div class="row">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">1</span>
            </div>
            <div class="fw-semibold">
                Học luận
            </div>
        </div>
    </div>

    <div class="col-md-9">
        @if ($studentSections->count())
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_contacts_table">
                <thead>
                    <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 text-nowrap">
                        <th class="min-w-125px text-left ps-3">
                            <span class="d-flex align-items-center">
                                <span>
                                    số buổi đã xếp lớp
                                </span>
                            </span>
                        </th>
                        <th class="min-w-125px text-left">
                            <span class="d-flex align-items-center">
                                <span>
                                    Số buổi hủy bỏ
                                </span>
                            </span>
                        </th>
                        <th class="min-w-125px text-left">
                            <span class="d-flex align-items-center">
                                <span>
                                    Số buổi thực tế
                                </span>
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @php
                        $sectionCount = $studentSections->count();
                        if ($sectionCount < 5) {
                            $formattedCount = '<5 buổi';
                            $rowClass = 'table-success';
                        } elseif ($sectionCount >= 5 && $sectionCount < 10) {
                            $formattedCount = '>5 buổi, <10 buổi';
                            $rowClass = 'table-warning';
                        } else {
                            $formattedCount = '>10 buổi';
                            $rowClass = 'table-danger';
                        }
                    @endphp
                    <tr list-control="item" class="{{ $rowClass }}">
                        <td class="text-left ps-1">
                            {{$sectionCount}}  buổi
                        </td>
                        <td class="text-left ps-1">
                            {{ $cancelSessionsCount }} buổi
                        </td>
                        <td class="text-left ps-1">
                            {{ $presentSessionsCount }} buổi

                        </td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="alert alert-danger" role="alert">
                Chưa xếp lớp
            </div>
        @endif
    </div>
</div>
