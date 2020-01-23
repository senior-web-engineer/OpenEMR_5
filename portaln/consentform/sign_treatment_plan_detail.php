<?php

require_once("../verify_session.php");
require_once("../../library/forms.inc");
require_once("../../library/patient.inc");
require_once("../../library/user.inc");

function validEmail($email)
{
    if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $email)) {
        return true;
    }
    return false;
}

function sendEmailToProvider($treatmentPlan, $pid)
{
    $sent = false;
    $patient = getPatientData($pid);
    $form = sqlQuery("SELECT * FROM `forms` where form_id=".$treatmentPlan['id']." and formdir='treatment_plan' and deleted=0");
    $encounter = getFormEncounterByEncounter($form['encounter']);
    $provider = getUserIDInfo($encounter['provider_id']);
    if ($provider) {
        if (validEmail($provider['email'])) {

            $message = htmlspecialchars(xl("Following patient/client have signed your treatment plan."), ENT_NOQUOTES) . ":<br>";
            $message .= "<br>";
            $message .= htmlspecialchars(xl("Patient/Client Name"), ENT_NOQUOTES) . ": " . htmlspecialchars($patient['fname'] . ' ' . $patient['mname'] . ' ' . $patient['lname'], ENT_NOQUOTES) .
                "<br><br>" . htmlspecialchars(xl("Email Address"), ENT_NOQUOTES) . ": " . htmlspecialchars($patient['email'], ENT_NOQUOTES) .
                "<br><br>" . htmlspecialchars(xl("Encounter"), ENT_NOQUOTES) . ": " . htmlspecialchars($encounter['encounter'], ENT_NOQUOTES) . "<br><br>";

            $mail = new MyMailer();
            $providerName = $provider['fname'] . ' ' . $provider['lname'];
            $providerEmail = $provider['email'];
            $email_subject = xl('Patient signed treatment plan.');
            $email_sender = $GLOBALS['patient_reminder_sender_email'];
//    $mail->AddReplyTo($email_sender, $email_sender);
            $mail->SMTPDebug = 0;
            $mail->SetFrom($email_sender, $email_sender);
            $mail->AddAddress($providerEmail, $providerName);
            $mail->Subject = $email_subject;
            $mail->MsgHTML("<html><body><div class='wrapper'>" . $message . "</div></body></html>");
            $mail->IsHTML(true);
            $mail->AltBody = $message;

            if ($mail->Send()) {
                $sent = true;
            } else {
                $email_status = $mail->ErrorInfo;
                error_log("EMAIL ERROR: " . $email_status, 0);
                $sent = false;
            }
        }
    }

    return $sent;
}


$id = $_POST["tpid"];
$treatmentPlan = getTreatmentPlanById($id);
$patientSignature = getPatientSignature($pid, 'patient-signature');
$errors = array();
if ($pid == $treatmentPlan['pid'] && $patientSignature) {
    $updates = array($patientSignature['attachment'], date('Y-m-d'));
    $updateQuery = "UPDATE form_treatment_plan set patient_signature='" . $patientSignature['signature'] . "', patient_signature_date='" . date('Y-m-d') . "' where id=" . $id;
    sqlInsertClean_audit($updateQuery, $updates);
    sendEmailToProvider($treatmentPlan, $pid);
} else {
    $errors[] = "Selected treatment plan can not be signed.";
}

if (empty($errors) == true) {
    echo json_encode([
        'type' => 'success',
        'message' => 'Treatment plan signed successfully.'
    ]);
} else {
    echo json_encode([
        'type' => 'error',
        'message' => $errors
    ]);
}
exit();

?>