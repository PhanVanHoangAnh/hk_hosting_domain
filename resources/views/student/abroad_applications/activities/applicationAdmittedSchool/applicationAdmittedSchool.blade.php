
<div class="row">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">5</span>
            </div>
            <div class="fw-semibold">
                Kết quả chọn trường 
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="">

            <!--begin::Card body-->
            <form id="tableApplicationAdmittedSchool" tabindex="-1">
                @csrf
                <div class="table-responsive">
                    @if(!$applicationAdmittedSchools->isEmpty())
                    <table class="table align-middle table-row-dashed fs-6 gy-5 border" id="dtHorizontalVerticalOrder">
                        <thead>
                            <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                                <th class="min-w-125px text-left">
                                    <span class="d-flex align-items-center">
                                        <span>
                                            Trường đỗ
                                        </span>
                                    </span>
                                </th>
                                <th class="min-w-125px text-left">
                                    <span class="d-flex align-items-center">
                                        <span>
                                            Học bổng
                                        </span>
                                    </span>
                                </th>
                                
                                {{-- <th class="min-w-125px text-left">
                                    <span class="d-flex align-items-center">
                                        <span>
                                            Theo học
                                        </span>
                                    </span>
                                </th>
                                <th class="min-w-125px text-left">
                                    <span class="d-flex align-items-center">
                                        <span>
                                            Thao tác
                                        </span>
                                    </span>
                                </th> --}}
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @foreach ($applicationAdmittedSchools as $applicationAdmittedSchool)
                            <tr>
                                <td class="text-left mb-1 text-nowrap">
                                    {{$applicationAdmittedSchool->school->name}}
                                </td>
                                
                                <td class="text-left mb-1 text-nowrap">
                                    {{number_format($applicationAdmittedSchool->scholarship, 0, '.', ',') . 'đ'}}
                                    
                                </td>

                                {{-- <td  list-control="school-selected-edit"
                                    data-url="{{ action('\App\Http\Controllers\Student\AbroadController@saveSchoolSelected', [
                                        'id' => $applicationAdmittedSchool->id,
                                    ]) }}"
                                    class="text-nowrap">
                                    <div>
                                        <div>
                                            <span inline-control="data">
                                                @if ($applicationAdmittedSchool->selected == 1)
                                                    Có
                                                @else
                                                    <span class="text-gray-500">Không</span>
                                                @endif
                                            
                                            </span>
                                            <a href="javascript:;" inline-control="edit-button">
                                                <span class="material-symbols-rounded fs-6 inline-edit-button">
                                                    edit
                                                </span>
                                            </a>
                                            <div inline-control="form" style="display:none;">
                                                <div class="d-flex align-items-center">
                                                    <select inline-control="input" class="form-select"
                                                        data-control="select2" data-placeholder="Select an option">
                                                        <option value="">Chưa chọn trường</option>
                                                        <option value="1">Có</option>
                                                        <option value="0">Không</option>
                                                    </select>
                                                    <button inline-control="close" type="button"
                                                        class="btn btn-icon">
                                                        <span class="material-symbols-rounded">
                                                            close
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="min-w-125px text-left">
                                    <div class="col-md-3 ps-0 d-flex justify-content-start align-items-center">
                                        <a row-action="update-application-admitted-school" class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                        href="{{ action(
                                            [App\Http\Controllers\Student\AbroadController::class, 'editApplicationAdmittedSchool'],
                                            [
                                                'id' => $applicationAdmittedSchool->id,
                                            ],
                                        ) }}">Chỉnh sửa</a>
                                    </div>
                                </td> --}}
                                
                                
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @endif
                        
                        
                        <!--end::Table-->
                        
                    {{-- <div class="d-flex justify-content-end align-items-center mt-3">
                        <!--begin::Button-->
                        <a href="{{ action(
                            [App\Http\Controllers\Student\AbroadController::class, 'createApplicationAdmittedSchool'],
                            [
                                'id' => $abroadApplication->id,
                            ],
                        ) }}"
                            class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px" row-action="create-application-admitted-school">
                            <span class="material-symbols-rounded me-2">
                                add
                            </span>
                            Thêm mới 
                        </a>
                        <!--end::Button-->
                    </div> --}}
                
                </div>

            </form>
            <!--end::Card body-->
        </div>
        <!--end::details View-->
    
    </div>
</div>  


<script>
    $(() => {
        ApplicationFee.init();
        //Update node-log
        UpdatePopup.init();

        EditInline.init();
    });
    var EditInline = function() {
        return {
            init: function() {
                // salesperson inline edit
                document.querySelectorAll('[list-control="school-selected-edit"]').forEach(control => {
                    var url = control.getAttribute('data-url');
                    var salespersonInlineEdit = new SchoolSelectedInlineEdit({
                        container: control,
                        url: url,
                    });
                });

                
            }
        };
    }();
    var SchoolSelectedInlineEdit = class {
        constructor(options) {
            this.container = options.container;
            this.saveUrl = options.url;

            //
            this.events();
        }

        getEditButtonSchoolSelected() {
            return this.container.querySelector('[inline-control="edit-button"]');
        }

        showFormBoxSchoolSelected() {
            this.getFormBoxSchoolSelected().style.display = 'inline-block';
        }

        hideFormBoxSchoolSelected() {
            this.getFormBoxSchoolSelected().style.display = 'none';
        }

        getFormBoxSchoolSelected() {
            return this.container.querySelector('[inline-control="form"]');
        }

        getDataContainerSchoolSelected() {
            return this.container.querySelector('[inline-control="data"]')
        }

        hideDataContainerSchoolSelected() {
            this.getDataContainerSchoolSelected().style.display = 'none';
        }

        showDataContainerSchoolSelected() {
            this.getDataContainerSchoolSelected().style.display = 'inline-block';
        }

        updateSchoolSelected(selected) {
            this.getDataContainerSchoolSelected().innerHTML = selected;
        }

        getInputControlSchoolSelected() {
            return this.container.querySelector('[inline-control="input"]');
        }

        getSchoolSelected() {
            return this.getInputControlSchoolSelected().value;
        }

        hideEditButtonSchoolSelected() {
            this.getEditButtonSchoolSelected().style.display = 'none';
        }

        showEditButtonSchoolSelected() {
            this.getEditButtonSchoolSelected().style.display = 'inline-block';
        }

        getCloseButtonSchoolSelected() {
            return this.container.querySelector('[ inline-control="close"]');
        }

        save(afterSave) {
            var _this = this;
            // const that = this;
            $.ajax({
                method: 'POST',
                url: this.saveUrl,
                data: {
                    _token: "{{ csrf_token() }}",
                    selected: this.getSchoolSelected(),
                },
            }).done(function(response) {
                _this.updateSchoolSelected(response.selected);

                // afterSave
                if (typeof(afterSave) !== 'undefined') {
                    afterSave();
                }
            }).fail(function() {

            });
        }

        setEditModeSchoolSelected() {
            this.showFormBoxSchoolSelected();
            this.hideDataContainerSchoolSelected();
            this.hideEditButtonSchoolSelected();
        }

        closeEditModeSchoolSelected() {
            this.hideFormBoxSchoolSelected();
            this.showDataContainerSchoolSelected();
            this.showEditButtonSchoolSelected();
        }

        events() {
            var _this = this;

            //click
            this.getEditButtonSchoolSelected().addEventListener('click', (e) => {
                this.setEditModeSchoolSelected();
            })

            // close
            this.getCloseButtonSchoolSelected().addEventListener('click', (e) => {
                this.closeEditModeSchoolSelected();
            });

            // Click để lưu thay đổi
            $(this.getInputControlSchoolSelected()).on('change', (e) => {
                this.save(function() {
                    //
                    ASTool.alert({
                        message: 'Đã cập nhật trường theo học thành công!',
                        ok: function() {
                            // close box
                            _this.closeEditModeSchoolSelected();
                        }
                    });

                    // reload Sidebar
                    applicationAdmittedSchool.load();
                });
            });
        }
    };


    var UpdatePopup = (function() {
        var updatePopup;

        return {
            init: function() {
                updatePopup = new Popup();
            },
            updateUrl: function(newUrl) {
                updatePopup.url = newUrl;
                updatePopup.load();
            },
            getUpdatePopup: function() {
                return updatePopup;
            }
        };
    })();

    var ApplicationFee = (function() {
        var listContent;

        function getUpdateBtn() {
            return document.querySelectorAll('[row-action="update-application-admitted-school"]');
        }

        function getCreateBtn() {
            return document.querySelectorAll('[row-action="create-application-admitted-school"]');
        }

        return {
            init: function() {
                listContent = document.querySelector('#tableApplicationAdmittedSchool');
                if (listContent) {
                    getUpdateBtn().forEach(function(btn) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            var btnUrl = btn.getAttribute('href');
                            UpdatePopup.updateUrl(btnUrl);
                        });
                    });
                    getCreateBtn().forEach(function(btn) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            var btnUrl = btn.getAttribute('href');
                            UpdatePopup.updateUrl(btnUrl);
                        });
                    });
                } else {
                    throw new Error("listContent is undefined or null.");
                }
            }
        };
    })();
</script>