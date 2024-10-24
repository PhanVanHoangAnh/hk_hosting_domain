<div data-control="module-role-select" class="mb-4">
    <label class="required fs-6 fw-semibold mb-2">Vai trò người dùng</label>
    <div data-control="content">

    </div>
    <div>
        <button type="button" data-control="add" class="btn btn-sm btn-light">
            <span class="d-flex align-items-center">
                <span class="material-symbols-rounded">
                    add
                </span>
                <span>Thêm vai trò</span>
            </span>
        </button>
    </div>
</div>
<script>
    $(function() {
        new ModuleRoleSelect({
            container: $('[data-control="module-role-select"]'),
            modules: {!! json_encode(App\Library\Module::getModuleRoleData()) !!},
            roles: {!! json_encode($user->roles->map(function($role) {return $role->id;})->toArray()) !!},
        });
    });

    var ModuleRoleSelect = class {
        constructor(options) {
            this.container = options.container;
            this.modules = options.modules;
            this.roles = options.roles;

            //
            if (!this.roles.length) {
                this.addRole(null);
            }

            //
            this.render();

            //
            this.events();
        }

        getAddButton() {
            return this.container.find('[data-control="add"]');
        }

        getContent() {
            return this.container.find('[data-control="content"]');
        }

        getModuleSelect() {
            return this.getContent().find('[data-control="module-select"]');
        }

        getModuleSelecttByIndex(index) {
            return this.getContent().find('[data-control="module-select"][data-index="'+index+'"]');
        }

        getRoleSelect() {
            return this.getContent().find('[data-control="role-select"]');
        }

        getRoleSelectByIndex(index) {
            return this.getContent().find('[data-control="role-select"][data-index="'+index+'"]');
        }

        getRemoveButton() {
            return this.getContent().find('[data-control="remove"]');
        }

        events() {
            var _this = this;

            // change module
            this.getAddButton().on('click', function(e) {
                e.preventDefault();

                _this.addRole(null);
            });
        }

        addRole(roleId) {
            this.roles.push(roleId);

            this.render();
        }

        render() {
            this.getContent().html('');

            this.roles.forEach((role, index) => {
                var moduleOptions = '';
                var deleteCol;

                // delete
                deleteCol = `
                    <div class="col-md-2">
                        <button type="button" data-control="remove" data-index="`+index+`" class="btn btn-sm btn-light">
                            <span class="d-flex align-items-center">
                                <span class="material-symbols-rounded">
                                    delete
                                </span>
                                <span>Xóa</span>
                            </span>
                        </button>
                    </div>
                `;

                this.modules.forEach(module => {
                    moduleOptions += `
                        <option value="`+module.name+`">`+module.label+`</option>
                    `;
                });

                this.getContent().append(`
                    <div class="row">
                        <div class="col-md-5">
                            <!--begin::Input group-->
                            <div class="mb-7">
                                <select data-control="module-select" data-index="`+index+`" name="modules[`+index+`]" class="form-select filter-select @if ($errors->has('module')) is-invalid @endif" data-control="select2"
                                    data-close-on-select="false" data-placeholder="Chọn phân hệ" data-allow-clear="true" required
                                    >
                                        <option value="">Chọn phân hệ</option>
                                        ` +moduleOptions+ `
                                </select>
                                <x-input-error :messages="$errors->get('module')" class="mt-2" />
                            </div>
                            <!--end::Input group-->
                        </div>
                        <div class="col-md-5">
                            <!--begin::Input group-->
                            <div class="mb-7">
                                <select data-control="role-select" data-index="`+index+`" name="roles[`+index+`]" class="form-select filter-select @if ($errors->has('role_id')) is-invalid @endif" data-control="select2"
                                    data-close-on-select="false" data-placeholder="Chọn vai trò" data-allow-clear="true" required
                                    >

                                </select>
                                <x-input-error :messages="$errors->get('account_group_id')" class="mt-2" />
                            </div>
                            <!--end::Input group-->
                        </div>
                        `+deleteCol+`
                    </div>
                `);

                // select value
                var moduleName = this.getModuleNameByRole(role);
                this.getModuleSelecttByIndex(index).val(moduleName);
                this.selectModule(index, moduleName);
            });

            this.afterRenderEvents();
        }

        getModuleNameByRole(roleId)
        {
            if (!roleId) {
                return null;
            }

            var moduleName;
            this.modules.forEach(module => {
                module.roles.forEach(role => {
                    if (role.id == roleId) {
                        moduleName = module.name;
                    }
                });
            });

            return moduleName;
        }

        afterRenderEvents() {
            var _this = this;

            // change module
            this.getModuleSelect().on('change', function() {
                var index = $(this).attr('data-index');

                _this.selectModule(index, $(this).val());

                _this.update(index);
            });

            // change role
            this.getRoleSelect().on('change', function() {
                var index = $(this).attr('data-index');

                _this.update(index);
            });

            // remove role
            this.getRemoveButton().on('click', function() {
                var index = $(this).attr('data-index');

                _this.remove(index);
            });
        }

        getRoles(moduleName) {
            var roles;
            this.modules.forEach(module => {
                if (module.name == moduleName) {
                    roles = module.roles;
                    return;
                }
            });

            return roles;
        }

        selectModule(index, moduleName) {
            var _this = this;

            // remove all options
            _this.getRoleSelectByIndex(index).find('option').remove();

            if (!moduleName) {
                return;
            }

            var roles = this.getRoles(moduleName);

            // insert select
            roles.forEach(function(role) {
                _this.getRoleSelectByIndex(index).append($('<option>', {
                    value: role.id,
                    text: role.name,
                    selected: role.id == _this.roles[index],
                }));
            });
        }

        update(index) {
            var _this = this;
            var role = _this.getRoleSelectByIndex(index).val();

            this.roles[index] = role;
        }

        remove(index) {
            this.roles.splice(index, 1);

            if (this.roles.length == 0) {
                this.addRole(null);
            }

            this.render();
        }
    }
</script>
