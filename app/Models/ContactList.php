<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ContactList extends Model
{
    use HasFactory;
    protected $fillable = ['name'];



    public function scopeSearch($query, $keyword)
    {
        $query = $query->where('name', 'LIKE', "%{$keyword}%");
    }


    public static function newDefault()
    {
        $contact = new self();
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

        // save
        $this->save();

        return $validator->errors();
    }

}