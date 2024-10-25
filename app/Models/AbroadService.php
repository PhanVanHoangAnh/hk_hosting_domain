<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbroadService extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type'];

    public const TYPE_THESIS_PACKAGE = "thesis_package";
    public const TYPE_BASIC = "basic";
public const TYPE_PREMIUM = "premium";

    public static function getAllTypes()
    {
        return [
            self::TYPE_THESIS_PACKAGE,
            self::TYPE_BASIC,
            self::TYPE_PREMIUM
        ];
    }

    public static function types()
    {
        return self::all()->pluck('type')->unique();
    }

    public static function getServiceByType($type)
    {
        return self::where('type', $type)->get();
    }

    public static function scopeSelect2($query, $request)
    {
        // keyword
        if ($request->search) {
            $query = $query->search($request->search);
        }

        // pagination
        $abroadServices = $query->paginate($request->per_page ?? '10');

        return [
            "results" => $abroadServices->map(function ($service) {
                return [
                    'id' => $service->id,
                    'text' => $service->getSelect2Text(),
                ];
            })->toArray(),
            "pagination" => [
                "more" => $abroadServices->lastPage() != $request->page,
            ],
        ];
    }

    public function getSelect2Text()
    {
        return '<strong>' . 'Tên môn học: ' . $this->name . '</strong><div>' . 'loại dịch vụ: ' . $this->type . '</div>';
    }
}
