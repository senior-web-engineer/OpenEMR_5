<?php
/*
* Add Room
*/

require_once("../globals.php");
require_once("../../library/acl.inc");
require_once("$srcdir/options.inc.php");
require_once("$srcdir/erx_javascript.inc.php");

use OpenEMR\Common\Csrf\CsrfUtils;
use OpenEMR\Core\Header;
use OpenEMR\Menu\MainMenuRole;
use OpenEMR\Menu\PatientMenuRole;

/*
if (!acl_check('admin', 'practice')) {
    exit();
}
*/

$room_link = "";
if (isset($_GET['room']))
{
    $room_link = $_GET['room'];
}

$alertmsg = '';

?>
<html>
    <head>
        <?php Header::setupHeader(['common','opener']); ?>
        <script language="JavaScript">

            function submitform() {
                top.restoreSession();
                alertMsg='';

                let patient_phone = $("#patient_phone").val();
                if (patient_phone == '')
                    return;

                let invite_roomlink = $("#invite_roomlink").val();
                if (invite_roomlink == '')
                    return;

                let post_url = $("#invite_form").attr("action");
                let request_method = $("#invite_form").attr("method");
                let form_data = $("#invite_form").serialize();

                console.log(post_url);
                console.log(request_method);
                console.log(form_data);


                $.ajax({
                    url: post_url,
                    type: request_method,
                    data: form_data
                }).done(function (r) {
                    if (r) {
                        alert(r);
                    } else {
                        dlgclose('reload', false);
                    }
                });

                return false;
            }

            $(function(){
                $("#cancel").click(function() {
                    dlgclose();
                });
            });
        </script>
    </head>
    <body class="body_top">
        <div class="container">
            <table>
                <tr>
                    <td><span class="title"><?php echo xlt('Invite via Text Message'); ?></span>&nbsp;</td>
                </tr>
            </table>
            <form name='invite_form' id="invite_form" method='post' action="telehealth_main.php">
                <input type="hidden" name="csrf_token_form" value="<?php echo attr(CsrfUtils::collectCsrfToken()); ?>" />
                <input type='hidden' name='mode' id='mode' value='invite_room'>
                <table border=0>
                    <tr>
                        <td valign=top>
                            <span class="bold">&nbsp;</span>
                            <table border="0" cellpadding="0" cellspacing="0" style="width:600px;">
                                <tr>
                                    <td style="width:150px;"><span class="text"><?php echo xlt('Patient Phone Number'); ?>: </span></td>
                                    <td style="width:320px;">
                                        <input type="text" name="patient_phone" id="patient_phone" class="form-control" value="" placeholder="+17548022619">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:150px;"><span class="text"><?php echo xlt('Invite Room Link'); ?>: </span></td>
                                    <td style="width:320px;">
                                        <input type="text" name="invite_roomlink" id="invite_roomlink" class="form-control" value="<?php echo $room_link?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:150px;"><span class="text"><?php echo xlt('Message Preview'); ?>: </span></td>
                                    <td style="width:320px;">
                                        <textarea rows=5 cols=30 id="invite_message" class="form-control" name="invite_message">Hello.
Please join me for a secure video call:
<?php echo $room_link; ?>
                                        </textarea>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table border=0 cellpadding=0 cellspacing=0 style="width:600px;padding-top:50px;">
                    <tr>
                        <td class="buttonbar">
                            <input type="button" class="btn btn-link btn-save" name='form_save' id='form_save' onclick="return submitform()" value="<?php echo xlt('Send'); ?>">
                            <input type="button" class="btn btn-link btn-cancel" id='cancel' value="<?php echo xlt('Cancel');?>">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>
