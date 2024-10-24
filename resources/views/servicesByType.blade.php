<option value="">Chọn dịch vụ</option>

@if ($services->count() > 0)
    @foreach ($services as $service)
        <option value="{{ $service->id }}" {{ isset($selectedValue) && $selectedValue == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
    @endforeach
@endif