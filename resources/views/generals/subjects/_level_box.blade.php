<div class="form-outline" selector-box="level">
    <label class="fs-6 fw-semibold required mb-2" for="level-create-select">Trình độ</label>
    <select data-type="product-level" id="level-create-select" 
        class="form-select form-control" 
        name="level"
        data-control="select2" 
        data-dropdown-parent="#{{ $parentId }}" 
        data-placeholder="Chọn trình độ"
        data-allow-clear="true">
        <option value="">Chọn trình độ</option>
        @foreach(\App\Models\Subject::getLevels() as $level)
            <option value="{{ $level }}" {{ $originLevel && $originLevel == $level ? 'selected' : '' }}>{{ $level }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('level')" class="mt-2"/>
</div>

<script>
    $(() => {
        new LevelBox({
            container: () => {
                return $('[selector-box="level"]');
            }
        })
    })
</script>