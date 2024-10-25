<?php

namespace App\Models;

use App\Events\UpdateSocialNetwork;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SocialNetwork extends Model
{
    use HasFactory;
    public const STATUS_DRAFT = 'draft';
    public const STATUS_ACTIVE = 'active';
    protected $table = 'social_network';
    protected $fillable = ['abroad_application_id', 'name', 'link', 'status'];
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    public function abroadApplication()
    {
        return $this->belongsTo(AbroadApplication::class);
    }
    public static function getByAbroadApplication($id)
    {
        $socialNetworks = self::where('abroad_application_id', $id)->get();
        return $socialNetworks;
    }
    public function updateSocialNetworkLink($link)
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            $this->link = $link;
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
    public static function createSocialNetworkLink($request)
    {
        // Xử lý dữ liệu từ request để tạo link mạng xã hội
        $socialNetwork = new SocialNetwork();
        $socialNetwork->abroad_application_id = $request->id;
        $socialNetwork->name = $request->page;
        $socialNetwork->link = $request->link;

        // Lưu link mạng xã hội vào cơ sở dữ liệu
        $socialNetwork->save();

        // UpdateSocialNetwork::dispatch($socialNetwork);
        return $socialNetwork;
    }

    public function updateActiveSocialNetwork()
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            $updated = DB::table('social_network')
                ->update(['status' => self::STATUS_ACTIVE]);
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
    public static function isCheckFill($abroad_application_id){
       
            return self::where('abroad_application_id', $abroad_application_id)
            ->where(function ($query) {
                $query->whereNotNull('name');
            })
            ->exists();
       
    }
}
