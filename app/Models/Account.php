<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Library\Module;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Account extends Model
{
    use HasFactory;
    public const STATUS_ACTIVE = 'active';
    public const STATUS_OUT_OF_JOB = 'out_of_job';
    protected $fillable = ['name', 'account_group_id', 'branch'];

    public function scopeSearch($query, $keyword)
    {
        return $query->where('name', 'LIKE', "%{$keyword}%");
    }

    public static function newDefault()
    {
        // Tạo một thể hiện mới của mô hình
        $account = new self();
        return $account;
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
    
    public function noteLogs()
    {
        $user = $this->users()->first();
        if ($user && $user->can('manager', \App\Models\User::class))  {
            $accountIds = $this->accountGroup->members->pluck('id'); 
            return NoteLog::whereIn('account_id', $accountIds);
        } elseif ($user  && $user->can('mentor', \App\Models\User::class))  {
            $accountIds = $user->mentees()->pluck('id')->push($this->id); 
            return NoteLog::whereIn('account_id', $accountIds);

        }
        return $this->hasMany(NoteLog::class);
    }

    public function onlyContacts()
    {
        return $this->hasMany(Contact::class)->isNotCustomer();
    }

    public function onlyContactsOrHasContactRequests()
    {
        $user = $this->users()->first();
        if ($user  && $user->can('manager', \App\Models\User::class))  {
            $accountIds = $this->accountGroup->members->pluck('id')->push($this->id);
        } elseif ($user  && $user->can('mentor', \App\Models\User::class))  {
            $accountIds = $user->mentees()->pluck('id')->push($this->id); 
        } else {
            $accountIds = [$this->id];
        }

        return Contact::byBranch(\App\Library\Branch::getCurrentBranch())
            ->isNotCustomer()
            ->where(function ($q) use ($accountIds) {
                $q->whereIn('account_id', $accountIds)
                    ->orWhereHas('contactRequests', function ($q) use ($accountIds) {
                        $q->whereIn('account_id', $accountIds);
                    });
            });
    
    }

    public function contactsOrHasContactRequests()
    {
        return $this->hasMany(Contact::class)->where(function ($q) {
            $q->where('account_id', '=', $this->id)
                ->orWhereHas('contactRequests', function ($q) {
                    $q->where('account_id', '=', $this->id);
                });
        });
    }

    public function contactRequests()
    { 
        return $this->hasMany(ContactRequest::class);
    }

    public function onlyContactsHasOrder()
    {
        $user = $this->users()->first();
        if ($this->accountGroup  && $user  && $user->can('manager', \App\Models\User::class))  {
            $accountIds = $this->accountGroup->members->pluck('id')->push($this->id);
        } elseif ($user  && $user->can('mentor', \App\Models\User::class))  {
            $accountIds = $user->mentees()->pluck('id')->push($this->id);
        } else {
            $accountIds = collect([$this->id]);
        }

        return Contact::isCustomer()
        ->where(function ($q) use ($accountIds) {
            $q->orWhereHas('orders', function ($q) use ($accountIds) {
                    $q->whereIn('sale', $accountIds);
                })
                ->orWhere('account_id', '=', $this->id)
                ->orWhereHas('contactRequests', function ($q) {
                    $q->where('account_id', '=', $this->id);
                });
        });
    }
    

    public function mentees()
    {
        return $this->hasMany(Account::class, 'mentor_id');
    }
    public function contactRequestsByAccount()
    { 
        $user = $this->users()->first();
        if ($this->accountGroup  && $user  && $user->can('manager', \App\Models\User::class))  {
            $accounts = $this->accountGroup->members->push($this);
            return ContactRequest::hadAssignedToAccounts($accounts);
        }
        if ($user  && $user->can('mentor', \App\Models\User::class))  {
            $accounts = $user->getAccountsIncludingMentees(); 
            return ContactRequest::hadAssignedToAccounts($accounts);
        }
        return $this->hasMany(ContactRequest::class);
    }

    public function customers()
    {
        return $this->contacts()->isCustomer();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function saleOrdersByAccount()
    { 
        $user = $this->users()->first();
        if ($this->accountGroup  && $user  && $user->can('manager', \App\Models\User::class))  {
            $accountIds = $this->accountGroup->members->pluck('id')->push($this->id);
            return Order::whereIn('sale', $accountIds); 
        }
        if ($user  && $user->can('mentor', \App\Models\User::class))  {
            $accountIds = $user->mentees()->pluck('id')->push($this->id); 
            return Order::whereIn('sale', $accountIds); 
        }

        return $this->hasMany(Order::class, 'sale');
    }

    public function saleOrders()
    {
        return $this->hasMany(Order::class, 'sale');
    }

    public function kpiTarget()
    {
        return $this->hasMany(KpiTarget::class, 'account_id', 'id');
    }
    
    public function kpiTargets()
    {
        return $this->hasMany(KpiTarget::class, 'account_id', 'id');
    }

    public function accountGroup()
    {
        return $this->belongsTo(AccountGroup::class);
    }

    public function managingAccountGroup()
    {
        return $this->hasOne(AccountGroup::class, 'manager_id');
    }

    public function accountKpiNotes()
    {
        return $this->hasMany(AccountKpiNote::class, 'account_id');
    }

    public function demands()
    {
        return $this->hasMany(Demand::class);
    }

    public function abroadApplications()
    {
        $query = AbroadApplication::query();

        $user = $this->users()->first();
        
        if ($this->accountGroup  && $user  && $user->can('manager', \App\Models\User::class))  {
            $accountIds = $this->accountGroup->getAllAccountAndManagerIds();
            return $query->where(function ($subQuery) use ($accountIds) {
                $subQuery->orWhereIn('account_1', $accountIds)
                        ->orWhere('account_manager_abroad_id', $this->id);
            });
        }
        return $query->orWhere('account_1', $this->id);
        // return $this->hasMany(AbroadApplication::class, 'account_1');
    }
    public function abroadApplicationExtracurriculars()
    {
        $query = AbroadApplication::query();
        $user = $this->users()->first();

        if ($this->accountGroup  && $user  && $user->can('manager', \App\Models\User::class))  {
            $accountIds = $this->accountGroup->getAllAccountAndManagerIds();
            return $query->where(function ($subQuery) use ($accountIds) {
                $subQuery->orWhereIn('account_2', $accountIds)
                        ->orWhere('account_manager_extracurricular_id', $this->id);
            });
        }
        return $query->orWhere('account_2', $this->id);

    }
    public function getSaleSub()
    {
        return $this->accountGroup ?
            ($this->accountGroup->manager ?? null) :
            null;
    }

    public function student()
    {
        return $this->belongsTo(Contact::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    public function getCoursesForUser()
    {
         $user = $this->users()->first();
         if ($this->accountGroup  && $user  && $user->can('manager', \App\Models\User::class))  {
            
            $accountIds = $this->accountGroup->members->pluck('teacher_id');
            
            return Course::edu()->whereIn('teacher_id', $accountIds);

        }
        return $this->teacher->courses();
    }

    // Trong mô hình Account
    public function paymentRecords()
    {
        return $this->hasMany(PaymentRecord::class);
    }

    public function newTag()
    {
        $tag = Tag::newDefault();
        $tag->account_id = $this->id;
        return $tag;
    }

    public function newRole()
    {
        $role = Role::newDefault();
        $role->account_id = $this->id;
        return $role;
    }

    public static function scopeSales($query)
    {
        $query = $query->whereHas('users', function ($q) {
            $q->whereHas('roles', function ($q2) {
                $q2->where('module', Module::SALES); 
            });
        });
        // return $query;
    }

    public static function scopeExtracurriculars($query)
    {
        $query = $query->whereHas('users', function ($q) {
            $q->whereHas('roles', function ($q2) {
                $q2->where('module', Module::EXTRACURRICULAR); 
            });
        });
    }

    public static function scopeExtracurricularsAndSales($query)
    {
        $query = $query->whereHas('users', function ($q) {
            $q->whereHas('roles', function ($q2) {
                $q2->where('module', Module::EXTRACURRICULAR)
                ->orWhere('module', Module::SALES); 
            });
        });
    }

    public static function scopeSalesSup($query)
    {
        $query = $query->whereHas('users', function ($q) {
            $q->whereHas('roles', function ($q2) {
                $q2->where('alias', Role::ALIAS_SALES_LEADER); 

            });
        });
    }

    public static function scopeActive($query)
    {
        $query = $query->where('accounts.status', self::STATUS_ACTIVE);
    }

    public static function scopeIsOutOfJob($query)
    {
        $query = $query->where('accounts.status', self::STATUS_OUT_OF_JOB);
    }
    
    public function newContact()
    {
        $contact = Contact::newDefault();
        $contact->account_id = $this->id;

        return $contact;
    }

    public function newOrder()
    {
        $contact = Order::newDefault();
        $contact->sale = $this->id;

        return $contact;
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
        
        $this->generateCode();

        // save
        $this->save();

        return $validator->errors();
    }

    public static function scopeFilterByCreatedAt($query, $created_at_from, $created_at_to)
    {
        if (!empty($created_at_from) && !empty($created_at_to)) {
            return $query->whereBetween('accounts.created_at', [$created_at_from, \Carbon\Carbon::parse($created_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeFilterByUpdatedAt($query, $updated_at_from, $updated_at_to)
    {
        if (!empty($updated_at_from) && !empty($updated_at_to)) {
            return $query->whereBetween('accounts.updated_at', [$updated_at_from, \Carbon\Carbon::parse($updated_at_to)->endOfDay()]);
        }

        return $query;
    }

    public function getSelect2Text()
    {
        return $this->name;
    }

    public static function scopeSelect2($query, $request)
    {
        //theo branch
        $query->where('branch', \App\Library\Branch::getCurrentBranch());
        
        // keyword
        if ($request->search) {
            $query = $query->search($request->search);
        }

        // team leader select
        if ($request->filter == 'team_leader') {
            $query = $query->teamLeader();
        }

        // is not
        if ($request->is_not) {
            $query = $query->whereNot('id', $request->is_not);
        }

        // pagination
        $records = $query->paginate($request->per_page ?? '10');

        return [
            "results" => $records->map(function ($record) {
                return [
                    'id' => $record->id,
                    'text' => $record->getSelect2Text(),
                ];
            })->toArray(),
            "pagination" => [
                "more" => $records->lastPage() != $request->page,
            ],
        ];
    }

    public function generateCode()
    {
        if ($this->created_at) {
            $orderYear = $this->created_at->year;
        } else {
            $orderYear = date('Y'); 
        }

        $maxCode = self::where('code_year', $orderYear)->max('code_number');
        $codeNumber = $maxCode ? ($maxCode + 1) : 1;

        $this->code_year = $orderYear;
        $this->code_number = $codeNumber;
        $this->save();

        // refresh code
        $this->refreshCode();
    }

    public function refreshCode()
    {
        $this->code = 'UC' . sprintf("%04s", $this->code_number) . "/" . $this->code_year;
        $this->save();
    }

    public static function findByCode($code)
    {
        return self::where('accounts.code', $code)->first();
    }

    public function getContactRequests($sourceType, $updated_at_from = null, $updated_at_to = null)
    {
        $query = $this->contactRequests()->where('source_type', $sourceType);

        if ($updated_at_from && $updated_at_to) {
            $query->whereBetween('assigned_at', [$updated_at_from . ' 00:00:00', $updated_at_to . ' 23:59:59']);
        } else {
            
            if ($updated_at_from) {
                $query->whereDate('assigned_at', '>=', $updated_at_from . ' 00:00:00');
            }
    
            
            if ($updated_at_to) {
                $query->whereDate('assigned_at', '<=', $updated_at_to . ' 23:59:59');
            }
        }

        return $query;
    }

    public function getContactRequestsTotal( $updated_at_from = null, $updated_at_to = null)
    {
        $query = $this->contactRequests();

        if ($updated_at_from && $updated_at_to) {
            $query->whereBetween('assigned_at', [$updated_at_from . ' 00:00:00', $updated_at_to . ' 23:59:59']);
        } else {
            
            if ($updated_at_from) {
                $query->whereDate('assigned_at', '>=', $updated_at_from . ' 00:00:00');
            }
    
            
            if ($updated_at_to) {
                $query->whereDate('assigned_at', '<=', $updated_at_to . ' 23:59:59');
            }
        }
        return $query;
    }

    public function countMatchingContactIdsBySourceType($sourceType, $updated_at_from = null, $updated_at_to = null)
    {
        $contactRequestsContactIds = $this->getContactRequests($sourceType, $updated_at_from, $updated_at_to )->pluck('contact_id')->toArray();

        // số lượng contact_id trùng nhau trong bảng orders
        $matchingContactIdsCount = Order::hasContactRequest()->whereIn('contact_id', $contactRequestsContactIds)->count();

        return $matchingContactIdsCount;
    }

    public function sumMatchingContactIdsByTypes($updated_at_from = null, $updated_at_to = null)
    {
        $types = ['Other', 'Hotline', 'Referal', 'Offline', 'Digital'];

        return collect($types)->map(function ($type) use ($updated_at_from, $updated_at_to) {
            return $this->countMatchingContactIdsBySourceType($type, $updated_at_from, $updated_at_to);
        })->sum();
    }

    public function getActualRevenueMonth($startAt, $endAt)
    {
        return Order::where('updated_at', '>', Carbon::parse($startAt)->endOfDay())->sum('price');
    }

    public function getManager() 
    {
        if (!isset($this->account_group_id)) return null;

        $group = AccountGroup::find($this->account_group_id);
        $managerId = $group->manager_id;

        return self::find($managerId);
    }

    public function getAmountOfPaymentRecordsAccumulatedMonth($startDate)
    {
        $saleId = $this->id;
        
        $totalPaymentRecordsAmount = PaymentRecord::whereHas('orders', function($order) use ($saleId) {
            $order->where('status', 'approved')->where('sale', $saleId);
        })
        ->whereDate('updated_at', '>=', $startDate)
        ->orderByRaw('MONTH(updated_at) ASC')
        ->get()
        ->pluck('amount')
        ->toArray();

        $totalAmount = array_sum(array_map('floatval', $totalPaymentRecordsAmount));
        
        return $totalAmount;
    }

    public function getAmountOfPaymentRecordsAccumulatedYear($startDate)
    {
        $saleId = $this->id;
        
        $totalPaymentRecordsAmount = PaymentRecord::whereHas('orders', function($order) use ($saleId) {
            $order->where('status', 'approved')->where('sale', $saleId);
        })
        ->whereDate('updated_at', '>=', $startDate)
        ->orderByRaw('YEAR(updated_at) ASC')
        ->get()
        ->pluck('amount')
        ->toArray();

        $totalAmount = array_sum(array_map('floatval', $totalPaymentRecordsAmount));
        
        return $totalAmount;
    }

    public function getAmountOfPaymentRecordsAccumulatedQuater($startDate)
    {
        $saleId = $this->id;
        
        $totalPaymentRecordsAmount = PaymentRecord::whereHas('orders', function($order) use ($saleId) {
            $order->where('status', 'approved')->where('sale', $saleId);
        })
        ->whereDate('updated_at', '>=', $startDate)
        ->orderByRaw('QUARTER(updated_at) ASC')
        ->get()
        ->pluck('amount')
        ->toArray();

        $totalAmount = array_sum(array_map('floatval', $totalPaymentRecordsAmount));
        
        return $totalAmount;
    }

    public function scopeOfType($query, $type)
    {
        return $query->whereHas('accountGroup', function ($subquery) use ($type) {
            $subquery->where('type', $type);
        });
    }

    public function getAccountKpiNoteContactsInWeek( $start, $end)
    {
        return $this->accountKpiNotes()
        ->whereBetween('estimated_payment_date', [$start, $end])
        ->distinct('contact_id')
        ->pluck('contact_id');
    }

    public function getAccountKpiNoteContacts()
    {
        return $this->accountKpiNotes()
        ->distinct('contact_id')
        ->pluck('contact_id');
    }

    public function getAmountInRange($start, $end)
    {
        return $this->accountKpiNotes()
            ->whereBetween('estimated_payment_date', [$start, $end])
            ->get()
            ->sum('amount');
    }

    public function sumAmountOfPaymentRecordsInDateRange($startDate, $endDate, $contactId)
    {
        return $this->paymentRecords()
                    ->whereBetween('payment_date', [$startDate, $endDate])
                    ->where('contact_id', $contactId)
                    ->sum('amount');
    }

    public static function exportToExcelKpiReport($templatePath, $filteredAccounts, $request, $start, $end)
    {
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 3;
        $iteration = 1;
        $start = !is_null($start) ? Carbon::createFromFormat('Y-m-d', $start)->format('d-m-Y') : '--';
        $end = !is_null($end) ? Carbon::createFromFormat('Y-m-d', $end)->format('d-m-Y') : '--';

        foreach ($filteredAccounts as $account) {
            // Date formatting
            $accountKpiByMonth = KpiTarget::getAccountKpiByMonth($account->id, $request->from_date);
            $actualRevenueMonth = !is_null($start) ? $account->getAmountOfPaymentRecordsAccumulatedMonth($start) : 0;
            $completionRateMonth = $accountKpiByMonth != 0 ? ($actualRevenueMonth / $accountKpiByMonth) * 100 : 0;
        
            $accountKpiLuyKeNam = KpiTarget::getAccountKpiLuyKeNam($account->id, $request->to_date);
            $actualRevenueYear = !is_null($start) ? $account->getAmountOfPaymentRecordsAccumulatedYear($start) : 0;
            $completionRateNam = $accountKpiLuyKeNam != 0 ? ($actualRevenueYear / $accountKpiLuyKeNam) * 100 : 0;
            
            $rowData = [
                $iteration,
                $account->code,
                $account->name,
                $start,
                $end,
                number_format($accountKpiByMonth, 0, '.', ',') . 'đ',
                number_format($actualRevenueMonth, 0, '.', ',') . 'đ',
                number_format($completionRateMonth, 2, ".", ",") . '%',

                number_format($accountKpiLuyKeNam, 0, '.', ',') . 'đ',
                number_format($actualRevenueYear, 0, '.', ',') . 'đ',
                number_format($completionRateNam, 2, ".", ",") . '%',
            ];
        
            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
            $iteration++;
        }        
    }

    public static function exportToExcelConversionRateReport($templatePath, $filteredAccount, $updated_at_from, $updated_at_to)
    {
        $worksheet = $templatePath->getActiveSheet();
        $rowIndex = 4;

        foreach ($filteredAccount as $account) {
            // Date formatting
            $contactRequestsCount = $account->getContactRequests('Digital', $updated_at_from, $updated_at_to)->count();
            $matchingContactIdsCount = $account->countMatchingContactIdsBySourceType('Digital', $updated_at_from, $updated_at_to);
            $ratioDigital = ($contactRequestsCount > 0) ? number_format($matchingContactIdsCount / $contactRequestsCount * 100, 2) . '%' : '0%';
            $offlineContactRequestsCount = $account->getContactRequests('Offline', $updated_at_from, $updated_at_to)->count();
            $matchingOfflineContactIdsCount = $account->countMatchingContactIdsBySourceType('Offline', $updated_at_from, $updated_at_to);
            $ratioOffline = ($offlineContactRequestsCount > 0) ? number_format($matchingOfflineContactIdsCount / $offlineContactRequestsCount * 100, 2). '%' : '0%';
            $referralContactRequestsCount = $account->getContactRequests('Referral', $updated_at_from, $updated_at_to)->count();
            $matchingReferralContactIdsCount = $account->countMatchingContactIdsBySourceType('Referral', $updated_at_from, $updated_at_to);
            $ratioReferal = ($referralContactRequestsCount > 0) ? number_format($matchingReferralContactIdsCount / $referralContactRequestsCount * 100, 2). '%' : '0%';
            $hotlineContactRequestsCount = $account->getContactRequests('Hotline', $updated_at_from, $updated_at_to)->count();
            $matchingHotlineContactIdsCount = $account->countMatchingContactIdsBySourceType('Hotline', $updated_at_from, $updated_at_to);
            $ratioHotline = ($hotlineContactRequestsCount > 0) ? number_format($matchingHotlineContactIdsCount / $hotlineContactRequestsCount * 100, 2). '%' : '0%';
            $otherContactRequestsCount = $account->getContactRequests('Other', $updated_at_from, $updated_at_to)->count();
            $matchingOtherContactIdsCount = $account->countMatchingContactIdsBySourceType('Other', $updated_at_from, $updated_at_to);
            $ratioOther = ($otherContactRequestsCount > 0) ? number_format($matchingOtherContactIdsCount / $otherContactRequestsCount * 100, 2). '%' : '0%';
            $totalContactRequestsCount = $account->getContactRequestsTotal($updated_at_from, $updated_at_to)->count();
            $totalMatchingContactIdsCount = $account->sumMatchingContactIdsByTypes($updated_at_from, $updated_at_to);
            $total = ($totalContactRequestsCount > 0) ? number_format($totalMatchingContactIdsCount / $totalContactRequestsCount * 100, 2). '%' : '0%';
            $rowData = [
                $account->code,
                $account->name,
                $account->getSaleSub()->name ?? '--',
                $contactRequestsCount,
                $matchingContactIdsCount,
                $ratioDigital,
                $offlineContactRequestsCount,
                $matchingOfflineContactIdsCount,
                $ratioOffline,
                $referralContactRequestsCount,
                $matchingReferralContactIdsCount,
                $ratioReferal,
                $hotlineContactRequestsCount,
                $matchingHotlineContactIdsCount,
                $ratioHotline,
                $otherContactRequestsCount,
                $matchingOtherContactIdsCount,
                $ratioOther,
                $totalContactRequestsCount,
                $totalMatchingContactIdsCount,
                $total,
            ];

            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
        }
    }

    public function getSaleSup() 
    {
        return $this->accountGroup ? ($this->accountGroup->manager ?? null) : null;
    }

    public function getStudent()
    {
        return $this->student;
    }

    public function setStudent($contact)
    {
        $this->student_id = $contact->id;
        $this->save();
    }

    public function createNewDefaultContact($name, $email)
    {
        // $validator = Validator::make();

        // $validator->after(function ($validator) use ($name, $email) {
        //     if ($name == '') {
        //         $validator->errors()->add()
        //     }
        // });

        $newContact = Contact::create([
            'name' => $name,
            'email' => $email,
            'status' => Contact::STATUS_ACTIVE
        ]);

        return $newContact;
    }

    public function getTeacher()
    {
        return $this->teacher;
    }

    public function setTeacher($teacher)
    {
        $this->teacher_id = $teacher->id;
        $this->save();
    }

    public function createNewDefaultTeacher($name, $email, $type=null)
    {
        $newTeacher = Teacher::create([
            'name' => $name,
            'email' => $email,
            'type' => $type ?? Teacher::TYPE_VIETNAM,
            'status' => Teacher::STATUS_ACTIVE,
            'area' => $this->branch,
        ]);

        return $newTeacher;
    }
    public static function scopeByBranch($query, $branch)
    {
        if ($branch != \App\Library\Branch::BRANCH_ALL) {
            $query->where('branch', $branch);
        }
    }

    public static function scopeTeamleader($query)
    {
        // $query->whereHas('users', function ($q) {
        //     $q->whereHas('roles', function ($q2) {
        //         $q2->whereHas('rolePermissions', function ($q3) {
        //             $q3->whereIn('permission', [
        //                 \App\Library\Permission::SALES_ACCOUNT_GROUP_MANAGE
        //             ]);
        //         });
        //     });
        // });
    }

    public function setAccountGroupByTeamLeader($leader)
    {
        // for now, each team leader has one account group that he/she is a leader
        if ($leader->managingAccountGroup)
        {
            $this->setAccountGroup($leader->managingAccountGroup);
        } else {
            $leader->createDefaultAccountGroup();
            $leader = self::find($leader->id);
            $this->setAccountGroup($leader->managingAccountGroup);
        }
    }

    public function createDefaultAccountGroup()
    {
        $this->managingAccountGroup()->create([
            'name' => $this->name,
            'type' => AccountGroup::TYPE_SALES,
        ]);
    }

    public function setAccountGroup($accountGroup)
    {
        $this->account_group_id = $accountGroup->id;
        $this->save();
    }

    public function getOrdersForAccount()
    {
        $ordersBySalesperson = Order::where('sale', $this->id)->select('id');

        // Orders where the account has revenue distribution
        $ordersByRevenueDistribution = Order::whereHas('orderItems.revenueDistributions', function ($query) {
            $query->where('account_id', $this->id);
        })->select('id');

        
        $orders = $ordersBySalesperson->unionAll($ordersByRevenueDistribution)->get();
        $uniqueOrders = $orders->unique('id');

        return $uniqueOrders;
    }

    // public function getRevenueForAccountInCurrentMonth()
    // {
    //     $orderIds = $this->getOrdersForAccount();
        
    //     $paymentRecords = PaymentRecord::whereIn('order_id', $orderIds)->paid()->currentMonth()->get();
    
    //     $revenues = [];
    //     $revenue = 0;
    
    //     foreach ($paymentRecords as $paymentRecord) {
    //         $orderItems = OrderItem::where('order_id', $paymentRecord->order_id)->get();
    //         $order = $orderItems->first()->order;
    
    //         foreach ($orderItems as $orderItem) {
    //             $accountId = $this->id;
    
    //             // Calculate revenue based on is_sharing
    //             if ($orderItem->is_sharing === 0) {
    //                 // If is_sharing is 0, calculate revenue based on salesperson
    //                 if ($order->sale == $accountId) {
    //                     $revenue += $paymentRecord->amount * ($orderItem->price / $order->getTotal());
    //                     $revenues[] = [
    //                         'amount' => $paymentRecord->amount,
    //                         'percentage0' => $orderItem->price / $order->getTotal(),
    //                         'revenue' => $revenue,
    //                         'orderItem' => $orderItem->id,
    //                         'order' => $order->id,
    //                     ];
    //                 }
    //             } else {
    //                 // If is_sharing is 1, calculate revenue based on RevenueDistribution
    //                 $revenueDistribution = RevenueDistribution::where('order_item_id', $orderItem->id)
    //                                                             ->where('account_id', $accountId)
    //                                                             ->first();
    //                 if ($revenueDistribution) {
    //                     $revenue += $paymentRecord->amount * ($revenueDistribution->amount / $orderItem->price) * ($orderItem->price /$order->getTotal());
    //                     $revenues[] = [
    //                         'amount' => $paymentRecord->amount,
    //                         'percentage1' => ($revenueDistribution->amount / $orderItem->price) * ($orderItem->price /$order->getTotal()),
    //                         'revenue' => $revenue,
    //                         'orderItem' => $orderItem->id,
    //                         'order' => $order->id,
    //                     ];
    //                 }
    //             }
    //         }
    //     }
    
    //     return $revenues[];
    // }

    public function getRevenueForAccountInDateRange($startAt, $endAt)
    {
        $startAt = \Carbon\Carbon::parse($startAt)->startOfDay();
        $endAt = \Carbon\Carbon::parse($endAt)->endOfDay();

        
        $orderIds = $this->getOrdersForAccount();

        
        $paymentRecords = PaymentRecord::whereIn('order_id', $orderIds)
                                    ->paid()
                                    ->received()
                                    ->whereBetween('payment_date', [$startAt, $endAt])
                                    ->get();

        $revenue = 0;
        foreach ($paymentRecords as $paymentRecord) {
            $orderItems = OrderItem::where('order_id', $paymentRecord->order_id)->get();

            if ($orderItems->isNotEmpty()) {
                foreach ($orderItems as $orderItem) {
                    $order = $orderItem->order; 
                    $revenue += $this->calculateRevenue($paymentRecord, $orderItem, $order);
                }
            }
        }

        return $revenue;
    }

    public function getRevenueForAccountInCurrentMonth()
    {
        $orderIds = $this->getOrdersForAccount();
        $paymentRecords = PaymentRecord::whereIn('order_id', $orderIds)->paid()->received()->currentMonth()->get();

        $revenue = 0;
        foreach ($paymentRecords as $paymentRecord) {
            $orderItems = OrderItem::where('order_id', $paymentRecord->order_id)->get();

            if ($orderItems->isNotEmpty()) {
                foreach ($orderItems as $orderItem) {
                    $order = $orderItem->order; 
                    $revenue += $this->calculateRevenue($paymentRecord, $orderItem, $order);
                }
            }
        }

        return $revenue;
    }
    public function getRevenueForAccountInPreviousMonth()
    {
        $orderIds = $this->getOrdersForAccount();
        $paymentRecords = PaymentRecord::whereIn('order_id', $orderIds)->paid()->received()->previousMonth()->get();

        $revenue = 0; 
        foreach ($paymentRecords as $paymentRecord) {
            $orderItems = OrderItem::where('order_id', $paymentRecord->order_id)->get();

            if ($orderItems->isNotEmpty()) {
                foreach ($orderItems as $orderItem) {
                    $order = $orderItem->order; 
                    $revenue += $this->calculateRevenue($paymentRecord, $orderItem, $order); 
                }
            }
        }

        return $revenue;
    } 

    // private function calculateRevenue($paymentRecord, $orderItem, $order)
    // {
    //     $revenue = 0;

    //     if ($orderItem->type === OrderItem::TYPE_EDU) { 
    //         $orderItemPrice = $orderItem->getTotalPriceOfEdu();
    //     } else {
    //         $orderItemPrice = $orderItem->price;
    //     }

    //     if ($orderItem->is_share == 0 ) {
    //         $revenue += $paymentRecord->amount * ($orderItemPrice / $order->getTotal());
    //     } else {
    //         $revenueDistribution = RevenueDistribution::where('order_item_id', $orderItem->id)
    //                                                     ->where('account_id', $this->id)
    //                                                     ->first(); 
    //         if ($revenueDistribution) {
    //             $revenue += $paymentRecord->amount * ($revenueDistribution->amount / $orderItemPrice) * ($orderItemPrice / $order->getTotal());
    //         } else {
    //             \Log::error('Không tìm thấy dữ liệu RevenueDistribution cho order item ' . $orderItem->id); 
    //         }
    //     }

    //     $refundRequest = RefundRequest::where('order_item_id', $orderItem->id)->first();

    //     if ($refundRequest) {
    //         // If payment record exists
    //         $paymentRecord = PaymentRecord::where('order_item_id', $orderItem->id)
    //             ->where('type', 'paid')
    //             ->first();
    //         if ($paymentRecord) {
    //             if ($orderItem->is_share == 0) {
    //                 $revenue -= $paymentRecord->amount * ($orderItemPrice / $order->getTotal());
    //             } else {
    //                 $revenueDistribution = RevenueDistribution::where('order_item_id', $orderItem->id)
    //                     ->where('account_id', $this->id)
    //                     ->first();
    //                 if ($revenueDistribution) {
    //                     $revenue -= $paymentRecord->amount * ($revenueDistribution->amount / $orderItemPrice) * ($orderItem->price / $order->getTotal());
    //                 } else {
    //                     \Log::error('Không tìm thấy dữ liệu RevenueDistribution cho order item ' . $orderItem->id);
    //                 }
    //             }
    //         } else {
    //             \Log::error('Không tìm thấy dữ liệu paymentRecord cho order item ' . $orderItem->id);
    //         }
    //     }

    //     return $revenue;
    // }

    private function calculateRevenue($paymentRecord, $orderItem, $order)
    {
        $orderItemPrice = $orderItem->getTotalPriceRegardlessType();
        $revenue = 0;
        if ($orderItem->is_share == 0) {
            $revenue += $paymentRecord->amount * ($orderItemPrice / $order->getTotal());
        } else {
            $revenue += $this->calculateSharedRevenue($paymentRecord, $orderItem, $orderItemPrice, $order);
        }
    
        // if ($this->hasRefundRequest($orderItem)) {
        //     $revenue -= $this->calculateRefundAmount($orderItem, $orderItemPrice, $order);
        // }
    
        return $revenue;
    }
    
    private function calculateSharedRevenue($paymentRecord, $orderItem, $orderItemPrice, $order)
    {
        $revenueDistribution = RevenueDistribution::where('order_item_id', $orderItem->id)
            ->where('account_id', $this->id)
            ->first(); 
    
        if (!$revenueDistribution) {
            \Log::error('Không tìm thấy dữ liệu RevenueDistribution cho order item ' . $orderItem->id);
            return 0;
        }
    
        return $paymentRecord->amount * ($revenueDistribution->amount / $orderItemPrice) * ($orderItemPrice / $order->getTotal());
    }
    
    private function hasRefundRequest($orderItem)
    {
        return RefundRequest::where('order_item_id', $orderItem->id)->approved()->exists();
    }
    
    private function calculateRefundAmount($orderItem, $orderItemPrice, $order)
    {
        $paymentRecord = PaymentRecord::where('order_item_id', $orderItem->id)->refund()->paid()
            ->first();
    
        if ($paymentRecord) {
            if ($orderItem->is_share == 1) {
            
                $revenueDistribution = RevenueDistribution::where('order_item_id', $orderItem->id)
                    ->where('account_id', $this->id)
                    ->first(); 
                    
                return $paymentRecord->amount * ($revenueDistribution->amount / $orderItemPrice) * ($orderItemPrice / $order->getTotal());
            }
            
        } else {
            \Log::error('Không tìm thấy dữ liệu paymentRecord cho order item ' . $orderItem->id);
            return 0;
        }
    
       
    
        return $paymentRecord->amount * ($orderItemPrice / $order->getTotal());
    }
    
        
    public function getRevenueForAccountByPreviousWeek($weekOffset = 0)
    {
        $orderIds = $this->getOrdersForAccount();
        $currentDate = Carbon::now();
        $firstDayOfMonth = $currentDate->copy()->startOfMonth();
        $currentWeekOfMonth = ceil($currentDate->day / 7);

        if ($currentWeekOfMonth == 1) {
            // if the current week is the first week of the month, use the last week of the previous month
            $startOfWeek = $currentDate->copy()->subMonth()->endOfMonth()->startOfWeek(Carbon::MONDAY);
            $endOfWeek = $currentDate->copy()->subMonth()->endOfMonth()->endOfWeek(Carbon::SUNDAY);
        } else {
            // calculate the week based on the current week of the month
            $startOfWeek = $firstDayOfMonth->addWeeks($currentWeekOfMonth - 2)->startOfWeek(Carbon::MONDAY);
            $endOfWeek = $startOfWeek->copy()->endOfWeek(Carbon::SUNDAY);
        }

        // Get payment records 
        $paymentRecordPaids = PaymentRecord::whereIn('order_id', $orderIds)
                                        ->paid()
                                        ->received()
                                        ->whereBetween('payment_date', [$startOfWeek, $endOfWeek])
                                        ->get();

        $revenue = 0;

        foreach ($paymentRecordPaids as $paymentRecord) {
            $orderItems = OrderItem::where('order_id', $paymentRecord->order_id)->get();
            $order = $orderItems->first()->order;

            foreach ($orderItems as $orderItem) { 
                $order = $orderItem->order; 
                $revenue += $this->calculateRevenue($paymentRecord, $orderItem, $order);
                
            }
        }

        return $revenue;
    }
    public function getKpiTargetAmountForCurrentMonth()
    {
        $currentDate = Carbon::now();
        $startOfMonth = $currentDate->startOfMonth();
        $endOfMonth = $currentDate->endOfMonth();
 
        $kpiTarget = $this->kpiTarget()
                        ->where('start_at', '<=', $startOfMonth)
                        ->where('end_at', '>=', $endOfMonth)
                        ->orderBy('updated_at', 'desc')
                        ->first();

        return $kpiTarget ? $kpiTarget->amount : 0;
    }

    public function getPercentKpiRevenueThisMonth()
    {
        if ($this->getKpiTargetAmountForCurrentMonth() == 0) {
            return 0; 
        }
        $percentage = ($this->getRevenueForAccountInCurrentMonth() / $this->getKpiTargetAmountForCurrentMonth()) * 100;
        return round($percentage, 2);
    }
    
    public function getPercentKpiRevenuePreviousMonth()
    {
        if ($this->getKpiTargetAmountForCurrentMonth() == 0) {
            return 0; 
        }
        $percentage = ($this->getRevenueForAccountInPreviousMonth() / $this->getKpiTargetAmountForCurrentMonth()) * 100;
        return round($percentage, 2);
    }
    
    public function getPercentKpiRevenueInPreviousWeek()
    {
        if ($this->getKpiTargetAmountForCurrentMonth() == 0) {
            return 0; 
        }
        $percentage = ($this->getRevenueForAccountByPreviousWeek() / $this->getKpiTargetAmountForCurrentMonth()) * 100;
        return round($percentage, 2);
    }
    
    public function divideRevenueByKpiTarget()
    { 
        $kpiTarget = $this->getKpiTargetAmountForCurrentMonth();
    
        if ($kpiTarget == 0) {
            return false; 
        }
    
        $percentage = $this->getPercentKpiRevenue();
    
        if ($percentage < 25) {
            return false; 
        }
    
        return true;
    }
    
    public function getKpiMonth()
    { 
        return $this->kpiTarget()->month()->latest()->value('amount');
    }
    
    public function getLongUnExploitedContactRequests()
    {
        $longUnExploitedContactRequests = $this->contactRequests->where(function($q) {
            $numOfDays = 1; // Temporary

            return $q->isLongUnExploited($numOfDays);
        });

        return $longUnExploitedContactRequests;
    }

    public function calculateTotalKPI($startDate, $endDate)
    {
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);


        $targets = $this->kpiTargets()
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('start_at', [$startDate, $endDate])
                        ->orWhereBetween('end_at', [$startDate, $endDate]);
                })->orWhere(function ($query) use ($startDate, $endDate) {
                    $query->where('start_at', '<=', $startDate)
                        ->where('end_at', '>=', $endDate);
                });
            })
            ->orderBy('updated_at', 'desc')
            ->get();


        $kpiTotal = 0;
        $accountedDays = collect();


        foreach ($targets as $target) {

            $targetStart = Carbon::parse($target->start_at);
            $targetEnd = Carbon::parse($target->end_at);

            $overlapStart = $targetStart->greaterThan($startDate) ? $targetStart : $startDate;
            $overlapEnd = $targetEnd->lessThan($endDate) ? $targetEnd : $endDate;

            $daysInPeriod = collect(range(0, $overlapStart->diffInDays($overlapEnd)))
                ->map(function ($day) use ($overlapStart) {
                    return $overlapStart->copy()->addDays($day)->format('Y-m-d');
                })
                ->filter(function ($day) use ($accountedDays) {
                    return !$accountedDays->contains($day);
                });

            $accountedDays = $accountedDays->merge($daysInPeriod);


            $totalDays = $targetStart->diffInDays($targetEnd) + 1;
            $dailyKPI = floatval($target->amount) / $totalDays;

            $contribution = $dailyKPI * $daysInPeriod->count();
            $kpiTotal += $contribution;
        }

        return $kpiTotal;
    }
    // public function calculateKPI($startDate, $endDate)
    // {
    //     $totalKPI = 0;

    //     // Fetch relevant KpiTarget records based on date range
    //     $relevantRecords = $this->kpiTargets()
    //                             ->where('start_at', '<=', $endDate)
    //                             ->where('end_at', '>=', $startDate)
    //                             ->get();

    //     foreach ($relevantRecords as $kpiTarget) {
    //         $startAt = Carbon::parse($kpiTarget->start_at);
    //         $endAt = Carbon::parse($kpiTarget->end_at);

    //         // Calculate overlap days
    //         $overlapStart = $startAt->max($startDate);
    //         $overlapEnd = $endAt->min($endDate);
    //         $overlapDays = $overlapStart->diffInDays($overlapEnd) + 1;

    //         // Calculate total days in the target period
    //         $totalDays = $startAt->diffInDays($endAt) + 1;

    //         // Calculate daily KPI amount
    //         $dailyKPI = $kpiTarget->amount / $totalDays;

    //         // Accumulate KPI for the overlapping period
    //         $totalKPI += $dailyKPI * $overlapDays;
    //     }

    //     return $totalKPI;
    // }

    public static function getDefaultSalesAccount()
    {
        return self::whereHas('users', function ($q) {
            $q->whereHas('roles', function ($q2) {
                $q2->where('email', 'sales@asms.com'); 
            });
        })->first();
    }

    /**
     * The sentence "Working with" here mean:
     * the contact has contact requests,
     * Retrieve all sales accounts to which this contact request was previously assigned
     */
    public static function getSalesWorkedWithContact($contact)
    {
        return self::sales()->whereHas('contactRequests', function($q) use ($contact) {
            $q->where('contact_id', $contact->id);
        })->get();
    }

    public static function scopeSelectHK($query, $request)
    {
        
        // keyword
        if ($request->search) {
            $query = $query->search($request->search);
        }

        // team leader select
        if ($request->filter == 'team_leader') {
            $query = $query->teamLeader();
        }

        // is not
        if ($request->is_not) {
            $query = $query->whereNot('id', $request->is_not);
        }

        // pagination
        $records = $query->paginate($request->per_page ?? '10');

        return [
            "results" => $records->map(function ($record) {
                return [
                    'id' => $record->id,
                    'text' => $record->getSelect2Text(),
                ];
            })->toArray(),
            "pagination" => [
                "more" => $records->lastPage() != $request->page,
            ],
        ];
    }
}
