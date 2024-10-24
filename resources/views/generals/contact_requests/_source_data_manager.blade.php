@php
    $sourceDataUniqForm = "source_data_uniq_form_" . uniqId();
@endphp

<div data-form-id="{{ $sourceDataUniqForm }}" class="col-md-12 col-12 col-xl-12 col-lg-12 col-xs-12 mt-5 py-5 px-8 rounded" style="background-color: #eeeaea; box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;">
    <input type="hidden" name="contact_request_data" value="{{ isset($contactRequest) && $contactRequest ? json_encode($contactRequest->toArray()) : '' }}">
    {{-- Sub-channel --}}
    <div class="row" data-form="sub-channel">
        <div class="col-md-6">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <label class="required fs-6 fw-semibold mb-2">Sub-Channel</label>
                <div>
                    <select list-action="marketing-source-sub-select" class="form-select fw-semibold"
                        data-dropdown-parent="#{{ $parentFormId }}"
                        data-control="select2" data-placeholder="chọn"
                        name="sub_channel">
                    </select>

                    <x-input-error :messages="$errors->get('overlap_contact_requests')" class="mt-2"/>
                </div>
            </div>
            <!--end::Input group-->
        </div>
    </div>

    <div class="row mt-4" data-form="data-auto-show">
        {{-- Load data by subchannel value --}}
    </div>
</div>
<script>
    $(() => {
        new SourceManager({
            container: () => {
                return $('[data-form-id="{{ $sourceDataUniqForm }}"]')
            }
        })
    })
</script>

<script>
    var SourceManager = class {
        constructor(options) {
            this.container = options.container;
            this.initData = {!! json_encode(\App\Helpers\Functions::getJsSourceTypes()) !!};
            this.init();
            this.events();
        }

        getSubChannels() {
            const subChannels = [];

            this.initData.forEach(source => {
                const channels = source.values;

                channels.forEach(channel => {
                    const subs = channel.values;
                    
                    subs.forEach(subChannel => {
                        subChannels.push(subChannel);
                    })
                })
            });

            return subChannels;
        }

        getContactRequestData() {
            return this.container().find('[name="contact_request_data"]').val();
        }

        getSubChannelForm() {
            return this.container().find('[data-form="sub-channel"]');
        }

        getSubChannelSelect() {
            return $(this.getSubChannelForm()).find('select');
        }

        getChannelBySubChannel(subChannel) {
            const data = this.initData;
            let result = '--';
            let found = 0;

            for (let i = 0; i < data.length; ++i) {
                if (found) break;

                const channels = data[i].values;

                for (let j = 0; j < channels.length; ++j) {
                    if (found) break;
                    
                    const subChannels = channels[j].values;

                    for (let x = 0; x < subChannels.length; ++x) {
                        if (subChannel === subChannels[x]) {
                            result = channels[j].name;
                            found = 1;
                            break;
                        }
                    }
                }
            }

            return result
        }

        getSourceTypeByChannel(channelInput) {
            const data = this.initData;
            let result = '--';
            let found = 0;

            for (let i = 0; i < data.length; ++i) {
                if (found) break;
                const channels = data[i].values;

                for (let j = 0; j < channels.length; ++j) {
                    if (channels[j].name === channelInput) {
                        result = data[i].name;
                        found = 1;
                        break;
                    };
                }
            }

            return result;
        }

        loadSubChannels() {
            const subChans = this.getSubChannels();
            const contactRequestData = JSON.parse(this.getContactRequestData());
            const subChannelSelected = contactRequestData ? contactRequestData.sub_channel : null;
            let subChanOptions = `<option value="">Chọn sub-channel</option>`;

            subChans.forEach(sub => {
                const channel = this.getChannelBySubChannel(sub);
                const sourceType = this.getSourceTypeByChannel(channel);

                subChanOptions += `<option value="${sub}" ${subChannelSelected && sub == subChannelSelected ? 'selected' : ''}>${sub} (${sourceType})</option>`;
            })

            this.getSubChannelSelect().html(subChanOptions);
        }

        getSubChannelValue() {
            return this.getSubChannelSelect().val();
        }

        getAutoLoadForm() {
            return this.container().find('[data-form="data-auto-show"]');
        }

        loadAutoLoadFormContent(content) {
            this.getAutoLoadForm().html(content);
        }

        init() {
            this.loadSubChannels();
        }

        addLoadEffect() {
            this.getAutoLoadForm().addClass('list-loading');

            if (!this.container().find('[list-action="loader"]')) {
                $(this.getAutoLoadForm()).before(
                    `
                        <div list-action="loader" class="py-20 px-3 text-center position-absolute" style="left:calc(50% - 20px);top:20px;">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    `
                );
            }
        }

        removeLoadEffect() {
            this.getAutoLoadForm().removeClass('list-loading');

            if (this.container().find('[list-action="loader"]')) {
                this.container().find('[list-action="loader"]').remove();
            }
        }

        changeSubChannelHandle() {
            const _this = this;
            const subChannel = this.getSubChannelValue();

            this.addLoadEffect();

            $.ajax({
                url: "{{ action([App\Http\Controllers\SourceDataManagerController::class, 'getAutoLoadFormBySubChannel']) }}",
                method: 'POST',
                data: {
                    contactRequestData: JSON.parse(_this.getContactRequestData()),
                    subChannel: subChannel,
                    _token: "{{ csrf_token() }}"
                }
            }).done(res => {
                _this.loadAutoLoadFormContent(res);
                _this.removeLoadEffect();
            }).fail(res => {
                ASTool.alert({
                    message: "Đã có lỗi xảy ra!",
                    icon: 'error',
                    ok: () => {
                        _this.removeLoadEffect();
                    }
                })
                
                console.error(res);
                throw new Error(error);
            })
        }

        events() {
            const _this = this;

            this.getSubChannelSelect().on('change', e => {
                e.preventDefault();

                _this.changeSubChannelHandle();
            })
        }
    }
</script>