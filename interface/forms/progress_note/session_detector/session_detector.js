/*
set the following variables / pre-requisites:
var session_detector_options = {
	form_pid:'<?php echo $form_pid;?>',
	form_encounter:'<?php echo $form_encounter;?>',
	v_client_name:'<?php echo (stripslashes($obj{"v_client_name"}));?>',
	v_current_session:'<?php echo $v_current_session;?>',
	v_dos:'<?php echo stripslashes($obj{"v_dos"});?>',
	v_pid:'<?php echo stripslashes($obj{"v_pid"});?>', 
	v_encounter:'<?php echo stripslashes($obj{"v_encounter"});?>'
};

var WEBROOT = '<?php echo $GLOBALS['webroot'] ?>';
*/

$(function () {

    // TODO:  jquery ui dialog 
    // $("#session_detector_dialog").dialog({
    //     autoOpen: false,
    //     bgiframe: true,
    //     height: 140,
    //     modal: true
    // });

    var randomnumber = Math.floor(Math.random() * 100);
    var url = WEBROOT + '/interface/forms/progress_note/session_detector/session_detector.api.php';
    var opt = session_detector_options; // just to shorten it

    var refreshIntervalId = setInterval(function () {
        $.post(url,
            {
                form_pid: opt.form_pid,
                form_encounter: opt.form_encounter,
                v_client_name: opt.v_client_name,
                v_current_session: opt.v_current_session,
                v_dos: opt.v_dos,
                v_pid: opt.v_pid,
                v_encounter: opt.v_encounter
            },
            function (data) {
                if (!!data) { // does data contain data
                    data = JSON.parse(data); // convert to json

                    console.debug(" system_encounter = " + data.system_encounter);
                    console.debug(" system_pid = " + data.system_pid);
                    console.debug(" concurrent_session = " + data.concurrent_session);

                    if (data.concurrent_session === "true") {
                        // stop the loop
                        clearInterval(refreshIntervalId);

                        // TODO:  jquery ui dialog 
                        // $("#session_detector_dialog").dialog("open");

                        alert("There is another OpenEMR session open in this browser. A new OpenEMR session may cause data loss. Further editing and saving on this form has been disabled to prevent data loss "); // for now

                        // lock page
                        top.restoreSession();
                        $('#draft').attr('disabled', true);
                        $('#submit').attr('disabled', true);
                        $('textarea').attr('readonly', true);
                    }
                }
            });
    }, 3000);
});

