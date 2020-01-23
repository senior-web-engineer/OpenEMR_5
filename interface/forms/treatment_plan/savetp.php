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
$service_name = $_GET["encounter_name"];
//$id = 0 + (isset($_GET['id']) ? $_GET['id'] : '');
if ($_GET["mode"] == ""){ // "" is new
	$newid = formSubmit("form_treatment_plan", $_POST, $_GET["id"], $userauthorized);
	print 'formSubmitt';  /*debugging */
	addForm($encounter, $service_name, $newid, "treatment_plan", $pid, $userauthorized);
	
}elseif ($_GET["mode"] == "clone") {
	print '<br>cloning';  /*debugging */
	$newid = 0;
	$batch = date(DATE_ATOM, time());
	echo "<br>batch id = $batch";
	$newid = formSubmit("form_treatment_plan", $_POST, $_GET["id"], $userauthorized);
	//$newid = 0 + (isset($_GET['id']) ? $_GET['id'] : '');
	$clone_tpid = $_GET["clone_tpid"];
	//$con = mysql_connect($host, $login, $pass); 
	//mysql_select_db($dbase, $con);
	$mysqli = new mysqli($host, $login, $pass, $dbase);
	
	//Calling the total_price stored procedure using the @t OUT parameter
	//mysql_query($con, "SET @tp = 0");
	echo "<br>CALL CloneTP(batch '$batch', pid $pid, clone_tpid $clone_tpid, @tp) ";
	//$result= mysql_query("CALL CloneTP('$batch', $pid, $clone_tpid, @tp)", $con) or die(mysql_error()); //Listing the result
	$result= $mysqli -> query ("CALL CloneTP('$batch', $pid, $clone_tpid, @tp)");
	if ($result){
		//while($row = mysql_fetch_array($result, MYSQL_NUM)) {
		  while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
		    echo '<br>'.$row[0].' '.$row[1].'->'.$row[2];
			$newid = $row[2];
		}
	} else { echo '<br>failed running CloneTP'; }
	//mysql_close($con);
	mysqli_close($mysqli);
	if ($newid > 0){
		
		//Clone problems -LEVEL2
		$probCloned = false;
		//$con = mysql_connect($host, $login, $pass); 
		//mysql_select_db($dbase, $con);
		$mysqli = new mysqli($host, $login, $pass, $dbase);
		echo "<br>CALL CloneProblem(batch '$batch', pid_in $pid, tpid_in $clone_tpid, tpid_new $newid) ";
		$result2= $mysqli -> query ("CALL CloneProblem('$batch', $pid, $clone_tpid, $newid)"); //Listing the result
		if ($result2){
			while($row2 = mysqli_fetch_assoc($result2)) {
				$probCloned = true;
				
			}
		}
		mysqli_free_result($result2);
		//mysql_close($con);
		mysqli_close($mysqli);
		if ($probCloned == true){
			
			$probids = array();
			$probidnews = array();
			//$con = mysql_connect($host, $login, $pass); 
			//mysql_select_db($dbase, $con);
			$mysqli = new mysqli($host, $login, $pass, $dbase);
			echo "<br>CALL getting cloned problems ";
			$sql2get = "select target_tbl, from_id, to_id, original_form_id, pid
				FROM form_treatment_plan_clonelog
				WHERE target_tbl = 'probid' and original_form_id = $clone_tpid
					and pid = $pid and batch = '$batch' ";
			$result21= $mysqli -> query ($sql2get); //Listing the result
			while($row21 = mysqli_fetch_array($result21, MYSQLI_NUM)) {
				echo '<br>'.$row21[0].' '.$row21[1].'->'.$row21[2]; 
				$probids[] = $row21[1];
				$probidnews[] = $row21[2];
			}
			mysqli_free_result($result21);
			//mysql_close($con);
			mysqli_close($mysqli);
				
			foreach ($probids as $key => $probid){
				$probidnew = $probidnews[$key];
				$mysqli = new mysqli($host, $login, $pass, $dbase);
				//$con = mysql_connect($host, $login, $pass); 
				//mysql_select_db($dbase, $con);
				//clone objectives -LEVEL3
				echo "<br>CALL CloneObjectives(batch '$batch', pid_in $pid, tpid_in $clone_tpid, tpid_new $newid, probid $probid, probid_new $probidnew) ";
				$result3= $mysqli -> query("CALL CloneObjectives('$batch', $pid, $clone_tpid, $newid, $probid, $probidnew )"); //Listing the result
				if ($result3){
					while($row3 = mysqli_fetch_array($result3, MYSQLI_NUM)) {
						echo '<br>'.$row3[0].' '.$row3[1].'->'.$row3[2];
					}
				} else { echo '<br>failed running CloneObjectives'; }
				mysqli_free_result($result3);
				mysqli_close($mysqli);
			}
			
		} else { echo '<br>failed running CloneProblem'; }
		
	}
	
	if ($newid > 0){
		addForm($encounter, $service_name, $newid, "treatment_plan", $pid, $userauthorized);
	} else { echo '<br>new tpid not retrieved'; }

}elseif ($_GET["mode"] == "intake") {
	$newid = formSubmit("form_treatment_plan", $_POST, $_GET["id"], $userauthorized);
	print 'formSubmitt';  /*debugging */
	addForm($encounter, $service_name, $newid, "treatment_plan", $pid, $userauthorized);
	
	/*problems*/
		$problem1_id = sqlInsert("INSERT INTO form_treatment_plan_problems set pid = {$_SESSION["pid"]}, form_id=$newid,tp_problem_number='1', IsPrimary='1',
		 Description='Mental Health Symptoms.'");
		$problem2_id = sqlInsert("INSERT INTO form_treatment_plan_problems set pid = {$_SESSION["pid"]}, form_id=$newid,tp_problem_number='2', IsPrimary='2',
		 Description='Impairment in Functioning'");
	/*definitions*/
		sqlInsert("INSERT INTO form_treatment_plan_behavioraldefinitions set pid = {$_SESSION["pid"]}, form_id=$newid,tp_problem_number='1', problem_id=$problem1_id,
		 Description='Patient and/or Guardian reports and/or demonstrates mental health symptoms and requesting services.'");
		sqlInsert("INSERT INTO form_treatment_plan_behavioraldefinitions set pid = {$_SESSION["pid"]}, form_id=$newid,tp_problem_number='2', problem_id=$problem2_id,
		 Description='Patient exhibits symptoms that impact daily functioning.'");
	/*goals*/	 
		sqlInsert("INSERT INTO form_treatment_plan_goals set pid = {$_SESSION["pid"]}, form_id=$newid,tp_problem_number='1', problem_id=$problem1_id,
		 Description='Patient will complete assessment to determine what services are needed.'");
		sqlInsert("INSERT INTO form_treatment_plan_goals set pid = {$_SESSION["pid"]}, form_id=$newid,tp_problem_number='2', problem_id=$problem2_id,
		 Description='Patient will reduce or eliminate presenting symptoms'");
	/*objectivies*/
		$objectives11_id = sqlInsert("INSERT INTO form_treatment_plan_objectives set pid = {$_SESSION["pid"]}, form_id=$newid,tp_problem_number='1', problem_id=$problem1_id, 
		 Description='Patient will participate and cooperate with the assessment process. The patient will provide all necessary information to develop treatment plan and comply with treatment recommendations such as medication, individual, and/or family counseling..'");
		$objectives12_id = sqlInsert("INSERT INTO form_treatment_plan_objectives set pid = {$_SESSION["pid"]}, form_id=$newid,tp_problem_number='1', problem_id=$problem1_id, 
		 Description='Patient will identify 2 physical and 2 mental/emotional symptoms.'");
		$objectives21_id = sqlInsert("INSERT INTO form_treatment_plan_objectives set pid = {$_SESSION["pid"]}, form_id=$newid,tp_problem_number='2', problem_id=$problem2_id, 
		 Description='Patient will increase knowledge about diagnosis.'");
		$objectives22_id = sqlInsert("INSERT INTO form_treatment_plan_objectives set pid = {$_SESSION["pid"]}, form_id=$newid,tp_problem_number='2', problem_id=$problem2_id, 
			Description='Patient will identify 2 triggers or stressors to presenting symptoms.'");
		$objectives23_id = sqlInsert("INSERT INTO form_treatment_plan_objectives set pid = {$_SESSION["pid"]}, form_id=$newid,tp_problem_number='2', problem_id=$problem2_id, 
			Description='Patient will learn and implement 3 coping strategies.'");
	     
	/*interventions*/
		sqlInsert("INSERT INTO form_treatment_plan_interventions set pid = {$_SESSION["pid"]}, form_id=$newid,tp_problem_number='1', problem_id=$problem1_id, ObjectiveID=$objectives11_id, 
		 Description='Clinicians (Psychiatrists and Counselors) will complete assessments.'");
		sqlInsert("INSERT INTO form_treatment_plan_interventions set pid = {$_SESSION["pid"]}, form_id=$newid,tp_problem_number='1', problem_id=$problem1_id, ObjectiveID=$objectives12_id, 
		 Description='Clinician will help Patient identify symptoms of present problem while utilizing beginning assessments (in-depth assessment, bio-psychosocial assessment, suicide risk assessment) to understand Patient s background and problem to establish treatment modality.'");
		sqlInsert("INSERT INTO form_treatment_plan_interventions set pid = {$_SESSION["pid"]}, form_id=$newid,tp_problem_number='2', problem_id=$problem2_id, ObjectiveID=$objectives21_id, 
		 Description='Clinician will educate the Patient about of his/her diagnosis including causes, symptoms, and treatment using psycho-education, biblio-therapy and Cognitive Behavioral Therapy techniques.'");
		sqlInsert("INSERT INTO form_treatment_plan_interventions set pid = {$_SESSION["pid"]}, form_id=$newid,tp_problem_number='2', problem_id=$problem2_id, ObjectiveID=$objectives22_id, 
		 Description='Clinician will assist Patient in exploring triggers or stressors through brainstorming, focused questions and Brief solution Focused Therapy techniques.'");
		sqlInsert("INSERT INTO form_treatment_plan_interventions set pid = {$_SESSION["pid"]}, form_id=$newid,tp_problem_number='2', problem_id=$problem2_id, ObjectiveID=$objectives23_id, 
		 Description='Clinician will teach the Patient coping strategies (e.g., reframing, physical exercise, social activities, progress muscle relaxation, deep breathing, thought-stopping technique) using psycho-education and Cognitive Behavioral Therapy techniques.'");
	/*discharge criteria*/ 
		sqlInsert("INSERT INTO form_treatment_plan_dischargecriteria set pid = {$_SESSION["pid"]}, form_id=$newid, 
		 criteria='The patient will meet the criteria for discharge when he/she meets treatment goals. The patient will participate and cooperate with the assessment process. The patient will provide all necessary information to develop treatment plan and comply with treatment recommendations such as medication, individual, and/or family counseling. Patient will identify 2 physical and 2 mental/emotional symptoms.'");
  

	

	
}elseif ($_GET["mode"] == "update") {
	$id = 0 + (isset($_GET['id']) ? $_GET['id'] : '');
	sqlInsert("update form_treatment_plan set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
	signatures_on_file='".$_POST["signatures_on_file"]."',
	status='".$_POST["status"]."'
	where id=$id");


}

$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");

if ($_GET["mode"] == ""){
	$address = "{$GLOBALS['rootdir']}/forms/treatment_plan/view.php?id=$newid";
	echo "\n<script language='Javascript'>top.restoreSession();window.location='$address';</script>\n";
	
}elseif ($_GET["mode"] == "intake") {
	$address = "{$GLOBALS['rootdir']}/forms/treatment_plan/view.php?id=$newid";
	echo "\n<script language='Javascript'>top.restoreSession();window.location='$address';</script>\n";

}elseif ($_GET["mode"] == "clone"){
	//$oldid = $_GET["id"];
	$oldid = $clone_tpid;
	echo "<br>cloned oldid = $oldid newid = $newid";
	$address = "{$GLOBALS['rootdir']}/forms/treatment_plan/view.php?id=$newid";
	//uncomment to show Link
	echo "<br><a href='".$address."'>".$address."</a>";
	//comment to prevent auto-redirect
	echo "\n<script language='Javascript'>top.restoreSession();window.location='$address';</script>\n";
	
}elseif ($_GET["mode"] == "update") {
	formJump();
}

formFooter();
?>

