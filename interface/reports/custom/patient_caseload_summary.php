<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Caseload Summary</title>

	<!-- Demo styling -->
	<link href="docs/css/jq.css" rel="stylesheet">

	<!-- jQuery: required (tablesorter works with jQuery 1.2.3+) -->
	<script src="js/jquery.min.js"></script>

	<!-- Pick a theme, load the plugin & initialize plugin -->
	<link href="css/theme.blue.css" rel="stylesheet">
	<script src="js/jquery.tablesorter.min.js"></script>
	<script src="js/jquery.tablesorter.widgets.min.js"></script>
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
<!--<body>
<div class="demo">
	<h1><a href="https://github.com/Mottie/tablesorter">table<em>sorter</em></a></h1>
	<p>By Christian Bach; github updates by <a href="https://github.com/Mottie/">Rob G</a><br>
		<a href="docs/index.html">Complete docs included</a> (updated with missing docs from <a href="http://wowmotty.blogspot.com/2011/06/jquery-tablesorter-missing-docs.html">this blog post</a>)
	</p>

	<table class="tablesorter">
		<thead>
			<tr>
				<th>AlphaNumeric Sort</th>
				<th>Currency</th>
				<th>Alphabetical</th>
				<th>Sites</th>
			</tr>
		</thead>
		<tbody>
			<tr><td>abc 123</td><td>&#163;10,40</td><td>Koala</td><td>http://www.google.com</td></tr>
			<tr><td>abc 1</td><td>&#163;234,10</td><td>Ox</td><td>http://www.yahoo.com</td></tr>
			<tr><td>abc 9</td><td>&#163;10,33</td><td>Girafee</td><td>http://www.facebook.com</td></tr>
			<tr><td>zyx 24</td><td>&#163;10</td><td>Bison</td><td>http://www.whitehouse.gov/</td></tr>
			<tr><td>abc 11</td><td>&#163;3,20</td><td>Chimp</td><td>http://www.ucla.edu/</td></tr>
			<tr><td>abc 2</td><td>&#163;56,10</td><td>Elephant</td><td>http://www.wikipedia.org/</td></tr>
			<tr><td>abc 9</td><td>&#163;3,20</td><td>Lion</td><td>http://www.nytimes.com/</td></tr>
			<tr><td>ABC 10</td><td>&#163;87,00</td><td>Zebra</td><td>http://www.google.com</td></tr>
			<tr><td>zyx 1</td><td>&#163;99,90</td><td>Koala</td><td>http://www.mit.edu/</td></tr>
			<tr><td>zyx 12</td><td>&#163;234,10</td><td>Llama</td><td>http://www.nasa.gov/</td></tr><br>
		</tbody>
	</table>

	<p>This is a quick demo of the columns & zebra widget with the "sortReset" option set to true (clicking on a sort header a third time will reset the sort)</p>

</div>
</body></html>
-->
<table style="width: 40%" class="tablesorter">
<thead> 
	<tr>
		<th class="filter-select">Last Name</th> 
		<th class="filter-select" style="width: 196px">First Name</th> 
		<th class="filter-select">Active</th>
		<th class="filter-select">Count</th>
	</tr>
</thead>
	<tbody>

<?php
 
 // Copyright (C) 2006-2012 Rod Roark <rod@sunsetsystems.com>
 //
 // This program is free software; you can redistribute it and/or
 // modify it under the terms of the GNU General Public License
 // as published by the Free Software Foundation; either version 2
 // of the License, or (at your option) any later version.

 // This report lists patients that were seen within a given date
 // range, or all patients if no date range is entered.

 require_once("../../globals.php");
 require_once("$srcdir/patient.inc");
 require_once("$srcdir/formatting.inc.php");
 require_once("$srcdir/options.inc.php");
 
$con = new mysqli($host, $login, $pass, $dbase);
$query = "SELECT ".
 " p.id, p.fname, p.lname, p.active, pd.providerID, COUNT(pd.pid), pd.patient_active ".
 "FROM  `users` AS p ".
 "JOIN patient_data AS pd ".
 "WHERE p.id = pd.providerID ".
 "AND patient_active = 'YES' ".
 "GROUP BY p.id";
 $result = $con -> query ($query);

 
 //$result = mysql_query($query) or die(mysql_error());
 
 // Print out result
while($row = mysqli_fetch_array($result))
{
$id = $row['id'];
$lname = $row['lname'];
$fname = $row['fname'];
$active = $row['active'];
$count = $row['COUNT(pd.pid)'];






	echo "<tr><td class='style1'> " .$lname."</td><td class='style1'> " . $fname."</td><td class='style1'> "  . $active."</td><td class='style1'> " . $count;
	
};
echo "</td></tr></tbody></table>";

?>


