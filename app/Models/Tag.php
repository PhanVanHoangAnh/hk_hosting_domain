<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function scopeSearch($query, $keyword)
    {
        $query = $query->where('name', 'LIKE', "%{$keyword}%");
    }

    public function scopeByAccountId($query, $accountId)
    {
        $query = $query->where('account_id', $accountId);
    }

    public static function newDefault()
    {
        $tag = new self();
        return $tag;
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

        // save
        $this->save();

        return $validator->errors();
    }

    public function accounts() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public static function scopeFilterByAccountIds($query, $accountIds)
    {
        if(in_array('all', $accountIds)) {
            return $query;
        } else {
            return $query->whereIn('account_id', $accountIds);
        }
    }

    public static function scopeFilterByCreatedAt($query, $created_at_from, $created_at_to)
    {
        if (!empty($created_at_from) && !empty($created_at_to)) {
            return $query->whereBetween('tags.created_at', [$created_at_from, \Carbon\Carbon::parse($created_at_to)->endOfDay()]);
        }
    
        return $query;
    }
    
    public static function scopeFilterByUpdatedAt($query, $updated_at_from, $updated_at_to)
    {
        if (!empty($updated_at_from) && !empty($updated_at_to)) {
            return $query->whereBetween('tags.updated_at', [$updated_at_from, \Carbon\Carbon::parse($updated_at_to)->endOfDay()]);
        }
    
        return $query;
    }
    
}
