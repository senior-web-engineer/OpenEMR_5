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
if ($_GET["mode"] == "new"){
$newid = formSubmit("form_cfars", $_POST, $_GET["id"], $userauthorized);
addForm($encounter, "CFARS", $newid, "cfars", $pid, $userauthorized);
}elseif ($_GET["mode"] == "update") {
$id = 0 + (isset($_GET['id']) ? $_GET['id'] : '');
sqlInsert("update form_cfars set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, 
date = NOW(), 
units ='1',
service_code ='H0031',
dcf_outcomes_report ='".$_POST["dcf_outcomes_report"]."', 
program_evaluation ='".$_POST["program_evaluation"]."', 
primary_diagnosis ='".$_POST["primary_diagnosis"]."', 
secondary_diagnosis ='".$_POST["secondary_diagnosis"]."', 
substance_abuse_history ='".$_POST["substance_abuse_history"]."', 
cfars_rater_notes ='".$_POST["cfars_rater_notes"]."', 
depression ='".$_POST["depression"]."',
depression_1 ='".$_POST["depression_1"]."', 
depression_2 ='".$_POST["depression_2"]."', 
depression_3 ='".$_POST["depression_3"]."', 
depression_4 ='".$_POST["depression_4"]."', 
depression_5 ='".$_POST["depression_5"]."', 
depression_6 ='".$_POST["depression_6"]."', 
depression_7 ='".$_POST["depression_7"]."', 
depression_8 ='".$_POST["depression_8"]."', 
depression_9 ='".$_POST["depression_9"]."', 
anxiety ='".$_POST["anxiety"]."', 
anxiety_1 ='".$_POST["anxiety_1"]."', 
anxiety_2 ='".$_POST["anxiety_2"]."', 
anxiety_3 ='".$_POST["anxiety_3"]."', 
anxiety_4 ='".$_POST["anxiety_4"]."', 
anxiety_5 ='".$_POST["anxiety_5"]."', 
anxiety_6 ='".$_POST["anxiety_6"]."', 
anxiety_7 ='".$_POST["anxiety_7"]."', 
anxiety_8 ='".$_POST["anxiety_8"]."', 
hyperactivity ='".$_POST["hyperactivity"]."', 
hyperactivity_1 ='".$_POST["hyperactivity_1"]."', 
hyperactivity_2 ='".$_POST["hyperactivity_2"]."', 
hyperactivity_3 ='".$_POST["hyperactivity_3"]."',
hyperactivity_4 ='".$_POST["hyperactivity_4"]."', 
hyperactivity_5 ='".$_POST["hyperactivity_5"]."', 
hyperactivity_6 ='".$_POST["hyperactivity_6"]."', 
hyperactivity_7 ='".$_POST["hyperactivity_7"]."', 
hyperactivity_8 ='".$_POST["hyperactivity_8"]."', 
hyperactivity_9 ='".$_POST["hyperactivity_9"]."', 
hyperactivity_10 ='".$_POST["hyperactivity_10"]."', 
hyperactivity_11 ='".$_POST["hyperactivity_11"]."', 
hyper_affect ='".$_POST["hyper_affect"]."',
hyper_affect_1 ='".$_POST["hyper_affect_1"]."',
hyper_affect_2 ='".$_POST["hyper_affect_2"]."',
hyper_affect_3 ='".$_POST["hyper_affect_3"]."',
hyper_affect_4 ='".$_POST["hyper_affect_4"]."',
hyper_affect_5 ='".$_POST["hyper_affect_5"]."',
hyper_affect_6 ='".$_POST["hyper_affect_6"]."',
hyper_affect_7 ='".$_POST["hyper_affect_7"]."',
hyper_affect_8 ='".$_POST["hyper_affect_8"]."',
hyper_affect_9 ='".$_POST["hyper_affect_9"]."',
thought_process ='".$_POST["thought_process"]."', 
thought_process_1 ='".$_POST["thought_process_1"]."', 
thought_process_2 ='".$_POST["thought_process_2"]."', 
thought_process_3 ='".$_POST["thought_process_3"]."', 
thought_process_4 ='".$_POST["thought_process_4"]."', 
thought_process_5 ='".$_POST["thought_process_5"]."', 
thought_process_6 ='".$_POST["thought_process_6"]."',
thought_process_7 ='".$_POST["thought_process_7"]."', 
thought_process_8 ='".$_POST["thought_process_8"]."', 
thought_process_9 ='".$_POST["thought_process_9"]."', 
thought_process_10 ='".$_POST["thought_process_10"]."',
thought_process_11 ='".$_POST["thought_process_11"]."',
thought_process_12 ='".$_POST["thought_process_12"]."',
cognitive_performance ='".$_POST["cognitive_performance"]."',
cognitive_performance_1 ='".$_POST["cognitive_performance_1"]."',
cognitive_performance_2 ='".$_POST["cognitive_performance_2"]."',
cognitive_performance_3 ='".$_POST["cognitive_performance_3"]."',
cognitive_performance_4 ='".$_POST["cognitive_performance_4"]."',
cognitive_performance_5 ='".$_POST["cognitive_performance_5"]."',
cognitive_performance_6 ='".$_POST["cognitive_performance_6"]."',
cognitive_performance_7 ='".$_POST["cognitive_performance_7"]."',
cognitive_performance_8 ='".$_POST["cognitive_performance_8"]."',
cognitive_performance_9 ='".$_POST["cognitive_performance_9"]."',
cognitive_performance_10 ='".$_POST["cognitive_performance_10"]."',
cognitive_performance_11 ='".$_POST["cognitive_performance_11"]."',
cognitive_performance_12 ='".$_POST["cognitive_performance_12"]."',
cognitive_performance_13 ='".$_POST["cognitive_performance_13"]."',
medical_physical ='".$_POST["medical_physical"]."',
medical_physical_1 ='".$_POST["medical_physical_1"]."',
medical_physical_2 ='".$_POST["medical_physical_2"]."',
medical_physical_3 ='".$_POST["medical_physical_3"]."',
medical_physical_4 ='".$_POST["medical_physical_4"]."',
medical_physical_5 ='".$_POST["medical_physical_5"]."',
medical_physical_6 ='".$_POST["medical_physical_6"]."',
medical_physical_7 ='".$_POST["medical_physical_7"]."',
medical_physical_8 ='".$_POST["medical_physical_8"]."',
medical_physical_9 ='".$_POST["medical_physical_9"]."',
medical_physical_10 ='".$_POST["medical_physical_10"]."',
medical_physical_11 ='".$_POST["medical_physical_11"]."',
medical_physical_12 ='".$_POST["medical_physical_12"]."',
traumatic_stress ='".$_POST["traumatic_stress"]."',
traumatic_stress_1 ='".$_POST["traumatic_stress_1"]."',
traumatic_stress_2 ='".$_POST["traumatic_stress_2"]."',
traumatic_stress_3 ='".$_POST["traumatic_stress_3"]."',
traumatic_stress_4 ='".$_POST["traumatic_stress_4"]."',
traumatic_stress_5 ='".$_POST["traumatic_stress_5"]."',
traumatic_stress_6 ='".$_POST["traumatic_stress_6"]."',
traumatic_stress_7 ='".$_POST["traumatic_stress_7"]."',
traumatic_stress_8 ='".$_POST["traumatic_stress_8"]."',
substance_use ='".$_POST["substance_use"]."',
substance_use_1 ='".$_POST["substance_use_1"]."',
substance_use_2 ='".$_POST["substance_use_2"]."',
substance_use_3 ='".$_POST["substance_use_3"]."',
substance_use_4 ='".$_POST["substance_use_4"]."',
substance_use_5 ='".$_POST["substance_use_5"]."',
substance_use_6 ='".$_POST["substance_use_6"]."',
substance_use_7 ='".$_POST["substance_use_7"]."',
substance_use_8 ='".$_POST["substance_use_8"]."',
substance_use_9 ='".$_POST["substance_use_9"]."',
substance_use_10 ='".$_POST["substance_use_10"]."',
substance_use_11 ='".$_POST["substance_use_11"]."',
substance_use_12 ='".$_POST["substance_use_12"]."',
interpersonal_relationships ='".$_POST["interpersonal_relationships"]."',
interpersonal_relationships_1 ='".$_POST["interpersonal_relationships_1"]."', 
interpersonal_relationships_2 ='".$_POST["interpersonal_relationships_2"]."', 
interpersonal_relationships_3 ='".$_POST["interpersonal_relationships_3"]."', 
interpersonal_relationships_4 ='".$_POST["interpersonal_relationships_4"]."', 
interpersonal_relationships_5 ='".$_POST["interpersonal_relationships_5"]."', 
interpersonal_relationships_6 ='".$_POST["interpersonal_relationships_6"]."', 
interpersonal_relationships_7 ='".$_POST["interpersonal_relationships_7"]."', 
family_relationships ='".$_POST["family_relationships"]."', 
family_relationships_1 ='".$_POST["family_relationships_1"]."',
family_relationships_2 ='".$_POST["family_relationships_2"]."',
family_relationships_3 ='".$_POST["family_relationships_3"]."',
family_relationships_4 ='".$_POST["family_relationships_4"]."',
family_relationships_5 ='".$_POST["family_relationships_5"]."',
family_relationships_6 ='".$_POST["family_relationships_6"]."',
family_relationships_7 ='".$_POST["family_relationships_7"]."',
family_relationships_8 ='".$_POST["family_relationships_8"]."',
family_relationships_9 ='".$_POST["family_relationships_9"]."',
family_environment ='".$_POST["family_relationships"]."', 
family_environment_1 ='".$_POST["family_environment_1"]."',
family_environment_2 ='".$_POST["family_environment_2"]."',
family_environment_3 ='".$_POST["family_environment_3"]."',
family_environment_4 ='".$_POST["family_environment_4"]."',
family_environment_5 ='".$_POST["family_environment_5"]."',
family_environment_6 ='".$_POST["family_environment_6"]."',
family_environment_7 ='".$_POST["family_environment_7"]."',
family_environment_8 ='".$_POST["family_environment_8"]."',
family_environment_9 ='".$_POST["family_environment_9"]."',
behavior_in_home_setting ='".$_POST["behavior_in_home_setting"]."',
behavior_in_home_setting_1 ='".$_POST["behavior_in_home_setting_1"]."',
behavior_in_home_setting_2 ='".$_POST["behavior_in_home_setting_2"]."',
behavior_in_home_setting_3 ='".$_POST["behavior_in_home_setting_3"]."',
behavior_in_home_setting_4 ='".$_POST["behavior_in_home_setting_4"]."',
behavior_in_home_setting_5 ='".$_POST["behavior_in_home_setting_5"]."',
behavior_in_home_setting_6 ='".$_POST["behavior_in_home_setting_6"]."',
behavior_in_home_setting_7 ='".$_POST["behavior_in_home_setting_7"]."',

adl_functioning ='".$_POST["adl_functioning"]."',
adl_functioning_1 ='".$_POST["adl_functioning_1"]."',
adl_functioning_2 ='".$_POST["adl_functioning_2"]."',
adl_functioning_3 ='".$_POST["adl_functioning_3"]."',
adl_functioning_4 ='".$_POST["adl_functioning_4"]."',
adl_functioning_5 ='".$_POST["adl_functioning_5"]."',
adl_functioning_6 ='".$_POST["adl_functioning_6"]."',
adl_functioning_7 ='".$_POST["adl_functioning_7"]."',
adl_functioning_8 ='".$_POST["adl_functioning_8"]."',
socio_legal ='".$_POST["socio_legal"]."',
socio_legal_1 ='".$_POST["socio_legal_1"]."',
socio_legal_2 ='".$_POST["socio_legal_2"]."',
socio_legal_3 ='".$_POST["socio_legal_3"]."',
socio_legal_4 ='".$_POST["socio_legal_4"]."',
socio_legal_5 ='".$_POST["socio_legal_5"]."',
socio_legal_6 ='".$_POST["socio_legal_6"]."',
socio_legal_7 ='".$_POST["socio_legal_7"]."',
socio_legal_8 ='".$_POST["socio_legal_8"]."',
socio_legal_9 ='".$_POST["socio_legal_9"]."',
socio_legal_10 ='".$_POST["socio_legal_10"]."',
socio_legal_11 ='".$_POST["socio_legal_11"]."',
work_or_school ='".$_POST["work_or_school"]."',
work_or_school_option ='".$_POST["work_or_school_option"]."',
work_or_school_1 ='".$_POST["work_or_school_1"]."',
work_or_school_2 ='".$_POST["work_or_school_2"]."',
work_or_school_3 ='".$_POST["work_or_school_3"]."',
work_or_school_4 ='".$_POST["work_or_school_4"]."',
work_or_school_5 ='".$_POST["work_or_school_5"]."',
work_or_school_6 ='".$_POST["work_or_school_6"]."',
work_or_school_7 ='".$_POST["work_or_school_7"]."',
work_or_school_8 ='".$_POST["work_or_school_8"]."',
work_or_school_9 ='".$_POST["work_or_school_9"]."',
work_or_school_10 ='".$_POST["work_or_school_10"]."',
work_or_school_11 ='".$_POST["work_or_school_11"]."',
work_or_school_12 ='".$_POST["work_or_school_12"]."',
work_or_school_13 ='".$_POST["work_or_school_13"]."',
work_or_school_14 ='".$_POST["work_or_school_14"]."',
work_or_school_15 ='".$_POST["work_or_school_15"]."',
ability_to_care_for_self ='".$_POST["ability_to_care_for_self"]."',
ability_to_care_for_self_1 ='".$_POST["ability_to_care_for_self_1"]."',
ability_to_care_for_self_2 ='".$_POST["ability_to_care_for_self_2"]."',
ability_to_care_for_self_3 ='".$_POST["ability_to_care_for_self_3"]."',
ability_to_care_for_self_4 ='".$_POST["ability_to_care_for_self_4"]."',
ability_to_care_for_self_5 ='".$_POST["ability_to_care_for_self_5"]."',
ability_to_care_for_self_6 ='".$_POST["ability_to_care_for_self_6"]."',
danger_to_self ='".$_POST["danger_to_self"]."',
danger_to_self_1 ='".$_POST["danger_to_self_1"]."',
danger_to_self_2 ='".$_POST["danger_to_self_2"]."',
danger_to_self_3 ='".$_POST["danger_to_self_3"]."',
danger_to_self_4 ='".$_POST["danger_to_self_4"]."',
danger_to_self_5 ='".$_POST["danger_to_self_5"]."',
danger_to_self_6 ='".$_POST["danger_to_self_6"]."',
danger_to_self_7 ='".$_POST["danger_to_self_7"]."',
danger_to_self_8 ='".$_POST["danger_to_self_8"]."',
danger_to_self_9 ='".$_POST["danger_to_self_9"]."',
danger_to_others ='".$_POST["danger_to_others"]."',
danger_to_others_1 ='".$_POST["danger_to_others_1"]."',
danger_to_others_2 ='".$_POST["danger_to_others_2"]."',
danger_to_others_3 ='".$_POST["danger_to_others_3"]."',
danger_to_others_4 ='".$_POST["danger_to_others_4"]."',
danger_to_others_5 ='".$_POST["danger_to_others_5"]."',
danger_to_others_6 ='".$_POST["danger_to_others_6"]."',
danger_to_others_7 ='".$_POST["danger_to_others_7"]."',
danger_to_others_8 ='".$_POST["danger_to_others_8"]."',
danger_to_others_9 ='".$_POST["danger_to_others_9"]."',
danger_to_others_10 ='".$_POST["danger_to_others_10"]."',
danger_to_others_11 ='".$_POST["danger_to_others_11"]."',
danger_to_others_12 ='".$_POST["danger_to_others_12"]."',
security_management_needs ='".$_POST["security_management_needs"]."',
security_management_needs_1 ='".$_POST["security_management_needs_1"]."',
security_management_needs_2 ='".$_POST["security_management_needs_2"]."',
security_management_needs_3 ='".$_POST["security_management_needs_3"]."',
security_management_needs_4 ='".$_POST["security_management_needs_4"]."',
security_management_needs_5 ='".$_POST["security_management_needs_5"]."',
security_management_needs_6 ='".$_POST["security_management_needs_6"]."',
security_management_needs_7 ='".$_POST["security_management_needs_7"]."',
security_management_needs_8 ='".$_POST["security_management_needs_8"]."',
security_management_needs_9 ='".$_POST["security_management_needs_9"]."',
security_management_needs_10 ='".$_POST["security_management_needs_10"]."',
security_management_needs_11 ='".$_POST["security_management_needs_11"]."',
security_management_needs_12 ='".$_POST["security_management_needs_12"]."',
security_management_needs_13 ='".$_POST["security_management_needs_13"]."',
security_management_needs_14 ='".$_POST["security_management_needs_14"]."',
status ='".$_POST["status"]."',
provider_print_name = '".$_POST["provider_print_name"]."'
where id=$id");
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();
?>