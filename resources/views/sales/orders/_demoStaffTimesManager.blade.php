@php
    $staffTimesManagerContainerUniqId = 'STMCU_' . uniqid();
@endphp

<div class="row" id="{{ $staffTimesManagerContainerUniqId }}">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-8 mt-8">
        @php
            $trainOrderStaffTimesManagerUniqId = 'S' . uniqid();
        @endphp
    
        <div id="{{ $trainOrderStaffTimesManagerUniqId }}" form-container="trainOrderStaffTimesManagerUniqId">
            {{-- Discount percent --}}
            
            <table class="table table-bordered border-10 w-100">
                {{-- Table head --}}
                <thead>
                    <tr>
                        <th class="text-center" rowspan="3"></th>
                        <th class="text-center" rowspan="3">Số&nbsp;buổi</th>
                    </tr>
                    <tr>
                        <th class="text-center" colspan="2">Thời&nbsp;lượng/buổi</th>
                        <th class="text-center" colspan="2">Tổng&nbsp;thời&nbsp;lượng</th>    
                        <th class="text-center" colspan="1" rowspan="3">Giá dịch vụ</th>    
                        <th class="text-center" colspan="1" rowspan="3">Giá dịch vụ sau giảm giá</th>    
                    </tr>
                    <tr>
                        <th class="text-center">Giờ</th>
                        <th class="text-center">Phút</th>
                        <th class="text-center">Giờ</th>
                        <th class="text-center">Phút</th>
                    </tr>
                </thead>
        
                {{-- Table body --}}
                <tbody>
                    {{-- FOREIGN TEACHER --}}
                    <tr data-container="foreign-teacher">
                        <td class="text-center align-middle">Giáo viên nước ngoài</td>
                        <td class="text-center"><input type="number" class="form-control border-0 text-center" data-control="num-of-sections" name="num_of_foreign_teacher_sections" value="{{ isset($orderItem->num_of_foreign_teacher_sections) ? $orderItem->num_of_foreign_teacher_sections : '0' }}" action-control="input"></td>
                        <td class="text-center"><input type="number" value="0" class="form-control border-0 text-center" data-control="hours-per-section" action-control="input"></td> {{-- Foreign hours per section --}}
                        <td class="text-center"><input type="number" value="0" class="form-control border-0 text-center" data-control="minutes-per-section" action-control="input"></td> {{-- Foreign minutes per section --}}
                        <input type="hidden" name="foreign_teacher_minutes_per_section" value="{{ isset($orderItem->foreign_teacher_minutes_per_section) ? $orderItem->foreign_teacher_minutes_per_section : "0" }}"> {{-- Foreign duration per section save DB --}}
                        <td class="text-center">
                            <input type="text" class="form-control border-0 cursor-pointer text-center" placeholder="--" 
                                    data-control="total-hours"
                                    readonly>
                        </td>
                        <td class="text-center">
                            <input type="text" class="form-control border-0 cursor-pointer text-center" placeholder="--" 
                                    data-control="total-minutes"
                                    readonly>
                        </td>
                        <td class="text-center align-middle">
                            <input type="text" class="form-control border-0 text-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    name="foreign_teacher_price"
                                    value="{{ isset($orderItem->foreign_teacher_price) ? App\Helpers\Functions::formatNumber($orderItem->foreign_teacher_price) : "0" }}"
                                    data-control="salary"
                                    readonly>
                        </td>
                        <td class="text-center align-middle">
                            <input type="text" class="form-control border-0 text-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-control="salary_after_discount"
                                    readonly>
                        </td>
                    </tr>

                    {{-- VIETNAM TEACHER --}}
                    <tr data-container="vn-teacher">
                        <td class="text-center align-middle">Giáo viên Việt Nam</td>
                        <td class="text-center"><input type="number" class="form-control border-0 text-center" data-control="num-of-sections" name="num_of_vn_teacher_sections" value="{{ isset($orderItem->num_of_vn_teacher_sections) ? $orderItem->num_of_vn_teacher_sections : '0' }}" action-control="input"></td>
                        <td class="text-center"><input type="number" value="0" class="form-control border-0 text-center" data-control="hours-per-section" action-control="input"></td> {{-- VN hours per section --}}
                        <td class="text-center"><input type="number" value="0" class="form-control border-0 text-center" data-control="minutes-per-section" action-control="input"></td> {{-- VN minutes per section --}}
                        <input type="hidden" name="vietnam_teacher_minutes_per_section" value="{{ isset($orderItem->vietnam_teacher_minutes_per_section) ? $orderItem->vietnam_teacher_minutes_per_section : "0" }}"> {{-- VN duration per section save DB --}}
                        <td class="text-center">
                            <input type="text" class="form-control border-0 cursor-pointer text-center" placeholder="--" 
                                    data-control="total-hours"
                                    readonly>
                        </td>
                        <td class="text-center">
                            <input type="text" class="form-control border-0 cursor-pointer text-center" placeholder="--" 
                                    data-control="total-minutes"
                                    readonly>
                        </td>
                        <td class="text-center align-middle">
                            <input type="text" class="form-control border-0 text-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    name="vn_teacher_price"
                                    value="{{ isset($orderItem->vn_teacher_price) ? App\Helpers\Functions::formatNumber($orderItem->vn_teacher_price) : "0" }}"
                                    data-control="salary"
                                    readonly>
                                </td>
                                <td class="text-center align-middle">
                                    <input type="text" class="form-control border-0 text-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-control="salary_after_discount"
                                    readonly>
                        </td>
                    </tr>
        
                    {{-- TUTOR --}}
                    <tr data-container="tutor">
                        <td class="text-center align-middle">Gia sư</td>
                        <td class="text-center"><input type="number" class="form-control border-0 text-center" data-control="num-of-sections" name="num_of_tutor_sections" value="{{ isset($orderItem->num_of_tutor_sections) ? $orderItem->num_of_tutor_sections : '0' }}" action-control="input"></td>
                        <td class="text-center"><input type="number" value="0" class="form-control border-0 text-center" data-control="hours-per-section" action-control="input"></td> {{-- Tutor hours per section --}}
                        <td class="text-center"><input type="number" value="0" class="form-control border-0 text-center" data-control="minutes-per-section" action-control="input"></td> {{-- Tutor minutes per section --}}
                        <input type="hidden" name="tutor_minutes_per_section" value="{{ isset($orderItem->tutor_minutes_per_section) ? $orderItem->tutor_minutes_per_section : "0" }}"> {{-- Tutor duration per section save DB --}}
                        <td class="text-center">
                            <input type="text" class="form-control border-0 cursor-pointer text-center" placeholder="--" 
                                    data-control="total-hours"
                                    readonly>
                        </td>
                        <td class="text-center">
                            <input type="text" class="form-control border-0 cursor-pointer text-center" placeholder="--"
                                    data-control="total-minutes"
                                    readonly>
                        </td>
                        <td class="text-center align-middle">
                            <input type="text" class="form-control border-0 text-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    name="tutor_price"
                                    value="{{ isset($orderItem->tutor_price) ? App\Helpers\Functions::formatNumber($orderItem->tutor_price) : "0" }}"
                                    data-control="salary"
                                    readonly>
                                </td>
                                <td class="text-center align-middle">
                                    <input type="text" class="form-control border-0 text-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-control="salary_after_discount"
                                    readonly>
                        </td>
                    </tr>

                    {{-- This script is used to disallow user fill float into hours per section input! --}}
                    <script>
                        var hoursPerSectionInputRegex = /^-?\d*$/;
                      
                        $(() => {
                            $('[data-control="hours-per-section"]').each((key, item) => {
                                $(item).on('input', e => {
                                    if (!hoursPerSectionInputRegex.test($(item).val())) {
                                        $(item).val($(item).val().replace(/[^0-9-]/g, ''))
                                    }
                                });
                            });
                        });
                    </script>
        
                    {{-- SUM --}}
                    <tr data-container="sum">
                        <td class="text-center align-middle">Tổng cộng</td>
                        <td class="text-center">
                            <input type="number" class="form-control border-0 cursor-pointer text-center" data-control="sum-num-of-sections"
                                    placeholder="--" action-control="input"
                                    readonly>
                        </td>
                        <td class="text-center">
                            <input type="number" class="form-control border-0 cursor-pointer text-center" data-control="sum-hours-per-section"
                                    placeholder="--" action-control="input"
                                    readonly>
                        </td>
                        <td class="text-center">
                            <input type="number" class="form-control border-0 cursor-pointer text-center" data-control="sum-minutes-per-section"
                                    placeholder="--" action-control="input"
                                    readonly>
                        </td>
                        <td class="text-center">
                            <input type="text" class="form-control border-0 cursor-pointer text-center" placeholder="--"
                                    data-control="sum-total-hours"
                                    readonly>
                        </td>
                        <td class="text-center">
                            <input type="text" class="form-control border-0 cursor-pointer text-center" placeholder="--"
                                    data-control="sum-total-minutes"
                                    readonly>
                        </td>
                        <td class="text-center align-middle">
                            <input type="text" class="form-control border-0 cursor-pointer text-center" placeholder="--"
                                    data-control="sum_salary_after_discount"
                                    readonly>
                        </td>
                        <td class="text-center align-middle">
                            <input type="text" class="form-control border-0 cursor-pointer text-center" placeholder="--"
                                    data-control="sum-salary"
                                    readonly>
                        </td>
                    </tr>
                </tbody>
            </table>
        
            {{-- ERRORS --}}
            <div class="row d-flex justify-content-center">
                <x-input-error :messages="$errors->get('num_of_vn_teacher_sections')" class="mt-2 text-center"/>
                <x-input-error :messages="$errors->get('num_of_foreign_teacher_sections')" class="mt-2 text-center"/>
                <x-input-error :messages="$errors->get('num_of_tutor_sections')" class="mt-2 text-center"/>
                <x-input-error :messages="$errors->get('vietnam_teacher_minutes_per_section')" class="mt-2 text-center"/>
                <x-input-error :messages="$errors->get('foreign_teacher_minutes_per_section')" class="mt-2 text-center"/>
                <x-input-error :messages="$errors->get('tutor_minutes_per_section')" class="mt-2 text-center"/>
                <x-input-error :messages="$errors->get('custom_validate_price_staff')" class="mt-2 text-center"/>
            </div>
        
            <div data-container="vn-error-manager">
                <div class="text-danger text-center d-none" label-control="error"></div>
            </div>
        
            <div data-container="foreign-error-manager">
                <div class="text-danger text-center d-none" label-control="error"></div>
            </div>
        
            <div data-container="tutor-error-manager">
                <div class="text-danger text-center d-none" label-control="error"></div>
            </div>
        
        </div>
    
        {{-- STAFF TIMES MANAGER SCRIPT --}}
        <script>    
            /**
             * Class use to manage table teach time & salary for each teacher
             */ 
            var StaffTimesManager = class {
                constructor(options) {
                    this.container = options.container;
                    this.rowsData = {
                        vnTeacher: new StaffDataRow({
                            tool: this,
                            container: () => {
                                return this.container().querySelector('[data-container="vn-teacher"]');
                            },
                            name: "vietnam_teacher_minutes_per_section",
                            errorManager: new ErrorManager({
                                tool: this,
                                container: this.container().querySelector('[data-container="vn-error-manager"]')
                            })
                        }),
                        foreignTeacher: new StaffDataRow({
                            tool: this,
                            container: () => {
                                return this.container().querySelector('[data-container="foreign-teacher"]');
                            },
                            name: "foreign_teacher_minutes_per_section",
                            errorManager: new ErrorManager({
                                tool: this,
                                container: this.container().querySelector('[data-container="foreign-error-manager"]')
                            })
                        }),
                        tutor: new StaffDataRow({
                            tool: this,
                            container: () => {
                                return this.container().querySelector('[data-container="tutor"]');
                            },
                            name: "tutor_minutes_per_section",
                            errorManager: new ErrorManager({
                                tool: this,
                                container: this.container().querySelector('[data-container="tutor-error-manager"]')
                            })
                        }),
                    };

                    this.salaryMask;
                    this.salaryAfterDiscountMask;
        
                    this.assignMasks();
                    this.init();
                }
    
                setParent(parent) {
                    this.parent = parent;
                }
        
                // GETTER/SETTER
        
                getContainer() {
                    return this.container;
                }
        
                getRowsData() {
                    return this.rowsData;
                }
        
                // Sum sections
                getSumSectionsInput() {
                    return this.container().querySelector('[data-control="sum-num-of-sections"]');
                }
        
                getSumSectionsValue() {
                    return this.getSumSectionsInput().value;
                }
        
                setSumSectionsValue(sum) {
                    this.getSumSectionsInput().value = sum;
                }
        
                // Sum hours per section
                getSumHoursPerSectionInput() {
                    return this.container().querySelector('[data-control="sum-hours-per-section"]');
                }
        
                getSumHoursPerSectionValue() {
                    return this.getSumHoursPerSectionInput().value;
                }
        
                setSumHoursPerSectionValue(sum) {
                    this.getSumHoursPerSectionInput().value = sum;
                }
        
                // Sum minutes per section
                getSumMinutesPerSectionInput() {
                    return this.container().querySelector('[data-control="sum-minutes-per-section"]');
                }
        
                getSumMinutesPerSectionValue() {
                    return this.getSumMinutesPerSectionInput().value;
                }
        
                setSumMinutesPerSectionValue(sum) {
                    this.getSumMinutesPerSectionInput().value = sum;
                }
        
                // Sum total hours
                getSumTotalHoursInput() {
                    return this.container().querySelector('[data-control="sum-total-hours"]');
                }
        
                getSumTotalHoursValue() {
                    return this.getSumTotalHoursInput().value;
                }
        
                setSumTotalHoursValue(sum) {
                    this.getSumTotalHoursInput().value = sum;
                }
        
                // Sum total minutes
                getSumTotalMinutesInput() {
                    return this.container().querySelector('[data-control="sum-total-minutes"]');
                }
        
                getSumTotalMinutesValue() {
                    return this.getSumTotalMinutesInput().value;
                }
        
                setSumTotalMinutesValue(sum) {
                    this.getSumTotalMinutesInput().value = sum;
                }
        
                // Sum salary
                getSumSalaryInput() {
                    this.salaryMask = new IMask(this.container().querySelector('[data-control="sum-salary"]'), {
                        mask: Number,
                        scale: 2,
                        thousandsSeparator: ',',
                        padFractionalZeros: false,
                        normalizeZeros: true,
                        radix: ',',
                        mapToRadix: ['.'],
                        min: 0,
                        max: 999999999999,
                    });
                    
                    return this.container().querySelector('[data-control="sum-salary"]');
                }
        
                getSumSalaryValue() {
                    return this.getSumSalaryInput().value;
                }
        
                setSumSalaryValue(sum) {
                    this.getSumSalaryInput().value = sum;

                    this.salaryMask = new IMask(this.getSumSalaryInput(), {
                        mask: Number,
                        scale: 2,
                        thousandsSeparator: ',',
                        padFractionalZeros: false,
                        normalizeZeros: true,
                        radix: ',',
                        mapToRadix: ['.'],
                        min: 0,
                        max: 999999999999,
                    });

                    setTimeout(() => { // push into stack
                        // Whenever set new value for this, use this value to caculate revenue sharing
                        if (typeof tool != 'undefined') { // tool is revenue tool include in revenue tool form
                            tool.updateTotalPrice(sum);
                        }
                    }, 1);
                }
        
                // Sum salary discounted
                getSumSalaryDiscountedInput() {
                    this.salaryMask = new IMask(this.container().querySelector('[data-control="sum_salary_after_discount"]'), {
                        mask: Number,
                        scale: 2,
                        thousandsSeparator: ',',
                        padFractionalZeros: false,
                        normalizeZeros: true,
                        radix: ',',
                        mapToRadix: ['.'],
                        min: 0,
                        max: 999999999999,
                    });
                    
                    return this.container().querySelector('[data-control="sum_salary_after_discount"]');
                }
        
                getSumSalaryDiscountedValue() {
                    return this.getSumSalaryDiscountedInput().value;
                }
        
                setSumSalaryDiscountedValue(sum) {
                    this.getSumSalaryDiscountedInput().value = sum;
                    
                    this.salaryMask = new IMask(this.getSumSalaryDiscountedInput(), {
                        mask: Number,
                        scale: 2,
                        thousandsSeparator: ',',
                        padFractionalZeros: false,
                        normalizeZeros: true,
                        radix: ',',
                        mapToRadix: ['.'],
                        min: 0,
                        max: 999999999999,
                    });
    
                    // // Whenever set new value for this, use this value to caculate revenue sharing
                    // if (typeof tool != 'undefined') { // tool is revenue tool include in revenue tool form
                    //     tool.updateTotalPrice(sum);
                    // }
                }
        
                // ACTION/METHOD
        
                // VALIDATE 
                
                // Validate before render sum sections
                validateToRenderSum(vnNumber, foreignNumber, tutorNumber) {
                    let isValid = true;
        
                    if (
                        (!vnNumber && !foreignNumber && !tutorNumber) ||
                        (parseInt(vnNumber) < 0 && parseInt(foreignNumber) < 0 && parseInt(tutorNumber) < 0)
                    ) {
                        isValid = false;
                    }
        
                    // Check for fields less than 0 and empty fields
                    if (
                        (parseInt(vnNumber) < 0 && (foreignNumber === '' || tutorNumber === '')) ||
                        (parseInt(foreignNumber) < 0 && (vnNumber === '' || tutorNumber === '')) ||
                        (parseInt(tutorNumber) < 0 && (vnNumber === '' || foreignNumber === ''))
                    ) {
                        isValid = false;
                    }
        
                    return isValid;
                }
        
                // String handle
                removeNonNumericChars(inputString) {
                    // Remove all characters not number from inputString.
                    const numericString = inputString.replace(/[^0-9]/g, '');
        
                    return numericString;
                }
        
                // CACULATE
                caculateSum(vnNumberInput, foreignNumberInput, tutorNumberInput) {
                    if (!vnNumberInput && !foreignNumberInput && !tutorNumberInput) {
                        return 0;
                    }
        
                    let sum = 0;
        
                    const vnNumber = this.removeNonNumericChars(vnNumberInput);
                    const foreignNumber = this.removeNonNumericChars(foreignNumberInput);
                    const tutorNumber = this.removeNonNumericChars(tutorNumberInput);
        
                    if (vnNumber && parseInt(vnNumber) > 0) {
                        sum += parseInt(vnNumber);
                    }
        
                    if (foreignNumber && parseInt(foreignNumber) > 0) {
                        sum += parseInt(foreignNumber);
                    }
        
                    if (tutorNumber && parseInt(tutorNumber) > 0) {
                        sum += parseInt(tutorNumber);
                    }
        
                    return sum;
                }
                
                // RESET
        
                resetSumSections() {
                    this.setSumSectionsValue('');
                }
        
                resetSumHoursPerSection() {
                    this.setSumHoursPerSectionValue('');
                }
        
                resetSumMinutesPerSection() {
                    this.setSumMinutesPerSectionValue('');
                }
        
                resetSumTotalHours() {
                    this.setSumTotalHoursValue('');
                }
        
                resetSumTotalMinutes() {
                    this.setSumTotalMinutesValue('');
                }
        
                resetSumSalary() {
                    this.setSumSalaryValue('');
                }
        
                resetSumSalaryAfterDiscount() {
                    this.setSumSalaryDiscountedValue('');
                }
        
                // RENDER
        
                // Sum sections
                renderSumSections() {
                    const vnNumber = this.getRowsData().vnTeacher.getNumOfSectionsValue();
                    const foreignNumber = this.getRowsData().foreignTeacher.getNumOfSectionsValue();
                    const tutorNumber = this.getRowsData().tutor.getNumOfSectionsValue();
                    
                    if (this.validateToRenderSum(vnNumber, foreignNumber, tutorNumber)) {
                        const sum = this.caculateSum(vnNumber, foreignNumber, tutorNumber);
                        this.setSumSectionsValue(sum);
                    } else {
                        this.resetSumSections(); // reset
                    }
                }
        
                // Sum hours per section
                renderSumHoursPerSection() {
                    const vnNumber = this.getRowsData().vnTeacher.getHoursPerSectionValue();
                    const foreignNumber = this.getRowsData().foreignTeacher.getHoursPerSectionValue();
                    const tutorNumber = this.getRowsData().tutor.getHoursPerSectionValue();
                    
                    if (this.validateToRenderSum(vnNumber, foreignNumber, tutorNumber)) {
                        const sum = this.caculateSum(vnNumber, foreignNumber, tutorNumber);
                        this.setSumHoursPerSectionValue(sum);
                    } else {
                        this.resetSumHoursPerSection(); // reset
                    }
                }
        
                // Sum minutes per section
                renderSumMinutesPerSection() {
                    const vnNumber = this.getRowsData().vnTeacher.getMinutesPerSectionValue();
                    const foreignNumber = this.getRowsData().foreignTeacher.getMinutesPerSectionValue();
                    const tutorNumber = this.getRowsData().tutor.getMinutesPerSectionValue();
        
                    if (this.validateToRenderSum(vnNumber, foreignNumber, tutorNumber)) {
                        const sum = this.caculateSum(vnNumber, foreignNumber, tutorNumber);
                        this.setSumMinutesPerSectionValue(sum);
                    } else {
                        this.resetSumMinutesPerSection(); // reset
                    }
                }
        
                // Sum total hours
                renderSumTotalHours() {
                    const vnNumber = this.getRowsData().vnTeacher.getTotalHoursValue();
                    const foreignNumber = this.getRowsData().foreignTeacher.getTotalHoursValue();
                    const tutorNumber = this.getRowsData().tutor.getTotalHoursValue();
        
                    if (this.validateToRenderSum(vnNumber, foreignNumber, tutorNumber)) {
                        const sum = this.caculateSum(vnNumber, foreignNumber, tutorNumber);
                        this.setSumTotalHoursValue(sum);
                    } else {
                        this.resetSumTotalHours(); // reset
                    }
                }
        
                // Sum total minutes
                renderSumTotalMinutes() {
                    const vnNumber = this.getRowsData().vnTeacher.getTotalMinutesValue();
                    const foreignNumber = this.getRowsData().foreignTeacher.getTotalMinutesValue();
                    const tutorNumber = this.getRowsData().tutor.getTotalMinutesValue();
        
                    if (this.validateToRenderSum(vnNumber, foreignNumber, tutorNumber)) {
                        const sum = this.caculateSum(vnNumber, foreignNumber, tutorNumber);
                        this.setSumTotalMinutesValue(sum);
                    } else {
                        this.resetSumTotalMinutes(); // reset
                    }
                }
        
                // Sum salary
                renderSumSalary() {
                    const vnNumber = this.getRowsData().vnTeacher.getSalaryValue();
                    const foreignNumber = this.getRowsData().foreignTeacher.getSalaryValue();
                    const tutorNumber = this.getRowsData().tutor.getSalaryValue();

                    if (this.validateToRenderSum(vnNumber, foreignNumber, tutorNumber)) {
                        const sum = this.caculateSum(vnNumber, foreignNumber, tutorNumber);
        
                        this.setSumSalaryDiscountedValue(sum);
                        // this.setSumSalaryValue(sum);
                    } else {
                        this.resetSumSalaryAfterDiscount(); // reset
                        // this.resetSumSalary(); // reset
                    }
        
                    setTimeout(() => {
                        if (revenueDistribution) {
                            revenueDistribution.validatePrice(); 
                        }
                    }, 0);
                }
        
                // Sum salary after discount
                renderSumSalaryAfterDiscount() {
                    setTimeout(() => {
                        const vnNumberAfterDiscount = this.getRowsData().vnTeacher.getSalaryAfterDiscountValue();
                        const foreignNumberAfterDiscount = this.getRowsData().foreignTeacher.getSalaryAfterDiscountValue();
                        const tutorNumberAfterDiscount = this.getRowsData().tutor.getSalaryAfterDiscountValue();
                       
                        if (this.validateToRenderSum(vnNumberAfterDiscount, foreignNumberAfterDiscount, tutorNumberAfterDiscount)) {
                            const sum = this.caculateSum(vnNumberAfterDiscount, foreignNumberAfterDiscount, tutorNumberAfterDiscount);
                            this.setSumSalaryValue(sum);
                            // this.setSumSalaryDiscountedValue(sum);
                        } else {
                            this.resetSumSalary(); // reset
                            // this.resetSumSalaryAfterDiscount(); // reset
                        }
                    }, 0);
        
                    setTimeout(() => {
                        if (revenueDistribution) {
                            revenueDistribution.validatePrice(); 
                        }
                    }, 0);
                }
        
                renderSum() {
                    this.renderSumSections();
                    this.renderSumHoursPerSection();
                    this.renderSumMinutesPerSection();
                    this.renderSumTotalHours();
                    this.renderSumTotalMinutes();
                    this.renderSumSalary();
                    this.renderSumSalaryAfterDiscount();
                }
        
                init() {
                    this.renderSum();

                    $(this.getSumSalaryDiscountedInput()).on('click', (e) => {
                        e.preventDefault();

                        this.salaryAfterDiscountMask.updateValue();
                    })
                }
        
                // Assign a mask to the input field
                assignMasks() {
                    if (this.getSumSalaryInput()) {
                        this.salaryMask = new IMask(this.getSumSalaryInput(), {
                            mask: Number,
                            scale: 2,
                            thousandsSeparator: ',',
                            padFractionalZeros: false,
                            normalizeZeros: true,
                            radix: ',',
                            mapToRadix: ['.'],
                            min: 0,
                            max: 999999999999,
                        });
                    };
        
                    if (this.getSumSalaryDiscountedInput()) {
                        this.salaryAfterDiscountMask = new IMask(this.getSumSalaryDiscountedInput(), {
                            mask: Number,
                            scale: 2,
                            thousandsSeparator: ',',
                            padFractionalZeros: false,
                            normalizeZeros: true,
                            radix: ',',
                            mapToRadix: ['.'],
                            min: 0,
                            max: 999999999999,
                        });
                    };
                }
            }
        
            /**
             * An object constructor for each staff row in staff data table
             * Instance of this class will be create in method of StaffTimesManager Class
             */
            var StaffDataRow = class {
                constructor(options) {
                    this.tool = options.tool;
                    this.container = options.container;
                    this.name = options.name;
                    this.errorManager = options.errorManager;
                    this.salaryMask;
                    this.salaryAfterDiscountMask;
        
                    this.init();

                    this.salaryMask = new IMask(this.getSalaryInput(), {
                        mask: Number,
                        scale: 2,
                        thousandsSeparator: ',',
                        padFractionalZeros: false,
                        normalizeZeros: true,
                        radix: ',',
                        mapToRadix: ['.'],
                        min: 0,
                        max: 999999999999,
                    });

                    this.salaryAfterDiscountMask = new IMask(this.getSalaryAfterDiscountInput(), {
                        mask: Number,
                        scale: 2,
                        thousandsSeparator: ',',
                        padFractionalZeros: false,
                        normalizeZeros: true,
                        radix: ',',
                        mapToRadix: ['.'],
                        min: 0,
                        max: 999999999999,
                    });
                }
        
                // Getter/Setter
        
                getContainer() {
                    return this.container;
                }
        
                getErrorManager() {
                    return this.errorManager;
                }
        
                getTool() {
                    return this.tool;
                }
        
                getName() {
                    let showName;
        
                    switch (this.name) {
                        case 'vietnam_teacher_minutes_per_section':
                            showName = "Giáo viên Việt Nam";
                            break;
                        case 'foreign_teacher_minutes_per_section':
                            showName = "Giáo viên nước ngoài";
                            break;
                        case 'tutor_minutes_per_section':
                            showName = "Gia sư";
                            break;
                        default:
                            showName = "Giáo viên Việt Nam";
                    }
        
                    return showName;
                }
        
                // Num of sections
                getNumOfSectionsInput() {
                    return this.container().querySelector('[data-control="num-of-sections"]');
                }
        
                getNumOfSectionsValue() {
                    return this.getNumOfSectionsInput().value;
                }
        
                setNumOfSectionsValue(num) {
                    this.getNumOfSectionsInput().value = num;
                }
        
                // Hours per section
                getHoursPerSectionInput() {
                    return this.container().querySelector('[data-control="hours-per-section"]');
                }
        
                getHoursPerSectionValue() {
                    return this.getHoursPerSectionInput().value;
                }
        
                setHoursPerSectionValue(hours) {
                    this.getHoursPerSectionInput().value = hours;
                }
        
                // Minutes per section
                getMinutesPerSectionInput() {
                    return this.container().querySelector('[data-control="minutes-per-section"]');
                }
        
                getMinutesPerSectionValue() {
                    return this.getMinutesPerSectionInput().value;
                }
        
                setMinutesPerSectionValue(minutes) {
                    this.getMinutesPerSectionInput().value = minutes;
                }
        
                // Salary
                getSalaryInput() {
                    return this.container().querySelector('[data-control="salary"]');
                }
        
                getSalaryValue() {
                    return this.getSalaryInput().value;
                }
        
                setSalaryValue(salary) {
                    this.getSalaryInput().value = isNaN(salary) ? 0 : salary;

                    this.salaryMask = new IMask(this.getSalaryInput(), {
                        mask: Number,
                        scale: 2,
                        thousandsSeparator: ',',
                        padFractionalZeros: false,
                        normalizeZeros: true,
                        radix: ',',
                        mapToRadix: ['.'],
                        min: 0,
                        max: 999999999999,
                    });
                }
        
                // Salary
                getSalaryAfterDiscountInput() {
                    return this.container().querySelector('[data-control="salary_after_discount"]');
                }
        
                getSalaryAfterDiscountValue() {
                    return this.getSalaryAfterDiscountInput().value;
                }
        
                setSalaryAfterDiscountValue(salary) {
                    this.getSalaryAfterDiscountInput().value = isNaN(salary) ? 0 : salary;

                    this.salaryAfterDiscountMask = new IMask(this.getSalaryAfterDiscountInput(), {
                        mask: Number,
                        scale: 2,
                        thousandsSeparator: ',',
                        padFractionalZeros: false,
                        normalizeZeros: true,
                        radix: ',',
                        mapToRadix: ['.'],
                        min: 0,
                        max: 999999999999,
                    });
                }
        
                // Save DB
                getTotalMinutesSaveDBInput() {
                    const name = this.name;
                    return this.container().querySelector(`[name="${name}"]`);
                }
        
                getTotalMinutesSaveDBValue() {
                    return this.getTotalMinutesSaveDBInput().value;
                }
        
                setTotalMinutesSaveDBInput(minutes) {
                    this.getTotalMinutesSaveDBInput().value = minutes;
                }
        
                // TOTAL
        
                // Hours
                getTotalHoursInput() {
                    return this.container().querySelector('[data-control="total-hours"]');
                }
        
                getTotalHoursValue() {
                    return this.getTotalHoursInput().value;
                }
        
                setTotalHoursValue(hours) {
                    this.getTotalHoursInput().value = hours;
                }
        
                // Minutes
                getTotalMinutesInput() {
                    return this.container().querySelector('[data-control="total-minutes"]');
                }
        
                getTotalMinutesValue() {
                    return this.getTotalMinutesInput().value;
                }
        
                setTotalMinutesValue(minutes) {
                    this.getTotalMinutesInput().value = minutes;
                }
        
                loadSavedData() {
                    const totalMinutes = this.getTotalMinutesSaveDBValue();
        
                    if (parseInt(totalMinutes) > 0) {
                        const totalHours = this.caculateTotalHoursFromMinutes(totalMinutes);
                        const remainMinutes = this.caculateRemainMinutesFromTotalMinutes(totalMinutes);
        
                        this.setHoursPerSectionValue(totalHours);
                        this.setMinutesPerSectionValue(remainMinutes);
                        
                        if (this.validateTimeInputs()) {
                            this.reload();
                        } else {
                            this.resetTotal();
                        }
                    }
                }
        
                init() {
                    this.loadSavedData();
                    // this.renderSalaryAfterDiscount();
                    this.events();
                }
        
                // Change num of sections
                changeNumOfSectionsHandle() {
                    if (this.validateTimeInputs()) {
                        this.reload();
                    } else {
                        this.resetTotal();
                    }
                    
                    this.getTool().renderSumSections();
                    this.getTool().renderSumTotalHours();
                    this.getTool().renderSumTotalMinutes();
                    this.getErrorManager().handle();
                }
        
                // Change hours per section
                changeHoursPerSectionHandle() {
                    if (this.validateTimeInputs()) {
                        this.reload();
                    } else {
                        this.resetTotal();
                    }
        
                    this.getTool().renderSumHoursPerSection();
                    this.getTool().renderSumTotalHours();
                    this.getTool().renderSumTotalMinutes();
                    this.getErrorManager().handle();
                }
        
                // Change minutes per section
                changeMinutesPerSectionHandle() {
                    if (this.validateTimeInputs()) {
                        this.reload();
                    } else {
                        this.resetTotal();
                    }
        
                    this.getTool().renderSumMinutesPerSection();
                    this.getTool().renderSumTotalHours();
                    this.getTool().renderSumTotalMinutes();
                    this.getErrorManager().handle();
                }  
        
                // Change salary
                changeSalaryHandle() {
                    if (this.validateSalaryInput()) {
                        this.getTool().renderSumSalary();
                        this.getTool().renderSumSalaryAfterDiscount();
                    }
        
                    this.getErrorManager().handle();
                    // this.renderSalaryAfterDiscount();
                }
        
                // renderSalaryAfterDiscount() {
                //     const salaryString = this.getSalaryValue().replace(/,/g, '');
                //     const salary = parseInt(salaryString, 10);
                //     const salaryAfterDiscount = parseInt(salary - (salary * (isNaN(discountPercent) ? 0 : discountPercent) / 100), 10);

                //     this.setSalaryAfterDiscountValue(salaryAfterDiscount);
                // }
        
                resetTotal() {
                    this.setTotalHoursValue('');
                    this.setTotalMinutesValue('');
                }
        
                // VALIDATE
        
                // Validate time inputs
                validateTimeInputs() {
                    let isValid = true;
                    const errorManager = this.getErrorManager();
                    const staffName = this.getName();
                    const numOfSections = this.getNumOfSectionsValue();
                    const hoursPerSection = this.getHoursPerSectionValue();
                    const minutesPerSection = this.getMinutesPerSectionValue();
                    
                    this.getErrorManager().reset();
        
                    if (numOfSections !== '') {
                        if (!numOfSections || isNaN(numOfSections)) {
                            isValid = false;
                            errorManager.addError(`Số buổi của ${staffName} không hợp lệ!`);
                        }
        
                        if (parseInt(numOfSections) < 0) {
                            isValid = false;
                            errorManager.addError(`Số buổi của ${staffName} không được bé hơn 0!`);
                        }
                    }
        
                    if (hoursPerSection !== "") {
                        if (!hoursPerSection || isNaN(hoursPerSection)) {
                            isValid = false;
                            errorManager.addError(`Số giờ mỗi buổi của ${staffName} không hợp lệ!`);
                        }
            
                        if (parseInt(hoursPerSection) < 0) {
                            isValid = false;
                            errorManager.addError(`Số giờ mỗi buổi của ${staffName} không được bé hơn 0!`);
                        }
            
                        if (parseInt(hoursPerSection) >= 24) {
                            isValid = false;
                            errorManager.addError(`Số giờ mỗi buổi của ${staffName} lớn hơn 24 giờ là không hợp lý, vui lòng nhập lại!`);
                        }
                    }
            
                    if (minutesPerSection !== "") {
                        if (parseInt(minutesPerSection) < 0) {
                            isValid = false;
                            errorManager.addError(`Số phút mỗi buổi của ${staffName} không được bé hơn 0!`);
                        }
        
                        if (!minutesPerSection || isNaN(minutesPerSection)) {
                            isValid = false;
                            errorManager.addError(`Số phút mỗi buổi của ${staffName} không hợp lệ!`);
                        }
                    }
        
                    if (parseInt(numOfSections) === 0 && 
                        parseInt(hoursPerSection) === 0 && 
                        parseInt(minutesPerSection) === 0) {
                        isValid = false;
                        errorManager.addError(`Cả 3 trường của ${staffName} không được cùng bằng 0!`);
                    }
        
                    // Check at least one of the two sides (sessions or hours/minutes) must be entered to render the total.
                    if (numOfSections === '' && (hoursPerSection !== '' || minutesPerSection !== '')) {
                        isValid = false;
                    }
        
                    if (numOfSections !== '' && (hoursPerSection === '' && minutesPerSection === '')) {
                        isValid = false;
                    }
        
                    return isValid;
                }
        
                // validate salary input
                validateSalaryInput() {
                    let isValid = true;
        
                    const salary = this.getSalaryValue();
                    const staffName = this.getName();
                    const errorManager = this.getErrorManager();
        
                    errorManager.reset();
        
                    if (salary !== "") {
                        if (!salary) {
                            isValid = false;
                            errorManager.addError(`Lương của ${staffName} không hợp lệ!`);
                        }
        
                        if (parseInt(salary) < 0) {
                            isValid = false;
                            errorManager.addError(`Lương của ${staffName} không được bé hơn 0!`);
                        }
                    }
        
                    return isValid;
                }
        
                // CACULATION
        
                // Caculate total minutes from hours, minutes per section & total sections
                caculateTotalMinutes(totalSections, hours, minutes) {
                    totalSections = !totalSections ? 1 : totalSections;
                    hours = !hours ? 0 : hours;
                    minutes = !minutes ? 0 : minutes;
        
                    return (parseFloat(hours) * 60 + parseFloat(minutes)) * parseFloat(totalSections);
                }
        
                // get hours from total minutes
                caculateTotalHoursFromMinutes(minutes) {
                    if (!minutes || parseInt(minutes) < 0) {
                        return 0;
                    }
        
                    return parseInt(parseInt(minutes) / 60);
                }
        
                // Caculate remain minutes
                caculateRemainMinutesFromTotalMinutes(minutes) {
                    if (!minutes || parseInt(minutes) < 0) {
                        return 0;
                    }
        
                    return parseInt(parseInt(minutes) % 60);
                }
        
                caculateTotalMinutesPerSection(hours, minutes) {
                    let total = 0;
        
                    if (!isNaN(parseInt(hours))) {
                        total += parseInt(hours) * 60;
                    }
        
                    if (!isNaN(parseInt(minutes))) {
                        total += parseInt(minutes);
                    }
        
                    return total;
                }
        
                reload() {
                    // Caculate & validate
                    const numOfSections = this.getNumOfSectionsValue();
                    const hoursPerSection = this.getHoursPerSectionValue();
                    const minutesPerSection = this.getMinutesPerSectionValue();
        
                    const totalMinutesPerSection = this.caculateTotalMinutesPerSection(hoursPerSection, minutesPerSection);
                    const minutes = this.caculateTotalMinutes(numOfSections, hoursPerSection, minutesPerSection);
                    const totalHours = this.caculateTotalHoursFromMinutes(minutes);
                    const remainMinutes = this.caculateRemainMinutesFromTotalMinutes(minutes);
        
                    this.setTotalMinutesSaveDBInput(totalMinutesPerSection);      
                    this.setTotalHoursValue(totalHours);
                    this.setTotalMinutesValue(remainMinutes);
                }
        
                // Assign a mask to the input field
                assignMasks() {
                    if (this.getSalaryInput()) {
                        this.salaryMask = new IMask(this.getSalaryInput(), {
                            mask: Number,
                            scale: 2,
                            thousandsSeparator: ',',
                            padFractionalZeros: false,
                            normalizeZeros: true,
                            radix: ',',
                            mapToRadix: ['.'],
                            min: 0,
                            max: 999999999999,
                        })
                    };
        
                    if (this.getSalaryAfterDiscountInput()) {
                        this.salaryAfterDiscountMask = new IMask(this.getSalaryAfterDiscountInput(), {
                            mask: Number,
                            scale: 2,
                            thousandsSeparator: ',',
                            padFractionalZeros: false,
                            normalizeZeros: true,
                            radix: ',',
                            mapToRadix: ['.'],
                            min: 0,
                            max: 999999999999,
                        });
                    };
                }

                focusInput(e) {
                    const value = e.target.value;

                    if (!value || parseFloat(value) === 0) {
                        e.target.value = '';
                        this.salaryMask.updateValue();
                    } else {
                        setTimeout(() => {
                            this.moveCaretToEnd(e.target);
                        }, 0);
                    }
                }

                blurInput(e) {
                    const value = e.target.value;

                    if (!value || parseFloat(value) === 0) {
                        e.target.value = 0;
                        this.salaryMask.updateValue('0');
                    }
                }

                moveCaretToEnd(el) {
                    if (typeof el.selectionStart == "number") {
                        el.selectionStart = el.selectionEnd = el.value.length;
                    } else if (typeof el.createTextRange != "undefined") {
                        el.focus();

                        var range = el.createTextRange();
                        
                        range.collapse(false);
                        range.select();
                    }
                }
        
                events() {
                    const _this = this;

                    $(_this.getNumOfSectionsInput()).on('change keyup', function() {
                        _this.changeNumOfSectionsHandle();
                    })
                    
                    $(_this.getHoursPerSectionInput()).on('change keyup', function() {
                        _this.changeHoursPerSectionHandle();
                    })
        
                    $(_this.getMinutesPerSectionInput()).on('change keyup', function() {
                        _this.changeMinutesPerSectionHandle();
                    })

                    $(_this.getNumOfSectionsInput()).on('focus', function(e) {
                        _this.focusInput(e);
                    })

                    $(_this.getNumOfSectionsInput()).on('blur', function(e) {
                        _this.blurInput(e);
                    })

                    $(_this.getHoursPerSectionInput()).on('focus', function(e) {
                        _this.focusInput(e);
                    })

                    $(_this.getHoursPerSectionInput()).on('blur', function(e) {
                        _this.blurInput(e);
                    })

                    $(_this.getMinutesPerSectionInput()).on('focus', function(e) {
                        _this.focusInput(e);
                    })

                    $(_this.getMinutesPerSectionInput()).on('blur', function(e) {
                        _this.blurInput(e);
                    })

                    $(_this.getSalaryInput()).on('change keyup', function(e) {
                        _this.changeSalaryHandle();

                        _this.salaryMask = new IMask(_this.getSalaryInput(), {
                            mask: Number,
                            scale: 2,
                            thousandsSeparator: ',',
                            padFractionalZeros: false,
                            normalizeZeros: true,
                            radix: ',',
                            mapToRadix: ['.'],
                            min: 0,
                            max: 999999999999,
                        })

                        _this.salaryMask = new IMask(_this.getSalaryAfterDiscountInput(), {
                            mask: Number,
                            scale: 2,
                            thousandsSeparator: ',',
                            padFractionalZeros: false,
                            normalizeZeros: true,
                            radix: ',',
                            mapToRadix: ['.'],
                            min: 0,
                            max: 999999999999,
                        })
                    })

                    // $(_this.getSalaryInput()).on('focus', function(e) {
                    //     _this.focusInput(e);
                    // })

                    // $(_this.getSalaryInput()).on('blur', function(e) {
                    //     _this.blurInput(e);
                    // })
                }
            }
        </script>
    </div>
    
    {{-- REVENUE SHARING FORM --}}
    @php
        $revenueFormUniqId = 'revenue_form_uniq_id_' . uniqid();
    @endphp

    {{-- Revenue sharing FORM --}}
    <div class="row d-none" data-form-include="{{ $revenueFormUniqId }}">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-8 mt-8">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 col-xs-12 mb-2">
                    <input type="checkbox" name="is_share" {{ isset($orderItem) && $orderItem->is_share ? 'checked' : '' }}>
                    <label class="fs-6 fw-semibold mb-2">Chia doanh thu</label>
                </div>
            </div>

            <div data-content="body">
                {{-- Load revenue form here --}}
            </div>
            <x-input-error :messages="$errors->get('custom_validate_revenue_distribution')" class="mt-2 text-center"/>
        </div>
    </div>


    {{-- Revenue sharing JS --}}
    <script>
        $(() => {
            new RevenueToolForm({
                container: () => {
                    return $('[data-form-include="{{ $revenueFormUniqId }}"]');
                }
            });

            setTimeout(() => {
                salaryManager = new SalaryManager({
                    container: () => {
                        return document.querySelector('#{{ $staffTimesManagerContainerUniqId }}');
                    },
                    staffTimesManager: new StaffTimesManager({
                        container: () => {
                            return document.querySelector('#{{ $trainOrderStaffTimesManagerUniqId }}')
                        }
                    }),
                })
            }, 1);
        })

        var RevenueToolForm = class {
            constructor(options) {
                this.container = options.container;
                
                this.toggle();
                this.load();
                this.events();
            }

            getCheckBox() {
                return this.container().find('[name="is_share"]');
            }

            getBody() {
                return this.container().find('[data-content="body"]');
            }

            load() {
                const data = {
                    _token: "{{ csrf_token() }}",
                    parentId: "{{ $createDemoOrderItemPopupUniqid }}",
                    defaultSaleId: 1,
                    totalPrice: "{{ isset($orderItem) ? $orderItem->getTotalPriceOfEdu() : '' }}",
                    revenueDistributions: "{{ isset($revenueData) ? $revenueData : json_encode( isset($orderItem) && $orderItem->revenueDistributions->count() > 0 ? $orderItem->revenueDistributions : \App\Helpers\RevenueDistribution::getRevenueDataWithDefault(1) ) }}",
                }

                $.ajax({
                    url: "{!! action([App\Http\Controllers\SaleRevenueController::class, 'getRevenueForm']) !!}",
                    method: "POST",
                    data: data
                }).done(res => {
                    this.container().find('[data-content="body"]').html(res);
                    initJs(this.container().find('[data-content="body"]')[0]);
                }).fail(res => {
                    throw {
                        info: "custom error alert",
                        file: "sales/orders/createExtraItem.blade.php",
                        message: "ajax fail, cannot get revenue form from server!",
                        originError: {
                            file: res.responseJSON.file,
                            line: res.responseJSON.line,
                            message: res.responseJSON.message,
                        }
                    }
                })
            }

            toggle() {
                const _this = this;

                if ($(_this.getCheckBox()).is(':checked')) {
                    _this.getBody().show();
                } else {
                    _this.getBody().hide();
                }
            }

            events() {
                const _this = this;

                this.getCheckBox().on('change keyup', function() {
                    _this.toggle();
                });
            }
        }
    </script>
</div>

{{-- TAFF TIMES MANAFER FORM --}}

<script>
    var salaryManager;

    var SalaryManager = class {
        constructor(options) {
            this.container = options.container;
            this.staffTimesManager = options.staffTimesManager;
            this.revenueDistribution = options.revenueDistribution;
            this.staffTimesManager.setParent(this);
            // this.revenueDistribution.setParent(this);
        }
    }
</script>
