@php
    $trainOrderLocationUniqId = 'F' . uniqid();
@endphp

<div class="col-12" id="trainOrderLocationUniqId_{{ $trainOrderLocationUniqId }}">
    <div class="row">
        <div class="col-6 mb-4">
            <div class="form-outline">
                <label class="fs-6 fw-semibold mb-2" for="branch-select">Chọn chi nhánh</label>
                <select id="branch-select" class="form-select form-control" data-control="select2"
                    data-dropdown-parent="#trainOrderLocationUniqId_{{ $trainOrderLocationUniqId }}"
                    data-placeholder="Chọn chi nhánh đào tạo">
                    <option value="">Chọn chi nhánh</option>
                    @foreach (App\Models\TrainingLocation::getBranchs() as $branch)
                        <option value="{{ $branch }}"
                            {{ isset($orderItem->training_location_id) &&
                            $orderItem->getLocationBranch() === $branch
                                ? 'selected'
                                : '' }}>
                            {{ trans('messages.training_location.' . $branch) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-6 mb-4">
            <div class="form-outline">
                <label class="fs-6 fw-semibold required mb-2" for="location-select">Chọn địa điểm đào tạo</label>
                <select id="location-select" class="form-select form-control" name="training_location_id"
                    data-dropdown-parent="#trainOrderLocationUniqId_{{ $trainOrderLocationUniqId }}"
                    data-control="select2" data-placeholder="Chọn địa điểm đào tạo">
                </select>
            </div>
            <x-input-error :messages="$errors->get('training_location_id')" class="mt-2" />
        </div>
    </div>
</div>

<script>
    $(() => {
        trainingLocationHandle = new TrainingLocationHandle({
            container: document.querySelector('#trainOrderLocationUniqId_{{ $trainOrderLocationUniqId }}')
        })
    })

    var TrainingLocationHandle = class {
        constructor(options) {
            this.container = options.container;

            this.init();
        }

        getContainer() {
            return this.container;
        }

        // Branch
        getBranchSelector() {
            return this.getContainer().querySelector('#branch-select');
        }

        // Branch value selected
        getBranch() {
            return this.getBranchSelector().value;
        }

        // Location
        getLocationSelector() {
            return this.getContainer().querySelector('[name="training_location_id"]');
        }

        // Location value selected
        getLocation() {
            return this.getLocationSelector().value;
        }

        changeBranch() {
            this.queryLocations();
        }

        getLocationSelectedId() {
            const id = "{{ isset($orderItem->training_location_id) ? $orderItem->training_location_id : '' }}";

            return id;
        }

        createLocationsOptions(locations) {
            let options = '<option value="">Chọn</option>';
            const locationSelectedId = this.getLocationSelectedId();
            let selected = '';

            locations.forEach(i => {
                const id = i.id;
                const name = i.name;

                if (parseInt(i.id) === parseInt(locationSelectedId)) {
                    selected = 'selected';
                } else {
                    selected = '';
                }

                options += `<option value="${id}" ${selected}>${name}</option> `;
            })

            return options;
        }

        // Call ajax to get all locations froms server
        queryLocations() {
            const _this = this;
            const branch = this.getBranch();
            const url = "{!! action([App\Http\Controllers\TrainingLocationController::class, 'getTrainingLocationsByBranch'],['branch' => 'PLACEHOLDER'],) !!}";
            const updateUrl = url.replace('PLACEHOLDER', branch);

            $.ajax({
                url: updateUrl,
                method: 'get'
            }).done(response => {
                const options = _this.createLocationsOptions(response);

                _this.getLocationSelector().innerHTML = options;
            }).fail(response => {
                throw new Error(response.message);
            })
        }

        init() {
            this.events();
        }

        events() {
            const _this = this;

            // Remove events before add event handle
            _this.getBranchSelector().outerHTML = _this.getBranchSelector().outerHTML;

            $(_this.getBranchSelector()).on('change', function(e) {
                e.preventDefault();
                _this.changeBranch();
            })
        }
    }
</script>