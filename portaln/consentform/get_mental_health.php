<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once("../verify_session.php");
require_once("../lib/consent_form.inc");
require_once("./../lib/appsql.class.php");

$consentForms = getConsentForms(2);
$patientConsentForm = getPatientConsentForm($pid);
$mentalHealthForm = $patientConsentForm ? $patientConsentForm['mental_health_form'] : [];
?>
<style>
    .display-block {
        display: block !important;
    }

    fieldset hr {
        margin-top: 12px;
        margin-bottom: 12px;
    }

    .consent-inline p, .consent-inline form, .fee form, .fee form label {
        display: inline-block;
    }

    .consent-inline input, .fee input {
        border: none;
        border-bottom: 1px solid #333;
        box-shadow: none;
        border-radius: 0;
        margin-left: 10px;
    }

    .consent-inline input:focus, .fee input:focus {
        outline: none;
        box-shadow: none;
    }

    .fee input {
        width: 10%;
        display: inline-block;
    }
</style>
<style>
    /*Start of Tab CSS*/
    /* TAB CSS for Open EMr */
    .tabconten-block {
        background: #fff;
        padding: 0px 15px;
    }

    .tabinnercontent {
        margin: 15px 0px;
        display: inline-block;
        width: 100%;
    }

    .so-tabnav, .so-tabwrap {
        -webkit-box-shadow: 0px -2px 20px 0px rgba(163, 163, 163, 0.10);
        -moz-box-shadow: 0px -2px 20px 0px rgba(163, 163, 163, 0.10);
        box-shadow: 0px -2px 25px 0px rgba(163, 163, 163, 0.10);
    }

    .so-tabnav {
        background: rgba(250, 250, 250, 1);
        background: -moz-linear-gradient(top, rgba(250, 250, 250, 1) 0%, rgba(235, 235, 235, 1) 100%);
        background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(250, 250, 250, 1)), color-stop(100%, rgba(235, 235, 235, 1)));
        background: -webkit-linear-gradient(top, rgba(250, 250, 250, 1) 0%, rgba(235, 235, 235, 1) 100%);
        background: -o-linear-gradient(top, rgba(250, 250, 250, 1) 0%, rgba(235, 235, 235, 1) 100%);
        background: -ms-linear-gradient(top, rgba(250, 250, 250, 1) 0%, rgba(235, 235, 235, 1) 100%);
        background: linear-gradient(to bottom, rgb(248, 252, 255) 0%, rgb(234, 245, 255) 100%);
    }

    .so-tabnav li a {
        padding: 12px 20px 12px 10px;
    }

    .so-tabnav > li.active > a, .so-tabnav > li.active > a:focus, .so-tabnav > li.active > a:hover {
        border-top: 3px solid #1d6ebc;
    }

    .so-tabnav > li > a:hover {
        border-color: #f2f9ff #ecf6ff #ebf5ff;
        background-color: #e2f1ff !important;
    }

    .termscheck-wrap a {
        color: #333;
    }

    .termscheck-wrap a:hover {
        color: #1d6ebc;
    }

    .ctmcontainer {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 16px;
        font-weight: normal;
        text-align: left;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .ctmcontainer input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 22px;
        width: 22px;
        background-color: #eee;
    }

    /* On mouse-over, add a grey background color */
    .ctmcontainer:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .ctmcontainer input:checked ~ .checkmark {
        background-color: #1d6ebc;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .ctmcontainer input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .ctmcontainer .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    /*CSS for Custom Radio Button---------
    ----------------------------------*/
    /* Customize the label (the container) */
    .radiocontainer {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 16px;
        font-weight: normal;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default radio button */
    .radiocontainer input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom radio button */
    .rcheckmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%;
    }

    /* On mouse-over, add a grey background color */
    .radiocontainer:hover input ~ .rcheckmark {
        background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .radiocontainer input:checked ~ .rcheckmark {
        background-color: #2196F3;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .rcheckmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .radiocontainer input:checked ~ .rcheckmark:after {
        display: block;
    }

    /* Style the indicator (dot/circle) */
    .radiocontainer .rcheckmark:after {
        top: 9px;
        left: 9px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
    }

    /*End of Custom Radio CSS-----
    ----------------------------------*/
    /*Mental Health Screening Page CSS------
    --------------------------------------*/
    .radio-block {
        font-size: 16px;
    }

    .ctm-table {
        margin-top: 1.5em;
    }

    .ctm-form {
        display: inline-block;
    }

    /*End of Mental Health Screening Page CSS*/
</style>

<body class="skin-blue md-bg">
<div class="container">
    <!-- End Insurance. Next what we've been striving towards..the end-->
    <div class="row" class="display-block">
        <div class="col-xs-12 col-md-12">
            <fieldset>
                <legend class="bg-success title-bg text-center">Mental Health Screening Form</legend>
                <div class="well ml-bg register-success">
                    <form class="ctm-form" method="post" class="ctm-form" id="mentalHealthForm" enctype="multipart/form-data" autocomplete="off">
                        <div>
                            <div class="form-row">
                                <div class="col-sm-12 col-md-6">
                                    <label class="ctmcontainer">I have never been treated for mental or emotional problems
                                        <input type="checkbox" name="never_treated"
                                            <?php echo $mentalHealthForm ? checkKeyValueIfExists('never_treated', $mentalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <label class="ctmcontainer">I am currently in treatment
                                        <input type="checkbox" name="currentlt_in_treatment"
                                            <?php echo $mentalHealthForm ? checkKeyValueIfExists('currentlt_in_treatment', $mentalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <label class="ctmcontainer">I have been treated in the past
                                        <input type="checkbox" name="treated_in_past"
                                            <?php echo $mentalHealthForm ? checkKeyValueIfExists('treated_in_past', $mentalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <label class="ctmcontainer">I need mental health help
                                        <input type="checkbox" name="mental_health_help"
                                            <?php echo $mentalHealthForm ? checkKeyValueIfExists('mental_health_help', $mentalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="radio-block">
                            <table class="table ctm-table">
                                <tbody>
                                <?php
                                $count = 1;
                                $consentFormArray = $mentalHealthForm ? checkKeyValueIfExists('consentForm', $mentalHealthForm) : [];
                                foreach($consentForms as $consentForm){
                                    $value = get_value($consentFormArray, $consentForm['id']);
                                    $noValueFlag = !is_null($value) && $value == 0 ? 1 : 0;
                                ?>
                                <tr>
                                    <th scope="row" class="col-xs-1"><?php echo $count ?>)</th>
                                    <td class="col-xs-9"><?php echo $consentForm['question'] ?></td>
                                    <td class="col-xs-1">
                                        <label class="radiocontainer">Yes
                                            <input type="radio" name="consentForm[<?php echo $consentForm['id'] ?>]"
                                            value="1" checked="checked">
                                            <span class="rcheckmark"></span>
                                        </label>
                                    </td>
                                    <td class="col-xs-1">
                                        <label class="radiocontainer">No
                                            <input type="radio" name="consentForm[<?php echo $consentForm['id'] ?>]"
                                            value="0" <?php echo $noValueFlag ? 'checked="checked"' : "" ?>>
                                            <span class="rcheckmark"></span>
                                        </label>
                                    </td>
                                </tr>
                                    <?php $count++; }  ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button href="#emotional-pain-form" data-toggle="collapse" data-parent="#panelgroup" class="btn btn-success btn-sm pull-right mt-4 mb-3 send-r" style="width:15%;"
                                        type="button" id="submitMentalHealthForm">Next Page</button>
                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#submitMentalHealthForm').on('click', function (e) {
            e.preventDefault();
            var formData = new FormData(document.getElementById('mentalHealthForm'));
            $.ajax({
                type: "POST",
                url: webRoot + '/portal/consentform/ajax.php?type=mental-health',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
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
