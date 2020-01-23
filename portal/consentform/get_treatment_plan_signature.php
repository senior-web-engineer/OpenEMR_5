<?php

require_once("../verify_session.php");
require_once("../../library/forms.inc");
require_once("./../lib/appsql.class.php");

$treatmentPlans = getAllTreatmentPlansByPid($pid, '*');
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Treatment Plan Signature</h4>

</div>
<div class="modal-body">
    <form name="signit" id="signit" class="sigPad">
        <ul class="sigNav">
            <label style='display: none;'>
                <input style='display: none;' type="checkbox" class="" id="isAdmin" name="isAdmin"/>
                <?php echo xlt('Is Authorizing Signature'); ?>
            </label>
            <li class="clearButton"><a href="#clear">
                    <button><?php echo xlt('Clear Signature'); ?></button>
                </a></li>
        </ul>
        <div class="sig sigWrapper">
            <div class="typed"></div>
            <canvas class="spad" id="drawpad" width="765" height="325"
                    style="border: 1px solid #000000; left: 0px;"></canvas>
            <img id="loading" src="sign/assets/loading.gif"
                 style="display: none; position: absolute; TOP: 150px; LEFT: 315px; WIDTH: 100px; HEIGHT: 100px"/>
            <input type="hidden" id="output" name="output_signature" class="output">
        </div>
        <input type="hidden" name="type" id="type" value="guardian-signature">
        <button type="button"
                onclick="signConsentForm(this)"><?php echo xlt('Acknowledge as my Electronic Signature'); ?>.
        </button>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
