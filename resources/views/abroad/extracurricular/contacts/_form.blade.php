<div class="scroll-y pe-7 py-10 px-lg-17">
    <!--begin::Input group-->

    <div class="row">
        <div id="related-contacts" style="none">
            
        </div>
        <div class="col-md-6">
            <!--begin::Col-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fs-6 fw-semibold mb-2">Tên</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control @if ($errors->has('name')) is-invalid @endif"
                    placeholder="" name="name" value="{{ $contact->name }}" />
                <!--end::Input-->
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <!--end::Col-->
            <!--end::Input group-->
        </div>

        <div class="col-md-6">

            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Ngày sinh</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="date" class="form-control @if ($errors->has('birthday')) is-invalid @endif"
                    name="birthday" placeholder="" value="{{ $contact->birthday }}" />
                <!--end::Input-->
                <x-input-error :messages="$errors->get('birthday')" class="mt-2" />
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-6">

            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Địa chỉ E-mail</span>
                    <span class="ms-1" data-bs-toggle="tooltip" title="Địa chỉ email phải xác thực">
                        <i class="ki-outline ki-information fs-7">
                        </i>
                    </span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="email" id="email"
                    class="form-control @if ($errors->has('email')) is-invalid @endif" name="email"
                    placeholder="e.g., sean@dellito.com" value="{{ $contact->email }}" />

                <!--end::Input-->
                <span id="error-message-email" class="text-danger"></span>
                <div id="table-email-coincide">

                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <!--end::Input group-->
        </div>

        <div class="col-md-6">

            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Số điện thoại</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input id="phone" type="text"
                    class="form-control @if ($errors->has('phone')) is-invalid @endif" name="phone"
                    placeholder="" value="{{ $contact->phone }}" />
                <!--end::Input-->
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                <span id="error-message-phone" class="text-danger"></span>
                <div id="table-phone-coincide"> </div>

            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div related-control="list" class="position-relative"></div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Cha</span>
                </label>
                <!--end::Label-->

                @include('helpers.contactSelector', [
                    'name' => 'father_id',
                    'url' => action('App\Http\Controllers\Abroad\ContactController@select2'),
                    'controlParent' => '#' . $formId,
                    'placeholder' => 'Tìm khách hàng/liên hệ từ hệ thống',
                    'value' => $contact->getFather() ? $contact->getFather()->id : null,
                    'text' => $contact->getFather() ? $contact->getFather()->getSelect2Text() : null,
                    'createUrl' => action('\App\Http\Controllers\Abroad\ContactController@create'),
                    'editUrl' => action('\App\Http\Controllers\Abroad\ContactController@edit', 'CONTACT_ID'),
                ])
                
                <x-input-error :messages="$errors->get('mother')" class="mt-2" />
            </div>

        </div>

        <div class="col-md-6">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Mẹ</span>
                </label>
                <!--end::Label-->

                @include('helpers.contactSelector', [
                    'name' => 'mother_id',
                    'url' => action('App\Http\Controllers\Abroad\ContactController@select2'),
                    'controlParent' => '#' . $formId,
                    'placeholder' => 'Tìm khách hàng/liên hệ từ hệ thống',
                    'value' => $contact->getMother() ? $contact->getMother()->id : null,
                    'text' => $contact->getMother() ? $contact->getMother()->getSelect2Text() : null,
                    'createUrl' => action('\App\Http\Controllers\Abroad\ContactController@create'),
                    'editUrl' => action('\App\Http\Controllers\Abroad\ContactController@edit', 'CONTACT_ID'),
                ])
                
                <x-input-error :messages="$errors->get('mother')" class="mt-2" />
            </div>

        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Thành phố</span>
                </label>
                <!--end::Label-->
                <select city-control="city-selector" data-control="select2" data-dropdown-parent="#{{ $formId }}" class="form-select form-control" name="city">
                    <option value="">Chọn Thành phố</option>
                    @foreach (config('cities') as $city)
                        <option value="{{ $city['Name'] }}" {{ $contact->city === $city['Name'] ? 'selected' : '' }}>
                            {{ $city['Name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Quận/ Huyện</span>
                    
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <select city-control="district-selector" data-control="select2" data-dropdown-parent="#{{ $formId }}" class="form-select form-control " name="district">
                    <option value="">Chọn quận/huyện</option>
                    @foreach (App\Helpers\Functions::getDistrictsByCity($contact->city) as $district)
                        <option value="{{ $district['Name'] }}" {{ $contact->district === $district['Name'] ? 'selected' : '' }}>
                            {{ $district['Name'] }}
                        </option>
                    @endforeach
                </select>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        <div class="col-md-6">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Phường</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <select city-control="ward-selector" data-control="select2" data-dropdown-parent="#{{ $formId }}" class="form-select form-control " name="ward">
                    <option value="">Chọn phường/xã</option>
                    @foreach (App\Helpers\Functions::getWardsByCityDistrict($contact->city, $contact->district) as $ward)
                        <option value="{{ $ward['Name'] }}" {{ $contact->ward === $ward['Name'] ? 'selected' : '' }}>
                            {{ $ward['Name'] }}
                        </option>
                    @endforeach
                </select>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>

        <script>
            $(function() {
                var container = document.getElementById('{{ $formId }}');

                new CityManager({
                    citySelector: container.querySelector('[city-control="city-selector"]'),
                    districtSelector: container.querySelector('[city-control="district-selector"]'),
                    wardSelector: container.querySelector('[city-control="ward-selector"]'),
                });
            });

            var CityManager = class {
                constructor(options) {
                    this.citySelector = options.citySelector;
                    this.districtSelector = options.districtSelector;
                    this.wardSelector = options.wardSelector;

                    this.data = {!! json_encode(config('cities')) !!};

                    // events
                    this.events();
                }

                getCityId() {
                    return this.citySelector.value;
                }

                getDistrictId() {
                    return this.districtSelector.value;
                }

                cleanupDistrict() {
                    $(this.districtSelector).find('option[value!=""]').remove();
                }

                cleanupWard() {
                    $(this.wardSelector).find('option[value!=""]').remove();
                }

                findDistrictsByCityId(cityId) {
                    var districts = [];
                    this.data.forEach(city => {
                        if (city.Name == cityId) {
                            districts = city.Districts;
                        }
                    });

                    return districts;
                }
                
                renderDistricts(cityId) {
                    var districts = this.findDistrictsByCityId(cityId);

                    this.cleanupDistrict();
                    this.cleanupWard();

                    districts.forEach(district => {
                        $(this.districtSelector).append('<option value="' + district.Name + '">' + district.Name + '</option>');
                    });
                }

                findWardsByDistrictId(districtId) {
                    var wards = [];

                    this.findDistrictsByCityId(this.getCityId()).forEach(district => {
                        if (district.Name == districtId) {
                            wards = district.Wards;
                        }
                    });

                    return wards;
                }

                renderWards(districtId) {
                    var wards = this.findWardsByDistrictId(districtId);

                    this.cleanupWard();

                    wards.forEach(ward => {
                        $(this.wardSelector).append('<option value="' + ward.Name + '">' + ward.Name + '</option>');
                    });
                }

                events() {
                    $(this.citySelector).on('change', (e) => {
                        var cityId = e.target.value;
                        // 
                        this.renderDistricts(cityId);
                    });

                    $(this.districtSelector).on('change', (e) => {
                        var districtId = e.target.value;
                        // 
                        this.renderWards(districtId);
                    });
                }
            }
        </script>



        <div class="col-md-6">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Địa chỉ</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text"
                    class="form-control  @if ($errors->has('address')) is-invalid @endif" name="address"
                    placeholder="" value="{{ $contact->address }}" />
                <!--end::Input-->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">

            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">CCCD/Passport</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input id="identity_id" type="text"
                    class="form-control @if ($errors->has('identity_id')) is-invalid @endif" name="identity_id"
                    placeholder="" value="{{ $contact->identity_id }}" />
                <!--end::Input-->
                <x-input-error :messages="$errors->get('identity_id')" class="mt-2" />
            </div>

        </div>
        <div class="col-md-6">
            <div class="fv-row mb-7">
                    <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Ngày cấp</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="date" class="form-control @if ($errors->has('identity_date')) is-invalid @endif"
                    name="identity_date" placeholder="" value="{{ $contact->identity_date }}" />
                <!--end::Input-->
                <x-input-error :messages="$errors->get('identity_date')" class="mt-2" />
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6">

            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Nơi cấp</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input id="identity_place" type="text"
                    class="form-control @if ($errors->has('identity_place')) is-invalid @endif" name="identity_place"
                    placeholder="" value="{{ $contact->identity_place }}" />
                <!--end::Input-->
                <x-input-error :messages="$errors->get('identity_place')" class="mt-2" />
            </div>

        </div>
        <div class="col-md-6">
            
        </div>
    </div>
    

    


    
</div>

<script>
    $(document).ready(function() {
        initializeEFCNumber();

        // related contacts
        new RelatedContactManager({
            form: $('#{{ $formId }}'),
            url: "{!! action('\App\Http\Controllers\Abroad\ContactController@relatedContactsBox', ['contact_id' => $contact->id,]) !!}",
            emailInput: $('#{{ $formId }}').find('[name="email"]'),
            phoneInput: $('#{{ $formId }}').find('[name="phone"]'),
        });
        
        // edit contact form
        var editContact = new EditContactForm({});

        // unknown
        unknown();
    });

    var RelatedContactManager = class {
        constructor(options) {
            this.form = options.form;
            this.url = options.url;
            this.emailInput = options.emailInput;
            this.phoneInput = options.phoneInput;

            // events
            this.events();
        }

        getEmailValue() {
            return this.emailInput.val();
        }

        getPhoneValue() {
            return this.phoneInput.val();
        }

        getRelateListBox() {
            return this.form.find('[related-control="list"]');
        }

        events() {
            this.emailInput.on('keyup', (e) => {
                this.findByEmail();
            });

            this.phoneInput.on('keyup', (e) => {
                this.findByPhone();
            });
        }

        findByEmail(callback) {
            this.find((response) => {
                this.getRelateListBox().html(response);
                initJs(this.getRelateListBox()[0]);
            });
        }

        findByPhone(callback) {
            this.find((response) => {
                this.getRelateListBox().html(response);
                initJs(this.getRelateListBox()[0]);
            });
        }

        find(callback) {
            $.ajax({
                type: 'GET',
                url: this.url,
                data: {
                    email: this.getEmailValue(),
                    phone: this.getPhoneValue(),
                },
                success: function(response) {
                    callback(response);
                }
            });
        }
    }

    var EditContactForm = class {
        constructor(options) {
            this.listContent = document.querySelector('.related-contacts-list');

        }

        getUpdateButtons() {
            return this.listContent.querySelectorAll('[row-action="update"]');
        }

        events() {
            this.getUpdateButtons().forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    var id = button.getAttribute('id');
                    if (id) {
                        var url =
                            "{{ action([\App\Http\Controllers\Abroad\ContactController::class, 'edit'], ['id' => ':id']) }}";
                        url = url.replace(':id', id);
                        UpdateContactPopup.load(url);
                    }
                });
            });
        }
    }

    var unknown = function() {
        // function displayRelatedContacts(contacts, inputType) {
        //     var relatedContacts = $(`#related-contacts`);
        //     var relatedContactsList = $('.related-contacts-list');

        //     relatedContactsList.empty();

        //     if (contacts.length > 0) {

        //         contacts.forEach(function(contact) {
        //             relatedContactsList.append(
        //                 '<tr>' +
        //                 '<td>' + contact.name + '</td>' +
        //                 '<td class="' + (inputType === 'email' ? 'bg-warning' : '') + '">' + contact
        //                 .email + '</td>' +
        //                 '<td class="' + (inputType === 'phone' ? 'bg-warning' : '') + '">' + contact
        //                 .phone +
        //                 '</td><td><a row-action="update" class="btn btn-primary" id="' + contact
        //                 .id +
        //                 '"  >Chỉnh sửa</a></td>' +
        //                 '</tr>'
        //             );
        //         });

        //         relatedContacts.removeClass('d-none');
        //     } else {
        //         relatedContacts.addClass('d-none');
        //     }
        //     editContact.events();
        // }
    }

    function toggleDNone(elements, condition) {
        elements.forEach(function(element) {
            if (condition) {
                element.classList.add('d-none');
            } else {
                element.classList.remove('d-none');
            }
        });
    }

    $(function() {
        var columnId = "{{ $contact->source_type ? $contact->source_type : 'hide' }}";
        var listActionDivs = document.querySelectorAll('div[list-action="show"]');
        toggleDNone(listActionDivs, columnId === 'offline' || columnId === 'hide');

        //  for select change
        $("select[list-action='check']").on("change", function() {
            var selectedValue = this.value;
            var showElements = document.querySelectorAll('[list-action="show"]');
            toggleDNone(showElements, selectedValue === 'offline' || selectedValue === '');
        });
    });

    function initializeEFCNumber() {
        const efcInput = $(
            '#{{ $formId }} [list-action="efc-number"]'
        );
        if (efcInput.length) {
            const mask = new IMask(efcInput[0], {
                mask: Number,
                scale: 2,
                thousandsSeparator: ',',
                padFractionalZeros: false,
                normalizeZeros: true,
                radix: ',',
                mapToRadix: ['.'],
                min: 0,
            });
        }
    };
</script>