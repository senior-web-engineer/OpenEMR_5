<?php

require_once("../../globals.php");
require_once("../../../library/acl.inc");

$user_id = $_POST['user_id'];
$arr = [];
$arr['user_id'] = $user_id;

$query = "SELECT * from rooms WHERE active = '1' and user_id = " . $user_id;
$res = sqlStatement($query);

$list = [];

for ($iter = 0; $row = sqlFetchArray($res); $iter++) {
    $list[] = $row['room_link'];
}

$arr['list'] = $list;

echo json_encode($arr);
?>
