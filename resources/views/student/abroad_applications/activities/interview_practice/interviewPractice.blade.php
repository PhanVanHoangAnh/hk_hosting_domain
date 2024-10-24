<div class="row">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">4</span>
            </div>
            <div class="fw-semibold">
                Luyện phỏng vấn
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
                                    Số buổi đã xếp lớp tham gia học
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
                    
                    <tr list-control="item">
                        <td class="text-left ps-1">
                            @php
                                $sectionCount = $studentSections->count();
                                if ($sectionCount < 5) {
                                    $formattedCount = '<5 buổi';
                                } elseif ($sectionCount >= 5 && $sectionCount < 10) {
                                    $formattedCount = '>5 buổi, <10 buổi';
                                } else {
                                    $formattedCount = '>10 buổi';
                                }
                            @endphp
                            {{ $formattedCount }}
                            
                        </td>
                        <td class="text-left ps-1"> 
                            {{$cancelSessionsCount}} buổi
                        </td>
                        <td class="text-left ps-1"> 
                            {{$presentSessionsCount}} buổi
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