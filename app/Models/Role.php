<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Validator;

class Role extends Model
{
    use HasFactory;

    public const ALIAS_MARKETING_STAFF = 'marketing';
    public const ALIAS_MARKETING_REPORTER = 'marketing.reporter'; 
    public const ALIAS_MARKETING_SUPERVISOR = 'marketing.supervisor'; 
    public const ALIAS_MARKETING_LEADER = 'marketing.leader';       //Trưởng nhóm
    public const ALIAS_MARKETING_MANAGER = 'marketing.manager';     //Quản lý bộ phận

    
    public const ALIAS_SALESPERSON = 'salesperson';
    public const ALIAS_SALES_LEADER = 'sales.leader';       //Trưởng nhóm
    public const ALIAS_SALES_MANAGER = 'sales.manager';     //Quản lý bộ phận
    public const ALIAS_SALES_MENTOR = 'sales.mentor';
    public const ALIAS_SALES_MANAGER_HN = 'sales.manager.hn';  //Quản lý chi nhánh HN
    public const ALIAS_SALES_MANAGER_SG = 'sales.manager.sg';  //Quản lý chi nhánh SG


    public const ALIAS_ACCOUNTANT = 'accountant';       //Nhân viên
    public const ALIAS_ACCOUNTANT_MANAGER = 'accountant.manager';   //Quản lý bộ phận
    public const ALIAS_ACCOUNTANT_MANAGER_HN = 'accountant.manager.hn';  //Quản lý chi nhánh HN
    public const ALIAS_ACCOUNTANT_MANAGER_SG = 'accountant.manager.sg';  //Quản lý chi nhánh SG

    public const ALIAS_EDU_STAFF = 'edu.staff';             //Nhân viên
    public const ALIAS_EDU_LEADER_GROUP = 'edu.leader.group';       //Trưởng nhóm
    public const ALIAS_EDU_LEADER = 'edu.leader';       //Trưởng phòng
    public const ALIAS_EDU_MANAGER = 'edu.manager';     //Quản lý bộ phận
    public const ALIAS_EDU_DIRECTOR = 'edu.director';       //Giám đốc đào tạo
    public const ALIAS_EDU_MANAGER_HN = 'edu.manager.hn';  //Quản lý chi nhánh HN
    public const ALIAS_EDU_MANAGER_SG = 'edu.manager.sg';  //Quản lý chi nhánh SG

    public const ALIAS_ABROAD_STAFF = 'abroad.staff';       //Nhân viên
    public const ALIAS_ABROAD_LEADER = 'abroad.leader';              //Trưởng nhóm
    public const ALIAS_ABROAD_MANAGER = 'abroad.manager';            //Quản lý bộ phận
    public const ALIAS_ABROAD_MANAGER_HN = 'abroad.manager.hn';  //Quản lý chi nhánh HN
    public const ALIAS_ABROAD_MANAGER_SG = 'abroad.manager.sg';  //Quản lý chi nhánh SG

    public const ALIAS_EXTRACURRICULAR_STAFF = 'extracurricular.staff';         //Nhân viên
    public const ALIAS_EXTRACURRICULAR_LEADER = 'extracurricular.leader';       //Quản lý bộ phận
    public const ALIAS_EXTRACURRICULAR_MANAGER = 'extracurricular.manager';     //Trưởng nhóm
    public const ALIAS_EXTRACURRICULAR_ADMIN = 'extracurricular.admin';  
    public const ALIAS_EXTRACURRICULAR_MANAGER_HN = 'extracurricular.manager.hn';  //Quản lý chi nhánh HN
    public const ALIAS_EXTRACURRICULAR_MANAGER_SG = 'extracurricular.manager.sg';  //Quản lý chi nhánh SG

    public const ALIAS_SYSTEM_MANAGER = 'system.manager';                       //Quản trị viên

    public const ALIAS_STUDENT = 'student';

    public const ALIAS_TEACHER = 'teacher';
    public const ALIAS_ABROAD_TEACHER = 'teacher.abroad';
    public const ALIAS_VN_TEACHER = 'teacher.vn';
    public const ALIAS_TUTOR = 'teacher.tutor';
    public const ALIAS_ASSISTANT = 'teacher.assistant';
    public const ALIAS_KID_ASSISTANT = 'teacher.kid_assistant';
    public const ALIAS_HOMEROOM_TEACHER = 'teacher.homeroom';

    public const ALIAS_TEACHING_ASSISTANT = 'teaching_assistant';       

    public const ALIAS_DIRECTOR_BRANCH = 'director.branch';                     //Giám đốc chi nhánh
    public const ALIAS_DIRECTOR_ALL = 'director.all';                           //Giám đốc

    protected $fillable = ['name', 'module', 'alias'];

    public function scopeSearch($query, $keyword)
    {
        return $query->where('name', 'LIKE', "%{$keyword}%");
    }
    
    public static function newDefault()
    {
        $role = new self();
        return $role;
    }

    public function saveFromRequest($request)
    {
        $this->fill($request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->save();
        $this->rolePermissions()->delete();

        // Retrieve role permissions from the request
        $rolePermissions = $request->input('role_permission', []);
   
        // Add new role permissions
        foreach ($rolePermissions as $permission) {
            $this->addPermission($permission);
        }

        // save
        
        return $validator->errors();
    }

    public function accounts()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function rolePermissions(): HasMany
    {
        return $this->hasMany(RolePermission::class);
    }

    public function hasPermission($action)
    {
        return $this->rolePermissions()
            ->byPermission($action)->exists();
    }

    public function getPermission($action)
    {
        return $this->rolePermissions()
            ->byPermission($action)->first();
    }

    public function addPermission($action)
    {
        // The role have already had the permission. Just return the permission
        if ($this->hasPermission($action)) {
            return $this->getPermission($action);
        }

        // add permission
        $rolePermission = new RolePermission();
        $rolePermission->permission = $action;
        $rolePermission->role_id = $this->id;
        $rolePermission->save();

        return $rolePermission;
    }

    public static function scopeByModule($query, $module)
    {
        $query->where('module', $module);
    }

    public static function addRole($module, $alias, $name)
    {
        $role = self::firstOrCreate(
            // Attributes to search for
            [
                'module' => $module,
                'alias' => $alias,
            ],
            // Attributes to set if not found
            [
                'name' => $name,
            ]
        );

        return $role;
    }
}