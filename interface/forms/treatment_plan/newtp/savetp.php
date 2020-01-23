<?php

include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");
foreach ($_POST as $k => $var) {
	$_POST[$k] = add_escape_custom($var);

	echo "$var\n";
}
if ($encounter == "")
	$encounter = date("Ymd");
	
//$_GET["id"] is form_id

if ($_GET["mode"] == ""){ // "" is new
	$newid = formSubmit("form_treatment_plan", $_POST, $_GET["id"], $userauthorized);
	print 'formSubmitt';  /*debugging */
	addForm($encounter, "Treatment Plan", $newid, "treatment_plan", $pid, $userauthorized);
	
}elseif ($_GET["mode"] == "clone") {
	print '<br>cloning';  /*debugging */
	$newid = 0;
	//$newid = formSubmit("form_treatment_plan", $_POST, $_GET["id"], $userauthorized);
	$clone_tpid = $_GET["clone_tpid"];
	$con = mysql_connect($host, $login, $pass); 
	mysql_select_db($dbase, $con);
	//Calling the total_price stored procedure using the @t OUT parameter
	//mysql_query($con, "SET @tp = 0");
	echo "<br>CALL CloneTP(pid $pid, clone_tpid $clone_tpid, @tp) ";
	$result= mysql_query("CALL CloneTP( $pid, $clone_tpid, @tp)", $con) or die(mysql_error()); //Listing the result
	if ($result){
		while($row = mysql_fetch_row($result)) {
			echo '<br>'.$row[0].' '.$row[1].'->'.$row[2];
			$newid = $row[2];
		}
	} else { echo '<br>failed running CloneTP'; }
	mysql_close($con);

	if ($newid > 0){
		
		//Clone problems -LEVEL2
		$con = mysql_connect($host, $login, $pass); 
		mysql_select_db($dbase, $con);
		echo "<br>CALL CloneProblem(pid_in $pid, tpid_in $clone_tpid, tpid_new $newid) ";
		$result2= mysql_query("CALL CloneProblem( $pid, $clone_tpid, $newid)", $con) or die(mysql_error()); //Listing the result
		if ($result2){
			$probids = array();
			$probidnews = array();
			while($row2 = mysql_fetch_row($result2)) {
				echo '<br>'.$row2[0].' '.$row2[1].'->'.$row2[2];
				
				$probids[] = $row2[1];
				$probidnews[] = $row2[2];
			}
			mysql_close($con);
			
			foreach ($probids as $key => $probid){
				$probidnew = $probidnews[$key];
				
				$con = mysql_connect($host, $login, $pass); 
				mysql_select_db($dbase, $con);
				//clone objectives -LEVEL3
				echo "<br>CALL CloneObjectives(pid_in $pid, tpid_in $clone_tpid, tpid_new $newid, probid $probid, probid_new $probidnew) ";
				$result3= mysql_query("CALL CloneObjectives( $pid, $clone_tpid, $newid, $probid, $probidnew )", $con) or die(mysql_error()); //Listing the result
				if ($result3){
					while($row3 = mysql_fetch_row($result3)) {
						echo '<br>'.$row3[0].' '.$row3[1].'->'.$row3[2];
					}
				} else { echo '<br>failed running CloneObjectives'; }
				mysql_close($con);
			}
			
		} else { echo '<br>failed running CloneProblem'; }
		
	}
	
	if ($newid > 0){
		addForm($encounter, "Treatment Plan", $newid, "treatment_plan", $pid, $userauthorized);
	} else { echo '<br>new tpid not retrieved'; }
	
}elseif ($_GET["mode"] == "update") {
	sqlInsert("update form_treatment_plan set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
	service_code='H0032',
	service_name='Treatment Plan',
 	status='".$_POST["status"]."'
	where id=$id");


}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");

if ($_GET["mode"] == ""){
	$address = "{$GLOBALS['rootdir']}/forms/treatment_plan/view.php?id=$newid";
	echo "\n<script language='Javascript'>top.restoreSession();window.location='$address';</script>\n";
	
}elseif ($_GET["mode"] == "clone"){
	//$oldid = $_GET["id"];
	$oldid = $clone_tpid;
	echo "<br>cloned oldid = $oldid newid = $newid";
	$address = "{$GLOBALS['rootdir']}/forms/treatment_plan/view.php?id=$newid";
	//uncomment to show Link
	//echo "<br><a href='".$address."'>".$address."</a>";
	//comment to prevent auto-redirect
	echo "\n<script language='Javascript'>top.restoreSession();window.location='$address';</script>\n";
	
}elseif ($_GET["mode"] == "update") {
	formJump();
}

formFooter();
?>

