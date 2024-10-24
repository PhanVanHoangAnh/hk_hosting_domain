@php
    $controlId = uniqid();
@endphp

<div data-control="contact-selector-{{ $controlId }}" class="d-flex align-items-top" style="width:100%">
    <div style="width:100%">
        <select {{ isset($editOnly) ? 'disabled' : '' }} form-control="contact-select"  data-control="select2-ajax"
         {{ isset($multiple) ? 'multiple="multiple"' : '' }}
            data-url="{{ $url }}" class="form-control {{ isset($hideBorder) ? 'border-0' : '' }} {{ isset($bgColor) ? $bgColor : '' }} {{ isset($editOnly) ? 'disabled pe-none' : '' }}"
            name="{{ $name }}" data-dropdown-parent="{{ $controlParent ?? '' }}" data-control="select2"
            data-placeholder="{{ $placeholder ?? '' }}" {{ isset($editOnly) ? 'disabled' : 'data-allow-clear="true"' }}>
            <option value=""></option>
            @if (isset($value))
                <option value="{{ $value }}" selected>{{ $text ?? '--' }}</option>
            @endif
        </select>
    </div>
    <div class="{{ isset($notEdit) && isset($notAdd) ? 'd-none' : '' }}" style="width:44px;">
        @if (!isset($notEdit))
            <button contact-control="edit" type="button" class="btn btn-info btn-sm btn-icon ms-1 mb-1"
                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" data-bs-dismiss="click"
                data-bs-original-title="Chỉnh sửa liên hệ" style="display:none;">
                <span class="material-symbols-rounded">
                    edit
                </span>
            </button>
        @endif
        @if (!isset($editOnly) && !isset($notAdd))
            <button contact-control="add" type="button"
                class="btn btn-light btn-sm btn-icon ms-1"data-bs-toggle="tooltip" data-bs-trigger="hover"
                data-bs-placement="right" data-bs-dismiss="click" data-bs-original-title="Thêm mới liên hệ">
                <span class="material-symbols-rounded">
                    person_add
                </span>
            </button>
        @endif
    </div>
</div>

<script>
    if (!window.contactSelectors) {
        window.contactSelectors = [];
    }

    $(function() {
        var contactSelector = new ContactSelector({
            container: document.querySelector('[data-control="contact-selector-{{ $controlId }}"]'),
            editUrl: {!! isset($editUrl) ? "'" . $editUrl . "'" : 'undefined' !!},
            createUrl: {!! isset($createUrl) ? "'" . $createUrl . "'" : 'undefined' !!},
            refreshUrl: '{{ action([\App\Http\Controllers\ContactController::class, 'json']) }}',
        });
    });

    var ContactSelector = class {
        constructor(options) {
            this.container = options.container;
            this.createUrl = options.createUrl;
            this.editUrl = options.editUrl;
            this.refreshUrl = options.refreshUrl;
            this.keyword;

            // create contact popup
            this.createPopup = new Popup({
                url: this.createUrl,
            });

            // success
            this.createPopup.success = (response) => {
                // hide popup
                this.getCreatePopup().hide();
                
                $(this.getSelectBox()).empty();
                
                // update select box value
                $(this.getSelectBox()).select2("trigger", "select", {
                    data: {
                        id: response.id,
                        text: response.selectedText
                    }
                });

                // refresh selected
                this.refreshAll();
                
                // show/hide edit button
                this.toggleEditButton();
            };

            // fail
            this.createPopup.fail = (response) => {
                this.getCreatePopup().setContent(response.responseText);
            };
            
            // edit popup
            this.editPopup = new Popup();
            this.editPopup.loaded = () => {
                // success
                ContactsUpdate.success = (response) => {
                    // hide popup
                    this.getEditPopup().hide();
                    
                    $(this.getSelectBox()).empty();
                    
                    // update select box value
                    $(this.getSelectBox()).select2("trigger", "select", {
                        data: {
                            id: response.id,
                            text: response.selectedText
                        }
                    });

                    //
                    this.refreshAll();
                    
                    // show/hide edit button
                    this.toggleEditButton();
                };

                // fail
                ContactsUpdate.fail = (response) => {
                    this.getEditPopup().setContent(response.responseText);
                };
            };
            
            // show/hide edit button
            this.toggleEditButton();
            
            // events
            this.events();

            //
            window.contactSelectors.push(this);
        }

        getKeywordInput() {
            if ($(this.getSelectBox()).data("select2")) {
                return $(this.getSelectBox()).data("select2").dropdown.$search;
            }
        }

        getKeyword() {
            return this.keyword;
        }

        setKeword(keyword) {
            this.keyword = keyword;
        }

        toggleEditButton() {
            if (this.canEdit()) {
                this.showEditButton();
            } else {

                this.hideEditButton();
            }
        }

        setEditUrl(url) {
            this.editUrl = url;
            this.editPopup.url = this.editUrl;
        }

        getValue() {
            return $(this.getSelectBox()).val();
        }

        canEdit() {
            return $(this.getEditContactButton()).length && this.getValue();
        }

        getContainer() {
            return this.container;
        }

        getSelectBox() {
            return this.getContainer().querySelector('[form-control="contact-select"]');
        }

        getAddContactButton() {
            return this.getContainer().querySelector('[contact-control="add"]');
        }

        getEditContactButton() {
            return this.getContainer().querySelector('[contact-control="edit"]');
        }

        showEditButton() {
            if (this.getEditContactButton()) {
                this.getEditContactButton().style.display = 'inline-flex';
            }
        }

        hideEditButton() {
            if (this.getEditContactButton()) {
                this.getEditContactButton().style.display = 'none';
            }
        }

        getCreatePopup() {
            return this.createPopup;
        }

        getEditPopup() {
            return this.editPopup;
        }

        events() {
            // click
            
            $(this.getAddContactButton()).on('click', (e) => {
                this.getCreatePopup().data = {
                    keyword: this.getKeyword(),
                }
                this.getCreatePopup().load();
            });

            // select change
            $(this.getSelectBox()).on('change', (e) => {
                var id = $(e.target).val();

                // show/hide edit button
                this.toggleEditButton();
            });

            // edit button click
            $(this.getEditContactButton()).on('click', (e) => {
                this.loadEditPopup();
            });

            //
            if (this.getKeywordInput()) {
                this.getKeywordInput().on('change', (e) => {
                    this.setKeword(this.getKeywordInput().val());
                });
            }
        }

        getEidtUrl() {
            return this.editUrl.replace('CONTACT_ID', this.getValue());
        }

        loadEditPopup() {
            this.editPopup.url = this.getEidtUrl();
            this.editPopup.load();
        }

        hideEditPopup() {
            this.editPopup.hide();
        }

        refresh() {
            if (!this.getValue()) {
                $(this.getSelectBox()).val(null).trigger('change');
                return;
            }

            $.ajax({
                url: this.refreshUrl,
                data: {
                    id: this.getValue(),
                }
            }).done((response) => {
                $(this.getSelectBox()).empty();

                // update select box value
                $(this.getSelectBox()).select2("trigger", "select", {
                    data: {
                        id: response.id,
                        text: response.selectedText
                    }
                });
            });
        }

        refreshAll() {
            window.contactSelectors.forEach(selector => {
                selector.refresh();
            });
        }
    };
</script>
