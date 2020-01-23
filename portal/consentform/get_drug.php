<?php
require_once("../verify_session.php");
require_once("../lib/consent_form.inc");
require_once("./../lib/appsql.class.php");

$consentForms = getConsentForms(1);
$patientConsentForm = getPatientConsentForm($pid);
$drugAlcoholForm = $patientConsentForm ? $patientConsentForm['drugs_form'] : [];
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

    .consent-inline input, .fee input, .drug input {
        border: none;
        border-bottom: 1px solid #333;
        box-shadow: none;
        border-radius: 0;
        margin-left: 10px;
    }

    .consent-inline input:focus, .fee input:focus, .drug input:focus {
        outline: none;
        box-shadow: none;
    }

    .fee input {
        width: 10%;
    }

    .fee input, .drug input {
        display: inline-block;
    }

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

    .drug div {
        margin-bottom: 1.5rem;
    }

    /*End of Mental Health Screening Page CSS*/
</style>

<body class="skin-blue md-bg">
<div class="container">
    <!-- End Insurance. Next what we've been striving towards..the end-->
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <fieldset>
                <legend class="bg-success title-bg text-center">Drug & Alcohol Screening Form</legend>
                <form method="post" class="ctm-form" id="drugAlcoholForm" enctype="multipart/form-data"
                      autocomplete="off">
                    <div class="well ml-bg register-success">
                        <div class="fee">
                            <div class="form-row">
                                <div class="col-sm-12 col-md-12">
                                    <label class="ctmcontainer">I have never been treated for drugs or alcohol
                                        <input type="checkbox" name="drug_past" checked="checked"
                                            <?php echo $drugAlcoholForm ? checkKeyValueIfExists('drug_past', $drugAlcoholForm) ? 'checked="checked"' : "" : "" ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>

                                <div class="col-sm-12 col-md-12">
                                    <label class="ctmcontainer d-inline">I am currently in treatment for drugs
                                        <input type="checkbox" name="drug_present"
                                            <?php echo $drugAlcoholForm ? checkKeyValueIfExists('drug_present', $drugAlcoholForm) ? 'checked="checked"' : "" : "" ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                    <input type="text" name="drugs" class="form-control" placeholder="fill here"
                                           value="<?php echo $drugAlcoholForm ? checkKeyValueIfExists('drugs', $drugAlcoholForm) : "" ?>">or
                                    alcohol
                                    <input type="text" name="alcohols" class="form-control" placeholder="fill here"
                                           value="<?php echo $drugAlcoholForm ? checkKeyValueIfExists('alcohols', $drugAlcoholForm) : "" ?>">Age
                                    first used
                                    <input type="text" name="first_used" class="form-control" placeholder="fill here"
                                           value="<?php echo $drugAlcoholForm ? checkKeyValueIfExists('first_used', $drugAlcoholForm) : "" ?>">
                                </div>

                                <div class="col-sm-12 col-md-12">
                                    <label class="ctmcontainer d-inline">I feel that I need to use drugs
                                        <input type="checkbox" name="drug_future"
                                            <?php echo $drugAlcoholForm ? checkKeyValueIfExists('drug_future', $drugAlcoholForm) ? 'checked="checked"' : "" : "" ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                    <input type="text" name="needed_drugs" class="form-control" placeholder="fill here"
                                           value="<?php echo $drugAlcoholForm ? checkKeyValueIfExists('needed_drugs', $drugAlcoholForm) : "" ?>">or
                                    alcohol
                                    <input type="text" name="needed_alcohols" class="form-control"
                                           placeholder="fill here"
                                           value="<?php echo $drugAlcoholForm ? checkKeyValueIfExists('needed_alcohols', $drugAlcoholForm) : "" ?>">
                                </div>

                            </div>
                        </div>
                        <div class="radio-block">
                            <table class="table ctm-table">
                                <tbody>

                                <?php
                                $count = 1;
                                $consentFormArray = $drugAlcoholForm ? checkKeyValueIfExists('consentForm', $drugAlcoholForm) : [];
                                foreach ($consentForms as $consentForm) {
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
                                                       value="0"
                                                    <?php echo $noValueFlag ? 'checked="checked"' : '' ?>>
                                                <span class="rcheckmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <?php $count++;
                                } ?>

                                </tbody>
                            </table>
                        </div>

                        <div class="drug">
                            <div class="row">
                                <label class="col-md-3">List drug/s of choice:</label>
                                <input type="text" name="drug_choices" class="col-md-4"
                                       value="<?php echo $drugAlcoholForm ? checkKeyValueIfExists('drug_choices', $drugAlcoholForm) : "" ?>">
                                <br/>
                            </div>
                            <div class="row">
                                <label class="col-md-3">Month/Year You Last Used: </label>
                                <input type="text" name="last_used_date" class="col-md-4 last_used_date"
                                       value="<?php echo $drugAlcoholForm ? checkKeyValueIfExists('last_used_date', $drugAlcoholForm) : "" ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <button href="#emotional-pain-form" data-toggle="collapse" data-parent="#panelgroup"
                                        class="btn btn-primary prevBtn btn-sm pull-left mt-4 mb-3" type="button">
                                    Previous
                                </button>
                                <button href="#physical-health-form" data-toggle="collapse" data-parent="#panelgroup"
                                        class="btn btn-success btn-sm pull-right mt-4 mb-3 send-r" style="width:15%;"
                                        type="submit" id="submitDrugAlcoholForm">Next Page
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.last_used_date').datepicker({
            format: 'YYYY-MM-DD'
        });
        $('#submitDrugAlcoholForm').on('click', function (e) {
            e.preventDefault();
            var formData = new FormData(document.getElementById('drugAlcoholForm'));
            $.ajax({
                type: "POST",
                url: webRoot + '/portal/consentform/ajax.php?type=drug-alcohol',
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
