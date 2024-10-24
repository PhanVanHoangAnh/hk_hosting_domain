<style>
    .item-row.selected {
        background-color: #f0f0f0;
    }
    .item-row.hovered {
        background-color: #e6e6e6;
    }
</style>

<table class="table align-middle table-row-dashed fs-6 gy-5">
    <thead>
        <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap item-row">
            <th class="w-10px pe-2 ps-1">
                <div class="form-check form-check-sm form-check-custom me-3">
                    <input list-action="check-all" class="form-check-input d-none" type="checkbox"/>
                </div>
            </th>
            <th
                class="min-w-125px text-left">
                <span class="d-flex align-items-center">
                    <span>
                        Tên hoạt động
                    </span>
                </span>
            </th>
            <th
                class="min-w-125px text-left" data-column="start_at">
                <span class="d-flex align-items-center">
                    <span>
                        Thời điểm bắt đầu
                    </span>
                </span>
            </th>
            <th
                class="min-w-125px text-left" data-column="end_at">
                <span class="d-flex align-items-center">
                    <span>
                        Thời điểm kết thúc
                    </span>
                </span>
            </th>
        </tr>
    </thead>
    <tbody class="text-gray-600">
        @foreach ($abroadApplications as $abroadApplication)
            <tr list-control="item" class="item-row {{ isset($orderItem->extracurricular_id) && $orderItem->extracurricular_id == $abroadApplication->id ? 'hovered' : '' }}" data-bs-trigger="hover">
                <td class="text-left ps-1">
                    <div class="form-check form-check-sm form-check-custom">
                        <input data-item-id="{{ $abroadApplication->id }}" list-action="check-item" {{ isset($orderItem->extracurricular_id) && $orderItem->extracurricular_id == $abroadApplication->id ? 'checked' : '' }}
                            class="form-check-input demo-item-checkbox" name="extracurricular_id" value="{{ $abroadApplication->id }}" type="radio"/>
                    </div>
                </td>
                <td class="text-left mb-1 text-nowrap"
                    data-filter="mastercard">
                    {{ $abroadApplication->name }}
                </td>
                <td data-column="start_at" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                    {{ $abroadApplication->start_at }}
                </td>
                <td data-column="end_at" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                    {{ $abroadApplication->end_at }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<x-input-error :messages="$errors->get('extracurricular_id')" class="mt-2"/>

<script>
    $(document).ready(function() {
        $('.item-row').on('click', function() {
            var checkbox = $(this).find('.demo-item-checkbox');
            var isChecked = checkbox.prop('checked');

            $('.demo-item-checkbox').prop('checked', false);
            $('.item-row').removeClass('selected');

            checkbox.prop('checked', !isChecked);
            $(this).toggleClass('selected', !isChecked);
        });

        $('.item-row').hover(
            function() {
                $(this).addClass('hovered');
            },
            function() {
                $(this).removeClass('hovered');
            }
        );
    });
</script>

