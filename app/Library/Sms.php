<?php
 
namespace App\Library;

use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;
 
class Sms
{
    public static function send($message, $phoneNumber)
    {
        if (!$phoneNumber) {
          Log::channel('sms')->error("Phone number is null|empty [message: " . $message . "]");
          return;
        }

        // test phone number overidden
        $phoneNumber = env('SMS_TEST_NUMBER') ?? $phoneNumber;

        try {
          $message = \App\Library\Tool::convert_vi_to_en($message);

          $curl = curl_init();
        
          curl_setopt_array($curl, array(
            CURLOPT_URL => env('SMS_URI'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
          "phone":"'.$phoneNumber.'",
          "password":"'.env('SMS_PASSWORD').'", 
          "message":"'.$message.'",
          "idrequest":"'.env('SMS_REQUEST_ID').'",
          "brandname":"'.env('SMS_BRAND_NAME').'", 
          "username":"'.env('SMS_USER').'"
          }
          ',
            CURLOPT_HTTPHEADER => array(
              'Content-Type: application/json'
            ),
          ));
          
          $response = curl_exec($curl);
          
          curl_close($curl);

          $r = json_decode($response, true);

          if ($r['result'] != '0') {
            Log::channel('sms')->error("Response: $response [phone: $phoneNumber, message: $message]");
          } else {
            Log::channel('sms')->info("Sms sent! [phone: $phoneNumber, message: $message, response: $response]");
          }
        } catch (\Throwable $e) {
          Log::channel('sms')->error($e->getMessage() . " [phone: $phoneNumber, message: $message]");
        }
    }
}