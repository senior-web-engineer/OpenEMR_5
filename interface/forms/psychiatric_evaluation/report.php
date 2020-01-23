<?php

include_once("../../globals.php");
include_once($GLOBALS["srcdir"]."/api.inc");
function psychiatric_evaluation_report( $pid, $encounter, $cols, $id) {
$count = 0;
print "Psychiatric Evaluation";
$data = formFetch("form_psychiatric_evaluation", $id);
if ($data) {
print "<table>
	<colgroup>
		<col width='50%'>
		<col width='50%'>
	</colgroup><tr>";
foreach($data as $key => $value) {
if ($key == "id" || $key == "pid" || $key == "user" || $key == "groupname" || $key == "authorized" || $key == "activity" || $key == "date" || $value == "" || $value == "0000-00-00 00:00:00") {
	continue;
}
if ($value == "on") {
$value = "yes";
}
$key=ucwords(str_replace("_"," ",$key));
print "<td><span class=bold>$key: </span><span class=text>$value</span></td>";
$count++;
if ($count == $cols) {
$count = 0;
print "</tr><tr>\n";
}
}
}
print "</tr></table>";
}
?> 
