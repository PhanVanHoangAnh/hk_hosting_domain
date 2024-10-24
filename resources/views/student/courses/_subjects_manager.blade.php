<div class="col-lg-6 col-xl-3 col-md-6 col-sm-12 col-12 mb-4">
    <div class="form-outline">
        <label class="required fs-6 fw-semibold mb-2">Loại đào tạo</label>
        <select class="form-select form-control {{ $action === 'edit' && $course->hasFinished() ? 'pe-none bg-secondary' : '' }}" name="type" data-action="type-select"
            data-control="select2" placeholder="Chọn loại đào tạo..." >
            <option value="">Chọn</option>    
        </select>   
        <x-input-error :messages="$errors->get('type')" class="mt-2"/>
    </div>
</div>
<div class="col-lg-6 col-xl-3 col-md-6 col-sm-12 col-12 mb-4">
    <div class="form-outline" data-container="subject-select">
        <label class="required fs-6 fw-semibold mb-2">Môn học</label>
        <select class="form-select form-control {{ $action === 'edit' && $course->hasFinished() ? 'pe-none bg-secondary' : '' }}" data-action="subject-select"
            data-control="select2" name="subject_id" data-placeholder="Chọn môn học...">
            <option value="">Chọn</option>
        </select>
        <x-input-error :messages="$errors->get('subject_id')" class="mt-2"/>
        
        <script>
            $(() => {
                subjectSelector = new SubjectSelector({
                    container: () => {
                        return $('[data-container="subject-select"]');
                    }
                });
            })
        </script>
    </div>

</div>

<script>
    /**
     * Quản lý việc show ra các môn học ứng với từng loại đào tạo mỗi khi người dùng 
     * thay đổi loại đào tạo
     */
    var SubjectsManager = class {
        subjects = {!! json_encode(App\Models\Subject::all()) !!};

        constructor(options) {
            this.container = options.container;
            this.allowLoadTypes = true;

            this.init();
        };

        getContainer() {
            return this.container;
        };

        setAllowLoadTypes(isAllow) {
            this.allowLoadTypes = isAllow;
        };

        getAllowLoadTypes() {
            return this.allowLoadTypes;
        };

        getSubjects() {
            return this.subjects;
        };

        getTypes() {
            const types = [];

            this.getSubjects().forEach(subject => {
                if (!types.includes(subject.type)) {
                    types.push(subject.type);
                }
            });

            return types;
        };

        getSubjectsByType(type) {
            const subjects = [];

            this.getSubjects().forEach(subject => {
                if (subject.type === type) {
                    subjects.push(subject);
                };
            });

            return subjects;
        };

        getSubjectById(id) {
            if (!id) {
                return null;
            };

            let subjectResult = null;
            
            this.getSubjects().forEach(subject => {
                if (parseInt(id) === parseInt(subject.id)) {
                    subjectResult = subject;
                };
            });

            return subjectResult;
        };

        loadTypeOptions(selectedType) {
            let optionsString = `<option value="">Chọn loại đào tạo</option>`;
            
            if (!selectedType) {
                this.getTypes().forEach(type => {
                    const newOption = `<option value="${type}">${type}</option>`;
    
                    optionsString += newOption;
                });
            } else {
                let selected = '';

                this.getTypes().forEach(type => {
                    if (selectedType === type) {
                        selected = 'selected';  
                    } else {
                        selected = '';
                    }

                    const newOption = `<option value="${type}" ${selected}>${type}</option>`;
    
                    optionsString += newOption;

                    return new Promise((resolve, reject) => {
                        this.getTypeSelect().innerHTML = optionsString;
                        resolve();
                    });
                });
            }

            this.getTypeSelect().innerHTML = optionsString;

        };

        loadSubjectOptionsByType(type, selectedSubject) {
            $.ajax({
                url: "{{ action([App\Http\Controllers\SubjectController::class, 'getSubjectsByType']) }}",
                method: 'POST',
                data: {
                    type: type,
                    selectedId: selectedSubject ? selectedSubject.id : null,
                    _token: "{{ csrf_token() }}"
                }
            }).done(response => {
                this.getSubjectSelect().innerHTML = response;
                subjectSelector.changeSubject();
            }).fail(response => {
                throw new Error('Load subjects by type fails!');
            })
        };

        getTypeSelect() {
            return this.getContainer().querySelector('[data-action="type-select"]');
        };

        getSubjectSelect() {
            return this.getContainer().querySelector('[data-action="subject-select"]');
        };

        keepCurrentTypeValue() {
            const _this = this;

            if (_this.getTypeSelect()) {
                _this.getTypeSelect().disabled = true;
            }
        }

        keepCurrentSubjectValue() {
            const _this = this;

            if (_this.getSubjectSelect()) {
                _this.getSubjectSelect().disabled = true;
            }
        }

        freeSelectType() {
            const _this = this;

            if (_this.getTypeSelect()) {
                _this.getTypeSelect().disabled = false;
            }
        }

        freeSelectSubject() {
            const _this = this;

            if (_this.getSubjectSelect()) {
                _this.getSubjectSelect().disabled = false;
            }
        }

        init() {
            this.loadTypeOptions();
            this.events();
        };

        selectTypeHande(type) {
            if (this.getAllowLoadTypes()) {
                this.loadSubjectOptionsByType(type);
            };
        };

        events() {
            const _this = this;

            $(_this.getTypeSelect()).on('change', function(e) {
                e.preventDefault();
                _this.selectTypeHande(this.value);
            });
        };
    };
</script>