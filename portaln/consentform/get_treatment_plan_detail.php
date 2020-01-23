<?php

require_once("../verify_session.php");
require_once("../../library/forms.inc");
require_once("../../library/api.inc");
require_once("./../lib/appsql.class.php");
require_once("$srcdir/patient.inc");

$id = $_GET["id"];
$treatmentPlan = getTreatmentPlanById($id);

$res = sqlStatement("SELECT fname,mname,lname,ss,sex,DOB,pid FROM patient_data WHERE pid = $pid");
$result = SqlFetchArray($res);
$provider_results = sqlQuery("select fname, mname, lname from users where username='" . $_SESSION{"authUser"} . "'");
$rendering_provider = sqlQuery("SELECT u.fname, u.mname, u.lname FROM (SELECT provider_id FROM form_encounter where encounter='$encounter') AS e LEFT JOIN (SELECT fname, mname, lname, id FROM  users) AS u ON e.provider_id = u.id");
$dos = sqlQuery("select date from form_encounter where encounter=$encounter");
$obj = formFetch("form_treatment_plan", $_GET["id"]);
$facility = sqlQuery("SELECT name,attn,phone,fax,street,city,state,postal_code FROM facility WHERE facility_code = 'Print'");

$patientSignature = getPatientSignature($pid, 'patient-signature');

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
    <h3 class="modal-title" id="myModalLabel"><?php echo xlt('Treatment Plan') ?></h3>
</div>
<div class="modal-body">
    <table class="table-hover table table-bordered table-condensed">
        <tr>
            <td>
                <div class="facility-info">
                    <?php echo $facility['name'] ?><br>
                    <?php echo $facility['street'] ?><br>
                    <?php echo $facility['city'] ?>
                    , <?php echo $facility['state'] ?> <?php echo $facility['postal_code'] ?><br>
                    Tel: <?php echo $facility['phone'] ?> | Fax: <?php echo $facility['fax'] ?>
                </div>
            </td>
            <td>
                <div class="form-info">
                    <span>Client Name:</span><?php echo $result['fname'] . '&nbsp' . $result['mname'] . '&nbsp;' . $result['lname']; ?>
                    <br>
                    <span>DOB:</span><?php echo $result['DOB']; ?><br>
                    <span>SS#:</span><?php echo $result['ss']; ?><br>
                    <span>Date of Service:</span><?php echo substr($dos["date"], 0, 10); ?><br>
                    <span>Admission Date:</span><?php echo stripslashes($result{"admit_date"}); ?><br>
                    <span>Clinician:</span><?php echo $rendering_provider["fname"] . ' ' . $rendering_provider["mname"] . ' ' . $rendering_provider["lname"]; ?>
                    <br>
                    <span>Sex:</span><?php echo $result['sex']; ?><br>
                </div>
            </td>
        </tr>
    </table>
    <table class="table-hover table table-bordered table-condensed">
        <tr>
            <th><h3>Diagnosis</h3></th>
            <td>
                <?php
                $sql6 = "SELECT da.form_id, da.Description AS dadescription " .
                    "FROM form_treatment_plan_diagnosis AS da " .
                    "WHERE da.form_id = $id " .
                    "AND (IsDeleted is Null or IsDeleted = 0) ";
                $result6 = sqlStatement($sql6);
                $print3 = "";
                while ($row6 = sqlFetchArray($result6)) {
                    $dadescription = $row6['dadescription'];
                    //echo "<span>".$dadescription . "</span>";
                    echo "<li class=''>" . $dadescription . "</li>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <th><h3>Problems</h3></th>
            <td>
                <table>
                    <?php
                    $sql = "SELECT tp.id, tp.Description AS tpdescription, tp.tp_problem_number AS tptp_problem_number, tp.form_id , tp.IsPrimary AS tpisrimary " .
                        "FROM form_treatment_plan_problems AS tp " .
                        "WHERE tp.form_id = $id and (IsDeleted is Null or IsDeleted = 0) " .
                        "ORDER BY tp.IsPrimary";
                    $result = sqlStatement($sql);
                    while ($row = sqlFetchArray($result)) {
                        $problem_id = $row['id'];
                        $tpproblem_number = $row['tptp_problem_number'];
                        $tpdescription = $row['tpdescription'];
                        $tpisprimary = $row['tpisrimary'];
                        ?>
                        <tr>
                            <?php if ($tpisprimary == "1") { ?>
                                <th>Primary Problem :</th>
                                <td><?php echo $row['tpdescription'] ?></td>
                            <?php } else { ?>
                                <th>Secondary Problem :</th>
                                <td><?php echo $row['tpdescription'] ?></td>
                            <?php } ?>
                        </tr>

                        <?php
                        //---- Goals -----
                        $sql3 = "SELECT gl.Description AS gldescription, gl.goal_status AS glgoal_status, gl.goal_action AS glgoal_action, gl.review_status AS glreview_status " .
                            "FROM form_treatment_plan_goals AS gl " .
                            "WHERE gl.form_id = $id AND gl.problem_id = $problem_id and (IsDeleted is Null or IsDeleted = 0) " .
                            "GROUP BY gldescription ";
                        $result3 = sqlStatement($sql3);
                        $print = "";
                        $print_review = "";
                        while ($row3 = sqlFetchArray($result3)) {
                            ?>
                            <tr>
                                <th>Goals :</th>
                                <td>
                                    <table>
                                        <tr colspan="2">
                                            <td><?= $row3['gldescription'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Status :</td>
                                            <td><?= $row3['glgoal_action'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Goal Action :</td>
                                            <td><?= $row3['glgoal_status'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Status Description :</td>
                                            <td><?= $row3['glreview_status'] ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <?php
                        }

                        //---- Objectives -----
                        $sql4 = "SELECT oj.id AS ojid, oj.Description AS ojdescription, oj.ObjectiveNumber AS ojObjectiveNumber, oj.target_date AS ojtarget_date " .
                            "FROM form_treatment_plan_objectives AS oj " .
                            "WHERE oj.form_id = $id AND oj.problem_id = $problem_id and (IsDeleted is Null or IsDeleted = 0) " .
                            "ORDER BY oj.id";
                        $result4 = sqlStatement($sql4);
                        $print = "";
                        while ($row4 = sqlFetchArray($result4)) {
                            $ojdescription = $row4['ojdescription'];
                            $objectivenumber = $row4['ojObjectiveNumber'];
                            $ojtarget_date = $row4['ojtarget_date'];
                            $ojid = $row4['ojid'];
                            ?>
                            <tr>
                                <th>Objectives :</th>
                                <td>
                                    <table>
                                        <tr>
                                            <td colspan="2"><?= $row4['ojdescription'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Target Date :</td>
                                            <td><?= $row4['ojtarget_date'] ?></td>
                                        </tr>

                                        <?php

                                        //*************INTERVENTIONS***************************************
                                        $sql5 = "SELECT it.form_id, it.Description AS itdescription, it.ObjectiveID AS itObjectiveID " .
                                            "FROM form_treatment_plan_interventions AS it " .
                                            "WHERE it.form_id = $id  AND it.ObjectiveID = $ojid and (IsDeleted is Null or IsDeleted = 0) " .
                                            "AND it.tp_problem_number = $tpproblem_number ";
                                        $result5 = sqlStatement($sql5);
                                        $print2 = "";
                                        while ($row5 = sqlFetchArray($result5)) {
                                            $itdescription = $row5['itdescription'];
                                            $print2 .= "<p>" . $itdescription . "</p>";
                                        }
                                        ?>
                                        <tr>
                                            <td>Interventions :</td>
                                            <td><?= $print2 ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>

                    <?php } ?>
                </table>
            </td>
        </tr>

        <tr>
            <th><h3>Modalities</h3></th>
            <td>
                <?php
                $sql7 = "SELECT mo.form_id, mo.start_date AS mostart_date, mo.end_date AS moend_date, mo.hcpt AS mohcpt, mo.intervals AS mointervals, mo.frequency AS mofrequency, mo.provider AS moprovider, mo.modality AS momodality " .
                    "FROM form_treatment_plan_modalities AS mo " .
                    "WHERE mo.form_id = $id " .
                    "AND (IsDeleted is Null or IsDeleted = 0) ";
                $result7 = sqlStatement($sql7);
                $print3 = "";
                while ($row7 = SqlFetchArray($result7)) {
                    ?>
                    <table>
                        <tr>
                            <th>Start Date :</th>
                            <td width="25%"><?= $row7['mostart_date'] ?></td>
                            <th>End Date :</th>
                            <td width="25%"><?= $row7['moend_date'] ?></td>
                        </tr>
                        <tr>
                            <th>Service Description :</th>
                            <td colspan="3"><?= $row7['momodality'] ?></td>
                        </tr>
                        <tr>
                            <th>CPT\HCPCS Code :</th>
                            <td><?= $row7['mohcpt'] ?></td>
                            <th>Interval :</th>
                            <td><?= $row7['mointervals'] ?></td>
                        </tr>
                        <tr>
                            <th>Frequency :</th>
                            <td><?= $row7['mofrequency'] ?></td>
                            <th>Responsible Provider :</th>
                            <td><?= $row7['mointervals'] ?></td>
                        </tr>
                    </table>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <th><h3>Modalities Note</h3></th>
            <td>
                <?php
                $sql8 = "SELECT mo.form_id, mo.notes AS monotes " .
                    "FROM form_treatment_plan_modalitynotes AS mo " .
                    "WHERE mo.form_id = $id " .
                    "AND (IsDeleted is Null or IsDeleted = 0) ";
                $result8 = sqlStatement($sql8);
                $print3 = "";
                while ($row8 = SqlFetchArray($result8)) {
                    $monotes = $row8['monotes'];
                    //$print3 .= "<li class=''>". $dadescription ."</li>";
                    echo "<span>" . $monotes . "</span>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <th><h3>Discharge Criteria</h3></th>
            <td>
                <?php
                $sql9 = "SELECT dc.form_id, dc.criteria AS dccriteria " .
                    "FROM form_treatment_plan_dischargecriteria AS dc " .
                    "WHERE dc.form_id = $id " .
                    "AND (IsDeleted is Null or IsDeleted = 0) ";
                $result9 = sqlStatement($sql9);
                $print3 = "";
                while ($row9 = SqlFetchArray($result9)) {
                    $dccriteria = $row9['dccriteria'];
                    echo "<span>" . $dccriteria . "</span>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="treatmentPlanSignatureBlock">
                    <?php
                    if($treatmentPlan['date_email_patient']) {
                        if ($treatmentPlan['patient_signature']) {
                            echo 'You have already signed this treatment plan.';
                            echo '<p>' . $patientSignature['signature'] . '</p>';
                        } else {
                            if ($patientSignature) {
                                echo '<p>' . $patientSignature['signature'] . '</p>';
                                ?>
                                <button type="button" class="btn btn-default sign-treatment-plan"
                                        id="treatmentPlan-<?php echo $treatmentPlan['id'] ?>">Allow my Signature in this
                                    treatment plan
                                </button>

                                <?php
                            } else {
                                echo 'Signature is not uploaded.';
                            }
                        }
                    }
                    ?>
                </div>
            </td>
        </tr>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>