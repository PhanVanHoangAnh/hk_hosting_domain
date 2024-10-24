var ColumnsDisplayManagerClass = class {
    constructor(options) {
        this.columns = options.columns;
        this.optionsBox = options.optionsBox;
        this.getList = options.getList;

        // save view
        this.name = options.name;
        this.saveUrl = options.saveUrl;

        // drag & drop
        this.dragging = false;
        this.draggingColumnId = null;

        // drag & drop th
        this.draggingTh = false;
        this.draggingThId = null;

        // render options box
        this.renderOptionsBox();
    }

    getColumns() {
        return this.columns;
    }

    applyToList() {
        var _this = this;
        this.getCheckedColumnIds().reverse().forEach(function(id) {
            var trs = _this.getList().listContent.querySelectorAll('thead tr');
            trs.forEach(function(tr) {
                // Find all the 'th' elements in the table
                var cols = tr.querySelectorAll('[data-column]');
                var firstCol = cols[0];

                // Loop through each 'th' element and move it to the beginning of its parent 'tr'
                cols.forEach(function(colElement) {
                    var colId = colElement.getAttribute('data-column');

                    if (colId == id) {
                        tr.insertBefore(colElement, firstCol);
                    }
                });
            });

            var trs = _this.getList().listContent.querySelectorAll('tbody tr');
            trs.forEach(function(tr) {
                // Find all the 'th' elements in the table
                var tds = tr.querySelectorAll('td[data-column]');
                var firstTd = tds[0];

                // Loop through each 'th' element and move it to the beginning of its parent 'tr'
                tds.forEach(function(tdElement) {
                    var tdId = tdElement.getAttribute('data-column');

                    if (tdId == id) {
                        tr.insertBefore(tdElement, firstTd);
                    }
                });
            });
        });

        //
        this.afterListContactLoadEvents();

        // save list view
        if (this.saveUrl) {
            this.saveListView();
        }
    }

    saveListView() {
        $.ajax({
            url: this.saveUrl,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                name: this.name,
                columns: this.getCheckedColumnIds(),
            }
        }).done((response) => {
            
        })
    }

    isDragging() {
        return this.dragging;
    }

    isDraggingTh() {
        return this.draggingTh;
    }

    startDragging(columnId) {
        this.dragging = true;
        this.draggingColumnId = columnId;
    }

    startDraggingTh(thId) {
        this.draggingTh = true;
        this.draggingThId = thId;

    }

    stopDragging() {
        this.dragging = false;
        this.draggingColumnId = null;
    }

    stopDraggingTh() {
        this.draggingTh = false;
        this.draggingThId = null;
    }

    dropBeforeColumn(dragId, dropId) {
        // swap columns position
        this.swapColumns(dragId, dropId);
    }

    findColumnById(columnId) {
        return this.columns.filter(function(column) {
            return column.id == columnId;
        })[0];
    }

    swapColumns(dragId, dropId) {
        var _this = this;
        var newColumns = [];
        var dragColumn = this.findColumnById(dragId);
        var dropColumn = this.findColumnById(dropId);

        this.columns.forEach(function(column) {
            // 
            if (dragId == column.id) {
                return;
            } else if (dropId == column.id) {
                newColumns.push(dragColumn);
                newColumns.push(dropColumn);

                dragColumn.checked = dropColumn.checked;
            } else {
                newColumns.push(column);
            }
        });

        this.columns = newColumns;

        // render
        this.renderOptionsBox();

        // load list
        this.getList().load();
    }

    getOptionsBox() {
        return this.optionsBox;
    }

    getCheckedBox() {
        return this.getOptionsBox().querySelector('[column-control="checked-box"]');
    }

    getUncheckedBox() {
        return this.getOptionsBox().querySelector('[column-control="unchecked-box"]');
    }

    renderColumnsItem(column) {
        return `
            <div column-control="column" data-id="` + column.id + `">
                <div class="p-2 my-2 border me-2 rounded bg-white">
                    <div class="d-flex align-items-center">
                        <div class="form-check column-item mb-0">
                            <input
                                style="cursor: pointer;"
                                id="column-checker-` + column.id + `"
                                column-action="checker"
                                data-value="` + column.id + `"
                                class="form-check-input" type="checkbox"
                                ` + (column.checked ? 'checked' : '') + `
                            />
                            <label class=""
                                for="column-checker-` + column.id + `">
                                ` + column.title + `
                            </label>
                        </div>
                        <div column-control="column-mover" class="ms-auto" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-dismiss="click" data-bs-placement="top" title="Kéo & Thả vị trí mong muốn">
                            <span class="material-symbols-rounded d-flex align-items-center">
                                open_with
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    renderCheckedBox() {
        var _this = this;

        $(_this.getCheckedBox()).html('');
        this.getCheckedColumns().forEach(function(column) {
            $(_this.getCheckedBox()).append(_this.renderColumnsItem(column));
        });
    }

    renderUncheckedBox() {
        var _this = this;

        $(_this.getUncheckedBox()).html('');
        this.getUncheckedColumns().forEach(function(column) {
            $(_this.getUncheckedBox()).append(_this.renderColumnsItem(column));
        });
    }

    renderOptionsBox() {
        this.renderCheckedBox();
        this.renderUncheckedBox();

        //
        KTComponents.init();

        // events
        this.afterRenderEvents();
    }

    getColumnCheckers() {
        return this.getOptionsBox().querySelectorAll('[column-action="checker"]');
    }

    getShadow() {
        return document.querySelector('[column-control="shadow"]');
    }

    getShadowTh() {
        return document.querySelector('[column-control="shadow-th"]');
    }

    addShadow(html) {
        $(document.body).append(`
            <div column-control="shadow" style="pointer-events:none;position:fixed;z-index:500;width: 200px">
                `+html+`
            </div>
        `);
    }

    addShadowTh(html) {
        $(document.body).append(`
            <div column-control="shadow-th" class="px-3 py-1 border rounded bg-light" style="pointer-events:none;position:fixed;z-index:500;width:auto;">
                `+html+`
            </div>
        `);
    }

    moveShadow(e) {
        $(this.getShadow()).css('left', e.clientX);
        $(this.getShadow()).css('top', e.clientY);
    }

    moveShadowTh(e) {
        $(this.getShadowTh()).css('left', e.clientX);
        $(this.getShadowTh()).css('top', e.clientY);
    }

    removeShadow() {
        $(document.body).find('[column-control="shadow"]').remove();
    }

    removeShadowTh() {
        $(document.body).find('[column-control="shadow-th"]').remove();
    }

    getColumnsThs() {
        return this.getList().listContent.querySelectorAll('thead th[data-column]');
    }

    afterListContactLoadEvents() {
        var _this = this;

        // drag & drop: mousedown
        this.getColumnsThs().forEach(function(th) {
            th.addEventListener('mousedown', function(e) {
                var id = th.getAttribute('data-column');

                // add shadow
                _this.addShadowTh(th.innerHTML);

                // moveShadow
                // _this.moveShadowTh(e);
                // start dragging
                _this.startDraggingTh(id);
            });
        });

        // drag & drop: mouseupmove
        document.body.addEventListener('mousemove', function(e) {
            if (_this.isDraggingTh()) {
                e.preventDefault();
                
                var overColumn = $(e.target).closest('th[data-column]');
                var overId = overColumn.attr('data-column');

                // moveShadow
                _this.moveShadowTh(e);

                if (_this.draggingThId == overId) {
                    return;
                }

                // remove hiệu ứng tất cả ô khác
                $('th[data-column]').removeClass('th-column-hover');

                // thêm hiệu ứng hover
                overColumn.addClass('th-column-hover');
            }
        });

        // drag & drop: mouseup
        document.body.addEventListener('mouseup', function(e) {
            if (_this.isDraggingTh()) {
                e.preventDefault();

                var hoverColumn = $(e.target).closest('th[data-column]');
                var dropThId = hoverColumn.attr('data-column');

                // remove hiệu ứng tất cả ô khác
                $('th[data-column]').removeClass('th-column-hover');

                // 1/ drop vào vị trí của column khác
                if (hoverColumn.length) {
                    if (dropThId !== _this.draggingThId) {
                        _this.dropBeforeColumn(_this.draggingThId, dropThId);
                    }
                }

                // stop dragging
                _this.stopDraggingTh();

                // remove shadow
                _this.removeShadowTh();
            }
        });
    }

    afterRenderEvents() {
        var _this = this;

        // checker
        this.getColumnCheckers().forEach(function(checker) {
            checker.addEventListener('change', function(e) {
                var checked = checker.checked;
                var id = checker.getAttribute('data-value');

                if (checked) {
                    // move last
                    _this.check(id);
                } else {
                    _this.uncheck(id);
                }
            });
        });

        // drag & drop: mousedown
        this.getColumnMovers().forEach(function(control) {
            control.addEventListener('mousedown', function(e) {
                var column = $(e.target).closest('[column-control="column"]');
                var id = column.attr('data-id');

                // add shadow
                _this.addShadow(column.html());

                // moveShadow
                _this.moveShadow(e);

                // start dragging
                _this.startDragging(id);
            });
        });

        // drag & drop: mouseupmove
        document.body.addEventListener('mousemove', function(e) {
            if (_this.isDragging()) {
                e.preventDefault();

                var overColumn = $(e.target).closest('[column-control="column"]');
                var overId = overColumn.attr('data-id');

                // moveShadow
                _this.moveShadow(e);

                if (_this.draggingColumnId == overId) {
                    return;
                }

                // remove hiệu ứng tất cả ô khác
                $('[column-control="column"]').removeClass('column-hover');

                // thêm hiệu ứng hover
                overColumn.addClass('column-hover');
            }
        });

        // drag & drop: mouseup
        document.body.addEventListener('mouseup', function(e) {
            if (_this.isDragging()) {
                e.preventDefault();

                var hoverColumn = $(e.target).closest('[column-control="column"]');
                var dropColumnId = hoverColumn.attr('data-id');
                var checkedBox = $(e.target).closest('[column-control="checked-box-container"]');
                var uncheckedBox = $(e.target).closest(
                    '[column-control="unchecked-box-container"]');

                // remove hiệu ứng tất cả ô khác
                $('[column-control="column"]').removeClass('column-hover');

                // 1/ drop vào vị trí của column khác
                if (hoverColumn.length) {
                    if (dropColumnId !== _this.draggingColumnId) {
                        _this.dropBeforeColumn(_this.draggingColumnId, dropColumnId);
                    }
                }

                // 2. drop vào trong checked box
                else if (checkedBox.length) {
                    _this.dropInsideCheckedBox(_this.draggingColumnId);
                }

                // 3. drop vào trong unchecked box
                else if (uncheckedBox.length) {
                    _this.dropInsideUncheckedBox(_this.draggingColumnId);
                }

                // stop dragging
                _this.stopDragging();

                // remove shadow
                _this.removeShadow();
            }
        });
    }

    dropInsideCheckedBox(draggingColumnId) {
        this.columns = this.columns.map(function(column) {
            if (column.id == draggingColumnId) {
                column.checked = true;
                return column;
            } else {
                return column;
            }
        });

        // render
        this.renderOptionsBox();

        // load list
        this.getList().load();
    }

    dropInsideUncheckedBox(draggingColumnId) {
        this.columns = this.columns.map(function(column) {
            if (column.id == draggingColumnId) {
                column.checked = false;
                return column;
            } else {
                return column;
            }
        });

        // render
        this.renderOptionsBox();

        // load list
        this.getList().load();
    }

    getColumnControls() {
        return this.getOptionsBox().querySelectorAll('[column-control="column"]');
    }

    getColumnMovers() {
        return this.getOptionsBox().querySelectorAll('[column-control="column-mover"]');
    }

    uncheck(id) {
        this.columns = this.columns.map(function(column) {
            if (column.id == id) {
                column.checked = false;
                return column;
            }

            return column;
        });

        // render
        this.renderOptionsBox();

        // load list
        this.getList().load();
    }

    check(id) {
        this.columns = this.columns.map(function(column) {
            if (column.id == id) {
                column.checked = true;
                return column;
            }

            return column;
        });

        // render
        this.renderOptionsBox();

        // load list
        this.getList().load();
    }

    getCheckedColumns() {
        return this.columns.filter(function(column) {
            return column.checked;
        });
    }

    getUncheckedColumns() {
        return this.columns.filter(function(column) {
            return !column.checked;
        });
    }

    getCheckedColumnIds() {
        return this.getCheckedColumns().map(function(column) {
            return column.id;
        });
    }
}