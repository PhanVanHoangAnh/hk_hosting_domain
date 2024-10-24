<?php

namespace App\Http\Controllers;

use App\Library\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', [
            'columns' => [
                ['id' => 'name', 'title' => trans('messages.user.name'), 'checked' => true],
                ['id' => 'email', 'title' => trans('messages.user.email'), 'checked' => true],
                ['id' => 'module', 'title' => trans('messages.user.module'), 'checked' => true],
                ['id' => 'account_group_id', 'title' => trans('messages.account.account_group_id'), 'checked' => true],
                ['id' => 'mentor', 'title' => trans('messages.user.mentor'), 'checked' => true],
                ['id' => 'created_at', 'title' => trans('messages.user.created_at'), 'checked' => true],
                ['id' => 'updated_at', 'title' => trans('messages.user.updated_at'), 'checked' => true],
            ]
        ]);
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

        return view('users.list', [
            'users' => $users,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function create()
    {
        $user = User::newDefault();
        return view('users.create', [
            'user' => $user
        ]);
    }

    public function store(Request $request)
    {
        $user = User::newDefault();
        $errors = $user->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('users.create', [
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

        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa user thành công',
        ]);
    }

    public function edit(Request $request, $id)
    {
        $user = User::find($id);
        return view('users.edit', [
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
            return response()->view('users.edit', [
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
        return view('users.deleteUsers', [
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

    public static function logoutAndRedirect(Request $request)
    {
        // Forget origin_user_id if it exists
        \Session::forget('origin_user_id');

        //
        \Auth::logout();

        // redirect
        return redirect()->away($request->redirect);
    }

    public function loginBack()
    {
        $originUser = User::find(\Session::get('origin_user_id'))->first();

        \Auth::login($originUser);

        \Session::forget('origin_user_id');

        // redirect
        return redirect()->action([\App\Http\Controllers\System\UserController::class, 'index']);
    }
}
