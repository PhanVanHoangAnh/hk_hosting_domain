<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class SoftwareRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'company_name',
        'company_size',
        'company_branch',
        'line_of_business',
        'note',
        'estimated_cost',
        'start_date',
    ];
    const STATUS_NEW = 'new';
    const STATUS_CARE = 'needs_care';
    const STATUS_DELIVERED = 'delivered'; 
    const STATUS_PROGRESS = 'progress'; 
    const STATUS_COMPLETED = 'completed';

    public static function newDefault()
    {
        $request = new self();
        return $request;
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function scopeNew($query)
    {
        $query = $query->where('software_requests.status', self::STATUS_NEW);
    }

    public function scopeCare($query)
    {
        $query = $query->where('software_requests.status', self::STATUS_CARE);
    }

    public function scopeDelivered($query)
    {
        $query = $query->where('software_requests.status', self::STATUS_DELIVERED);
    }

    public function softwareRequestNotes()
    {
        return $this->hasMany(NoteLog::class);
    }

    public function saveFromRequest($request)
    {
        $this->fill($request->all());

        $validator = Validator::make($request->all(), [
            // 'contact_id' => 'required',
            'company_size' => 'required',
            'company_branch' => 'required',
            'estimated_cost' => 'required',
            'note' => 'required',
            'start_date' => 'required',
        ]);

        $rules = [
            // 'contact_id' => 'required',
            'company_size' => 'required',
            'company_branch' => 'required',
            'estimated_cost' => 'required',
            'note' => 'required',
            'start_date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }
        $this->save();

        return $validator->errors();
    }
    public function scopeProgress($query)
    {
        $query = $query->where('software_requests.status', self::STATUS_PROGRESS);
    }
    public function scopeCompleted($query)
    {
        $query = $query->where('software_requests.status', self::STATUS_COMPLETED);
    }
  
    
    
    
}
