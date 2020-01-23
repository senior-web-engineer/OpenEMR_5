<?php

require_once("../verify_session.php");
require_once("../lib/consent_form.inc");
require_once("./../lib/appsql.class.php");

$consentForms = getConsentForms(4);
$patientConsentForm = getPatientConsentForm($pid);
$physicalHealthForm = $patientConsentForm ? $patientConsentForm['physical_health_form'] : [];
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
                <legend class="bg-success title-bg text-center">Physical Health Screening Forms</legend>
                <div class="well ml-bg register-success">
                    <form method="post" class="ctm-form" id="physicalHealthForm" enctype="multipart/form-data" autocomplete="off">
                        <table class="table">
                            <thead class="tbl-heading">
                            <tr>
                                <th>Age</th>
                                <th>Height</th>
                                <th>Weight</th>
                                <th>Physician's Name</th>
                                <th>Physician's Telephone</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <select class="form-control" name="age">
                                        <?php
                                        for($age=1; $age<=10; $age++)
                                        {
                                            $selected = '';
                                            if($physicalHealthForm && checkKeyValueIfExists('age', $physicalHealthForm)){
                                                $selected = checkKeyValueIfExists('age', $physicalHealthForm) == $age ? 'selected="selected"' : '';
                                            }
                                            echo '<option value="'.$age.'"'.$selected.'>'.$age.' Year</option>';
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="height" value="<?php echo $physicalHealthForm ? checkKeyValueIfExists('height', $physicalHealthForm) : "" ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="weight" value="<?php echo $physicalHealthForm ? checkKeyValueIfExists('weight', $physicalHealthForm) : "" ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="physician_name" value="<?php echo $physicalHealthForm ? checkKeyValueIfExists('physician_name', $physicalHealthForm) : "" ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="physician_telephone" value="<?php echo $physicalHealthForm ? checkKeyValueIfExists('physician_telephone', $physicalHealthForm) : "" ?>">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="fee">
                            <div class="form-row">
                                <div class="col-sm-12 col-md-12">
                                    <label class="d-inline">I am currently in treatment for drugs</label>
                                    <input type="text" class="form-control" name="treatment_drugs" placeholder="fill here"
                                           value="<?php echo $physicalHealthForm ? checkKeyValueIfExists('treatment_drugs', $physicalHealthForm) : "" ?>">
                                    <label>Do you see your physician yearly?</label>
                                    <input type="text" class="form-control" name="physican_yearly" placeholder="fill here"
                                           value="<?php echo $physicalHealthForm ? checkKeyValueIfExists('physican_yearly', $physicalHealthForm) : "" ?>">
                                    Age first used
                                    <input type="number" class="form-control" name="age_first_used" placeholder="fill here"
                                           value="<?php echo $physicalHealthForm ? checkKeyValueIfExists('age_first_used', $physicalHealthForm) : "" ?>">
                                </div>

                                <div class="col-sm-12 col-md-12 ctm-form">
                                    <label class="d-inline">Surgical Operations:</label>
                                    <input type="text" class="form-control" name="surgical_operations"
                                           value="<?php echo $physicalHealthForm ? checkKeyValueIfExists('surgical_operations', $physicalHealthForm) : "" ?>">
                                    <label>your health is: </label>
                                    <label class="ctmcontainer d-inline">Good
                                        <input type="radio" name="health" value="good"
                                            <?php echo checkKeyValueIfExists('health', $physicalHealthForm) == 'good' ? 'checked="checked"' : '' ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="ctmcontainer d-inline">Poor
                                        <input type="radio" name="health" value="poor"
                                            <?php echo checkKeyValueIfExists('health', $physicalHealthForm) == 'poor' ? 'checked="checked"' : '' ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="ctmcontainer d-inline">Bad
                                        <input type="radio" name="health" name="bad"
                                            <?php echo checkKeyValueIfExists('health', $physicalHealthForm) == 'bad' ? 'checked="checked"' : '' ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>List all medicine(s) that you are currently taking:</label>
                                <textarea class="form-control" rows="3" name="currently_taking_medicines"
                                ><?php echo $physicalHealthForm ? checkKeyValueIfExists('currently_taking_medicines', $physicalHealthForm) : "" ?>
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label>List all medicine(s) to which you are allergic:</label>
                                <textarea class="form-control" rows="3" name="allergic_medicines"
                                ><?php echo $physicalHealthForm ? checkKeyValueIfExists('allergic_medicines', $physicalHealthForm) : "" ?>
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label>Describe any serious current or past illnesses:</label>
                                <textarea class="form-control" rows="3" name="current_past_illness"
                                ><?php echo $physicalHealthForm ? checkKeyValueIfExists('current_past_illness', $physicalHealthForm) : "" ?>
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label>Describe any sleeping problems you are having:</label>
                                <textarea class="form-control" rows="2" name="sleeping_problems"
                                ><?php echo $physicalHealthForm ? checkKeyValueIfExists('sleeping_problems', $physicalHealthForm) : "" ?>
                                </textarea>
                            </div>
                            <br/>
                        </div>
                        <div>
                            <h4>Check all problems that apply to you: </h4>
                            <br/>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-xs-6 col-md-3">
                                <label class="ctmcontainer">Physical
                                    <input type="checkbox"
                                        <?php echo $physicalHealthForm ? checkKeyValueIfExists('bladder_control', $physicalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="form-group col-xs-6 col-md-3">
                                <label class="ctmcontainer">Learning Disability
                                    <input type="checkbox" name="learning_disability"
                                        <?php echo $physicalHealthForm ? checkKeyValueIfExists('learning_disability', $physicalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="form-group col-xs-6 col-md-3">
                                <label class="ctmcontainer">Heart
                                    <input type="checkbox" name="heart"
                                        <?php echo $physicalHealthForm ? checkKeyValueIfExists('heart', $physicalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="form-group col-xs-6 col-md-3">
                                <label class="ctmcontainer">Breathing
                                    <input type="checkbox" name="breathing"
                                        <?php echo $physicalHealthForm ? checkKeyValueIfExists('breathing', $physicalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                        </div>

                        <div class="form-row">

                            <div class="form-group col-xs-6 col-md-3">
                                <label class="ctmcontainer">Kidney
                                    <input type="checkbox" name="kidney"
                                        <?php echo $physicalHealthForm ? checkKeyValueIfExists('kidney', $physicalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="form-group col-xs-6 col-md-3">
                                <label class="ctmcontainer">Diabetes
                                    <input type="checkbox" name="diabetes"
                                        <?php echo $physicalHealthForm ? checkKeyValueIfExists('diabetes', $physicalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="form-group col-xs-6 col-md-3">
                                <label class="ctmcontainer">Headaches
                                    <input type="checkbox" name="headaches"
                                        <?php echo $physicalHealthForm ? checkKeyValueIfExists('headaches', $physicalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="form-group col-xs-6 col-md-3">
                                <label class="ctmcontainer">Dizziness
                                    <input type="checkbox" name="dizziness"
                                        <?php echo $physicalHealthForm ? checkKeyValueIfExists('dizziness', $physicalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-xs-6 col-md-3">
                                <label class="ctmcontainer">Bleeding
                                    <input type="checkbox" name="bleeding"
                                        <?php echo $physicalHealthForm ? checkKeyValueIfExists('bleeding', $physicalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="form-group col-xs-6 col-md-3">
                                <label class="ctmcontainer">Back Pain
                                    <input type="checkbox" name="back_pain"
                                        <?php echo $physicalHealthForm ? checkKeyValueIfExists('back_pain', $physicalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="form-group col-xs-6 col-md-3">
                                <label class="ctmcontainer">Joint Pain
                                    <input type="checkbox" name="joint_pain"
                                        <?php echo $physicalHealthForm ? checkKeyValueIfExists('joint_pain', $physicalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="form-group col-xs-6 col-md-3">
                                <label class="ctmcontainer">Skin Rashes
                                    <input type="checkbox" name="skin_rashes"
                                        <?php echo $physicalHealthForm ? checkKeyValueIfExists('skin_rashes', $physicalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-xs-6 col-md-3">
                                <label class="ctmcontainer">Bad Teeth
                                    <input type="checkbox" name="bad_teeth"
                                        <?php echo $physicalHealthForm ? checkKeyValueIfExists('bad_teeth', $physicalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="form-group col-xs-6 col-md-3">
                                <label class="ctmcontainer">Cancer
                                    <input type="checkbox" name="cancer"
                                        <?php echo $physicalHealthForm ? checkKeyValueIfExists('cancer', $physicalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="form-group col-xs-6 col-md-3">
                                <label class="ctmcontainer">Bladder Control
                                    <input type="checkbox" name="bladder_control"
                                        <?php echo $physicalHealthForm ? checkKeyValueIfExists('bladder_control', $physicalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="form-group col-xs-6 col-md-3">
                                <label class="ctmcontainer">Seizures
                                    <input type="checkbox" name="seizures"
                                        <?php echo $physicalHealthForm ? checkKeyValueIfExists('seizures', $physicalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-xs-6 col-md-3">
                                <label class="ctmcontainer">Stomach Aches
                                    <input type="checkbox" name="stomach_aches"
                                        <?php echo $physicalHealthForm ? checkKeyValueIfExists('stomach_aches', $physicalHealthForm) ? 'checked="checked"': "" : "" ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="form-group col-xs-12 col-md-12">
                                <label>Other (list): </label>
                                <textarea class="form-control" rows="2" name="other_lists"
                                ><?php echo $physicalHealthForm ? checkKeyValueIfExists('other_lists', $physicalHealthForm) : "" ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-12 block-center">
                                <h4>Nutritional Screening - The Nutrition Risk Assessment (NRA)</h4>
                                <h5>Please read the following and check the statement that is true for you:</h5>
                                <table class="table">
                                    <thead class="tbl-heading">
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Description</th>
                                        <th>Score</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $count = 1;
                                    $consentFormArray = $physicalHealthForm ? checkKeyValueIfExists('consentForm', $physicalHealthForm) : [];
                                    foreach($consentForms as $consentForm){
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $count ?></th>
                                        <td><?php echo $consentForm['question'] ?></td>
                                        <td><?php echo $consentForm['full_score'] ?></td>
                                        <td>
                                            <label class="ctmcontainer">
                                                <input type="checkbox" name="consentForm[<?php echo $consentForm['id'] ?>]" value="1"
                                                    <?php echo get_value($consentFormArray, $consentForm['id']) == 1 ? 'checked="checked"' : '' ?>>
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <?php $count++; }  ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xs-12 col-md-12 blue-text-block">
                                <h4>Total Your Nutritional Score.  If it’s –</h4>
                                <p>0 - 2  Good! Recheck your nutritional score in 6 months.</p>
                                <p>You are at moderate nutritional risk. See what can be done to improve your eating habits and lifestyle.  Recheck your nutritional score in 3 months.</p>
                                <p>6 or more    You are at high nutritional risk. Please follow-up with your primary health care doctor or make an appointment with your local health department.</p>
                            </div>
                        </div>
                        <br/>
                    <div class="row">
                        <div class="col-sm-12">
                            <button href="#drug-alcohol-form" data-toggle="collapse" data-parent="#panelgroup"  class="btn btn-primary prevBtn btn-sm pull-left mt-4 mb-3" type="button">Previous</button>
                            <button href="#risk-assessment-form" data-toggle="collapse" data-parent="#panelgroup" class="btn btn-success btn-sm pull-right mt-4 mb-3 send-r" style="width:15%;"
                                    type="button" id="submitPhysicalHealthForm">Next Page</button>
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
        $('#submitPhysicalHealthForm').on('click', function (e) {
            e.preventDefault();
            var formData = new FormData(document.getElementById('physicalHealthForm'));
            $.ajax({
                type: "POST",
                url: webRoot + '/portal/consentform/ajax.php?type=physical-health',
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
