<?php
//include_once("../globals.php");
//include_once("$srcdir/sha1.js");
//include_once("$srcdir/sql.inc");
//include_once("$srcdir/auth.inc");

include_once("../../pirc.php");


$db = @mysql_select_db($db_name, $connection) or die(mysql_error());

    
$provider = $_SESSION{"authUser"} ;

$provider_print_name = mysql_real_escape_string($_POST["provider_print_name"]);
$PIN = mysql_real_escape_string($_POST["PIN"]);
//$provider_signature = mysql_real_escape_string($_POST["provider_signature"]);


$sql="SELECT provider_signature FROM users
        WHERE provider_print_name='$provider_print_name' and  pin = '$PIN' ";

/*
mysql_query($query)or die(mysql_error());
if(mysql_affected_rows()>=1){
    echo "<p>($provider) Record Updated<p>";
}else{
    echo "<p>($provider) Not Updated<p>";
}
*/


$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) 
{
 echo $row['provider_signature'];
 

}

?>