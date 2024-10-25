<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Notifications\Notification;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',
        'password',
        'selected_branch'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The roles that belong to the user.
     */
    public const STATUS_ACTIVE = 'active';
    public const STATUS_OUT_OF_JOB = 'out_of_job';

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
    public function mentees()
    {
        return $this->hasMany(User::class, 'mentor_id');
    }
    public function getAccountsIncludingMentees()
    {
        $menteeAccounts = $this->mentees->map(function ($mentee) {
            return $mentee->account;
        });
        $menteeAccounts->push($this->account);

        return $menteeAccounts;
    }
    public function hasPermission($permission)
    {
        return RolePermission::whereIn('role_id', $this->roles()->pluck('roles.id'))
            ->where('permission', '=', $permission)
            ->count();
    }
    public static function scopeWithPermission($query, $permission)
    {
        $query = $query->whereHas('roles', function ($q) use ($permission) {
            $q->whereHas('rolePermissions', function ($q2) use ($permission) {
                $q2->where('permission', '=', $permission);
            });
        });
    }

    public function scopeSearch($query, $keyword)
    {
        $query->where(function ($query) use ($keyword) {
            $query->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('name', $keyword)
                ->orWhere('email', 'LIKE', "%{$keyword}%");
        });
    }

    public static function newDefault()
    {
        $user = new self();
        $user->status = self::STATUS_ACTIVE;
        return $user;
    }

    public function saveFromRequest($request)
    {
        $params = $request->all();
        
        if (!$request->password) {
            unset($params['password']);
        }

        $this->fill($params);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->id)],
        ];

        if (!$this->id) {
            $rules['password'] = ['required', Rules\Password::defaults()];
        } else {
            $rules['password'] = ['nullable', Rules\Password::defaults()];
        }

        if ($request->password) {
            $this->password = bcrypt($request->password);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // mentor
        if ($request->mentor_id) {
            $this->mentor_id = $request->mentor_id;
        } else {
            $this->mentor_id = null;
        }

        // change password required
        if ($request->change_password_required && $request->change_password_required == 'yes') {
            $this->change_password_required = true;
        } else {
            $this->change_password_required = false;
        }

        $this->status = self::STATUS_ACTIVE;
        
        // save
        $this->save();

        // add acccount
        if (!$this->account) {
            $account = $this->addAccount($this->name, $request->branch);
        } else {
            $account = $this->account;
            $account->name = $this->name;
        }

        // branch
        if ($request->branch) {
            $account->branch = $request->branch;
        }

        // account group
        if ($request->account_group_id) {
            $account->account_group_id = $request->account_group_id;
            $account->save();
        } else {
            $account->account_group_id = null;
            $account->save();
        }

        // role
        if ($request->role_id) {
            $this->setRole(Role::find($request->role_id));
        }

        // team leader
        if ($request->team_leader_id) {
            $account->setAccountGroupByTeamLeader(Account::find($request->team_leader_id));
        }

        // role
        if ($request->roles) {
            $this->roles()->sync($request->roles);
        }

        // add Teacher if this user is teacher
        if (in_array(\App\Library\Module::TEACHER, ($request->modules ?? []))) {
            $teacherParams = [
                'name' => $request->name,
                'type' => Role::find($request->roles[0])->alias,
                'email' => $request->email,
                'area' => $request->branch,
                'status' => Teacher::STATUS_ACTIVE
            ];

            $this->addTeacher($teacherParams);
        }

        return $validator->errors();
    }

    public static function scopeFilterByCreatedAt($query, $created_at_from, $created_at_to)
    {
        if (!empty($created_at_from) && !empty($created_at_to)) {
            return $query->whereBetween('users.created_at', [$created_at_from, \Carbon\Carbon::parse($created_at_to)->endOfDay()]);
        }

        return $query;
    }
    
    public static function scopeFilterByUpdatedAt($query, $updated_at_from, $updated_at_to)
    {
        if (!empty($updated_at_from) && !empty($updated_at_to)) {
            return $query->whereBetween('users.updated_at', [$updated_at_from, \Carbon\Carbon::parse($updated_at_to)->endOfDay()]);
        }

        return $query;
    }

    public function getReportViews()
    {
        if (!$this->report_views) {
            return [];
        }

        return json_decode($this->report_views, true);
    }

    public function addReportView($name, $data)
    {
        $views = $this->getReportViews();
        $views[$name] = $data;

        $this->updateReportViews($views);
    }

    public function updateReportViews($views)
    {
        $this->report_views = json_encode($views);
        $this->save();
    }

    public function removeReportView($name)
    {
        $views = $this->getReportViews();

        unset($views[$name]);

        $this->updateReportViews($views);
    }

    public function getListViews()
    {
        // no views at all
        if (!$this->list_views) {
            return [];
        }

        return json_decode($this->list_views, true);
    }

    public function getListView($name)
    {
        $views = $this->getListViews();

        if (!isset($views[$name])) {
            return false;
        }

        return $views[$name];
    }

    public function updateListView($name, $data)
    {
        $views = $this->getListViews();
        $views[$name] = $data;

        $this->updateListViews($views);
    }

    public function updateListViews($views)
    {
        $this->list_views = json_encode($views);
        $this->save();
    }

    public function removeListView($name)
    {
        $views = $this->getListViews();

        unset($views[$name]);

        $this->updateListViews($views);
    }

    public function getStudent()
    {
        return $this->account->getStudent();
    }

    public function addAccount($name, $branch)
    {
        if ($branch == '') {
            $branch = \App\Library\Branch::getDefaultBranch();
        }

        // account
        $account = Account::create([
            'name' => $name,
            'branch' => $branch,
            'status' => self::STATUS_ACTIVE,
        ]);
        
        $this->account_id = $account->id;
        $this->save();

        return $account;
    }

    public function createDefaultAccount($branch=null, $status = null)
    {
        if ($branch == null) {
            $branch = \App\Library\Branch::getDefaultBranch();
        }
        if ($status == null) {
            $status = Account::STATUS_ACTIVE;
        }
        // account
        $account = Account::create([
            'name' => $this->name,
            'branch' => $branch,
            'status' => $status,
        ]);
        
        $account->generateCode();

        $this->account()->associate($account);
        $this->save();

        return $account;
    }

    public function addRole($role)
    {
        if (!$this->roles()->where('role_id', $role->id)->exists()) {
            $this->roles()->attach($role);
        }
    }

    public function setRole($role)
    {
        $this->roles()->detach();
        
        //
        $this->addRole($role);
    }

    public function setAccount($account)
    {
        $this->account_id = $account->id;
        $this->save();
    }

    public function getTeacher()
    {
        return $this->account->getTeacher();
    }

    /**
     * check is current user is student
     * 
     * @return bool
     */
    public function isStudent() : bool
    {
        $student = $this->getStudent();

        if (is_null($student)) {
            return false;
        }

        return $this->email == $student->email;
    }

    public static function scopeByBranch($query, $branch)
    {
        if ($branch == \App\Library\Branch::BRANCH_ALL) return $query;

        return $query->whereHas('account', function ($subquery) use ($branch) {
            $subquery->where('branch', $branch);
        });
    }

    /**
     * Route notifications for the mail channel.
     *
     * @return  array<string, string>|string
     */
    // public function routeNotificationForMail(Notification $notification): array|string
    // {
    //     // Return email address only...
    //     return $this->email_address;
 
    //     // Return email address and name...
    //     return [$this->email_address => $this->name];
    // }

    public function hasRole($role)
    {
        return $this->roles()->where('roles.id', $role->id)->exists();
    }

    // Trong quá trình test thì chỉ send notification cho 1 email test duy nhất
    public function routeNotificationForMail(Notification $notification): array|string
    {
        // Return email address only...
        if(env('MAIL_TEST_ADDRESS')) {
            return env('MAIL_TEST_ADDRESS');
        }
 
        // Return email address and name...
        return [$this->email => $this->name];
    }

    public function hasModule($module)
    {
        return $this->roles()->where('module', $module)->exists();
    }

    public function isAlias($module)
    {
        return $this->roles()->where('alias', $module)->exists();
    }

    public function getRole()
    {
        return $this->roles()->first();
    }

    public static function scopeByModule($query, $module)
    {
        $query->whereHas('roles', function ($q) use ($module) {
            $q->where('module', $module);
        });
    }

    public static function scopeByManager($query, $alias)
    {
        $query->whereHas('roles', function ($q) use ($alias) {
            $q->where('alias', $alias);
        });
    }
    
    public function addStudentRole()
    {
        $roleStudent = Role::where('module', \App\Library\Module::STUDENT)->first();
        $this->addRole($roleStudent);
    }

    public function addTeacherRole()
    {
        $role = Role::where('module', \App\Library\Module::TEACHER)->first();
        $this->addRole($role);
    }

    public function updateAccountInfo()
    {
        $this->account->update([
            'name' => $this->name,
        ]);
    }

    public function disableChangePasswordNextLogin()
    {
        $this->change_password_required = false;
        $this->save();
    }

    public function enableChangePasswordNextLogin()
    {
        $this->change_password_required = true;
        $this->save();
    }
    public function getAccountGroupNameOrManagerName()
    {
        if ($this->account) {
            if ($this->account->accountGroup && $this->account->accountGroup->name) {
                return $this->account->accountGroup->name;
            } elseif ($this->account->manager && $this->account->manager->name) {
                return $this->account->manager->name;
            }
        }

        return null;
    }

    public static function getSystemUser()
    {
        return self::first();
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public static function scopeActive($query)
    {
        $query = $query->where('users.status', self::STATUS_ACTIVE);
    }

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public static function scopeIsOutOfJob($query)
    {
        $query = $query->where('users.status', self::STATUS_OUT_OF_JOB);
    }

    public function isOutOfJob()
    {
        return $this->status === self::STATUS_OUT_OF_JOB;
    }

    public function outOfJob()
    {
        $this->status = self::STATUS_OUT_OF_JOB;
        $this->save();
        // Sửa dòng dưới đây
        $this->account->status = self::STATUS_OUT_OF_JOB;
        $this->account->save();

        // Đăng xuất người dùng ra khỏi app
        \App\Helpers\Functions::logoutUser($this->id);
    }

    public function scopeIsAlias($query, $alias)
    {
        return $query->where('role_alias', $alias);
    }

    public function setSelectedBranch($branch)
    {
        $allBranchs = \App\Library\Branch::getAllBranch();

        if (!$branch || !in_array($branch, $allBranchs)) throw new \Exception("Branch setting is invalid!");
        
        $this->selected_branch = $branch;
        $this->save();
    }

    public function getCurrentBranch()
    {
        return $this->selected_branch ?? $this->account->branch;
    }

    public function addTeacher($params)
    {
        DB::beginTransaction();

        try {
            $newTeacher = Teacher::newDefault();
            $newTeacher->fill($params);
            $newTeacher->generateCode();

            $account = Account::find($this->account_id);
            $account->teacher_id = $newTeacher->id;
            $account->save();

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function softwareRequest()
    {
        
    }
}
