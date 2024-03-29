<?php
/** @package    Patient Portal::Controller */

/**
 *
 * Copyright (C) 2016-2017 Jerry Padgett <sjpadgett@gmail.com>
 *
 * LICENSE: This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEMR
 * @author Jerry Padgett <sjpadgett@gmail.com>
 * @link http://www.open-emr.org
 */

/**
 * import supporting libraries
 */
require_once("AppBaseController.php");
require_once("Model/Patient.php");

/**
 * PatientController is the controller class for the Patient object.
 * The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package Patient Portal::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class PatientController extends AppBaseController
{

    /**
     * Override here for any controller-specific functionality
     *
     * @inheritdocs
     */
    protected function Init()
    {
        parent::Init();
        // require_once ( '../lib/appsql.class.php' );

        // $this->RequirePermission(SecureApp::$PERMISSION_USER,'SecureApp.LoginForm');
    }

    /**
     * Displays a list view of Patient objects
     */
    public function ListView()
    {

        $rid = $pid = $user = $encounter = $register = 0;

        if (isset($_GET['id'])) {
            $rid = ( int ) $_GET['id'];
        }

        if (isset($_GET['pid'])) {
            $pid = ( int ) $_GET['pid'];
        }

        if (isset($_GET['user'])) {
            $user = $_GET['user'];
        }

        if (isset($_GET['enc'])) {
            $encounter = $_GET['enc'];
        }

        if (isset($_GET['register'])) {
            $register = $_GET['register'];
        }

        if (isset($_GET['typeId'])) {
            $typeId = $_GET['typeId'];
        }

        $this->Assign('recid', $rid);
        $this->Assign('cpid', $pid);
        $this->Assign('cuser', $user);
        $this->Assign('encounter', $encounter);
        $this->Assign('register', $register);
        $this->Assign('typeId', $register);
        $trow = array();
        $ptdata = $this->startupQuery($pid);
        foreach ($ptdata[0] as $key => $v) {
            $trow[lcfirst($key)] = $v;
        }

        $this->Assign('trow', $trow);
        $this->Render();
    }
    /**
     * API Method queries for startup Patient records and return as php
     */
    public function startupQuery($pid)
    {
        try {
            $criteria = new PatientCriteria();
            $recnum = ( int ) $pid;
            $criteria->Pid_Equals = $recnum;

            $output = new stdClass();
            // return row
            $patientdata = $this->Phreezer->Query('PatientReporter', $criteria);
            $output->rows = $patientdata->ToObjectArray(false, $this->SimpleObjectParams());
            $output->totalResults = count($output->rows);
            return $output->rows;
        } catch (Exception $ex) {
            $this->RenderExceptionJSON($ex);
        }
    }
    /**
     * API Method queries for Patient records and render as JSON
     */
    public function Query()
    {
        try {
            $criteria = new PatientCriteria();
            $pid = RequestUtil::Get('patientId');
            $criteria->Pid_Equals = $pid;

            $output = new stdClass();

            // if a sort order was specified then specify in the criteria
            $output->orderBy = RequestUtil::Get('orderBy');
            $output->orderDesc = RequestUtil::Get('orderDesc') != '';
            if ($output->orderBy) {
                $criteria->SetOrder($output->orderBy, $output->orderDesc);
            }

            $page = RequestUtil::Get('page');

            // return all results
            $patientdata = $this->Phreezer->Query('Patient', $criteria);
            $output->rows = $patientdata->ToObjectArray(true, $this->SimpleObjectParams());
            $output->totalResults = count($output->rows);
            $output->totalPages = 1;
            $output->pageSize = $output->totalResults;
            $output->currentPage = 1;

            $this->RenderJSON($output, $this->JSONPCallback());
        } catch (Exception $ex) {
            $this->RenderExceptionJSON($ex);
        }
    }

    /**
     * API Method retrieves a single Patient record and render as JSON
     */
    public function Read()
    {
        try {
            $pk = $this->GetRouter()->GetUrlParam('id');
            $patient = $this->Phreezer->Get('Patient', $pk);
            $this->RenderJSON($patient, $this->JSONPCallback(), true, $this->SimpleObjectParams());
        } catch (Exception $ex) {
            $this->RenderExceptionJSON($ex);
        }
    }

    /**
     * API Method inserts a new Patient record and render response as JSON
     */
    public function Create()
    {
        try {
            $json = json_decode(RequestUtil::GetBody());

            if (! $json) {
                throw new Exception('The request body does not contain valid JSON');
            }

            $patient = new Patient($this->Phreezer);

            // this is an auto-increment. uncomment if updating is allowed
            // $patient->Id = $this->SafeGetVal($json, 'id');

            $patient->Title = $this->SafeGetVal($json, 'title', $patient->Title);
            $patient->Language = $this->SafeGetVal($json, 'language', $patient->Language);
            $patient->Financial = $this->SafeGetVal($json, 'financial', $patient->Financial);
            $patient->Fname = $this->SafeGetVal($json, 'fname', $patient->Fname);
            $patient->Lname = $this->SafeGetVal($json, 'lname', $patient->Lname);
            $patient->Mname = $this->SafeGetVal($json, 'mname', $patient->Mname);
            $patient->Dob = date('Y-m-d', strtotime($this->SafeGetVal($json, 'dob', $patient->Dob)));
            $patient->Street = $this->SafeGetVal($json, 'street', $patient->Street);
            $patient->PostalCode = $this->SafeGetVal($json, 'postalCode', $patient->PostalCode);
            $patient->City = $this->SafeGetVal($json, 'city', $patient->City);
            $patient->State = $this->SafeGetVal($json, 'state', $patient->State);
            $patient->CountryCode = $this->SafeGetVal($json, 'countryCode', $patient->CountryCode);
            $patient->DriversLicense = $this->SafeGetVal($json, 'driversLicense', $patient->DriversLicense);
            $patient->Ss = $this->SafeGetVal($json, 'ss', $patient->Ss);
            $patient->Occupation = $this->SafeGetVal($json, 'occupation', $patient->Occupation);
            $patient->PhoneHome = $this->SafeGetVal($json, 'phoneHome', $patient->PhoneHome);
            $patient->PhoneBiz = $this->SafeGetVal($json, 'phoneBiz', $patient->PhoneBiz);
            $patient->PhoneContact = $this->SafeGetVal($json, 'phoneContact', $patient->PhoneContact);
            $patient->PhoneCell = $this->SafeGetVal($json, 'phoneCell', $patient->PhoneCell);
            $patient->PharmacyId = $this->SafeGetVal($json, 'pharmacyId', $patient->PharmacyId);
            $patient->Status = $this->SafeGetVal($json, 'status', $patient->Status);
            $patient->ContactRelationship = $this->SafeGetVal($json, 'contactRelationship', $patient->ContactRelationship);
            $patient->EmergencyContact = $this->SafeGetVal($json, 'emergencyContact', $patient->EmergencyContact);
            $patient->ScheduleDate = date('Y-m-d H:i:s', strtotime($this->SafeGetVal($json, 'scheduleDate', $patient->ScheduleDate)));
            $patient->Sex = $this->SafeGetVal($json, 'sex', $patient->Sex);
            $patient->Referrer = $this->SafeGetVal($json, 'referrer', $patient->Referrer);
            $patient->Referrerid = $this->SafeGetVal($json, 'referrerid', $patient->Referrerid);
            $patient->Providerid = $this->SafeGetVal($json, 'providerid', 0);
            $patient->RefProviderid = $this->SafeGetVal($json, 'refProviderid', $patient->RefProviderid);
            $patient->Email = $this->SafeGetVal($json, 'email', $patient->Email);
            $patient->EmailDirect = $this->SafeGetVal($json, 'emailDirect', $patient->EmailDirect);
            $patient->Ethnoracial = $this->SafeGetVal($json, 'ethnoracial', $patient->Ethnoracial);
            $patient->Race = $this->SafeGetVal($json, 'race', $patient->Race);
            $patient->Ethnicity = $this->SafeGetVal($json, 'ethnicity', $patient->Ethnicity);
            $patient->Religion = $this->SafeGetVal($json, 'religion', $patient->Religion);
            $patient->Interpretter = $this->SafeGetVal($json, 'interpretter', $patient->Interpretter);
            $patient->Migrantseasonal = $this->SafeGetVal($json, 'migrantseasonal', $patient->Migrantseasonal);
            $patient->FamilySize = $this->SafeGetVal($json, 'familySize', $patient->FamilySize);
            $patient->MonthlyIncome = $this->SafeGetVal($json, 'monthlyIncome', $patient->MonthlyIncome);
            $patient->BillingNote = $this->SafeGetVal($json, 'billingNote', $patient->BillingNote);
            $patient->Homeless = $this->SafeGetVal($json, 'homeless', $patient->Homeless);
            $patient->FinancialReview = date('Y-m-d H:i:s', strtotime($this->SafeGetVal($json, 'financialReview', $patient->FinancialReview)));
            $patient->Pubpid = $this->SafeGetVal($json, 'pubpid', $patient->Pubpid);
            $patient->Pid = $this->SafeGetVal($json, 'pid', $patient->Pid);
            $patient->Genericname1 = $this->SafeGetVal($json, 'genericname1', $patient->Genericname1);
            $patient->Genericval1 = $this->SafeGetVal($json, 'genericval1', $patient->Genericval1);
            $patient->Genericname2 = $this->SafeGetVal($json, 'genericname2', $patient->Genericname2);
            $patient->Genericval2 = $this->SafeGetVal($json, 'genericval2', $patient->Genericval2);
            $patient->HipaaMail = $this->SafeGetVal($json, 'hipaaMail', $patient->HipaaMail);
            $patient->HipaaVoice = $this->SafeGetVal($json, 'hipaaVoice', $patient->HipaaVoice);
            $patient->HipaaNotice = $this->SafeGetVal($json, 'hipaaNotice', $patient->HipaaNotice);
            $patient->HipaaMessage = $this->SafeGetVal($json, 'hipaaMessage', $patient->HipaaMessage);
            $patient->HipaaAllowsms = $this->SafeGetVal($json, 'hipaaAllowsms', $patient->HipaaAllowsms);
            $patient->HipaaAllowemail = $this->SafeGetVal($json, 'hipaaAllowemail', $patient->HipaaAllowemail);
            $patient->Squad = $this->SafeGetVal($json, 'squad', $patient->Squad);
            $patient->Fitness = $this->SafeGetVal($json, 'fitness', $patient->Fitness);
            $patient->ReferralSource = $this->SafeGetVal($json, 'referralSource', $patient->ReferralSource);
            $patient->Pricelevel = $this->SafeGetVal($json, 'pricelevel', $patient->Pricelevel);
            $patient->Regdate = date('Y-m-d', strtotime($this->SafeGetVal($json, 'regdate', $patient->Regdate)));
            $patient->Contrastart = date('Y-m-d', strtotime($this->SafeGetVal($json, 'contrastart', $patient->Contrastart)));
            $patient->CompletedAd = $this->SafeGetVal($json, 'completedAd', $patient->CompletedAd);
            $patient->AdReviewed = date('Y-m-d', strtotime($this->SafeGetVal($json, 'adReviewed', $patient->AdReviewed)));
            $patient->Vfc = $this->SafeGetVal($json, 'vfc', $patient->Vfc);
            $patient->Mothersname = $this->SafeGetVal($json, 'mothersname', $patient->Mothersname);
            $patient->Guardiansname = $this->SafeGetVal($json, 'guardiansname', $patient->Guardiansname);
            $patient->AllowImmRegUse = $this->SafeGetVal($json, 'allowImmRegUse', $patient->AllowImmRegUse);
            $patient->AllowImmInfoShare = $this->SafeGetVal($json, 'allowImmInfoShare', $patient->AllowImmInfoShare);
            $patient->AllowHealthInfoEx = $this->SafeGetVal($json, 'allowHealthInfoEx', $patient->AllowHealthInfoEx);
            $patient->AllowPatientPortal = $this->SafeGetVal($json, 'allowPatientPortal', $patient->AllowPatientPortal);
            $patient->DeceasedDate = date('Y-m-d H:i:s', strtotime($this->SafeGetVal($json, 'deceasedDate', $patient->DeceasedDate)));
            $patient->DeceasedReason = $this->SafeGetVal($json, 'deceasedReason', $patient->DeceasedReason);
            $patient->SoapImportStatus = $this->SafeGetVal($json, 'soapImportStatus', $patient->SoapImportStatus);
            $patient->CmsportalLogin = $this->SafeGetVal($json, 'cmsportalLogin', $patient->CmsportalLogin);
            $patient->CareTeam = $this->SafeGetVal($json, 'careTeam', $patient->CareTeam);
            $patient->County = $this->SafeGetVal($json, 'county', $patient->County);
            $patient->Industry = $this->SafeGetVal($json, 'industry', $patient->Industry);
            $patient->ChildName = $this->SafeGetVal($json, 'childName', $patient->ChildName);
            $patient->ChildAge = $this->SafeGetVal($json, 'childAge', $patient->ChildAge);
            $patient->PresentingProblem = $this->SafeGetVal($json, 'presentingProblem', $patient->PresentingProblem);
            $patient->HowCanWeHelpYou = $this->SafeGetVal($json, 'howCanWeHelpYou', $patient->HowCanWeHelpYou);
            $patient->AgreeTermsOfUse = 1;

            $patient->Validate();
            $errors = $patient->GetValidationErrors();

            if (count($errors) > 0) {
                $this->RenderErrorJSON('Please check the form for errors' . $errors, $errors);
            } else {
                $patient->Save();
                $this->RenderJSON($patient, $this->JSONPCallback(), true, $this->SimpleObjectParams());
            }
        } catch (Exception $ex) {
            $this->RenderExceptionJSON($ex);
        }
    }

    /**
     * API Method updates an existing Patient record and render response as JSON
     */
    public function Update()
    {
        try {
            $json = json_decode(RequestUtil::GetBody());

            if (! $json) {
                throw new Exception('The request body does not contain valid JSON');
            }

            $pk = $this->GetRouter()->GetUrlParam('id');
            $patient = $this->Phreezer->Get('Patient', $pk);
            // this is a primary key. uncomment if updating is allowed
            // $patient->Id = $this->SafeGetVal($json, 'id', $patient->Id);
            $patient->Title = $this->SafeGetVal($json, 'title', $patient->Title);
            $patient->Language = $this->SafeGetVal($json, 'language', $patient->Language);
            $patient->Financial = $this->SafeGetVal($json, 'financial', $patient->Financial);
            $patient->Fname = $this->SafeGetVal($json, 'fname', $patient->Fname);
            $patient->Lname = $this->SafeGetVal($json, 'lname', $patient->Lname);
            $patient->Mname = $this->SafeGetVal($json, 'mname', $patient->Mname);
            $patient->Dob = date('Y-m-d', strtotime($this->SafeGetVal($json, 'dob', $patient->Dob)));
            $patient->Street = $this->SafeGetVal($json, 'street', $patient->Street);
            $patient->PostalCode = $this->SafeGetVal($json, 'postalCode', $patient->PostalCode);
            $patient->City = $this->SafeGetVal($json, 'city', $patient->City);
            $patient->State = $this->SafeGetVal($json, 'state', $patient->State);
            $patient->CountryCode = $this->SafeGetVal($json, 'countryCode', $patient->CountryCode);
            $patient->DriversLicense = $this->SafeGetVal($json, 'driversLicense', $patient->DriversLicense);
            $patient->Ss = $this->SafeGetVal($json, 'ss', $patient->Ss);
            $patient->Occupation = $this->SafeGetVal($json, 'occupation', $patient->Occupation);
            $patient->PhoneHome = $this->SafeGetVal($json, 'phoneHome', $patient->PhoneHome);
            $patient->PhoneBiz = $this->SafeGetVal($json, 'phoneBiz', $patient->PhoneBiz);
            $patient->PhoneContact = $this->SafeGetVal($json, 'phoneContact', $patient->PhoneContact);
            $patient->PhoneCell = $this->SafeGetVal($json, 'phoneCell', $patient->PhoneCell);
            $patient->PharmacyId = $this->SafeGetVal($json, 'pharmacyId', $patient->PharmacyId);
            $patient->Status = $this->SafeGetVal($json, 'status', $patient->Status);
            $patient->ContactRelationship = $this->SafeGetVal($json, 'contactRelationship', $patient->ContactRelationship);
            $patient->EmergencyContact = $this->SafeGetVal($json, 'emergencyContact', $patient->EmergencyContact);
            $patient->ScheduleDate = date('Y-m-d H:i:s', strtotime($this->SafeGetVal($json, 'scheduleDate', $patient->ScheduleDate)));
            $patient->Sex = $this->SafeGetVal($json, 'sex', $patient->Sex);
            $patient->Referrer = $this->SafeGetVal($json, 'referrer', $patient->Referrer);
            $patient->Referrerid = $this->SafeGetVal($json, 'referrerid', $patient->Referrerid);
            $patient->Providerid = $this->SafeGetVal($json, 'providerid', $patient->Providerid);
            $patient->RefProviderid = $this->SafeGetVal($json, 'refProviderid', $patient->RefProviderid);
            $patient->Email = $this->SafeGetVal($json, 'email', $patient->Email);
            $patient->EmailDirect = $this->SafeGetVal($json, 'emailDirect', $patient->EmailDirect);
            $patient->Ethnoracial = $this->SafeGetVal($json, 'ethnoracial', $patient->Ethnoracial);
            $patient->Race = $this->SafeGetVal($json, 'race', $patient->Race);
            $patient->Ethnicity = $this->SafeGetVal($json, 'ethnicity', $patient->Ethnicity);
            $patient->Religion = $this->SafeGetVal($json, 'religion', $patient->Religion);
            $patient->Interpretter = $this->SafeGetVal($json, 'interpretter', $patient->Interpretter);
            $patient->Migrantseasonal = $this->SafeGetVal($json, 'migrantseasonal', $patient->Migrantseasonal);
            $patient->FamilySize = $this->SafeGetVal($json, 'familySize', $patient->FamilySize);
            $patient->MonthlyIncome = $this->SafeGetVal($json, 'monthlyIncome', $patient->MonthlyIncome);
            $patient->BillingNote = $this->SafeGetVal($json, 'billingNote', $patient->BillingNote);
            $patient->Homeless = $this->SafeGetVal($json, 'homeless', $patient->Homeless);
            $patient->FinancialReview = date('Y-m-d H:i:s', strtotime($this->SafeGetVal($json, 'financialReview', $patient->FinancialReview)));
            $patient->Pubpid = $this->SafeGetVal($json, 'pubpid', $patient->Pubpid);
            $patient->Pid = $this->SafeGetVal($json, 'pid', $patient->Pid);
            $patient->HipaaMail = $this->SafeGetVal($json, 'hipaaMail', $patient->HipaaMail);
            $patient->HipaaVoice = $this->SafeGetVal($json, 'hipaaVoice', $patient->HipaaVoice);
            $patient->HipaaNotice = $this->SafeGetVal($json, 'hipaaNotice', $patient->HipaaNotice);
            $patient->HipaaMessage = $this->SafeGetVal($json, 'hipaaMessage', $patient->HipaaMessage);
            $patient->HipaaAllowsms = $this->SafeGetVal($json, 'hipaaAllowsms', $patient->HipaaAllowsms);
            $patient->HipaaAllowemail = $this->SafeGetVal($json, 'hipaaAllowemail', $patient->HipaaAllowemail);
            $patient->ReferralSource = $this->SafeGetVal($json, 'referralSource', $patient->ReferralSource);
            $patient->Pricelevel = $this->SafeGetVal($json, 'pricelevel', $patient->Pricelevel);
            $patient->Regdate = date('Y-m-d', strtotime($this->SafeGetVal($json, 'regdate', $patient->Regdate)));
            $patient->Contrastart = date('Y-m-d', strtotime($this->SafeGetVal($json, 'contrastart', $patient->Contrastart)));
            $patient->CompletedAd = $this->SafeGetVal($json, 'completedAd', $patient->CompletedAd);
            $patient->AdReviewed = date('Y-m-d', strtotime($this->SafeGetVal($json, 'adReviewed', $patient->AdReviewed)));
            $patient->Vfc = $this->SafeGetVal($json, 'vfc', $patient->Vfc);
            $patient->Mothersname = $this->SafeGetVal($json, 'mothersname', $patient->Mothersname);
            $patient->Guardiansname = $this->SafeGetVal($json, 'guardiansname', $patient->Guardiansname);
            $patient->AllowImmRegUse = $this->SafeGetVal($json, 'allowImmRegUse', $patient->AllowImmRegUse);
            $patient->AllowImmInfoShare = $this->SafeGetVal($json, 'allowImmInfoShare', $patient->AllowImmInfoShare);
            $patient->AllowHealthInfoEx = $this->SafeGetVal($json, 'allowHealthInfoEx', $patient->AllowHealthInfoEx);
            $patient->AllowPatientPortal = $this->SafeGetVal($json, 'allowPatientPortal', $patient->AllowPatientPortal);
            $patient->CareTeam = $this->SafeGetVal($json, 'careTeam', $patient->CareTeam);
            $patient->County = $this->SafeGetVal($json, 'county', $patient->County);
            $patient->Industry = $this->SafeGetVal($json, 'industry', $patient->Industry);
            $patient->ChildName = $this->SafeGetVal($json, 'childName', $patient->ChildName);
            $patient->ChildAge = $this->SafeGetVal($json, 'childAge', $patient->ChildAge);
            $patient->PresentingProblem = $this->SafeGetVal($json, 'presentingProblem', $patient->PresentingProblem);
            $patient->HowCanWeHelpYou = $this->SafeGetVal($json, 'howCanWeHelpYou', $patient->HowCanWeHelpYou);

            $patient->Validate();
            $errors = $patient->GetValidationErrors();

            if (count($errors) > 0) {
                $this->RenderErrorJSON('Please check the form for errors', $errors);
            } else {
                $patient->Save();
                self::CloseAudit($patient);
                $this->RenderJSON($patient, $this->JSONPCallback(), true, $this->SimpleObjectParams());
            }
        } catch (Exception $ex) {
            $this->RenderExceptionJSON($ex);
        }
    }
    public function CloseAudit($p)
    {
        $appsql = new ApplicationTable();
        $ja = $p->GetArray();
        try {
            $audit = array ();
            // date("Y-m-d H:i:s");
            $audit['patient_id'] = $ja['pid'];
            $audit['activity'] = "profile";
            $audit['require_audit'] = "1";
            $audit['pending_action'] = "completed";
            $audit['action_taken'] = "accept";
            $audit['status'] = "closed";
            $audit['narrative'] = "Changes reviewed and commited to demographics.";
            $audit['table_action'] = "update";
            $audit['table_args'] = $ja;
            $audit['action_user'] = isset($_SESSION['authUserID']) ? $_SESSION['authUserID'] : "0";
            $audit['action_taken_time'] = date("Y-m-d H:i:s");
            $audit['checksum'] = "0";

            $edata = $appsql->getPortalAudit($ja['pid'], 'review');
            $audit['date'] = $edata['date'];
            if ($edata['id'] > 0) {
                $appsql->portalAudit('update', $edata['id'], $audit);
            }
        } catch (Exception $ex) {
            $this->RenderExceptionJSON($ex);
        }
    }
    /**
     * API Method deletes an existing Patient record and render response as JSON
     */
    public function Delete()
    {
        try {
            // TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

            $pk = $this->GetRouter()->GetUrlParam('id');
            $patient = $this->Phreezer->Get('Patient', $pk);

            $patient->Delete();

            $output = new stdClass();

            $this->RenderJSON($output, $this->JSONPCallback());
        } catch (Exception $ex) {
            $this->RenderExceptionJSON($ex);
        }
    }

    public function Avatar()
    {
        $pid = RequestUtil::Get('patientId');
        $appsql = new ApplicationTable();
        try {
            if(isset($_FILES['attachment'])){
                $errors= array();
                $fileName = $_FILES['attachment']['name'];
                $fileSize =$_FILES['attachment']['size'];
                $fileTmp =$_FILES['attachment']['tmp_name'];
                $fileType=$_FILES['attachment']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                $newFileName = str_random(4).time();
                $extensions= array("jpeg","jpg","png");

                if(in_array($fileExtension,$extensions)=== false){
                    $errors[]="extension not allowed, please choose a JPEG or PNG file.";
                }

                if($fileSize > 2097152){
                    $errors[]='File size must be less than or equal to 2 MB';
                }
                if(empty($errors)==true){
                    $storeFileName = 'attachments/'.$newFileName.'.'.$fileExtension;
                    $targetPath = "/var/www/html/openemr/portal/".$storeFileName;
                    move_uploaded_file($fileTmp, $targetPath);
                    chmod($targetPath, 0644);
                    $inputs = array ();
                    $inputs['pid'] = $pid;
                    $inputs['attachment'] = $storeFileName;
                    $appsql->portalNewAttachment($inputs);
                    echo json_encode([
                        'type'=>'success',
                        'message'=>'Document uploaded successfully.'
                    ]);
                }else{
                    echo json_encode([
                        'type'=>'error',
                        'message'=>$errors
                    ]);
                }
            }
        } catch (Exception $ex) {
            $this->RenderExceptionJSON($ex);
        }
    }
}
