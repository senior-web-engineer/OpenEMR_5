<?php
/**
 * Portal Registration Wizard
 *
 * @package OpenEMR
 * @link    http://www.open-emr.org
 * @author  Jerry Padgett <sjpadgett@gmail.com>
 * @copyright Copyright (c) 2017-2018 Jerry Padgett <sjpadgett@gmail.com>
 * @license https://www.gnu.org/licenses/agpl-3.0.en.html GNU Affero General Public License 3
 */

session_start();
session_regenerate_id(true);

unset($_SESSION['itsme']);
$_SESSION['authUser'] = 'portal-user';
$_SESSION['pid'] = true;
$_SESSION['register'] = true;
$encounterTypeId = $_GET['typeId'] ? $_GET['typeId'] : null;

$_SESSION['site_id'] = isset($_SESSION['site_id']) ? $_SESSION['site_id'] : 'default';
$landingpage = "index.php?site=" . $_SESSION['site_id'];

$ignoreAuth_onsite_portal_two = true;

require_once("../../interface/globals.php");

$res2 = sqlStatement("select * from lang_languages where lang_description = ?", array(
    $GLOBALS['language_default']
));
for ($iter = 0; $row = sqlFetchArray($res2); $iter++) {
    $result2[$iter] = $row;
}
if (count($result2) == 1) {
    $defaultLangID = $result2[0]{"lang_id"};
    $defaultLangName = $result2[0]{"lang_description"};
} else {
    // default to english if any problems
    $defaultLangID = 1;
    $defaultLangName = "English";
}

if (!isset($_SESSION['language_choice'])) {
    $_SESSION['language_choice'] = $defaultLangID;
}
// collect languages if showing language menu
if ($GLOBALS['language_menu_login']) {
    // sorting order of language titles depends on language translation options.
    $mainLangID = empty($_SESSION['language_choice']) ? '1' : $_SESSION['language_choice'];
    if ($mainLangID == '1' && !empty($GLOBALS['skip_english_translation'])) {
        $sql = "SELECT * FROM lang_languages ORDER BY lang_description, lang_id";
        $res3 = SqlStatement($sql);
    } else {
        // Use and sort by the translated language name.
        $sql = "SELECT ll.lang_id, " . "IF(LENGTH(ld.definition),ld.definition,ll.lang_description) AS trans_lang_description, " . "ll.lang_description " .
            "FROM lang_languages AS ll " . "LEFT JOIN lang_constants AS lc ON lc.constant_name = ll.lang_description " .
            "LEFT JOIN lang_definitions AS ld ON ld.cons_id = lc.cons_id AND " . "ld.lang_id = ? " .
            "ORDER BY IF(LENGTH(ld.definition),ld.definition,ll.lang_description), ll.lang_id";
        $res3 = SqlStatement($sql, array(
            $mainLangID
        ));
    }

    for ($iter = 0; $row = sqlFetchArray($res3); $iter++) {
        $result3[$iter] = $row;
    }

    if (count($result3) == 1) {
        // default to english if only return one language
        $hiddenLanguageField = "<input type='hidden' name='languageChoice' value='1' />\n";
    }
} else {
    $hiddenLanguageField = "<input type='hidden' name='languageChoice' value='" . htmlspecialchars($defaultLangID, ENT_QUOTES) . "' />\n";
}

?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo xlt('New Patient'); ?> | <?php echo xlt('Register'); ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="description" content="">

    <link href="<?php echo $GLOBALS['assets_static_relative']; ?>/font-awesome-4-6-3/css/font-awesome.min.css"
          rel="stylesheet" type="text/css"/>
    <link rel="stylesheet"
          href="<?php echo $GLOBALS['assets_static_relative']; ?>/jquery-datetimepicker-2-5-4/build/jquery.datetimepicker.min.css">
    <link href="<?php echo $GLOBALS['assets_static_relative']; ?>/bootstrap-3-3-4/dist/css/bootstrap.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="./../assets/css/register.css" rel="stylesheet" type="text/css"/>
    <!-- Cstm-site.css Link -->
    <link href="./../assets/css/cstm-site.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo $GLOBALS['assets_static_relative']; ?>/jquery-min-3-1-1/index.js"
            type="text/javascript"></script>

    <script src="<?php echo $GLOBALS['assets_static_relative']; ?>/bootstrap-3-3-4/dist/js/bootstrap.min.js"
            type="text/javascript"></script>
    <script type="text/javascript"
            src="<?php echo $GLOBALS['assets_static_relative']; ?>/jquery-datetimepicker-2-5-4/build/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript"
            src="<?php echo $GLOBALS['assets_static_relative']; ?>/emodal-1-2-65/dist/eModal.js"></script>

    <link href="../sign/css/signer.css?v=41" rel="stylesheet" type="text/css"/>
    <link href="../sign/assets/signpad.css?v=41" rel="stylesheet">
    <script type="text/javascript" src="../sign/assets/signer.js?v=41"></script>
    <script src="../sign/assets/signpad.js?v=25445" type="text/javascript"></script>

    <style>
        .display-block {
            display: block !important;
        }

        fieldset hr {
            margin-top: 12px;
            margin-bottom: 12px;
        }

        .consent-inline p, .consent-inline form, .fee form, .fee form label {
            display: inline-block;
        }

        .consent-inline input, .fee input {
            border: none;
            border-bottom: 1px solid #333;
            box-shadow: none;
            border-radius: 0;
            margin-left: 10px;
        }

        .consent-inline input:focus, .fee input:focus {
            outline: none;
            box-shadow: none;
        }

        .fee input {
            width: 10%;
            display: inline-block;
        }

        .fee-agreement input {
            display: block;
            width: 100%;
            margin-bottom: 1em;
        }

        .fee-agreement div {
            text-align: center;
        }

        .sig-preview svg g {
            position: relative;
            top: -100px;
            left: -98px;
        }

        .sig-preview svg {
            height: 224px;
        }

        .sign-modal {
            min-width: 400px !important;
            width: 400px !important;
        }
    </style>
    <script>
        var newPid = 0;
        var curPid = 0;
        var provider = 0;

        $(document).ready(function () {
            /* // test data
            $("#emailInput").val("me@me.com");
            $("#fname").val("Jerry");
            $("#lname").val("Padgett");
            $("#dob").val("1919-03-03");
            // ---------- */
            localStorage.setItem('EncounterTypeId', '<?php echo $encounterTypeId ?>');
            var navListItems = $('div.setup-panel div a'),
                allWells = $('.setup-content'),
                allNextBtn = $('.nextBtn'),
                allPrevBtn = $('.prevBtn');

            allWells.hide();

            navListItems.click(function (e) {
                e.preventDefault();
                var $target = $($(this).attr('href')),
                    $item = $(this);

                if (!$item.hasClass('disabled')) {
                    navListItems.removeClass('btn-primary').addClass('btn-default');
                    $item.addClass('btn-primary');
                    allWells.hide();
                    $target.show();
                    $target.find('input:eq(0)').focus();
                }
            });

            allPrevBtn.click(function () {
                var curStep = $(this).closest(".setup-content"),
                    curStepBtn = curStep.attr("id"),
                    prevstepwiz = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");
                prevstepwiz.removeAttr('disabled').trigger('click');
            });

            allNextBtn.click(function () {
                var profile = $("#profileFrame").contents();

                /* // test data
                profile.find("input#street").val("123 Some St.");
                profile.find("input#city").val("Brandon");
                //--------------------- */

                var curStep = $(this).closest(".setup-content"),
                    curStepBtn = curStep.attr("id"),
                    nextstepwiz = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                    curInputs = curStep.find("input[type='text'],input[type='email'],select"),
                    isValid = true;

                $(".form-group").removeClass("has-error");
                for (var i = 0; i < curInputs.length; i++) {
                    if (!curInputs[i].validity.valid) {
                        isValid = false;
                        $(curInputs[i]).closest(".form-group").addClass("has-error");
                    }
                }
                if (isValid) {
                    if (curStepBtn == 'step-1') { // leaving step 1 setup profile frame. Prob not nec but in case
                        profile.find('input#fname').val($("#fname").val());
                        profile.find('input#mname').val($("#mname").val());
                        profile.find('input#lname').val($("#lname").val());
                        profile.find('input#dob').val($("#dob").val());
                        profile.find('input#email').val($("#emailInput").val());
                        profile.find('input[name=allowPatientPortal]').val(['YES']);
                        // need these for validation.
                        profile.find('select#providerid option:contains("Unassigned")').val('');
                        profile.find('select#providerid').attr('required', true);
                        profile.find('select#sex option:contains("Unassigned")').val('');
                        profile.find('select#sex').attr('required', true);

                        var pid = profile.find('input#pid').val();
                        if (pid < 1) { // form pid set in promise
                            callServer('get_newpid', '', $("#dob").val(), $("#lname").val(), $("#fname").val()); // @TODO escape these
                        }
                    }
                    nextstepwiz.removeAttr('disabled').trigger('click');
                }
            });

            $("#profileNext").click(function () {
                var profile = $("#profileFrame").contents();
                var curStep = $(this).closest(".setup-content"),
                    curStepBtn = curStep.attr("id"),
                    nextstepwiz = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                    curInputs = $("#profileFrame").contents().find("input[type='text'],input[type='email'],select"),
                    isValid = true;
                $(".form-group").removeClass("has-error");
                var flg = 0;
                for (var i = 0; i < curInputs.length; i++) {
                    if (!curInputs[i].validity.valid) {
                        isValid = false;
                        if (!flg) {
                            curInputs[i].scrollIntoView();
                            curInputs[i].focus();
                            flg = 1;
                        }
                        $(curInputs[i]).closest(".form-group").addClass("has-error");
                    }
                }
                if (isValid) {
                    provider = profile.find('select#providerid').val();
                    nextstepwiz.removeAttr('disabled').trigger('click');
                    var fullName = profile.find('input#fname').val() + ' ' + profile.find('input#mname').val() + ' ' + profile.find('input#lname').val();
                    $('#consentForm').find('.full_name').text(fullName);
                }
            });

            $("#startForm").click('#startNext', function () {
                $("#profileFrame").contents().find('#language').val('English');
            });

            $("#submitPatient").click(function () {
                if ($('#consentForm').find('.consent_signature_id').val()) {
                    var profile = $("#profileFrame").contents();
                    var pid = profile.find('input#pid').val();

                    if (pid < 1) { // Just in case. Can never have too many pid checks!
                        callServer('get_newpid', '');
                    }

                    var isOk = checkRegistration(newPid);
                    if (isOk) {
                        // Use portals rest api. flag 1 is write to chart. flag 0 writes an audit record for review in dashboard.
                        // rest update will determine if new or existing pid for save. In register step-1 we catch existing pid but,
                        // we can still use update here if we want to allow changing passwords.
                        //
                        document.getElementById('profileFrame').contentWindow.page.updateModel(1);
                        $("#consentForm").submit();
                        $("#clientNoticeForm").submit();
                        $("#insuranceForm").submit();
                        //  cleanup is in callServer done promise. This starts end session.
                    }
                } else {
                    alert("Please sign consent form to complete registration.");
                }
            });

            $('div.setup-panel div a.btn-primary').trigger('click');

            $('.datepicker').datetimepicker({
                <?php $datetimepicker_timepicker = false; ?>
                <?php $datetimepicker_showseconds = false; ?>
                <?php $datetimepicker_formatInput = false; ?>
                <?php require($GLOBALS['srcdir'] . '/js/xl/jquery-datetimepicker-2-5-4.js.php'); ?>
            });

            $("#insuranceForm").submit(function (e) {
                e.preventDefault();
                var url = "account.php?action=new_insurance&pid=" + newPid;
                $.ajax({
                    url: url,
                    type: 'post',
                    data: $("#insuranceForm").serialize(),
                    success: function (serverResponse) {
                        doCredentials(newPid) // this is the end for session.
                        return false;
                    }
                });
            });

            $("#consentForm").submit(function (e) {
                e.preventDefault();
                var url = "account.php?action=new_consent&pid=" + newPid;
                $.ajax({
                    url: url,
                    type: 'post',
                    data: $("#consentForm").serialize(),
                    success: function (serverResponse) {
                        return true;
                    }
                });
            });
            $("#clientNoticeForm").submit(function (e) {
                e.preventDefault();
                var url = "account.php?action=new_client_notice&pid=" + newPid;
                $.ajax({
                    url: url,
                    type: 'post',
                    data: $("#clientNoticeForm").serialize(),
                    success: function (serverResponse) {
                        return true;
                    }
                });
            });

            $('#selLanguage').on('change', function () {
                callServer("set_lang", this.value);
            });

            $(document.body).on('hidden.bs.modal', function () { //@TODO maybe make a promise for wiz exit
                callServer('cleanup');
            });

            $('#inscompany').on('change', function () {
                if ($('#inscompany').val().toUpperCase() === 'SELF') {
                    $("#insuranceForm input").removeAttr("required");
                    let message = "<?php echo xls('You have chosen to be self insured or currently do not have insurance. Click next to continue registration.'); ?>";
                    alert(message);
                }
            });

        }); // ready end

        function doCredentials(pid) {
            callServer('do_signup', pid);
        }

        function checkRegistration(pid) {
            var profile = $("#profileFrame").contents();
            var curStep = $("#step-2"),
                curStepBtn = curStep.attr("id"),
                nextstepwiz = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                curInputs = $("#profileFrame").contents().find("input[type='text'],input[type='email'],select"),
                isValid = true;
            $(".form-group").removeClass("has-error");
            var flg = 0;
            for (var i = 0; i < curInputs.length; i++) {
                if (!curInputs[i].validity.valid) {
                    isValid = false;
                    if (!flg) {
                        curInputs[i].scrollIntoView();
                        curInputs[i].focus();
                        flg = 1;
                    }
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                }
            }

            if (!isValid) {
                return false;
            }

            return true;
        }

        function callServer(action, value, value2, last, first) {
            var data = {
                'action': action,
                'value': value,
                'dob': value2,
                'last': last,
                'first': first
            }
            if (action == 'do_signup') {
                data = {
                    'action': action,
                    'pid': value
                };
            } else if (action == 'notify_admin') {
                data = {
                    'action': action,
                    'pid': value,
                    'provider': value2
                };
            } else if (action == 'cleanup') {
                data = {
                    'action': action
                };
            }
            // The magic that is jquery ajax.
            $.ajax({
                type: 'GET',
                url: 'account.php',
                data: data
            }).done(function (rtn) {
                if (action == "cleanup") {
                    window.location.href = "./../index.php" // Goto landing page.
                } else if (action == "set_lang") {
                    window.location.href = window.location.href;
                } else if (action == "get_newpid") {
                    if (parseInt(rtn) > 0) {
                        newPid = rtn;
                        $("#profileFrame").contents().find('input#pubpid').val(newPid);
                        $("#profileFrame").contents().find('input#pid').val(newPid);
                    } else {
                        // After error alert app exit to landing page.
                        // Existing user error. Error message is translated in account.lib.php.
                        eModal.alert(rtn);
                    }
                } else if (action == 'do_signup') {
                    if (rtn == "") {
                        let message = "<?php echo xls('Unable to either create credentials or send email.'); ?>";
                        alert(message);
                        return false;
                    }
                    // For production. Here we're finished so do signup closing alert and then cleanup.
                    responseData = callServer('notify_admin', newPid, provider); // pnote notify to selected provider
                    // alert below for ease of testing.
                    //alert(rtn); // sync alert.. rtn holds username and password for testing.
                    let message = "<?php echo xls("Your new credentials have been sent, therefore, you have begun the steps toward becoming a client at the Parent's Information and 
             Resource Center (PIRC). Check your email inbox and also possibly your spam folder. Once you log into your patient portal feel 
             free to make an appointment or send us a secure message. We look forward to your becoming a member of the PIRC family of clients."); ?>"
                    eModal.alert(message); // This is an async call. The modal close event exits us to portal landing page after cleanup.
                }
            }).fail(function (err) {
                let message = "<?php echo xls('Something went wrong.') ?>";
                alert(message);
            });
        }
    </script>
</head>
<body class="skin-blue md-bg">
<div class="container">
    <div class="stepwiz col-md-offset-3">
        <div class="stepwiz-row setup-panel">
            <div class="stepwiz-step">
                <a href="#step-1" type="button" class="btn btn-primary btn-circle btn-ctm-circle">1</a>
                <p><?php echo xlt('Get Started') ?></p>
            </div>
            <div class="stepwiz-step">
                <a href="#step-2" type="button" class="btn btn-default btn-circle btn-ctm-circle"
                   disabled="disabled">2</a>
                <p><?php echo xlt('Profile') ?></p>
            </div>
            <?php if ($encounterTypeId == 1) { ?>
                <div class="stepwiz-step">
                    <a href="#step-3" type="button" class="btn btn-default btn-circle btn-ctm-circle"
                       disabled="disabled">3</a>
                    <p><?php echo xlt('Insurance') ?></p>
                </div>
            <?php } ?>
            <div class="stepwiz-step">
                <a href="#step-4" type="button" class="btn btn-default btn-circle btn-ctm-circle"
                   disabled="disabled">
                    <?php if ($encounterTypeId == 1) {
                        echo '4';
                    } else {
                        echo '3';
                    }
                    ?>
                </a>
                <p><?php echo xlt('Consent Form') ?></p>
            </div>
            <div class="stepwiz-step">
                <a href="#step-5" type="button" class="btn btn-default btn-circle btn-ctm-circle"
                   disabled="disabled">
                    <?php if ($encounterTypeId == 1) {
                        echo '5';
                    } else {
                        echo '4';
                    }
                    ?>
                </a>
                <p><?php echo xlt('Client Notice') ?></p>
            </div>
            <div class="stepwiz-step">
                <a href="#step-6" type="button" class="btn btn-default btn-circle btn-ctm-circle"
                   disabled="disabled"><?php echo xlt('Done') ?></a>
                <p><?php echo xlt('Register') ?></p>
            </div>
        </div>
    </div>
    <!-- // Start Forms // -->
    <form class="" id="startForm" role="form" action="" method="post" onsubmit="">
        <div class="row setup-content" id="step-1">
            <div class="col-xs-12">
                <fieldset>
                    <legend class='bg-primary text-center title-bg'><?php echo xlt('Contact') ?></legend>
                    <div class="well ml-bg">
                        <?php if ($GLOBALS['language_menu_login']) { ?>
                            <?php if (count($result3) != 1) { ?>
                                <div class="form-group row">
                                    <div class="col-xs-12 col-md-4">
                                        <label for="selLanguage"><?php echo xlt('Language'); ?></label>
                                        <select class="form-control" id="selLanguage" name="languageChoice">
                                            <?php
                                            echo "<option selected='selected' value='" . htmlspecialchars($defaultLangID, ENT_QUOTES) . "'>" .
                                                htmlspecialchars(xl('Default') . " - " . xl($defaultLangName), ENT_NOQUOTES) . "</option>\n";
                                            foreach ($result3 as $iter) {
                                                if ($GLOBALS['language_menu_showall']) {
                                                    if (!$GLOBALS['allow_debug_language'] && $iter['lang_description'] == 'dummy') {
                                                        continue; // skip the dummy language
                                                    }
                                                    echo "<option value='" . htmlspecialchars($iter['lang_id'], ENT_QUOTES) . "'>" .
                                                        htmlspecialchars($iter['trans_lang_description'], ENT_NOQUOTES) . "</option>\n";
                                                } else {
                                                    if (in_array($iter['lang_description'], $GLOBALS['language_menu_show'])) {
                                                        if (!$GLOBALS['allow_debug_language'] && $iter['lang_description'] == 'dummy') {
                                                            continue; // skip the dummy language
                                                        }
                                                        echo "<option value='" . htmlspecialchars($iter['lang_id'], ENT_QUOTES) . "'>" .
                                                            htmlspecialchars($iter['trans_lang_description'], ENT_NOQUOTES) . "</option>\n";
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="fname"><?php echo xlt('First') ?></label>
                                    <div class="controls inline-inputs">
                                        <input type="text" class="form-control" id="fname" required
                                               placeholder="<?php echo xla('First Name'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="mname"><?php echo xlt('Middle') ?></label>
                                    <div class="controls inline-inputs">
                                        <input type="text" class="form-control" id="mname"
                                               placeholder="<?php echo xla('Full or Initial'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="lname"><?php echo xlt('Last Name') ?></label>
                                    <div class="controls inline-inputs">
                                        <input type="text" class="form-control" id="lname" required
                                               placeholder="<?php echo xla('Enter Last'); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!--                            <div class="col-sm-12 col-md-4">-->
                            <!--                                <div class="form-group inline">-->
                            <!--                                    <label class="control-label" for="fname">-->
                            <?php //echo xlt('Child Name') ?><!--</label>-->
                            <!--                                    <div class="controls inline-inputs">-->
                            <!--                                        <input type="text" class="form-control" id="fname" required-->
                            <!--                                               placeholder="-->
                            <?php //echo xla('Child Name'); ?><!--">-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group inline">
                                    <label class="control-label" for="dob"><?php echo xlt('Birth Date') ?></label>
                                    <div class="controls inline-inputs">
                                        <div class="form-group">
                                            <input id="dob" type="text" required class="form-control datepicker"
                                                   placeholder="<?php echo xla('YYYY-MM-DD'); ?>"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group inline">
                                    <label class="control-label"
                                           for="email"><?php echo xlt('Enter E-Mail Address') ?></label>
                                    <div class="controls inline-inputs">
                                        <input id="emailInput" type="email" class="form-control" style="width: 100%"
                                               required
                                               placeholder="<?php echo xla('Enter email address to receive registration.'); ?>"
                                               maxlength="100">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <button class="btn btn-primary nextBtn btn-sm pull-right mb-3" id="startNext"
                                        type="button"><?php echo xlt('Next') ?></button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </form>
    <!-- Profile Form -->
    <form class="form-inline" id="profileForm" role="form" action="account.php" method="post">
        <div class="row setup-content" id="step-2" style="display: none">
            <div class="col-md-12 text-center">
                <fieldset>
                    <legend class='bg-primary title-bg'><?php echo xlt('Profile') ?></legend>
                    <div class="well ml-bg">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item"
                                    src="../patient/patientdata?pid=0&register=true&typeId=<?php echo $encounterTypeId; ?>"
                                    id="profileFrame" name="demo"></iframe>
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <button class="btn btn-primary prevBtn btn-sm pull-left mb-3"
                                            type="button"><?php echo xlt('Previous') ?></button>
                                    <button class="btn btn-primary btn-sm pull-right mb-3" type="button"
                                            id="profileNext"><?php echo xlt('Next') ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </form>


    <!-- Insurance Form -->
    <form id="insuranceForm" role="form" action="" method="post">
        <?php if ($encounterTypeId == 1) { ?>
            <div class="row setup-content" id="step-3" style="display: none">
                <div class="col-xs-6 col-md-12">
                    <fieldset>
                        <legend class='bg-primary title-bg text-center'><?php echo xlt('Insurance') ?></legend>
                        <div class="well ml-bg">
                            <!--End of Row 1-->
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for="provider"><?php echo xlt('Insurance Company') ?></label>
                                        <div class="controls inline-inputs">
                                            <input type="text" class="form-control" name="provider" id="inscompany"
                                                   required
                                                   placeholder="<?php echo xla('Enter Self if None'); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for=""><?php echo xlt('Plan Name') ?></label>
                                        <div class="controls inline-inputs">
                                            <input type="text" class="form-control" name="plan_name" required
                                                   placeholder="<?php echo xla('Required'); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for=""><?php echo xlt('Policy Number') ?></label>
                                        <div class="controls inline-inputs">
                                            <input type="text" class="form-control" name="policy_number" required
                                                   placeholder="<?php echo xla('Required'); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End of Row 1-->
                            <!--Start of Row 2-->
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for=""><?php echo xlt('Group Number') ?></label>
                                        <div class="controls inline-inputs">
                                            <input type="text" class="form-control" name="group_number" required
                                                   placeholder="<?php echo xla('Required'); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for=""><?php echo xlt('Policy Begin Date') ?></label>
                                        <div class="controls inline-inputs">
                                            <input type="text" class="form-control datepicker" name="date"
                                                   placeholder="<?php echo xla('Policy effective date'); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for=""><?php echo xlt('Co-Payment') ?></label>
                                        <div class="controls inline-inputs">
                                            <input type="number" class="form-control" name="copay"
                                                   placeholder="<?php echo xla('Plan copay if known'); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-5">
                                    <button class="btn btn-primary prevBtn btn-sm pull-left mb-3"
                                            type="button"><?php echo xlt('Previous') ?></button>
                                    <button class="btn btn-primary nextBtn btn-sm pull-right mb-3"
                                            type="button"><?php echo xlt('Next') ?></button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>

        <?php } else { ?>
            <input type="hidden" name="provider" value="">
            <input type="hidden" name="plan_name" value="">
            <input type="hidden" name="policy_number" value="">
            <input type="hidden" name="group_number" value="">
            <input type="hidden" name="date" value="">
            <input type="hidden" name="copay" value="">
        <?php } ?>
    </form>

    <form id="consentForm" role="form" action="" method="post">
        <div class="row setup-content" id="step-4" style="display: none">
            <div class="col-xs-12 col-md-12">
                <fieldset>
                    <legend class='bg-success title-bg text-center'><?php echo xlt('Consent Form') ?></legend>
                    <div class="well ml-bg register-success">
                        <div class="so-tabwrap">
                            <div class="tab-content tabconten-block" id="nav-tabContent">
                                <!--Start of Individual Tab-->
                                <div class="tab-pane fade active in" id="individual" role="tabpanel">
                                    <div class="tabinnercontent mt-4">
                                        <!-- Start of Treatment & Participation -->
                                        <div class="consent-inline">
                                            <input type="hidden" name="consent_signature_id"
                                                   class="consent_signature_id" value="">
                                            <p>I <span class="full_name"></span>
                                                request to be admitted to PIRC Clinic, Inc. for any of the following
                                                services psychiatric/tele-psychiatric assessment,
                                                medication/tele-medication management, counseling/tele-mental health,
                                                observation, social services, anger management, parenting training and
                                                other services.
                                            </p>
                                            <p>
                                                I understand that by signing below I am not a client of The Parent's
                                                Information and Resource Center, Inc., (PIRC) until I have been
                                                formally made aware that my registration request has been reviewed and
                                                accepted by a representative of PIRC. I also understand
                                                that if I do not complete the entire intake process, my actions
                                                constitutes a refusal of treatment from PIRC, and therefore, PIRC is not
                                                liable for my refusal to receive services.
                                            </p>
                                        </div>
                                        <br>
                                        <h4>Medication Policy:</h4>
                                        <hr>
                                        <div>
                                            <p>If medication needs are identified, I agree to comply with medication
                                                treatment as prescribed. It is not our policy to renew prescription
                                                medication over the telephone. Due to the need for close medication
                                                monitoring, prescription refills are disbursed only at the time of an
                                                office/tele-psychiatry visit. Therefore, it is imperative that the
                                                patient keeps his/her medication appointment.</p>
                                        </div>
                                        <br>
                                        <h4>Litigation Disclosure:</h4>
                                        <hr>
                                        <div>
                                            <p>I understand that PIRC Clinic, Inc. will not become involved with custody
                                                battles or other legal exchanges with attorney’s etc. PIRC will exchange
                                                written information to the patient or the patient’s legal guardian and
                                                it will be up to the patient or the patient’s legal guardian to share
                                                the information with the attorney or other interested parties. </p>
                                        </div>
                                        <br>
                                        <h4>Fee Agreement:</h4>
                                        <hr>
                                        <div class="fee">
                                            <p>I also understand that while I am participating in treatment, I may be
                                                expected to pay a fee for all social and/or medical services that I
                                                received, unless other fee arrangements are made. I understand that PIRC
                                                will bill any of the following sources:</p>

                                            <div class="form-row">
                                                <div class="col-sm-12 col-md-12">
                                                    <label class="ctmcontainer d-inline">Government Funded Program (free
                                                        of charge), including Medicaid or Medicare (I will pay the
                                                        Medicaid /Medicare Copay of $<input type="checkbox"
                                                                                            checked="checked"
                                                                                            name="government_fund_flag"
                                                                                            value="1">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <input type="number" class="form-control"
                                                           name="government_funded_fee">)
                                                </div>

                                                <div class="col-sm-12 col-md-12">
                                                    <label class="ctmcontainer d-inline">Private Insurance and I will
                                                        pay the Co-pay of $<input type="checkbox"
                                                                                  name="insurance_fund_flag" value="1">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <input type="number" class="form-control"
                                                           name="insurance_copay_fee">per session.
                                                </div>

                                                <div class="col-sm-12 col-md-12">
                                                    <label class="ctmcontainer d-inline">Grant/Private funding which is
                                                        free of charge to me based on the funding criteria<input
                                                            type="checkbox" name="private_fund_flag" value="1">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>

                                                <div class="col-sm-12 col-md-12">
                                                    <label class="ctmcontainer d-inline">Self-pay and I will pay the
                                                        full cost of $<input type="checkbox" name="self_pay_flag"
                                                                             value="1">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <input type="number" class="form-control" name="self_pay_fee">per
                                                    (1) hour counseling session. I understand that I am required to pay
                                                    the regular fee for appointment that I miss unless cancelled within
                                                    24 hours of my scheduled appointment.
                                                </div>

                                                <br/>
                                                <br/>
                                            </div>
                                            <div class="row fee-agreement">
                                                <br/>
                                                <label class="col-sm-12 col-md-4 mt-4">Client Signature</label>

                                                <div class="form-group col-md-4 mt-4">
                                                    <a href="#openConsentSignModal" data-toggle="modal" data-backdrop="true">
                                                        <?php echo xlt('SIGNATURE'); ?>
                                                    </a>
                                                </div>
                                                <!--<div class="patient-signature-preview"></div>-->
                                            </div>
                                            <div class="row">
                                                <div class="patient-signature-preview sig-preview col-sm-12 col-md-3">

                                                </div>
                                            </div>

                                        </div>
                                        <!-- End of Treatment & Participation -->
                                    </div>
                                </div>
                            </div>
                            <!--End of Tab Content-->
                        </div>

                        <div class="row">
                            <div class="col-md-12 mt-5">
                                <button class="btn btn-primary prevBtn btn-sm pull-left mb-3"
                                        type="button"><?php echo xlt('Previous') ?></button>
                                <button class="btn btn-primary nextBtn btn-sm pull-right mb-3"
                                        type="button"><?php echo xlt('Next') ?></button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </form>

    <div class="row setup-content" id="step-5" style="display: none">
        <div class="col-xs-12 col-md-12">
            <form id="clientNoticeForm" role="form" action="" method="post">
                <fieldset>
                    <legend
                        class='bg-success title-bg text-center'><?php echo xlt("Client's Notice of Privacy Practice") ?></legend>
                    <div class="well ml-bg register-success">

                        <div class="so-tabwrap">

                            <div class="tab-content tabconten-block" id="nav-tabContent">
                                <!-- Start of Right & Notice of Privacy Practices -->
                                <div class="tab-pane fade active in" id="unassign" role="tabpanel">
                                    <div class="tabinnercontent mt-4">
                                        <p>This agency is committed to ensuring that you receive professional and
                                            humanistic services, directed toward your needs, and in a manner that
                                            protects your dignity and feelings of self worth. To this end, the following
                                            Statement of Rights has been formulated:</p>
                                        <br>
                                        <h4>CIVIL RIGHTS</h4>
                                        <hr>
                                        <div>
                                            <ol type="1">
                                                <li>You have the right to be treated with dignity and respect.
                                                </li>
                                                <li>You retain all rights, benefits and privileges guaranteed by law.
                                                </li>
                                            </ol>
                                        </div>
                                        <br>
                                        <h4>DISCRIMINATION</h4>
                                        <hr>
                                        <div>
                                            <ol>
                                                <li>Services will be provided to you and/or your family members without
                                                    discrimination. Ethnic background, personal or social creed, racial
                                                    membership, sex, religion, or age will not affect our services to
                                                    you.
                                                </li>
                                                <li>You will not be refused any services based on lack of, or limited,
                                                    personal financial resources. Travel and loss of work time will be
                                                    discussed and kept at a minimum. No physical barriers will preclude
                                                    treatment.
                                                </li>
                                                <li>Services will be provided with a minimum waiting time. Agency
                                                    service hours will be reasonably convenient
                                                </li>
                                            </ol>
                                        </div>
                                        <br>
                                        <h4>CONFIDENTIALITY </h4>
                                        <hr>
                                        <div>
                                            <ol>
                                                <li>Your medical and social service records are confidential and cannot
                                                    be released to anyone without express consent given by you or your
                                                    guardian. However, the Court without your permission can subpoena
                                                    your records, especially if you are court-mandated to treatment.
                                                    Also, knowledge of child abuse, elder abuse, and intent to harm
                                                    others or you must, by law be reported in addition to knowledge of
                                                    communicable diseases.
                                                </li>
                                                <li>You have the right to review and approve any information being
                                                    requested by another provider agency.
                                                </li>
                                            </ol>
                                        </div>
                                        <br>
                                        <h4>TREATMENT</h4>
                                        <hr>
                                        <div>
                                            <ol>
                                                <li>You have the right to an individual plan for treatment and will be
                                                    expected to participate in your plan for treatment.
                                                </li>
                                                <li>You have the right to know the name and professional credentials of
                                                    anyone working with you.
                                                </li>
                                                <li>You may request to participate in any staff meeting regarding
                                                    yourself.
                                                </li>
                                                <li>You may review your clinical record upon written request.</li>
                                                <li>You will be advised of the positive effect and possible complication
                                                    of any drugs or medications prescribed by any physician involved in
                                                    your treatment.
                                                </li>
                                                <li>You have the right to refuse to participate in, or be interviewed
                                                    for, research purposes.
                                                </li>
                                                <li>You have the right to refuse any electronic and/or visual recording
                                                    of your treatment without your expressed written approval.
                                                </li>
                                                <li>You have the right to terminate treatment at anytime.</li>
                                            </ol>
                                        </div>
                                        <br>
                                        <h4>GRIEVANCE PROCEDURE</h4>
                                        <hr>
                                        <div>
                                            <ol>
                                                <li>If you feel that your treatment program has not been provided
                                                    fairly, or reasonably, you may present your concerns, in writing to
                                                    the PIRC's management / supervisory staff.
                                                </li>
                                                <li>You have the right to legal recourse; you have the right to confer
                                                    with family, attorney, physician, clergyman, and others at any time.
                                                </li>
                                                <li>You may contact the Alcohol, Drug Abuse and Mental Health Office of
                                                    the Department of Children and Families at (954) 467-4298 if you
                                                    have a grievance regarding the treating agency.
                                                </li>
                                                <li>You are under the protection provided under Florida Statute 491
                                                    Section 10E-16004 (27) as follows:
                                                    Protection of patient’s – the rights of the patient’s who are
                                                    admitted to this program shall be assured and defined in each
                                                    program operating standards. This shall include operating standards,
                                                    which protect the dignity, health and safety of patient’s.
                                                </li>
                                            </ol>
                                        </div>
                                        <br>
                                        <h4>EVALUATION</h4>
                                        <p>Consistent with providing professional and quality services, you will be
                                            given and opportunity to evaluate all aspects of your services and the
                                            personnel with whom you were involved. (You may be asked to evaluate your
                                            treatment, in writing, during or upon completion of treatment).</p>
                                        <br>
                                        <div class="">
                                            <div class="form-group row mt-4">
                                                <label for="inputEmail3" class="col-sm-4 col-form-label">Client
                                                    Signature:</label>
                                                <div class="col-xs-6 col-md-4">
                                                    <a href="#openClientNoticeSignModal" data-toggle="modal"
                                                       data-backdrop="true">
                                                        <?php echo xlt('CLIENT SIGNATURE'); ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="patient-signature-preview sig-preview col-sm-12 col-md-3">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Right & Notice of Privacy Practices -->
                            </div>
                            <!--End of Tab Content-->
                        </div>

                        <div class="row">
                            <div class="col-md-12 mt-5">
                                <button class="btn btn-primary prevBtn btn-sm pull-left mb-3"
                                        type="button"><?php echo xlt('Previous') ?></button>
                                <button class="btn btn-primary nextBtn btn-sm pull-right mb-3"
                                        type="button"><?php echo xlt('Next') ?></button>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <input type="hidden" name="client_notice_signature_id" class="client_notice_signature_id" value="">
            </form>
        </div>

    </div>
    <!-- End Insurance. Next what we've been striving towards..the end-->
    <div class="row setup-content" id="step-6" style="display: none">
        <div class="col-xs-12 col-md-12">
            <fieldset>
                <legend class='bg-success title-bg text-center'><?php echo xlt('Register') ?></legend>
                <div class="well ml-bg register-success" style="text-align: center">
                    <h3><?php echo xlt("All set. Click Send Request below to finish registration") ?></h3>
                    <hr>
                    <p>
                        <?php echo xlt("An e-mail with your new account credentials will be sent to the e-mail address supplied earlier. You may still review or edit any part of your information by using the top step buttons to go to the appropriate panels. Note to be sure you have given your correct e-mail address. If after receiving credentials and you have trouble with access to the portal, please contact administration.") ?>
                    </p>
                    <br/>
                    <div class="row">
                        <div class="col-sm-12">
                            <button class="btn btn-primary prevBtn btn-sm pull-left mt-4 mb-3"
                                    type="button"><?php echo xlt('Previous') ?></button>
                            <button class="btn btn-success btn-sm pull-right mt-4 mb-3 send-r" style="width:15%;"
                                    type="button" id="submitPatient"><?php echo xlt('Send Request') ?></button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>

<div id="openConsentSignModal" class="modal fade" role="dialog">F
    <div class="modal-dialog modal-lg sign-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="input-group">

                </div>
            </div>
            <div class="modal-body">
                <form name="signit" id="signit" class="sigPad">
                    <input type="hidden" name="name" id="name" class="name">
                    <ul class="sigNav">
                        <label style='display: none;'>
                            <input style='display: none;' type="checkbox" class="" id="isAdmin" name="isAdmin"/>
                            <?php echo xlt('Is Authorizing Signature'); ?>
                        </label>
                        <li class="clearButton">
                            <a href="#clear">
                                <button><?php echo xlt('Clear Signature'); ?></button>
                            </a>
                        </li>
                    </ul>
                    <div class="sig sigWrapper">
                        <div class="typed"></div>
                        <canvas class="spad" id="drawpad" width="366" height="226"
                                style="border: 1px solid #000000; left: 0px;"></canvas>
                        <img
                            style="display: none; position: absolute; TOP: 150px; LEFT: 315px; WIDTH: 100px; HEIGHT: 100px"
                            id="loading" src="../assets/loading.gif"/>
                        <input type="hidden" id="output" name="output" class="output">
                    </div>
                    <input type="hidden" name="type" id="type" value="patient-registration-signature">
                    <input type="hidden" name="signature_id" class="consent_signature_id" value="">
                    <button type="button"
                            onclick="signRegistrationConsentForm(this)"><?php echo xlt('Acknowledge as my Electronic Signature'); ?>
                        .
                    </button>
                </form>
            </div>
        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
    </div>
</div><!-- Modal -->

<div id="openClientNoticeSignModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg sign-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form name="signit" id="signit" class="sigPad">
                    <input type="hidden" name="name" id="name" class="name">
                    <ul class="sigNav">
                        <label style='display: none;'>
                            <input style='display: none;' type="checkbox" class="" id="isAdmin" name="isAdmin"/>
                            <?php echo xlt('Is Authorizing Signature'); ?>
                        </label>
                        <li class="clearButton">
                            <a href="#clear">
                                <button><?php echo xlt('Clear Signature'); ?></button>
                            </a>
                        </li>
                    </ul>
                    <div class="sig sigWrapper">
                        <div class="typed"></div>
                        <canvas class="spad" id="drawpad" width="366" height="226"
                                style="border: 1px solid #000000; left: 0px;"></canvas>
                        <img
                            style="display: none; position: absolute; TOP: 150px; LEFT: 315px; WIDTH: 100px; HEIGHT: 100px"
                            id="loading" src="../assets/loading.gif"/>
                        <input type="hidden" id="output" name="output" class="output">
                    </div>
                    <input type="hidden" name="type" id="type" value="client-notice-signature">
                    <input type="hidden" name="signature_id" class="client_notice_signature_id" value="">
                    <button type="button"
                            onclick="signRegistrationClientNotice(this)"><?php echo xlt('Acknowledge as my Electronic Signature'); ?>
                    </button>
                </form>
            </div>
        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
    </div>
</div><!-- Modal -->

</body>
<style>
    /* Customize the label (the container) */
    .termscheck-wrap {
        width: 48%;
        margin: 0 auto;
    }

    .termscheck-wrap a {
        text-decoration: underline;
    }

    .termscheck-wrap a:hover {
        color: #1d6ebc;
    }

    .ctmcontainer {
        /*display: block;*/
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 16px;
        font-weight: normal;
        text-align: left;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .ctmcontainer input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 22px;
        width: 22px;
        background-color: #eee;
    }

    /* On mouse-over, add a grey background color */
    .ctmcontainer:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .ctmcontainer input:checked ~ .checkmark {
        background-color: #1d6ebc;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .ctmcontainer input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .ctmcontainer .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    .fee-agreement div {
        text-align: left;

    }

    .fee-agreement div label {
        margin-left: 20px;

    }
</style>

<script>
    var webRoot = "<?php echo $GLOBALS['web_root'];?>";
    $(document).ready(function () {
        $('#openConsentSignModal').on('show.bs.modal', function (e) {
            $('.sigPad').signaturePad({
                drawOnly: true,
                defaultAction: 'drawIt'
            });
        });
        $('#openConsentSignModal').on('hidden.bs.modal', function () {
            return false;
        });

        $('#openClientNoticeSignModal').on('show.bs.modal', function (e) {
            $('.sigPad').signaturePad({
                drawOnly: true,
                defaultAction: 'drawIt'
            });
        });
        $('#openClientNoticeSignModal').on('hidden.bs.modal', function () {
            return false;
        });
    });
</script>

</html>
