<?php
 
namespace App\Library;
 
use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;
 
class Twilio
{
    public static function send($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipients, ['from' => $twilio_number, 'body' => $message]);
    }
}