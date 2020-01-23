<?php
/**
 * @author			Yves
 * @description 	Save request feature
 * @created By 		Khoa N
 */
require_once("../globals.php");

if (isset($_POST['title']) === true && isset($_POST['feature']) === true) {
	// firstly i willl check duplicated feature
	$sql = 'SELECT COUNT(id) as count_id FROM request_features WHERE feature=?';
	$query = sqlQuery($sql, array($_POST['feature']));

	if($query['count_id'] > 0) {
		exit('duplicated');
	}

    $bindParams = [$_POST['title'], $_POST['feature'], $_SESSION['authUserID']];

    $sql = 'INSERT INTO request_features SET 
            title=?,
            feature=?,
            user_id=?,
            request_datetime=NOW(),
            feature_comment=?';

    if(isset($_POST['feature_comment']) === true) {
    	array_push($bindParams, $_POST['feature_comment']);
    }
    else {
    	array_push($bindParams, '');
    }

    echo sqlInsert($sql, $bindParams);    
}