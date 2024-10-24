<div class="scroll-y pe-7  py-10 px-lg-17">
    <!--begin::Input group-->
    <div class="fv-row mb-10 fv-plugins-icon-container">
        <!--begin::Label-->
        <div class="row">
            <div class="col-md-12">

                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">
                        <span class="">Đơn hàng</span>
                    </label>

                    <input type="text" class="form-control" id="" name="name" placeholder="Đơn hàng"
                        required value="{{ $demand->name}}"/>

                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

            </div>
        </div>
    </div>