@if ($levels && $levels->count() > 0) 
    <option value="">Chọn trình độ</option>
    @foreach ($levels as $level)
        <option value="{{ $level }}" {{ isset($levelSelected) && $levelSelected == $level ? 'selected' : '' }}>{{ $level }}</option>
    @endforeach
@else 
    <option value="" selected>Môn học này không có trình độ</option>
@endif