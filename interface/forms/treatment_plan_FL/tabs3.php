<!DOCTYPE html>
<html lang="en">
<head>
<?php
include_once("$srcdir/api.inc");
include_once('$srcdir/globals.php');
include_once("../../globals.php");
include_once("$srcdir/api.inc");
$obj = $formid ? formFetch("form_treatment_plan", $formid) : array();
?>
<title>Bootstrap Case</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://www.jqwidgets.com/jquery-widgets-demo/jqwidgets/styles/jqx.base.css" type="text/css" />
<link rel="stylesheet" href="https://www.jqwidgets.com/jquery-widgets-demo/jqwidgets/styles/jqx.light.css" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="tab3_new.css?version=2">
<link href="<?php echo "$web_root";?>/library/js/SmartWizard-master/dist/css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" />

<!-- text importer -->
<script src="<?php echo "$web_root";?>/library/textimporter/jquery-1.11.3.min.js"></script>
<link rel="stylesheet" href="<?php echo "$web_root";?>/library/css/bootstrap.min.css">
<script src="<?php echo "$web_root";?>/library/js/bootstrap.min.js"></script>

<script type="text/javascript" src="https://www.jqwidgets.com/jquery-widgets-demo/jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="https://www.jqwidgets.com/jquery-widgets-demo/jqwidgets/jqxtree.js"></script>
<script type="text/javascript" src="https://www.jqwidgets.com/jquery-widgets-demo/jqwidgets/jqxsplitter.js"></script>
<script type="text/javascript" src="https://www.jqwidgets.com/jquery-widgets-demo/jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="https://www.jqwidgets.com/jquery-widgets-demo/jqwidgets/jqxpanel.js"></script>
<script type="text/javascript" src="https://www.jqwidgets.com/jquery-widgets-demo/jqwidgets/jqxlistbox.js"></script>
<script type="text/javascript" src="https://www.jqwidgets.com/jquery-widgets-demo/jqwidgets/jqxexpander.js"></script>
<script type="text/javascript" src="https://www.jqwidgets.com/jquery-widgets-demo/jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="https://www.jqwidgets.com/jquery-widgets-demo/jqwidgets/jqxexpander.js"></script>
<script type="text/javascript" src="<?php echo "$web_root";?>/library/js/SmartWizard-master/dist/js/jquery.smartWizard.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@8/dist/sweetalert2.min.css" id="theme-styles">
<script type="text/javascript" src="tab3_new.js?version=122"></script>
<script type="text/javascript" src="tab_problem.js?version=122"></script>
<script type="text/javascript" src="tab_behavior.js?version=122"></script>
<script type="text/javascript" src="tab_goal.js?version=122"></script>
<script type="text/javascript" src="tab_objective.js?version=122"></script>
<script type="text/javascript" src="tab_intervention.js?version=122"></script>
<script type="text/javascript" src="tab_modality.js?version=122"></script>
<script type="text/javascript" src="tab_modality_note.js?version=122"></script>
<script type="text/javascript" src="tab_discharge.js?version=122"></script>
<script type="text/javascript" src="tab_diagnosis.js?version=122"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<!-- page querystring parameters -->
<script type="text/javascript">
<?php 
  $formid = 0 + (isset($_GET['formid']) ? $_GET['formid'] : 0); 
  $dev  = 0 + (isset($_GET['dev']) ? $_GET['dev'] : 0);
  
?>
var dev = <?php echo $dev ?>;
const theme = 'light';
</script>
</head>
<body>
<input type="hidden" id="form-id" value="<?php echo $formid ?>">
<div id="mainSplitter" style="width: 100%; height: 100%">
    <div>
      <div style="border: none;" id="jqxExpander">
        <div>
            <i class="fa fa-address-card" aria-hidden="true"></i> Problems    
          </div>
          <div class="problems-area" style="padding: 0">
            <div class="problems-panel">
              <div class="list-group" id="problem-tab" style="margin:0">
              </div>
            </div>
            <div class="bottom-panel">
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-primary"   disabled onclick="createNewProblem()" id="btn-new-problem"><i class="fa fa-plus" aria-hidden="true"></i> New</button>
                <button type="button" class="btn btn-secondary" disabled onclick="editProblem()"      id="btn-edit-problem"><i class="fa fa-pencil" aria-hidden="true"></i>
                 Edit</button>
                <button type="button" class="btn btn-danger" disabled    onclick="deleteProblem()"    id="btn-delete-problem"><i class="fa fa-trash" aria-hidden="true"></i>
                  Del</button>
              </div>
            </div>
          </div>
      </div>
    </div>
    <div class="smartwizard-panel">
      <div id="smartwizard">
          <ul>
              <li><a href="#step-1">Diagnosis</a></li>
              <li><a href="#step-2">Definitions</a></li>
              <li><a href="#step-3">Goals</a></li>
              <li><a href="#step-4">Objectives / Interventions</a></li>
              <li><a href="#step-5">Modality</a></li>
              <li><a href="#step-6">Modality Note</a></li>
              <li><a href="#step-7">Discharge Criteria</a></li>
          </ul>
          
          <div class="smartwizard-content">
            <div id="step-1" class="">
              <div class="step-prev-contents"></div>
              <br>
              <div style="margin-bottom: 30px;">
                <button class="btn btn-primary" id="btn-add-diagnosis" onclick="createNewDiagnosis()" disabled>Add New Axis I Diagnosis</button>
              </div>
              <ul class="list-group" id="diagnosis-contents">
              </ul>
            </div>

            <div id="step-2" class="">
              <div class="step-prev-contents"></div>
              <br>
              <div style="margin-bottom: 30px;">
                <button class="btn btn-primary" onclick="createNewBehavior()" disabled id="btn-add-behavior">Add New Behavioral Definition</button>
              </div>
              <div class="step-content-body">
                <h3 class="step-content-header">Definitions</h3>
                <ul class="list-group" id="behavior-contents">
                </ul>
              </div>
            </div>
            <div id="step-3" class="">
              <div class="step-prev-contents"></div>
              <br>
              <div style="margin-bottom: 30px;">
                <button class="btn btn-primary" onclick="createNewGoal()" disabled id="btn-add-goal">Add Goal</button>
              </div>
              <div class="step-content-body">
                <h3 class="step-content-header">Goals</h3>
                <div class="list-group" id="goal-contents">
                </div>
              </div>
            </div>
            <div id="step-4" class="">
              <div class="step-prev-contents"></div>
              <br>
              <h3>Objectives for Problem</h3>
              <div style="margin-bottom: 30px;">
                <button class="btn btn-primary" onclick="createNewObjective()" disabled id="btn-add-objective">Add Objective</button>
              </div>
              <div class="step-content-body">
                <h3 class="step-content-header">Objectives</h3>
                <div class="list-group" id="objective-contents">
                </div>
              </div>
            </div>
            <div id="step-5" class="">
              <div class="step-prev-contents"></div>
              <br>
              <div>
                <button class="btn btn-primary" onclick="createNewModality()" disabled id="btn-add-modality">Add Modality</button>
              </div>
              <br>
              <div class="step-content-body">
                <h3 class="step-content-header">Modality</h3>
                <div class="list-group" id="modality-contents">
                </div>
              </div>
            </div>
            <div id="step-6" class="">
              <div class="step-prev-contents"></div>
              <br>
              <div>
                <textarea type="text" id="modality-notes" name="" class="form-control" rows="15"></textarea>
              </div>
              <div style="margin-top: 10px;">
                <button class="btn btn-primary" id="btn-add-modality-note" onclick="saveModalityNote(-1)">Add</button>
                <button class="btn btn-danger" id="btn-delete-modality-note" disabled onclick="deleteModalityNote()">Delete</button>
              </div>
              <br>
              <!-- <div class="step-content-body">
                <h3 class="step-content-header">Modality Note</h3>
                <ul class="list-group" id="modality-note-contents">
                </ul>
              </div> -->
            </div>
            <div id="step-7" class="">
              <div class="step-prev-contents"></div>
              <br>
              <div style="margin-bottom: 30px;">
                <button class="btn btn-primary" onclick="createNewDischarge()">Add New Discharge Criteria</button>
              </div>
              <div class="step-content-body">
                <h3 class="step-content-header">Discharge Criteria</h3>
                <ul class="list-group" id="discharge-contents">
                </ul>
              </div>
            </div>
          </div>
      </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="add-modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title"></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="/action_page.php">
          <div class="form-group" id="modal-primary">
            <label class="control-label col-sm-3" for="IsPrimary">Is Primary</label>
            <div class="col-sm-8">
              <input type="number" class="form-control" id="IsPrimary" name="IsPrimary" min="1">
            </div>
          </div>
          <div class="form-group" id='modal-first'>
            <label class="control-label col-sm-3" for="modal-first-select" id="modal-first-label"></label>
            <div class="col-sm-8">
              <select class="form-control" id="modal-first-select">
              </select>
            </div>
          </div>
          <div class="form-group" id='modal-second'>
            <label class="control-label col-sm-3" for="modal-second-select" id="modal-second-label"></label>
            <div class="col-sm-8">
              <select class="form-control" id="modal-second-select">
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-save">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Objective Modal -->
<div class="modal fade" id="objective-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="objective-modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="objective-title"></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="/action_page.php">
          <div class="form-group">
            <label class="control-label col-sm-3" for="objectiveTargetDate">Target Date</label>
            <div class="col-sm-8">
              <input type="date" class="form-control" id="objectiveTargetDate" name="objectiveTargetDate">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="objectiveNoSession">Number of Session</label>
            <div class="col-sm-8">
              <input type="number" class="form-control" id="objectiveNoSession" name="objectiveNoSession" min="0">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="objective-select" id="objective-label"></label>
            <div class="col-sm-8">
              <select class="form-control" id="objective-select">
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveObjective()">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Modality -->
<div class="modal fade" id="modality-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="modality-modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modality-title"></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="/action_page.php">
          <div class="form-group">
            <label class="control-label col-sm-3" for="modalityStartDate">Start Date</label>
            <div class="col-sm-8">
              <input type="date" class="form-control" id="modalityStartDate">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="modalityEndDate">End Date</label>
            <div class="col-sm-8">
              <input type="date" class="form-control" id="modalityEndDate">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="modality-service-select">Service And Code</label>
            <div class="col-sm-8">
              <select class="form-control" id="modality-service-select">
                <option value="-1" disabled selected>Service</option>
                <option>H2019HR - Individual Therapy</option>
                <option>H2017 - PSR</option>
                <option>H2012 - Day Treatment</option>
                <option>H2019HO - TBOSS</option>
                <option>H2019HQ - Group Therapy</option>
                <option>H2000HP - Psych Eval</option>
                <option>H0031HO - In-Depth Assessment - New Patient</option>
                <option>H0031TS - In-Depth Assessment - Established Patient</option>
                <option>H0031HN - Bio-Psychosocial Evaluation</option>
                <option>H0031 - CFARS/FARS</option>
                <option>H0032 - Treatment Plan</option>
                <option>H0032TS - Treatment Plan Review</option>
                <option>T1015 - Med Management</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="modality-interval-select">Interval</label>
            <div class="col-sm-8">
              <select class="form-control" id="modality-interval-select">
                <option value="-1" disabled selected>Interval</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-3" for="modality-frequency-select">Frequency</label>
            <div class="col-sm-8">
              <select class="form-control" id="modality-frequency-select">
                <option value="-1" disabled selected>Frequency</option>
                <option>BiMonthly</option>
                <option>Biweekly</option>
                <option>Daily</option>
                <option>Monthly</option>
                <option>Quaterly</option>
                <option>Weekly</option>
                <option>Yearly</option>
                <option>SemiYearly</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="modality-duration-hour-select">Duration</label>
            <div class="col-sm-4">
              <select class="form-control" id="modality-duration-hour-select">
                <option value="-1" disabled selected>Duration(Hours)</option>
                <option>0</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
              </select>
            </div>
            <div class="col-sm-4">
              <select class="form-control" id="modality-duration-min-select">
                <option value="-1" disabled selected>Duration(Minutes)</option>
                <option value="0">00</option>
                <option>15</option>
                <option>30</option>
                <option>45</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="modalityProvider">Provider</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="modalityProvider">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveModality()">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="discharge-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="discharge-modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="discharge-title"></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="/action_page.php">
          <div class="form-group">
            <label class="control-label col-sm-3" for="discharge-criteria">Discharge Criteria</label>
            <div class="col-sm-8">
              <textarea type="text" class="form-control" id="discharge-criteria" rows="10"></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-save" onclick="saveDischarge()">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal bd-example-modal-lg" id="loading" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 48px">
            <span class="fa fa-spinner fa-spin fa-3x"></span>
        </div>
    </div>
</div>
</body>
</html>
