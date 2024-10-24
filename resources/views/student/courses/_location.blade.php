@php
    $createCourseLocationUniqId = 'F' . uniqid();
@endphp

<div class="row" id="createCourseLocationUniqId_{{ $createCourseLocationUniqId }}">
    <div class="col-4 mb-4">
        <div class="form-outline">
            <label class="fs-6 fw-semibold mb-2" for="branch-select">Chọn chi nhánh</label>
            <select id="branch-select" class="form-select form-control" data-control="select2"
                data-dropdown-parent="#createCourseLocationUniqId_{{ $createCourseLocationUniqId }}"
                data-placeholder="Chọn chi nhánh đào tạo" name="branch">
                <option value="">Chọn chi nhánh</option>
                @foreach (App\Models\TrainingLocation::getBranchs() as $item)
                    <option value="{{ $item }}"
                        @php
                            $selected = '';

                            if (isset($branch) && $branch == $item) {
                                $selected = 'selected';
                            } else {
                                if (isset($course->training_location_id)) {
                                    if (\App\Models\TrainingLocation::find($course->training_location_id)) {
                                        $branch = \App\Models\TrainingLocation::find($course->training_location_id)->branch;
        
                                        if (isset($branch) && $item == $branch) {
                                            $selected = 'selected';
                                        } else {
                                            $selected = '';
                                        }
                                    }
                                } elseif(isset($courseCopy->training_location_id)) {
                                    if (\App\Models\TrainingLocation::find($courseCopy->training_location_id)) {
                                        $branch = \App\Models\TrainingLocation::find($courseCopy->training_location_id)->branch;
        
                                        if (isset($branch) && $item == $branch) {
                                            $selected = 'selected';
                                        } else {
                                            $selected = '';
                                        }
                                    }
                                }
                            }

                        @endphp
                        {{ $selected }}>
                        {{ trans('messages.training_location.' . $item) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-4 mb-4">
        <div class="form-outline">
            <label class="fs-6 fw-semibold required mb-2" for="location-select">Chọn địa điểm đào tạo</label>
            <select id="location-select" class="form-select form-control" name="training_location_id"
                data-dropdown-parent="#createCourseLocationUniqId_{{ $createCourseLocationUniqId }}"
                data-control="select2" data-placeholder="Chọn địa điểm đào tạo">
            </select>
        </div>
        <x-input-error :messages="$errors->get('training_location_id')" class="mt-2" />
    </div>

    <div class="col-4 mb-4">
        <div class="form-outline">
            <label class="fs-6 fw-semibold mb-2" for="class-room-select">Nhập phòng học</label>
            <input type="text" class="form-control" name="class_room" placeholder="Nhập lớp học" value="{{ isset($course->class_room) ? $course->class_room : (isset($courseCopy->class_room) ? $courseCopy->class_room : '' ) }}">
        </div>
        <x-input-error :messages="$errors->get('class_room')" class="mt-2" />
    </div>
</div>

<script>
    var TrainingLocationHandle = class {
        constructor(options) {
            this.container = document.querySelector('#createCourseLocationUniqId_{{ $createCourseLocationUniqId }}');

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

        // Prevent user from change the branch value
        keepCurrentBranchValue() {
            const _this = this;

            if (_this.getBranchSelector()) {
                _this.getBranchSelector().disabled = true;
            }
        }

        // Allow user to change the branch value
        freeSelectBranch() {
            const _this = this;

            if (_this.getBranchSelector()) {
                _this.getBranchSelector().disabled = false;
            }
        }

        // Location
        getLocationSelector() {
            return this.getContainer().querySelector('[name="training_location_id"]');
        }

        // Location value selected
        getLocation() {
            return this.getLocationSelector().value;
        }

        /**
         * Change the branch
         * @return void
         */
        changeBranch() {
            this.queryLocations();

            const branch = this.getBranch();

            if (branch) {
                let area;
    
                switch(branch) {
                    case 'HN': 
                        area = 'HN';
                        break;
                    case 'SG':
                        area = 'SG';
                        break;
                    default:
                        area = -1;
                        break;
                }

                if (area == -1) {
                    throw new Error('Bug: Invalid area');
                }

                let url = "{{ action([App\Http\Controllers\Student\StaffController::class, 'getHomeRoomByArea'], ['area' => 'PLACEHOLDER']) }}";
                const updatedUrl = url.replace('PLACEHOLDER', area);

                $.ajax({
                    url: updatedUrl,
                }).done(response => {
                    addCourseManager.setHomeRoomOptions(response.homeRooms);
                    addCourseManager.showHomeRoomForm(); // Show
                }).fail(response => {
                    throw new Error('Get homerooms fail')
                })
            }
        }

        getLocationSelectedId() {
            const id = "{{ isset($course->training_location_id) ? $course->training_location_id : (isset($courseCopy->training_location_id) ? $courseCopy->training_location_id : '') }}";

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
            
            if (branch) {
                (() => {
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
                })()
            }
        }

        init() {
            this.queryLocations();
            this.events();
        }

        events() {
            const _this = this;

            $(_this.getBranchSelector()).on('change', function(e) {
                e.preventDefault();
                _this.changeBranch();
            })
        }
    }
</script>