<?php
/*
* Room List
*/

require_once("../globals.php");
require_once("../../library/acl.inc");
require_once("$srcdir/auth.inc");

use OpenEMR\Common\Csrf\CsrfUtils;
use OpenEMR\Core\Header;
use OpenEMR\Services\UserService;

if (!empty($_POST)) {
    if (!CsrfUtils::verifyCsrfToken($_POST["csrf_token_form"])) {
        CsrfUtils::csrfNotVerified();
    }
}

if (!empty($_GET)) {
    if (!CsrfUtils::verifyCsrfToken($_GET["csrf_token_form"])) {
        CsrfUtils::csrfNotVerified();
    }
}

if (!acl_check('admin', 'users')) {
    die(xlt('Access denied'));
}

if (isset($_POST["mode"])) {
    if ($_POST["mode"] == "new_room") {
        sqlStatement(
            "INSERT INTO `rooms` SET user_id = ?, platform = ?, room_link = ?",
            array(
                trim((isset($_POST['user_id']) ? $_POST['user_id'] : '')),
                trim((isset($_POST['platform']) ? $_POST['platform'] : '')),
                trim((isset($_POST['roomlink']) ? $_POST['roomlink'] : ''))
            )
        );
    }

    if ($_POST["mode"] == "edit_room") {
        sqlStatement(
            "UPDATE `rooms` set platform = ?, room_link = ? WHERE id = ?",
            array(
                trim((isset($_POST['platform']) ? $_POST['platform'] : '')),
                trim((isset($_POST['roomlink']) ? $_POST['roomlink'] : '')),
                trim((isset($_POST['id']) ? $_POST['id'] : ''))
            )
        );
    }

    if ($_POST['mode'] == 'delete_room') {
        sqlStatement(
            "DELETE FROM rooms WHERE id = ?",
            array(
                trim((isset($_POST['id']) ? $_POST['id'] : ''))
            )
        );
    }
}

if (isset($_REQUEST["mode"])) {
    exit(text(trim($alertmsg)));
}
?>
<html>
    <head>
        <title><?php echo xlt('Rooms / Rooms');?></title>
        <?php Header::setupHeader(['common','jquery-ui']); ?>
        <script type="text/javascript">
            $(function(){
                tabbify();
                $(".medium_modal").on('click', function(e) {
                    e.preventDefault();e.stopPropagation();
                    dlgopen('', '', 660, 200, '', '', {
                        type: 'iframe',
                        url: $(this).attr('href')
                    });
                });

            });
        </script>
    </head>
    <body class="body_top">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title">
                        <h2><?php echo xlt('Rooms');?></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <a href="room_add.php" class="medium_modal btn btn-default btn-add"><?php echo xlt('Add Room'); ?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><?php echo xlt('Id'); ?></th>
                                <th><?php echo xlt('Username'); ?></th>
                                <th><?php echo xlt('Real Name'); ?></th>
                                <th><?php echo xlt('Platform'); ?></th>
                                <th><?php echo xlt('Room Link'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $query = "SELECT rooms.id, users.username, users.fname, users.lname, rooms.platform, rooms.room_link FROM rooms INNER JOIN users ON rooms.user_id=users.id WHERE rooms.active = '1'";
                            $res = sqlStatement($query);
                            for ($iter = 0; $row = sqlFetchArray($res); $iter++) {
                        ?>
                            <tr>
                                <td><?php echo ($iter + 1); ?></td>
                                <td><?php echo "<b><a href='room_add.php?id=" . attr_url($row{"id"}) . "&csrf_token_form=" . attr_url(CsrfUtils::collectCsrfToken()) .
                                "' class='medium_modal' onclick='top.restoreSession()'>" . text($row{"username"}) . "</a></b>";?></td>
                                <td><?php echo text($row['fname']) . ' ' . text($row['lname']); ?></td>
                                <td><?php echo text($row['platform']); ?></td>
                                <td><?php echo $row['room_link']; ?></td>
                            </tr>
                        <?php
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
