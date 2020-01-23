<?php

require_once("../verify_session.php");
require_once("../../library/forms.inc");
require_once("./../lib/appsql.class.php");
$pid = '5';
$treatmentPlans = getAllActiveTreatmentPlansByPid($pid, '*');
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
                <legend class="bg-success title-bg text-center"><?php echo xlt('Treatment Plans') ?></legend>
                <div class="well ml-bg register-success">
                        <div class="row">
                            <div class="col-xs-12 col-md-12 block-center">
                                <table class="table">
                                    <thead class="tbl-heading">
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Service Name</th>
                                        <th>Status</th>
                                        <th>By</th>
                                        <th>Options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $count = 1;
                                    foreach($treatmentPlans as $treatmentPlan){
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $count ?></th>
                                            <td><?php echo $treatmentPlan['service_name'] ?></td>
                                            <td><?php echo $treatmentPlan['form_status'] ?></td>
                                            <td><?php echo $treatmentPlan['user'] ?></td>
                                            <td>
                                                <a data-toggle="modal"
                                                   href="./consentform/get_treatment_plan_detail.php?id=<?php echo $treatmentPlan['id'] ?>"
                                                   data-target="#viewTreatmentPlanModal" title="View Plan">
                                                    <i class="fa fa-lg fa-eye" aria-hidden="true"></i>View
                                                </a>&nbsp;
                                                <a href="./consentform/print_treatment_plan_detail.php?id=<?php echo $treatmentPlan['id'] ?>"
                                                    title="Print Plan" target="_blank">
                                                    <i class="fa fa-lg fa-print" aria-hidden="true"></i>Print
                                                </a>&nbsp;
                                            </td>
                                        </tr>
                                    <?php $count++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br/>
                </div>
            </fieldset>
        </div>
    </div>
</div>

<div id="viewTreatmentPlanModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"></div>
    </div>
</div><!-- Modal -->

<script type="text/javascript">
    $(document).ready(function () {
        $('#viewTreatmentPlanModal').on('hidden.bs.modal', function () {
            $(this).data('bs.modal', null);
            $('#viewTreatmentPlanModal').removeData('bs.modal');
        });

        $('#viewTreatmentPlanModal').on('click', '.sign-treatment-plan', function (e) {
            e.preventDefault();
            $object = $(this);
            var treatmentPlanId = $object.attr('id').replace(/^\D+/g, '');
            $.ajax({
                type: "POST",
                url: webRoot + '/portal/consentform/sign_treatment_plan_detail.php',
                data: {'tpid':treatmentPlanId},
                success: function (response) {
                    var res = JSON.parse(response);
                    if(res.type == 'success'){
                        $($object).html("<p>You have already signed this treatment plan.</p>");
                        alert(res.message);
                    } else {
                        alert(res.message);
                    }
                    console.log(res);
                },
                error: function (err) {
                    console.log(err);
                },
            });
        });
    });
</script>
</body>
