<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Twilio\Rest\Client;

class Reminder extends Model
{
    /**
    * send Twilio SMS
    *
    * @param $to
    * @param $sms_body
    */
    function sendSMS( $to, $sms_body ) {
        // Your Account SID and Auth Token from twilio.com/console
        $sid    = getenv( 'TWILIO_ACCOUNT_SID' );
        $token  = getenv( 'TWILIO_AUTH_TOKEN' );
        $client = new Client( $sid, $token );
        $client->messages->create(
             $to,
             [
             // A Twilio phone number you purchased at twilio.com/console
             'from' => getenv( 'TWILIO_PHONE_NUMBER' ),
             // the body of the text message you'd like to send
             'body' => $sms_body
             ]
        );
    }

    
	public function sendReminders() {
        // Fill in a reminder you'd like to send in this function, either populated
        //  by a constant or from the database.
        $reminder = "This is your daily reminder. Get it done!";
        $recipients = [
            [ 'to' => getenv('TO_NUMBER') ]
            // add additional recipients here, if necessary
        ];
        foreach($recipients as $recipient) {
            $this->sendSMS($recipient['to'], $reminder);
        }
    }
}
