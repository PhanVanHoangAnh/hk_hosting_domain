<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class KpiTarget extends Model
{
    use HasFactory;

    const TYPE_MONTH = 'month';
    const TYPE_QUARTER = 'quarter';

    const IMPORT_TEMPLATE_PATH = 'templates/import-kpi-target.xlsx';

    public static function scopeMonth($query)
    {
        $query = $query->where('type', self::TYPE_MONTH);
    }
    public static function scopeQuarter($query)
    {
        $query = $query->where('type', self::TYPE_QUARTER);
    }
    public function getStartAtAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function getEndAtAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public static function getTypeOptions()
    {
        return [
            ['value' => self::TYPE_MONTH, 'text' => trans('messages.kpi_target.type.month')],
            ['value' => self::TYPE_QUARTER, 'text' => trans('messages.kpi_target.type.quarter')],
        ];
    }

    public function scopeSearch($query, $keyword)
    {
        $query->where(function ($query) use ($keyword) {
            $query->orWhereHas('account', function ($q2) use ($keyword) {
                $q2->where('name', 'LIKE', "%{$keyword}%")
                   ->orWhere('code', 'LIKE', "%{$keyword}%");
            });
        });
    }

    public static function newDefault()
    {
        $kpiTarget = new self();
        $kpiTarget->type = self::TYPE_MONTH;
        return $kpiTarget;
    }

    public function fillAttributes($params = [])
    {
        $this->type = $params['type'] ?? null;
        $this->amount = isset($params['amount']) ? preg_replace('/[^0-9]/', '', $params['amount']) : null;
        $this->account_id = $params['account_id'] ?? null;
        $this->start_at = $params['start_at'] ?? null;
        $this->end_at = $params['end_at'] ?? null;
    }

    public function saveFromRequest($request)
    {
        $this->fillAttributes($request->all());

        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'account_id' => 'required',
            'amount' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
        ], [
            'type.required' => 'Chưa chọn loại kế hoạch',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // save
        $this->save();

        return $validator->errors();
    }

    public static function scopeDeleteAll($query, $ids)
    {
        $kpiTargets = self::whereIn('id', $ids)->get();

        foreach ($kpiTargets as $kpiTarget) {
            $kpiTarget->delete();
        }
    }

    public static function getImportTemplatePath()
    {
        return public_path(self::IMPORT_TEMPLATE_PATH);
    }

    public static function getImportTemplate()
    {
        $templatePath = self::getImportTemplatePath();
        $templateSpreadsheet = IOFactory::load($templatePath);

        // get wordsheet
        $accounts = Account::all();
        $worksheet = $templateSpreadsheet->getActiveSheet();

        // Process excel file content
        foreach ($accounts as $index => $account) {
            $rowData = [
                $account->code,
                $account->name,
                self::TYPE_MONTH,
                "1000000",
                Carbon::now()->format('d/m/Y'),
                Carbon::now()->format('d/m/Y'),
            ];

            // insert row to worksheet
            $rowIndex = $index + 2;
            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
        }

        // Output path
        $outputFileName = 'filtered_contacts.xlsx';
        $storagePath = storage_path('app/exports');
        $outputFilePath = $storagePath . '/' . $outputFileName;

        // Save the spreadsheet to the output file
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');
        $writer->save($outputFilePath);

        return $outputFilePath;
    }

    public static function uploadImportFile($request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx',
        ]);

        // validate
        if ($validator->fails()) {
            // remove null + errors
            return [null, $validator->errors()];
        }

        // file
        $file = $request->file('file');

        // uniq name
        $uniqueIdentifier = md5_file($file->path());

        // move file to tmp place
        $uploadedFile = $file->move(storage_path('app/tmp'), $uniqueIdentifier);

        // return path + empty errors
        return [$uploadedFile->getPathName(), collect([])];
    }

    public static function readFromExcelFile($path)
    {
        $spreadsheet = IOFactory::load($path);
        $worksheet = $spreadsheet->getActiveSheet();

        // 0: AccountCode
        // 1: AccountName
        // 2: TargetType (month|quarter)
        // 3: TargetAmount (VNĐ)
        // 4: StartAt (d/m/yyyy)
        // 5: EndAt (d/m/yyyy)
        $rows = $worksheet->toArray();

        // remove first header row
        array_shift($rows);

        // filter
        $rows = array_filter($rows, function ($row) {
            // have all values
            $valid = isset($row[0]) && isset($row[1]) && isset($row[2]) && isset($row[3]) && isset($row[4]) && isset($row[5]);

            // is valid account code
            $valid = $valid && Account::findByCode($row[0]);

            //
            return $valid;
        });

        // array mapping
        $rows = collect(array_map(function ($row) {
            $account = Account::findByCode($row[0]);

            // new KpiTarget
            $kpiTarget = self::newDefault();

            $kpiTarget->fillAttributes([
                'account_id' => $account->id,
                'type' => $row[2],
                'amount' => $row[3],
                'start_at' => Carbon::createFromFormat('d/m/Y', $row[4]),
                'end_at' => Carbon::createFromFormat('d/m/Y', $row[5]),
            ]);

            return $kpiTarget;
        }, $rows));

        return $rows;
    }

    public static function scopeByType($query, $type)
    {
        $query->where('type', $type);
    }

    public static function scopeStartAt($query, $startAt)
    {
        $query->where('start_at', '>=', Carbon::parse($startAt)->startOfDay());
    }

    public static function scopeEndAt($query, $endAt)
    {
        $query->where('end_at', '<=', Carbon::parse($endAt)->endOfDay());
    }

    public static function scopeInTimeRange($query, $startAt, $endAt)
    {
        $query->where('start_at', '>', Carbon::parse($startAt)->startOfDay())
                ->where('end_at', '<', Carbon::parse($endAt)->endOfDay());
    }

    public static function scopeByAccountIds($query, $accountIds)
    {
        $query->whereIn('account_id', $accountIds);
    }
    
    public static function getAccountKpiByMonth($account, $from_date)
    {
        return self::where('account_id', $account)
            ->where('type', self::TYPE_MONTH)
            ->whereNotNull('start_at') // Chắc chắn rằng start_at không null
            ->whereMonth('start_at', '=', Carbon::parse($from_date)->month)
            ->sum('amount');
    }

  
    public function calculateKPI( $startDate, $endDate)
    {
        $totalKPI = 0;
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

      
        $startAt = Carbon::parse($this->start_at);
        $endAt = Carbon::parse($this->end_at);

        $overlapStart = $startAt->max($startDate);
        $overlapEnd = $endAt->min($endDate);

        $overlapDays = $overlapStart->diffInDays($overlapEnd) ;

        if ($overlapDays > 0) {
            $totalKpiTargetDays = $startAt->diffInDays($endAt) ;

            $dailyKPI = $this->amount / $totalKpiTargetDays;
            $totalKPI += $dailyKPI * $overlapDays;
        }
        return $totalKPI;
    }

    // public static function getAccountKpiByMonth($account, $from_date)
    // {
    //     // Bắt đầu query với điều kiện cơ bản
    //     $query = self::where('account_id', $account)
    //         ->where('type', self::TYPE_MONTH);

    //     // Kiểm tra xem có lựa chọn ngày không
    //     if ($from_date) {
    //         // Nếu có lựa chọn ngày, thêm điều kiện vào query
    //         $query->whereBetween('start_at', [$from_date]);
    //     } else {
    //         // Nếu không có lựa chọn ngày, không áp dụng điều kiện
    //         $query->whereRaw('1 = 1');
    //     }

    //     // Tính tổng số KPI và trả về kết quả
    //     return $query->sum('amount');
    // }

    // public static function getAccountKpiByMonth($account, $from_date, $startAtFilter = null, $endAtFilter = null, $accountIdsFilter = null)
    // {
    //     $query = self::where('account_id', $account)
    //         ->where('type', self::TYPE_MONTH)
    //         ->whereNotNull('start_at')
    //         ->whereMonth('start_at', '=', Carbon::parse($from_date)->month);

    //     if ($startAtFilter) {
    //         $query->where('start_at', '>=', $startAtFilter);
    //     }

    //     if ($endAtFilter) {
    //         $query->where('start_at', '<=', $endAtFilter);
    //     }

    //     if ($accountIdsFilter) {
    //         $query->whereIn('account_id', $accountIdsFilter);
    //     }

    //     return $query->sum('amount');
    // }

    public static function getAccountKpiLuyKeQuy($account, $to_date)
    {
        return self::where('account_id', $account)
            ->where('type', self::TYPE_QUARTER)
            ->whereMonth('start_at', '<=', Carbon::parse($to_date)->month)
            ->sum('amount');
    }

    public static function getAccountKpiLuyKeNam($account, $to_date)
    {
        return self::where('account_id', $account)
            ->where('type', self::TYPE_MONTH)
            ->whereMonth('start_at', '<=', Carbon::parse($to_date)->month)
            ->sum('amount');
    }
    public static function scopeByBranch($query, $branch)
    {
        return $query->whereHas('account', function ($subquery) use ($branch) {
            if ($branch !== \App\Library\Branch::BRANCH_ALL) {
                $subquery->where('branch', $branch);
            }
        });
    }
}
