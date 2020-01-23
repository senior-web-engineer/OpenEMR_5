

<?php

require_once("../verify_session.php");
require_once("../lib/consent_form.inc");
require_once("./../lib/appsql.class.php");

if($pid){
    $result = [];
    $consentForm = '';
    if($_GET['type'] == 'mental-health')
    {
        $result = insertMentalHealthDetail($pid, json_encode($_POST));
    } elseif($_GET['type'] == 'emotional-pain')
    {
        $result = insertEmotionalPainDetail($pid, json_encode($_POST));
    } elseif($_GET['type'] == 'drug-alcohol')
    {
        $result = insertDrugAlchoholDetail($pid, json_encode($_POST));
    } elseif($_GET['type'] == 'physical-health')
    {
        $result = insertPhysicalHealthDetail($pid, json_encode($_POST));
    } elseif($_GET['type'] == 'risk-assessment')
    {
        $result = insertRiskAssessmentDetail($pid, json_encode($_POST));
        $consentForm = getPatientConsentForm($pid);
    }
    echo json_encode(['type'=>'success', 'result'=>$result, 'consentForm'=>$consentForm], 200);
    exit();
}


?>
