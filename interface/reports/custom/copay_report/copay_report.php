<?php
/**
 * main file for the 270 batch creation.
 * This report is the batch report required for batch eligibility verification.
 *
 * This program creates the batch for the x12 270 eligibility file
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 * @author    Terry Hill <terry@lilysystems.com>
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @copyright Copyright (c) 2010 MMF Systems, Inc
 * @copyright Copyright (c) 2016 Terry Hill <terry@lillysystems.com>
 * @copyright Copyright (c) 2017 Brady Miller <brady.g.miller@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */


require_once("../../../globals.php");
require_once("$srcdir/forms.inc");
require_once("$srcdir/billing.inc");
require_once("$srcdir/patient.inc");
require_once "$srcdir/options.inc.php";
require_once("$srcdir/calendar.inc");
require_once("$srcdir/edi.inc");

use OpenEMR\Core\Header;
$now = time(); // or your date as well
//		$your_date = strtotime("2018-01-01");
//		$datediff = $now - $your_date;

//		echo round($datediff / (60 * 60 * 24));



function show_elig_custom($res,$X12info,$segTer,$compEleSep){

	$i=0;
//	echo "	<div id='report_results'>
//			<table>
	echo "<div id='report_results'>".		
	     "<div class='table-responsive'>".
				"<table class='selection table' id='selection'>

				<thead>
					
					<th style='width:5%;'>	". htmlspecialchars( xl('Facility Name'), ENT_NOQUOTES) ."</th>
					
					<th style='width:15%;'>	". htmlspecialchars( xl('Insurance Comp'), ENT_NOQUOTES) ."</th>
					
					
					<th style='width:5%;' >	". htmlspecialchars( xl('Patient ID'), ENT_NOQUOTES) ."</th>
					
					

					

					<th style='width:8%;' >	". htmlspecialchars( xl('Policy No'), ENT_NOQUOTES) ."</th>
					<th style='width:8%;'>	". htmlspecialchars( xl('Patient Fname'), ENT_NOQUOTES) ."</th>
					<th style='width:8%;'>	". htmlspecialchars( xl('Patient Lname'), ENT_NOQUOTES) ."</th>


					<th style='width:10%;' >	". htmlspecialchars( xl('DOB'), ENT_NOQUOTES) ."</th>
					<th style='width:6%;' >	". htmlspecialchars( xl('Gender'), ENT_NOQUOTES) ."</th>
					<th style='width:5%;'>	". htmlspecialchars( xl('Copay'), ENT_NOQUOTES) ."</th>
					<th style='width:2%;' >	&nbsp;			  </th>
				</thead>

				<tbody>

		";
//echo "<input type='checkbox' id='checkAll'> <label for='checkAll'>Check All</label>";
	while ($row = sqlFetchArray($res)) {


		$i= $i+1;

		if($i%2 == 0){
			$background = '#FFF';
		}else{
			$background = '#FFF';
		}
			
		$elig	  = array();
		$elig[0]  = $row['facility_name'];				// Inquiring Provider Name  calendadr
		$elig[1]  = $row['facility_npi'];				// Inquiring Provider NPI
		$elig[2]  = $row['payer_name'];					// Payer Name  our insurance co name
		$elig[3]  = $row['policy_number'];				// Subscriber ID
		$elig[4]  = $row['subscriber_lname'];				// Subscriber Last Name
		$elig[5]  = $row['subscriber_fname'];				// Subscriber First Name
		$elig[6]  = $row['subscriber_mname'];				// Subscriber Middle Initial
		$elig[7]  = $row['subscriber_dob'];				// Subscriber Date of Birth
		$elig[8]  = substr($row['subscriber_sex'], 0, 1);		// Subscriber Sex
		$elig[9]  = $row['subscriber_ss'];				// Subscriber SSN
		$elig[10] = translate_relationship($row['subscriber_relationship']);    // Pt Relationship to insured
		$elig[11] = $row['lname'];					// Dependent Last Name
		$elig[12] = $row['fname'];					// Dependent First Name
		$elig[13] = $row['mname'];					// Dependent Middle Initial
		$elig[14] = $row['dob'];					// Dependent Date of Birth
		$elig[15] = substr($row['sex'], 0, 1);				// Dependent Sex
		$elig[16] = $row['pc_eventDate'];				// Date of service
		$elig[17] = "30";						// Service Type
		$elig[18] = $row['pubpid'];					// Patient Account Number pubpid
		$elig[19] = $row['trading_partner_id'];
		$elig[20] = $row['date_last_checked'];
		$elig[21] = $row['active'];
		$elig[22] = $row['copay'];
		$last_date = $elig[20];
		//echo "lastdate1".$elig[20];
		//echo "lastdate2". $last_date;
		//$datediff = $now - $last_date;
		//echo "<br>".round($datediff / (60 * 60 * 24));
		//$datediff2 = round($datediff / (60 * 60 * 24));
		$now = time(); // or your date as well
		$your_date = strtotime($row['date_last_checked']);
		$datediff = $now - $your_date;
		$datediff = round($datediff / (60 * 60 * 24));
		$patientbalance = get_patient_balance($row['pid'], $with_insurance = true);
		
		
		echo "	<tr id='PR".$i."_". htmlspecialchars( $row['policy_number'], ENT_QUOTES)."'>";
		echo "	<td class ='detail' style='width:5%;'>". htmlspecialchars( $row['facility_name'], ENT_NOQUOTES) ." </td>";
				//<td class ='detail' style='width:8%;'><input class='form-control input-sm' type='text' name='facility_npi[]' value=". htmlspecialchars( $row['facility_npi'], ENT_NOQUOTES) ." </td>
		echo " 	<td class ='detail' style='width:15%;'>". htmlspecialchars( $row['payer_name'], ENT_NOQUOTES) ."</td>";
	  //echo "  <td class ='detail' style='width:5%;'>". $patientbalance ."</td>";
	    
	//	echo "	<td class ='detail' style='width:8%;'><input class='form-control input-sm' type='text' name='api_code[]' value='".  htmlspecialchars( $row['trading_partner_id'], ENT_NOQUOTES) ."' </td>
		echo "	<td class ='detail' style='width:5%;'>".  htmlspecialchars( $row['pid'], ENT_NOQUOTES) ." </td>";
	//			<td class ='detail' style='width:5%;'>".  htmlspecialchars( $row['date_last_checked'], ENT_NOQUOTES) ." </td>
	//			<td class ='detail' style='width:5%;'>". htmlspecialchars( $datediff, ENT_NOQUOTES) ."</td>";
	//			if ($row['active'] !='1'){
	//			echo "<td class ='detail' style='width:5%;'><p class='auto-style1'><b>Inactive/Inconclusive</b></p></td>";
	//									}else{
	//			echo "<td class ='detail' style='width:5%;'>Active</td>";
	//									}
		echo "	<td class ='detail' style='width:8%;'>".  htmlspecialchars( $row['policy_number'], ENT_NOQUOTES) ." </td>";
		echo "	<td class ='detail' style='width:8%;'>". htmlspecialchars( $row['subscriber_fname'], ENT_NOQUOTES) ." </td>";
		//echo "	<td class ='detail' style='width:8%;'>". htmlspecialchars( $row['subscriber_mname'])."'</td>" ;
		echo "	<td class ='detail' style='width:8%;'>". htmlspecialchars( $row['subscriber_lname'], ENT_NOQUOTES) ." </td>
				<td class ='detail' style='width:7%;'>". htmlspecialchars( $row['subscriber_dob'], ENT_NOQUOTES) ." </td>
				<td class ='detail' style='width:6%;'>".  htmlspecialchars( $row['subscriber_sex'], ENT_NOQUOTES) ."</td>";
		echo "  <td class ='detail' style='width:5%;'>". htmlspecialchars( $row['copay'], ENT_NOQUOTES) ."</td>
				<td class ='detail' style='width:2%;'></td>
			</tr>
		";

		unset($elig);
	}

	if($i==0){

		echo "	<tr>
				<td class='norecord' colspan=16>
					<div style='padding:5px;font-family:arial;font-size:13px;text-align:center;'>". htmlspecialchars( xl('No records found'), ENT_NOQUOTES) . "</div>
				</td>
			</tr>	";
	}
		echo "	</tbody>
			</table>";
}


// Element data seperator
$eleDataSep     = "*";

// Segment Terminator
$segTer         = "~";

// Component Element seperator
$compEleSep     = ":";

// filter conditions for the report and batch creation

$from_date      = (isset($_POST['form_from_date'])) ? DateToYYYYMMDD($_POST['form_from_date']) : date('Y-m-d');
$to_date        = (isset($_POST['form_to_date'])) ? DateToYYYYMMDD($_POST['form_to_date']) : date('Y-m-d');
$form_facility  = $_POST['form_facility'] ? $_POST['form_facility'] : '';
$form_provider  = $_POST['form_users'] ? $_POST['form_users'] : '';
$exclude_policy = $_POST['removedrows'] ? $_POST['removedrows'] : '';
$X12info        = $_POST['form_x12'] ? explode("|", $_POST['form_x12']) : '';

//Set up the sql variable binding array (this prevents sql-injection attacks)
$sqlBindArray = array();

$where  = "e.pc_pid IS NOT NULL AND e.pc_eventDate >= ?";
array_push($sqlBindArray, $from_date);

//$where .="and e.pc_eventDate = (select max(pc_eventDate) from openemr_postcalendar_events where pc_aid = d.id)";

if ($to_date) {
    $where .= " AND e.pc_eventDate <= ?";
    array_push($sqlBindArray, $to_date);
}

if ($form_facility != "") {
    $where .= " AND f.id = ? ";
    array_push($sqlBindArray, $form_facility);
}

if ($form_provider != "") {
    $where .= " AND d.id = ? ";
    array_push($sqlBindArray, $form_provider);
}

if ($exclude_policy != "") {
    $arrayExplode   =   explode(",", $exclude_policy);
                        array_walk($arrayExplode, 'arrFormated');
                        $exclude_policy = implode(",", $arrayExplode);
                        $where .= " AND i.policy_number not in (".add_escape_custom($exclude_policy).")";
}

    $where .= " AND (i.policy_number is not null and i.policy_number != '') ";

    $query = sprintf("		SELECT DISTINCT DATE_FORMAT(e.pc_eventDate, '%%Y%%m%%d') as pc_eventDate,
								   e.pc_facility,
								   p.lname,
								   p.fname,
								   p.mname,
								   DATE_FORMAT(p.dob, '%%Y%%m%%d') as dob,
								   p.ss,
								   p.sex,
								   p.pid,
								   p.pubpid,
								   i.policy_number,
								   i.provider as payer_id,
								   i.subscriber_relationship,
								   i.subscriber_lname,
								   i.subscriber_fname,
								   i.subscriber_mname,
								   i.copay,
								   DATE_FORMAT(l.date, '%%Y-%%m-%%d') as date_last_checked,
								   l.active,
								   DATE_FORMAT(i.subscriber_dob, '%%Y-%%m-%%d') as subscriber_dob,
								   i.subscriber_ss,
								   i.subscriber_sex,
								   DATE_FORMAT(i.date,'%%Y%%m%%d') as date,
								   d.lname as provider_lname,
								   d.fname as provider_fname,
								   d.npi as provider_npi,
								   d.upin as provider_pin,
								   f.federal_ein as federal_ein,
								   f.facility_npi as facility_npi,
								   f.name as facility_name,
								   c.name as payer_name,
								   c.api_code as trading_partner_id
							FROM openemr_postcalendar_events AS e
							LEFT JOIN users AS d on (e.pc_aid is not null and e.pc_aid = d.id)
							LEFT JOIN facility AS f on (f.id = e.pc_facility)
							LEFT JOIN patient_data AS p ON p.pid = e.pc_pid
							LEFT JOIN insurance_data AS i ON (i.id =(
																	SELECT id
																	FROM insurance_data AS i
																	WHERE pid = p.pid AND type = 'primary'
																	ORDER BY date DESC
																	LIMIT 1
																	)
																)
							LEFT JOIN eligible AS l ON (l.id=(
																SELECT id 
																FROM eligible AS l
																WHERE pid = p.pid
																ORDER BY date DESC
        														LIMIT 1
        														)
        													)
							LEFT JOIN insurance_companies as c ON (c.id = i.provider)
							WHERE %s ", $where);
	//echo $query;
    // Run the query
    $res            = sqlStatement($query, $sqlBindArray);

    // Get the facilities information
    $facilities     = getUserFacilities($_SESSION['authId']);

    // Get the Providers information
    $providers      = getUsernames();

    //Get the x12 partners information
    $clearinghouses = getX12Partner();
	
	

    if (isset($_POST['form_savefile']) && !empty($_POST['form_savefile']) && $res) {
        header('Content-Type: text/plain');
        header(sprintf(
            'Content-Disposition: attachment; filename="elig-270..%s.%s.txt"',
            $from_date,
            $to_date
        ));
        print_elig($res, $X12info, $segTer, $compEleSep);
        exit;
    }
?>

<html>

    <head>

        <title><?php echo xlt('Copay Report'); ?></title>

        <?php Header::setupHeader('datetime-picker'); ?>

        <style type="text/css">

            /* specifically include & exclude from printing */
            @media print {
                #report_parameters {
                    visibility: hidden;
                    display: none;
                }
                #report_parameters_daterange {
                    visibility: visible;
                    display: inline;
                }
                #report_results table {
                   margin-top: 0px;
                }
            }

            /* specifically exclude some from the screen */
            @media screen {
                #report_parameters_daterange {
                    visibility: hidden;
                    display: none;
                }
            }

        .auto-style1 {
			color: #FF0000;
		}

        </style>

        <script type="text/javascript">

            var stringDelete = "<?php echo xla('Do you want to remove this record?'); ?>?";
            var stringBatch  = "<?php echo xla('Please select X12 partner, required to create the 270 batch'); ?>";

            // for form refresh

            function refreshme() {
                document.forms[0].submit();
            }
            //cutom pokitdock
            function ActionDeterminator() {
				      $('#progresswheel').show();
				       document.theform.action = 'batch_check.php';
					   //document.theform.action = 'batch_check_mock.php';
				  }
			function ActionDeterminator2() {
				     document.theform.action = 'copay_report.php';
				  }

//<form method='post' name='theform' id='theform' action='batch_check_mock.php' onsubmit="return top.restoreSession()">


            //  To delete the row from the reports section
            function deletetherow(id){
                var suredelete = confirm(stringDelete);
                if(suredelete == true){
                    document.getElementById('PR'+id).style.display="none";
                    if(document.getElementById('removedrows').value == ""){
                        document.getElementById('removedrows').value = "'" + id + "'";
                    }else{
                        document.getElementById('removedrows').value = document.getElementById('removedrows').value + ",'" + id + "'";

                    }
                }

            }

            //  To validate the batch file generation - for the required field [clearing house/x12 partner]
            function validate_batch()
            {
                if(document.getElementById('form_x12').value=='')
                {
                    alert(stringBatch);
                    return false;
                }
                else
                {
                    document.getElementById('form_savefile').value = "true";
                    document.theform.submit();

                }


            }
             //  To validate the batch file generation - for the required field [clearing house/x12 partner]
            function validate_batch_custom()
            {
                if(document.getElementById('form_x12').value=='')
                {
                    alert(stringBatch);
                    return false;
                }
                else
                {
                    document.getElementById('form_savefile').value = "true";
                    document.theform.submit();

                }


            }


            // To Clear the hidden input field

            function validate_policy()
            {
                document.getElementById('removedrows').value = "";
                document.getElementById('form_savefile').value = "";
                return true;
            }

            // To toggle the clearing house empty validation message
            function toggleMessage(id,x12){

                var spanstyle = new String();

                spanstyle       = document.getElementById(id).style.visibility;
                selectoption    = document.getElementById(x12).value;

                if(selectoption != '')
                {
                    document.getElementById(id).style.visibility = "hidden";
                }
                else
                {
                    document.getElementById(id).style.visibility = "visible";
                    document.getElementById(id).style.display = "inline";
                }
                return true;

            }

            $(document).ready(function() {
                $('.datepicker').datetimepicker({
                    <?php $datetimepicker_timepicker = false; ?>
                    <?php $datetimepicker_showseconds = false; ?>
                    <?php $datetimepicker_formatInput = true; ?>
                    <?php require($GLOBALS['srcdir'] . '/js/xl/jquery-datetimepicker-2-5-4.js.php'); ?>
                    <?php // can add any additional javascript settings to datetimepicker here; need to prepend first setting with a comma ?>
                });
            });

        </script>

    </head>
    <body class="body_top">

        <!-- Required for the popup date selectors -->
        <div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>

        <span class='title'><?php echo xlt('Report'); ?> - <?php echo xlt('Clients Copay'); ?></span>

        <div id="report_parameters_daterange">
            <?php echo text(oeFormatShortDate($form_from_date)) . " &nbsp; " . xlt('to') . "&nbsp; ". text(oeFormatShortDate($form_to_date)); ?>
        </div>
		<!--
        <form method='post' name='theform' id='theform' action='batch_check_mock.php' onsubmit="return top.restoreSession()">
        -->
        
        <form method='post' name='theform' id='theform' action='edi_270_balance.php' onsubmit="return top.restoreSession()">

            <input type="hidden" name="removedrows" id="removedrows" value="">
            <div id="report_parameters">
                <table>
                    <tr>
                        <td width='550px'>
                            <div style='float:left'>
                                <table class='text'>
                                    <tr>
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

                                    <tr>
                                        <td class='control-label'>
                                            <?php echo xlt('Facility'); ?>:
                                        </td>
                                        <td>
                                            <?php dropdown_facility($form_facility, 'form_facility', false);  ?>
                                        </td>
                                        <td class='control-label'>
                                            <?php echo xlt('Provider'); ?>:
                                        </td>
                                        <td>
                                            <select name='form_users' class='form-control' onchange='form.submit();'>
                                                <option value=''>-- <?php echo xlt('All'); ?> --</option>
                                                <?php foreach ($providers as $user) : ?>
                                                    <option value='<?php echo attr($user['id']); ?>'
                                                        <?php echo $form_provider == $user['id'] ? " selected " : null; ?>
                                                    ><?php echo text($user['fname']." ".$user['lname']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>&nbsp;
                                        </td>
                                    </tr><!--document.myform.action = 'kraken_psr_.php';-->

<!--
                                    <tr>
                                        <td class='control-label'>
                                            <?php echo xlt('X12 Partner'); ?>:
                                        </td>
                                        <td colspan='5'>
                                            <select name='form_x12' id='form_x12' class='form-control' onchange='return toggleMessage("emptyVald","form_x12");' >
                                                        <option value=''>--<?php echo xlt('select'); ?>--</option>
                                                        <?php
                                                        if (isset($clearinghouses) && !empty($clearinghouses)) {
                                                            foreach ($clearinghouses as $clearinghouse) { ?>
                                                                    <option value='<?php echo attr($clearinghouse['id']."|".$clearinghouse['id_number']."|".$clearinghouse['x12_sender_id']."|".$clearinghouse['x12_receiver_id']."|".$clearinghouse['x12_version']."|".$clearinghouse['processing_format']); ?>'
                                                                        <?php echo $clearinghouse['id'] == $X12info[0] ? " selected " : null; ?>
                                                                    ><?php echo text($clearinghouse['name']); ?></option>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                </select>
                                                <span id='emptyVald' style='color:red;font-size:12px;'> * <?php echo xlt('Clearing house info required for EDI 270 batch creation.'); ?></span>
                                        </td>
                                    </tr>-->
                                </table>
                            </div>
                        </td>
                        <td align='left' valign='middle' height="100%">
                            <table style='border-left:1px solid; width:100%; height:100%' >
                                  <tr>
                                    <td>
                                        <div class="text-center">
                                            <div class="btn-group" role="group">
                                               <!-- <a href='#' class='btn btn-default btn-refresh' onclick='validate_policy(); $("#theform").submit();'>form.submit();-->
                                               <input type='submit' value='Refresh' class='btn btn-primary btn-refresh' onclick='return ActionDeterminator2();'>
												     
                                                <!--
                                                <a href='#' class='btn btn-default btn-transmit' onclick='return validate_batch();'>
                                                    <?php echo xlt('Create batch'); ?>
                                                <a href='#' class='btn btn-default btn-transmit' onclick='return validate_batch_custom();'>
                                                    <?php echo xlt('Run Verification'); ?>
                                                <input type='hidden' name='form_savefile' id='form_savefile' value=''></input>-->
    
												<!--<input type="submit" class="btn btn-primary" type="submit" />-->
                                            <!--    <input type="submit" value="Run Eligibility" class="btn btn-primary" onClick="return ActionDeterminator();">-->
   												<div id="progresswheel">
													<img height="32" src="ajax-loader.gif" width="32">
												</div>
												<script language="JavaScript">
												$('#progresswheel').hide();
												</script>
                                                
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

        

        <?php
        if ($res) {
            //show_elig_custom($res, $X12info, $segTer, $compEleSep);
            show_elig_custom($res, $X12info, $segTer, $compEleSep);

        }
        ?>
     </form>
    	
    </body>

    <script language='JavaScript'>
        <?php
        if ($alertmsg) {
            echo " alert('$alertmsg');\n";
        } ?>
       
$("#checkAll").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
     var $inpts = $(this).closest('tr').find('input:text').prop('disabled', !this.checked);
	$('.selection').on('change', ':checkbox', function () {
       var $inpts = $(this).closest('tr').find('input:text').prop('disabled', !this.checked);
     }).find(':checkbox').change();
 });
 
   $('.selection').on('change', ':checkbox', function () {
       var $inpts = $(this).closest('tr').find('input:text').prop('disabled', !this.checked);
   
   }).find(':checkbox').change();

</script>
  

</html>
