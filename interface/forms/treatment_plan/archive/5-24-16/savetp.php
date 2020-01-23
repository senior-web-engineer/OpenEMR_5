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
if ($_GET["mode"] == ""){
	$newid = formSubmit("form_treatment_plan", $_POST, $_GET["id"], $userauthorized);
	print 'formSubmitt';  /*debugging */
	addForm($encounter, "Treatment Plan", $newid, "treatment_plan", $pid, $userauthorized);
}elseif ($_GET["mode"] == "update") {
	sqlInsert("update form_treatment_plan set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(),
	service_code='H0032',
    service_name='Treatment Plan',
 	status='".$_POST["status"]."'
	where id=$id");

	/*
	sqlInsert("update form_psych_eval set pid = {$_SESSION["pid"]},groupname='".$_SESSION["authProvider"]."',user='".$_SESSION["authUser"]."',authorized=$userauthorized,activity=1, date = NOW(), 
	dcn='".$_POST["dcn"]."', 
	location='".$_POST["location"]."',
	timestart='".$_POST["timestart"]."',
	timeend='".$_POST["timeend"]."',
	referral_source='".$_POST["referral_source"]."',
	new_client_eval='".$_POST["new_client_eval"]."',
	readmission='".$_POST["readmission"]."',
	consultation='".$_POST["consultation"]."',
	copy_sent_to='".$_POST["copy_sent_to"]."',
	reason_why='".$_POST["reason_why"]."',
	
	provider='".$_POST["provider"]."',
	units='1',
	servicecode='".$_POST["servicecode"]."',
	complaint='".$_POST["complaint"]."',
	background_history='".$_POST["background_history"]."',
	mh_history ='".$_POST["mh_history"]."',
	history_of_present_illness ='".$_POST["history_of_present_illness"]."',
	fam_mh_history ='".$_POST["fam_mh_history"]."',
	sa_history='".$_POST["sa_history"]."',
	fam_sa_history='".$_POST["fam_sa_history"]."',
	phys_history='".$_POST["phys_history"]."',
	dev_history='".$_POST["dev_history"]."',
	med_history='".$_POST["med_history"]."',
	abuse_history='".$_POST["abuse_history"]."',
	violent_history='".$_POST["violent_history"]."',
	education_history='".$_POST["education_history"]."',
	empl_history='".$_POST["empl_history"]."',
	legal_history='".$_POST["legal_history"]."',
	school_work='".$_POST["school_work"]."',
	personal_relationships='".$_POST["personal_relationships"]."',
	fatherc='".$_POST["fatherc"]."',
	motherc='".$_POST["motherc"]."',
	father_involved='".$_POST["father_involved"]."',
	mother_involved='".$_POST["mother_involved"]."',
	number_children='".$_POST["number_children"]."',
	siblings='".$_POST["siblings"]."',
	other_relationships='".$_POST["other_relationships"]."',
	social_relationships='".$_POST["social_relationships"]."',
	current_symptoms='".$_POST["current_symptoms"]."',
	personal_strengths='".$_POST["personal_strengths"]."',
	mental_status='".$_POST["mental_status"]."',
	spiritual='".$_POST["spiritual"]."',
	legal='".$_POST["legal"]."',
	summary_justification='".$_POST["summary_justification"]."',
	axis1='".$_POST["axis1"]."',
	axis2='".$_POST["axis2"]."',
	axis3='".$_POST["axis3"]."',
	allergies='".$_POST["allergies"]."',
	ax4_prob_support_group='".$_POST["ax4_prob_support_group"]."',
	ax4_prob_soc_env='".$_POST["ax4_prob_soc_env"]."',
	ax4_educational_prob='".$_POST["ax4_educational_prob"]."',
	ax4_occ_prob='".$_POST["ax4_occ_prob"]."',
	ax4_housing='".$_POST["ax4_housing"]."',
	ax4_economic='".$_POST["ax4_economic"]."',
	ax4_access_hc='".$_POST["ax4_access_hc"]."',
	ax4_legal='".$_POST["ax4_legal"]."',
	ax4_other_cb='".$_POST["ax4_other_cb"]."',
	ax4_other='".$_POST["ax4_other"]."',
	ax5_current='".$_POST["ax5_current"]."',
	ax5_past='".$_POST["ax5_past"]."',
	risk_suicide_na='".$_POST["risk_suicide_na"]."',
	risk_suicide_nk='".$_POST["risk_suicide_nk"]."',
	risk_suicide_io='".$_POST["risk_suicide_io"]."',
	risk_suicide_plan='".$_POST["risk_suicide_plan"]."',
	risk_suicide_iwom='".$_POST["risk_suicide_iwom"]."',
	risk_suicide_iwm='".$_POST["risk_suicide_iwm"]."',
	
	risk_suicide_none='".$_POST["risk_suicide_none"]."',
	
	risk_homocide_na='".$_POST["risk_homocide_na"]."',
	risk_homocide_nk='".$_POST["risk_homocide_nk"]."',
	risk_homocide_io='".$_POST["risk_homocide_io"]."',
	risk_homocide_plan='".$_POST["risk_homocide_plan"]."',
	risk_homocide_iwom='".$_POST["risk_homocide_iwom"]."',
	risk_homocide_iwm='".$_POST["risk_homocide_iwm"]."',
	
	risk_homocide_none='".$_POST["risk_homocide_none"]."',
	
	risk_compliance_na='".$_POST["risk_compliance_na"]."',
	risk_compliance_fc='".$_POST["risk_compliance_fc"]."',
	risk_compliance_mc='".$_POST["risk_compliance_mc"]."',
	risk_compliance_moc='".$_POST["risk_compliance_moc"]."',
	risk_compliance_var='".$_POST["risk_compliance_var"]."',
	risk_compliance_no='".$_POST["risk_compliance_no"]."',
	risk_substance_na ='".$_POST["risk_substance_na"]."',
	risk_substance_none='".$_POST["risk_substance_none"]."',
	risk_normal_use='".$_POST["risk_normal_use"]."',
	risk_substance_ou='".$_POST["risk_substance_ou"]."',
	risk_substance_dp='".$_POST["risk_substance_dp"]."',
	risk_substance_ur='".$_POST["risk_substance_ur"]."',
	risk_substance_ab='".$_POST["risk_substance_ab"]."',
	risk_sexual_na='".$_POST["risk_sexual_na"]."',
	risk_sexual_y='".$_POST["risk_sexual_y"]."',
	risk_sexual_n='".$_POST["risk_sexual_n"]."',
	risk_sexual_ry='".$_POST["risk_sexual_ry"]."',
	risk_sexual_rn='".$_POST["risk_sexual_rn"]."',
	risk_sexual_cv='".$_POST["risk_sexual_cv"]."',
	risk_sexual_cp='".$_POST["risk_sexual_cp"]."',
	risk_sexual_b='".$_POST["risk_sexual_b"]."',
	risk_sexual_nf='".$_POST["risk_sexual_nf"]."',
	risk_neglect_na='".$_POST["risk_neglect_na"]."',
	risk_neglect_y='".$_POST["risk_neglect_y"]."',
	risk_neglect_n='".$_POST["risk_neglect_n"]."',
	risk_neglect_ry='".$_POST["risk_neglect_ry"]."',
	risk_neglect_rn='".$_POST["risk_neglect_rn"]."',
	risk_neglect_cv='".$_POST["risk_neglect_cv"]."',
	risk_neglect_cp='".$_POST["risk_neglect_cp"]."',
	risk_neglect_cb='".$_POST["risk_neglect_cb"]."',
	risk_neglect_cn='".$_POST["risk_neglect_cn"]."',
	risk_exists_c='".$_POST["risk_exists_c"]."',
	risk_exists_cn='".$_POST["risk_exists_cn"]."',
	risk_exists_s='".$_POST["risk_exists_s"]."',
	risk_exists_o='".$_POST["risk_exists_o"]."',
	risk_exists_b='".$_POST["risk_exists_b"]."',
	risk_community='".$_POST["risk_community"]."',
	
	desired_services='".$_POST["desired_services"]."',
	
	recommendations_psy_p='".$_POST["recommendations_psy_p"]."',
	recommendations_psy_i='".$_POST["recommendations_psy_i"]."',
	recommendations_psy_tboss='".$_POST["recommendations_psy_tboss"]."',
	recommendations_psy_d='".$_POST["recommendations_psy_d"]."',
	recommendations_psy_o='".$_POST["recommendations_psy_o"]."',
	recommendations_psy_notes='".$_POST["recommendations_psy_notes"]."',
	recommendations_psy_notes='".$_POST["recommendations_psy_med"]."',
	recommendations_psy_notes='".$_POST["recommendations_psy_medication"]."',
	recommendations_psy_notes='".$_POST["recommendations_psy_follow_up"]."',
	refer_date='".$_POST["refer_date"]."',
	parent ='".$_POST["parent"]."',
	referrals_pepm='".$_POST["referrals_pepm"]."',
	referrals_mc='".$_POST["referrals_mc"]."',
	referrals_vt='".$_POST["referrals_vt"]."',
	referrals_o='".$_POST["referrals_o"]."',
	referrals_cu='".$_POST["referrals_cu"]."',
	referrals_docs='".$_POST["referrals_docs"]."',
	referrals_or='".$_POST["referrals_or"]."',
	
	signature='".$_POST["signature"]."', 
	credentials='".$_POST["credentials"]."', 
	sig_date='".$_POST["sig_date"]."', 
	sup_signature='".$_POST["sup_signature"]."', 
	sup_credentials='".$_POST["sup_credentials"]."', 
	sup_sig_date='".$_POST["sup_sig_date"]."' 
	
	where id=$id");
	*/
}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");

if ($_GET["mode"] == ""){
	$address = "{$GLOBALS['rootdir']}/forms/treatment_plan/view.php?id=$newid";
	echo "\n<script language='Javascript'>top.restoreSession();window.location='$address';</script>\n";
}elseif ($_GET["mode"] == "update") {
	formJump();
}

formFooter();
?>

