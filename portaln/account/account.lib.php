<?php
/**
 * Ajax Library for Register
 *
 * @package OpenEMR
 * @link    http://www.open-emr.org
 * @author  Jerry Padgett <sjpadgett@gmail.com>
 * @copyright Copyright (c) 2017 Jerry Padgett <sjpadgett@gmail.com>
 * @license https://www.gnu.org/licenses/agpl-3.0.en.html GNU Affero General Public License 3
 */
/* Library functions for register*/

function notifyAdmin($pid, $providerId)
{
    return sendEmailToAdminEmailList($pid);
    $note = xl("New patient registration received from patient portal. Reminder to check for possible new appointment");
    $title = xl("New Patient");
    $provider = sqlQueryNoLog("SELECT users.username FROM users WHERE authorized = 1 And id = ?", array($providerId));

    $rtn = addPnote($pid, $note, 1, 1, $title, $provider['username'], '', 'New');
    return notifyProvider($pid, $providerId);
//    return $rtn;
}

function isNew($dob = '', $lname = '', $fname = '', $email = '')
{
    $last = '%' . trim($lname) . '%';
    $first = '%' . trim($fname) . '%';
    $dob = '%' . trim($dob) . '%';
    $semail = '%' . trim($email) . '%';
    $sql = "select pid from patient_data Where patient_data.lname LIKE ? And patient_data.fname LIKE ? And patient_data.DOB LIKE ? order by date limit 0,1";
    $data = array(
        $last,
        $first,
        $dob
    );
    if ($email) {
        $sql = "select pid from patient_data Where patient_data.lname LIKE ? And patient_data.fname LIKE ? And patient_data.DOB LIKE ? And patient_data.email LIKE ? order by date limit 0,1";
        $data = array(
            $last,
            $first,
            $dob,
            $semail
        );
    }
    $row = sqlQuery($sql, $data);

    return $row['pid'] ? $row['pid'] : 0;
}

function saveConsent($pid)
{
    return newConsentData($pid, $_REQUEST);
}

function saveClientNotice($pid)
{
    return newClientNoticeData($pid, $_REQUEST);
}

function saveInsurance($pid)
{
    newInsuranceData(
        $pid = $pid,
        $type = "primary",
        $provider = "0",
        $policy_number = $_REQUEST['policy_number'],
        $group_number = $_REQUEST['group_number'],
        $plan_name = $_REQUEST['provider'] . ' ' . $_REQUEST['plan_name'],
        $subscriber_lname = "",
        $subscriber_mname = "",
        $subscriber_fname = "",
        $subscriber_relationship = "",
        $subscriber_ss = "",
        $subscriber_DOB = "",
        $subscriber_street = "",
        $subscriber_postal_code = "",
        $subscriber_city = "",
        $subscriber_state = "",
        $subscriber_country = "",
        $subscriber_phone = "",
        $subscriber_employer = "",
        $subscriber_employer_street = "",
        $subscriber_employer_city = "",
        $subscriber_employer_postal_code = "",
        $subscriber_employer_state = "",
        $subscriber_employer_country = "",
        $copay = $_REQUEST['copay'],
        $subscriber_sex = "",
        $effective_date = DateToYYYYMMDD($_REQUEST['date']),
        $accept_assignment = "TRUE",
        $policy_type = ""
    );
    newInsuranceData($pid, "secondary");
    newInsuranceData($pid, "tertiary");
}

function getNewPid()
{
    $result = sqlQuery("select max(pid)+1 as pid from patient_data");
    $newpid = 1;
    if ($result['pid'] > 1) {
        $newpid = $result['pid'];
    }
    if ($newpid == null) {
        $newpid = 0;
    }
    return $newpid;
}

function generatePassword($length = 8, $strength = 1)
{
    $consonants = 'bdghjmnpqrstvzacefiklowxy';
    $numbers = '0234561789';
    $specials = '@#$%';

    $password = '';
    $alt = time() % 2;
    for ($i = 0; $i < $length / 3; $i ++) {
        if ($alt == 1) {
            $password .= $consonants[(rand() % strlen($consonants))] . $numbers[(rand() % strlen($numbers))] . $specials[(rand() % strlen($specials))];
            $alt = 0;
        } else {
            $password .= $numbers[(rand() % strlen($numbers))] . $specials[(rand() % strlen($specials))] . $consonants[(rand() % strlen($consonants))];
            $alt = 1;
        }
    }

    return $password;
}

function validEmail($email)
{
    if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $email)) {
        return true;
    }

    return false;
}

function messageCreate($uname, $pass)
{
    $message = htmlspecialchars(xl("Patient Portal Web Address"), ENT_NOQUOTES) . ":<br>";

    if ($GLOBALS['portal_onsite_enable']) {
        $message .= "<a href='" . htmlspecialchars($GLOBALS['portal_onsite_address'], ENT_QUOTES) . "'>" .
            htmlspecialchars($GLOBALS['portal_onsite_address'], ENT_NOQUOTES) . "</a><br>";
    }

    if ($GLOBALS['portal_onsite_two_enable']) {
        $message .= "<a href='" . htmlspecialchars($GLOBALS['portal_onsite_two_address'], ENT_QUOTES) . "'>" .
            htmlspecialchars($GLOBALS['portal_onsite_two_address'], ENT_NOQUOTES) . "</a><br>";
    }

    $message .= "<br>";

    $message .= htmlspecialchars(xl("User Name"), ENT_NOQUOTES) . ": " . htmlspecialchars($uname, ENT_NOQUOTES) .
    "<br><br>" . htmlspecialchars(xl("Password"), ENT_NOQUOTES) . ": " . htmlspecialchars($pass, ENT_NOQUOTES) . "<br><br>";

    return $message;
}

function doCredentials($pid)
{
    global $srcdir;
    require_once("$srcdir/authentication/common_operations.php");

    $newpd = sqlQuery("SELECT * FROM `patient_data` WHERE `pid`=?", array(
        $pid
    ));

    $clear_pass = generatePassword();

    $uname = $newpd['fname'] . $newpd['id'];

    $res = sqlStatement("SELECT * FROM patient_access_onsite WHERE pid=?", array(
        $pid
    ));
    $query_parameters = array(
        $uname
    );
    $salt_clause = "";
    // For onsite portal create a blowfish based hash and salt.
    $new_salt = oemr_password_salt();
    $salt_clause = ",portal_salt=? ";
    array_push($query_parameters, oemr_password_hash($clear_pass, $new_salt), $new_salt);
    array_push($query_parameters, $pid);
    if (sqlNumRows($res)) {
        sqlStatement("UPDATE patient_access_onsite SET portal_username=?,portal_pwd=?,portal_pwd_status=0 " . $salt_clause . " WHERE pid=?", $query_parameters);
    } else {
        sqlStatement("INSERT INTO patient_access_onsite SET portal_username=?,portal_pwd=?,portal_pwd_status=0" . $salt_clause . " ,pid=?", $query_parameters);
    }

    if (! (validEmail($newpd['email']))) {
        $sent = false;
    }

    $message = messageCreate($uname, $clear_pass);

    $mail = new MyMailer();
    $pt_name = $newpd['fname'] . ' ' . $newpd['lname'];
    $pt_email = $newpd['email'];
    $email_subject = xl('Access Your Patient Portal');
    $email_sender = $GLOBALS['patient_reminder_sender_email'];
    $mail->AddReplyTo($email_sender, $email_sender);
    $mail->SetFrom($email_sender, $email_sender);
    $mail->AddAddress($pt_email, $pt_name);
    $mail->Subject = $email_subject;
    $mail->MsgHTML("<html><body><div class='wrapper'>" . $message . "</div></body></html>");
    $mail->IsHTML(true);
    $mail->AltBody = $message;

    if ($mail->send()) {
        $sent = true;
    } else {
        $email_status = $mail->ErrorInfo;
        error_log("EMAIL ERROR: " . $email_status, 0);
        $sent = false;
    }
    return $sent;
}

function notifyProvider($pid, $providerId)
{
    global $srcdir;
    require_once("$srcdir/authentication/common_operations.php");

    $patient = sqlQuery("SELECT * FROM `patient_data` WHERE `pid`=?", array($pid));
    $provider = sqlQuery("SELECT * FROM users WHERE authorized = 1 And `id` = ?", array($providerId));
    $encounterType = $provider['ecounter_type_id'] == 2 ? 'parenting' : 'counseling';

    $query = "SELECT 
                    usr. id AS user_id,
                    garo.id AS aro_id,
                    garo.value AS username,
                    garo.name AS display_name,
                    gagp.id AS group_id,
                    gagp.name AS group_name,
                    gagp.value AS group_nick
                FROM
                    `gacl_aro` AS garo 
                        LEFT JOIN `gacl_groups_aro_map` AS gamp 
                            ON garo.id = gamp.aro_id 
                        LEFT JOIN `gacl_aro_groups` AS gagp
                            ON gagp.id = gamp.group_id
                        RIGHT JOIN `users_secure` usr 
                            ON usr. username =  garo.value
                            where group_id=11";

    $response = sqlStatement($query);
    while($row = sqlFetchArray($response)){
        $notifyAdmin = sqlQuery("SELECT * FROM users WHERE authorized = 1 And `id` = ?", array($row['user_id']));
        if($notifyAdmin){
            $query_parameters = array(
                $notifyAdmin['id'],
                $patient['id'],
                $provider ? $provider['id'] : 0,
                $patient['fname'] .' '. $patient['mname'] .' '.$patient['lname'],
                $provider ? $provider['fname'] .' '. $provider['mname'] .' '.$provider['lname'] : '',
                $patient['date'],
                0
            );

            sqlStatement("INSERT INTO portal_notifications SET notify_user_id=?,patient_id=?,provider_id=?,patient_name=?, provider_name=?,appointment_datetime=?,is_seen=?",
                $query_parameters);
            sendEmailToAdmin($notifyAdmin, $patient);
        }
    }

    $message = htmlspecialchars(xl("You have counseling request from this patient/client."), ENT_NOQUOTES) . ":<br>";
    $message .= "<br>";
    $message .= htmlspecialchars(xl("Patient/Client Name"), ENT_NOQUOTES) . ": " . htmlspecialchars($patient['fname'] . ' ' . $patient['lname'], ENT_NOQUOTES) .
        "<br><br>" . htmlspecialchars(xl("Email Address"), ENT_NOQUOTES) . ": " . htmlspecialchars($patient['email'], ENT_NOQUOTES) . "<br><br>";

    $sent = true;
    if($provider){
        $mail = new MyMailer();
        $providerName = $provider['fname'] . ' ' . $provider['mname'] . ' ' . $provider['lname'];
        $providerEmail = $provider['email'];
        $email_subject = xl('Access Your Patient Portal');
        $email_sender = $GLOBALS['patient_reminder_sender_email'];
        $mail->AddReplyTo($email_sender, $email_sender);
        $mail->SetFrom($email_sender, $email_sender);
        $mail->AddAddress($providerName, $providerEmail);
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

    return $sent;
}

function sendEmailToAdmin($adminUser, $patient)
{
    $message = htmlspecialchars(xl("You have new service request from this patient/client."), ENT_NOQUOTES) . ":<br>";
    $message .= "<br>";
    $message .= htmlspecialchars(xl("Patient/Client Name"), ENT_NOQUOTES) . ": " . htmlspecialchars($patient['fname'] . ' ' . $patient['lname'], ENT_NOQUOTES) .
        "<br><br>" . htmlspecialchars(xl("Email Address"), ENT_NOQUOTES) . ": " . htmlspecialchars($patient['email'], ENT_NOQUOTES) . "<br><br>";

    $mail = new MyMailer();
    $adminName = $adminUser['fname'] . ' ' . $adminUser['mname'] . ' ' . $adminUser['lname'];
    $adminEmail = $adminUser['email'];
    $email_subject = xl('New appointment requested.');
    $email_sender = $GLOBALS['patient_reminder_sender_email'];
    $mail->AddReplyTo($email_sender, $email_sender);
    $mail->SetFrom($email_sender, $email_sender);
    $mail->AddAddress($adminName, $adminEmail);
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
    return $sent;
}

function sendEmailToAdminEmailList($pid)
{
    $patient = sqlQuery("SELECT * FROM `patient_data` WHERE `pid`=?", array($pid));
    $message = htmlspecialchars(xl("You have new service request from this patient/client."), ENT_NOQUOTES) . ":<br>";
    $message .= "<br>";
    $message .= htmlspecialchars(xl("Patient/Client Name"), ENT_NOQUOTES) . ": " . htmlspecialchars($patient['fname'] . ' ' .$patient['mname'] . ' ' . $patient['lname'], ENT_NOQUOTES) .
        "<br><br>" . htmlspecialchars(xl("Email Address"), ENT_NOQUOTES) . ": " . htmlspecialchars($patient['email'], ENT_NOQUOTES) . "<br><br>";
    $email_subject = xl('New appointment requested.');
    $email_sender = $GLOBALS['patient_reminder_sender_email'];

    $response = sqlStatement("SELECT * FROM tbl_admin_emails WHERE active = 1");
    while($row = sqlFetchArray($response)){
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
