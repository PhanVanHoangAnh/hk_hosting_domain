$(function() {
    initJs(document.body);
});

function initJs(container) {
    // date clear helper
    container.querySelectorAll('[data-control="date-with-clear-button"]').forEach(function(element) {
        new DateClearButton(element);
    });

    // close dropdown button
    container.querySelectorAll('[data-control="dropdown-close-button"]').forEach(function(element) {
        new DropdownCloseButton(element);
    });

    // select2 ajax
    $(container).find('[data-control="select2-ajax"]').each(function() {
        var url = $(this).attr('data-url');

        $(this).select2({
            allowClear: true,
            ajax: {
                url: url,
                data: function (params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1
                    }
    
                    // Query parameters will be ?search=[term]&page=[page]
                    return query;
                },
            },
            escapeMarkup: function(markup) {
                return markup;
            }
        });
    });

    $(container).find('[data-control="select2"]').each(function() {
        $(this).select2();
        $(this).trigger('change');
    });

    // select2 tự mở dropdown khi focus
    // $(container).on('focus', '.select2', function() {
    //     $(this).siblings('select').select2('open');
    // });

    //
    KTComponents.init();

    //
    new BoxToggle({
        buttons: $(container).find('[data-box-toggle]'),
    });

    // button one click loading effect
    new ButtonOneClickLoading($(container).find('[data-control="one-click-loading"]'));
}

var ButtonOneClickLoading = class {
    constructor(buttons) {
        buttons.on('click', function() {
            this.setAttribute('data-kt-indicator', 'on');
            $(this).addClass('disabled');
        });
    }
}

var BoxToggle = class {
    constructor(options) {
        this.buttons = options.buttons;

        //
        this.events();
    }

    expandMore(button, box) {
        box.show();
        button.find('[box-toggle="anchor"]').html('expand_more');
    }

    expandLess(button, box) {
        box.hide();
        button.find('[box-toggle="anchor"]').html('expand_less');
    }

    events() {
        var _this = this;
        this.buttons.on('click', function(e) {
            var box = $($(this).attr('data-box-toggle'));
            var isShow = box.is(':visible');

            if(isShow) {
                _this.expandLess($(this), box);
            } else {
                _this.expandMore($(this), box);
            }
        });

        // auto hide all
        this.buttons.each(function() {
            var box = $($(this).attr('data-box-toggle'));
            
            if(!box.find('.menu-link.active').length) {
                _this.expandLess($(this), box);
            }
        });
    }
};

var DropdownCloseButton = class {
    constructor(element) {
        this.element = element;

        // events
        this.element.addEventListener('click', (e) => {
            this.close();
        });
        
    }

    close() {
        if (this.getButton().length) {
            this.getButton().trigger('click');
        }
    }

    getButton() {
        return $(this.element).closest('.menu-sub-dropdown').prev();
    }

};

var DateClearButton = class {
    constructor(container) {
        this.container = container;
        //
        this.events();
        this.handleCheckCurrValue();
    }

    events() {
        var _this = this;

        // change value
        this.getInput().addEventListener('change', function(e) {
            if (!_this.getValue()) {
                _this.hideClearButton();
            } else {
                _this.showClearButton();
            }
        });

        // clear
        $(this.getClearButton()).on('click', function(e) {
            _this.clearValue();

            _this.hideClearButton();
        });
    }

    handleCheckCurrValue() {
        var _this = this;

        if (!_this.getValue()) {
            _this.hideClearButton();
        } else {
            _this.showClearButton();
        }
    }

    getClearButton() {
        return this.container.querySelector('[data-control="clear"]');
    }

    // hideClearButton() {
    //     this.getClearButton().style.display = 'none';
    // }

    // showClearButton() {
    //     this.getClearButton().style.display = 'block';
    // }

    hideClearButton() {
        $(this.getClearButton()).hide();
    }
    
    showClearButton() {
        $(this.getClearButton()).show();
    }
    

    getInput() {
        return this.container.querySelector('[data-control="input"]');
    }

    getValue() {
        return this.getInput().value;
    }
    
    clearValue() {
        this.getInput().value = '';
        
        // Create a new 'change' event
        var event = new Event('change');

        // Dispatch the 'change' event on the element
        // this.getInput().dispatchEvent(event);

        $(this.getInput()).trigger('change');
    }
};

function notify(optionsOrType, title, message, url) {
    var options = optionsOrType;

    if (typeof(message) != 'undefined') {
        options = {
            type: optionsOrType,
            title: title,
            message: message,
            dismissible: true,
            url: (url ?? null),
        };
    }

    new ANotify().add(options);
}

// // 
// var ASCreateContactPopupClass = class {
//     constructor(options) {
//         this.url = options.url;

//         //
//         this.popup = new Popup({
//             url: this.getUrl(),
//         });
//     }

//     getPopup() {
//         return this.popup;
//     }

//     getUrl() {
//         return this.url;
//     }

//     load() {
//         this.getPopup().load();
//     }

//     // var popupCreateContact;
//     // var buttonCreateContact;

//     // // show campaign modal
//     // var showContactModal = function() {
//     //     popupCreateContact.load();
//     // };

//     // return {
//     //     init: function() {
//     //         // create campaign popup
//     //         popupCreateContact = new Popup({
//     //             url: "{{ action('\App\Http\Controllers\Sales\ContactController@create') }}",

//     //         });

//     //         // create campaign button
//     //         buttonCreateContact = document.getElementById('buttonCreateContact');

//     //         // click on create campaign button
//     //         buttonCreateContact.addEventListener('click', (e) => {
//     //             e.preventDefault();

//     //             // show create campaign modal
//     //             showContactModal();
//     //         });
//     //     },

//     //     getPopup: function() {
//     //         return popupCreateContact;
//     //     }
//     // };
// };

function removeMaskLoading() {
    $('.mask-loading-effect').remove();
}

function addMaskLoading(text, callback, options) {
    removeMaskLoading();
    var wait = 400;
    
    if (typeof(text) === 'undefined') {
        text = '';
    }

    if (typeof(options) === 'undefined') {
        options = {};
    }

    if (typeof(options.wait) !== 'undefined') {
        wait = options.wait;
    }
    
    var div = $('<div>').html(`<div class="mask-loading-effect"><div class="content">
        <div class="mask-loading mb-3"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
        `+text+`</div><div>`
    );
    
    $('body').append(div);
    
    div.fadeIn(400, function() {
        if (typeof(callback) !== 'undefined') {
            setTimeout(function() { callback(); }, wait);
        }
    });
}

function copyToClipboard(text, container) {
    var $temp = $("<input>");
    if (typeof(container) !== 'undefined') {
        container.append($temp);
    } else {
        $("body").append($temp);
    }
    
    $temp.val(text.trim()).select();
    document.execCommand("copy");
    $temp.remove();
}