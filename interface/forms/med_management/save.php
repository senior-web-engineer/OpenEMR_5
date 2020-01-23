<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");

if ($encounter == "") {
    $encounter = date("Ymd");
}

if ($_GET["mode"] == "new") {
    $newid = formSubmit("form_med_management", $_POST, $_GET["id"], $userauthorized);
    print 'formSubmitt';  /*debugging */
    addForm($encounter, "Medication Management", $newid, "med_management", $pid, $userauthorized);
} 
elseif ($_GET["mode"] == "update") {

    $id = 0 + (isset($_GET['id']) ? $_GET['id'] : '');

    $exceptionFields = array();
    formSubmit("form_med_management", $_POST, $id, $userauthorized, 'update', $exceptionFields);

}
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();
?>












