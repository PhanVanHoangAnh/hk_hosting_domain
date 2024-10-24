<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;
use \Log;

class ZoomMeeting extends Model
{
    use HasFactory;

    public $client;
    public $jwt;
    public $headers;

    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;
    const PREFIX_LINK = 'https://api.zoom.us/v2';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://zoom.us',
            'timeout'  => 30.0, // Increase the timeout to 30 seconds
            'handler'  => $stack,
        ]);

        $this->accessToken = env('ZOOM_ACCESS_TOKEN');
        $this->headers = [
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];
    }

    public static function generateZoomAccessToken()
    {
        $account_id = env('ZOOM_ACCOUNT_ID');
        $apiKey = env('ZOOM_CLIENT_ID');
        $apiSecret = env('ZOOM_CLIENT_SECRET');
        $base64Credentials = base64_encode("$apiKey:$apiSecret");
        $url = 'https://zoom.us/oauth/token?grant_type=account_credentials&account_id=' . $account_id;
        
        $response = Http::withHeaders([
            'Authorization' => "Basic $base64Credentials",
            'Content-Type' => 'application/x-www-form-urlencoded',
            ])->timeout(60) // Total request timeout
              ->connectTimeout(30) // Connection timeout
              ->retry(3, 100) // Retry 3 times with 100ms delay between retries
              ->post($url);
            
        $responseData = $response->json();

        if (isset($responseData['access_token'])) {
            return $responseData['access_token'];
        } else {
            // Log or print the entire response for debugging purposes.
            \Log::error('Zoom OAuth Token Response: ' . json_encode($responseData));

            // Handle the error as needed.
            return null;
        }
    }

    private function retrieveZoomUrl()
    {
        return env('ZOOM_API_URL', '');
    }

    public function toZoomTimeFormat(string $dateTime)
    {
        try {
            $date = new \DateTime($dateTime);

            return $date->format('Y-m-d\TH:i:s');
        } catch (\Exception $e) {
            Log::error('ZoomJWT->toZoomTimeFormat : ' . $e->getMessage());

            return '';
        }
    }

    /**
     * Create a ZOOM meeting with this account owner(me)
     */
    public static function create($data)
    {
        $accessToken = self::generateZoomAccessToken();
        $url = self::PREFIX_LINK . '/users/me/meetings';

        $response = Http::withToken($accessToken)->post($url, [
            'topic'      => 'Online Meeting',
            'type'       => self::MEETING_TYPE_SCHEDULE,
            'start_time' => time() + config('zoom.token_life'),
            'duration'   => 2,
            'agenda'     => 'Meeting for Course',
            'timezone' => 'Asia/Ho_Chi_Minh'
        ]);

        if ($response->successful()) {
            return [
                'success' => $response->getStatusCode() === 201,
                'data'    => json_decode($response->getBody(), true),
            ];
        } else {
            return response()->json(['error' => 'Failed to create a Zoom meeting'], 500);
        }
    }

    public static function cacheUsersList()
    {
        return Cache::remember('zoom_users', 60, function()  {
            // return self::listUsers();
            return ZoomUser::all()->toArray();
        });
    }

    /**
     * Get all users in managed by this ZOOM account
     */
    public static function listUsers()
    {
        $accessToken = self::generateZoomAccessToken();
        $url = self::PREFIX_LINK . '/users';

        try {
            $response = Http::withToken($accessToken)
                ->timeout(60) // Set total request timeout to 60 seconds
                ->connectTimeout(30) // Set connection timeout to 30 seconds
                ->retry(3, 100) // Retry 3 times with 100ms delay
                ->get($url);

            if ($response->successful()) {
                return $response->json();
            } else {
                \Log::error("Failed to list Zoom users: " . $response->body());
                return null;
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            \Log::error("Connection timed out: " . $e->getMessage());
            return null;
        } catch (\Exception $e) {
            \Log::error("Failed to list Zoom users: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a meeting for a user managed by this account with param data
     * 
     * @param data - information of meeting
     * @param userId - id of user owner this meeting 
     */
    public static function createMeetingForUser($data, $userId)
    {
        $accessToken = self::generateZoomAccessToken();
        $url = self::PREFIX_LINK . '/users/' . $userId . '/meetings';

        $response = Http::withToken($accessToken)->post($url, [
            'topic' => $data['topic'],
            'type' => self::MEETING_TYPE_SCHEDULE,
            'start_time' => $data['start_time'],
            'duration' => $data['duration'],
            'agenda' => $data['agenda'],
            'timezone' => $data['timezone'],
            'password' => $data['password'],
            'settings' => [
                'host_video' => $data['host_video'] ?? false, // turn off host video when join
                'participant_video' => $data['participant_video'] ?? false, // turn off participant video when join
                'cn_meeting' => $data['cn_meeting'] ?? false, // meeting in china?
                'in_meeting' => $data['in_meeting'] ?? false, // meeting in india?
                'join_before_host' => $data['join_before_host'] ?? false, // Allow join before host
                'jbh_time' => $data['jbh_time'] ?? 0, // Time allowed to join before host (if join_before_host is true)
                'mute_upon_entry' => $data['mute_upon_entry'] ?? true, // auto mute when join
                'watermark' => $data['watermark'] ?? false, // use watermark?
                'use_pmi' => $data['use_pmi'] ?? true, // Use Personal Meeting ID (PMI)
                'waiting_room' => $data['waiting_room'] ?? true, // Enable waiting room
                'approval_type' => $data['approval_type'] ?? 2, // Approval type for participants (0: auto, 1: manual, 2: none)
                'audio' => $data['audio'] ?? 'voip', // Audio options ('voip', 'telephony', 'both')
                'auto_recording' => $data['auto_recording'] ?? 'none', // Auto recording ('local', 'cloud', 'none')
                'enforce_login' => $data['enforce_login'] ?? false, // Require login to join
                'enforce_login_domains' => $data['enforce_login_domains'] ?? '', // Only allow login from these domains
                'alternative_hosts' => $data['alternative_hosts'] ?? '', // List of alternative hosts
                'alternative_host_update_polls' => $data['alternative_host_update_polls'] ?? false, // Allow alternative hosts to update polls
                'close_registration' => $data['close_registration'] ?? false, // Close registration after meeting starts
                'show_share_button' => $data['show_share_button'] ?? false, // Show share button
                'allow_multiple_devices' => $data['allow_multiple_devices'] ?? false, // Allow joining from multiple devices
                'registrants_confirmation_email' => $data['registrants_confirmation_email'] ?? true, // Send confirmation email to registrants
                'request_permission_to_unmute_participants' => $data['request_permission_to_unmute_participants'] ?? false, // Request permission to unmute participants
                'registrants_email_notification' => $data['registrants_email_notification'] ?? true, // Send email notification to registrants
                'meeting_authentication' => $data['meeting_authentication'] ?? false, // Enable meeting authentication
                'encryption_type' => $data['encryption_type'] ?? 'enhanced_encryption', // Encryption type for the meeting
                'approved_or_denied_countries_or_regions' => [
                    'enable' => $data['approved_or_denied_countries_or_regions']['enable'] ?? false,
                    'approved_list' => $data['approved_or_denied_countries_or_regions']['approved_list'] ?? [],
                    'denied_list' => $data['approved_or_denied_countries_or_regions']['denied_list'] ?? [],
                ],
            ],
        ]);

        if ($response->successful()) {
            return [
                'success' => $response->getStatusCode() === 201,
                'data' => json_decode($response->getBody(), true)
            ];
        } else {
            return response()->json([
                'error' => 'Failed to create a ZOOM meeting'
            ], 500);
        }
    }

    /**
     * Get all current meetings for all users
     */
    public static function listAllMeetings()
    {
        $users = ZoomUser::all()->toArray();

        if (isset($users)) {
            $meetings = [];

            foreach ($users as $user) {
                $accessToken = self::generateZoomAccessToken();
                $url = self::PREFIX_LINK . '/users/' . $user['user_id'] . '/meetings';

                $response = Http::withToken($accessToken)->get($url);

                if ($response->successful()) {
                    $userMeetings = $response->json();
                    $meetings = array_merge($meetings, $userMeetings['meetings']);
                } else {
                    Log::error("Fail to list meetings for user {$user['user_id']}: " . $response->body());
                }
            }

            return $meetings;
        } else {
            return null;
        }
    }

    /**
     * Delete a meeting by meeting ID
     * 
     * @param meetingId - ID of the meeting to be deleted
     */
    public static function deleteMeeting($meetingId)
    {
        $accessToken = self::generateZoomAccessToken();
        $url = self::PREFIX_LINK . '/meetings/' . $meetingId;

        $response = Http::withToken($accessToken)->delete($url);

        if ($response->successful()) {
            Log::info("Successfully deleted meeting {$meetingId}");
            return [
                'success' => $response->getStatusCode() === 204,
                'meetingId' => $meetingId
            ];
        } else {
            Log::error("Failed to delete meeting {$meetingId}: " . $response->body());
            return [
                'success' => false,
                'meetingId' => $meetingId,
                'error' => 'Failed to delete the meeting'
            ];
        }
    }

    /**
     * THIS FUNCTION IS DANGEROUS
     * DELETES ALL MEETINGS
     * ONLY USE IN DEVELOPMENT WITH TEST DATA
     * DO NOT USE IN PRODUCTION
     */
    public static function deleteAllMeetings()
    {
        $meetings = self::listAllMeetings();

        if ($meetings) {
            foreach ($meetings as $meeting) {
                self::deleteMeeting($meeting['id']);

                Log::info("Delete attempt for meeting ID {$meeting['id']}");
            }
            return [
                'success' => true,
                'message' => 'All meetings have been deleted'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'No meetings found to delete'
            ];
        }
    }

    /**
     * Get list meeting generated by a user
     * 
     * @param userId - id of user
     */
    public static function listUserMeetings($userId)
    {
        $accessToken = self::generateZoomAccessToken();
        $url = self::PREFIX_LINK . '/users/' . $userId . '/meetings';

        $response = Http::withToken($accessToken)->get($url);

        if ($response->successful()) {
            return $response->json();
        } else {
            \Log::error("Fail to list ZOOM meetings for user: " .$response->body());
            return null;
        }
    }

    /**
     * Get detail information of all meeting
     * 
     * @param meetingId
     */
    public static function getMeetingDetails($meetingId)
    {
        $accessToken = self::generateZoomAccessToken();
        $url = self::PREFIX_LINK . '/meetings/' . $meetingId;

        $response = Http::withToken($accessToken)->get($url);

        if ($response->successful()) {
            return $response->json();
        } else {
            \Log::error("Fail to get ZOOM meeting detail: " . $response->body());
            return null;
        }
    }

    /**
     * Delete all meetings of a user by user ID
     *
     * @param int $userId - ID of the user
     * @return array
     */
    public static function deleteAllMeetingsOfUser($userId)
    {
        $meetings = self::listMeetingsForUser($userId);

        if ($meetings && isset($meetings['meetings'])) {
            $meetingIds = array_column($meetings['meetings'], 'id');
            $errors = [];
            
            foreach ($meetingIds as $meetingId) {
                $result = self::deleteMeeting($meetingId);
                if (!$result['success']) {
                    $errors[] = $result['meetingId'];
                }
            }

            if (empty($errors)) {
                return [
                    'success' => true,
                    'message' => 'All meetings have been deleted successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Some meetings could not be deleted',
                    'failed_meetings' => $errors
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'No meetings found for the user or failed to fetch meetings'
            ];
        }
    }

    public static function isMeetingEnable($meetingId)
    {
        $meetingDetails = self::getMeetingDetails($meetingId);

        if (!$meetingDetails) return false;

         // Check if the meeting status is "waiting" or "started"
        if ($meetingDetails['status'] !== 'waiting' && $meetingDetails['status'] !== 'started') {
            return false;
        }

        // Check if the meeting is not using Personal Meeting ID (PMI)
        if ($meetingDetails['settings']['use_pmi'] === true) {
            return false;
        }

        // Check if the meeting has a valid start URL and join URL
        if (empty($meetingDetails['start_url']) || empty($meetingDetails['join_url'])) {
            return false;
        }

        return true;
    }

    public static function getMeetingIdFromStartLink($url)
    {
        $pattern = "/\/s\/(\d+)/";

        // Use preg_match to extract the ID
        if (preg_match($pattern, $url, $matches)) {
            // $matches[1] will contain the meeting ID
            $meetingId = $matches[1];
            return $meetingId;
        } else {
            return null;
        }
    }

    public static function getMeetingIdFromJoinLink($url)
    {
        $pattern = "/\/j\/(\d+)/";

        // Use preg_match to extract the ID
        if (preg_match($pattern, $url, $matches)) {
            // $matches[1] will contain the meeting ID
            $meetingId = $matches[1];
            return $meetingId;
        } else {
            return null;
        }
    }

    /**
     * Get all user meetings with details
     * 
     * @param userId - ID of all meetings user
     */
    public static function listUserMeetingsWithDetails($userId)
    {
        $meetings = self::listUserMeetings($userId);

        if (!$meetings || !isset($meeting['meetings'])) {
            return response()->json([
                "error" => "Failed to retrieve meetings for the user"
            ], 500);
        }

        $meetingDetails = [];

        foreach($meetings['meeting'] as $meeting) {
            $details = self::getMeetingDetails($meeting['id']);

            if ($details) {
                $meetingDetails[] = $detail;
            }
        }

        return $meetingDetails;
    }

    /**
     * Get a test data
     */
    public static function getTestData()
    {
        return [
            'topic' => 'Online meeting',
            'start_time' => '2024-05-23T10:00:00Z',
            'duration' => 60,
            'agenda' => 'Meeting for Course',
            'timezone' => 'Asia/Ho_Chi_Minh',
            'password' => 'Abcd1234',
            'host_video' => false, // turn off host video when join
            'participant_video' => false, // turn off participant video when join
            'cn_meeting' => false, // meeting in China
            'in_meeting' => false, // meeting in India
            'join_before_host' => false, // Allow join before host
            'jbh_time' => 0, // Time allowed to join before host (if join_before_host is true)
            'mute_upon_entry' => true, // auto mute when join
            'watermark' => false, // use watermark
            'use_pmi' => false, // Use Personal Meeting ID (PMI)
            'waiting_room' => false, // Enable waiting room
            'approval_type' => 2, // Approval type for participants (0: auto, 1: manual, 2: none)
            'audio' => 'voip', // Audio options ('voip', 'telephony', 'both')
            'auto_recording' => 'none', // Auto recording ('local', 'cloud', 'none')
            'enforce_login' => false, // Require login to join
            'enforce_login_domains' => '', // Only allow login from these domains
            'alternative_hosts' => '', // List of alternative hosts
            'alternative_host_update_polls' => false, // Allow alternative hosts to update polls
            'close_registration' => false, // Close registration after meeting starts
            'show_share_button' => false, // Show share button
            'allow_multiple_devices' => false, // Allow joining from multiple devices
            'registrants_confirmation_email' => true, // Send confirmation email to registrants
            'request_permission_to_unmute_participants' => false, // Request permission to unmute participants
            'registrants_email_notification' => true, // Send email notification to registrants
            'meeting_authentication' => false, // Enable meeting authentication
            'encryption_type' => 'enhanced_encryption', // Encryption type for the meeting
            'approved_or_denied_countries_or_regions' => [
                'enable' => false,
                'approved_list' => [], // List of approved countries or regions
                'denied_list' => [], // List of denied countries or regions
            ],
        ];
    }

    public static function checkUsersWithoutMeetings($startDate, $endDate)
    {
        // Get all users
        // $users = self::listUsers();
        $users = ZoomUser::all()->toArray();

        if ($users === null) {
            return response()->json(['error' => 'Failed to retrieve Zoom users'], 500);
        }

        $usersWithoutMeetings = [];

        foreach ($users as $user) {
            $userId = $user['user_id'];
            
            // get user meetings form --- to
            $meetings = self::listMeetingsForUserWithTimeRange($userId, $startDate, $endDate);

            if ($meetings === null || empty($meetings['meetings'])) {
                $usersWithoutMeetings[] = $user;
            }
        }

        return $usersWithoutMeetings;
    }

    public static function listMeetingsForUserWithTimeRange($userId, $startDate, $endDate)
    {
        $accessToken = self::generateZoomAccessToken();
        $url = self::PREFIX_LINK . '/users/' . $userId . '/meetings';

        $response = Http::withToken($accessToken)->get($url, [
            'type' => 'scheduled',
            'from' => $startDate->format('Y-m-d\TH:i:s\Z'),
            'to' => $endDate->format('Y-m-d\TH:i:s\Z'),
        ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            \Log::error("Failed to list meetings for user $userId: " . $response->body());
            return null;
        }
    }

    /* 
        Example test to find out which user does not have a teaching link during a time

        $startDate = Carbon\Carbon::create(2024, 5, 31, 7, 0, 0, 'Asia/Ho_Chi_Minh');
        $endDate = Carbon\Carbon::create(2024, 5, 31, 8, 0, 0, 'Asia/Ho_Chi_Minh');
        $usersWithoutMeetings = \App\Models\ZoomMeeting::checkUsersWithoutMeetings($startDate, $endDate);
    */

    /**
     * Check if a user with the given email has any Zoom meetings within the specified time range.
     *
     * @param string $email
     * @param Carbon\Carbon $startDate
     * @param Carbon\Carbon $endDate
     * @return bool
     */
    public static function userHasMeetingsWithEmailInTimeRange($email, $startDate, $endDate)
    {
        // Get the user ID by email
        $user = self::getUserByEmail($email);

        if (!$user) {
            return false; // User not found
        }

        $userId = $user['id'];

        // Get meetings for the user within the time range
        $meetings = self::listMeetingsForUserWithTimeRange($userId, $startDate, $endDate);

        if ($meetings === null || empty($meetings['meetings'])) {
            return false; // No meetings found for the user
        }

        return true; // Meetings found for the user
    }

    /**
     * Get user information by email.
     *
     * @param string $email
     * @return array|null
     */
    private static function getUserByEmail($email)
    {
        $accessToken = self::generateZoomAccessToken();
        $url = self::PREFIX_LINK . '/users';

        $response = Http::withToken($accessToken)->get($url, [
            'status' => 'active', // Filter only active users
            'email' => $email, // Search by email
        ]);

        if ($response->successful()) {
            $users = $response->json();

            // Check if any user found with the given email
            if (!empty($users['users'])) {
                // Return the first user found (assuming email is unique)
                return $users['users'][0];
            }
        }

        return null; // User not found or failed to retrieve user information
    }

    public static function listMeetingsForUser($userId)
    {
        $accessToken = self::generateZoomAccessToken();
        $url = self::PREFIX_LINK . '/users/' . $userId . '/meetings';

        $response = Http::withToken($accessToken)->get($url, [
            'type' => 'scheduled',
            'page_size' => 300, // Adjust the page size as needed
        ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            \Log::error("Failed to list meetings for user $userId: " . $response->body());
            return null;
        }
    }

    /**
     * Check if a user with the given email exists.
     *
     * @param string $email
     * @return bool
     */
    public static function userExistsWithEmail($email)
    {
        $accessToken = self::generateZoomAccessToken();
        $url = self::PREFIX_LINK . '/users';

        $response = Http::withToken($accessToken)->get($url, [
            'status' => 'active', // Filter only active users
            'email' => $email, // Search by email
        ]);

        if ($response->successful()) {
            $users = $response->json();

            // Check if any user found with the given email
            return !empty($users['users']);
        } else {
            // Handle the error
            \Log::error("Failed to check user with email $email: " . $response->body());
            return false;
        }
    }

    /**
     * Get the information of a user by user ID
     *
     * @param string $userId - ID of the user to retrieve information for
     * @return array|null - User information if successful, null otherwise
     */
    public static function getUserInfo($userId)
    {
        $accessToken = self::generateZoomAccessToken();
        $url = self::PREFIX_LINK . '/users/' . $userId;

        $response = Http::withToken($accessToken)->get($url);

        if ($response->successful()) {
            return $response->json();
        } else {
            \Log::error("Fail to get Zoom user info: " . $response->body());
            return null;
        }
    }

    public function updatezoom($id, $data)
    {
        $accessToken = self::generateZoomAccessToken();
        $url = self::PREFIX_LINK . '/meetings/' . $id;

        $response = Http::withToken($accessToken)->patch($url, [
            'topic' => 'Online Meeting',
            'type' => self::MEETING_TYPE_SCHEDULE,
            'start_time' => $this->toZoomTimeFormat($data['start_time']),
            'duration' => $data['duration'],
            'agenda' => (!empty($data['agenda'])) ? $data['agenda'] : null,
            'timezone' => 'Africa/Cairo',
        ]);

        if ($response->successful()) {
            // Meeting updated successfully
            return [
                'success' => true,
                'data' => $response->json(),
            ];
        } else {
            // Handle the error
            return response()->json(['error' => 'Failed to update the Zoom meeting'], 500);
        }
    }

    /**
     * @param string $id
     *
     * @return bool[]
     */

    public function deleteZoomMeeting($id)
    {
        $accessToken = self::generateZoomAccessToken();
        $url = self::PREFIX_LINK . '/meetings/' . $id;

        $response = Http::withToken($accessToken)->delete($url);

        if ($response->successful()) {
            // Meeting deleted successfully
            return [
                'success' => true,
                'data' => $response->json(),
            ];
        } else {
            // Handle the error
            return response()->json(['error' => 'Failed to delete the Zoom meeting'], 500);
        }
    }

    /**
     * Display a zoomPost.
     *
     * @return \Illuminate\Http\Response
     */
    public function zoomPost(string $path, array $body = [])
    {
        $request = $this->zoomRequest();
        return $request->post(config('zoom.base_url') . $path, $body);
    }

    public static function getPayloadArrayFromStartUrl($startUrl)
    {
        // Get token value
        $queryString = parse_url($startUrl, PHP_URL_QUERY);
        parse_str($queryString, $params);

        if (!isset($params['zak'])) return null;

        $jwtToken = $params['zak'];

        // Separate JWT to parts
        list($header, $payload, $signature) = explode('.', $jwtToken);

        // Decode Payload
        $decodedPayload = base64_decode($payload);
        $payloadArray = json_decode($decodedPayload, true);

        return $payloadArray;
    }

    /*
        function getPayloadArrayFromStartUrl return EXAMPLE:
        [
            "aud" => "clientsm",
            "uid" => "i7xbXj8UQsSmBh6XExru4Q",
            "iss" => "web",
            "sk" => "0",
            "sty" => 1,
            "wcd" => "aw1",
            "clt" => 0,
            "mnum" => "93529110229",
            "exp" => 1716849637,
            "iat" => 1716842437,
            "aid" => "msThZkoURc29zfn7GCnCcg",
            "cid" => "",
        ]

        Meaning: 
        aud: (Audience) Trường này chỉ định đối tượng mà token được phát hành. Trong trường hợp này, aud là "clientsm", có thể là tên của ứng dụng hoặc dịch vụ sử dụng token này.
        uid: (User ID) Đây là ID của người dùng. Trong trường hợp này, nó là "i7xbXj8UQsSmBh6XExru4Q", là ID của người dùng mà token này đại diện.
        iss: (Issuer) Trường này chỉ định nơi phát hành token. Ở đây là "web", có thể ám chỉ rằng token được phát hành từ dịch vụ web của Zoom.
        sk: (Session Key) Đây có thể là một trường liên quan đến khóa phiên, với giá trị "0".
        sty: (Session Type) Trường này chỉ định loại phiên, với giá trị 1. Giá trị này có thể có ý nghĩa nội bộ cụ thể đối với Zoom.
        wcd: Trường này có thể là viết tắt của "Web Client Domain" hoặc một thông tin liên quan đến phiên làm việc qua web, với giá trị "aw1".
        clt: Trường này có thể liên quan đến loại khách hàng (client type), với giá trị 0.
        mnum: (Meeting Number) Đây là số của cuộc họp, "93529110229", là ID của cuộc họp trên Zoom.
        exp: (Expiration Time) Đây là thời gian hết hạn của token, tính theo thời gian Unix. Giá trị 1716849637 có nghĩa là token hết hạn vào thời điểm đó.
        iat: (Issued At) Đây là thời gian phát hành token, tính theo thời gian Unix. Giá trị 1716842437 chỉ thời điểm token được phát hành.
        aid: (Account ID) Đây là ID của tài khoản Zoom, "msThZkoURc29zfn7GCnCcg".
        cid: (Client ID) Đây là ID của khách hàng, ở đây là một chuỗi rỗng.

        ***********

        aud (Audience): Xác định đối tượng mà token được phát hành. Điều này giúp đảm bảo rằng token chỉ được chấp nhận bởi các dịch vụ hoặc ứng dụng đã được xác định trước.
        uid (User ID): ID duy nhất của người dùng mà token đại diện. Điều này giúp xác định người dùng một cách duy nhất.
        iss (Issuer): Xác định nguồn gốc của token, giúp xác minh rằng token được phát hành bởi một nguồn tin cậy.
        sk (Session Key): Thường liên quan đến khóa phiên hoặc định danh phiên làm việc.
        sty (Session Type): Có thể chỉ định loại phiên hoặc trạng thái của phiên.
        wcd: Thông tin cụ thể có thể liên quan đến phiên web hoặc cấu hình web.
        clt: Loại khách hàng hoặc loại phiên làm việc, giúp xác định cách xử lý token.
        mnum (Meeting Number): ID của cuộc họp trên Zoom, giúp liên kết token với một cuộc họp cụ thể.
        exp (Expiration Time): Xác định thời gian hết hạn của token để đảm bảo rằng token không thể sử dụng sau một khoảng thời gian nhất định.
        iat (Issued At): Xác định thời điểm phát hành token, giúp theo dõi tuổi thọ của token.
        aid (Account ID): ID của tài khoản Zoom, giúp liên kết token với một tài khoản cụ thể.
        cid (Client ID): ID của khách hàng, có thể được sử dụng để xác định ứng dụng hoặc dịch vụ đang sử dụng token.
    */

    public static function getZoomUsersByIds($ids)
    {
        if (!$ids) {
            return [];
        }

        // $allUsers = self::listUsers()['users'];
        $allUsers = ZoomUser::all()->toArray();

        $usersMatchIds = array_filter($allUsers, function($user) use ($ids) {
            return in_array($user['user_id'], $ids);
        });

        return $usersMatchIds;
    }

    /**
     * Retrieve all Zoom user IDs that can create Zoom links suitable for the times of the given sections, 
     * without overlapping with the times of other Zoom links of the user in the system.
     * 
     * @param sectionsData - Sections generated from week schedule apply to calendar (not save to DB yet).
     * @return availableZoomUserIds - Zoom links suitable for the times of the given sections.
     */
    public static function getAvailableZoomUserIdsBySections($sectionsData, $courseId=null): array
    {
        // If there are no sections => not generate zoom link for sections
        if (!$sectionsData) return [];

        $allZoomUsersData = ZoomUser::all();
        $allZoomUserIds = array_column($allZoomUsersData->toArray(), 'user_id'); // All zoom user ids currently existing
        $conflictZoomUserIds = [];

        foreach($sectionsData as $data) { // Loop each section input
            $sectionsQuery = Section::query();

            if ($courseId) {
                $sectionsQuery = $sectionsQuery->whereHas('course', function($q) use ($courseId) {
                    $q->where('id', '!=', $courseId);
                });
            }

            // Find sections in system are conflicting with current section loop by time (start_at, end_at)
            $conflictSections = $sectionsQuery->conflictWith($data['start_at'], $data['end_at'])->get();

            // When we have the collection of sections (conflictSections) which conflict with current section loop to,
            // We have to find all zoom user ids of all sections in conflict sections collection and push into "$conflictZoomUserIds"
            foreach ($conflictSections as $conflictSection) {
                array_push($conflictZoomUserIds, $conflictSection->getZoomUserId());
            }            
        }

        // At this step, we have 2 array
        // - $allZoomUserIds: the array of all zoom user ids currently existing in our system
        // - $conflictZoomUserIds: the array of all zoom user ids of all section which is overlap with sections input ($sectionsData)
        // => now we find all zoom user ids which isn't in the conflict zoom user ids from all zoom user ids array => that is all available zoom ids 
        $availableZoomUserIds = array_diff($allZoomUserIds, $conflictZoomUserIds);

        return $availableZoomUserIds;
    }

    public static function getConflictZoomMeetingLinksWithSections($sectionsData, $courseId=null)
    {
        $conflictZoomUserStartLinks = [];

        foreach($sectionsData as $data) {
            $sectionsQuery = Section::query();
            
            if ($courseId) {
                $sectionsQuery = $sectionsQuery->whereHas('course', function($q) use ($courseId) {
                    $q->where('id', '!=', $courseId);
                });
            }

            $conflictSections = $sectionsQuery->conflictWith($data['start_at'], $data['end_at'])->get();

            foreach ($conflictSections as $conflictSection) {
                array_push($conflictZoomUserStartLinks, $conflictSection->zoom_start_link);
            }
        }

        return $conflictZoomUserStartLinks;
    }

    public static function getZoomUserIdByStartLink($startLink)
    {
        $payload = self::getPayloadArrayFromStartUrl($startLink);
        
        if (!$payload) return null;

        return $payload['uid'];
    }
}