@extends('layouts.main.popup', [
    'size' => 'full',
])
@section('title')
    Nhập dữ liệu liên hệ từ file excel
@endsection
@section('content')
    <style>
        .scrollable-table-excel {
            overflow: scroll;
            max-height: 400px;
        }

        #dtHorizontalVerticalExample {
            border-collapse: collapse;
        }

        #dtHorizontalVerticalExample th,
        #dtHorizontalVerticalExample td {
            padding: 8px 16px;
            border: 1px solid #ddd;
        }

        #dtHorizontalVerticalExample thead {
            position: sticky;
            inset-block-start: 0;
            background-color: #ddd;
        }

        #dtHorizontalVerticalExample th {
            text-align: center;
        }

        #dtHorizontalVerticalExample td {
            /* text-align: center; */
            vertical-align: middle;
        }

        .table-bordered>:not(caption)>* {
            border-width: 0px;
        }
    </style>

    <div class="modal-body pt-10 pb-15 px-lg-17">
        <div class="my-4">
            <div data-control="progress-bar" id="percentage-bar">
                
            </div>
            <div data-control="importing-spinner" class="spinner-border text-success" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <script>
        $(() => {
            //
            new ProgressBar({
                container: $('[data-control="progress-bar"]'),
                url: '{{ action([App\Http\Controllers\Marketing\ContactImportController::class, 'progressBar']) }}'
            });
        });

        var ProgressBar = class {
            constructor(options) {
                this.container = options.container;
                this.url = options.url;

                this.check();
            }

            check() {
                $.ajax({
                    url: this.url,
                    method: "GET",
                }).done(response => {
                    this.container.html(response.html);

                    if (response.percent < 100) {
                        setTimeout(() => {
                            this.check();
                        }, 1000);
                    }
                });
            }
        }
    </script>
@endsection