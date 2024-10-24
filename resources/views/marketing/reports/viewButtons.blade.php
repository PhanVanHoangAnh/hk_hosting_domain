@if (count($views))
    <div class="d-flex flex-row">
        @foreach ($views as $name => $data)
            <div class="btn-group me-2" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light" view-control="load" view-name="{{ $name }}">
                    {{ $name }}
                </button>
                <button type="button" class="btn btn-light btn-icon" view-control="remove" view-name="{{ $name }}">
                    <span class="material-symbols-rounded">delete</span>
                </button>
            </div>
        @endforeach
    </div>
@else
    <div class="mt-5 mb-2">
        <span class="d-flex align-items-center">
            <span class="material-symbols-rounded me-2">
                info
            </span>
            <span>
                Người dùng chưa có báo cáo lưu sẵn.
                Chọn cấu hình báo cáo và nhấn nút <strong>Lưu báo cáo</strong> bên dưới để thêm.
            </span>
        </span>
    </div>
@endif
