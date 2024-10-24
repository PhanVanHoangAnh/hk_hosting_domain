<base href="../../../" />
<title>HKI - Hoàng Khang Incotech</title>
<meta charset="utf-8" />

<link rel="shortcut icon" href="{{ url('/core/assets/media/logos/favicon.ico') }}?v=2"/>
<!--begin::Fonts(mandatory for all pages)-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
<!--end::Fonts-->

<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
<link href="{{ url('/core/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('/core/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
<!--end::Global Stylesheets Bundle-->
<script>
    // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
</script>

<!--begin::ASMS Bundle(mandatory for all pages)-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
<link href="{{ url('/css/anotify.css') }}?v=21" rel="stylesheet" type="text/css" />
<link href="{{ url('/css/asms.css') }}?v={{ \App\Helpers\Functions::assetVersion() }}" rel="stylesheet" type="text/css" />
<script src="{{ url('/js/asms.js') }}?v={{ \App\Helpers\Functions::assetVersion() }}"></script>
<script src="{{ url('/js/ColumnsDisplayManager.js') }}?v={{ \App\Helpers\Functions::assetVersion() }}"></script>
<script src="{{ url('/js/SortManager.js') }}?v={{ \App\Helpers\Functions::assetVersion() }}"></script>
<script src="https://unpkg.com/imask"></script>
<!--end::ASMS Bundle-->

<meta name="csrf-token" content="{{ csrf_token() }}">

@if (Auth::user())
    <script>
        $(function() {
            window.notificationChecker = new NotificationChecker({
                url: '{{ action([App\Http\Controllers\NotificationController::class, 'check']) }}',
                pushedUrl: '{{ action([App\Http\Controllers\NotificationController::class, 'setPushed']) }}',
            });

            // Sidebar
            window.aSidebar = new ASidebar({
                selector: '#kt_aside',
            });

            // sidebar counter
            window.aSidebar.reloadCounters();
        })

        var NotificationChecker = class {
            constructor(options) {
                this.url = options.url;
                this.pushedUrl = options.pushedUrl;

                this.check();
            }

            check() {
                var _this = this;
                var ids = [];

                $.ajax({
                    url: this.url,
                    method: 'GET',
                }).done(response => {
                    response.forEach(notification => {
                        // Nếu hết phiên đăng nhập
                        if (notification.status == 'user_session_expired') {
                            ASTool.alert({
                                message: notification.message,
                                icon: 'error',
                                ok: function() {
                                    window.location.reload();
                                }
                            });
                            return;
                        }
                        notify(notification.status, notification.title, notification.message, notification.url);

                        ids.push(notification.id);
                    });
                    
                    // recheck after time
                    setTimeout(() => {
                        _this.check();
                    }, 15000);

                    // check pushed
                    setTimeout(() => {
                        _this.setPushed(ids);
                    }, 10000);

                    //
                    window.notificationManager.refresh();

                    // reload sidebar @todo performance issue
                    // window.aSidebar.reloadCounters();
                }).fail(message => {
                });
            }

            setPushed(ids) {
                var _this = this;

                if (!ids.length) {
                    return;
                }

                $.ajax({
                    url: _this.pushedUrl,
                    method: 'GET',
                    data: {
                        ids: ids,
                    }
                }).done(response => {
                }).fail(message => {
                });
            }
        }

        var ASidebar = class {
            constructor(options) {
                this.selector = options.selector;
                this.container = $(this.selector);
            }

            reloadCounters() {
                var _this = this;

                $('[sidebar-counter]').html('');

                $.ajax({
                    url: ""
                }).done((response) => {
                    var counters = ($(response).find(this.selector).find('[sidebar-counter]'));
                    counters.each(function () {
                        var id = $(this).attr('sidebar-counter');
                        var element = $('[sidebar-counter="'+id+'"]');
                        var number = parseInt($(this).html().trim());
                        element.html(number.toLocaleString('en-US'));
                    });
                })
                .fail(function() {})
                .always(function() {});
            }
        };
    </script>
@endif
