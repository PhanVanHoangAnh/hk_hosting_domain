<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Tag;

use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $accounts = Account::all();
        return view('marketing.tags.index', [
            'accounts' => $accounts,
            'columns' => [
                ['id' => 'name', 'title' => trans('messages.tag.name'), 'checked' => true],
                ['id' => 'account_id', 'title' => trans('messages.tag.account_id'), 'checked' => true],
                ['id' => 'created_at', 'title' => trans('messages.tag.created_at'), 'checked' => true],
                ['id' => 'updated_at', 'title' => trans('messages.tag.updated_at'), 'checked' => true],
            ]
        ]);
    }

    public function list(Request $request)
    {
        //init
        // $tags = Tag::query();
        $tags = Tag::with('accounts');
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        // $accounts = Account::all();

        //keyword
        if ($request->keyword) {
            $tags = $tags->search($request->keyword);
        }

        // filter by account id
        // if ($request->accountIds) {
        //     $tags = $tags->filterByAccountIds($request->accountIds);
        // }
        // filter by account id
        if ($request->has('account_filter')) {
            $tags = $tags->filterByAccountIds($request->input('account_filter'));
        }
        // Filter by created_at
        if ($request->has('created_at_from') && $request->has('created_at_to')) {
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $tags = $tags->filterByCreatedAt($created_at_from, $created_at_to);
        }
        // Filter by updated_at
        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $tags = $tags->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }

        // sort
        $tags = $tags->orderBy($sortColumn, $sortDirection);

        //pagination
        $tags = $tags->paginate($request->perpage ?? 5);

        return view('marketing.tags.list', [
            'tags' => $tags,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function create(Request $request)
    {
        $tag = $request->user()->account->newTag();
        // $tag = Tag::query();
        // $tag = new Tag();
        // $tag->account_id = auth()->id();


        return view('marketing.tags.create', [
            'tag' => $tag,
        ]);
    }

    public function store(Request $request)
    {
        $tag = $request->user()->account->newTag();
        // $tag = new Tag();
        // $tag->account_id = $request->user()->account->id;

        // $tag = Tag::query();
        // $tag->account_id = auth()->id();

        // $tag->save();
        $errors = $tag->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('marketing.tags.create', [
                'tag' => $tag,
                'errors' => $errors,
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm tag thành công',
        ]);
    }

    public function update(Request $request, $id)
    {
        // init
        $tag = Tag::find($id);
        // validate
        $errors = $tag->saveFromRequest($request);
        if (!$errors->isEmpty()) {
            return response()->view('marketing.tags.edit', [
                'tag' => $tag,
                'errors' => $errors,
            ], 400);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm tag thành công',
        ]);
    }

    public function edit(Request $request, $id)
    {
        $tag = Tag::find($id);
        return view('marketing.tags.edit', [
            'tag' => $tag,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        // init
        $tag = Tag::find($id);
        // delete
        $tag->delete();
        //
        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa tag khách hàng thành công',
        ]);
    }

    public function deleteTags(Request $request)
    {
        //
        $tagIds = $request->input('tag_ids');
        //
        $tags = Tag::whereIn('id', $tagIds)->get();
        return view('marketing.tags.delete_tags', [
            'tags' => $tags,
        ]);
    }

    public function actionDeleteTags(Request $request)
    {
        // Lấy danh sách các ID từ trường 'tag_ids' trong request
        $tagIds = $request->input('tag_ids');
        // Sử dụng danh sách các ID để lấy các tag tương ứng
        Tag::whereIn('id', $tagIds)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa tag khách hàng thành công',
        ]);
    }
}
