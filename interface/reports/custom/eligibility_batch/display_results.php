<!--*******************************************************-->
<!--*******************************************************-->
<!--**                                                   **-->
<!--**  amed in memory of Pipopo, aka Kraken.            **-->
<!--** When released, things happen, good and bad.       **-->
<!--** So be careful, when you 'Release The Kraken!'     **-->
<!--**                                                   **--> 
<!--*******************************************************-->
<!--*******************************************************-->
<?php
include_once("../../../globals.php");
require_once("$srcdir/patient.inc");
require_once("$srcdir/formatting.inc.php");
require_once("$srcdir/options.inc.php");
require_once("$srcdir/forms.inc");
require_once("$srcdir/billing.inc");
require_once("$srcdir/calendar.inc");
require_once("$srcdir/edi.inc");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Eligibility</title>
    <script src="../js/jquery.min.js"></script>
		
    <!-- stylesheets -->
    <link rel=stylesheet href="../js/bootstrap-3.3.7/css/bootstrap.min.css" type="text/css">
    
    <!--[if lt IE 9]>
        <script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- supporting javascript code -->
    
    <script type="text/javascript" src="../js/bootstrap-3.3.7/js/bootstrap.min.js"></script>
    
    <!-- supporting javascript code -->
    
    <!-- Demo styling -->
	<link href="../docs/css/jq.css" rel="stylesheet">

	<!-- jQuery: required (tablesorter works with jQuery 1.2.3+) -->

	<!-- Pick a theme, load the plugin & initialize plugin -->
	<link href="../css/theme.blue.css" rel="stylesheet">
	<script src="../js/jquery.tablesorter.min.js"></script>
	<script src="../js/jquery.tablesorter.widgets.min.js"></script>
	<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->

    <script src="scripts/display_results.js"></script>
    <script type="text/javascript">
        // NOTE: currently not being used
        // $(document).ready(function() {
        //     $('.datepicker').datetimepicker({
        //         < ?php $datetimepicker_timepicker = false; ?>
        //         < ?php $datetimepicker_showseconds = false; ?>
        //         < ?php $datetimepicker_formatInput = true; ?>
        //         < ?php require($GLOBALS['srcdir'] . '/js/xl/jquery-datetimepicker-2-5-4.js.php'); ?>
        //         // can add any additional javascript settings to datetimepicker here; need to prepend first setting with a comma
        //     });
        // });
    </script>

</head>
<body class="body_top">

    <!-- Required for the popup date selectors -->
    <div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>

    <span class='title'><?php echo xlt('Report'); ?> - <?php echo xlt('Eligibility Inquiry Results Batch'); ?></span>
<!--
    <div id="report_parameters_daterange">
        <?php echo text(oeFormatShortDate($form_from_date)) . " &nbsp; " . xlt('to') . "&nbsp; ". text(oeFormatShortDate($form_to_date)); ?>
    </div>
-->

    <!-- RESULTS TEMPLATE 
        REQUIREMENTS: 
        1) Bootstrap 3 js and css must be included in the header of this file
        2) Each element must have a 'detailRow' class and an id. example:
            echo "<tr class='auto-style1 detailRow' id='" . $recid . "'>".
    -->
    <script>
        var WEBROOT = '<?php echo $GLOBALS['webroot'] ?>/interface/reports/custom/eligibility_batch';
    </script>
    <script src="<?php echo $GLOBALS['webroot'] ?>/interface/reports/custom/eligibility_batch/templateModal/handlebars-v4.1.2.js"></script><!-- template engine -->
    <script src="<?php echo $GLOBALS['webroot'] ?>/interface/reports/custom/eligibility_batch/templateModal/handlebar-pretty-json.js"></script><!-- template engine -->
	<script src="<?php echo $GLOBALS['webroot'] ?>/interface/reports/custom/eligibility_batch/templateModal/resultsModal.js"></script><!-- logic -->
	<link href="<?php echo $GLOBALS['webroot'] ?>/interface/reports/custom/eligibility_batch/templateModal/resultsTemplate.css" rel="stylesheet">
    <div id="results_div"></div><!-- placeholder for the data popup for results -->
    <div id="loading_div"></div><!-- placeholder for the loading popup for results -->
    <!-- END RESULTS TEMPLATE -->
    
    <form method='post' name='theform' id='theform' action='edi_270.php' onsubmit="return top.restoreSession()">
        <input type="hidden" name="removedrows" id="removedrows" value="">
        <div id="report_parameters">
            <table>
                <tr>
                    <td width='550px'>
                        <div style='float:left'>
                            <table class='text'>
                            <!--    <tr>
                                    <td class='control-label'>
                                        <?php echo xlt('From'); ?>:
                                    </td>
                                    <td>
                                        <input type='text' class='datepicker form-control' name='form_from_date' id="form_from_date" size='10' value='<?php echo attr(oeFormatShortDate($from_date)); ?>'>
                                    </td>
                                    <td class='control-label'>
                                        <?php echo xlt('To'); ?>:
                                    </td>
                                    <td>
                                        <input type='text' class='datepicker form-control' name='form_to_date' id="form_to_date" size='10' value='<?php echo attr(oeFormatShortDate($to_date)); ?>'>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            -->      <tr>
                                    <td class='control-label'>
                                        <?php echo xlt('Select Batch'); ?>:
                                    </td>
                                    <td>

                                    <?php
                                    $user= $_SESSION["authUser"];
                                    
                                    //$tracking_id = '38';
                                    $tracking_id = $_POST["tracking_id"];
                                    $mysqli = mysqli_connect($host, $login, $pass, $dbase, $port) or die(mysqli_connect_error());				//echo $host;
                                    
                                    //$batch = "SELECT id,user,date FROM eligibility_request_tracking WHERE user = '$user';";
                                    $batch = "SELECT id,user,date FROM eligibility_request_tracking;";
                                    //echo $query;
                                    // Execute it, or return the error message if there's a problem.
                                    $batch_result = $mysqli -> query($batch);
                                    $dropdown1 .= "<select id='tracking_id' name='tracking_id' class='form-control' required ><option selected=''></option>";
                                    $dropdown1 .= "<option value='All'>All</option>";
                                    while($row = mysqli_fetch_array($batch_result)) {
                                        $dropdown1 .= "\r\n<option value='{$row['id']}'>{$row['id']}". "  "."{$row['date']}". "  "."{$row['user']}</option>";
                                    }
                                    $dropdown1 .= "\r\n</select>";
                                   
                                    echo  $dropdown1, "" ;
                                    ?>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>PID</td>
                                </tr>
                                
                            </table>
                        </div>
                    </td>
                    <td align='left' valign='middle' height="100%">
                        <table style='border-left:1px solid; width:100%; height:100%' >
                            <tr>
                                <td>
                                    <div class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href='#' class='btn btn-default btn-refresh' onclick='ActionDeterminator(); $("#theform").submit();'>
                                                <?php echo xlt('Refresh'); ?>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <div class='text'>
            <?php echo xlt('Please choose date range criteria above, and click Refresh to view results.'); ?>
        </div>

    </form>

    <!--<td>
            <select name='form_users' class='form-control' onchange='form.submit();'>
            <option value=''>-- <?php echo xlt('All'); ?> --</option>
            <?php foreach ($providers as $user) : ?>
                <option value='<?php echo attr($user['id']); ?>'
                    <?php echo $form_provider == $user['id'] ? " selected " : null; ?>
                ><?php echo text($user['fname']." ".$user['lname']); ?></option>
            <?php endforeach; ?>
        </select>
    </td>-->

    <table style="width: 73%" class="tablesorter">
    <thead> 
        <tr>
            <th class="filter-select" data-placeholder="Select Batch">Batch ID</th>
            <th class="style4" data-placeholder="Select a last name">PID</th>
            <th class='style4' style="width:10%;">L. Name</th>
            <th class='style4'>M. Name</th>
            <th class="filter-select" data-placeholder="Select a name" style="width:10%;">First Name</th>
            <th class="filter-select" data-placeholder="Select a City">Gender</th>
            <th class="filter-select" data-placeholder="Select a Carrier">System Insurance ID</th>
            <th class="filter-select" data-placeholder="Select a Carrier">Current Insurance</th>
            <th class="filter-select" data-placeholder="Select a Carrier">Response: HMO/MMA</th>
            <th class='style4'>Policy #</th>
            <th class='style4' style="width:15%;">Plan Description</th>
            <th class="filter-select" data-placeholder="Select Status">Response Status</th>
            <th class="filter-select" style="width:20%;" data-placeholder="Report Date">Report Date</th>
        </tr>
    </thead>
    <tbody>

    <?php
        if ($tracking_id =='All') {
            $extra_filter = '';				
        } else {
            $extra_filter = "WHERE e.batch_id = '".$tracking_id."'";
        };	
        //$extra_filter = "WHERE e.batch_id = '".$tracking_id."'";

        $query = "SELECT ".
                "e.id,".
                "i.provider,".
                "p.name, ".
                "e.batch_id,". 
                "e.pid,". 
                "e.fname,".
                "e.lname,". 
                "e.mname,". 
                "e.sex,". 
                "e.policy_number,". 
                "e.insurance_company,". 
                "e.plan_description,".
                "e.date, ".
                "e.active ".
                "FROM  eligible As e ".
                "LEFT JOIN insurance_data AS i ON (i.id =( ".
                                                    "SELECT id ".
                                                    "FROM insurance_data AS i ".
                                                    "WHERE pid = e.pid AND type = 'primary' ".
                                                    "ORDER BY date DESC ".
                                                    "LIMIT 1 ".
                                                    ") ".
                                                    ") ".
                "LEFT JOIN insurance_companies AS p ON (p.id =( ".
                                                    "SELECT id ".
                                                    "FROM insurance_companies AS p ".
                                                    "WHERE id = i.provider ".
                                                    
                                                    ") ".
                                                    ") $extra_filter"

                //"WHERE e.batch_id = $tracking_id"
        ;
        //echo $query;
        $result = $mysqli -> query($query);
        // Print out result
        while($row = mysqli_fetch_array($result)) {
            $recid = $row['id'];
            $batch_id = $row['batch_id'];
            $id = $row['pid'];
            $lname = $row['lname'];
            $mname = $row['mname'];
            $fname = $row['fname'];
            $sex = $row['sex'];
            $policy_number = $row['policy_number'];
            $insurance_provider = $row['provider'];
            $insurance_name = $row['name'];
            $insurance_company = $row['insurance_company'];
            $plan_description = $row['plan_description'];
            $active = $row['active'];
            $date = $row['date'];

            echo "<tr class='auto-style1 detailRow' id='" . $recid . "'>".
            "<td class='style1'> " .$batch_id. 
            "</td><td class='style1'> " .$id. 
            "</td><td class='style1'> " .$lname.
            "</td><td class='style1'> " .$mname.
            "</td><td class='style1'> " .$fname.
            "</td><td class='style1'> " .$sex.
            "</td><td class='style1'> " .$insurance_provider.
            "</td><td class='style1'> " .$insurance_name.
            "</td><td class='style1'> " .$insurance_company.
            "</td><td class='style1'> " .$policy_number.
            "</td><td class='style1'> " .$plan_description;
        if ($active =='1'){ 
            echo "</td><td class='style1'>active";
            echo "</td><td class='style1'> " .$date;			
                        }else{
            echo "</td><td class='style1'><b><span class='results'>inactive/inconclusive</span></b>";
            echo "</td><td class='style1'> " .$date;}
            echo "</div>";
        };

        echo "</td></tr></tbody></table>";

    ?>

    <input type="button" class="dontsave btn btn-primary btn-refresh " value="<?php xl('Return To Eligibility','e'); ?>"> 
