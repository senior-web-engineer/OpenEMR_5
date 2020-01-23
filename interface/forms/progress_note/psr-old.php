<div id="GroupProblem" class="form-group group">
	<h3>List Specific Treatment Plan Deficit/Problems/Behavior Addressed</h3>
	<?php
			if ($tp_form_id !=''){

			$field ="Description";
			
			$options ="";
						$append = sqlStatement("SELECT pid, form_id, Description, IsDeleted FROM form_treatment_plan_behavioraldefinitions WHERE pid = $pid AND form_id = $tp_form_id AND IsDeleted = '0' ");
						foreach($append as $key => $value){
					   				 $options .= "<br>  <span class='intLink' onclick=\"insertDeficit_problems_behavior_addressed('".$value['Description']."');\"><a>".$value['Description']."</a></span> ";
														}
			if (isset($value['Description'])) {
						echo "<b>Behavior Definition from Treatment Plan:</b>";
						echo $options;
						echo "<br>";
			}

			}
			
			

			?>  

			<br>
	
	<textarea class="form-control validate" wrap=virtual id ="deficit_problems_behavior_addressed" name="deficit_problems_behavior_addressed" style="height: 143px; width: 85%;" required><?php echo stripslashes($obj{"deficit_problems_behavior_addressed"});?></textarea><br>
</div>
<div id="GroupIntervention" class="form-group group">
	<h3>Intervention</h3>	
	<textarea class="form-control validate" wrap=virtual id="interventions" name="interventions" style="height: 137px; width: 85%;" required><?php echo stripslashes($obj{"interventions"});?></textarea><br><br>
<div id="GroupResponse" class="form-group group">
	<h3>Response to Intervention</h3>	
	<textarea name="response_to_intervention" id="response_to_intervention" class="form-control" cols="40" rows="10" required><?php echo stripslashes($obj{"response_to_intervention"});?></textarea>
</div>
<script language="javascript">
function insertDeficit_problems_behavior_addressed(sStartTag, sEndTag) {//Field Name
  var bDouble = arguments.length > 1, 
  oMsgInput = document.SigForm.deficit_problems_behavior_addressed, //Field Mame
  nSelStart = oMsgInput.selectionStart, 
  nSelEnd = oMsgInput.selectionEnd, 
  sOldText = oMsgInput.value;
  oMsgInput.value = sOldText.substring(0, nSelStart) + (bDouble ? sStartTag + sOldText.substring(nSelStart, 
  nSelEnd) + sEndTag : sStartTag) + sOldText.substring(nSelEnd);
  oMsgInput.setSelectionRange(bDouble || nSelStart === nSelEnd ? nSelStart + sStartTag.length : nSelStart,
  (bDouble ? nSelEnd : nSelStart) + sStartTag.length);
  oMsgInput.focus();
}

$(document).ready(function(){
    $("#status").click(function() {
      $("[required]").each(function() {
      		var el = $(this);
             if((el.val() == "") || ($("#units").val() == '')|| ($("#time_start").val() == '')
             || ($("#time_end").val() == '')
             || ($("#clinical_intervention").val() == '')
             || ($("#response_to_intervention").val() == '')|| ($("#service_code").val() == '')
             || ($("#service_code").val() == 'TBD')
             || ($("#diagnosis1").val() == '')|| ($("#provider_print_name").val() == '') 
             || ($("#provider_credentials").val() == '')|| ($("#provider_signature_date").val() == '')	
             || ($("#provider_signature_date").val() == '0000-00-00')
			 || ($("#insurance_warning:contains('Alert!')").length > 0) )
             	{
             $("select").find("option[value*='Ready for']").attr("disabled", true);
	             var vals = $('.validate').val()
				     if (!vals) 
				        {
				          console.log('Error exists');
				          $('.validate').css({ "border": '#FF0000 1px solid'});
				          //$('.validate').val('enter a value');
				        }   
    			}else{
      		 $("select").find("option[value*='Ready for']").attr("disabled", false);	
    			}
    			});
    			
    });
});
</script>
