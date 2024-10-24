class ANotify {
    constructor(options) {
        var _this = this;
        _this.id = '_' + Math.random().toString(36).substr(2, 9);
        _this.options = {};
        _this.notifications = [];
        _this.container = $('#anotify');

        // options
        if (typeof(options) !== 'undefined') {
            _this.options = options;
        }

        // append container
        if (!_this.container.length) {
            $('body').append('<div id="anotify"></div>')
            _this.container = $('#anotify');
        }
    }

    add(options) {
        var _this = this;
        var id = '_' + Math.random().toString(36).substr(2, 9);
        var timeout = 15000;
        var type = 'info';
        var url = null;

        if (typeof(options.timeout) !== 'undefined') {
            timeout = options.timeout;
        }

        if (typeof(options.type) !== 'undefined') {
            type = options.type;
        }

        if (typeof(options.url) !== 'undefined') {
            url = options.url;
        }

        if (type == 'error') {
            type = 'danger';
        }

        var titleHtml = '';
        if (typeof(options.title) !== 'undefined') {
            titleHtml = `
                <div class="fw-bold">`+options.title+`</div>
            `;
        }

        var closeButton = '';
        if (typeof(options.dismissible) !== 'undefined' && options.dismissible === true) {
            closeButton = `
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
        }
        _this.container.prepend(`
            <div id="`+id+`" class="alert alert-`+type+` alert-dismissible fade show shadow notification-item `+(url ? 'clickable' : '')+`" style="display:none;" role="alert">
                <div class="">
                    `+titleHtml+`
                    <div>`+options.message+`</div>
                </div>
                `+closeButton+`
            </div>
        `);

        $('#' + id).slideDown();

        if (timeout !== false) {
            setTimeout(function() {
                $('#' + id).fadeOut();
            }, timeout);
        }

        // events
        if (url !== null) {
            $('#' + id).on('click', function() {
                window.location = url;
            });
        }
    }
}