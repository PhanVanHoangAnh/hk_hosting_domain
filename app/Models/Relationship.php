<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    use HasFactory;

    const TYPE_FATHER = 'father';
    const TYPE_MOTHER = 'mother';
    const TYPE_OTHER = 'other';

    public static function newDefault()
    {
        $relationship = new self();
        
        return $relationship;
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    
    public function toContact()
    {
        return $this->belongsTo(Contact::class);
    }

    public static function scopeFather($query)
    {
        $query = $query->where('relationships.type', self::TYPE_FATHER);
    }

    public static function scopeMother($query)
    {
        $query = $query->where('relationships.type', self::TYPE_MOTHER);
    }

    public static function validate($contact, $toContact, $type, $other=null)
    {
        $exists = self::findRelationship($contact, $toContact, $type, $other);
        
        // existing
        if ($exists) {
            throw new \Exception('Quan hệ đã tồn tại!');
        }

        // can not be the same
        if ($contact->id == $toContact->id) {
            throw new \Exception('Không thể thêm quan hệ cho cùng liên hệ!');
        }

        // đã có father khác
        if ($type == self::TYPE_FATHER || $type == self::TYPE_MOTHER) {
            $relationship = self::where('to_contact_id', $toContact->id)
                ->where('relationships.type', $type)
                ->first();

            if ($relationship) {
                $typeName = trans('messages.contact.' . $type);
                throw new \Exception("Liên hệ {$relationship->toContact->name} đã có {$typeName} là {$relationship->contact->name}!");
            }
        }
    }

    public static function add($contact, $toContact, $type, $other=null)
    {
        self::validate($contact, $toContact, $type, $other);

        // add new one
        $relationship = self::newDefault();
        $relationship->contact_id = $contact->id;
        $relationship->to_contact_id = $toContact->id;
        $relationship->type = $type;

        if ($relationship->type == self::TYPE_OTHER) {
            $relationship->other = $other;
        } else {
            $relationship->other = null;
        }

        $relationship->save();
    }

    public static function findRelationship($contact, $toContact, $type, $other=null)
    {
        return self::where('relationships.contact_id', $contact->id)
            ->where('relationships.to_contact_id', $toContact->id)
            ->where('relationships.type', $type)
            ->where('relationships.other', $other)
            ->first();
    }

    public function getWording()
    {
        if ($this->type == self::TYPE_OTHER) {
            return $this->other;
        } else if ($this->type == self::TYPE_FATHER) {
            return 'cha';
        } else if ($this->type == self::TYPE_MOTHER) {
            return 'mẹ';
        } else {
            return 'unknow!';
        }
    }
}
