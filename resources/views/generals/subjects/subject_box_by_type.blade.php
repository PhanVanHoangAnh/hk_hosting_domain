<div class="form-outline">
    <label class="fs-6 fw-semibold required mb-2">Môn học</label>
    <select class="form-select form-control" 
        name="subject_id"
        data-dropdown-parent="#{{ $parentId }}"
        data-control="select2" 
        placeholder="Chọn môn học...">
        @if ($subjects && count($subjects) > 0)
            <option value="">Chọn môn học</option>
            @foreach ($subjects as $subject)
                <option value="{{ $subject->id }}" {{ isset($selectedSubjectId) && $selectedSubjectId == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
            @endforeach
        @else 
            <option value="">Chọn môn học</option>
        @endif
    </select>

    {{-- Error --}}
    @if (isset($subjectError)) 
        <span class="text-danger text-center">{{ $subjectError }}</span>
    @endif
</div>