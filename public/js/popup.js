window.popups = {};

class Popup {
    constructor(options) {
        // url
        this.id = 'element_' + Date.now() + '_' + Math.floor(Math.random() * 1000);
        window.popups[this.id] = this;

        this.url;
        this.container;
        this.modal;

        this.method;
        this.header;
        this.customersId;
        this.data;
        // options
        if (typeof (options) == 'undefined') {
            options = {};
        }

        // data
        if (typeof (options.data) == 'undefined') {
            this.data = {};
        } else {
            this.data = options.data;
        }

        if (typeof (options.url) !== 'undefined') {
            this.url = options.url;
        }

        if (typeof (options.customersId) !== 'undefined') {
            this.customersId = [];
        }

        // Kiểm tra nếu options.customersId là mảng
        if (Array.isArray(options.customersId)) {
            this.customersId = options.customersId;
        }

        // init
        this.init();
    }

    setData(data) {
        this.data = data;
    }

    init() {
        var _this = this;
        // make modal dom
        var div = document.createElement('div');
        div.innerHTML = this.getInitHtml().trim();

        // container
        this.container = div.firstChild;

        // boostrap modal
        this.modal = new bootstrap.Modal(div.firstChild, {
            backdrop: 'static',
            keyboard: false
        });

        // div.firstChild.addEventListener('hide.bs.modal', function (event) {
        //     // ASTool.confirm({
        //     //     message: 'Bạn có muốn đóng cửa sổ không!',
        //     //     ok: () => {
        //     //         // _this.modal.hide();
        //     //     },
        //     //     cancel: () => {
        //     //         event.preventDefault();
        //     //     }
        //     // });
        //     var ok = confirm('Bạn có muốn đóng cửa sổ không!');

        //     if (!ok) {
        //         event.preventDefault();
        //     }
        // });
    }

    getModalContent() {
        return this.container;
    }

    getInitHtml() {
        return `
            <div id="`+this.id+`" modal-container class="modal" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-650px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header pb-0 border-0 justify-content-end">
                            <!--begin::Close-->
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <i class="material-symbols-rounded fs-1">
                                    close
                                </i>
                            </div>
                            <!--end::Close-->
                        </div>
                        <!--begin::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                            <!--begin::Content-->
                            <div class="text-center">
                                <div list-action="loader" class="py-20 px-3 text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
        `;
    }

    show() {
        this.modal.show();

        ASTool.fixPopupLayers();
    }

    hide() {
        this.modal.hide();
    }

    reset() {
        this.container.querySelector('.modal-content').innerHTML = $(this.getInitHtml()).find('.modal-content').html();
    }

    load(callback) {
        // reset
        this.reset();

        // show modal
        this.show();

        $.ajax({
            url: this.url,
            method: this.method ?? "GET",
            data: this.data,
            headers: this.header,
        }).done((response) => {
            this.setContent(response);

            if (typeof(callback) !== 'undefined') {
                callback();
            }
        }).fail(function () {
        });
    }
    loadHubSpot() {
        // reset
        this.reset();

        // show modal
        this.show();

        $.ajax({
            url: this.url,
            method: this.method ?? "POST",
            data: this.data,
            headers: this.header,
        }).done((response) => {
            this.setContent(response);
        }).fail(function () {
        });
    }

    loadJsonData() {
        // reset
        this.reset();

        // show modal
        this.show();

        $.ajax({
            url: this.url,
            method: this.method ?? "GET",
            contentType: "application/json",
            data: JSON.stringify(this.data),
            headers: this.header,
        }).done((response) => {
            this.setContent(response);
        }).fail(function () {
        }).always(function () {
            removeMaskLoading();
        });
    }

    loadExcelFile() {
        this.reset();

        this.show();

        $.ajax({
            url: this.url,
            method: this.method ?? "GET",
            data: this.data,
            headers: this.header,
            processData: false, // Set this because we have to send file type (haven't convert to String type), if not => error: Illegal invocation
            contentType: false, // With this atrribute, we can get the file data
        }).done(response => {
            this.setContent(response);
        }).fail(() => {

        });
    }

    loadCustomers() {
        this.reset();
        this.show();
        $.ajax({
            url: this.url,
            data: {
                customersId: this.customersId
            }
        }).done((response) => {
            this.setContent(response);
        }).fail(function () {
        });
    }
    loadCustomers() {
        this.reset();
        this.show();
        $.ajax({
            url: this.url,
            data: {
                customersId: this.customersId
            }
        }).done((response) => {
            this.setContent(response);
        }).fail(function () {
        });
    }

    setContent(html) {
        this.getModalContent().innerHTML = html;

        // Optionally, you can execute any JavaScript code within the loaded HTML
        // This includes any script tags within the loaded HTML
        // Example:
        const scripts = this.getModalContent().querySelectorAll('script');
        scripts.forEach(script => {
            const scriptElement = document.createElement('script');
            scriptElement.innerHTML = script.innerHTML;
            document.body.appendChild(scriptElement);
        });

        // init content
        if(typeof initJs !== 'undefined') {
            initJs(this.getModalContent());
        }

        // load callback
        if (typeof(this.loaded) !== 'undefined') {
            this.loaded();
        }
    }
}