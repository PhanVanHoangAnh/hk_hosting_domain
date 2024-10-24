<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ExtracurricularController;
use App\Helpers\Functions;
use Illuminate\Support\Facades\Validator;

class Extracurricular extends Model
{
    use HasFactory;
    public const STATUS_DRAFT = 'draft';
    public const STATUS_ACTIVE = 'active';

    public const FILTER_KEY_BY_USER = 'byUser';
    public const FILTER_KEY_REGISTED = 'registed';
    public const FILTER_KEY_DONE = 'done';
    
    protected $table = 'extracurricular';
    protected $fillable = [
        'name',
        'address',
        'start_at',
        'end_at',
        'link',
        'status',
        'price',
        'type',
        'coordinator',
        'study_method',
        'max_student',
        'min_student',
        'price',
        'expected_costs',
        'actual_costs',
        'total_revenue',
        'describe',
        'hours_per_week',
        'weeks_per_year', 
        'document_link',
        'image_link',
        'proposal_link'
    ];
    
    public function abroadApplication()
    {
        return $this->belongsTo(AbroadApplication::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'coordinator', 'id');
    }

    public function extracurricularStudent()
    {
        return $this->hasMany(ExtracurricularStudent::class, 'extracurricular_id', 'id');
    }

    public function students()
    {
        return $this->belongsToMany(Contact::class, 'extracurricular_students', 'extracurricular_id', 'student_id');
    }

    public static function scopeSearch($query, $keyword)
    {
        $query = $query->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('address', 'LIKE', "%{$keyword}%")
                    ->orWhereHas('contacts', function ($q) use ($keyword) {
                        $q->where('phone', 'LIKE', "%{$keyword}%");
                    });
    }
    public static function scopeSearchById($query, $keyword)
    {
        $query = $query->where('id', $keyword);
    }
    public static function newDefault()
    {
        $extracurricular = new self();
        return $extracurricular;
    }
    
    public function updateExtracurricular($request)
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            $this->name = $request->name;
            $this->address = $request->address;
            $this->start_at = $request->start_at;
            $this->end_at = $request->end_at;
            $this->type = $request->type_extracurricular;
            $this->coordinator = $request->coordinator;
            $this->study_method = $request->study_type;
            $this->max_student = $request->max_student;
            $this->min_student = $request->min_student;
            $this->price = str_replace(',', '', $request->price);
            $this->expected_costs = $request->expected_costs == '' ? 0 : str_replace(',', '', $request->expected_costs);
            $this->actual_costs = $request->actual_costs =='' ? 0 : str_replace(',', '', $request->actual_costs); 
            $this->hours_per_week = $request->hours_per_week;
            $this->weeks_per_year = $request->weeks_per_year;
            // $this->total_revenue = $request->total_revenue;
            $this->describe = $request->describe;
            $this->image_link = $request->image_link;
            $this->document_link = $request->document_link;

            $this->save();
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            throw $e;
        }

        // commit
        DB::commit();
    }
    public  function createExtracurricular($request)
    {
        $this->fill($request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
            'type' => 'required',
            'coordinator' => 'required',
            'study_method' => 'required',
            'max_student' => 'required',
            'min_student' => 'required',
            'price' => 'required',

            'expected_costs' => 'required',
          
        ]);
        if ($request->price != '') {
            $this->price = Functions::convertStringPriceToNumber($request->price);
        }
        if ($request->expected_costs != '') {
            $this->expected_costs = Functions::convertStringPriceToNumber($request->expected_costs);
        }

        if ($validator->fails()) {
            return $validator->errors();
        }

        // save
        $this->save();
        return $validator->errors();

        // return $validator->errors();
        // $extracurricular = new Extracurricular();
        // $extracurricular->name = $request->name;
        // $extracurricular->address = $request->address;
        // $extracurricular->start_at = $request->start_at;
        // $extracurricular->end_at = $request->end_at;
        // $extracurricular->type = $request->type_extracurricular;
        // $extracurricular->coordinator = $request->coordinator;
        // $extracurricular->study_method = $request->study_type;
        // $extracurricular->max_student = $request->max_student;
        // $extracurricular->min_student = $request->min_student;
        // $extracurricular->price = str_replace(',', '', $request->price);
        // $extracurricular->expected_costs = $request->expected_costs == '' ? 0 : str_replace(',', '', $request->expected_costs);
        // $extracurricular->actual_costs = $request->actual_costs =='' ? 0 : str_replace(',', '', $request->actual_costs); 
        // // $extracurricular->total_revenue = $request->total_revenue;
        // $extracurricular->describe = $request->describe;
        // $extracurricular->image_link = $request->image_link;
        // $extracurricular->document_link = $request->document_link;
        // $extracurricular->hours_per_week = $request->hours_per_week;
        // $extracurricular->weeks_per_year = $request->weeks_per_year;

        // $extracurricular->save();

        // return $extracurricular;
    }

    public function updateDraftExtracurricular()
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            $updated = DB::table('extracurricular')
                ->update(['status' => self::STATUS_DRAFT]);
            DB::commit();
            // Return the number of updated rows
            return $updated;
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Handle the exception or log the error
            // For example, you might throw the exception again to let it propagate
            throw $e;
        }
    }

    public function countStudents()
    {
        return $this->extracurricularStudent()->count();
    }
    public function checkCountStudent()
    {
        $count = OrderItem::where('extracurricular_id', $this->id)->count();

        // Kiểm tra số lượng sinh viên đã đăng ký
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function scopeFinish($query) 
    {
        return $query->where('end_at', '<', Carbon::today());
    }
    public static function scopeNotFinished($query) 
    {
        $query = $query->where('end_at', '>=', Carbon::today());
        return $query;
    }
    public function scopeIsFinished() 
    {
        return $this->end_at < Carbon::today(); 
    }
    public static function scopeFinalized($query) 
    {
        return $query->whereNotNull('image_link')
            ->whereNotNull('document_link')
            ->whereNotNull('actual_costs');
    }

    public function addStudent($student,$order_item_id)
    {
        $this->students()->attach($student->id, ['order_item_id' => $order_item_id]);
    }

    public static function scopeSelect2($query, $request)
    {
        // keyword
        if ($request->search) {
            $query = $query->search($request->search);
        }

        // pagination
        $extracurriculars = $query->paginate($request->per_page ?? '10');

        return [
            "results" => $extracurriculars->map(function ($extra) {
                return [
                    'id' => $extra->id,
                    'text' => $extra->getSelect2Text(),
                ];
            })->toArray(),
            "pagination" => [
                "more" => $extracurriculars->lastPage() != $request->page,
            ],
        ];
    }

    public function getSelect2Text()
    {
        return '<strong>' . 'Tên hoạt động: ' . $this->name . '</strong>
                <div>' . 'địa chỉ: ' . $this->address . '</div>
                <div>' . 'Bắt đầu: ' . \Carbon\Carbon::parse($this->start_at)->format('d/m/Y') . '</div>
                <div>' . 'Kết thúc: ' . \Carbon\Carbon::parse($this->end_at)->format('d/m/Y') . '</div>
                <div>' . 'Link Proposal: ' . ($this->proposal_link ? $this->proposal_link : '--') . '</div>';
    }

    /**
     * Handle, validate and save price inline edit
     */
    public function savePriceInline($price)
    {
        $priceConverted = Functions::convertStringPriceToNumber($price);

        $this->price = $priceConverted;
        $this->save();
    }
    
    public function totalRevenue()
    {
        $extracurricularStudents = $this->extracurricularStudent;
        $totalRevenue = 0;

        foreach ($extracurricularStudents as $extracurricularStudent) {
            $orderItems = $extracurricularStudent->orderItems()->get();
            if ($orderItems->isNotEmpty()) {
                foreach ($orderItems as $orderItem) {
                    $totalRevenue += $orderItem->getTotalPriceRegardlessType();
                }
            }
        }
        

        return $totalRevenue;
    }


    public static function destroyAll($items)
    {
        self::whereIn('id', $items)->delete();
    }

    public static function scopeFilterByStartAt($query, $created_at_from=null, $created_at_to=null)
    {
        if (!empty($created_at_from)) {
            $query->where('extracurricular.start_at', '>=', \Carbon\Carbon::parse($created_at_from)->startOfDay());
        }

        if (!empty($created_at_to)) {
            $query->where('extracurricular.start_at', '<=', \Carbon\Carbon::parse($created_at_to)->endOfDay());
        }
    }

    public static function scopeFilterByEndAt($query, $updated_at_from=null, $updated_at_to=null)
    {
        if (!empty($updated_at_from)) {
            $query->where('extracurricular.end_at', '>=', \Carbon\Carbon::parse($updated_at_from)->startOfDay());
        }

        if (!empty($updated_at_to)) {
            $query->where('extracurricular.end_at', '<=', \Carbon\Carbon::parse($updated_at_to)->endOfDay());
        }
    }

    public static function scopeFilterByStudent($query, $student)
    {
        $query->whereHas('extracurricularStudent', function($q) use ($student) {
            $q->filterByStudent($student);
        });
    }

    public static function scopeHaventHappenedYet($query)
    {
        $query->where('start_at', '>', now());
    }

    public static function scopeDone($query)
    {
        $query->where('end_at', '<', now());
    }
    public function getProfit()
    {
        return $this->price - $this->actual_costs;
    }

    public function scopeByBranch($query, $branch)
    {
        return $query->where(function ($query) use ($branch) {
                $query->orWhere('study_method',  'Online')
                   
                ->orWhere(function ($query) use ($branch) {
                        $query->where('study_method', 'Offline')
                            ->whereHas('account', function ($q) use ($branch) {
                                if ($branch !== \App\Library\Branch::BRANCH_ALL) {
                                    $q->byBranch($branch);
                                }
                            });
                    })->orWhereNull('study_method')->orWhereNull('coordinator');
        });
    }

    
    
}
