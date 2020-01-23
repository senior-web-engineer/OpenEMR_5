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
					ProblemNumber, Description, approach_note, IsCustom, IsPrimary 
				FROM openemr.form_progress_problems 
				WHERE (IsDeleted = 0 or IsDeleted is null) 
					and pid = {$_SESSION["pid"]} and form_id = " . getPost("form_id",-1) . "
				ORDER BY IsPrimary Asc ";
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
				WHERE (IsDeleted = 0 or IsDeleted is null) 
					and pid = {$_SESSION["pid"]} and form_id = " . getPost("form_id",-1) . " 
					and problem_id = " . add_escape_custom(getPost("problem_id",0)) . "";
        $res = sqlStatement($sql);
        while($row = SqlFetchArray($res)){
            $rows['list'][] = $row;
        }
        $output = json_encode($rows);
		break;
	case "getgoals":
        $rows = array();
		$sql = "SELECT id, pid, form_id, tp_problem_number, GroupID, 
					ProblemNumber, GoalNumber, Description, IsCustom, goal_status, goal_action, review_status
				FROM openemr.form_progress_notes_goals
				WHERE (IsDeleted = 0 or IsDeleted is null) 
					and pid = {$_SESSION["pid"]} and form_id = " . getPost("form_id",-1) . " 
					and problem_id = " . add_escape_custom(getPost("problem_id",0)) . "";
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
				FROM openemr.form_progress_notes_objectives
				WHERE (IsDeleted = 0 or IsDeleted is null) 
					and pid = {$_SESSION["pid"]} and form_id = " . getPost("form_id",-1) . " 
					and problem_id = " . add_escape_custom(getPost("problem_id",0)) . "";
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
				FROM openemr.form_progress_notes_interventions
				WHERE (IsDeleted = 0 or IsDeleted is null) 
					and pid = {$_SESSION["pid"]} and form_id = " . getPost("form_id",-1) . " 
					";
        $res = sqlStatement($sql);
        while($row = SqlFetchArray($res)){
            $rows['list'][] = $row;
        }
        $output = json_encode($rows);
		break;
		
		
   case "getmodalities":
        $rows = array();
		$sql = "SELECT id, pid, form_id, user, start_date, end_date, modality, hcpt, intervals, frequency, duration_hour, duration_minute, provider, Description, tp_problem_number
				FROM openemr.form_progress_notes_interventions
				WHERE (IsDeleted = 0 or IsDeleted is null) 
					and problem_id = " . add_escape_custom(getPost("problem_id",0)) . "
					and pid = {$_SESSION["pid"]} and form_id = " . getPost("form_id",-1) . "";
        $res = sqlStatement($sql);
        while($row = SqlFetchArray($res)){
            $rows['list'][] = $row;
        }
        $output = json_encode($rows);
		break;
   case "getmodalitynotes":
        $rows = array();
		$sql = "SELECT id, pid, form_id, Notes, user
				FROM openemr.form_treatment_plan_modalitynotes
				WHERE (IsDeleted = 0 or IsDeleted is null) 
					and pid = {$_SESSION["pid"]} and form_id = " . getPost("form_id",-1) . "";
        $res = sqlStatement($sql);
        while($row = SqlFetchArray($res)){
            $rows['list'][] = $row;
        }
        $output = json_encode($rows);
		break;
	case "getdischargecriteria":
        $rows = array();
		$sql = "SELECT id, pid, form_id, Criteria, user
				FROM openemr.form_treatment_plan_dischargecriteria
				WHERE (IsDeleted = 0 or IsDeleted is null) 
					and pid = {$_SESSION["pid"]} and form_id = " . getPost("form_id",-1) . "";
        $res = sqlStatement($sql);
        while($row = SqlFetchArray($res)){
            $rows['list'][] = $row;
        }
        $output = json_encode($rows);
		break;

	case "getstrength":
        $rows = array();
		$sql = "SELECT id, pid, form_id, Description, user
				FROM openemr.form_treatment_plan_strength
				WHERE (IsDeleted = 0 or IsDeleted is null) 
					and type = '1' 
					and pid = {$_SESSION["pid"]} and form_id = " . getPost("form_id",-1) . "";
        $res = sqlStatement($sql);
        while($row = SqlFetchArray($res)){
            $rows['list'][] = $row;
        }
        $output = json_encode($rows);
		break;	
	case "getweakness":
        $rows = array();
		$sql = "SELECT id, pid, form_id, Description, user, type
				FROM openemr.form_treatment_plan_strength
				WHERE (IsDeleted = 0 or IsDeleted is null) 
					and type = '0'
					and pid = {$_SESSION["pid"]} and form_id = " . getPost("form_id",-1) . "";
        $res = sqlStatement($sql);
        while($row = SqlFetchArray($res)){
            $rows['list'][] = $row;
        }
        $output = json_encode($rows);
		break;				
	case "getsummary":
        $rows = array();
		$sql = "SELECT id, pid, form_id, Description, user
				FROM openemr.form_treatment_plan_summary
				WHERE (IsDeleted = 0 or IsDeleted is null) 
					and pid = {$_SESSION["pid"]} and form_id = " . getPost("form_id",-1) . "";
        $res = sqlStatement($sql);
        while($row = SqlFetchArray($res)){
            $rows['list'][] = $row;
        }
        $output = json_encode($rows);
		break;		
   case "getdiagnosis":
        $rows = array();
		$sql = "SELECT id, pid, form_id, LegalCode, Description, 
					Axis, cgaf_score, pgaf_score, stress_rating
				FROM openemr.form_treatment_plan_diagnosis
				WHERE (IsDeleted = 0 or IsDeleted is null) 
					and axis = " . getPost("axis",0) . "  
					and pid = {$_SESSION["pid"]} and form_id = " . getPost("form_id",-1) . "";
        $res = sqlStatement($sql);
        while($row = SqlFetchArray($res)){
            $rows['list'][] = $row;
        }
        $output = json_encode($rows);
		break;		


	default:
        $output = "{\"api\": \"$api\"}";
		break;
}
$_SESSION["encounter"] = $encounter;
//echo($test);
echo "{\"data\": $output, \"error\": \"$errorString\", \"message\": \"$message\"}";
?>

