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
    case "savetreatmentplan": 
		$sets = "pid = {$_SESSION["pid"]},
			groupname = '" . $_SESSION["authProvider"] . "',
			user = '" . $_SESSION["authUser"] . "',
			authorized = $userauthorized, 
			activity=1, 
			date = NOW()
			";
		if (empty($id) || $id == -1) {
		  $newid = sqlInsert("INSERT INTO form_progress_note SET $sets");
		  addForm($encounter, "Progress Note Yahoo", $newid, "progress_note", $pid, $userauthorized);
		  $id = $newid;
		} else {
		  sqlStatement("UPDATE form_progress_note SET $sets WHERE id = ". add_escape_custom("$id"). "");
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
			IsCustom = " . add_escape_custom(getPost("IsCustom",0)) .  ",
			IsDeleted = " . add_escape_custom(getPost("IsDeleted",0)) .  ",
			IsPrimary = " . add_escape_custom(getPost("IsPrimary",0)) .  "
			";
		if (empty($id) || $id == -1) {
		  $id = sqlInsert("INSERT INTO form_progress_problems SET $sets");
		} else {
		  sqlStatement("UPDATE form_progress_problems SET $sets WHERE id = ". add_escape_custom("$id"). "");
		}
		$output = "{\"id\": \"$id\"}";
		break;
    case "saveproblemprimary": 
		//sqlStatement("UPDATE form_treatment_plan_problems SET IsPrimary = 0 WHERE form_id = ". add_escape_custom(getPost("form_id",0)). "");
		//sqlStatement("UPDATE form_treatment_plan_problems SET IsPrimary = 1 WHERE id = ". add_escape_custom("$id"). "");
		sqlStatement("UPDATE form_progress_problems SET IsPrimary = ". add_escape_custom(getPost("IsPrimary",0)) .  " WHERE id = ". add_escape_custom("$id"). "");
		
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
			IsCustom = " . add_escape_custom(getPost("IsCustom",0)) .  " ,
			IsDeleted = " . add_escape_custom(getPost("IsDeleted",0)) .  ",
			problem_id = " . add_escape_custom(getPost("problem_id",0)) .  "
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
			IsCustom = " . add_escape_custom(getPost("IsCustom",0)) .  " ,
			goal_status = '" . add_escape_custom(getPost("goal_status",'')) .  "', 
			goal_action = '" . add_escape_custom(getPost("goal_action",'')) .  "', 
			review_status = '" . add_escape_custom(getPost("review_status",'')) .  "', 
			IsDeleted = " . add_escape_custom(getPost("IsDeleted",0)) .  ",
			problem_id = " . add_escape_custom(getPost("problem_id",0)) .  "
			";
		if (empty($id) || $id == -1) {
		  $id = sqlInsert("INSERT INTO form_progress_notes_goals SET $sets ");
		} else {
		  sqlStatement("UPDATE form_progress_notes_goals SET $sets WHERE id = ". add_escape_custom("$id"). "");
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
			IsEvidenceBased = " . add_escape_custom(getPost("IsEvidenceBased",0)) .  " ,
			IsDeleted = " . add_escape_custom(getPost("IsDeleted",0)) .  ",
			problem_id = " . add_escape_custom(getPost("problem_id",0)) .  "
			";
		if (empty($id) || $id == -1) {
		  $id = sqlInsert("INSERT INTO form_progress_notes_objectives SET $sets ");
		} else {
		  sqlStatement("UPDATE form_progress_notes_objectives SET $sets WHERE id = ". add_escape_custom("$id"). "");
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
			ObjectiveID = " . add_escape_custom(getPost("ObjectiveID",0)) .  " ,
			IsDeleted = " . add_escape_custom(getPost("IsDeleted",0)) .  " ,
			problem_id = " . add_escape_custom(getPost("problem_id",0)) .  "
			";
		if (empty($id) || $id == -1) {
		  $id = sqlInsert("INSERT INTO form_progress_notes_interventions SET $sets ");
		} else {
		  sqlStatement("UPDATE form_progress_notes_interventions SET $sets WHERE id = ". add_escape_custom("$id"). "");
		}
		$output = "{\"id\": \"$id\"}";
		break;
	case "savemodalities":
		$sets = "pid = {$_SESSION["pid"]},
			form_id = " . add_escape_custom(getPost("form_id",0)) .  ", 
			user = '" . add_escape_custom(getPost("user",'')) .  "', 
			Description = '" . add_escape_custom(getPost("Description",'')) .  "', 
			tp_problem_number = " . add_escape_custom(getPost("tp_problem_number",0)) .  ",
			IsDeleted = " . add_escape_custom(getPost("IsDeleted",0)) .  ",
			problem_id = " . add_escape_custom(getPost("problem_id",0)) .  "
			";
		if (empty($id) || $id == -1) {
		  $id = sqlInsert("INSERT INTO form_progress_notes_interventions SET $sets ");
		} else {
		  sqlStatement("UPDATE form_progress_notes_interventions SET $sets WHERE id = ". add_escape_custom("$id"). "");
		}
		$output = "{\"id\": \"$id\"}";
		break;
	case "savemodalitynotes":
		$sets = "pid = {$_SESSION["pid"]},
			form_id = " . add_escape_custom(getPost("form_id",0)) .  ", 
			user = '" . $_SESSION["authUser"] . "',
			Notes = '" . add_escape_custom(getPost("Notes",'')) .  "',
			IsDeleted = " . add_escape_custom(getPost("IsDeleted",0)) .  "
			";
		if (empty($id) || $id == -1) {
		  $id = sqlInsert("INSERT INTO form_treatment_plan_modalitynotes SET $sets ");
		} else {
		  sqlStatement("UPDATE form_treatment_plan_modalitynotes SET $sets WHERE id = ". add_escape_custom("$id"). "");
		}
		$output = "{\"id\": \"$id\"}";
		break;
	case "savedischargecriteria":
		$sets = "pid = {$_SESSION["pid"]},
			form_id = " . add_escape_custom(getPost("form_id",0)) .  ", 
			user = '" . $_SESSION["authUser"] . "',
			Criteria = '" . add_escape_custom(getPost("Criteria",'')) .  "',
			IsDeleted = " . add_escape_custom(getPost("IsDeleted",0)) .  "
			";
		if (empty($id) || $id == -1) {
		  $id = sqlInsert("INSERT INTO form_treatment_plan_dischargecriteria SET $sets ");
		} else {
		  sqlStatement("UPDATE form_treatment_plan_dischargecriteria SET $sets WHERE id = ". add_escape_custom("$id"). "");
		}
		$output = "{\"id\": \"$id\"}";
		break;

		case "savestrength":
		$sets = "pid = {$_SESSION["pid"]},
			form_id = " . add_escape_custom(getPost("form_id",0)) .  ", 
			user = '" . $_SESSION["authUser"] . "',
			Description = '" . add_escape_custom(getPost("Description",'')) .  "',
			type = '1',
			IsDeleted = " . add_escape_custom(getPost("IsDeleted",0)) .  "
			";
		if (empty($id) || $id == -1) {
		  $id = sqlInsert("INSERT INTO form_treatment_plan_strength SET $sets ");
		} else {
		  sqlStatement("UPDATE form_treatment_plan_strength SET $sets WHERE id = ". add_escape_custom("$id"). "");
		}
		$output = "{\"id\": \"$id\"}";
		break;
		case "saveweakness":
		$sets = "pid = {$_SESSION["pid"]},
			form_id = " . add_escape_custom(getPost("form_id",0)) .  ", 
			user = '" . $_SESSION["authUser"] . "',
			Description = '" . add_escape_custom(getPost("Description",'')) .  "',
			type = '0',
			IsDeleted = " . add_escape_custom(getPost("IsDeleted",0)) .  "
			";
		if (empty($id) || $id == -1) {
		  $id = sqlInsert("INSERT INTO form_treatment_plan_strength SET $sets ");
		} else {
		  sqlStatement("UPDATE form_treatment_plan_strength SET $sets WHERE id = ". add_escape_custom("$id"). "");
		}
		$output = "{\"id\": \"$id\"}";
		break;
		case "savesummary":
		$sets = "pid = {$_SESSION["pid"]},
			form_id = " . add_escape_custom(getPost("form_id",0)) .  ", 
			user = '" . $_SESSION["authUser"] . "',
			Description = '" . add_escape_custom(getPost("Description",'')) .  "',
			IsDeleted = " . add_escape_custom(getPost("IsDeleted",0)) .  "
			";
		if (empty($id) || $id == -1) {
		  $id = sqlInsert("INSERT INTO form_treatment_plan_summary SET $sets ");
		} else {
		  sqlStatement("UPDATE form_treatment_plan_summary SET $sets WHERE id = ". add_escape_custom("$id"). "");
		}
		$output = "{\"id\": \"$id\"}";
		break;


	case "savediagnosis":
		$sets = "pid = {$_SESSION["pid"]},
			form_id = " . add_escape_custom(getPost("form_id",0)) .  ", 
			LegalCode = '" . add_escape_custom(getPost("LegalCode",'')) .  "',
			Description = '" . add_escape_custom(getPost("Description",'')) .  "',
			Axis = '" . add_escape_custom(getPost("Axis",'')) .  "',
			cgaf_score = '" . add_escape_custom(getPost("cgaf_score",'')) .  "',
			pgaf_score = '" . add_escape_custom(getPost("pgaf_score",'')) .  "',
			stress_rating = '" . add_escape_custom(getPost("stress_rating",'')) .  "',
			IsDeleted = " . add_escape_custom(getPost("IsDeleted",0)) .  "
			";
		if (empty($id) || $id == -1) {
		  $id = sqlInsert("INSERT INTO form_treatment_plan_diagnosis SET $sets ");
		} else {
		  sqlStatement("UPDATE form_treatment_plan_diagnosis SET $sets WHERE id = ". add_escape_custom("$id"). "");
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

