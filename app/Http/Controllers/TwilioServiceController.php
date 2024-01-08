<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Twilio\Rest\Client;

class TwilioServiceController extends Controller
{
    // Holds all Twilio services 

    // protected $twilio;

    // public function __construct(TwilioService $twilio)
    // {
    //     $this->twilio = $twilio;
    // }


    public static function sendMessage($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_PHONE_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipients, 
                ['from' => $twilio_number, 'body' => $message] );
    }

    public function send_sms($receiver, $message){
        // $receiverNumber = "RECEIVER_NUMBER";
        // $message = "This is testing from CodeSolutionStuff.com";
  
        try {
  
            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_number = getenv("TWILIO_PHONE_NUMBER");

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiver, [
                'from' => $twilio_number, 
                'body' => $message]);
                
            return true;
  
        } catch (Exception $e) {
            dd("Error: ". $e->getMessage());
        }
    }

    // TWILIO_SID="AC73a428cc1ee42c873d80f1cc00936ffe"
    // TWILIO_AUTH_TOKEN="c93b16122ae32d9a1d654dfbe9b1d807"
    // TWILIO_PHONE_NUMBER="+12058394784"
}
