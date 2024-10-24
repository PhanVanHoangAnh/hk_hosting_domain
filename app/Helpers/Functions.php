<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Functions
{
    public static function formatNumber($number, $decimals = 0)
    {
        // Check if the number is already rounded to 0 decimal places
        if ($number == round($number)) {
            // The number is already rounded
            $decimals = 0;
        }

        return number_format($number, $decimals, ".", ",");
    }

    public static function getRelationshipOptions()
    {
        return [
            ['value' => \App\Models\Relationship::TYPE_FATHER, 'text' => 'Cha'],
            ['value' => \App\Models\Relationship::TYPE_MOTHER, 'text' => 'Mẹ'],
            ['value' => \App\Models\Relationship::TYPE_OTHER, 'text' => 'Khác...'],
        ];
    }

    public static function getDistrictsByCity($name)
    {
        $districts = [];
        $cities = config('cities');

        foreach ($cities as $city) {
            if ($city['Name'] == $name) {
                $districts = $city['Districts'];
            }
        }

        return $districts;
    }

    public static function getWardsByCityDistrict($cityName, $districtName)
    {
        $wards = [];
        $districts = self::getDistrictsByCity($cityName);

        foreach ($districts as $district) {
            if ($district['Name'] == $districtName) {
                $wards = $district['Wards'];
            }
        }

        return $wards;
    }

    public static function campareEmails($email1, $email2)
    {
        return trim(strtolower($email1)) == trim(strtolower($email2));
    }

    public static function camparePhones($phone1, $phone2)
    {
        return trim(strtolower($phone1)) == trim(strtolower($phone2));
    }

    public static function isValidPhoneNumber($phoneNumber)
    {
        // Remove any non-digit characters from the phone number
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        // Check if the phone number has the expected length (adjust as needed)
        if (strlen($phoneNumber) >= 10 && strlen($phoneNumber) <= 15) {
            return true;
        } else {
            return false;
        }
    }

    public static function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function columnsFromListView($columns, $listView)
    {
        // do nothing if list view is not found
        if (!$listView) {
            return $columns;
        }

        // 
        $saveColumnIds = $listView; // for now, list view is column ids array

        // checked if showed
        foreach ($columns as $key => $column) {
            if (in_array($column['id'], $saveColumnIds)) {
                $columns[$key]['checked'] = true;
            } else {
                $columns[$key]['checked'] = false;
            }
        }

        //
        return self::sortObjectArrayWithIdArray($columns, $saveColumnIds);
    }

    public static function sortObjectArrayWithIdArray($objects, $sortedOrder)
    {
        // Use usort with the custom sorting function
        usort($objects, function ($a, $b) use ($sortedOrder) {
            $keyA = array_search($a['id'], $sortedOrder);
            $keyB = array_search($b['id'], $sortedOrder);

            // If both elements are in the sorted order, compare their positions
            if ($keyA !== false && $keyB !== false) {
                return $keyA - $keyB;
            }

            // If only one element is in the sorted order, prioritize it
            if ($keyA !== false) {
                return -1;
            } elseif ($keyB !== false) {
                return 1;
            }

            // If neither element is in the sorted order, maintain their relative order
            return 0;
        });

        // Output the sorted array
        return $objects;
    }

    public static function base64urlEncode($s)
    {
        return str_replace(array('+', '/'), array('-', '_'), base64_encode($s));
    }

    public static function base64urlDecode($s)
    {
        return base64_decode(str_replace(array('-', '_'), array('+', '/'), $s));
    }

    /**
     * Convert price in mask to float number
     */
    public static function convertStringPriceToNumber($strPrice)
    {
        if (is_numeric($strPrice) && floatval($strPrice) > 0) {
            return floatval($strPrice);
        }

        if (!is_string($strPrice)) return 0;

        $cleanStr = str_replace(array(',', '.'), '', $strPrice);
        $floatNum = floatval($cleanStr);

        return $floatNum;
    }

    public static function removeSpecialsCharacterFromString($str)
    {
        return strtolower(preg_replace('/[^\w]/', '', $str));
    }

    public static function calculatePercentage($count, $total, $decimals=0)
    {
        return $total != 0 ? round(($count / max($total, 1)) * 100, $decimals) : 0;
    }

    public static function getNotificationUrl($notification)
    {
        switch ($notification->type) {
            case 'App\Notifications\SendContactRequestsAssigned':
                return action([\App\Http\Controllers\Sales\ContactRequestController::class, 'index']);
            case 'App\Notifications\ApproveHSDTNotification':
                return action([\App\Http\Controllers\Abroad\AbroadController::class, 'index']);
            case 'App\Notifications\Attendance':
                return action([\App\Http\Controllers\Sales\ContactRequestController::class, 'index']);
            // case 'App\Notifications\SendContactRequestsAssigned':
            //     return action([\App\Http\Controllers\Sales\ContactRequestController::class, 'index']);
            // case 'App\Notifications\SendContactRequestsAssigned':
            //     return action([\App\Http\Controllers\Sales\ContactRequestController::class, 'index']);
            // case 'App\Notifications\SendContactRequestsAssigned':
            //     return action([\App\Http\Controllers\Sales\ContactRequestController::class, 'index']);
            // case 'App\Notifications\SendContactRequestsAssigned':
            //     return action([\App\Http\Controllers\Sales\ContactRequestController::class, 'index']);
            // case 'App\Notifications\SendContactRequestsAssigned':
            //     return action([\App\Http\Controllers\Sales\ContactRequestController::class, 'index']);
        }

        return null;
    }

    public static function processVarchar250Input($string)
    {
        return Str::limit($string ?? '', 250);
    }

    public static function calculateExpiredAt($assignedAt) {
        $startHour = 8; // 6:00 AM
        $endHour = 20;  // 8:00 PM
        $hours = 2;

        // $assignedAt = Carbon::parse($assignedAt);
        $expiredAt = $assignedAt->copy();
        
        $workingHoursToAdd = $hours + 1;
        
        // reset minute if out of work hour
        if ($assignedAt->hour < $startHour || $assignedAt->hour >= $endHour) {
            $expiredAt->hour($startHour)->minute(0)->second(0);
        }

        while ($workingHoursToAdd > 0) {
            $currentHour = $expiredAt->hour;
            
            if ($currentHour >= $startHour && $currentHour < $endHour) {
                $workingHoursToAdd--;
                if ($workingHoursToAdd > 0) {
                    $expiredAt->addHour();
                }
            } else {
                // If we're outside of working hours, jump to the next working day start time
                if ($currentHour >= $endHour) {
                    $expiredAt->addHours(24 - $expiredAt->hour + $startHour);
                } else if ($currentHour < $startHour) {
                    $expiredAt->hour($startHour)->minute(0)->second(0);
                }
            }
        }

        return $expiredAt;
    }

    public static function getParamsFromUrl($url)
    {
        $queryParams = [];
        
        // Parse the URL and retrieve the query string
        $parsedUrl = parse_url($url);
        if (isset($parsedUrl['query'])) {
            // Parse the query string into an associative array
            parse_str($parsedUrl['query'], $queryParams);
        }
    
        return $queryParams;
    }

    public static function getChannelBySubChannel($subChannel) {
        $sourceTypeImport = config('sourceTypeImport'); // Giả định cấu hình được trả về bởi hàm config
        $channelMapping = [];
    
        // Duyệt qua cấu hình để xây dựng bảng ánh xạ
        foreach ($sourceTypeImport as $channelsArray) {
            foreach ($channelsArray as $sourceType => $channels) {
                foreach ($channels as $channel => $subChannels) {
                    foreach ($subChannels as $subChannelName) {
                        $channelMapping[trim($subChannelName)] = [
                            'channel' => $channel,
                            'source_type' => $sourceType
                        ];
                    }
                }
            }
        }
    
        // Tra cứu ánh xạ từ sub_channel đầu vào
        if (isset($channelMapping[trim($subChannel)])) {
            $mapping = $channelMapping[trim($subChannel)];
            return [
                'channel' => $mapping['channel'],
                'source_type' => $mapping['source_type']
            ];
        } else {
            throw new \Exception("Sub-channel [$subChannel] not found in configuration");
        }
    }

    public static function getJsSourceTypes(): array
    {
        $datas = config('sourceTypeImport');

        return array_map(function($data) {
            return [
                'itemType' => 'channel',
                'name' => array_keys($data)[0],
                'itemKey' => array_keys($data)[0],
                // 'values' => $data[array_keys($data)[0]],
                'values' => array_map(function($subChannels, $channel) {
                    return [
                        'itemType' => 'subChannel',
                        'name' => $channel,
                        'itemKey' => $channel,
                        'values' => $subChannels,
                    ];
                }, $data[array_keys($data)[0]], array_keys($data[array_keys($data)[0]]))
            ];
        }, $datas);
    }

    public static function convertMinutesToHours($totalMinutes)
    {
        $hours = $totalMinutes / 60;

        return number_format($hours, 1) . ' giờ';
    }

    public static function leadStatusMapping($string)
    {
        $mapping = [
            \App\Models\ContactRequest::LS_ERROR => [
                trans('messages.contact_request.lead_status.' . \App\Models\ContactRequest::LS_ERROR),
                'Sai số, không có nhu cầu',
                'Sai số/ Không có nhu cầu',
                'F-Sai Số',
                'F-Sai số/ Không có nhu cầu',
                'Không có nhu cầu',
                'Không có đơn hàng',
                'ễn Thị Thanh Bình',
            ],
            \App\Models\ContactRequest::LS_NOT_PICK_UP => [
                trans('messages.contact_request.lead_status.' . \App\Models\ContactRequest::LS_NOT_PICK_UP),
                'Không nghe máy, gọi lại sau',
            ],
            \App\Models\ContactRequest::LS_NOT_PICK_UP_MANY_TIMES => [
                trans('messages.contact_request.lead_status.' . \App\Models\ContactRequest::LS_NOT_PICK_UP_MANY_TIMES),
                'Không nghe máy nhiều lần',
                'T-KNM nhiều lần',
            ],
            \App\Models\ContactRequest::LS_DUPLICATE_DATA => [
                trans('messages.contact_request.lead_status.' . \App\Models\ContactRequest::LS_DUPLICATE_DATA),
                'Trùng data',
                'F-Trùng Data',
            ],
            \App\Models\ContactRequest::LS_NOT_POTENTIAL => [
                trans('messages.contact_request.lead_status.' . \App\Models\ContactRequest::LS_NOT_POTENTIAL),
                'Chia lại (Không tiềm năng)',
                'Có nhu cầu nhưng không tiềm năng',
            ],
            \App\Models\ContactRequest::LS_HAS_REQUEST => [
                trans('messages.contact_request.lead_status.' . \App\Models\ContactRequest::LS_HAS_REQUEST),
                'Có nhu cầu, khai thác thêm',
                'Liên hệ',
                'Có nhu cầu, cần khai thác thêm'
            ],
            \App\Models\ContactRequest::LS_FOLLOW => [
                trans('messages.contact_request.lead_status.' . \App\Models\ContactRequest::LS_FOLLOW),
                'Follow dài',
            ],
            \App\Models\ContactRequest::LS_POTENTIAL => [
                trans('messages.contact_request.lead_status.' . \App\Models\ContactRequest::LS_POTENTIAL),
                'Tiềm năng',
            ],
            \App\Models\ContactRequest::LS_HAS_CONSTRACT => [
                trans('messages.contact_request.lead_status.' . \App\Models\ContactRequest::LS_HAS_CONSTRACT),
                'Khách hàng',
            ],
            \App\Models\ContactRequest::LS_MAKING_CONSTRACT => [
                trans('messages.contact_request.lead_status.' . \App\Models\ContactRequest::LS_MAKING_CONSTRACT),
            ],
            \App\Models\ContactRequest::LS_NOT_CALL_YET => [
                trans('messages.contact_request.lead_status.' . \App\Models\ContactRequest::LS_NOT_CALL_YET),
            ],
            \App\Models\ContactRequest::LS_DEPOSITED => [
                trans('messages.contact_request.lead_status.' . \App\Models\ContactRequest::LS_DEPOSITED),
            ],
            \App\Models\ContactRequest::LS_HAS_CONSTRACT_OUTSIDE_SYSTEM => [
                trans('messages.contact_request.lead_status.' . \App\Models\ContactRequest::LS_HAS_CONSTRACT_OUTSIDE_SYSTEM),
            ],
            \App\Models\ContactRequest::LS_NA => [
                trans('messages.contact_request.lead_status.' . \App\Models\ContactRequest::LS_NA),
            ],
        ];

        foreach ($mapping as $key => $values) {
            foreach ($values as $value) {
                if (trim($value) == trim($string)) {
                    return $key;
                }
            }
        }

        return null;
    }

    public static function normalizeString($string)
    {
        $string = preg_replace('/[ÀÁẢÃẠÂẤẦẪẬĂẮẰẴẶ]/u', 'A', $string);
        $string = preg_replace('/[àáảãạâấầẫậăắằẵặ]/u', 'a', $string);
        $string = preg_replace('/[ÉÈẼẸÊẾỀỄỆ]/u', 'E', $string);
        $string = preg_replace('/[éèẹẻẽêếềệểễ]/u', 'e', $string);
        $string = preg_replace('/[ÍÌĨỊ]/u', 'I', $string);
        $string = preg_replace('/[íìịỉĩ]/u', 'i', $string);
        $string = preg_replace('/[ÓÒÕỌÔỐỒỖỘƠỚỜỠỢ]/u', 'O', $string);
        $string = preg_replace('/[óòõọôốồỗộơớờỡợ]/u', 'o', $string);
        $string = preg_replace('/[ÚÙŨỤƯỨỪỮỰ]/u', 'U', $string);
        $string = preg_replace('/[úùũụưứừữự]/u', 'u', $string);
        $string = preg_replace('/[ÝỲỸỴ]/u', 'Y', $string);
        $string = preg_replace('/[ýỳỵỷỹ]/u', 'y', $string);
        $string = preg_replace('/Đ/u', 'D', $string);
        $string = preg_replace('/đ/u', 'd', $string);
        $string = preg_replace('/[\x{0300}\x{0301}\x{0303}\x{0309}\x{0323}]/u', '', $string);
        $string = preg_replace('/[\x{02C6}\x{0306}\x{031B}]/u', '', $string);
        $string = strtoupper($string);
        $string = preg_replace('/[^a-zA-Z0-9]/', '', $string);

        return $string;
    }

    public static function getSourceTypes()
    {
        $sourceTypes = [];
        foreach(config('sourceTypeImport') as $config) {
            $sourceTypes[] = array_keys($config)[0];
        }

        return $sourceTypes;
    }

    public static function logoutUser($userId)
    {
        \DB::table('sessions')->where('user_id', $userId)->delete();
    }

    public static function assetVersion()
    {
        return 26;
    }

    public static function hidePhoneNumber($phone) {
        // Check if the phone number is at least 8 digits long
        if (strlen($phone) >= 8) {
            // Replace middle digits with asterisks
            $phone = substr($phone, 0, 3) . '***' . substr($phone, -2);
        }
        return $phone;
    }
}
