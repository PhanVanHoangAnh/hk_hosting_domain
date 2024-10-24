<button data-control="zoom-button" type="button" class="btn btn-outline btn-outline-default as-zoom-button px-4" style="height:43px;">
    <span class="d-flex align-items-center">
        <span data-control="icon" class="material-symbols-rounded">
            zoom_out_map
        </span>
    </span>
</button>

<script>
    $(() => {
        window.zoomManager = new ZoomManager({
            buttons: $('[data-control="zoom-button"]'),
            wrapper: $('body')
        });
    });

    var ZoomManager = class {
        constructor(options) {
            this.buttons = options.buttons;
            this.wrapper = options.wrapper;

            // events
            this.events();
        }

        getIcons() {
            return this.buttons.find('[data-control="icon"]');
        }

        events() {
            var _this = this;
            this.buttons.on('click', function(e) {
                e.preventDefault();

                if (_this.isZoomedIn()) {
                    _this.zoomOut();
                } else {
                    _this.zoomIn();
                }
            });
        }

        isZoomedIn() {
            return this.wrapper.hasClass('as-zoomed-in');
        }

        zoomIn() {
            this.wrapper.addClass('as-zoomed-in');
            this.getIcons().html('zoom_in_map');
        }

        zoomOut() {
            this.wrapper.removeClass('as-zoomed-in');
            this.getIcons().html('zoom_out_map');
        }
    }
</script>
