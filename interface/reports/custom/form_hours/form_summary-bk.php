<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Progress notes Summary Report</title>

	<!-- Demo styling -->
	<link href="../docs/css/jq.css" rel="stylesheet">

	<!-- jQuery: required (tablesorter works with jQuery 1.2.3+) -->
	<script src="../js/jquery.min.js"></script>

	<!-- Pick a theme, load the plugin & initialize plugin -->
	<link href="../css/theme.blue.css" rel="stylesheet">
	<script src="../js/jquery.tablesorter.min.js"></script>
	<script src="../js/jquery.tablesorter.widgets.min.js"></script>
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

</head>

<table style="width: 40%" class="tablesorter">
<thead> 
	<tr>
		<th class="filter-select">Last Name</th> 
		<th class="filter-select" style="width: 196px">First Name</th> 
		<th class="filter-select">Active Provider</th>
		
		<th class="filter-select">Completed</th>
		<th class="filter-select">In Progress</th>
		<th class="filter-select">Total</th>
	</tr>
</thead>
	<tbody>

<?php
 
 require_once("../../../globals.php");
 require_once("$srcdir/patient.inc");
 require_once("$srcdir/formatting.inc.php");
 require_once("$srcdir/options.inc.php");
 
$start_date = "$_REQUEST[start_date]";
$end_date = "$_REQUEST[end_date]";
$user_name = "$_REQUEST[form_doctor]";
$form_selected = "$_REQUEST[form_selected]";


if ($user_name) {
			$provider_select = "WHERE p.username = '$user_name' ";					
          				} else {
			$provider_select = "WHERE p.calendar = '1' AND p.active = '1'";
				  }
 switch ($form_selected) {
    case "form_progress_note":
         $form_name = "Progress Note ";
    break;
    case "form_treatment_plan":
         $form_name = "Treatment Plan";
    break;
 }
 echo "This <b>".$form_name."</b> report is from <b>". $start_date. "</b> to <b>". $end_date."</b>" ;
$con = new mysqli($host, $login, $pass, $dbase);
//$query = "SELECT ".
// " p.id, p.username, p.fname, p.lname, p.active, pd.providerID, COUNT(pd.pid), pd.patient_active ".
// "FROM  `users` AS p ".
// "JOIN patient_data AS pd ".
// "WHERE p.id = pd.providerID ".
// "AND patient_active = 'YES' ".
// "$provider_select.
// "GROUP BY p.id";
// $result = $con -> query ($query);
 $query = "SELECT ".
 " p.id, p.username, p.fname, p.lname, p.active ".
 "FROM  `users` AS p ".
 //"JOIN patient_data AS pd ".
 //"WHERE p.id = pd.providerID ".
 //"AND patient_active = 'YES' ".
 $provider_select.
 "GROUP BY p.id";
 $result = $con -> query ($query);

 
 //$result = mysql_query($query) or die(mysql_error());
 
 // Print out result
while($row = mysqli_fetch_array($result))
{
$id = $row['id'];
$username = $row['username'];
$lname = $row['lname'];
$fname = $row['fname'];
$active = $row['active'];
$count = $row['COUNT(pd.pid)'];

	$query_2 = "SELECT f.pid, f.user, f.form_name, f.encounter, f.form_id, COUNT(f.form_id), e.date, e.encounter, e.facility, fm.id, fm.status ".
				"FROM forms AS f ".
				 
				//"JOIN form_encounter AS e ON e.id = f.form_id ".
				//"AND e.encounter = f.encounter ".
				"JOIN form_encounter AS e ".
				"ON e.encounter = f.encounter ".
				"JOIN $form_selected AS fm ".
				"ON fm.id = f.form_id ".
				//"WHERE f.pid = '1' ".
				//"AND e.date = '2018-10-06'";
				"WHERE f.form_name LIKE '$form_name%' ".
				"AND fm.status LIKE 'Ready%' ".
				"AND f.user =  '$username' ".
				"AND (e.date BETWEEN '$start_date' AND '$end_date')";
				
	$result_2 = $con -> query ($query_2);
	//echo $query_2;
	while($row_2 = mysqli_fetch_array($result_2))
					{
					$count_2 = $row_2['COUNT(f.form_id)'];	
					};
	$query_3 = "SELECT f.pid, f.user, f.form_name, f.encounter, f.form_id, COUNT(f.form_id), e.date, e.encounter, e.facility, fm.id, fm.status ".
				"FROM forms AS f ".
				 
				//"JOIN form_encounter AS e ON e.id = f.form_id ".
				//"AND e.encounter = f.encounter ".
				"JOIN form_encounter AS e ".
				"ON e.encounter = f.encounter ".
				"JOIN $form_selected AS fm ".
				"ON fm.id = f.form_id ".
				//"WHERE f.pid = '1' ".
				//"AND e.date = '2018-10-06'";
				"WHERE f.form_name LIKE '$form_name%' ".
				"AND fm.status LIKE 'In Progress' ".
				"AND f.user =  '$username' ".
				"AND (e.date BETWEEN '$start_date' AND '$end_date')";
				
	$result_3 = $con -> query ($query_3);
	//echo $query_3;
	while($row_3 = mysqli_fetch_array($result_3))
					{
					$count_3 = $row_3['COUNT(f.form_id)'];	
					};
					
	//echo $query_4;
	$query_4 = "SELECT f.pid, f.user, f.form_name, f.encounter, f.form_id, e.date, e.encounter, e.facility, ".
				"fm.id, fm.status, fm.time_start, fm.time_end ".
				"FROM forms AS f ".
				 
				//"JOIN form_encounter AS e ON e.id = f.form_id ".
				//"AND e.encounter = f.encounter ".
				"JOIN form_encounter AS e ".
				"ON e.encounter = f.encounter ".
				"JOIN $form_selected AS fm ".
				"ON fm.id = f.form_id ".
				//"WHERE f.pid = '1' ".
				//"AND e.date = '2018-10-06'";
				"WHERE f.form_name LIKE '$form_name%' ".
				"AND (fm.status LIKE 'In Progress' OR fm.status LIKE 'Ready%') ".
				"AND f.user =  '$username' ".
				"AND (e.date BETWEEN '$start_date' AND '$end_date')";
				
	$result_4 = $con -> query ($query_4);
	$data = array();
	//echo $query_4;
	while($row_4 = mysqli_fetch_array($result_4))
					{
					$count_4 = $row_4['COUNT(f.form_id)'];
					$data[] = $row_4;
					//echo 'hih';
					//echo 'lll'.$row_4[time_start].'<br>';
					echo $row_4[time_start].' ';
					//$time_in_24_hour_format = 
					echo date("H:i", strtotime("$row_4[time_end]")).
					'<br>';
					//$time1 = date("H:i", strtotime("$row_4[time_start]"));
					//$time2 = date("H:i", strtotime("$row_4[time_end]"));
					$time1 = strtotime("$row_4[time_start]");
					$time2 = strtotime("$row_4[time_end]");
					$difference = abs($time2-$time1) / 3600;
					//echo 'hello'.$time1, $time2.'-'.$difference.'<br>';
					echo '-----'.$difference.'<br>';
					//$time_in_24_hour_format = date("H:i", strtotime($row_4[time_end]));
					//echo $time_in_24_hour_format.
					};
	echo 'mmm'.$row_4[time_start];				

	echo "<tr><td class='style1'> " .
		$lname."</td><td class='style1'> ". 
		$fname."</td><td class='style1'> ". 
		$active."</td><td class='style1'> ".
		$count_2."</td><td class='style1'> ".
		$count_3."</td><td class='style1'> ".
		$count_4
		;
	
};
echo "</td></tr></tbody></table>";
echo 'kkk'. $row_4[time_start];
print_r($data);
?>


