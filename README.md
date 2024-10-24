<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Initialization

git clone git@github.com:luanpm88/asms.git asms
cd asms
git checkout develop
php composer.phar install
cp .env.example .env
php artisan key:generate
nano .env # mysql db configuration update here
php artisan migrate
php artisan serve
php artisan db:seed # development only
php artisan storage:link
## Run queue tasks

php artisan queue:listen

## Update code from repos

git pull # develop

## Git Push code

git diff [..] # Check updates
git add [..]
git commit -m "[..]"
git push # develop

## Update current local developement

git pull // config pull.rebase = false
php composer.phar install // composer.json composer.lock aka Gemfile Gemfile.lock
php artisan migrate
php artisan db:seed // reload lại db: php artisan migrate:refresh && php artisan db:seed

## Default User Development -- UserSeeder

email: ethan.nguyen@asms.com
password: 123456

## HELPERS: POPUP

var popup = new Popup({
    url: url,
    data: {...}
});
popup.load();

## HELPERS: CONFIRM, ALERT

ASTool.alert({
    message: 'Bạn có muốn xóa Account này không?',
    ok: function() {
    },
})

ASTool.confirm({
    message: 'Bạn có muốn xóa Account này không?',
    ok: function() {
    },
    cancel: function() {
    },
})

## Under Construction helper

Thêm thuộc tính data-control="under-construction" tại mọi elements mình muốn
VD: <a data-action="under-construction" href="../.

## custom css thì viết hết vào đây
public/css/asms.css

## select2 in modal bug
# sử dụng thuộc tính data-dropdown-parent này cho các select box inside modal
<select class="form-select form-control" data-dropdown-parent="#CustomersFormView"

# Cài đặt gói HTTP client của Laravel để lấy dữ liệu từ hubspot
composer require guzzlehttp/guzzle

# Date helper
<div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
    <input data-control="input" name="created_at_from" placeholder="=asas" type="date" class="form-control" placeholder="" />
    <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
</div>

## INIT JS - dynamic content thì đều call cái này
initJs(this.listContent);

# SELECT2 AJAX
# -- View --
<select id="contact-select" data-control="select2-ajax" data-url="{{ action('App\Http\Controllers\Sales\ContactController@select2') }}" class="form-control">
    @if ($order->contact_id)
        <option value="{{ $order->contact_id }}" selected>{{ '<strong>' . $order->contacts->name .'</strong><br>'. $order->contacts->email }}</option>
    @endif
</select>
# -- Controller --
public function select2(Request $request)
{
    return response()->json(Contact::select2($request));
}
# -- Model --
public static function select2($request)
{
    $query = self::query();
    // keyword
    if ($request->search) {
        $query = $query->search($request->search);
    }

    // pagination
    $contacts = $query->paginate($request->per_page ?? '10');

    return [
        "results" => $contacts->map(function($contact) {
            return [
                'id' => $contact->id,
                'text' => '<strong>' . $contact->name . '</strong><div>' . $contact->email . '</div>',
            ];
        })->toArray(),
        "pagination" => [
            "more" => $contacts->lastPage() != $request->page,
        ],
    ];
}

# Freeze column
1 - cho class freeze-column vào thẻ div bọc cái table
2 - Tìm th và td muốn ghim cho attr  data-control="freeze-column" (thường là 2 chỗ), th thêm class bg-info

# button loading effect
<!--begin::Button-->
<button id="CreateSocialNetworkButton" type="submit" class="btn btn-primary" data-control="one-click-loading">
    <span class="indicator-label">Lưu</span>
    <span class="indicator-progress">Đang xử lý...
        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
</button>
<!--end::Button-->
js:
addEffect = () => {
    // btn effect
    button.setAttribute('data-kt-indicator', 'on');
    button.setAttribute('disabled', true);
}

removeEffect = () => {
    // btn effect
    button.removeAttribute('data-kt-indicator');
    button.removeAttribute('disabled');
}

# Freeze column
1 - cho class freeze-column vào thẻ div bọc cái table
2 -  Tìm th và td muốn ghim cho attr  data-control="freeze-column" (thường là 2 chỗ), th thêm class bg-info

# Reload sidebar
aSidebar.reloadCounters();

# Google Sheet Service
$service = new App\Library\GoogleSheetService();
$service->readContactSyncSheet()

# Zoom button
<div class="d-inline-block ms-2">
    @include('components.zoom_button')
</div>