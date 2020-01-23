<?php
include_once("../../../../globals.php");
require_once("$srcdir/patient.inc");
require_once("$srcdir/formatting.inc.php");
require_once("$srcdir/options.inc.php");
require_once("$srcdir/forms.inc");
require_once("$srcdir/billing.inc");
require_once("$srcdir/calendar.inc");
require_once("$srcdir/edi.inc");

$id = 0;
$fn = $_REQUEST['fn'] ? $_REQUEST['fn'] : '';
$generator = null;

switch ($fn) {
    case "resultjson":
        // get table info
        $recid = $_REQUEST['recid'] ? $_REQUEST['recid'] : 0;

        // set query
        $sql = " SELECT results_json ";
        $sql .= " FROM openemr.eligible ";
        $sql .= " where id  = ? ";
        // run query
        $generator = sqlStatement($sql, $recid);
        break;
}

$i = 0;
$array = array();
while($row = sqlFetchArray($generator) ) {
    array_push($array, $row);
    $i++;
}

$data = [ 
    'generator' => $array
];

echo json_encode($data);
?>
