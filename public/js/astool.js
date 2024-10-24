var ASTool = {
    alert: function(options) {
        if (!options.icon) {
            options.icon = 'success'
        }

        if (!options.textOk) {
            options.textOk = 'OK'
        }

        Swal.fire({
            html: options.message,
            icon: options.icon,
            buttonsStyling: false,
            confirmButtonText: options.textOk,
            allowEnterKey: true,
            customClass: {
                confirmButton: "btn btn-primary"
            }
        }).then((result) => {
            if (options.ok) {
                options.ok();
            }
        });
    },

    confirm: function(options) {
        Swal.fire({
            title: 'Bạn chắc chứ?',
            text: options.message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy',
        }).then((result) => {
            if (result.isConfirmed) {
                if (options.ok) {
                    options.ok();
                }
            }

            if (result.isDismissed) {
                if (options.cancel) {
                    options.cancel();
                }
            }
            
        });
        
        // if (!options.icon) {
        //     options.icon = 'success'
        // }

        // if (!options.textOk) {
        //     options.textOk = 'OK'
        // }
    },
    
    addPageLoadingEffect: function() {
        var element = document.createElement('div')
        element.innerHTML = `
            <div data-control="page-loading" style="
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.1);
                position: fixed;
                top: 0;
                left: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1000000;
            ">
                <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        document.body.appendChild(element);
    },

    removePageLoadingEffect: function() {
        document.querySelector('[data-control="page-loading"]').remove();
    },

    fixPopupLayers: function() {
        var initZIndex = 1000;

        $('.modal-backdrop:visible').each(function(index) {
            var zIndex = initZIndex + (index*10);

            $(this).css('z-index', zIndex);
        });

        var initZIndex = 1010;

        $('.modal:visible').each(function(index) {
            var zIndex = initZIndex + (index*10);

            $(this).css('z-index', zIndex);
        });
    },

    warning: function(options) {

        if (!options.icon) {
            options.icon = 'warning'
        }

        if (!options.textOk) {
            options.textOk = 'OK'
        }

        Swal.fire({
            text: options.message,
            icon: options.icon,
            buttonsStyling: false,
            confirmButtonText: options.textOk,
            allowEnterKey: true,
            customClass: {
                confirmButton: "btn btn-primary"
            }
        }).then((result) => {
            if (options.ok) {
                options.ok();
            }
        });
    },
};