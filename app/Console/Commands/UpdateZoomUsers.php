<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ZoomMeeting;
use App\Models\ZoomUser;

class UpdateZoomUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-zoom-users:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
    */
    public function handle()
    {
        $users = ZoomMeeting::listUsers()['users'];

        foreach ($users as $user) {
            $existingUser = ZoomUser::where('user_id', $user['id'])->first();

            if (!$existingUser) {
                $newUser = new ZoomUser();

                $newUser->fill($user);
                $newUser->record_created_at = $user['created_at'];
                $newUser->user_id = $user['id'];

                $newUser->save();
            } else {
                // @todo: Update fields if exists
            }
        }

        // @todo: Xóa nếu không có trong users trả về: ZoomaMeeting::whereNotIn($users->map('ID'))->delete();
        ZoomUser::whereNotIn('user_id', array_map(function($user) {
            return $user['id'];
        }, $users))
        ->delete();
    }
}
