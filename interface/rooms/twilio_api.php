<?php

require __DIR__ . "/twiliosdk/src/Twilio/autoload.php";
use Twilio\Rest\Client;

$twilio_sid    = "AC6fee688eaec10e6686cafeb2352aa612";
$twilio_token  = "33543e3f51d6346ecf04dce590a7aad0";
$twilio_from = "";


function create_room() {
    global $twilio_sid;
    global $twilio_token;
    $twilio = new Client($twilio_sid, $twilio_token);
    $room = $twilio->video->v1->rooms->create(["uniqueName" => "DailyStandup"]);
    $json_room = json_decode($room);
    return $json_room;
}

function send_sms($to, $body)
{
    global $twilio_sid;
    global $twilio_token;
    global $twilio_from;

    $_to = $to;
    if (substr($_to, 0, 1) != '+')
        $_to = '+'.$_to;

    $client = new Client($twilio_sid, $twilio_token);
    $message = $client->messages->create(
        $_to,
        array(
            'from' => $twilio_from,
            'body' => $body
        )
    );

    if ($message)
        return $message->sid;
    else
        return null;
}

?>
