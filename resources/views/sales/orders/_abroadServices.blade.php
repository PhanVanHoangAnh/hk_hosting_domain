<!-- The customer's feedback is to remove the option of selecting the type of study abroad, 
    and instead of categorizing subjects, they prefer to consolidate them into one select option. 
    Therefore, i have modified the database by removing data and the 'type' column in 'abroad_services' 
    and temporarily excluding the functionality of this feature -->

@php
    $abroadServicesForm = 'abroadServicesForm_' . uniqId();
@endphp

<div id="{{ $abroadServicesForm }}" class="col-lg-8 col-md-8 col-sm-12 col-12">
    <div class="row" data-control="services-box">
        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
            <div class="form-outline">
                <label class="required fs-6 fw-semibold mb-2" for="abroad-type-select">Loại dịch vụ</label>

                <select select-form="type-select-form" name="abroad_service_type" class="form-select form-control"
                        data-control="select2" data-placeholder="Chọn loại dịch vụ du học..." data-allow-clear="true" data-dropdown-parent="#{{ $abroadServicesForm }}">
                        <option value="">Chọn</option>
                            @foreach (\App\Models\AbroadService::types() as $type)
                                <option value="{{ $type }}" {{ isset($abroadServiceType) && $abroadServiceType == $type ? 'selected' : (isset($orderItem->abroad_service_id) && \App\Models\AbroadService::find($orderItem->abroad_service_id)->type == $type ? 'selected' : '') }}>{{ trans('messages.abroad_service.' . $type) }}</option> 
                            @endforeach
                </select>
                <x-input-error :messages="$errors->get('abroad_service_type')" class="mt-2" />
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
            <div class="form-outline">
                <label class="required fs-6 fw-semibold mb-2" for="abroad-service-select">Dịch vụ</label>
                <select select-form="service-select-form" selected-value="{{ isset($orderItem->abroad_service_id) ? $orderItem->abroad_service_id : '' }}" class="form-select form-control" name="abroad_service_id"
                        data-control="select2" data-placeholder="Chọn dịch vụ du học..." data-allow-clear="true" data-dropdown-parent="#{{ $abroadServicesForm }}">
                </select>
                <x-input-error :messages="$errors->get('abroad_service_id')" class="mt-2"/>
            </div>
        </div>

        <script>
            var ServicesBox = class {
                constructor(options) {
                    this.box = options.box;
                    this.typeSelectBox = options.typeSelectBox;
                    this.serviceSelectBox = options.serviceSelectBox;
                
                    this.changeType();
                    this.events();
                }

                getServiceSelectedId() {
                    return this.serviceSelectBox()[0].getAttribute('selected-value');
                }

                findServicesContentByType(type) {
                    const _this = this;

                    return new Promise((res, rej) => {
                        if (!type) {
                            rej(new Error("Invalid type value!"));
                        }

                        $.ajax({
                            url: "{{ action([App\Http\Controllers\AbroadServiceController::class, 'loadAbroadServiceOptionsByType']) }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                type: type,
                                serviceSelectedId: _this.getServiceSelectedId()
                            },
                            method: 'post'
                        }).done(response => {
                            res(response);
                        }).fail(response => {
                            rej(new Error("Find services by type fail!"));
                        })
                    })
                }

                loadServicesContent(content) {
                    this.serviceSelectBox().html(content);
                }

                changeType() {
                    if (this.typeSelectBox().data('select2')) {
                        if (this.typeSelectBox().val()) {
                            const type = this.typeSelectBox().val();

                            this.findServicesContentByType(type)
                                .then(content => {
                                    this.loadServicesContent(content);
                                })
                                .catch(error => {
                                    throw error;
                                })
                        }
                    } else {
                        throw new Error("Selector is not in select2 format!");
                    }
                }

                events() {
                    this.typeSelectBox().on('change', (e) => {
                        e.preventDefault();

                        this.changeType();
                    })
                }
            }
        </script>
    </div>

    <script>
        $(() => {
            new ServicesBox({
                box: $('[data-control="services-box"]'),
                typeSelectBox: () => {
                    return $('[select-form="type-select-form"]')
                },
                serviceSelectBox: () => {
                    return $('[select-form="service-select-form"]')
                }
            })
        })
    </script>
</div>