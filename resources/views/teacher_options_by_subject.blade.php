<option value="">Chọn giáo viên</option>

@foreach ($teachers as $teacher)
    <option value="{{ $teacher->id }}" {{ isset($selectedTeacher) && $selectedTeacher == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
@endforeach