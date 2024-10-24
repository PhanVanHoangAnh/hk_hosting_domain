@extends('layouts.main.popup')

@section('title')
    Xếp lớp
@endsection

@php
    $assignToClassPopupUniqId = 'assignToClass_' . uniqid();
@endphp

@section('content')
    <div id="{{ $assignToClassPopupUniqId }}">
        <form data-action="form" action="{{ action('\App\Http\Controllers\Edu\StudentController@doneAssignToClass') }}"
            method="post">
            @csrf
            <div class="py-10">
                <div class="row w-100 px-15 mx-auto d-flex justify-content-around mb-10">
                    <div class="col-12">
                        @include('edu.students._student_form', [
                            'formId' => $assignToClassPopupUniqId,
                        ])
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-2 mb-2">
                        <button type="submit" popup-control="save" class="btn btn-primary w-100">Lưu</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        var assignToClassManager;

        $(() => {
            assignToClassManager = new AssignToClassManager({
                container: document.querySelector('#{{ $assignToClassPopupUniqId }}')
            })
        });

        var AssignToClassManager = class {
            constructor(options) {
                this.container = options.container;

                this.events();
            };

            getContainer() {
                return this.container;
            };

            getForm() {
                return this.getContainer().querySelector('[data-action="form"]');
            };

            events() {
                const _this = this;

                _this.getForm().addEventListener('submit', function(e) {
                    e.preventDefault();

                    const url = _this.getForm().getAttribute('action');
                    const data = $(_this.getForm()).serialize();

                    $.ajax({
                        url: url,
                        method: 'post',
                        data: data
                    }).done(response => {
                        assignToClassPopup.hide();

                        ASTool.alert({
                            message: response.message,
                            ok: () => {
                                ContactsList.getList().load();
                            }
                        });
                    }).fail(response => {
                        throw new Error(response);
                    })
                });
            };
        };
    </script>
@endsection
