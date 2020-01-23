<?php
//------------Forms generated from formsWiz

$fake_register_globals=false;
$sanitize_all_escapes=true;

include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");

function createNewSA($tableName, $authorized = "0") {
    $sql = "insert into " . escape_table_name($tableName) . " 
            set pid = '".add_escape_custom($_SESSION['pid'])."',
                groupname='".add_escape_custom($_SESSION['authProvider'])."',
                user='".add_escape_custom($_SESSION['authUser'])."',
                authorized='".add_escape_custom($authorized)."',
                encounter=" . $_SESSION["encounter"] . ",
                activity=1, 
                date = NOW()";
    return sqlInsert($sql);
}

if ($encounter == "")
    $encounter = date("Ymd");

$encounterid = $_SESSION["encounter"];

if ($_GET["mode"] == "new") {
    // get FSAId formid
    $formid = createNewSA("form_service_authorization_id", $userauthorized);
    addForm($encounter, "Service Authorization", $formid, "service_authorization", $pid, $userauthorized);
} elseif ($_GET["mode"] == "update") {
    // get FSAId formid
    $formid = 0 + (isset($_GET['id']) ? $_GET['id'] : 0);
}

// cycle through form
$ids = $_POST["id"]; // all rows must have id = 0 for new, >0 for edit, <0 for delete
if (!empty($ids)) {
    foreach ($ids as $idx => $id) :
        $form = array();
        echo 'idx ' . idx;
        echo 'id ' . id;
        foreach ($_POST as $key => $val) :
            $form[$key] = $val[$idx];
            echo 'key ' . $key;
            echo 'val ' . $val[$idx];
        endforeach;

        // is there a posted id?
        if ($id == 0) {
            // add values
            $id = formSubmit("form_service_authorization", $form, $id, $userauthorized);
            // set value not in posted form
            sqlInsert("update form_service_authorization 
                        set type ='patient', form_id = $formid, encounter = $encounterid
                        where id=$id ");
        } else if ($id < 0) {
            $id = abs($id);
            // delete values
            sqlInsert("update form_service_authorization 
                        set IsDeleted = 1
                        where id=$id ");
        } else {
            // update values
            formUpdate("form_service_authorization", $form, $id, $userauthorized);
        }
    endforeach;
}

 formHeader("Redirecting....");
 formJump();
?>