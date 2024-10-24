<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class NoteLog extends Model
{
    use HasFactory;

    const STATUS_DELETED = 'deleted';
    const STATUS_ACTIVE = 'active';

    const IMAGE_UPLOAD_PATH = 'uploads/app/note_log';

    protected $fillable = ['contact_id', 'content', 'account_id', 'status', 'contact_request_id', 'system_add', 'software_request_id', 'contact_time'];

    public function contacts()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }
    public function contactRequest()
    {
        return $this->belongsTo(ContactRequest::class, 'contact_request_id', 'id');
    }
    public function softwareRequest()
    {
        return $this->belongsTo(SoftwareRequest::class, 'software_request_id', 'id');
    }
    public static function scopeSearch($query, $key)
    {
        $query->where(function ($subquery) use ($key) {
            $subquery->orWhere('content', 'LIKE', "%{$key}%")
                ->orWhereHas('contacts', function ($contactsSubquery) use ($key) {
                    $contactsSubquery->where('name', 'LIKE', "%{$key}%");
                })
                ->orWhereHas('account', function ($accountsSubquery) use ($key) {
                    $accountsSubquery->where('name', 'LIKE', "%{$key}%");
                });
        });
    }

    public function scopeActive($query)
    {
        return $query->where('note_logs.status', self::STATUS_ACTIVE);
    }

    public function scopeDeleted($query)
    {
        return $query->where('note_logs.status', self::STATUS_DELETED);
    }

    public static function isDeleted()
    {
        return self::where('status', self::STATUS_DELETED)->get();
    }

    public static function newDefault()
    {
        $note = new self();
        $note->status = self::STATUS_ACTIVE;
        return $note;
    }
    public function scopeNoteLogFromUser($query)
    {
        return $query->where('system_add', false);
    }
    public function scopeNoteLogFromSystem($query)
    {
        return $query->where('system_add', 1);
    }
    public static function scopeFilterByContactIds($query, $contactIds)
    {
        if (in_array('all', $contactIds)) {
            return $query;
        } else {
            return $query->whereIn('contact_id', $contactIds);
        };
    }

    public static function scopeFilterByAccountId($query, $accountId)
    {
        $query = $query->where('account_id', $accountId);
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function saveFromRequest($request)
    {
        $this->fill($request->all());

        $validator = Validator::make($request->all(), [
            'content' => 'required'
        ]);

        $rules = [
            'content' => 'required'
        ];

        if ($request->image) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->system_add = false;
        if ($request->has('reminder')) {
            $contactRequest = ContactRequest::find($this->contact_request_id);

            if ($contactRequest) {
                $contactRequest->reminder = $request->reminder;
                $contactRequest->save();
            } else {
                return response()->json(['message' => 'Contact request not found'], 404);
            }
        }
        $this->save();

        // upload image
        if ($request->has('image')) {
            $this->uploadImage($request->file('image'));
        }


        return $validator->errors();
    }

    public function storeFromRequest($request)
    {

        $this->account_id = auth()->id();

        $this->fill($request->all());

        $rules = [
            'content' => 'required',
            'contact_id' => 'required',
        ];

        if ($request->has('contact_request_id')) {
            $rules = [
                'content' => 'required',
                'contact_id' => '',
                'contact_request_id' => 'required'
            ];
            if ($request->has('reminder')) {
                $contactRequestId = $request->input('contact_request_id');

                $contactRequest = ContactRequest::find($contactRequestId);

                if ($contactRequest) {
                    $contactRequest->reminder = $request->reminder;
                    $contactRequest->save();
                } else {
                    return response()->json(['message' => 'Contact request not found'], 404);
                }
            }
        }
        if ($request->image) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }
        $this->system_add = false;

        $this->save();

        // upload image
        if ($request->has('image')) {
            $this->uploadImage($request->file('image'));
        }

        return $validator->errors();
    }

    public static function scopeSortList($query, $sortColumn, $sortDirection)
    {
        return $query = $sortColumn === 'name'
            ? $query->join('accounts', 'note_logs.account_id', '=', 'accounts.id')
            ->join('contacts', 'note_logs.contact_id', '=', 'contacts.id')
            ->select('note_logs.*', 'contacts.name as contact_name')
            ->orderBy('contact_name', $sortDirection)
            : $query->orderBy($sortColumn, $sortDirection);
    }

    public static function scopeDeleteListNotes($query, $noteIds)
    {
        $notelogs = self::whereIn('id', $noteIds)->get();

        foreach ($notelogs as $notelog) {
            $notelog->update(['status' => self::STATUS_DELETED]);
        }
    }

    public static function scopeFilterByCreatedAt($query, $created_at_from, $created_at_to)
    {
        if (!empty($created_at_from) && !empty($created_at_to)) {
            return $query->whereBetween('note_logs.created_at', [$created_at_from, \Carbon\Carbon::parse($created_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeFilterByUpdatedAt($query, $updated_at_from, $updated_at_to)
    {
        if (!empty($updated_at_from) && !empty($updated_at_to)) {
            return $query->whereBetween('note_logs.updated_at', [$updated_at_from, \Carbon\Carbon::parse($updated_at_to)->endOfDay()]);
        }

        return $query;
    }

    public function deleteNoteLog()
    {
        $this->status = self::STATUS_DELETED;
        $this->save();

        // remove folder
        File::deleteDirectory(public_path($this->getImageDir()));
    }
    public static function scopeByBranch($query, $branch)
    {
        return $query->whereHas('account', function ($subquery) use ($branch) {
            if ($branch !== \App\Library\Branch::BRANCH_ALL) {
                $subquery->where('branch', $branch);
            }
        });
    }

    public function isAddedBySystem()
    {
        return $this->system_add == true;
    }

    public function getImagePath()
    {
        return $this->getImageDir() . '/image';
    }

    public function getImageDir()
    {
        $dirPath = self::IMAGE_UPLOAD_PATH . '/' . $this->id;

        return $dirPath;
    }

    public function uploadImage($file)
    {
        // image path
        $filePath = $this->getImageDir();

        // Đảm bảo thư mục tồn tại
        if (!File::exists($filePath)) {
            File::makeDirectory($filePath, 0755, true, true);
        }

        // Xóa file nếu đã tồn tại
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
        // Di chuyển file tới thư mục lưu trữ
        $file->move($filePath, 'image');
    }

    public function uploadImageFromRequest($request)
    {
        // Kiểm tra nếu không có file trong request
        if (!$request->hasFile('file')) {
            return collect(); // Trả về mảng rỗng nếu không có file
        }

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpg,jpeg,png'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->uploadImage($request->file('file'));

        return $validator->errors();
    }

    public function hasImage()
    {
        $publicPath = public_path($this->getImagePath());

        if (file_exists($publicPath)) {
            return true;
        }

        return false;
    }

    public function getUploadImage()
    {
        if ($this->hasImage()) {
            return $this->getImagePath();
        } else {
            return url('core/assets/media/svg/files/blank-image.svg');
        }
    }

    public function storeNoteLogFromRequest($request)
    {

        $this->fill($request->all());

        $rules = [
            'content' => 'required',
            'contact_id' => 'required',
        ];

        if ($request->has('software_request_id')) {
            $rules = [
                'content' => 'required',
                'contact_id' => '',
                'software_request_id' => 'required'
            ];
        }

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return $validator->errors();
            // dd(12);
        }

        $this->save();

        return $validator->errors();
    }

    public function saveNoteLogFromRequest($request)
    {
        $this->fill($request->all());

        $validator = Validator::make($request->all(), [
            'content' => 'required'
        ]);

        $rules = [
            'content' => 'required'
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $this->save();

        return $validator->errors();
    }

}
