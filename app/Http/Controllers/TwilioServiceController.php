<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\TwilioService;

class TwilioServiceController extends Controller
{
    // Holds all Twilio services 

    public static function sendSms(TwilioService $twilio, $receiver, $body)
    {
        // $twilio->sendMessage('+2349015222109', 'Hello from Twilio! Its Chinonso');
        // Add your logic or return a response

        $send_message = $twilio->messages->create(
            // The number you'd like to send the message to
            $receiver,
            [
                // A Twilio phone number you purchased at https://console.twilio.com
                'from' => env('TWILIO_PHONE_NUMBER'),
                // The body of the text message you'd like to send
                'body' => $body
            ]
        );

        print_r($send_message);
    }
}
