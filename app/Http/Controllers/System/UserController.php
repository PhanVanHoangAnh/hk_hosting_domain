<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Library\Module;
use Illuminate\Support\Facades\DB;



class UserController extends Controller
{
    public function index(Request $request)
    {
        return view(
            'system.users.index',
            [
                'status' => $request->status,
                'columns' => [
                    ['id' => 'name', 'title' => trans('messages.user.name'), 'checked' => true],
                    ['id' => 'email', 'title' => trans('messages.user.email'), 'checked' => true],
                    ['id' => 'module', 'title' => trans('messages.user.module'), 'checked' => true],
                    ['id' => 'role', 'title' => trans('messages.user.role'), 'checked' => true],
                    ['id' => 'account_group_id', 'title' => trans('messages.account.account_group_id'), 'checked' => true],
                    ['id' => 'mentor', 'title' => trans('messages.user.mentor'), 'checked' => true],
                    ['id' => 'created_at', 'title' => trans('messages.user.created_at'), 'checked' => true],
                    ['id' => 'updated_at', 'title' => trans('messages.user.updated_at'), 'checked' => true],
                    ['id' => 'status', 'title' => trans('messages.user.status'), 'checked' => true],

                ],
            ]
        );
    }

    public function list(Request $request)
    {
        //init
        $users = User::byBranch(\App\Library\Branch::getCurrentBranch());

        //keyword
        if ($request->keyword) {
            $users = $users->search($request->keyword);
        }

        // module
        if ($request->module) {
            $users = $users->byModule($request->module);
        }

        // statuses
        if ($request->status) {
            switch ($request->status) {

                case User::STATUS_ACTIVE:
                    $users = $users->active();
                    break;

                case User::STATUS_OUT_OF_JOB:
                    $users = $users->isOutOfJob();
                    break;

                case 'all':
                    break;

                default:
                    throw new \Exception('Invalid status:' . $request->status);
            }
        }

        // sort
        $users = $users->orderBy($request->sort_by ?? 'created_at', $request->sort_direction ?? 'desc');

        //pagination

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        // Filter by created_at
        if ($request->has('created_at_from') && $request->has('created_at_to')) {
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $users  = $users->filterByCreatedAt($created_at_from, $created_at_to);
        }
        // Filter by updated_at
        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $users  = $users->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }
        $users = $users->paginate($request->per_page ?? 10);


        // pagination

        return view('system.users.list', [
            'users' => $users,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function create()
    {
        $user = User::newDefault();
        return view('system.users.create', [
            'user' => $user
        ]);
    }

    public function store(Request $request)
    {
        $user = User::newDefault();
        $errors = $user->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('system.users.create', [
                'user' => $user,
                'errors' => $errors,
            ], 400);
        }

        $imageName = 'profile_picture.jpg'; // Khởi tạo biến $imageName

        // Xử lý hình ảnh
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            // $imageName = $request->input('profile_picture') . '.' . $image->getClientOriginalExtension();

            // Tạo đường dẫn đầy đủ cho thư mục lưu trữ
            $storagePath = "/users/{$user->id}/";

            // Lưu trữ hình ảnh trong thư mục
            $image->storeAs($storagePath, $imageName, 'public');
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm user thành công',
            // 'imageName' => $imageName,
        ]);
    }

    public function destroy(Request $request, $id)
    {

        $user = User::find($id);

        // $user->delete();
        if($user->hasModule(Module::EXTRACURRICULAR)){
            $abroadApplications = $user->account->abroadApplicationExtracurriculars()->get();
            
            if($user->account->accountGroup){ 
                $managerId = $user->account->accountGroup->manager_id;

                DB::transaction(function () use ($abroadApplications, $managerId) {
                    foreach ($abroadApplications as $abroadApplication) {
                        $abroadApplication->update([
                            'account_manager_extracurricular_id' => $managerId,
                            'account_2' => null,
                        ]);
                
                    }
                });
            }
            else{ 
                DB::transaction(function () use ($abroadApplications) { 
                    foreach ($abroadApplications as $abroadApplication) {
                        $abroadApplication->update(['account_2' => null]);
                    }
                });
            }
        }
        if($user->hasModule(Module::ABROAD)){
            $abroadApplications = $user->account->abroadApplications()->get();
            
            if($user->account->accountGroup){ 
                $managerId = $user->account->accountGroup->manager_id;

                DB::transaction(function () use ($abroadApplications, $managerId) {
                    foreach ($abroadApplications as $abroadApplication) {
                        $abroadApplication->update([
                            'account_manager_abroad_id' => $managerId,
                            'account_1' => null,
                        ]);
                
                    }
                });
            }
            else{ 
                DB::transaction(function () use ($abroadApplications) { 
                    foreach ($abroadApplications as $abroadApplication) {
                        $abroadApplication->update(['account_1' => null]);
                    }
                });
            }
        }
        $user->outOfJob();

        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa tài khoản thành công',
        ]);
    }

    public function edit(Request $request, $id)
    {
        $user = User::find($id);
        return view('system.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        // init
        $user = User::find($id);
        // validate
        $errors = $user->saveFromRequest($request);
        if (!$errors->isEmpty()) {
            return response()->view('system.users.edit', [
                'user' => $user,
                'errors' => $errors,
            ], 400);
        }

        // Xử lý hình ảnh nếu được tải lên
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = "profile_picture.jpg"; // Tên hình ảnh bạn muốn sử dụng

            // Lưu hình ảnh trong thư mục của người dùng
            $image->storeAs("public/users/{$user->id}/", $imageName);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đã cập nhật người dùng thành công',
        ]);
    }

    public function deleteUsers(Request $request)
    {
        //
        $userIds = $request->input('user_ids');
        //
        $users = User::whereIn('id', $userIds)->get();
        return view('system.users.deleteUsers', [
            'users' => $users,
        ]);
    }

    public function actionDeleteUsers(Request $request)
    {
        // Lấy danh sách các ID từ trường 'user_ids' trong request
        $userIds = $request->input('user_ids');
        // Sử dụng danh sách các ID để lấy các tag tương ứng
        // User::whereIn('id', $userIds)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa người dùng thành công',
        ]);
    }

    public function saveListColumns(Request $request)
    {
        $request->user()->updateListView($request->name, $request->columns);
    }

    public function updateAvatar(Request $request,  $id)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');

            // storage path
            $storagePath = "avatar/{$id}/";

            // nếu có file rồi thì update lại file
            if (!is_dir(public_path("storage/{$storagePath}"))) {
                mkdir(public_path("storage/{$storagePath}"), 0777, true);
            }

            $avatarFileName = 'profile_avatar.png';
            $avatar->storeAs($storagePath, $avatarFileName, 'public');

            return response()->json(['message' => 'Cập nhật hình đại diện thành công']);
        }

        return response()->json(['message' => 'Không tim thấy tệp tin.'], 400);
    }

    public function loginAs(Request $request)
    {
        $originUserId = $request->user();
        $user = User::find($request->id);

        \Auth::login($user);
        \Session::put('origin_user_id', $originUserId);

        return redirect()->route('root');
    }

    // public function outOfJobUser(Request $request, $id)
    // {
    //     $user = User::find($id);

    //     $user->outOfJob();

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Tài khoản đã tạm ngưng',
    //     ]);    
    // }
    public function checkAbroadApplications($id)
    {
        $user = User::find($id);

        if ($user->hasModule(Module::EXTRACURRICULAR)) {
            $abroadApplicationsCount = $user->account->abroadApplicationExtracurriculars()->count();
            return response()->json([
                'hasModule' => true,
                'count' => $abroadApplicationsCount
            ]);
        }elseif ($user->hasModule(Module::ABROAD)) {
            $abroadApplicationsCount = $user->account->abroadApplications()->count();
            return response()->json([
                'hasModule' => true,
                'count' => $abroadApplicationsCount
            ]);
        } else {
            return response()->json([
                'hasModule' => false
            ]);
        }
    }
}
