<?php

require_once("../verify_session.php");
require_once("../lib/consent_form.inc");
require_once("./../lib/appsql.class.php");

$consentForms = getConsentForms(5);
$consentForms2 = getConsentForms(6);
$patientConsentForm = getPatientConsentForm($pid);
$riskAssessmentForm = $patientConsentForm ? $patientConsentForm['risk_assessment_form'] : [];
?>
<style>
    .display-block{
        display:block!important;
    }
    fieldset hr{ margin-top:12px; margin-bottom:12px; }
    .consent-inline p, .consent-inline form, .fee form, .fee form label{
        display:inline-block;
    }
    .consent-inline input, .fee input, .drug input{ border:none; border-bottom:1px solid #333; box-shadow:none; border-radius:0; margin-left:10px; }
    .consent-inline input:focus, .fee input:focus, .drug input:focus{
        outline:none;
        box-shadow:none;
    }
    .fee input{
        width:10%;
    }
    .fee input, .drug input{
        display:inline-block;
    }
    .table tr td select{
        webkit-appearance:menulist;
    }
    select::-ms-expand { display: block; }
</style>

<body class="skin-blue md-bg">
<div class="container">
    <!-- End Insurance. Next what we've been striving towards..the end-->
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <fieldset>
                <legend class="bg-success title-bg text-center">HIV/AIDS SCREENING / RISK ASSESSMENT</legend>
                <div class="well ml-bg register-success">
                    <form method="post" class="ctm-form" id="riskAssessmentForm" enctype="multipart/form-data" autocomplete="off">
                    <div class="">
                        <p>The questions below are designed to help you identify your risk for contracting the HIV/AIDS Virus.  If you answer yes to any of the questions below, it would be wise for you to schedule an HIV/AIDS test with your local health department or your primary care doctor.  HIV/AIDS testing are confidential and free of charge. </p>

                        <table class="table">
                            <tbody>
                            <?php
                            $count = 1;
                            $consentFormArray = $patientConsentForm ? checkKeyValueIfExists('consentForm', $riskAssessmentForm) : [];
                            foreach($consentForms as $consentForm){
                                $value = get_value($consentFormArray, $consentForm['id']);
                                $noValueFlag = !is_null($value) && $value == 0 ? 1 : 0;
                            ?>
                            <tr>
                                <td class="col-xs-10"><?php echo $consentForm['question'] ?></td>
                                <td class="col-xs-1">
                                    <label class="radiocontainer">Yes
                                        <input type="radio" name="consentForm[<?php echo $consentForm['id'] ?>]" value="1" checked="checked">
                                        <span class="rcheckmark"></span>
                                    </label>
                                </td>
                                <td class="col-xs-1">
                                    <label class="radiocontainer">No
                                        <input type="radio"  name="consentForm[<?php echo $consentForm['id'] ?>]" value="0"
                                            <?php echo $noValueFlag ? 'checked="checked"' : "" ?>>
                                        <span class="rcheckmark"></span>
                                    </label>
                                </td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                        <div class="">
                            <h4>In the past five years, have you had sex with any of the following: </h4>
                            <table class="table">
                                <tbody>
                                <?php
                                $count = 1;
                                foreach($consentForms2 as $consentForm){
                                    $value = get_value($consentFormArray, $consentForm['id']);
                                    $noValueFlag = !is_null($value) && $value == 0 ? 1 : 0;
                                ?>
                                <tr>
                                    <td class="col-xs-10"><?php echo $consentForm['question'] ?></td>
                                    <td class="col-xs-1">
                                        <label class="radiocontainer">Yes
                                            <input type="radio" name="consentForm[<?php echo $consentForm['id'] ?>]"
                                                   value="1" checked="checked">
                                            <span class="rcheckmark"></span>
                                        </label>
                                    </td>
                                    <td class="col-xs-1">
                                        <label class="radiocontainer">No
                                            <input type="radio" name="consentForm[<?php echo $consentForm['id'] ?>]" value="0"
                                                <?php echo $noValueFlag ? 'checked="checked"' : "" ?>>
                                            <span class="rcheckmark"></span>
                                        </label>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <div>
                            <p>My signature below means that I or my child have read and completed the above health screenings and understand that I or my child may need to follow-up with a primary care doctor or the local Health Department for any medical risk or problems.</p>
                            <p>I understand that I or my child may need to get a HIV/AIDS test if any of the HIV/AIDS risk behaviors applies. </p>
                        </div>
                        <div class="row consent-inline">
                            <div class="col-xs-6 col-md-5">
<!--                                <input type="text" class="form-control" name="patient_guardian_signature"-->
<!--                                       value="--><?php //echo $riskAssessmentForm ? checkKeyValueIfExists('patient_guardian_signature', $riskAssessmentForm) : "" ?><!--">-->
                                <a href="#guardianSignatureModal" data-toggle="modal" data-backdrop="true">
                                    <i class="fa fa-cog fa-fw pull-right"></i><?php echo xlt('PATIENT or GUARDIAN SIGNATURE'); ?>
                                </a>
                                <label>PATIENT or GUARDIAN SIGNATURE </label>
                            </div>
                            <div class="col-xs-6 col-md-4">
                                <input type="text" class="form-control signature_date" name="signature_date" placeholder="DD/MM/YY"
                                       value="<?php echo $riskAssessmentForm ? checkKeyValueIfExists('signature_date', $riskAssessmentForm) : "" ?>">
                                <label>Date</label>
                            </div>
                        </div>

                    </div>
                    <br/>
                    </form>
                    <div class="row">
                        <div class="col-sm-12">
                            <button href="#physical-health-form" data-toggle="collapse" data-parent="#panelgroup"
                                    class="btn btn-primary prevBtn btn-sm pull-left mt-4 mb-3" type="button">Previous</button>
                            <button href="#lists" data-toggle="collapse" data-parent="#panelgroup"
                                    class="btn btn-success btn-sm pull-right mt-4 mb-3 send-r" style="width:15%;"
                                    type="button" id="submitRiskAssessmentForm">Next Page</button>
                        </div>
                    </div>
                </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.signature_date').datepicker({
            format: 'YYYY-MM-DD'
        });
        $('#submitRiskAssessmentForm').on('click', function (e) {
            e.preventDefault();
            var formData = new FormData(document.getElementById('riskAssessmentForm'));
            $.ajax({
                type: "POST",
                url: webRoot + '/portal/consentform/ajax.php?type=risk-assessment',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    returnData = JSON.parse(response);
                    if(returnData.consentForm){
                        if(returnData.consentForm.completed){
                            $('#patient-screening-form').hide();
                        }
                    }
                    console.log(response);
                },
                error: function (err) {
                    console.log(err);
                },
            });
        });
    });
</script>
</body>
