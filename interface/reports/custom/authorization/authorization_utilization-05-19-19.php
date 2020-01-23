  <?php
  require_once("../../../globals.php");
  include_once("$srcdir/api.inc");
  require_once("$srcdir/patient.inc");
 set_time_limit(600);
?>
<head>


	<meta charset="utf-8">
	<title>Utilization</title>

	<!-- Demo styling -->
	<link href="../docs/css/jq.css" rel="stylesheet">

	<!-- jQuery: required (tablesorter works with jQuery 1.2.3+) -->
	<script src="../js/jquery.min.js"></script>

	<!-- Pick a theme, load the plugin & initialize plugin -->
	<link href="../css/theme.blue.css" rel="stylesheet">
	<script src="../js/jquery.tablesorter.min.js"></script>
	<script src="../js/jquery.tablesorter.widgets.min.js"></script>
	<script>
	
	
//	
//	
//	$(function(){
//		$('table').tablesorter({
//			widgets        : ['zebra', 'columns'],
//			usNumberFormat : false,
//			sortReset      : true,
//			sortRestart    : true
//		});
//	});
//
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
        4 : function(e, n, f, i) {
          return e === f;
        },
                 
             5 : {
          ""      : function(e, n, f, i) { return /^[YES]/.test(e); },
          "" : function(e, n, f, i) { return /^[NO]/.test(e); 
          }
                 }
    
                 
                 
      }

    }

  });

});
	
	
	
	
	
	
	
	
	</script>

	<style type="text/css">
	.auto-style1 {
		font-weight: normal;
	}
	</style>

</head>
<table style="width: 100%" class="tablesorter">
<thead> 
		<tr>
			<th class='auto-style1'>PID</th>       
			<th class="auto-style1" data-placeholder="Select a last name">Last Name</th> 
			<th class='auto-style1'>First Name</th>
			<th class='auto-style1'>Provider</th>
			<th class='auto-style1'>Service</th>
			<th class='auto-style1'>Insurance</th>
			<th class='auto-style1'>Authorization #</th>
			<th class='auto-style1'>Units/Visits</th>
			<th class='auto-style1'>Start</th>
			<th class='auto-style1'>End</th>
			<th class='style4'><B>Fiscal Year</B></th>
			<th class='auto-style1'>Days</th>
			<th class='style4' style="width: 95px"><B>Units Used</B></th>
			<th class='auto-style1'>Days</th> 
			<th class='style4'><B>Allowed</B></th> 
			<th class='auto-style1'>Remaining</th> 
		</tr>
</thead>
<tbody>

<?php
 //require_once("../globals.php");
 //require_once("$srcdir/patient.inc");
 //require_once("$srcdir/formatting.inc.php");
 //require_once("$srcdir/options.inc.php");
 
 // ADDED BY DNUNEZ 8-5-15 TO ALLOW LONGER PHP PROCESSING TIME BEFORE TIMEOUT
 set_time_limit(600);
$provider = "$_REQUEST[providerid]";
$fiscal_year = "$_REQUEST[fiscal_year]";
$service_code = "$_REQUEST[service_code]";
//$provider = "1";
//$fiscal_year = "2018";
switch ($service_code){
	case "H2019HR":
		$first_number1 = 104;
		break;
	case "H2019HO":
		$first_number1 = 1920;
		break;
	case "H2017":
		$first_number1 = 1920;
		break;
}
if ($provider == '')
	$provider = '*';
$db_name = "openemr";

//echo "<td class='style4'>PID</td>       <td class='style4'>Last Name</td> <td class='style4'>First Name</td><td class='style4'>Provider</td>  <td class='style4'><B>Last Encounter</B></td><td class='style4'> Days Since Last Encounter</td> <td class='style4'><B>Last Treatment Plan</B></td> <td class='style4'>Days Since Last TP</td> <td class='style4'><B>Last Treatment Plan Review</B></td> <td class='style4'>Days Since Last TP/R</td><td class='style4'><B>Last C/FARS</B></td><td class='style4'>Days Since Last C/FARS</td><td class='style4'><B>Last Psych Eval</B></td><td class='style4'> Days Since Last Psych Eval</td></tr>";
$connection = new mysqli($host, $login, $pass, $dbase); 

//$db = @mysql_select_db($db_name, $connection) or die(mysql_error());

//****************************    START FORM **************************************

$sql = "SELECT ". 
	"p.pid, p.lname AS plname, p.fname AS pfname, p.patient_active, p.providerID, p.group_providerID, ".
	"pr.lname, pr.fname, pr.id, ".
	"au.authorization_number, ".
	"ins.name AS insname, ".
	"au.pid, ".
	"au.service_code, ".
    "au.service_name, ". 
    "au.units, ". 
    "au.start_date, ". 
    "au.end_date ".
"FROM patient_data AS p ".
	"LEFT JOIN form_service_authorization AS au ON au.pid = p.pid ".
	"LEFT JOIN users AS pr ON pr.id = p.providerID ".
	"JOIN insurance_companies AS ins ON ins.id = au.insurance_provider ".

//"AS c ".
"WHERE ".
	"p.patient_active = 'YES' ".
	"AND (p.providerID = $provider OR p.group_providerID = $provider) ".
	//"AND au.service_code = '$service_code' ".
	"ORDER BY p.lname ASC "
//"c.pid = '1' ".
//"AND patient_active = 'YES'"
//."LIMIT 0, 20"
;
echo $sql;
$result = $connection -> query ($sql) ;

while ($row = mysqli_fetch_array($result)) 
{
 $pid = $row['pid'];
 $lname = $row['plname'];
 $fname = $row['pfname'];
 $prlname = $row['lname'];
 $prfname = $row['fname'];
 $insname = $row['insname'];
 $auunits = $row['units'];
 $first_number1 = $row['units'];
 $start_date = $row['start_date'];
 $end_date = $row['end_date'];
 $authorization_number = $row['authorization_number'];
 $service_code = $row['service_code'];

//echo 'llllllllllllllllllllllllll<br>'. $pid;
//echo $lname;
echo $authorization_number."<br>";
 

 
$query = "SELECT ".
		"ps.pid, ps.service_code, ps.units, ps.encounter, ps.date, ps.status ". 
		",fr.id, fr.form_id, fr.date, fr.encounter ".
		",en.encounter, en.date ".
		",SUM(ps.units) ". 
		"FROM form_progress_note as ps ".
		"JOIN forms AS fr ON fr.form_id = ps.id AND fr.pid = ps.pid ".
		"JOIN form_encounter AS en ON en.encounter = fr.encounter ".
		"WHERE ps.service_code = '$service_code' ".
		"AND ps.status NOT LIKE '%Void%' ".
		"AND en.date BETWEEN '$start_date' AND '$end_date' ". 
		"AND ps.pid = $pid ".
		"GROUP BY ps.service_code "
		

		; 
//echo "<br>". $query."<br>";	 
$result_1 = $connection -> query ($query) ;
//echo $query;
//echo $result_1;
// Print out result
//echo $query;
//echo "<br>";
while($row_1 = mysqli_fetch_array($result_1)){
											//$first_number1 = 1920; 
											$second_number1 = ($row_1['SUM(ps.units)']);
											$sum_total1 = $first_number1 - $second_number1;
	//echo "<tr><th>Unit(s) of service for PSR (H2017) used since the begining of this fiscal year (07-01-2012)</th> ". "<th>". $row['servicecode']. "</th><th>". " Units Billed:<b> ". "</th><th>". $row['SUM(ps.units)']. "</b></th><th>". $row['date']. "</th>";
	echo "<tr>";
	echo "<td>".$pid. "</td>";
	echo "<td>".$lname. "</td>";
	echo "<td>".$fname. "</td>";
	echo "<td>".$prlname.",".$prfname. "</td>";
	echo "<td>". $service_code. "</td>";
	echo "<td>". $insname. "</td>";
	echo "<td>". $authorization_number. "</td>";
	echo "<td>". $auunits. "</td>";
	echo "<td>". $start_date. "</td>";
	echo "<td>". $end_date. "</td>";
	echo "<td>07-01-". $fiscal_year ."</td>"; 
	echo "<td>". $row_1['service_code']. "</td>";
	echo "<td><b>". $row_1['SUM(ps.units)']. "</b></td>";
	echo "<td>". $row_1['date']. "</td>";
	echo "<td>".$first_number1."</td>";
	echo "<td>". ($sum_total1). "</td>";
	echo "</tr>";
}


}
?>
<script>
    document.write('<a href="' + document.referrer + '"><br>Go Back</a>');
</script>
