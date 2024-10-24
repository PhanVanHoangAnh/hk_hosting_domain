@if (Session::has('origin_user_id'))
    <a href="{{ action(
        [App\Http\Controllers\UserController::class, 'loginBack']
    ) }}" class="login-back-section bg-light text-light bg-info border-info shadow d-flex align-items-center"
    data-bs-toggle="tooltip" title="Thoát tài khoản người dùng {{ Auth::user()->account->name ?? ''}}."
    >
        <span class="material-symbols-rounded fs-2">
            logout
        </span>
    </a>
@endif