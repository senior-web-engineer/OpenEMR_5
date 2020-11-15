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
$room_userid = "";
$room_platform = "";
$room_link = "";
if (isset($_GET['id']))
{
    $res = sqlStatement("SELECT * from room_platform where id=?", array($_GET["id"]));
    for ($iter = 0; $row = sqlFetchArray($res); $iter++) {
                    $result[$iter] = $row;
    }
    $platforminfo = $result[0];
    $platform = $platforminfo['platform'];
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

                let mode = $("#mode").val();
                if (mode != 'delete_platform'){
                    f=document.forms[0];
                    for(i=0;i<f.length;i++) {
                        if(f[i].type=='text') {
                            if (f[i].name == 'platform') {
                                if (f[i].value == '') {
                                    alertMsg += '<?php echo xl("Invalid")." " ?>'+'platform'+"\n";
                                } else {
                                    alertMsg += checkLength('platform', f[i].value,32);
                                }
                            }
                        }
                    }

                    if(alertMsg) {
                        alert(alertMsg);
                        return false;
                    }
                }

                let post_url = $("#new_platform").attr("action");
                let request_method = $("#new_platform").attr("method");
                let form_data = $("#new_platform").serialize();

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
                $("#delete").click(function(){
                    $("#mode").val('delete_platform');
                    submitform();
                });
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
                    <td><span class="title"><?php echo (isset($_GET['id']))?xlt('Add Platform'):xlt('Edit Platform'); ?></span>&nbsp;</td>
                </tr>
            </table>
            <form name='new_platform' id="new_platform" method='post' action="platform_list.php">
                <input type="hidden" name="csrf_token_form" value="<?php echo attr(CsrfUtils::collectCsrfToken()); ?>" />
                <input type='hidden' name='mode' id='mode' value='<?php echo (attr($_GET["id"]))?'edit_platform':'new_platform'; ?>'>
                <INPUT TYPE="hidden" NAME="id" VALUE="<?php echo attr($_GET["id"]); ?>">
                <table border=0>
                    <tr>
                        <td valign=top>
                            <span class="bold">&nbsp;</span>
                            <table border=0 cellpadding=0 cellspacing=0 style="width:600px;">
                                <tr>
                                    <td style="width:150px;"><span class="text"><?php echo xlt('Platform'); ?>: </span></td>
                                    <td style="width:220px;">
                                        <input type="text" name="platform" class="form-control" value="<?php echo $platform; ?>">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table border=0 cellpadding=0 cellspacing=0 style="width:600px;padding-top:50px;">
                    <tr>
                        <td class="buttonbar">
                            <input type="button" class="btn btn-link btn-save" name='form_save' id='form_save' onclick="return submitform()" value="<?php echo xlt('Save'); ?>">
                            <input type="button" class="btn btn-link btn-cancel" id='cancel' value="<?php echo xlt('Cancel');?>">
                            <input type="button" class="btn btn-link btn-delete" id='delete' onclick="return submitform()" value="<?php echo xlt('Delete');?>">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>
