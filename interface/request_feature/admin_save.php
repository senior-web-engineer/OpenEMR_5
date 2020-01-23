<?php
/**
 * @author			Yves
 * @description 	Save request feature
 * @created By 		Khoa N
 */
require_once("../globals.php");
if (!acl_check('admin', 'acl')) {
    echo "(" . xlt('ACL Administration Not Authorized') . ")";
    exit;
}
if(isset($_POST['type']) === true && $_POST['type'] === 'delete') {
    $bindParams = [$_POST['id']];

    $sql = 'DELETE FROM request_features WHERE id=?';

    sqlQuery($sql, $bindParams);
    echo 'ok';
}
else if (isset($_POST['status']) === true && isset($_POST['id-for-admin-comment']) === true) {
    $bindParams = [$_POST['status'], $_POST['admin_comment'], $_POST['id-for-admin-comment']];

    $sql = 'UPDATE request_features SET 
            status=?,
            admin_comment=?,
            admin_comment_datetime=NOW()
            WHERE id=?';

    echo sqlQuery($sql, $bindParams);    
}