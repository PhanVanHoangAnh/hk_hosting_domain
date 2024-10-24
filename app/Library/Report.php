<?php

namespace App\Library;

use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class Report
{
    public static function exportExcel($templateSpreadsheet, $xColumns, $yColumns, $datas, $xTotal, $yTotal, $total, $data_1, $xTotal_1, $yTotal_1, $total_1, $data_2, $xTotal_2, $yTotal_2, $total_2)
    {
        if ($data_1 !== null && $data_2 !== null) {
            $worksheet = $templateSpreadsheet->getActiveSheet();
            $rowIndex = 1;
            $columnIndex = 'A';
            // Di chuyển sang cột tiếp theo sau cột thứ 2
            $columnIndex = Coordinate::stringFromColumnIndex(Coordinate::columnIndexFromString($columnIndex) + 1);
            foreach ($xColumns as $xColumn) {
                // Ghi giá trị vào cột hiện tại
                $worksheet->setCellValue($columnIndex . $rowIndex, $xColumn['text']);

                // Merge 3 ô liên tiếp cho giá trị text
                $endColumnIndex = Coordinate::stringFromColumnIndex(Coordinate::columnIndexFromString($columnIndex) + 2);
                $mergeRange = $columnIndex . $rowIndex . ':' . $endColumnIndex . $rowIndex;
                $worksheet->mergeCells($mergeRange);

                // Lấy style của ô và thiết lập căn giữa
                $style = $worksheet->getStyle($columnIndex . $rowIndex);
                $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Di chuyển sang cột thứ 2 để giữ giá trị của cột thứ 2
                $columnIndex = Coordinate::stringFromColumnIndex(Coordinate::columnIndexFromString($endColumnIndex) + 1);
            }
            // Merge 3 ô liên tiếp cho giá trị text
            $endColumnIndex = Coordinate::stringFromColumnIndex(Coordinate::columnIndexFromString($columnIndex) + 2);
            $mergeRange = $columnIndex . $rowIndex . ':' . $endColumnIndex . $rowIndex;
            $worksheet->mergeCells($mergeRange);
            // Lấy style của ô và thiết lập căn giữa
            $style = $worksheet->getStyle($columnIndex . $rowIndex);
            $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            // Ghi giá trị "Tổng cộng" vào cột mới sau khi đã merge

            $worksheet->setCellValue($columnIndex . $rowIndex, 'Tổng cộng');
            $rowIndex++;
            $nameColumns = [''];
            for ($i = 0; $i <= count($xColumns); $i++) {
                $nameColumns[] = 'Hợp đồng';
                $nameColumns[] = 'Nhu Cầu';
                $nameColumns[] = 'Tỷ lệ CĐ';
            }
            $worksheet->fromArray([$nameColumns], null, 'A' . $rowIndex);
            $rowIndex++;
            foreach ($yColumns as $yColumn) {
                $tempRow = []; // Mảng tạm thời để lưu thông tin của mỗi dòng

                $tempRow[] = $yColumn['text']; // Thêm thông tin của yColumn vào mảng tạm thời

                // Duyệt qua mỗi phần tử trong datas để lấy giá trị tương ứng với yColumn
                foreach ($datas as $key => $data) {
                    $tempRow[] = $data_2[$key][$yColumn['value']];
                    $tempRow[] = $data_1[$key][$yColumn['value']];
                    $tempRow[] = $data[$yColumn['value']];
                }


                $tempRow[] = $yTotal_2[$yColumn['value']]; // Thêm thông tin của yTotal vào mảng tạm thời
                $tempRow[] = $yTotal_1[$yColumn['value']];
                $tempRow[] = $yTotal[$yColumn['value']];
                $worksheet->fromArray([$tempRow], null, 'A' . $rowIndex);
                $rowIndex++;
            }
            $tempRow = [];
            $tempRow[] = 'Tổng cộng';

            // Duyệt qua mỗi phần tử trong datas để lấy giá trị tương ứng với yColumn
            foreach ($xTotal as $key => $xTotal) {
                $tempRow[] = $xTotal_2[$key];
                $tempRow[] = $xTotal_1[$key];
                $tempRow[] = $xTotal;
            }
            $tempRow[] = $total_2;
            $tempRow[] = $total_1;
            $tempRow[] = $total;


            $worksheet->fromArray([$tempRow], null, 'A' . $rowIndex);
            $rowIndex++;
        } else {
            $worksheet = $templateSpreadsheet->getActiveSheet();
            $rowIndex = 1;

            $rowData = [''];
            foreach ($xColumns as  $xColumn) {
                // Date formatting
                // Lấy giá trị từ 'text' và thêm vào $rowData
                $rowData[] = $xColumn['text'];
            }
            $rowData[] = 'Tổng cộng';
            $worksheet->fromArray([$rowData], null, 'A' . $rowIndex);
            $rowIndex++;
            // Duyệt qua mỗi yColumn
            foreach ($yColumns as $yColumn) {
                $tempRow = []; // Mảng tạm thời để lưu thông tin của mỗi dòng

                $tempRow[] = $yColumn['text']; // Thêm thông tin của yColumn vào mảng tạm thời

                // Duyệt qua mỗi phần tử trong datas để lấy giá trị tương ứng với yColumn
                foreach ($datas as $data) {
                    $tempRow[] = $data[$yColumn['text']];
                }

                $tempRow[] = $yTotal[$yColumn['text']]; // Thêm thông tin của yTotal vào mảng tạm thời

                $worksheet->fromArray([$tempRow], null, 'A' . $rowIndex);
                $rowIndex++;
            }
            $temp = [];
            $temp[] = 'Tổng cộng';
            foreach ($xTotal as $xTotal) {
                $temp[] = $xTotal;
            }
            $temp[] = $total;
            $worksheet->fromArray([$temp], null, 'A' . $rowIndex);
            $rowIndex++;
        }
    }
    
    public static function getMarketingReport($xType, $yType, $dataType, $filterType)
    {
        $report = [
            'xColumns' => [],
            'yColumns' => [],
            'data' => [],
            'total' => 0,
            'xTotal' => [],
            'yTotal' => [],

            'data_1' => [],
            'total_1' => 0,
            'xTotal_1' => [],
            'yTotal_1' => [],

            'data_2' => [],
            'total_2' => 0,
            'xTotal_2' => [],
            'yTotal_2' => [],
        ];

        // Lấy danh sách giá trị của x columns
        $report['xColumns'] = self::getColumnsByType($xType);
        $report['yColumns'] = self::getColumnsByType($yType);

        // data
        foreach ($report['xColumns'] as $xColumn) {
            $report['data'][$xColumn['value']] = [];

            foreach ($report['yColumns'] as $yColumn) {
                // new contact count
                if ($dataType == 'new_contact') {
                    $report['data'][$xColumn['value']][$yColumn['value']] = self::getNewContactCount($xType, $yType, $xColumn, $yColumn, $filterType);
                } else if ($dataType == 'new_customer') {
                    $report['data_2'][$xColumn['value']][$yColumn['value']] = self::getNewContactRequestHasOrderCount($xType, $yType, $xColumn, $yColumn, $filterType);
                    $report['data_1'][$xColumn['value']][$yColumn['value']] = self::getNewContactRequestCount($xType, $yType, $xColumn, $yColumn, $filterType);
                    if ($report['data_2'][$xColumn['value']][$yColumn['value']] !== 0) {
                        $data_percentage = round(($report['data_2'][$xColumn['value']][$yColumn['value']] / $report['data_1'][$xColumn['value']][$yColumn['value']]) * 100, 2);
                        $report['data'][$xColumn['value']][$yColumn['value']] = $data_percentage . '%';
                    } else {
                        // Xử lý trường hợp nếu mẫu số là 0
                        $report['data'][$xColumn['value']][$yColumn['value']] = 0 . '%';
                    }
                } else {
                    throw new \Exception('Tại sao lại không có typr này:' . $dataType);
                }
            }
        }
        if ($dataType == 'new_contact') {
            // x total

            foreach ($report['xColumns'] as $xColumn) {
                $report['xTotal'][$xColumn['value']] = 0;
                foreach ($report['yColumns'] as $yColumn) {
                    $report['xTotal'][$xColumn['value']] += $report['data'][$xColumn['value']][$yColumn['value']];
                }
            }

            // y total
            foreach ($report['yColumns'] as $yColumn) {
                $report['yTotal'][$yColumn['value']] = 0;
                foreach ($report['xColumns'] as $xColumn) {
                    $report['yTotal'][$yColumn['value']] += $report['data'][$xColumn['value']][$yColumn['value']];
                }
            }

            // total
            foreach ($report['yColumns'] as $yColumn) {
                foreach ($report['xColumns'] as $xColumn) {
                    $report['total'] += $report['data'][$xColumn['value']][$yColumn['value']];
                }
            }
        } else if ($dataType == 'new_customer') {
            // x total_1
            foreach ($report['xColumns'] as $xColumn) {
                $report['xTotal_1'][$xColumn['value']] = 0;
                foreach ($report['yColumns'] as $yColumn) {
                    $report['xTotal_1'][$xColumn['value']] += $report['data_1'][$xColumn['value']][$yColumn['value']];
                }
            }
            // y total_1
            foreach ($report['yColumns'] as $yColumn) {
                $report['yTotal_1'][$yColumn['value']] = 0;
                foreach ($report['xColumns'] as $xColumn) {
                    $report['yTotal_1'][$yColumn['value']] += $report['data_1'][$xColumn['value']][$yColumn['value']];
                }
            }
            // total_1
            foreach ($report['yColumns'] as $yColumn) {
                foreach ($report['xColumns'] as $xColumn) {
                    $report['total_1'] += $report['data_1'][$xColumn['value']][$yColumn['value']];
                }
            }
            // x total_2
            foreach ($report['xColumns'] as $xColumn) {
                $report['xTotal_2'][$xColumn['value']] = 0;
                foreach ($report['yColumns'] as $yColumn) {
                    $report['xTotal_2'][$xColumn['value']] += $report['data_2'][$xColumn['value']][$yColumn['value']];
                }
            }

            // y total_2
            foreach ($report['yColumns'] as $yColumn) {
                $report['yTotal_2'][$yColumn['value']] = 0;
                foreach ($report['xColumns'] as $xColumn) {
                    $report['yTotal_2'][$yColumn['value']] += $report['data_2'][$xColumn['value']][$yColumn['value']];
                }
            }

            // total_2
            foreach ($report['yColumns'] as $yColumn) {
                foreach ($report['xColumns'] as $xColumn) {
                    $report['total_2'] += $report['data_2'][$xColumn['value']][$yColumn['value']];
                }
            }
            //xTotal
            foreach ($report['xColumns'] as $xColumn) {
                $report['xTotal'][$xColumn['value']] = 0;
                foreach ($report['yColumns'] as $yColumn) {

                    if ($report['xTotal_1'][$xColumn['value']] !== 0) {

                        $xTotal_percentage = round(($report['xTotal_2'][$xColumn['value']] / $report['xTotal_1'][$xColumn['value']]) * 100, 2);
                        $report['xTotal'][$xColumn['value']] =  $xTotal_percentage . '%';
                    } else {
                        // Xử lý trường hợp nếu mẫu số là 0
                        $report['xTotal'][$xColumn['value']] = 0 . '%';
                    }
                }
            }

            // y total
            foreach ($report['yColumns'] as $yColumn) {
                $report['yTotal'][$yColumn['value']] = 0;
                foreach ($report['xColumns'] as $xColumn) {
                    if ($report['yTotal_1'][$yColumn['value']] !== 0) {
                        $yTotal_percentage = round(($report['yTotal_2'][$yColumn['value']] / $report['yTotal_1'][$yColumn['value']]) * 100, 2);
                        $report['yTotal'][$yColumn['value']] = $yTotal_percentage . '%';
                    } else {
                        // Xử lý trường hợp nếu mẫu số là 0
                        $report['yTotal'][$yColumn['value']] = 0 . '%';
                    }
                }
            }

            // total
            foreach ($report['yColumns'] as $yColumn) {
                foreach ($report['xColumns'] as $xColumn) {
                    if ($report['total_1'] !== 0) {
                        $total_percentage = round(($report['total_2'] /  $report['total_1']) * 100, 2);
                        $report['total'] =  $total_percentage . '%';
                    } else {
                        // Xử lý trường hợp nếu mẫu số là 0
                        $report['total'] = 0 . '%';
                    }
                }
            }
        }

        return $report;
    }

    public static function scopeFilterByCreatedAt($query, $created_at_from, $created_at_to)
    {
        if (!empty($created_at_from) && !empty($created_at_to)) {
            return $query->whereBetween('created_at', [$created_at_from, \Carbon\Carbon::parse($created_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function scopeFilterByUpdatedAt($query, $updated_at_from, $updated_at_to)
    {
        if (!empty($updated_at_from) && !empty($updated_at_to)) {
            return $query->whereBetween('updated_at', [$updated_at_from, \Carbon\Carbon::parse($updated_at_to)->endOfDay()]);
        }

        return $query;
    }

    public static function getColumnsByType($type)
    {
        switch ($type) {
            case 'lead_status':
                return array_map(function ($item) {
                    return [
                        'text' => $item,
                        'value' => $item,
                    ];
                }, config('leadStatuses'));
                break;
            case 'source_type':
                return array_map(function ($item) {
                    return [
                        'text' => $item,
                        'value' => $item,
                    ];
                }, config('sourceTypeValue'));
                break;
            case 'channel':
                return array_map(function ($item) {
                    return [
                        'text' => $item,
                        'value' => $item,
                    ];
                }, config('marketingSources'));
                break;
            case 'sales':
                return \App\Models\Account::sales()->get()->map(function ($account) {
                    return [
                        'text' => $account->name,
                        'value' => $account->id,
                    ];
                })->toArray();
                break;
            case 'school':
                $schools = \App\Models\ContactRequest::pluck('school')->toArray();
                $schools = array_unique($schools);

                $schools = array_filter($schools, function ($item) {
                    return $item !== null;
                });
                $schools = array_values($schools);
                return array_map(function ($item) {
                    return [
                        'text' => $item,
                        'value' => $item,
                    ];
                }, $schools);
                break;
            case 'list':
                $lists = \App\Models\ContactRequest::pluck('list')->toArray();
                $lists = array_unique($lists);
                $lists = array_values($lists);
                $lists = array_filter($lists, function ($item) {
                    return $item !== null;
                });
                return array_map(function ($item) {
                    return [
                        'text' => $item,
                        'value' => $item,
                    ];
                }, $lists);
                break;
            case 'pic':
                $pics = \App\Models\ContactRequest::pluck('pic')->toArray();
                $pics = array_unique($pics);
                $pics = array_values($pics);
                $pics = array_filter($pics, function ($item) {
                    return $item !== null;
                });
                return array_map(function ($item) {
                    return [
                        'text' => $item,
                        'value' => $item,
                    ];
                }, $pics);
                break;
            case 'type_match':
                $type_matchs = \App\Models\ContactRequest::pluck('type_match')->toArray();
                $type_matchs = array_unique($type_matchs);
                $type_matchs = array_values($type_matchs);
                $type_matchs = array_filter($type_matchs, function ($item) {
                    return $item !== null;
                });
                return array_map(function ($item) {
                    return [
                        'text' => $item,
                        'value' => $item,
                    ];
                }, $type_matchs);
                break;
            case 'birthday':
                $birthdays = \App\Models\ContactRequest::pluck('birthday')->toArray();
                $birthdays = array_unique($birthdays);
                $birthdays = array_values($birthdays);
                $birthdays = array_filter($birthdays, function ($item) {
                    return !is_null($item);
                });

                sort($birthdays);
                // $years = array_map(function ($age) {
                //     $parts = explode('-', $age);
                //     return $parts[0];
                // }, $ages);
                // $years = array_unique($years);
                // sort($ages);
                return array_map(function ($birthdays) {
                    return [
                        'text' => $birthdays,
                        'value' => $birthdays,
                    ];
                }, $birthdays);
                break;
            case 'age':
                $ages = \App\Models\ContactRequest::pluck('age')->toArray();
                $ages = array_unique($ages);
                $ages = array_values($ages);
                $ages = array_filter($ages, function ($item) {
                    return !is_null($item);
                });

                sort($ages);
                // $years = array_map(function ($age) {
                //     $parts = explode('-', $age);
                //     return $parts[0];
                // }, $ages);
                // $years = array_unique($years);
                // sort($ages);
                return array_map(function ($ages) {
                    return [
                        'text' => $ages,
                        'value' => $ages,
                    ];
                }, $ages);
                break;
            case 'campaign':
                $campaigns = \App\Models\ContactRequest::pluck('campaign')->toArray();
                $campaigns = array_unique($campaigns);
                $campaigns = array_values($campaigns);
                $campaigns = array_filter($campaigns, function ($item) {
                    return $item !== null;
                });
                return array_map(function ($item) {
                    return [
                        'text' => $item,
                        'value' => $item,
                    ];
                }, $campaigns);
                break;
            case 'adset':
                $adsets = \App\Models\ContactRequest::pluck('adset')->toArray();
                $adsets = array_unique($adsets);
                $adsets = array_values($adsets);
                $adsets = array_filter($adsets, function ($item) {
                    return $item !== null;
                });
                return array_map(function ($item) {
                    return [
                        'text' => $item,
                        'value' => $item,
                    ];
                }, $adsets);
                break;
            case 'device':
                $devices = \App\Models\ContactRequest::pluck('device')->toArray();
                $devices = array_unique($devices);
                $devices = array_values($devices);
                $devices = array_filter($devices, function ($item) {
                    return $item !== null;
                });
                return array_map(function ($item) {
                    return [
                        'text' => $item,
                        'value' => $item,
                    ];
                }, $devices);
                break;
            case 'term':
                $terms = \App\Models\ContactRequest::pluck('term')->toArray();
                $terms = array_unique($terms);
                $terms = array_values($terms);
                $terms = array_filter($terms, function ($item) {
                    return $item !== null;
                });
                return array_map(function ($item) {
                    return [
                        'text' => $item,
                        'value' => $item,
                    ];
                }, $terms);
                break;
            case 'ads':
                $adses = \App\Models\ContactRequest::pluck('ads')->toArray();
                $adses = array_unique($adses);
                $adses = array_values($adses);
                $adses = array_filter($adses, function ($item) {
                    return $item !== null;
                });
                return array_map(function ($item) {
                    return [
                        'text' => $item,
                        'value' => $item,
                    ];
                }, $adses);
                break;
            case 'placement':
                $placements = \App\Models\ContactRequest::pluck('placement')->toArray();
                $placements = array_unique($placements);
                $placements = array_values($placements);
                $placements = array_filter($placements, function ($item) {
                    return $item !== null;
                });
                return array_map(function ($item) {
                    return [
                        'text' => $item,
                        'value' => $item,
                    ];
                }, $placements);
                break;
            default:
                throw new \Exception("Không tìm thấy loại giá trị: {$type}");
        };
    }

    public static function getNewContactCount($xType, $yType, $xColumn, $yColumn, $filterType)
    {
        $query = \App\Models\ContactRequest::query();

        $query = self::filterContactByType($query, $xType, $xColumn);
        $query = self::filterContactByType($query, $yType, $yColumn);
        $query = self::filterContactByFilter($query, $filterType);

        return $query->count();
    }

    public static function getNewContactRequestHasOrderCount($xType, $yType, $xColumn, $yColumn, $filterType)
    {
        $query = \App\Models\ContactRequest::has('orders')->get();

        $query = self::filterContactByType($query, $xType, $xColumn);
        $query = self::filterContactByType($query, $yType, $yColumn);
        $query = self::filterContactByFilter($query, $filterType);

        return $query->count();
    }

    public static function getNewContactRequestCount($xType, $yType, $xColumn, $yColumn, $filterType)
    {
        $query = \App\Models\ContactRequest::query();

        $query = self::filterContactByType($query, $xType, $xColumn);
        $query = self::filterContactByType($query, $yType, $yColumn);
        $query = self::filterContactByFilter($query, $filterType);

        return $query->count();
    }

    public static function filterContactByFilter($query, $filterType)
    {
        // fitlers by create_at
        if (isset($filterType['created_at_from']) && isset($filterType['created_at_to'])) {
            $created_at_from = $filterType['created_at_from'];
            $created_at_to = $filterType['created_at_to'];
            $query  = $query->filterByCreatedAt($created_at_from, $created_at_to);
        }
        // Filter by updated_at
        if (isset($filterType['updated_at_from']) && isset($filterType['updated_at_to'])) {
            $updated_at_from = $filterType['updated_at_from'];
            $updated_at_to = $filterType['updated_at_to'];
            $query  = $query->filterByCreatedAt($updated_at_from, $updated_at_to);
        }
        if (isset($filterType['channel'])) {
            $query = $query->where('channel', $filterType['channel']);
        }
        if (isset($filterType['sub_channel'])) {
            $query = $query->where('sub_channel', $filterType['sub_channel']);
        }
        if (isset($filterType['lifecycle_stage'])) {
            $query = $query->where('lifecycle_stage', $filterType['lifecycle_stage']);
        }
        if (isset($filterType['lead_status'])) {
            $query = $query->where('lead_status', $filterType['lead_status']);
        }
        if (isset($filterType['source_type'])) {
            $query = $query->where('source_type', $filterType['source_type']);
        }
        return $query;
    }

    public static function filterContactByType($query, $type, $column)
    {
        switch ($type) {
            case 'lead_status':
                $query = $query->where('lead_status', $column['value']);
                break;
            case 'channel':
                $query = $query->where('channel', $column['value']);
                break;
            case 'sales':
                $query = $query->where('account_id', $column['value']);
                break;
            case 'school':
                $query = $query->where('school', $column['value']);
                break;
            case 'list':
                $query = $query->where('list', $column['value']);
                break;
            case 'pic':
                $query = $query->where('pic', $column['value']);
                break;
            case 'type_match':
                $query = $query->where('type_match', $column['value']);
                break;
            case 'birthday':
                $query = $query->where('birthday', $column['value']);
                break;
            case 'age':
                $query = $query->where('age', $column['value']);
                break;
            case 'campaign':
                $query = $query->where('campaign', $column['value']);
                break;
            case 'adset':
                $query = $query->where('adset', $column['value']);
                break;
            case 'device':
                $query = $query->where('device', $column['value']);
                break;
            case 'term':
                $query = $query->where('term', $column['value']);
                break;
                break;
            case 'ads':
                $query = $query->where('ads', $column['value']);
                break;
            case 'placement':
                $query = $query->where('placement', $column['value']);
                break;
            case 'source_type':
                $query = $query->where('source_type', $column['value']);
                break;

            default:
                throw new \Exception("Không tìm thấy loại giá trị: {$type}");
        };

        return $query;
    }
}
