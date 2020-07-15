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


if (!acl_check('admin', 'super')) {
    die(xlt('Access denied'));
}


if (isset($_POST["mode"])) {
    if ($_POST["mode"] == "new_platform") {
        $new_platform_id = sqlInsert(
            "INSERT INTO `room_platform` SET platform = ?, priority = ?",
            array(
                trim((isset($_POST['platform']) ? $_POST['platform'] : '')),
                0,
            )
        );

        sqlStatement(
            "UPDATE `room_platform` set priority = ? WHERE id = ?",
            array(
                $new_platform_id,
                $new_platform_id
            )
        );

    }

    if ($_POST["mode"] == "edit_platform") {
        sqlStatement(
            "UPDATE `room_platform` set platform = ? WHERE id = ?",
            array(
                trim((isset($_POST['platform']) ? $_POST['platform'] : '')),
                trim((isset($_POST['id']) ? $_POST['id'] : ''))
            )
        );
    }

    if ($_POST['mode'] == 'delete_platform') {
        sqlStatement(
            "DELETE FROM `room_platform` WHERE id = ?",
            array(
                trim((isset($_POST['id']) ? $_POST['id'] : ''))
            )
        );
    }
}

if (isset($_GET["mode"])) {
    if ($_GET["mode"] == "down") {
        $query = "SELECT * FROM room_platform WHERE priority > ? ORDER BY priority ASC LIMIT 1";
        $res = sqlStatement($query, array($_GET["priority"]));
        $row = sqlFetchArray($res);
        if ($row)
        {
            sqlStatement(
                "UPDATE `room_platform` set priority = ? WHERE id = ?",
                array(
                    $row['priority'],
                    $_GET['id']
                )
            );

            sqlStatement(
                "UPDATE `room_platform` set priority = ? WHERE id = ?",
                array(
                    $_GET['priority'],
                    $row['id']
                )
            );
        }
    }

    if ($_GET["mode"] == "up") {
        $query = "SELECT * FROM room_platform WHERE priority < ? ORDER BY priority DESC LIMIT 1";
        $res = sqlStatement($query, array($_GET["priority"]));
        $row = sqlFetchArray($res);
        if ($row)
        {
            sqlStatement(
                "UPDATE `room_platform` set priority = ? WHERE id = ?",
                array(
                    $row['priority'],
                    $_GET['id']
                )
            );

            sqlStatement(
                "UPDATE `room_platform` set priority = ? WHERE id = ?",
                array(
                    $_GET['priority'],
                    $row['id']
                )
            );
        }
    }
}

if (isset($_POST["mode"])) {
    exit(text(trim($alertmsg)));
}

?>
<html>
    <head>
        <title><?php echo xlt('Rooms / Platform');?></title>
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

            function set_priority(sort, id, priority)
            {
                location.href="<?php echo $_SERVER['PHP_SELF'] ?>?mode=" + sort + "&id=" + id + "&priority=" + priority + "&csrf_token_form=" + "<?php echo attr(CsrfUtils::collectCsrfToken()); ?>";
            }
        </script>
    </head>
    <body class="body_top">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title">
                        <h2><?php echo xlt('Platform');?></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <a href="./platform_add.php" class="medium_modal btn btn-default btn-add"><?php echo xlt('Add Platform'); ?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width:5%"><?php echo xlt('Id'); ?></th>
                                <th style="width:60%"><?php echo xlt('Platform'); ?></th>
                                <th style="width:20%"><?php echo xlt('Priority'); ?></th>
                                <th style="width:15%"><?php echo xlt('Created Time'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $query = "SELECT * FROM room_platform ORDER BY priority ASC";

                            $res = sqlStatement($query);
                            for ($iter = 0; $row = sqlFetchArray($res); $iter++) {
                        ?>
                            <tr>
                                <td><?php echo ($iter + 1); ?></td>
                                <td><?php echo "<b><a href='platform_add.php?id=" . attr_url($row{"id"}) . "&csrf_token_form=" . attr_url(CsrfUtils::collectCsrfToken()) .
                                "' class='medium_modal' onclick='top.restoreSession()'>" . text($row{"platform"}) . "</a></b>";?></td>
                                <td>
                                    <a href="#" onclick="set_priority('down', <?php echo attr_url($row{"id"}) ?>, <?php echo attr_url($row{"priority"}) ?>)"><span class="glyphicon glyphicon-arrow-down"></span></a>
                                    <a href="#" onclick="set_priority('up', <?php echo attr_url($row{"id"}) ?>, <?php echo attr_url($row{"priority"}) ?>)"><span class="glyphicon glyphicon-arrow-up"></span></a>
                                </td>
                                <td><?php echo $row['created_time']; ?></td>
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
