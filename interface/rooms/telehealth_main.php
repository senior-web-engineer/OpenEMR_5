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


?>

<html>
    <head>
        <title><?php echo xlt('Rooms / Telehealth');?></title>
        <?php Header::setupHeader(['common','jquery-ui']); ?>
        <script type="text/javascript">
        </script>
    </head>
    <body class="body_top">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title">
                        <h2><?php echo xlt('Telehealth Meetings');?></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-2">
                    <label style="padding-top: 10px;">Platform: </label>
                </div>
                <div class="col-xs-2">
                    <select name="platform" size="1" class="form-control">
                    <?php
                        $query = "SELECT * FROM room_platform ORDER BY priority ASC";
                        $res = sqlStatement($query);
                        for ($iter = 0; $row = sqlFetchArray($res); $iter++) {
                    ?>
                        <option value="<?php echo $row['platform']; ?>"><?php echo $row['platform'];?></option>
                    <?php
                        }
                    ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-2">
                    <label style="padding-top: 10px;">Room Link: </label>
                </div>
                <div class="col-xs-10">
                    <input type="text" class="form-control" name="room_link">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-2">
                    <label style="padding-top: 10px;">Scheduled Meeting: </label>
                </div>
                <div class="col-xs-4">
                    <table class="table table-striped">
                        <tr>
                            <td><img src='./img/avatar.png' width='280px' height='280px'></td>
                            <td><input type="button" class="form-control" value="Scheduled Meeting"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-2">
                    <label style="padding-top: 10px;">Patient List: </label>
                </div>
                <div class="col-xs-10">
                    <table class="table table-striped">
                        <tr>
                            <td style="padding-top:25px;">1</td>
                            <td><img src='./img/avatar.png'></td>
                            <td style="padding-top:25px;">Patient Name</td>
                            <td style="padding: 20px 5px;"><input type="button" class="form-control" value="Send a Message"></td>
                            <td style="padding: 20px 5px;"><input type="button" class="form-control" value="Start Session"></td>
                        </tr>
                        <tr>
                            <td style="padding-top:25px;">2</td>
                            <td><img src='./img/avatar.png'></td>
                            <td style="padding-top:25px;">Patient Name</td>
                            <td style="padding: 20px 5px;"><input type="button" class="form-control" value="Send a Message"></td>
                            <td style="padding: 20px 5px;"><input type="button" class="form-control" value="Start Session"></td>
                        </tr>
                        <tr>
                            <td style="padding-top:25px;">3</td>
                            <td><img src='./img/avatar.png'></td>
                            <td style="padding-top:25px;">Patient Name</td>
                            <td style="padding: 20px 5px;"><input type="button" class="form-control" value="Send a Message"></td>
                            <td style="padding: 20px 5px;"><input type="button" class="form-control" value="Start Session"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
