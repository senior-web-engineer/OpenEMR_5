<?php
/**
 * consent_form.inc includes functions for manipulating consent form information.
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @copyright Copyright (c) 2018 Brady Miller <brady.g.miller@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */


use OpenEMR\Common\Utils\QueryUtils;

function validEmail($email)
{
    if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $email)) {
        return true;
    }
    return false;
}

function getConsentForms($groupId = null)
{
    $sql = "select * from `consent_forms`";
    if ($groupId) {
        $sql .= " where `consent_group_id`=" . $groupId;
    }
    $sql .= " order by order_position asc";
    return sqlStatement($sql);
}

function getPatientConsentForm($pid)
{
    return sqlQuery("SELECT * FROM `patient_consent_forms` WHERE `pid`=?", array($pid));
}

function insertMentalHealthDetail($pid, $inputs)
{
    $patientConsentForm = sqlQuery("SELECT * FROM `patient_consent_forms` WHERE `pid`=?", array($pid));
    if ($patientConsentForm) {
        $updates = array($inputs);
        $updateQuery = "UPDATE patient_consent_forms set mental_health_form='" . $inputs . "' where id=" . $patientConsentForm['id'];
        $returnValue = sqlInsertClean_audit($updateQuery, $updates);
    } else {
        $insertQuery = "INSERT INTO patient_consent_forms (`pid`,`mental_health_form`)" .
            " VALUES ('" . $pid . "','" . $inputs . "')";
        $returnValue = sqlInsert($insertQuery);
    }
    return $returnValue;
}

function insertEmotionalPainDetail($pid, $inputs)
{
    $patientConsentForm = sqlQuery("SELECT * FROM `patient_consent_forms` WHERE `pid`=?", array($pid));
    if ($patientConsentForm) {
        $updates = array($inputs);
        $updateQuery = "UPDATE patient_consent_forms set emotional_pain_form='" . $inputs . "' where id=" . $patientConsentForm['id'];
        $returnValue = sqlInsertClean_audit($updateQuery, $updates);
    } else {
        $insertQuery = "INSERT INTO patient_consent_forms (`pid`,`emotional_pain_form`)" .
            " VALUES ('" . $pid . "','" . $inputs . "')";
        $returnValue = sqlInsert($insertQuery);
    }
    return $returnValue;
}

function insertDrugAlchoholDetail($pid, $inputs)
{
    $patientConsentForm = sqlQuery("SELECT * FROM `patient_consent_forms` WHERE `pid`=?", array($pid));
    if ($patientConsentForm) {
        $updates = array($inputs);
        $updateQuery = "UPDATE patient_consent_forms set drugs_form='" . $inputs . "' where id=" . $patientConsentForm['id'];
        $returnValue = sqlInsertClean_audit($updateQuery, $updates);
    } else {
        $insertQuery = "INSERT INTO patient_consent_forms (`pid`,`drugs_form`)" .
            " VALUES ('" . $pid . "','" . $inputs . "')";
        $returnValue = sqlInsert($insertQuery);
    }
    return $returnValue;
}

function insertPhysicalHealthDetail($pid, $inputs)
{
    $patientConsentForm = sqlQuery("SELECT * FROM `patient_consent_forms` WHERE `pid`=?", array($pid));
    if ($patientConsentForm) {
        $updates = array($inputs);
        $updateQuery = "UPDATE patient_consent_forms set physical_health_form='" . $inputs . "' where id=" . $patientConsentForm['id'];
        $returnValue = sqlInsertClean_audit($updateQuery, $updates);
    } else {
        $insertQuery = "INSERT INTO patient_consent_forms (`pid`,`physical_health_form`)" .
            " VALUES ('" . $pid . "','" . $inputs . "')";
        $returnValue = sqlInsert($insertQuery);
    }
    return $returnValue;
}

function insertRiskAssessmentDetail($pid, $inputs)
{
    $patientConsentForm = sqlQuery("SELECT * FROM `patient_consent_forms` WHERE `pid`=?", array($pid));
    if ($patientConsentForm) {
        $updates = array($inputs);
        $updateQuery = "UPDATE patient_consent_forms set risk_assessment_form='" . $inputs . "', completed=1 where id=" . $patientConsentForm['id'];
        $returnValue = sqlInsertClean_audit($updateQuery, $updates);
    } else {
        $insertQuery = "INSERT INTO patient_consent_forms (`pid`,`risk_assessment_form`,`completed`)" .
            " VALUES ('" . $pid . "','" . $inputs . "', 1)";
        $returnValue = sqlInsert($insertQuery);
    }
    return $returnValue;
}

function checkKeyValueIfExists($key, $json)
{
    $array = json_decode($json);
    return array_key_exists($key, $array) ? $array->$key : "";
}

function get_value($data, $key, $default = null)
{
    $value = $default;
    if (is_array($data) && array_key_exists($key, $data)) {
        $value = $data[$key];
    } else if (is_object($data) && property_exists($data, $key)) {
        $value = $data->$key;
    } else {
        $segments = explode('.', $key);
        foreach ($segments as $segment) {
            if (is_array($data) && array_key_exists($segment, $data)) {
                $value = $data = $data[$segment];
            } else if (is_object($data) && property_exists($data, $segment)) {
                $value = $data = $data->$segment;
            } else {
                $value = $default;
                break;
            }
        }
    }
    return $value;
}


function insertReferralData($inputs)
{
    try {
        $insertQuery = "INSERT INTO `referral` (" .
            "`patient_name`," .
            "`age`," .
            "`dob`," .
            "`gender`," .
            "`insurance_provider`," .
            "`policy_number`," .
            "`medicaid`," .
            "`medicare_number`," .
            "`street`," .
            "`city`," .
            "`state`," .
            "`zip_code`," .
            "`telephone_type`," .
            "`telephone_number`," .
            "`email_address`," .
            "`referring_agency`," .
            "`referring_email`," .
            "`referring_source`," .
            "`referring_title`," .
            "`referring_phone`," .
            "`referring_fax`," .
            "`reason`," .
            "`comments`) VALUES ('" .
            $inputs['patient_name'] . "','" .
            $inputs['age'] . "','" .
            $inputs['dob'] . "','" .
            $inputs['gender'] . "','" .
            $inputs['insurance_provider'] . "','" .
            $inputs['policy_number'] . "','" .
            $inputs['medicaid'] . "','" .
            $inputs['medicare_number'] . "','" .
            $inputs['street'] . "','" .
            $inputs['city'] . "','" .
            $inputs['state'] . "','" .
            $inputs['zip_code'] . "','" .
            $inputs['telephone_type'] . "','" .
            $inputs['telephone_number'] . "','" .
            $inputs['email_address'] . "','" .
            $inputs['referring_agency'] . "','" .
            $inputs['referring_email'] . "','" .
            $inputs['referring_source'] . "','" .
            $inputs['referring_title'] . "','" .
            $inputs['referring_phone'] . "','" .
            $inputs['referring_fax'] . "','" .
            json_encode($inputs['reason']) . "','" .
            $inputs['comments'] . "'" .
            ")";
        $referralId = sqlInsert($insertQuery);
        sendEmailToAdmin($referralId);
        sendEmailToReferrer($referralId);
        return json_encode(['type' => 'success', 'referralId' => $referralId]);
    } catch (Exception $e) {
        return json_encode(['type' => 'error', 'message' => $e->getMessage()]);
    }
    exit();
}

function sendEmailToAdmin($referralId)
{
    $referralForm = sqlQuery("SELECT * FROM `referral` WHERE `id`=?", array($referralId));
    $email_subject = xl('New referral form submitted.');
    $email_sender = $GLOBALS['patient_reminder_sender_email'];
    $message = htmlspecialchars(xl("You have new referral request."), ENT_NOQUOTES) . ":<br><br>";

    $message .= '<table class="table"><tbody>';
    $message .= '<tr><td>Patient Name</td><td>' . htmlspecialchars($referralForm['patient_name'], ENT_NOQUOTES) . '</td><td>DOB</td><td>' . $referralForm['dob'] . '</td><td>Age</td><td>' . $referralForm['age'] . '</td></tr>';
    $message .= '<tr><td>Gender</td><td>' . $referralForm['gender'] . '</td><td>Insurance Provider</td><td>' . $referralForm['insurance_provider'] . '</td><td>Policy Number</td><td>' . $referralForm['policy_number'] . '</td></tr>';
    $message .= '<tr><td>Medicaid</td><td>' . $referralForm['medicaid'] . '</td><td>Medicare Number</td><td>' . $referralForm['medicare_number'] . '</td><td>Address</td><td>' . $referralForm['street'] . ' ' . $referralForm['city'] . ' ' . $referralForm['state'] . ',' . $referralForm['zip_code'] . '</td></tr>';
    $message .= '<tr><td>Telephone Number</td><td>' . '(' . $referralForm['telephone_type'] . ')' . $referralForm['telephone_number'] . '</td><td>Email Address</td><td>' . $referralForm['email_address'] . '</td><td></td><td></td></tr>';
    $message .= '<tr><td>Referring Agency</td><td>' . $referralForm['referring_agency'] . '</td><td>Referring Email</td><td>' . $referralForm['referring_email'] . '</td><td>Referring Source</td><td>' . $referralForm['age'] . '</td></tr>';
    $message .= '<tr><td>Referring Title</td><td>' . $referralForm['referring_title'] . '</td><td>Referring Phone</td><td>' . $referralForm['referring_phone'] . '</td><td>Referring Fax</td><td>' . $referralForm['referring_fax'] . '</td></tr>';
    $message .= '<tr><td>Reasons</td><td colspan="5">';
    $reasons = json_decode($referralForm['reason']);
    $reasonText = '';
    foreach ($reasons as $index => $reason) {
        $reasonText .= $reason;
        if ($index !== count($reasons) - 1) $reasonText .= ', ';
    }
    $message .= $reasonText . '</td></tr>';
    $message .= '<tr><td>Comments</td><td colspan="5">' . $referralForm['comments'] . '</td></tr>';
    $message .= '</tbody></table>';

    $response = sqlStatement("SELECT * FROM tbl_admin_emails WHERE active = 1");
    while ($row = sqlFetchArray($response)) {
        $adminEmail = $row['email_address'];
        if (validEmail($adminEmail)) {
            $mail = new MyMailer();
            $adminName = $row['name'];
            $mail->addReplyTo($email_sender, $email_sender);
            $mail->setFrom($email_sender, $email_sender);
            $mail->addAddress($adminEmail, $adminName);
            $mail->Subject = $email_subject;
            $mail->msgHTML("<html><body><div class='wrapper'>" . $message . "</div></body></html>");
            $mail->isHTML(true);
            $mail->AltBody = $message;
            if ($mail->send()) {
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

function sendEmailToReferrer($referralId)
{
    $referralForm = sqlQuery("SELECT * FROM `referral` WHERE `id`=?", array($referralId));
    $email_subject = xl('Thank you for your referral!');
    $email_sender = $GLOBALS['patient_reminder_sender_email'];
    $message = htmlspecialchars(xl("Thanks for referring your client to the Parent's Information and esource Center (PIRC). 
    Review of all referrals usually takes 2-3 business days. If you have any questions you may contact Ms. Moreen Russel by 
    email at mrussell@pircinc.org, or call us at 954-785-8285 ext 1012. We are looking forward to being of service to you."), ENT_NOQUOTES) . ":<br><br>";


    $toEmail = $referralForm['referring_email'];
    if (validEmail($toEmail)) {
        $mail = new MyMailer();
        $toName = $referralForm['referring_agency'];
        $mail->addReplyTo($email_sender, $email_sender);
        $mail->setFrom($email_sender, $email_sender);
        $mail->addAddress($toEmail, $toName);
        $mail->Subject = $email_subject;
        $mail->msgHTML("<html><body><div class='wrapper'>" . $message . "</div></body></html>");
        $mail->isHTML(true);
        $mail->AltBody = $message;
        if ($mail->send()) {
            $sent = true;
        } else {
            $email_status = $mail->ErrorInfo;
            error_log("EMAIL ERROR: " . $email_status, 0);
            $sent = false;
        }
    }
    return $sent;
}
