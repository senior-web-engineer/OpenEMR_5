<?php
include_once("../../globals.php");
    
$provider = $_SESSION{"authUser"} ;

$provider_print_name = $_POST["provider_print_name"];
$PIN = $_POST["PIN"];
$sql="SELECT provider_signature FROM users WHERE provider_print_name= '$provider_print_name' and  pin = '$PIN' ";
$result = sqlStatement($sql);
while ($row = sqlFetchArray($result)){
 echo $row['provider_signature'];
}

?>