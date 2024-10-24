<option value="">Chọn môn học</option>
@foreach ($subjects as $subject)
    <option value="{{ $subject->id }}" {{ isset($selectedId) && $selectedId == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
@endforeach