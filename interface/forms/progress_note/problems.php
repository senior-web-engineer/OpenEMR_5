hello problems

<?php

//SANITIZE ALL ESCAPES
 $sanitize_all_escapes=true;

 //STOP FAKE REGISTER GLOBALS
 $fake_register_globals=false;
 
include_once("../../globals.php");
include_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/options.inc.php");
$formid = 0 + (isset($_GET['id']) ? $_GET['id'] : '');
$obj = $formid ? formFetch("form_soap", $formid) : array();
echo "this is echo";
echo $formid;
?>
<?php



$con = mysql_connect($host, $login, $pass); 
mysql_select_db($dbase, $con);





		include ("pro.php");
?>

nooooooo