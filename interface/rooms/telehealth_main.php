<?php
/*
* Room List
*/

require_once("../globals.php");
require_once("../../library/acl.inc");
require_once("$srcdir/auth.inc");
require_once("./twilio_api.php");

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

$mode = 'get_roomlink';
$platform = '';
$room_link = '';
$meetingurl  = "";

if (isset($_POST["mode"])) {
    $mode = $_POST["mode"];
    if ($_POST["mode"] == "get_roomlink") {
        $user_id = $_POST["user_id"];
        $platform = $_POST["platform"];
        $query = "SELECT * FROM rooms WHERE user_id=$user_id AND platform='$platform'";
        $res = sqlStatement($query);
        $row = sqlFetchArray($res);
        $room_link = "";
        if ($row)
            $room_link = $row['room_link'];

        if ($platform == "Twilio") {
            $room = create_room();
            $room_link = $room['url'];
        }
        echo $room_link;
    }

    if ($_POST["mode"] == "join_room") {
        $user_id = $_POST["user_id"];
        $platform = $_POST["platform"];
        if ($platform == "Zoom") {
            $query = "SELECT * FROM users WHERE id=$user_id";
            $res = sqlStatement($query);
            $row = sqlFetchArray($res);
            $name = implode(" ", [$row['fname'], $row['mname'], $row['lname']]);
            $un = base64_encode($name);
            $query = "SELECT * FROM rooms WHERE user_id=$user_id AND platform='$platform'";
            $res = sqlStatement($query);
            $row = sqlFetchArray($res);
            if ($row)
                $room_link = $row['room_link'];

            $pattern = preg_quote($room_link, '/');
            preg_match('/\/([0-9]+)\?/', $room_link, $matches);
            if (count($matches) > 0)
                $meetingid = str_replace("/", "", $matches[0]);
                $meetingid = str_replace("?", "", $meetingid);
            if ($meetingid != '') {
                $meetingurl = "https://zoom.us/s/".$meetingid;
                //$meetingurl = "https://zoom.us/wc/".$meetingid."/join?prefer=0&un=".$un;
            }
        }
        if ($platform == "Twilio") {
            $meetingurl = $room_link;
        }
    }
}

if (isset($_REQUEST["mode"])) {
    if ($_REQUEST["mode"] == "get_roomlink")
        exit(text(trim($alertmsg)));
}

?>

<html>
    <head>
        <title><?php echo xlt('Rooms / Telehealth');?></title>
        <?php Header::setupHeader(['common','jquery-ui']); ?>
        <script type="text/javascript">
            function start_session(room_link) {
                location.href = room_link;
            }

            function change_room() {
                let form_data = $("#telehealth_form").serialize();
                $.ajax({
                    url: '<?php echo $_SERVER['PHP_SELF'];?>',
                    type: 'post',
                    data: form_data
                }).done(function (r) {
                    $("#room_link").val(r);
                });

                return false;
            }

            function join_room() {
                $("#mode").val('join_room');
                telehealth_form.submit();
            }
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
            <form name='telehealth_form' id="telehealth_form" method='post' action="<?php echo $_SERVER['PHP_SELF'];?>">
            <input type="hidden" name="csrf_token_form" value="<?php echo attr(CsrfUtils::collectCsrfToken()); ?>" />
            <input type='hidden' name='mode' id='mode' value='<?php echo $mode; ?>'>
            <input type='hidden' name='user_id' id='user_id' value='<?php echo $_SESSION['authUserID']; ?>'>
            <div class="row">
                <div class="col-xs-2">
                    <label style="padding-top: 10px;">Platform: </label>
                </div>
                <div class="col-xs-2">
                    <select name="platform" size="1" class="form-control" onchange="change_room()">
                    <?php
                        $query = "SELECT * FROM room_platform ORDER BY priority ASC";
                        $res = sqlStatement($query);
                        for ($iter = 0; $row = sqlFetchArray($res); $iter++) {
                    ?>
                        <option value="<?php echo $row['platform']; ?>" <?php echo ($platform == $row['platform'])?'selected':''; ?>><?php echo $row['platform'];?></option>
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
                    <input type="text" class="form-control" name="room_link" id="room_link" readonly style="background:#fff" value="<?php echo $room_link; ?>">
                </div>
            </div>
            </form>
            <div class="row">
                <div class="col-xs-2">
                    <label style="padding-top: 10px;">Scheduled Meeting: </label>
                </div>
                <div class="col-xs-4">
                    <table class="table table-striped">
                        <tr>
                            <td>
                                <?php if ($meetingurl == '') { ?>
                                    <img src='./img/avatar.png' width='480px' height='480px'>
                                <?php } else { ?>
                                    <div class="iframe-container" style="overflow: hidden; width:480px; height:480px; position: relative;">
                                        <iframe allow="microphone; camera" style="border: 0; height: 100%; left: 0; position: absolute; top: 0; width: 100%;" src="<?php echo $meetingurl; ?>" sandbox="allow-forms allow-scripts allow-same-origin" allow="microphone; camera"></iframe>
                                    </div>
                                <?php } ?>
                            </td>
                            <td><input type="button" class="form-control" value="Scheduled Meeting" onclick="join_room()"></td>
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
                    <?php
                        $query = "SELECT a.pc_roomlink, b.fname, b.lname, b.mname, b.phone_cell, b.email, CONCAT(pc_eventDate, ' ', pc_startTime) as pc_eventDateTime FROM openemr_postcalendar_events a INNER JOIN patient_data b ON a.pc_pid=b.id WHERE a.pc_aid=".$_SESSION['authUserID']." AND CONCAT(pc_eventDate, ' ', pc_startTime) >= NOW() ORDER BY a.pc_eventDate, pc_startTime, pc_endTime ASC";
                        $res = sqlStatement($query);
                        for ($iter = 0; $row = sqlFetchArray($res); $iter++) {
                    ?>
                            <tr>
                                <td style="padding-top:25px;"><?php echo ($iter+1); ?></td>
                                <td><img src='./img/avatar.png'></td>
                                <td style="padding-top:20px;">
                                    <?php echo text($row['fname'])." ". text($row['mname']) . " " . text($row['lname']);?>
                                    <br>
                                    <?php echo text($row['pc_eventDateTime']);?>
                                </td>
                                <td style="padding: 20px 5px;"><input type="button" class="form-control" value="Send a Message"></td>
                                <td style="padding: 20px 5px;"><input type="button" class="form-control" value="Start Session" onclick="start_session('<?php echo text($row['pc_roomlink']);?>')"></td>
                            </tr>
                    <?php
                        }
                    ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
