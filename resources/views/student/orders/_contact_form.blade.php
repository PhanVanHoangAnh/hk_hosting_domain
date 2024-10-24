<input type="hidden" name="copy_from_order_id" value="{{ request()->copy_from_order_id }}">

<div class="mb-10">
    <div class="form-outline mb-7">
        <div class="d-flex align-items-center">
            <label for="" class="form-label fw-semibold text-info">{{ $order && $order->type == App\Models\Order::TYPE_REQUEST_DEMO ? 'Người liên hệ' : 'Người ký hợp đồng' }}</label>
        </div>
        
        @include('helpers.contactSelector', [
            'name' => 'contact_id',
            'url' => action('App\Http\Controllers\Student\ContactController@select2'),
            'controlParent' => '#' . $formId,
            'placeholder' => 'Tìm khách hàng/liên hệ từ hệ thống',
            'value' => $order->contact_id ? $order->contact_id : null,
            'text' => $order->contact_id ? $order->contacts->getSelect2Text() : null,
            'createUrl' => action('\App\Http\Controllers\Student\ContactController@create'),
            'editUrl' => action('\App\Http\Controllers\Student\ContactController@edit', 'CONTACT_ID'),
        ])
        
        <x-input-error :messages="$errors->get('contact_id')" class="mt-2" />
    </div>

    <div data-control="relationship-section">
        <div class="form-outline mb-7">
            <label class="form-check form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" value="1" name="signer_is_student" {{ $order->contact_id == $order->student_id ? 'checked' : '' }} />
                <span class="form-check-label fw-semibold fs-3 text-info">
                    {{ $order && $order->type == App\Models\Order::TYPE_REQUEST_DEMO ? 'Người liên hệ' : 'Người ký hợp đồng' }} cũng là học viên
                </span>
            </label>
        </div>

        {{-- <div class="form-outline mb-7">
            <div class="d-flex align-items-center">
                <label for="" class="form-label fw-semibold">Học viên</label>
                <div class="mb-3 ms-3">(<input class="fsorm-check-input" type="checkbox" value="1" name="signer_is_contact" checked /> Là liên hệ/khách hàng)</div>
            </div>
            
            <div class="mb-7" box-not-toggle box-toggle-selector='[name="signer_is_contact"]' box-toggle-value="1" style="display:none;">
                @include('helpers.contactSelector', [
                    'name' => 'signer_id',
                    'url' => action('App\Http\Controllers\Student\ContactController@select2'),
                    'controlParent' => '#pick-contact-form',
                    'placeholder' => 'Tìm khách hàng/liên hệ từ hệ thống',
                    'value' => $order->contact_id ? $order->contact_id : null,
                    'text' => $order->contact_id ? $order->contacts->getSelect2Text() : null,
                    'createUrl' => action('\App\Http\Controllers\Student\ContactController@create'),
                    'editUrl' => action('\App\Http\Controllers\Student\ContactController@edit', 'CONTACT_ID'),
                ])
                <x-input-error :messages="$errors->get('signer_id')" class="mt-2" />
            </div>
        </div> --}}
        <div box-not-toggle box-toggle-selector='[name="signer_is_student"]' box-toggle-value="1" style="display:none;">
            <div class="form-outline mb-7">
                <label for="" class="form-label fw-semibold text-info">Học viên</label>
                @include('helpers.contactSelector', [
                    'name' => 'student_id',
                    'url' => action('App\Http\Controllers\Student\ContactController@select2'),
                    'controlParent' => '#' . $formId,
                    'placeholder' => 'Tìm khách hàng/liên hệ từ hệ thống',
                    'value' => $order->student_id ? $order->student_id : null,
                    'text' => $order->student_id ? $order->student->getSelect2Text() : null,
                    'createUrl' => action('\App\Http\Controllers\Student\ContactController@create'),
                    'editUrl' => action('\App\Http\Controllers\Student\ContactController@edit', 'CONTACT_ID'),
                ])
                <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
            </div>

            <div box-control="relationship-box" style="display:none;">
                <div class="form-outline mb-7">
                    <label for="" class="form-label fw-semibold text-info">Quan hệ người ký hợp đồng với học viên</label>
                    <div data-control="relationship-form">
                        
                    </div>
                </div>
            </div>

            <script>
                $(function() {
                    // relation select box
                    new RelationBoxToggle({
                        box: document.querySelector('[box-control="relationship-box"]'),
                        getStudentSelectBox: function() {
                            return $('[name="student_id"]');
                        },
                    });
                });

                var RelationSectionToggle = class {
                    constructor(options) {
                        this.box = options.box;
                        this.contactSelectBox = options.contactSelectBox;

                        // 
                        this.toggle();

                        //
                        this.events();
                    }

                    toggle() {
                        if (this.contactSelectBox().data('select2')) {
                            if (this.contactSelectBox().val()) {
                                this.box.style.display = 'block';
                            } else {
                                this.box.style.display = 'none';
                            }
                        } else {
                            throw new Error("Element is not converted to Select2");
                        }
                    }

                    events() {
                        this.contactSelectBox().on('change', (e) => {
                            this.toggle();
                        });
                    }
                };
            </script>
        </div>

        <script>
            $(function() {
                new RelationshipBox({
                    box: $('[data-control="relationship-form"]'),
                    url: '{{ action('\App\Http\Controllers\Student\OrderController@relationshipForm') }}',
                    getContactSelectBox: function() {
                        return $('[name="contact_id"]');
                    },
                    getStudentSelectBox: function() {
                        return $('[name="student_id"]');
                    },
                    getContactIsStudentSelectBox: function() {
                        return $('[name="signer_is_student"]');
                    },
                });
            });

            var RelationshipBox = class {
                constructor(options) {
                    this.box = options.box;
                    this.url = options.url;
                    this.getContactSelectBox = options.getContactSelectBox;
                    this.getStudentSelectBox = options.getStudentSelectBox;
                    this.getContactIsStudentSelectBox = options.getContactIsStudentSelectBox;

                    //
                    this.render();

                    //
                    this.events();
                }

                events() {
                    this.getContactSelectBox().on('change', (e) => {
                        this.render();
                    });
                    this.getStudentSelectBox().on('change', (e) => {
                        this.render();
                    });
                    this.getContactIsStudentSelectBox().on('change', (e) => {
                        this.render();
                    });
                }

                render() {
                    // signer is student
                    if (this.getContactIsStudentSelectBox().is(':checked')) {
                        this.box.html('');
                        return;
                    }

                    // one of them is empty
                    if (!this.getContactSelectBox().val() || !this.getStudentSelectBox().val()) {
                        this.box.html('');
                        return;
                    }

                    // select the same contact
                    if (this.getContactSelectBox().val() == this.getStudentSelectBox().val()) {
                        this.box.html('');
                        return;
                    }

                    // find relationship
                    $.ajax({
                        url: this.url,
                        type: 'GET',
                        data: {
                            contact_id: this.getContactSelectBox().val(),
                            to_contact_id: this.getStudentSelectBox().val(),
                        },
                    }).done((response) => {
                        this.box.html(response);
                        initJs(this.box[0]);
                    });
                }
            }
        </script>
    </div>

    <script>
        $(function() {
            document.querySelectorAll('[box-not-toggle]').forEach(box => {
                new BoxNotToggle({
                    box: box,
                    selectors: document.querySelectorAll(box.getAttribute('box-toggle-selector')),
                    value: box.getAttribute('box-toggle-value'),
                });
            });

            document.querySelectorAll('[box-select-toggle]').forEach(box => {
                new BoxSelectToggle({
                    box: box,
                    selectors: document.querySelectorAll(box.getAttribute('box-toggle-selector')),
                    value: box.getAttribute('box-toggle-value'),
                });
            });

            // Show/Hide relationship section
            new RelationSectionToggle({
                box: document.querySelector('[data-control="relationship-section"]'),
                contactSelectBox: function() {
                    return $('[name="contact_id"]');
                },
            });
        });

        var RelationTypeSelectToggle = class {
            constructor(options) {
                this.options = options;
                
                //
                this.events();

                //
                this.toggle();
            }

            events() {
                this.options.getContactTypeSelects().on('change', () => {
                    this.toggle();
                });

                this.options.getSignerIsStudentCheckbox().on('change', () => {
                    this.toggle();
                });
            }

            toggle() {
                if (this.options.getContactTypeValue() == 'signer' && this.options.getSignerIsStudentCheckbox().is(':checked')) {
                    this.options.box.hide();
                } else {
                    this.options.box.show();
                }
            }
        }

        var RelationBoxToggle = class {
            constructor(options) {
                this.box = options.box;
                this.getStudentSelectBox = options.getStudentSelectBox;

                // 
                this.toggle();

                //
                this.events();
            }

            toggle() {
                if (!this.getStudentSelectBox().val()) {
                    this.box.style.display = 'none';
                } else {
                    this.box.style.display = 'block';
                }
            }

            events() {
                this.getStudentSelectBox().on('change', (e) => {
                    this.toggle();
                });
            }
        };

        var BoxNotToggle = class {
            constructor(options) {
                this.box = options.box;
                this.selectors = options.selectors;
                this.value = options.value;

                // events
                this.events();

                //
                this.toggle();
            }

            getValue() {
                var value = null;
                this.selectors.forEach(selector => {
                    if ($(selector).is(':checked')) {
                        value = selector.value;
                    }
                });
                return value;
            }

            toggle() {
                if (this.value !== this.getValue()) {
                    this.box.style.display = 'block';
                } else {
                    this.box.style.display = 'none';
                }
            }

            events() {
                this.selectors.forEach(selector => {
                    selector.addEventListener('change', (e) => {
                        this.toggle()
                    });
                });
                    
            }
        }

        var BoxSelectToggle = class {
            constructor(options) {
                this.box = options.box;
                this.selectors = options.selectors;
                this.value = options.value;

                // events
                this.events();

                //
                this.toggle();
            }

            getValue() {
                var value = null;
                this.selectors.forEach(selector => {
                    value = selector.value;
                });
                return value;
            }

            toggle() {
                if (this.value == this.getValue()) {
                    this.box.style.display = 'block';
                } else {
                    this.box.style.display = 'none';
                }
            }

            events() {
                this.selectors.forEach(selector => {
                    selector.addEventListener('change', (e) => {
                        this.toggle()
                    });
                });
                    
            }
        }
    </script>
</div>

<div class="mb-10">
    <div class="col-12">
        <div id="ContactRequestContainer">

        </div>
        <x-input-error :messages="$errors->get('contact_request_id')" class="mt-2" />
    </div>
</div>

<script>
    var contactRequestManager;

    @if (true || !$order->isRequestDemo())
        $(() => {
            // Contact Request Manager: Show contact request liên quan
            contactRequestManager = new ContactRequestManager({
                url: '{{ action([App\Http\Controllers\Student\OrderController::class, 'pickContactRequest']) }}',
                container: document.getElementById('ContactRequestContainer'),
                contactSelectBox: document.querySelector('[name="contact_id"]'),
                contactRequestId: '{{ $order->contact_request_id }}',
                contactIsStudentSelectBox: $('[name="signer_is_student"]'),
                contactIsStudent: function() {
                    return $('[name="signer_is_student"]').is(':checked');
                },
                studentSelectBox: $('[name="student_id"]'),
            });
        })
    @endif

    var ContactRequestManager = class {
        constructor(options) {
            this.url = options.url;
            this.container = options.container;
            this.contactSelectBox = options.contactSelectBox;
            this.contactRequestId = options.contactRequestId;
            this.studentSelectBox = options.studentSelectBox;
            this.contactIsStudent = options.contactIsStudent;
            this.contactIsStudentSelectBox = options.contactIsStudentSelectBox;

            //
            this.load();

            // events
            this.events();
        }

        getContactId() {
            return $(this.contactSelectBox).val();
        }

        getContactRequestId() {
            if (!this.getRows().length) {
               return null; 
            }
            
            var checkedElement = this.getRows()[0].querySelector('[name="contact_request_id"]:checked');
            if (!checkedElement) {
                return null;
            }

            return checkedElement.value;
        }

        events() {
            $(this.contactSelectBox).on('change', (e) => {
                //
                this.load();
            });

            this.studentSelectBox.on('change', (e) => {
                //
                this.load();
            });

            this.contactIsStudentSelectBox.on('change', (e) => {
                //
                this.load();
            });
        }

        load() {
            var contactIds = null;
            
            if (this.getContactId()) {
                contactIds = [this.getContactId()];

                if (!this.contactIsStudent() && this.studentSelectBox.val()) {
                    contactIds.push(this.studentSelectBox.val());
                }
            }

            $.ajax({
                url: this.url,
                type: 'GET',
                data: {
                    contact_ids: contactIds,
                    contact_request_id: this.contactRequestId,
                    orderType: "{{ isset($orderType) ? $orderType : null }}"
                },
            }).done((reponse) => {
                $(this.container).html(reponse);

                // init js
                initJs(this.container);

                // after load event
                this.afterLoadEvents();
            });
        }

        getRows() {
            return this.container.querySelectorAll('[request-control="row"]');
        }

        checkRow(row) {
            var radio = row.querySelector('[request-control="select-radio"]');

            // check current row
            if (event.target !== radio) {
                radio.checked = true;
            }

            // effect
            this.getRows().forEach(r => {
                r.classList.remove('bg-light-warning');
                r.classList.remove('pe-none');
            });

            row.classList.add('bg-light-warning');
            row.classList.add('pe-none');
        }

        afterLoadEvents() {
            this.getRows().forEach(row => {
                row.addEventListener('click', (e) => {
                    this.checkRow(row);
                });
            });
        }
    }
</script>