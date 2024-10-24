<option value="">Chọn tài khoản</option>
@foreach ($zoomUsers as $user)
    <option value="{{ $user['user_id'] }}"
    {{ isset($course->zoom_user_id) && $course->zoom_user_id == $user['user_id'] ? 'selected' : (isset($courseCopy->zoom_user_id) && $courseCopy->zoom_user_id == $user['user_id'] ? 'selected' : '') }}
    >{{ $user['email'] . " (" . $user['display_name'] . " - " . $user['dept'] . ")" }}</option>
@endforeach