<?php
require_once("../globals.php");
if (!acl_check('admin', 'acl')) {
    require_once('./api_user.php');
}
else {
  require_once('./api_admin.php');
}