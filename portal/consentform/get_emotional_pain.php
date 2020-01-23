<?php

require_once("../verify_session.php");
require_once("../lib/consent_form.inc");
require_once("./../lib/appsql.class.php");

$consentForms = getConsentForms(3);
$patientConsentForm = getPatientConsentForm($pid);
$emotionalPainForm = $patientConsentForm ? $patientConsentForm['emotional_pain_form'] : [];
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
                <legend class="bg-success title-bg text-center">Emotional Pain Scale</legend>
                <div class="well ml-bg register-success">
                    <form method="post" class="ctm-form" id="emotionalPainForm" enctype="multipart/form-data" autocomplete="off">
                    <div class="pain-block">
                        <p>This scale is intended to measure how much pain an adult or child is feeling inside.  The face and the number correspond to the level of pain.  Please pick a number from 0-10.
                        </p>
                        <p>This face [labeled 0]] shows no pain. The faces show more and more pain [labeled 2 to 8] up to 10 – shows very much pain.  Select the face that shows how much you hurt [right now]." Score the chosen face 0, 2, 4, 6, 8, or 10, counting left to right, so '0' = 'no pain' and '10' = 'very much pain.'</p>
                        <br/>
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td><img src="images/pain0.png"></td>
                                <td><img src="images/pain2.png"></td>
                                <td><img src="images/pain4.png"></td>
                                <td><img src="images/pain6.png"></td>
                                <td><img src="images/pain8.png"></td>
                                <td><img src="images/pain10.png"></td>
                            </tr>
                            <tr>
                                <td>0</td>
                                <td>2</td>
                                <td>4</td>
                                <td>6</td>
                                <td>8</td>
                                <td>10</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <label>Describe any pain you are having:</label>
                            <textarea class="form-control" rows="3" name="any_pain"
                            ><?php echo $emotionalPainForm ? checkKeyValueIfExists('any_pain', $emotionalPainForm) : "" ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button href="#mental-health-form" data-toggle="collapse" data-parent="#panelgroup"  class="btn btn-primary prevBtn btn-sm pull-left mt-4 mb-3" type="button">Previous</button>
                            <button href="#drug-alcohol-form" data-toggle="collapse" data-parent="#panelgroup" class="btn btn-success btn-sm pull-right mt-4 mb-3 send-r" style="width:15%;"
                                    type="submit" id="submitEmotionalPainForm">Next Page
                            </button>
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
        $('#submitEmotionalPainForm').on('click', function (e) {
            e.preventDefault();
            var formData = new FormData(document.getElementById('emotionalPainForm'));
            $.ajax({
                type: "POST",
                url: webRoot + '/portal/consentform/ajax.php?type=emotional-pain',
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
