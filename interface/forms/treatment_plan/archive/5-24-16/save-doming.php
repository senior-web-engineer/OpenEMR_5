<?php
//$sanitize_all_escapes=$_POST['true']; //SANITIZE ALL ESCAPES

//$fake_register_globals=$_POST['false']; //STOP FAKE REGISTER GLOBALS

include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");
require_once("$srcdir/formdata.inc.php");
include_once("$srcdir/jsonwrapper/jsonwrapper.php");

header('Content-Type: application/json'); //sets the response type

//init main variables
$api = getPost('api','');
$id = 0 + (getPost('id',''));
$output = "null";
$errorString = "";
$message = "";

//helper functions
function customError($errno, $errstr) {
  $errorString = "[$errno] $errstr";
  echo "{\"data\": null, \"error\": \"$errorString\"}";
  die();
}
set_error_handler("customError");

function getPost($key, $default = '') {
    if (isset($_POST[$key])) return $_POST[$key];
    if (isset($_GET[$key])) return $_GET[$key];
    return $default;
}

//start processing the form
if ($encounter == "")
	$encounter = date("Ymd"); //this was put here to spoof the encounter check
	
if (! $encounter) { // comes from globals.php
	$errorString = "Internal error: we do not seem to be in an encounter!";
	$api = "error";
	//die(xl("Internal error: we do not seem to be in an encounter!"));
}

switch ($api){
	case "getproblems":
        $rows = array();
		$sql = "SELECT id, pid, form_id, tp_problem_number, GroupID, 
					ProblemNumber, Description, approach_note, IsCustom
				FROM openemr.form_treatment_plan_problems 
				WHERE pid = {$_SESSION["pid"]} and form_id = " . getPost("form_id",-1) . "";
        $res = sqlStatement($sql);
        while($row = SqlFetchArray($res)){
            $rows['list'][] = $row;
        }
        $output = json_encode($rows);
		break;
	case "getbds":
        $rows = array();
		$sql = "SELECT id, pid, form_id, tp_problem_number, GroupID, 
					ProblemNumber, DefinitionNumber, Description, IsCustom
				FROM openemr.form_treatment_plan_behavioraldefinitions
				WHERE pid = {$_SESSION["pid"]} and form_id = " . getPost("form_id",-1) . " 
					and tp_problem_number = " . add_escape_custom(getPost("tp_problem_number",0)) . "";
        $res = sqlStatement($sql);
        while($row = SqlFetchArray($res)){
            $rows['list'][] = $row;
        }
        $output = json_encode($rows);
		break;
	case "getgoals":
        $rows = array();
		$sql = "SELECT id, pid, form_id, tp_problem_number, GroupID, 
					ProblemNumber, GoalNumber, Description, IsCustom
				FROM openemr.form_treatment_plan_goals
				WHERE pid = {$_SESSION["pid"]} and form_id = " . getPost("form_id",-1) . " 
					and tp_problem_number = " . add_escape_custom(getPost("tp_problem_number",0)) . "";
        $res = sqlStatement($sql);
        while($row = SqlFetchArray($res)){
            $rows['list'][] = $row;
        }
        $output = json_encode($rows);
		break;
	case "getobjectives":
        $rows = array();
		$sql = "SELECT id, pid, form_id, tp_problem_number, target_date, 
					sessions, IsCritical, GroupID, ProblemNumber, ObjectiveNumber,
					Description, IsCustom, IsEvidenceBased
				FROM openemr.form_treatment_plan_objectives
				WHERE pid = {$_SESSION["pid"]} and form_id = " . getPost("form_id",-1) . " 
					and tp_problem_number = " . add_escape_custom(getPost("tp_problem_number",0)) . "";
        $res = sqlStatement($sql);
        while($row = SqlFetchArray($res)){
            $rows['list'][] = $row;
        }
        $output = json_encode($rows);
		break;
	case "getinterventions":
        $rows = array();
		$sql = "SELECT id, pid, form_id, tp_problem_number, sessions, 
					user, GroupID, ProblemNumber, InterventionNumber, 
					Description, ShortDescription, IsCustom, IsEvidenceBased
				FROM openemr.form_treatment_plan_interventions
				WHERE pid = {$_SESSION["pid"]} and form_id = " . getPost("form_id",-1) . " 
					and tp_problem_number = " . add_escape_custom(getPost("tp_problem_number",0)) . "
					and ObjectiveID = " . add_escape_custom(getPost("ObjectiveID",0)) . "
					";
        $res = sqlStatement($sql);
        while($row = SqlFetchArray($res)){
            $rows['list'][] = $row;
        }
        $output = json_encode($rows);
		break;

		
    case "savetreatmentplan": 
		$sets = "pid = {$_SESSION["pid"]},
			groupname = '" . $_SESSION["authProvider"] . "',
			user = '" . $_SESSION["authUser"] . "',
			authorized = $userauthorized, 
			activity=1, 
			date = NOW()
			";
		if (empty($id) || $id == -1) {
		  $newid = sqlInsert("INSERT INTO form_treatment_plan SET $sets");
		  addForm($encounter, "Treatment Plan", $newid, "treatment_plan", $pid, $userauthorized);
		  $id = $newid;
		} else {
		  sqlStatement("UPDATE form_treatment_plan SET $sets WHERE id = ". add_escape_custom("$id"). "");
		}
		$output = "{\"id\": \"$id\"}";
		break;
    case "saveproblems": 
		$sets = "pid = {$_SESSION["pid"]},
			form_id = " . add_escape_custom(getPost("form_id",0)) .  ", 
			tp_problem_number = " . add_escape_custom(getPost("tp_problem_number",0)) .  ", 
			GroupID = " . add_escape_custom(getPost("GroupID",0)) .  ", 
			ProblemNumber = " . add_escape_custom(getPost("ProblemNumber",0)) .  ", 
			Description = '" . add_escape_custom(getPost("Description",'')) .  "', 
			approach_note = '" . add_escape_custom(getPost("approach_note",'')) .  "', 
			IsCustom = " . add_escape_custom(getPost("IsCustom",0)) .  "
			";
		if (empty($id) || $id == -1) {
		  $id = sqlInsert("INSERT INTO form_treatment_plan_problems SET $sets");
		} else {
		  sqlStatement("UPDATE form_treatment_plan_problems SET $sets WHERE id = ". add_escape_custom("$id"). "");
		}
		$output = "{\"id\": \"$id\"}";
		break;
	case "savebehavioraldefinitions":
		$sets = "pid = {$_SESSION["pid"]},
			form_id = " . add_escape_custom(getPost("form_id",0)) .  ", 
			tp_problem_number = " . add_escape_custom(getPost("tp_problem_number",0)) .  ", 
			GroupID = " . add_escape_custom(getPost("GroupID",0)) .  ", 
			ProblemNumber = " . add_escape_custom(getPost("ProblemNumber",0)) .  ", 
			DefinitionNumber = " . add_escape_custom(getPost("DefinitionNumber", 0)) .  ", 
			Description = '" . add_escape_custom(getPost("Description",'')) .  "', 
			IsCustom = " . add_escape_custom(getPost("IsCustom",0)) .  " 
			";
		if (empty($id) || $id == -1) {
		  $id = sqlInsert("INSERT INTO form_treatment_plan_behavioraldefinitions SET $sets ");
		} else {
		  sqlStatement("UPDATE form_treatment_plan_behavioraldefinitions SET $sets WHERE id = ". add_escape_custom("$id"). "");
		}
		$output = "{\"id\": \"$id\"}";
		break;
	case "savegoals":
		$sets = "pid = {$_SESSION["pid"]},
			form_id = " . add_escape_custom(getPost("form_id",0)) .  ", 
			tp_problem_number = " . add_escape_custom(getPost("tp_problem_number",0)) .  ", 
			GroupID = " . add_escape_custom(getPost("GroupID",0)) .  ", 
			ProblemNumber = " . add_escape_custom(getPost("ProblemNumber",0)) .  ", 
			GoalNumber = " . add_escape_custom(getPost("GoalNumber",0)) .  ", 
			Description = '" . add_escape_custom(getPost("Description",'')) .  "', 
			IsCustom = " . add_escape_custom(getPost("IsCustom",0)) .  " 
			";
		if (empty($id) || $id == -1) {
		  $id = sqlInsert("INSERT INTO form_treatment_plan_goals SET $sets ");
		} else {
		  sqlStatement("UPDATE form_treatment_plan_goals SET $sets WHERE id = ". add_escape_custom("$id"). "");
		}
		$output = "{\"id\": \"$id\"}";
		break;
	case "saveobjectives":
		$sets = "pid = {$_SESSION["pid"]},
			form_id = " . add_escape_custom(getPost("form_id",0)) .  ", 
			tp_problem_number = " . add_escape_custom(getPost("tp_problem_number",0)) .  ", 
			target_date = '" . add_escape_custom(getPost("target_date",'')) .  "', 
			sessions = " . add_escape_custom(getPost("sessions",0)) .  ", 
			IsCritical = " . add_escape_custom(getPost("IsCritical",0)) .  ", 
			GroupID = " . add_escape_custom(getPost("GroupID",0)) .  ", 
			ProblemNumber = " . add_escape_custom(getPost("ProblemNumber",0)) .  ", 
			ObjectiveNumber = " . add_escape_custom(getPost("ObjectiveNumber",0)) .  ", 
			Description = '" . add_escape_custom(getPost("Description",'')) .  "', 
			IsCustom = " . add_escape_custom(getPost("IsCustom",0)) .  ", 
			IsEvidenceBased = " . add_escape_custom(getPost("IsEvidenceBased",0)) .  " 
			";
		if (empty($id) || $id == -1) {
		  $id = sqlInsert("INSERT INTO form_treatment_plan_objectives SET $sets ");
		} else {
		  sqlStatement("UPDATE form_treatment_plan_objectives SET $sets WHERE id = ". add_escape_custom("$id"). "");
		}
		$output = "{\"id\": \"$id\"}";
		break;
	case "saveinterventions":
		$sets = "pid = {$_SESSION["pid"]},
			form_id = " . add_escape_custom(getPost("form_id",0)) .  ", 
			tp_problem_number = " . add_escape_custom(getPost("tp_problem_number",0)) .  ", 
			sessions = " . add_escape_custom(getPost("sessions",0)) .  ", 
			user = '" . add_escape_custom(getPost("user",'')) .  "', 
			GroupID = " . add_escape_custom(getPost("GroupID",0)) .  ", 
			ProblemNumber = " . add_escape_custom(getPost("ProblemNumber",0)) .  ", 
			InterventionNumber = " . add_escape_custom(getPost("InterventionNumber",0)) .  ", 
			Description = '" . add_escape_custom(getPost("Description",'')) .  "', 
			ShortDescription = '" . add_escape_custom(getPost("ShortDescription",'')) .  "', 
			IsCustom = " . add_escape_custom(getPost("IsCustom",0)) .  ", 
			IsEvidenceBased = " . add_escape_custom(getPost("IsEvidenceBased",0)) .  ", 
			ObjectiveID = " . add_escape_custom(getPost("ObjectiveID",0)) .  " 
			";
		if (empty($id) || $id == -1) {
		  $id = sqlInsert("INSERT INTO form_treatment_plan_interventions SET $sets ");
		} else {
		  sqlStatement("UPDATE form_treatment_plan_interventions SET $sets WHERE id = ". add_escape_custom("$id"). "");
		}
		$output = "{\"id\": \"$id\"}";
		break;

	default:
        $output = "{\"api\": \"$api\"}";
		break;
}
$_SESSION["encounter"] = $encounter;
//echo($test);
echo "{\"data\": $output, \"error\": \"$errorString\", \"message\": \"$message\"}";
?>

