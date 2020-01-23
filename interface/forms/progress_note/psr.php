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
<div id="GroupTopic" class="form-group group">
	<h3>Topic</h3>
	Click on a topic to select:	
		<table style="width: 100%">
			<tr>
				<td>
						
					<span class="intLink" onclick="insertTopic('Medication Management. ');"><a>1-Medication Management.</a><br></span> 
					<span class="intLink" onclick="insertTopic('Social/Daily Living Skills. ');"><a>2-Social/Daily Living Skills.</a><br></span>
					<span class="intLink" onclick="insertTopic('Emotions Management. ');"><a>3-Emotions Management.</a><br></span>
					<span class="intLink" onclick="insertTopic('Grief/Trauma. ');"><a>4-Grief/Trauma: </a><br></span>
					<span class="intLink" onclick="insertTopic('Following Instruction.');"><a>5-Following Instruction</a><br></span>  
					<span class="intLink" onclick="insertTopic('Anger Management. ');"><a>6-Anger Management </a><br></span> 
					<span class="intLink" onclick="insertTopic('Communication Skills. ');"><a>7-Communication Skills</a><br></span> 
					<span class="intLink" onclick="insertTopic('Wellness/Relaxation Techniques. ');"><a>8-Wellness/Relaxation Techniques </a><br></span> 
		
				</td>
			
				<td>
					<span class="intLink" onclick="insertTopic('Addiction/Co-occurring Disorder Education/Relapse. ');"><a>9-Addiction/Co-occurring Disorder Education/Relapse </a><br></span> 
					<span class="intLink" onclick="insertTopic('Drug Prevention. ');"><a>10-Drug Prevention</a></span><br> 
					<span class="intLink" onclick="insertTopic('Decision Making/Problem-solving Skills. ');"><a>11-Decision Making/Problem-solving Skills </a><br></span> 
					<span class="intLink" onclick="insertTopic('Sex Education/Relationships. ');"><a>12-Sex Education/Relationships </a><br></span> 
					<span class="intLink" onclick="insertTopic('Hygiene/Nutrition. ');"><a>13-Hygiene/Nutrition </a></span><br>
					<span class="intLink" onclick="insertTopic('Bullying. ');"><a>14-Bullying </a><br></span> 
					<span class="intLink" onclick="insertTopic('Self-esteem. ');"><a>15-Self-esteem: </a><br></span> 
					<span class="intLink" onclick="insertTopic('Other: ');"><a>16-Other:(Specify) </a><br></span>
				</td>
			</tr>
		</table>
	<br>

	<textarea class="form-control validate" wrap=virtual id="topic" name="topic" style="height: 137px; width: 85%;" ><?php echo stripslashes($obj{"topic"});?></textarea><br><br>

<div id="GroupIntervention" class="form-group group">
	<h3>Intervention</h3>
	Click on an Intervention to select, then give a description of the acitvity:	
		<table style="width: 100%">
			<tr>
				<td>
						
					<span class="intLink" onclick="insertInterventions('Educating: ');"><a>1-Educating</a><br></span> 
					<span class="intLink" onclick="insertInterventions('Prompting: ');"><a>2-Prompting</a><br></span>
					<span class="intLink" onclick="insertInterventions('Redirecting: ');"><a>3-Redirecting</a><br></span>
					<span class="intLink" onclick="insertInterventions('Reframing: ');"><a>4-Reframing </a><br></span>
					<span class="intLink" onclick="insertInterventions('Interpretation: ');"><a>5-Interpretation</a><br></span>  
					<span class="intLink" onclick="insertInterventions('Reinforcement: ');"><a>6-Reinforcement</a> <br></span> 
					<span class="intLink" onclick="insertInterventions('Encouragement: ');"><a>7-Encouragement</a><br></span> 
					
		
				</td>
			
				<td>
					<span class="intLink" onclick="insertInterventions('Validating ');"><a>8-Validating </a><br></span> 
					<span class="intLink" onclick="insertInterventions('Praising: ');"><a>9-Praising </a><br></span> 
					<span class="intLink" onclick="insertInterventions('Reassuring: ');"><a>10-Reassuring</a></span><br> 
					<span class="intLink" onclick="insertInterventions('Modeling/Role playing: ');"><a>11-Modeling/Role playing </a><br></span> 
					<span class="intLink" onclick="insertInterventions('Supporting: ');"><a>12-Supporting </a><br></span> 
					<span class="intLink" onclick="insertInterventions('Other:(Specify) ');"><a>13-Other:(Specify) </a></span><br>
					
				</td>
			</tr>
		</table>
	<br>
	
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
function insertTopic(sStartTag, sEndTag) {//Field Name
  var bDouble = arguments.length > 1, 
  oMsgInput = document.SigForm.topic, //Field Mame
  nSelStart = oMsgInput.selectionStart, 
  nSelEnd = oMsgInput.selectionEnd, 
  sOldText = oMsgInput.value;
  oMsgInput.value = sOldText.substring(0, nSelStart) + (bDouble ? sStartTag + sOldText.substring(nSelStart, 
  nSelEnd) + sEndTag : sStartTag) + sOldText.substring(nSelEnd);
  oMsgInput.setSelectionRange(bDouble || nSelStart === nSelEnd ? nSelStart + sStartTag.length : nSelStart,
  (bDouble ? nSelEnd : nSelStart) + sStartTag.length);
  oMsgInput.focus();
}
function insertInterventions(sStartTag, sEndTag) {//Field Name
  var bDouble = arguments.length > 1, 
  oMsgInput = document.SigForm.interventions, //Field Mame
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
<?php
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
   $browser = 'Internet explorer';
   //echo $browser;
 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
   $browser = 'Internet explorer';
 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
   $browser = 'Mozilla Firefox';
 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
   $browser = 'Google Chrome';
 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
  $browser = "Opera Mini";
 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
   $browser = "Opera";
 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
   $browser = "Safari";
 else
   $browser = 'Something else';
  
?>
<input type ="hidden" name="browser" value="<?php echo $browser;?>">

