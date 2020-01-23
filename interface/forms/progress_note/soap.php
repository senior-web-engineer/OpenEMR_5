<div id="soap">
	<div id="GroupTG" class="form-group group">
		<div id="GroupA" class="form-group group">
			<h3>Goal:</h3>
			<?php
			if ($tp_form_id !=''){
			$field ="Description";
			$options ="";
						$append = sqlStatement("SELECT pid, form_id, Description, IsDeleted FROM form_treatment_plan_goals WHERE pid = $pid AND form_id = $tp_form_id AND IsDeleted = '0' ");
						foreach($append as $key => $value){
					   				 $options .= "<br>  <span class='intLink' onclick=\"insertGoal('".$value['Description']."');\"><a>".$value['Description']."</a></span> ";
														}
			if (isset($value['Description'])) {
						echo "<b>Click on Goal(s) from Treatment Plan to select:</b>";
						echo $options;
						echo "<br>";
			}
			}
			
			

			?>  
			<br>
			<textarea name="goal" class="form-control validate" cols="40" style="height: 73px" required><?php echo stripslashes($obj{"goal"});?></textarea>
		</div>
		<div id="GroupA" class="form-group group">
			<h3>Subjective:</h3>
			<textarea name="subjective" id="subjective" class="form-control" cols="40" rows="10" required><?php echo stripslashes($obj{"subjective"});?></textarea>
		</div>
		<div id="GroupB" class="form-group group">
			<h3>Objective:</h3>
			<textarea name="objective" id="objective" class="form-control" cols="40" rows="10" required><?php echo stripslashes($obj{"objective"});?></textarea>
		</div>
		<div id="GroupC" class="form-group group">
			<h3>Assessment:</h3>
			<textarea name="assessment" id="assessment" class="form-control" cols="40" rows="10" required><?php echo stripslashes($obj{"assessment"});?></textarea>
		</div>
		<div id="GroupD" class="form-group group">
			<h3>Plan:</h3>
			<textarea name="plan" id="plan" class="form-control" cols="40" rows="10" required><?php echo stripslashes($obj{"plan"});?></textarea>
		</div>
</div>
	
<script language="javascript">
function insertGoal(sStartTag, sEndTag) {//Field Name
  var bDouble = arguments.length > 1, 
  oMsgInput = document.SigForm.goal, //Field Name
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
             || ($("#time_end").val() == '')|| ($("#service_code").val() == '')
             || ($("#service_code").val() == 'TBD')
             || ($("#txgoals").val() == '')|| ($("#subjective").val() == '')
             || ($("#objective").val() == '')
             || ($("#assessment").val() == '')|| ($("#plan").val() == '')|| ($("#diagnosis1").val() == '') 
             || ($("#provider_print_name").val() == '')|| ($("#provider_credentials").val() == '')	
             || ($("#provider_signature_date").val() == '')|| ($("#provider_signature_date").val() == '0000-00-00')
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
if ($current_user != $form_user && $current_user_rights != 'reviewer' 
	|| ($form_status == 'Ready for Billing/Supervisor') ||($form_status == 'Ready for Billing'))
		{
	?>
	<script language="javascript">
		$(document).ready(function(){
			$("#form :input").attr("readonly", true);
			$('input[type="text"], textarea').attr("readonly", true);
			$("select").css('pointer-events','none'); 
			$("#img_provider_signature_date").css('pointer-events','none');
			$("#img_supervisor_signature_date").css('pointer-events','none');
			$("#cancel1").attr("disabled", false);
			$("#cancel2").attr("disabled", false);
			$("#activate").attr("disabled", false);
			$("#draft").prop("disabled", false);
			
			});

			$("#activate").change(function() {
			 if(this.checked) {
						$("#form :input").attr("readonly", false);
						$('input[type="text"], textarea').attr("readonly", false);
						$("select").css('pointer-events','auto'); 
						$("#img_provider_signature_date").css('pointer-events','auto');
						$("#img_supervisor_signature_date").css('pointer-events','auto');
						$("#cancel1").attr("disabled", false);
						$("#cancel2").attr("disabled", false);
						$("#activate").attr("disabled", false);
						$("#draft").attr("disabled", false);
					} else {
						$("#form :input").attr("readonly", true);
						$('input[type="text"], textarea').attr("readonly", true);
						$("select").css('pointer-events','none'); 
						$("#img_provider_signature_date").css('pointer-events','none');
						$("#img_supervisor_signature_date").css('pointer-events','none');
						$("#cancel1").attr("disabled", false);
						$("#cancel2").attr("disabled", false);
						$("#activate").attr("disabled", false);
						$("#draft").attr("disabled", false);
							}
			});
	</script>
<?php
}
?>


