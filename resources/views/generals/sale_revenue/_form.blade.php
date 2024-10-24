@php
    $includeSaleRevenueFormId = "include_sale_revenue_form_id_" . uniqId();
@endphp

<div class="card p-10" form-data="{{ $includeSaleRevenueFormId }}">
    <input type="hidden" name="revenue_distributions" value="{!! $revenueDistributions !!}">
    <input type="hidden" name="total_price" value="{!! $totalPrice !!}">
    <div class="p-5">
        <div form-data="body">
        </div>
        <input type="hidden" name="sales_revenued_list">
        <div class="row mb-5 mt-5">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 col-xs-12 d-flex justify-content-center">
                {{-- Button add person --}}
                <button class="btn btn-info w-25" action-control="add">+</button>
            </div>
        </div>
    </div>
</div>

<script>
    var tool;

    $(() => {
        tool = new RevenueTool({
            container: () => {
                return $('[form-data="{{ $includeSaleRevenueFormId }}"]');
            }
        })
    })

    var RevenueTool = class {
        constructor(options) {
            this.container = options.container;
            this.rows = [];

            this.initDatas();
            this.load();
            this.events();
        }

        /* GETTER SETTER */

        /**
         * Get button add new person
         * 
         * @return {Jquery} jQuery object containing the add button element(s)
         */
        getAddBtn() {
            return this.container().find('[action-control="add"]');
        }

        getSaveInput() {
            return this.container().find('[name="sales_revenued_list"]');
        }

        /* METHOD */

        /**
         * Initialize revenue data.
         * 
         * @return {void}
         */
        initDatas() {
            const originData = JSON.parse(this.container().find('[name="revenue_distributions"]').val());
            const originTotalPrice = JSON.parse(this.container().find('[name="total_price"]').val());
            
            const defaultSaleId = {{ $defaultSaleId }};

            // Generate a unique identifier (c_id) for each data item
            originData.forEach(data => {
                data.c_id = this.generateCId();

                /* 
                    The logic is that when the sale is changed externally 
                    and then the edit button is pressed for an already created service, 
                    the default sale in the service being edited will automatically switch to the newly modified external sale. 
                    However, the database will only be updated when the save button is pressed.
                */
                if (data.is_primary == 1) {
                    if (data.account_id != defaultSaleId) data.account_id = defaultSaleId;
                }
            })

            this.revenueData = originData; // rows
            this.totalPrice = originTotalPrice; // price    
        }

        /**
         * Add new data to the revenue data.
         * 
         * @param {object} dataToAdd - The data object to add.
         * @return {void}
         */
        addData(dataToAdd) {
            this.revenueData.push(dataToAdd);
        }

        /**
         * Remove data from revenue data by c_id.
         * 
         * @param {string} cId - The c_id of the data item to remove.
         * @return {void}
         */
        removeData(cId) {
            this.revenueData = this.revenueData.filter(data => data.c_id != cId);

            this.load();
        }

        /**
         * Update existing data in revenue data.
         * 
         * @param {object} data - The updated data object.
         * @return {void}
         * @throws {object} - Custom error object if the item to update is not found in the original data.
         */
        updateData(data) {
            const index = this.revenueData.findIndex(item => item.c_id == data.c_id);

            // If the data item is found, update it; otherwise, throw an error
            if (index !== -1) {
                this.revenueData[index] = { ...this.revenueData[index], ...data };
            } else {
                throw {
                    type: "error",
                    info: "custom error alert",
                    file: "generals/sale_revenue/_form.blade.php",
                    message: "Item to update not found in the original data!",
                }
            }
        }

        convertStringPriceToFloat(price) {
            if (typeof price === 'string') {
                price = price.replace(/[^\d.]/g, '');
                price = price.replace(/\.(?=.*\.)/g, '');

                return parseFloat(price);
            } else if (typeof price === 'number') {
                return parseFloat(price);
            } else {
                // Error
                throw {
                    type: "error",
                    info: "custom error alert",
                    file: "generals/sale_revenue/_form.blade.php",
                    message: "convert string price to number fail"
                }
            }
        }

        updateTotalPrice(newPrice) {
            this.totalPrice = this.convertStringPriceToFloat(newPrice);
            this.load();
        }

        /**
         * Generate a unique identifier (c_id) for revenue data.
         * 
         * @return {string} - The generated unique identifier.
         */
        generateCId() {
            return 'custom_id_' + Date.now() + '_' + Math.floor(Math.random() * 1000);
        }

        loadDataToSave() {
            this.getSaveInput().val(JSON.stringify(this.revenueData));
        }

        /**
         * Reload list
         * 
         * Sends an AJAX POST request to retrieve and update a list of revenue distributions.
         * 
         * @return {void}
         */
        load() {
            const data = {
                _token: "{{ csrf_token() }}",
                parentId: "{{ $parentId }}",
                defaultSaleId: {{ $defaultSaleId }},
                totalPrice: this.totalPrice,
                revenueData: JSON.stringify(this.revenueData),
            }

            $.ajax({
                url: "{{ action([App\Http\Controllers\SaleRevenueController::class, 'getDistributeList']) }}",
                method: 'POST',
                data: data
            }).done(res => {
                this.container().find('[form-data="body"]').html(res);

                // Initializes any JavaScript functionality (e.g., Select2) within the updated content.
                if (this.container().find('[form-data="body"]')[0]) {
                    initJs(this.container().find('[form-data="body"]')[0]);
                }

                this.loadDataToSave();
            }).fail(res => {
                // Throws an error containing details about the failure
                throw {
                    type: "error",
                    info: "custom error alert",
                    file: "generals/sale_revenue/_form.blade.php",
                    message: "ajax fail, cannot get revenue persons list from server!",
                    originError: {
                        file: res.responseJSON.file,
                        line: res.responseJSON.line,
                        message: res.responseJSON.message,
                    }
                }
            })
        }

        /**
         * Add new data to revenue data
         * 
         * @return {void}
         */
        clickAdd() {
            const emptyData = {
                account_id: null,
                is_primary: false,
                order_item_id: null,
                amount: null,
                c_id: this.generateCId()
            }

            this.addData(emptyData);
            this.load(); // reload
        }

        /**
         * Events handle
         * 
         * @return {void}
         */
        events() {
            const _this = this; // override this

            _this.getAddBtn().on('click', e => {
                e.preventDefault();
                _this.clickAdd();
            })
        }
    }
</script>