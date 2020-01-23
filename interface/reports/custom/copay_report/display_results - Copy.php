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

	<script>
$(function() {

  // call the tablesorter plugin
  $("table").tablesorter({
    theme: 'blue',

    // hidden filter input/selects will resize the columns, so try to minimize the change
    widthFixed : true,

    // initialize zebra striping and filter widgets
    widgets: ["zebra", "filter", "columns"],
    
    
    
    usNumberFormat : false,
			sortReset      : true,
			sortRestart    : true,


    // headers: { 5: { sorter: false, filter: false } },

    widgetOptions : {

      // css class applied to the table row containing the filters & the inputs within that row
      filter_cssFilter   : 'tablesorter-filter',

      // If there are child rows in the table (rows with class name from "cssChildRow" option)
      // and this option is true and a match is found anywhere in the child row, then it will make that row
      // visible; default is false
      filter_childRows   : false,

      // if true, filters are collapsed initially, but can be revealed by hovering over the grey bar immediately
      // below the header row. Additionally, tabbing through the document will open the filter row when an input gets focus
      filter_hideFilters : false,

      // Set this option to false to make the searches case sensitive
      filter_ignoreCase  : true,

      // jQuery selector string of an element used to reset the filters
      filter_reset : '.reset',

      // Delay in milliseconds before the filter widget starts searching; This option prevents searching for
      // every character while typing and should make searching large tables faster.
      filter_searchDelay : 300,

      // Set this option to true to use the filter to find text from the start of the column
      // So typing in "a" will find "albert" but not "frank", both have a's; default is false
      filter_startsWith  : false,

      // if false, filters are collapsed initially, but can be revealed by hovering over the grey bar immediately
      // below the header row. Additionally, tabbing through the document will open the filter row when an input gets focus
      filter_hideFilters : false,

      // Add select box to 4th column (zero-based index)
      // each option has an associated function that returns a boolean
      // function variables:
      // e = exact text from cell
      // n = normalized value returned by the column parser
      // f = search filter input value
      // i = column index
      filter_functions : {

        // Add select menu to this column
        // set the column value to true, and/or add "filter-select" class name to header
        // 0 : true,

        // Exact match only
        1 : function(e, n, f, i) {
          return e === f;
        },

        // Add these options to the select dropdown (regex example)
        2 : {
          "A - D" : function(e, n, f, i) { return /^[A-D]/.test(e); },
          "E - H" : function(e, n, f, i) { return /^[E-H]/.test(e); },
          "I - L" : function(e, n, f, i) { return /^[I-L]/.test(e); },
          "M - P" : function(e, n, f, i) { return /^[M-P]/.test(e); },
          "Q - T" : function(e, n, f, i) { return /^[Q-T]/.test(e); },
          "U - X" : function(e, n, f, i) { return /^[U-X]/.test(e); },
          "Y - Z" : function(e, n, f, i) { return /^[Y-Z]/.test(e); }
        },

        // Add these options to the select dropdown (numerical comparison example)
        // Note that only the normalized (n) value will contain numerical data
        // If you use the exact text, you'll need to parse it (parseFloat or parseInt)
        4 : {
          "Male"      : function(e, n, f, i) { return /^[Male]/.test(e); },
          "Female" : function(e, n, f, i) { return /^[Female]/.test(e); }
                 },
                 
             5 : {
          "YES"      : function(e, n, f, i) { return /^[YES]/.test(e); },
          "NO" : function(e, n, f, i) { return /^[NO]/.test(e); }
                 }
    
                 
                 
      }

    }

  });

});

	
</script>
<script type="text/javascript">
function ActionDeterminator() {
				     document.theform.action = 'display_results.php';
				  }


</script>
        <script type="text/javascript">

            var stringDelete = "<?php echo xla('Do you want to remove this record?'); ?>?";
            var stringBatch  = "<?php echo xla('Please select X12 partner, required to create the 270 batch'); ?>";

            // for form refresh

            function refreshme() {
                document.forms[0].submit();
            }

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

        <span class='title'><?php echo xlt('Report'); ?> - <?php echo xlt('Eligibility 270 Inquiry Batch'); ?></span>

        <div id="report_parameters_daterange">
            <?php echo text(oeFormatShortDate($form_from_date)) . " &nbsp; " . xlt('to') . "&nbsp; ". text(oeFormatShortDate($form_to_date)); ?>
        </div>

        <form method='post' name='theform' id='theform' action='edi_270.php' onsubmit="return top.restoreSession()">
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
                                            <?php echo xlt('Batch'); ?>:
                                        </td>
                                        <td>

									 <?php
										
										$user= $_SESSION["authUser"];
										
										//$tracking_id = '38';
										$tracking_id = $_POST["tracking_id"];
										$mysqli = mysqli_connect($host, $login, $pass, $dbase) or die(mysqli_connect_error());				//echo $host;
										
										
										$batch = "SELECT id,user,date FROM eligibility_request_tracking WHERE user = '$user';";
												//echo $query;
												// Execute it, or return the error message if there's a problem.
												$batch_result = $mysqli -> query($batch);
													$dropdown1 .= "<select id='tracking_id' name='tracking_id' required ><option selected=''></option>";
													
												while($row = mysqli_fetch_array($batch_result)) {
													$dropdown1 .= "\r\n<option value='{$row['id']}'>{$row['id']}". "  "."{$row['date']}". "  "."{$row['user']}</option>";
													
												}
													$dropdown1 .= "\r\n</select>";
													
													echo  "<dl class='dl-horizontal'><dt>Select Batch:</dt><dd>",$dropdown1, "<b></b></dd>" ;
										?>
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
                                    </tr>

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



										<td>
                                     	<!--       <select name='form_users' class='form-control' onchange='form.submit();'>
                                                <option value=''>-- <?php echo xlt('All'); ?> --</option>
                                                <?php foreach ($providers as $user) : ?>
                                                    <option value='<?php echo attr($user['id']); ?>'
                                                        <?php echo $form_provider == $user['id'] ? " selected " : null; ?>
                                                    ><?php echo text($user['fname']." ".$user['lname']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                         -->
                                        </td>
















<table style="width: 60%" class="tablesorter">
<thead> 
	<tr>
		<th class="filter-select" data-placeholder="Select Batch">Batch ID</th>
		<th class="filter-select" data-placeholder="Select a last name">PID</th>
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
		
	</tr>
</thead>
<tbody>



<?php


$query = "SELECT ".
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
											 ") ".

		 "WHERE e.batch_id = $tracking_id"
;
//echo $query;
$result = $mysqli -> query($query);
// Print out result
while($row = mysqli_fetch_array($result)) {
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
	echo "<tr <span class='auto-style1'>".
	"<td class='style1'> " .$batch_id. 
	"</td><td class='auto-style1'> " .$id. 
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
				}else{
	echo "</td><td class='style1'><b><span class='results'>inactive/inconclusive</span></b>";}
	echo "</div>";
};
echo "</td></tr></tbody></table>";

?>
<input type="button" class="dontsave btn btn-primary btn-refresh " value="<?php xl('Return To Eligibility','e'); ?>"> 

<script language="javascript">
$(document).ready(function(){
      $(".dontsave").click(function() { location.href='<?php echo "edi_270.php"; ?>'; });
});
</script>

