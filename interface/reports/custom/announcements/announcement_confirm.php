<?php
require_once("../../../globals.php");
// require_once("$srcdir/acl.inc");
// if (!acl_check('admin', 'acl')) {
//     echo "(" . xlt('ACL Administration Not Authorized') . ")";
//     exit;
// }

    if (isset($_POST['type']) && $_POST['type'] == 'read') {
        $bindParams = [$_POST['announceId'], $_POST['userId']];
        $sql = 'INSERT INTO announcements_confirmation SET '.
                'announcement_id=?,
                user=?,
                created_date = NOW()';    
        sqlInsert($sql, $bindParams);
    }
?>