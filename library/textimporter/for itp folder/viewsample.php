<!DOCTYPE html>
<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
formHeader("Form: individualized_treatment_plan_cmh");
?>
        <script src="<?php echo "$web_root";?>/library/textimporter/jquery-1.11.3.min.js"></script>
        <script src="<?php echo "$web_root";?>/library/textimporter/underscore.js"></script>
        <script src="<?php echo "$web_root";?>/library/textimporter/jquery-tmpl.js"></script>
        <script src="<?php echo "$web_root";?>/library/textimporter/knockout-3.3.0.debug.js"></script>
        <script src="<?php echo "$web_root";?>/library/textimporter/koExternalTemplateEngine_all.js"></script>
        <script src="<?php echo "$web_root";?>/library/textimporter/textimporter.js"></script>
        <link href="<?php echo "$web_root";?>/library/textimporter/textimporter.css" rel="stylesheet"></link>

        <h2>Page</h2>
        <style>
            textarea { width:400px; height:100px;}
        </style>

        <textarea id="thistextbox2" ></textarea>
        <div data-bind="tiControl: {
                            id: 'thistextbox2',
                            page: 'prognosis/view.html'
                            }, tiVM: $data"></div>

        <textarea id="textbox1" ></textarea>
        <input type="text" id="input1" />
        <div data-bind="tiControl: {
                            id: 'textbox1',
                            storeid: ['input1'] ,
                            page: 'prognosis/view.html'
                            }, tiVM: $data"></div>

        <textarea id="textbox3" ></textarea>
        <div data-bind="tiControl: {
                            id: 'textbox3',
                            page: 'prognosis/view.html',
                            params: {id1: 17}
                            }, tiVM: $data"></div>
        
        <textarea id="textbox4" ></textarea>
        <div data-bind="tiControl: {
                            id: 'textbox4',
                            page: 'prognosis/view.html',
                            appendvalue: false,
                            params: {id1: 2112}
                            }, tiVM: $data"></div>
        
        
        <br><br>Problem #1:<br>
        <textarea cols=85 rows=2 wrap=virtual name="problem_1" id="problem_1" ></textarea><br>
        <div data-bind="tiControl: {
                            id: 'problem_1',
                            page: 'itp_cmh/new.php',
                            storeid: ['group1','problem1'] ,
                            appendvalue: true,
                            params: {id1: 0}
                            }, tiVM: $data"></div>
        <input type="text" id="group1" />
        <input type="text" id="problem1" /><br><br>

        <b>Goal #1:</b><br>
        <textarea cols=85 rows=2 wrap=virtual name="goal_1" id="goal_1" ></textarea><br><br>
        <div data-bind="tiControl: {
                            id: 'goal_1',
                            page: 'itp_cmh/new.php',
                            storeid: ['goal'] ,
                            appendvalue: true,
                            params: {id1: 0}
                            }, tiVM: $data"></div>
        <input type="text" id="goal1" />
	<br><br>

        <div id="errors" class="errors" ></div>

    </body>
</html>
