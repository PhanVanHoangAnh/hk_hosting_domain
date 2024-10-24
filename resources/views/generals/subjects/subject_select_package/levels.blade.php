@php
    $levelFormId = "levels-" . uniqId();
@endphp

<div class="col-lg-12 col-md-12 col-sm-12 col-12" data-form="{{ $levelFormId }}">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-outline" selector-box="level">
                <label class="fs-6 fw-semibold mb-2" for="level-create-select">Trình độ</label>
                <select data-type="product-level" id="level-create-select" 
                    class="form-select form-control" 
                    name="level"
                    data-control="select2" 
                    data-dropdown-parent="#{{ $parentId }}" 
                    data-placeholder="Chọn trình độ" 
                    data-allow-clear="true">
                    <option value="">Chọn trình độ</option>
                    @foreach($levels as $level)
                        <option value="{{ $level}}"  {{ isset($selectedLevel) && $selectedLevel == $level ? 'selected' : '' }}>{{ $level }}</option>
                    @endforeach
                </select>

                {{-- Error --}}
                @if (isset($levelError)) 
                    <span class="text-danger text-center">{{ $levelError }}</span>
                @endif
            </div>
        </div>
    </div>
</div>