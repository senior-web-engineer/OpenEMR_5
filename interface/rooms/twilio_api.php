<?php

require __DIR__ . "/twiliosdk/src/Twilio/autoload.php";
use Twilio\Rest\Client;

$twilio_sid    = "AC6fee688eaec10e6686cafeb2352aa612";
$twilio_token  = "33543e3f51d6346ecf04dce590a7aad0";

function create_room() {
    global $twilio_sid;
    global $twilio_token;
    $twilio = new Client($twilio_sid, $twilio_token);
    $room = $twilio->video->v1->rooms->create(["uniqueName" => "DailyStandup"]);
    $json_room = json_decode($room);
    return $json_room;
}

?>
