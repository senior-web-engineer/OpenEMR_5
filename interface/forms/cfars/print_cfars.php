<!-- Info Header -->
<div class="header">
	<div class="info">
<!-- FACILITY Info -->
		<?php 
		$facility = sqlQuery("SELECT name,phone,fax,street,city,state,postal_code FROM facility WHERE facility_code = 'Print'");
		?>
		<div class="facility-info">
		<?php echo $facility['name']?><br>
		<?php echo $facility['street']?><br>
		<?php echo $facility['city']?>, <?php echo $facility['state']?> <?php echo $facility['postal_code']?><br>
		Tel: <?php echo $facility['phone']?> | Fax: <?php echo $facility['fax']?>
		</div>				
<!-- Form Info -->
		<div class="form-info">
			<span>Client Name:</span><?php echo $result['fname'] . '&nbsp' . $result['mname'] . '&nbsp;' . $result['lname'];?>
			<span>DOB:</span><?php echo $result['DOB'];?><br>
			<span>SS#:</span><?php echo $result['ss'];?>
			<span>Plan Date:</span><?php echo substr($dos["date"], 0, 10); ?><br>
<!--			<span>INSURANCE:</span><?php echo substr($ins["plan_name"], 0, 10) . '&nbsp;' . substr($ins["provider"], 0, 10); ?><br>-->
			<span>Age:</span><?php echo $result['age'];?>
			<span>Sex:</span><?php echo $result['sex'];?><br>
			<span>Admission Date:</span><?php echo stripslashes($obj{"admit_date"});?>
			<span>Therapist:</span><?php echo $_SESSION['date'] ?><?php echo stripslashes($obj{"provider"});?><br>
			<span>Time Started:</span><?php echo stripslashes($obj{"timestart"});?>
			<span>End Time:</span><?php echo stripslashes($obj{"timeend"});?><br>
		</div>
		<br class="clr">
	</div>
	<br class="clr">
	<h1>CFARS</h1>
</div>

	
	<div id="form_container" class="WarpShadow WLarge WNormal">

							
	<ul >
		<li id="li_1"  >
			<label class="description">DCF Outcomes Report <span id="required_1" class="required">*</span></label>
			<div>
				<select class="element select medium" id="dcf_outcomes_report" name="dcf_outcomes_report"> 
					<option selected=""><?php echo stripslashes($obj{"dcf_outcomes_report"});?></option>
					<option value="Admission to Provider" > Admission to Provider</option>
					<option value="Post Admission Evaluation(e.g., six months, annual, etc.)"> Post Admission Evaluation(e.g., six months, annual, etc.)</option>
					<option value="Discharge from Provider"> Discharge from Provider</option>
					<option value="Administrative/Immediate Discharge"> Administrative/Immediate Discharge</option>
					<option value="None of the Above"> None of the Above</option>
				</select>
			</div> 
		</li>		
		<li id="li_2"  >
			<label class="description">Program Evaluation (optional) <span id="required_1" class="required">*</span></label>
			<div>
				<select class="element select medium" id="program_evaluation" name="program_evaluation"> 
					<option selected=""><?php echo stripslashes($obj{"program_evaluation"});?></option>
					<option value="Admission to Program" > Admission to Program</option>
					<option value="6 Months After Admission to Program"> 6 Months After Admission to Program</option>
					<option value="Annually After Admission to Program"> Annually After Admission to Programr</option>
					<option value="Planned Discharge from, or Transfer to another Program within agency"> Planned Discharge from, or Transfer to another Program within agency</option>
					<option value="Administrative/Immediate Discharge">Administrative/Immediate Discharge</option>
					<option value="None of the above">None of the above</option>
				</select>
			</div> 
		</li>		
		<li id="li_3"  >
			<label class="description" for="primary_diagnosis">DSM-IV Code for Primary Diagnosis: </label>
			<div>
            <p><?php echo stripslashes($obj{"primary_diagnosis"});?></p>    
			<!--<input id="primary_diagnosis" name="primary_diagnosis" type="text"  value="<?php echo stripslashes($obj{"primary_diagnosis"});?>"/>-->
			</div> 
		</li>		
		<li id="li_4"  >
			<label class="description" for="secondary_diagnosis">DSM-IV Code for Secondary Diagnosis: </label>
			<div>
			<p><?php echo stripslashes($obj{"secondary_diagnosis"});?></p>    
			<!--<input id="secondary_diagnosis" name="secondary_diagnosis" type="text"  value="<?php echo stripslashes($obj{"secondary_diagnosis"});?>"/>-->
			</div> 
		</li>		
		<li id="li_5"  >
			<label class="description" for="substance_abuse_history">Substance Abuse History </label>
			<div>
				<select class="element select medium" id="substance_abuse_history" name="substance_abuse_history"> 
					<option selected=""><?php echo stripslashes($obj{"substance_abuse_history"});?></option>
					<option value="YES"  >YES</option>
					<option value="NO"  >NO</option>
				</select>
			</div> 
		</li>
		<li id="li_6" >
			<label class="description" for="cfars_rater_notes">CFARS Rater's Notes (Optional): </label>
			<div>
				<textarea id="cfars_rater_notes" name="cfars_rater_notes" class="element textarea medium" rows="8" cols="90" onkeyup="limit_input(6,'c',250);" onchange="limit_input(6,'c',250);"><?php echo stripslashes($obj{"cfars_rater_notes"});?></textarea>
				<label for="cfars_rater_notes">Maximum of <var id="range_max_6">250</var> characters allowed.</label></div> 
		</li>		
		<li id="li_7" class="section_break">
			<h3>CFARS Problem Severity Ratings</h3>
		</li>		
		<li id="li_8" class="section_break">
			<h3>Depression</h3>
			<label class="description" for="depression">Rating 
			<span id="required_12" class="required">*</span></label>
			<div>
				<select class="element select small" id="depression" name="depression">
				<option selected=""><?php echo stripslashes($obj{"depression"});?></option>
				<option value="1"  >1 = No Problem</option>
				<option value="2"  >2 = Less than Slight</option>
				<option value="3"  >3 = Slight Problem</option>
				<option value="4"  >4 = Slight to Moderate</option>
				<option value="5"  >5 = Moderate Problem</option>
				<option value="6"  >6 = Moderate to Severe</option>
				<option value="7"  >7 = Severe Problem</option>
				<option value="8"  >8 = Severe to Extreme</option>
				<option value="9"  >9 = Extreme Problem</option>
				</select>
			</div>
			<label class="description">Symptoms/Assets </label>
			<div>
				<span><input id="depression_1"  name="depression_1" class="element checkbox" type="checkbox" <?php if ($obj{"depression_1"} == "on") {echo "checked";};?>  /><label class="choice" for="depression_1">Depressed Mood</label></span>
				<span><input id="depression_2"  name="depression_2" class="element checkbox" type="checkbox" <?php if ($obj{"depression_2"} == "on") {echo "checked";};?>  /><label class="choice" for="depression_2">Happy</label></span>
				<span><input id="depression_3"  name="depression_3" class="element checkbox" type="checkbox" <?php if ($obj{"depression_3"} == "on") {echo "checked";};?> /><label class="choice" for="depression_3">Sleep Problems</label></span>
				<span><input id="depression_4"  name="depression_4" class="element checkbox" type="checkbox" <?php if ($obj{"depression_4"} == "on") {echo "checked";};?> /><label class="choice" for="depression_4">Sad</label></span>
				<span><input id="depression_5"  name="depression_5" class="element checkbox" type="checkbox" <?php if ($obj{"depression_5"} == "on") {echo "checked";};?>  /><label class="choice" for="depression_5">Hopeless</label></span>
				<span><input id="depression_6"  name="depression_6" class="element checkbox" type="checkbox" <?php if ($obj{"depression_6"} == "on") {echo "checked";};?>  /><label class="choice" for="depression_6">Laks Energy/Interst</label></span>
				<span><input id="depression_7"  name="depression_7" class="element checkbox" type="checkbox" <?php if ($obj{"depression_7"} == "on") {echo "checked";};?>  /><label class="choice" for="depression_7">Irritable</label></span>
				<span><input id="depression_8"  name="depression_8" class="element checkbox" type="checkbox" <?php if ($obj{"depression_8"} == "on") {echo "checked";};?>  /><label class="choice" for="depression_8">Withdrawn</label></span>
				<span><input id="depression_9"  name="depression_9" class="element checkbox" type="checkbox" <?php if ($obj{"depression_9"} == "on") {echo "checked";};?>  /><label class="choice" for="depression_9">Anti-Depression Meds</label></span>
			</div>
		</li>		
		<li id="li_11" class="section_break">
			<h3>Anxiety</h3>
			<label class="description" for="anxiety">Rating 
			<span id="required_9" class="required">*</span></label>
			<div>
				<select class="element select small" id="anxiety" name="anxiety">
				<option selected=""><?php echo stripslashes($obj{"anxiety"});?></option>
				<option value="1"  >1 = No Problem</option>
				<option value="2"  >2 = Less than Slight</option>
				<option value="3"  >3 = Slight Problem</option>
				<option value="4"  >4 = Slight to Moderate</option>
				<option value="5"  >5 = Moderate Problem</option>
				<option value="6"  >6 = Moderate to Severe</option>
				<option value="7"  >7 = Severe Problem</option>
				<option value="8"  >8 = Severe to Extreme</option>
				<option value="9"  >9 = Extreme Problem</option>
				</select>
			</div>
			<label class="description">Symptoms/Assets </label>
			<div>
				<span><input id="anxiety_1"  name="anxiety_1" class="element checkbox" type="checkbox" <?php if ($obj{"anxiety_1"} == "on") {echo "checked";};?>  /><label class="choice" for="anxiety_1">Anxious/Tense</label></span>
				<span><input id="anxiety_2"  name="anxiety_2" class="element checkbox" type="checkbox" <?php if ($obj{"anxiety_2"} == "on") {echo "checked";};?> /><label class="choice" for="anxiety_2">Calm</label></span>
				<span><input id="anxiety_3"  name="anxiety_3" class="element checkbox" type="checkbox" <?php if ($obj{"anxiety_3"} == "on") {echo "checked";};?> /><label class="choice" for="anxiety_3">Guilt</label></span>
				<span><input id="anxiety_4"  name="anxiety_4" class="element checkbox" type="checkbox" <?php if ($obj{"anxiety_4"} == "on") {echo "checked";};?> /><label class="choice" for="anxiety_4">Phobic</label></span>
				<span><input id="anxiety_5"  name="anxiety_5" class="element checkbox" type="checkbox" <?php if ($obj{"anxiety_5"} == "on") {echo "checked";};?> /><label class="choice" for="anxiety_5">Worried/Fearful</label></span>
				<span><input id="anxiety_6"  name="anxiety_6" class="element checkbox" type="checkbox" <?php if ($obj{"anxiety_6"} == "on") {echo "checked";};?> /><label class="choice" for="anxiety_6">Ant-Anxiety Meds</label></span>
				<span><input id="anxiety_7"  name="anxiety_7" class="element checkbox" type="checkbox" <?php if ($obj{"anxiety_7"} == "on") {echo "checked";};?> /><label class="choice" for="anxiety_7">Obsessive/Compulsive</label></span>
				<span><input id="anxiety_8"  name="anxiety_8" class="element checkbox" type="checkbox" <?php if ($obj{"anxiety_8"} == "on") {echo "checked";};?> /><label class="choice" for="anxiety_8">Panic</label></span>
			</div>
		</li>		
		<li id="li_15" class="section_break">
			<h3>Hyperactivity</h3>
			<label class="description" for="hyperactivity">Rating 
			<span id="required_19" class="required">*</span></label>
			<div>
				<select class="element select small" id="hyperactivity" name="hyperactivity">
				<option selected=""><?php echo stripslashes($obj{"hyperactivity"});?></option>
				<option value="1"  >1 = No Problem</option>
				<option value="2"  >2 = Less than Slight</option>
				<option value="3"  >3 = Slight Problem</option>
				<option value="4"  >4 = Slight to Moderate</option>
				<option value="5"  >5 = Moderate Problem</option>
				<option value="6"  >6 = Moderate to Severe</option>
				<option value="7"  >7 = Severe Problem</option>
				<option value="8"  >8 = Severe to Extreme</option>
				<option value="9"  >9 = Extreme Problem</option>
				</select>
			</div>
			<label class="description">Symptoms/Assets </label>
			<div>
				<span><input id="hyperactivity_1"  name="hyperactivity_1" class="element checkbox" type="checkbox" <?php if ($obj{"hyperactivity_1"} == "on") {echo "checked";};?>  /><label class="choice" for="hyperactivity_1">Manic</label></span>
				<span><input id="hyperactivity_2"  name="hyperactivity_2" class="element checkbox" type="checkbox" <?php if ($obj{"hyperactivity_2"} == "on") {echo "checked";};?>  /><label class="choice" for="hyperactivity_2">Inattentive</label></span>
				<span><input id="hyperactivity_3"  name="hyperactivity_3" class="element checkbox" type="checkbox" <?php if ($obj{"hyperactivity_3"} == "on") {echo "checked";};?>  /><label class="choice" for="hyperactivity_3">Agitated</label></span>
				<span><input id="hyperactivity_4"  name="hyperactivity_4" class="element checkbox" type="checkbox" <?php if ($obj{"hyperactivity_4"} == "on") {echo "checked";};?>  /><label class="choice" for="hyperactivity_4">Sleep Deficit</label></span>
				<span><input id="hyperactivity_5"  name="hyperactivity_5" class="element checkbox" type="checkbox" <?php if ($obj{"hyperactivity_5"} == "on") {echo "checked";};?>  /><label class="choice" for="hyperactivity_5">Overactive/Hyperactive</label></span>
				<span><input id="hyperactivity_6"  name="hyperactivity_6" class="element checkbox" type="checkbox" <?php if ($obj{"hyperactivity_6"} == "on") {echo "checked";};?>  /><label class="choice" for="hyperactivity_6">Mood Swings</label></span>
				<span><input id="hyperactivity_7"  name="hyperactivity_7" class="element checkbox" type="checkbox" <?php if ($obj{"hyperactivity_7"} == "on") {echo "checked";};?>  /><label class="choice" for="hyperactivity_7">Pressured Speech</label></span>
				<span><input id="hyperactivity_8"  name="hyperactivity_8" class="element checkbox" type="checkbox" <?php if ($obj{"hyperactivity_8"} == "on") {echo "checked";};?>  /><label class="choice" for="hyperactivity_8">Relaxed</label></span>
				<span><input id="hyperactivity_9"  name="hyperactivity_9" class="element checkbox" type="checkbox" <?php if ($obj{"hyperactivity_9"} == "on") {echo "checked";};?>  /><label class="choice" for="hyperactivity_9">Impulsivity</label></span>
				<span><input id="hyperactivity_10"  name="hyperactivity_10" class="element checkbox" type="checkbox" <?php if ($obj{"hyperactivity_10"} == "on") {echo "checked";};?>  /><label class="choice" for="hyperactivity_10">ADHD Meds</label></span>
				<span><input id="hyperactivity_11"  name="hyperactivity_11" class="element checkbox" type="checkbox" <?php if ($obj{"hyperactivity_11"} == "on") {echo "checked";};?>  /><label class="choice" for="hyperactivity_11">Anti-Manic Meds</label></span>
			</div>
		</li>		
		<li id="li_21" class="section_break">
			<h3>Thought Process</h3>
			<label class="description" for="thought_process"">Rating 
			<span id="required_22" class="required">*</span></label>
			<div>
				<select class="element select small" id="thought_process" name="thought_process">
				<option selected=""><?php echo stripslashes($obj{"thought_process"});?></option>
				<option value="1"  >1 = No Problem</option>
				<option value="2"  >2 = Less than Slight</option>
				<option value="3"  >3 = Slight Problem</option>
				<option value="4"  >4 = Slight to Moderate</option>
				<option value="5"  >5 = Moderate Problem</option>
				<option value="6"  >6 = Moderate to Severe</option>
				<option value="7"  >7 = Severe Problem</option>
				<option value="8"  >8 = Severe to Extreme</option>
				<option value="9"  >9 = Extreme Problem</option>
				</select>
			</div>
			<label class="description">Symptoms/Assets </label>
			<div>
				<span><input id="thought_process_1"  name="thought_process_1" class="element checkbox" type="checkbox" <?php if ($obj{"thought_process_1"} == "on") {echo "checked";};?>  /><label class="choice" for="thought_process_1">Illogical</label></span>
				<span><input id="thought_process_2"  name="thought_process_2" class="element checkbox" type="checkbox" <?php if ($obj{"thought_process_2"} == "on") {echo "checked";};?>  /><label class="choice" for="thought_process_2">Delusional</label></span>
				<span><input id="thought_process_3"  name="thought_process_3" class="element checkbox" type="checkbox" <?php if ($obj{"thought_process_3"} == "on") {echo "checked";};?>  /><label class="choice" for="thought_process_3">Hallucinations</label></span>
				<span><input id="thought_process_4"  name="thought_process_4" class="element checkbox" type="checkbox" <?php if ($obj{"thought_process_4"} == "on") {echo "checked";};?>  /><label class="choice" for="thought_process_4">Paranoid</label></span>
				<span><input id="thought_process_5"  name="thought_process_5" class="element checkbox" type="checkbox" <?php if ($obj{"thought_process_5"} == "on") {echo "checked";};?>  /><label class="choice" for="thought_process_5">Ruminative</label></span>
				<span><input id="thought_process_6"  name="thought_process_6" class="element checkbox" type="checkbox" <?php if ($obj{"thought_process_6"} == "on") {echo "checked";};?>  /><label class="choice" for="thought_process_6">Command Hallucination</label></span>
				<span><input id="thought_process_7"  name="thought_process_7" class="element checkbox" type="checkbox" <?php if ($obj{"thought_process_7"} == "on") {echo "checked";};?>  /><label class="choice" for="thought_process_7">Derailed Thinking</label></span>
				<span><input id="thought_process_8"  name="thought_process_8" class="element checkbox" type="checkbox" <?php if ($obj{"thought_process_8"} == "on") {echo "checked";};?>  /><label class="choice" for="thought_process_8">Loose Associations</label></span>
				<span><input id="thought_process_9"  name="thought_process_9" class="element checkbox" type="checkbox" <?php if ($obj{"thought_process_9"} == "on") {echo "checked";};?>  /><label class="choice" for="thought_process_9">Intact</label></span>
				<span><input id="thought_process_10"  name="thought_process_10" class="element checkbox" type="checkbox" <?php if ($obj{"thought_process_10"} == "on") {echo "checked";};?>  /><label class="choice" for="thought_process_10">Oriented</label></span>
				<span><input id="thought_process_11"  name="thought_process_11" class="element checkbox" type="checkbox" <?php if ($obj{"thought_process_11"} == "on") {echo "checked";};?>  /><label class="choice" for="thought_process_11">Disoriented</label></span>
				<span><input id="thought_process_12"  name="thought_process_12" class="element checkbox" type="checkbox" <?php if ($obj{"thought_process_12"} == "on") {echo "checked";};?>  /><label class="choice" for="thought_process_12">Anti-Psych. Med.</label></span>
			</div>
		</li>		
		<li id="li_24" class="section_break">
			<h3>Cognitive Performance</h3>
			<label class="description" for="cognitive_performance">Rating 
			<span id="required_25" class="required">*</span></label>
			<div>
				<select class="element select small" id="cognitive_performance" name="cognitive_performance">
				<option selected=""><?php echo stripslashes($obj{"cognitive_performance"});?></option>
				<option value="1"  >1 = No Problem</option>
				<option value="2"  >2 = Less than Slight</option>
				<option value="3"  >3 = Slight Problem</option>
				<option value="4"  >4 = Slight to Moderate</option>
				<option value="5"  >5 = Moderate Problem</option>
				<option value="6"  >6 = Moderate to Severe</option>
				<option value="7"  >7 = Severe Problem</option>
				<option value="8"  >8 = Severe to Extreme</option>
				<option value="9"  >9 = Extreme Problem</option>
				</select>
			</div>
			<label class="description">Symptoms/Assets</label>
			<div>
				<span><input id="cognitive_performance_1"  name="cognitive_performance_1" class="element checkbox" type="checkbox" <?php if ($obj{"cognitive_performance_1"} == "on") {echo "checked";};?>  /><label class="choice" for="cognitive_performance_1">Poor Memory</label></span>
				<span><input id="cognitive_performance_2"  name="cognitive_performance_2" class="element checkbox" type="checkbox" <?php if ($obj{"cognitive_performance_2"} == "on") {echo "checked";};?>  /><label class="choice" for="cognitive_performance_2">Low Self-Awareness</label></span>
				<span><input id="cognitive_performance_3"  name="cognitive_performance_3" class="element checkbox" type="checkbox" <?php if ($obj{"cognitive_performance_3"} == "on") {echo "checked";};?>  /><label class="choice" for="cognitive_performance_3">Poor Attention/ Concentration</label></span>
				<span><input id="cognitive_performance_4"  name="cognitive_performance_4" class="element checkbox" type="checkbox" <?php if ($obj{"cognitive_performance_4"} == "on") {echo "checked";};?>  /><label class="choice" for="cognitive_performance_4">Development Disability</label></span>
				<span><input id="cognitive_performance_5"  name="cognitive_performance_5" class="element checkbox" type="checkbox" <?php if ($obj{"cognitive_performance_5"} == "on") {echo "checked";};?>  /><label class="choice" for="cognitive_performance_5">Insightful</label></span>
				<span><input id="cognitive_performance_6"  name="cognitive_performance_6" class="element checkbox" type="checkbox" <?php if ($obj{"cognitive_performance_6"} == "on") {echo "checked";};?>  /><label class="choice" for="cognitive_performance_6">Concrete Thinking</label></span>
				<span><input id="cognitive_performance_7"  name="cognitive_performance_7" class="element checkbox" type="checkbox" <?php if ($obj{"cognitive_performance_7"} == "on") {echo "checked";};?>  /><label class="choice" for="cognitive_performance_7">Impaired Judgment</label></span>
				<span><input id="cognitive_performance_8"  name="cognitive_performance_8" class="element checkbox" type="checkbox" <?php if ($obj{"cognitive_performance_8"} == "on") {echo "checked";};?>  /><label class="choice" for="cognitive_performance_8">Slow Processing</label></span>
			</div>
		</li>		
		<li id="li_28" class="section_break">
			<h3>Medical / Physical</h3>
			<label class="description" for="medical_physical">Rating 
			<span id="required_27" class="required">*</span></label>
			<div>
				<select class="element select small" id="medical_physical" name="medical_physical">
				<option selected="" ><?php echo stripslashes($obj{"medical_physical"});?></option>
				<option value="1"  >1 = No Problem</option>
				<option value="2"  >2 = Less than Slight</option>
				<option value="3"  >3 = Slight Problem</option>
				<option value="4"  >4 = Slight to Moderate</option>
				<option value="5"  >5 = Moderate Problem</option>
				<option value="6"  >6 = Moderate to Severe</option>
				<option value="7"  >7 = Severe Problem</option>
				<option value="8"  >8 = Severe to Extreme</option>
				<option value="9"  >9 = Extreme Problem</option>
				</select>
			</div>
			<label class="description">Symptoms/Assets </label>
			<div>
				<span><input id="medical_physical_1"  name="medical_physical_1" class="element checkbox" type="checkbox" <?php if ($obj{"medical_physical_1"} == "on") {echo "checked";};?>  /><label class="choice" for="medical_physical_1">Acute Illness</label></span>
				<span><input id="medical_physical_2"  name="medical_physical_2" class="element checkbox" type="checkbox" <?php if ($obj{"medical_physical_2"} == "on") {echo "checked";};?>  /><label class="choice" for="medical_physical_2">Hypochondria</label></span>
				<span><input id="medical_physical_3"  name="medical_physical_3" class="element checkbox" type="checkbox" <?php if ($obj{"medical_physical_3"} == "on") {echo "checked";};?>  /><label class="choice" for="medical_physical_3">Good Health</label></span>
				<span><input id="medical_physical_4"  name="medical_physical_4" class="element checkbox" type="checkbox" <?php if ($obj{"medical_physical_4"} == "on") {echo "checked";};?>  /><label class="choice" for="medical_physical_4">CNS Disorder</label></span>
				<span><input id="medical_physical_5"  name="medical_physical_5" class="element checkbox" type="checkbox" <?php if ($obj{"medical_physical_5"} == "on") {echo "checked";};?>  /><label class="choice" for="medical_physical_5">Chronic Illness</label></span>
				<span><input id="medical_physical_6"  name="medical_physical_6" class="element checkbox" type="checkbox" <?php if ($obj{"medical_physical_6"} == "on") {echo "checked";};?>  /><label class="choice" for="medical_physical_6">Need. Med/Dental Care</label></span>
				<span><input id="medical_physical_7"  name="medical_physical_7" class="element checkbox" type="checkbox" <?php if ($obj{"medical_physical_7"} == "on") {echo "checked";};?>  /><label class="choice" for="medical_physical_7">Pregnant</label></span>
				<span><input id="medical_physical_8"  name="medical_physical_8" class="element checkbox" type="checkbox" <?php if ($obj{"medical_physical_8"} == "on") {echo "checked";};?>  /><label class="choice" for="medical_physical_8">Poor Nutrition</label></span>
				<span><input id="medical_physical_9"  name="medical_physical_9" class="element checkbox" type="checkbox" <?php if ($obj{"medical_physical_9"} == "on") {echo "checked";};?>  /><label class="choice" for="medical_physical_9">Enuretic/Encopretic</label></span>
				<span><input id="medical_physical_10"  name="medical_physical_10" class="element checkbox" type="checkbox" <?php if ($obj{"medical_physical_10"} == "on") {echo "checked";};?>  /><label class="choice" for="medical_physical_10">Eating Disorder</label></span>
				<span><input id="medical_physical_11"  name="medical_physical_11" class="element checkbox" type="checkbox" <?php if ($obj{"medical_physical_11"} == "on") {echo "checked";};?>  /><label class="choice" for="medical_physical_11">Seizures</label></span>
				<span><input id="medical_physical_12"  name="medical_physical_12" class="element checkbox" type="checkbox" <?php if ($obj{"medical_physical_12"} == "on") {echo "checked";};?>  /><label class="choice" for="medical_physical_12">Stress-Related Illness</label></span>
			</div>
		</li>
		<li id="li_28" class="section_break">
			<h3>Traumatic Stress</h3>
			<label class="description" for="traumatic_stress">Rating 
			<span id="required_27" class="required">*</span></label>
			<div>
				<select class="element select small" id="traumatic_stress" name="traumatic_stress">
				<option selected=""><?php echo stripslashes($obj{"traumatic_stress"});?></option>
				<option value="1"  >1 = No Problem</option>
				<option value="2"  >2 = Less than Slight</option>
				<option value="3"  >3 = Slight Problem</option>
				<option value="4"  >4 = Slight to Moderate</option>
				<option value="5"  >5 = Moderate Problem</option>
				<option value="6"  >6 = Moderate to Severe</option>
				<option value="7"  >7 = Severe Problem</option>
				<option value="8"  >8 = Severe to Extreme</option>
				<option value="9"  >9 = Extreme Problem</option>
				</select>
			</div>
			<label class="description">Symptoms/Assets </label>
			<div>
				<span><input id="traumatic_stress_1"  name="traumatic_stress_1" class="element checkbox" type="checkbox" <?php if ($obj{"traumatic_stress_1"} == "on") {echo "checked";};?>  /><label class="choice" for="traumatic_stress_1">Acute</label></span>
				<span><input id="traumatic_stress_2"  name="traumatic_stress_2" class="element checkbox" type="checkbox" <?php if ($obj{"traumatic_stress_2"} == "on") {echo "checked";};?>  /><label class="choice" for="traumatic_stress_2">Dreams/Nightmares</label></span>
				<span><input id="traumatic_stress_3"  name="traumatic_stress_3" class="element checkbox" type="checkbox" <?php if ($obj{"traumatic_stress_3"} == "on") {echo "checked";};?>  /><label class="choice" for="traumatic_stress_3">Chronic</label></span>
				<span><input id="traumatic_stress_4"  name="traumatic_stress_4" class="element checkbox" type="checkbox" <?php if ($obj{"traumatic_stress_4"} == "on") {echo "checked";};?>  /><label class="choice" for="traumatic_stress_4">Detached</label></span>
				<span><input id="traumatic_stress_5"  name="traumatic_stress_5" class="element checkbox" type="checkbox" <?php if ($obj{"traumatic_stress_5"} == "on") {echo "checked";};?>  /><label class="choice" for="traumatic_stress_5">Avoidance</label></span>
				<span><input id="traumatic_stress_6"  name="traumatic_stress_6" class="element checkbox" type="checkbox" <?php if ($obj{"traumatic_stress_6"} == "on") {echo "checked";};?>  /><label class="choice" for="traumatic_stress_6">Repression/Amnesia</label></span>
				<span><input id="traumatic_stress_7"  name="traumatic_stress_7" class="element checkbox" type="checkbox" <?php if ($obj{"traumatic_stress_7"} == "on") {echo "checked";};?>  /><label class="choice" for="traumatic_stress_7">Upseting Memories</label></span>
				<span><input id="traumatic_stress_8"  name="traumatic_stress_8" class="element checkbox" type="checkbox"  <?php if ($obj{"traumatic_stress_8"} == "on") {echo "checked";};?>  /><label class="choice" for="traumatic_stress_8">Hyper vigilance</label></span>
			</div>
		</li>
		<li id="li_28" class="section_break">
			<h3>Substance Use</h3>
			<label class="description" for="substance_use">Rating 
			<span id="required_27" class="required">*</span></label>
			<div>
				<select class="element select small" id="substance_use" name="substance_use">
				<option selected=""><?php echo stripslashes($obj{"substance_use"});?></option>
				<option value="1"  >1 = No Problem</option>
				<option value="2"  >2 = Less than Slight</option>
				<option value="3"  >3 = Slight Problem</option>
				<option value="4"  >4 = Slight to Moderate</option>
				<option value="5"  >5 = Moderate Problem</option>
				<option value="6"  >6 = Moderate to Severe</option>
				<option value="7"  >7 = Severe Problem</option>
				<option value="8"  >8 = Severe to Extreme</option>
				<option value="9"  >9 = Extreme Problem</option>
				</select>
			</div>
			<label class="description">Symptoms/Assets </label>
			<div>
				<span><input id="substance_use_1"  name="substance_use_1" class="element checkbox" type="checkbox" <?php if ($obj{"substance_use_1"} == "on") {echo "checked";};?>  /><label class="choice" for="substance_use_1">Alcohol</label></span>
				<span><input id="substance_use_2"  name="substance_use_2" class="element checkbox" type="checkbox" <?php if ($obj{"substance_use_2"} == "on") {echo "checked";};?>  /><label class="choice" for="substance_use_2">Drug(s)</label></span>
				<span><input id="substance_use_3"  name="substance_use_3" class="element checkbox" type="checkbox" <?php if ($obj{"substance_use_3"} == "on") {echo "checked";};?>  /><label class="choice" for="substance_use_3">Dependance</label></span>
				<span><input id="substance_use_4"  name="substance_use_4" class="element checkbox" type="checkbox" <?php if ($obj{"substance_use_4"} == "on") {echo "checked";};?>  /><label class="choice" for="substance_use_4">Abuse</label></span>
				<span><input id="substance_use_5"  name="substance_use_5" class="element checkbox" type="checkbox" <?php if ($obj{"substance_use_5"} == "on") {echo "checked";};?>  /><label class="choice" for="substance_use_5">Over the Counter Drugs</label></span>
				<span><input id="substance_use_6"  name="substance_use_6" class="element checkbox" type="checkbox" <?php if ($obj{"substance_use_6"} == "on") {echo "checked";};?>  /><label class="choice" for="substance_use_6">Craving/Urges</label></span>
				<span><input id="substance_use_7"  name="substance_use_7" class="element checkbox" type="checkbox" <?php if ($obj{"substance_use_7"} == "on") {echo "checked";};?>  /><label class="choice" for="substance_use_7">DUI</label> </span>
				<span><input id="substance_use_8"  name="substance_use_8" class="element checkbox" type="checkbox" <?php if ($obj{"substance_use_8"} == "on") {echo "checked";};?>  /><label class="choice" for="substance_use_8">Abstinent</label></span>
				<span><input id="substance_use_9"  name="substance_use_9" class="element checkbox" type="checkbox" <?php if ($obj{"substance_use_9"} == "on") {echo "checked";};?>  /><label class="choice" for="substance_use_9">I.V. Drugs</label></span>
				<span><input id="substance_use_10"  name="substance_use_10" class="element checkbox" type="checkbox" <?php if ($obj{"substance_use_10"} == "on") {echo "checked";};?>  /><label class="choice" for="substance_use_10">Recovery</label></span>
				<span><input id="substance_use_11"  name="substance_use_11" class="element checkbox" type="checkbox" <?php if ($obj{"substance_use_11"} == "on") {echo "checked";};?>  /><label class="choice" for="substance_use_11">Interfere w/Functioning</label></span>
				<span><input id="substance_use_12"  name="substance_use_12" class="element checkbox" type="checkbox" <?php if ($obj{"substance_use_12"} == "on") {echo "checked";};?>  /><label class="choice" for="substance_use_12">Med. Control</label></span>
			</div>
		</li>
		<li id="li_28" class="section_break">
			<h3>Interpersonal Relationships</h3>
			<label class="description" for="interpersonal_relationships">Rating 
			<span id="required_27" class="required">*</span></label>
			<div>
				<select class="element select small" id="interpersonal_relationships" name="interpersonal_relationships">
				<option selected=""><?php echo stripslashes($obj{"interpersonal_relationships"});?></option>
				<option value="1"  >1 = No Problem</option>
				<option value="2"  >2 = Less than Slight</option>
				<option value="3"  >3 = Slight Problem</option>
				<option value="4"  >4 = Slight to Moderate</option>
				<option value="5"  >5 = Moderate Problem</option>
				<option value="6"  >6 = Moderate to Severe</option>
				<option value="7"  >7 = Severe Problem</option>
				<option value="8"  >8 = Severe to Extreme</option>
				<option value="9"  >9 = Extreme Problem</option>
				</select>
			</div>
			<label class="description">Symptoms/Assets </label>
			<div>
				<span><input id="interpersonal_relationships_1"  name="interpersonal_relationships_1" class="element checkbox" type="checkbox" <?php if ($obj{"interpersonal_relationships_1"} == "on") {echo "checked";};?> /><label class="choice" for="interpersonal_relationships_1">Problems w/Friends</label></span>
				<span><input id="interpersonal_relationships_2"  name="interpersonal_relationships_2" class="element checkbox" type="checkbox" <?php if ($obj{"interpersonal_relationships_2"} == "on") {echo "checked";};?>  /><label class="choice" for="interpersonal_relationships_2">Diff. Estab./ Maintain Relationships</label></span>
				<span><input id="interpersonal_relationships_3"  name="interpersonal_relationships_3" class="element checkbox" type="checkbox" <?php if ($obj{"interpersonal_relationships_3"} == "on") {echo "checked";};?>  /><label class="choice" for="interpersonal_relationships_3">Poor Social Skills</label></span>
				<span><input id="interpersonal_relationships_4"  name="interpersonal_relationships_4" class="element checkbox" type="checkbox" <?php if ($obj{"interpersonal_relationships_4"} == "on") {echo "checked";};?>  /><label class="choice" for="interpersonal_relationships_4">Age-Appropriate Group Participation</label></span>
				<span><input id="interpersonal_relationships_5"  name="interpersonal_relationships_5" class="element checkbox" type="checkbox" <?php if ($obj{"interpersonal_relationships_5"} == "on") {echo "checked";};?>  /><label class="choice" for="interpersonal_relationships_5">Adequate Social Skills</label></span>
				<span><input id="interpersonal_relationships_6"  name="interpersonal_relationships_6" class="element checkbox" type="checkbox" <?php if ($obj{"interpersonal_relationships_6"} == "on") {echo "checked";};?>  /><label class="choice" for="interpersonal_relationships_6">Supportive Relationships</label></span>
				<span><input id="interpersonal_relationships_7"  name="interpersonal_relationships_7" class="element checkbox" type="checkbox" <?php if ($obj{"interpersonal_relationships_7"} == "on") {echo "checked";};?>  /><label class="choice" for="interpersonal_relationships_7">Overly Shy</label></span>
			</div>
		</li>
		<li id="li_28" class="section_break">
			<h3>Behavior in &quot;Home&quot; Setting</h3>
			<label class="description" for="behavior_in_home_setting">Rating 
			<span id="required_27" class="required">*</span></label>
			<div>
				<select class="element select small" id="behavior_in_home_setting" name="behavior_in_home_setting">
				<option selected=""><?php echo stripslashes($obj{"behavior_in_home_setting"});?></option>
				<option value="1"  >1 = No Problem</option>
				<option value="2"  >2 = Less than Slight</option>
				<option value="3"  >3 = Slight Problem</option>
				<option value="4"  >4 = Slight to Moderate</option>
				<option value="5"  >5 = Moderate Problem</option>
				<option value="6"  >6 = Moderate to Severe</option>
				<option value="7"  >7 = Severe Problem</option>
				<option value="8"  >8 = Severe to Extreme</option>
				<option value="9"  >9 = Extreme Problem</option>
				</select>
			</div>
			<label class="description">Symptoms/Assets </label>
			<div>
				<span><input id="behavior_in_home_setting_1"  name="behavior_in_home_setting_1" class="element checkbox" type="checkbox" <?php if ($obj{"behavior_in_home_setting_1"} == "on") {echo "checked";};?>  /><label class="choice" for="behavior_in_home_setting_1">Disregard Rules</label></span>
				<span><input id="behavior_in_home_setting_2"  name="behavior_in_home_setting_2" class="element checkbox" type="checkbox" <?php if ($obj{"behavior_in_home_setting_2"} == "on") {echo "checked";};?>  /><label class="choice" for="behavior_in_home_setting_2">Defies Authority</label></span>
				<span><input id="behavior_in_home_setting_3"  name="behavior_in_home_setting_3" class="element checkbox" type="checkbox" <?php if ($obj{"behavior_in_home_setting_3"} == "on") {echo "checked";};?>  /><label class="choice" for="behavior_in_home_setting_3">Conflict w/Sibling or Peer</label></span>
				<span><input id="behavior_in_home_setting_4"  name="behavior_in_home_setting_4" class="element checkbox" type="checkbox" <?php if ($obj{"behavior_in_home_setting_4"} == "on") {echo "checked";};?>  /><label class="choice" for="behavior_in_home_setting_4">Conflict w/Parent or Caregiver</label></span>
				<span><input id="behavior_in_home_setting_5"  name="behavior_in_home_setting_5" class="element checkbox" type="checkbox" <?php if ($obj{"behavior_in_home_setting_5"} == "on") {echo "checked";};?>  /><label class="choice" for="behavior_in_home_setting_5">Conflict w/Relative</label></span>
				<span><input id="behavior_in_home_setting_6"  name="behavior_in_home_setting_6" class="element checkbox" type="checkbox" <?php if ($obj{"behavior_in_home_setting_6"} == "on") {echo "checked";};?>  /><label class="choice" for="behavior_in_home_setting_6">Respectful</label></span>
				<span><input id="behavior_in_home_setting_7"  name="behavior_in_home_setting_7" class="element checkbox" type="checkbox" <?php if ($obj{"behavior_in_home_setting_7"} == "on") {echo "checked";};?>  /><label class="choice" for="behavior_in_home_setting_7">Responsipble</label></span>
			</div>
		</li>
		<li id="li_28" class="section_break">
			<h3>ADL Functioning</h3>
			<label class="description" for="adl_functioning">Rating 
			<span id="required_27" class="required">*</span></label>
			<div>
				<select class="element select small" id="adl_functioning" name="adl_functioning">
				<option selected=""><?php echo stripslashes($obj{"adl_functioning"});?></option>
				<option value="1"  >1 = No Problem</option>
				<option value="2"  >2 = Less than Slight</option>
				<option value="3"  >3 = Slight Problem</option>
				<option value="4"  >4 = Slight to Moderate</option>
				<option value="5"  >5 = Moderate Problem</option>
				<option value="6"  >6 = Moderate to Severe</option>
				<option value="7"  >7 = Severe Problem</option>
				<option value="8"  >8 = Severe to Extreme</option>
				<option value="9"  >9 = Extreme Problem</option>
				</select>
			</div>
			<label class="description">Symptoms/Assets </label>
			<div>
				<span><input id="adl_functioning_1"  name="adl_functioning_1" class="element checkbox" type="checkbox" <?php if ($obj{"adl_functioning_1"} == "on") {echo "checked";};?>  /><label class="choice" for="adl_functioning_1">Handicapped</label></span>
				<span><input id="adl_functioning_2"  name="adl_functioning_2" class="element checkbox" type="checkbox" <?php if ($obj{"adl_functioning_2"} == "on") {echo "checked";};?>  /><label class="choice" for="adl_functioning_2">Permanent Disability</label></span>
				<span><input id="adl_functioning_3"  name="adl_functioning_3" class="element checkbox" type="checkbox" <?php if ($obj{"adl_functioning_3"} == "on") {echo "checked";};?>  /><label class="choice" for="adl_functioning_3">No Known Limitations</label></span>
				<p>Not Age Appropriate In:</p>
				<span><input id="adl_functioning_4"  name="adl_functioning_4" class="element checkbox" type="checkbox" <?php if ($obj{"adl_functioning_4"} == "on") {echo "checked";};?>  /><label class="choice" for="adl_functioning_4">Communication</label></span>
				<span><input id="adl_functioning_5"  name="adl_functioning_5" class="element checkbox" type="checkbox" <?php if ($obj{"adl_functioning_5"} == "on") {echo "checked";};?>  /><label class="choice" for="adl_functioning_5">Self-Care</label></span>
				<span><input id="adl_functioning_6"  name="adl_functioning_6" class="element checkbox" type="checkbox" <?php if ($obj{"adl_functioning_6"} == "on") {echo "checked";};?>  /><label class="choice" for="adl_functioning_6">Hygiene</label></span>
				<span><input id="adl_functioning_7"  name="adl_functioning_7" class="element checkbox" type="checkbox" <?php if ($obj{"adl_functioning_7"} == "on") {echo "checked";};?>  /><label class="choice" for="adl_functioning_7">Recreation</label></span>
				<span><input id="adl_functioning_8"  name="adl_functioning_8" class="element checkbox" type="checkbox" <?php if ($obj{"adl_functioning_8"} == "on") {echo "checked";};?>  /><label class="choice" for="adl_functioning_8">Mobility</label></span>
			</div>
		</li>
		<li id="li_28" class="section_break">
			<h3>Socio-Legal</h3>
			<label class="description" for="socio_legal">Rating 
			<span id="required_27" class="required">*</span></label>
			<div>
				<select class="element select small" id="socio_legal" name="socio_legal">
				<option selected=""><?php echo stripslashes($obj{"socio_legal"});?></option>
				<option value="1"  >1 = No Problem</option>
				<option value="2"  >2 = Less than Slight</option>
				<option value="3"  >3 = Slight Problem</option>
				<option value="4"  >4 = Slight to Moderate</option>
				<option value="5"  >5 = Moderate Problem</option>
				<option value="6"  >6 = Moderate to Severe</option>
				<option value="7"  >7 = Severe Problem</option>
				<option value="8"  >8 = Severe to Extreme</option>
				<option value="9"  >9 = Extreme Problem</option>
				</select>
			</div>
			<label class="description">Symptoms/Assets </label>
			<div>
				<span><input id="socio_legal_1"  name="socio_legal_1" class="element checkbox" type="checkbox" <?php if ($obj{"socio_legal_1"} == "on") {echo "checked";};?>  /><label class="choice" for="socio_legal_1">Disregard Rules</label></span>
				<span><input id="socio_legal_2"  name="socio_legal_2" class="element checkbox" type="checkbox" <?php if ($obj{"socio_legal_2"} == "on") {echo "checked";};?>  /><label class="choice" for="socio_legal_2">Offense/Property</label></span>
				<span><input id="socio_legal_3"  name="socio_legal_3" class="element checkbox" type="checkbox" <?php if ($obj{"socio_legal_3"} == "on") {echo "checked";};?>  /><label class="choice" for="socio_legal_3">Offense/Person</label></span>
				<span><input id="socio_legal_4"  name="socio_legal_4" class="element checkbox" type="checkbox" <?php if ($obj{"socio_legal_4"} == "on") {echo "checked";};?>  /><label class="choice" for="socio_legal_4">Fire Setting</label></span>
				<span><input id="socio_legal_5"  name="socio_legal_5" class="element checkbox" type="checkbox" <?php if ($obj{"socio_legal_5"} == "on") {echo "checked";};?>  /><label class="choice" for="socio_legal_5">Comm. Control/Re-entry</label></span>
				<span><input id="socio_legal_6"  name="socio_legal_6" class="element checkbox" type="checkbox" <?php if ($obj{"socio_legal_6"} == "on") {echo "checked";};?>  /><label class="choice" for="socio_legal_6">Pending Charges</label></span>
				<span><input id="socio_legal_7"  name="socio_legal_7" class="element checkbox" type="checkbox" <?php if ($obj{"socio_legal_7"} == "on") {echo "checked";};?>  /><label class="choice" for="socio_legal_7">Dishonest</label></span>
				<span><input id="socio_legal_8"  name="socio_legal_8" class="element checkbox" type="checkbox" <?php if ($obj{"socio_legal_8"} == "on") {echo "checked";};?>  /><label class="choice" for="socio_legal_8">Incompetent to Proceed</label></span>
				<span><input id="socio_legal_9"  name="socio_legal_9" class="element checkbox" type="checkbox" <?php if ($obj{"socio_legal_9"} == "on") {echo "checked";};?>  /><label class="choice" for="socio_legal_9">Detention/Commitment</label></span>
				<span><input id="socio_legal_10" name="socio_legal_10" class="element checkbox" type="checkbox" <?php if ($obj{"socio_legal_10"} == "on") {echo "checked";};?>  /><label class="choice" for="socio_legal_10">Use/Con Other(s)</label></span>
				<span><input id="socio_legal_11" name="socio_legal_11" class="element checkbox" type="checkbox" <?php if ($obj{"socio_legal_11"} == "on") {echo "checked";};?>  /><label class="choice" for="socio_legal_11">Street Gang Member</label></span>
			</div>
		</li>
		<li id="li_28" class="section_break">
			<h3>Select: Work or School</h3>
			<div>
				<select class="element select small" id="work_or_school_option" name="work_or_school_option"> 
					<option selected=""><?php echo stripslashes($obj{"work_or_school_option"});?></option>
					<option value="Work"  >Work</option>
					<option value="School"  >School</option>
				</select>
			</div>
			<label class="description" for="work_or_school">Rating 
			<span id="required_27" class="required">*</span></label>
			<div>
				<select class="element select small" id="work_or_school" name="work_or_school">
				<option selected=""><?php echo stripslashes($obj{"work_or_school"});?></option>
				<option value="1"  >1 = No Problem</option>
				<option value="2"  >2 = Less than Slight</option>
				<option value="3"  >3 = Slight Problem</option>
				<option value="4"  >4 = Slight to Moderate</option>
				<option value="5"  >5 = Moderate Problem</option>
				<option value="6"  >6 = Moderate to Severe</option>
				<option value="7"  >7 = Severe Problem</option>
				<option value="8"  >8 = Severe to Extreme</option>
				<option value="9"  >9 = Extreme Problem</option>
				</select>
			</div>
			<label class="description">Symptoms/Assets </label>
			<div>
				<span><input id="work_or_school_1"  name="work_or_school_1" class="element checkbox" type="checkbox" <?php if ($obj{"work_or_school_1"} == "on") {echo "checked";};?>  /><label class="choice" for="work_or_school_1">Absenteeism</label></span>
				<span><input id="work_or_school_2"  name="work_or_school_2" class="element checkbox" type="checkbox" <?php if ($obj{"work_or_school_2"} == "on") {echo "checked";};?>  /><label class="choice" for="work_or_school_2">Poor Performance</label></span>
				<span><input id="work_or_school_3"  name="work_or_school_3" class="element checkbox" type="checkbox" <?php if ($obj{"work_or_school_3"} == "on") {echo "checked";};?>  /><label class="choice" for="work_or_school_3">Regular</label></span>
				<span><input id="work_or_school_4"  name="work_or_school_4" class="element checkbox" type="checkbox" <?php if ($obj{"work_or_school_4"} == "on") {echo "checked";};?>  /><label class="choice" for="work_or_school_4">Dropped Out</label></span>
				<span><input id="work_or_school_5"  name="work_or_school_5" class="element checkbox" type="checkbox" <?php if ($obj{"work_or_school_5"} == "on") {echo "checked";};?>  /><label class="choice" for="work_or_school_5">Learning Disability</label></span>
				<span><input id="work_or_school_6"  name="work_or_school_6" class="element checkbox" type="checkbox" <?php if ($obj{"work_or_school_6"} == "on") {echo "checked";};?>  /><label class="choice" for="work_or_school_6">Seeking</label></span>
				<span><input id="work_or_school_7"  name="work_or_school_7" class="element checkbox" type="checkbox" <?php if ($obj{"work_or_school_7"} == "on") {echo "checked";};?>  /><label class="choice" for="work_or_school_7">Employed</label></span>
				<span><input id="work_or_school_8"  name="work_or_school_8" class="element checkbox" type="checkbox" <?php if ($obj{"work_or_school_8"} == "on") {echo "checked";};?>  /><label class="choice" for="work_or_school_8">Doesn't Read/Write</label></span>
				<span><input id="work_or_school_9"  name="work_or_school_9" class="element checkbox" type="checkbox" <?php if ($obj{"work_or_school_9"} == "on") {echo "checked";};?>  /><label class="choice" for="work_or_school_9">Tardiness</label></span>
				<span><input id="work_or_school_10"  name="work_or_school_10" class="element checkbox" type="checkbox" <?php if ($obj{"work_or_school_10"} == "on") {echo "checked";};?>  /><label class="choice" for="work_or_school_10">Defies Authority</label></span>
				<span><input id="work_or_school_11"  name="work_or_school_11" class="element checkbox" type="checkbox" <?php if ($obj{"work_or_school_11"} == "on") {echo "checked";};?>  /><label class="choice" for="work_or_school_11">Not Emplyed</label></span>
				<span><input id="work_or_school_12"  name="work_or_school_12" class="element checkbox" type="checkbox" <?php if ($obj{"work_or_school_12"} == "on") {echo "checked";};?>  /><label class="choice" for="work_or_school_12">Suspended</label></span>
				<span><input id="work_or_school_13"  name="work_or_school_13" class="element checkbox" type="checkbox" <?php if ($obj{"work_or_school_13"} == "on") {echo "checked";};?>  /><label class="choice" for="work_or_school_13">Disruptive</label></span>
				<span><input id="work_or_school_14"  name="work_or_school_14" class="element checkbox" type="checkbox" <?php if ($obj{"work_or_school_14"} == "on") {echo "checked";};?>  /><label class="choice" for="work_or_school_14">Terminated/Expelled</label></span>
				<span><input id="work_or_school_15"  name="work_or_school_15" class="element checkbox" type="checkbox" <?php if ($obj{"work_or_school_15"} == "on") {echo "checked";};?>  /><label class="choice" for="work_or_school_15">Skips Class</label></span>
			</div>
		</li>
		<li id="li_28" class="section_break">
			<h3>Danger to Self</h3>
			<label class="description" for="danger_to_self">Rating 
			<span id="required_27" class="required">*</span></label>
			<div>
				<select class="element select small" id="danger_to_self" name="danger_to_self">
				<option selected=""><?php echo stripslashes($obj{"danger_to_self"});?></option>
				<option value="1"  >1 = No Problem</option>
				<option value="2"  >2 = Less than Slight</option>
				<option value="3"  >3 = Slight Problem</option>
				<option value="4"  >4 = Slight to Moderate</option>
				<option value="5"  >5 = Moderate Problem</option>
				<option value="6"  >6 = Moderate to Severe</option>
				<option value="7"  >7 = Severe Problem</option>
				<option value="8"  >8 = Severe to Extreme</option>
				<option value="9"  >9 = Extreme Problem</option>
				</select>
			</div>
			<label class="description">Symptoms/Assets </label>
			<div>
				<span><input id="danger_to_self_1"  name="danger_to_self_1" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_self_1"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_self_1">Suicidal Ideation</label></span>
				<span><input id="danger_to_self_2"  name="danger_to_self_2" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_self_2"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_self_2">Current Plan</label></span>
				<span><input id="danger_to_self_3"  name="danger_to_self_3" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_self_3"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_self_3">Recent Attempt</label></span>
				<span><input id="danger_to_self_4"  name="danger_to_self_4" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_self_4"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_self_4">Past Attempt</label></span>
				<span><input id="danger_to_self_5"  name="danger_to_self_5" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_self_5"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_self_5">Self-Injury</label></span>
				<span><input id="danger_to_self_6"  name="danger_to_self_6" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_self_6"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_self_6">Self-Mutilation</label></span>
				<span><input id="danger_to_self_7"  name="danger_to_self_7" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_self_7"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_self_7">"Risk-Taking" Behavior</label></span>
				<span><input id="danger_to_self_8"  name="danger_to_self_8" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_self_8"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_self_8">Serious Self-Neglect</label></span>
				<span><input id="danger_to_self_9"  name="danger_to_self_9" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_self_9"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_self_9">Inability to Care for Self</label></span>
			</div>
		</li>
		<li id="li_28" class="section_break">
			<h3>Danger to Others</h3>
			<label class="description" for="danger_to_others">Rating 
			<span id="required_27" class="required">*</span></label>
			<div>
				<select class="element select small" id="danger_to_others" name="danger_to_others">
				<option selected=""><?php echo stripslashes($obj{"danger_to_others"});?></option>
				<option value="1"  >1 = No Problem</option>
				<option value="2"  >2 = Less than Slight</option>
				<option value="3"  >3 = Slight Problem</option>
				<option value="4"  >4 = Slight to Moderate</option>
				<option value="5"  >5 = Moderate Problem</option>
				<option value="6"  >6 = Moderate to Severe</option>
				<option value="7"  >7 = Severe Problem</option>
				<option value="8"  >8 = Severe to Extreme</option>
				<option value="9"  >9 = Extreme Problem</option>
				</select>
			</div>
			<label class="description">Symptoms/Assets </label>
			<div>
				<span><input id="danger_to_others_1"  name="danger_to_others_1" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_others_1"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_others_1">Violent Temper</label></span>
				<span><input id="danger_to_others_2"  name="danger_to_others_2" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_others_2"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_others_2">Threatens Others</label></span>
				<span><input id="danger_to_others_3"  name="danger_to_others_3" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_others_3"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_others_3">Causes Serious Injury</label></span>
				<span><input id="danger_to_others_4"  name="danger_to_others_4" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_others_4"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_others_4">Homicidial Ideations</label></span>
				<span><input id="danger_to_others_5"  name="danger_to_others_5" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_others_5"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_others_5">Use of Weapons</label></span>
				<span><input id="danger_to_others_6"  name="danger_to_others_6" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_others_6"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_others_6">Homicidial Threats</label></span>
				<span><input id="danger_to_others_7"  name="danger_to_others_7" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_others_7"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_others_7">Assaultive</label></span>
				<span><input id="danger_to_others_8"  name="danger_to_others_8" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_others_8"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_others_8">Homicide Attempt</label></span>
				<span><input id="danger_to_others_9"  name="danger_to_others_9" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_others_9"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_others_9">Cruelty to Animals</label></span>
				<span><input id="danger_to_others_10"  name="danger_to_others_10" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_others_10"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_others_10">Accused of Sexual Assault</label></span>
				<span><input id="danger_to_others_11"  name="danger_to_others_11" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_others_11"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_others_11">Does not appear dangerous to others</label></span>
				<span><input id="danger_to_others_12"  name="danger_to_others_12" class="element checkbox" type="checkbox" <?php if ($obj{"danger_to_others_12"} == "on") {echo "checked";};?>  /><label class="choice" for="danger_to_others_12">Physically Aggressive</label></span>
			</div>
		</li>
		<li id="li_28" class="section_break">
			<h3>Security/Management Needs</h3>
			<label class="description" for="security_management_needs">Rating 
			<span id="required_27" class="required">*</span></label>
			<div>
				<select class="element select small" id="security_management_needs" name="security_management_needs">
				<option selected=""><?php echo stripslashes($obj{"security_management_needs"});?></option>
				<option value="1"  >1 = No Problem</option>
				<option value="2"  >2 = Less than Slight</option>
				<option value="3"  >3 = Slight Problem</option>
				<option value="4"  >4 = Slight to Moderate</option>
				<option value="5"  >5 = Moderate Problem</option>
				<option value="6"  >6 = Moderate to Severe</option>
				<option value="7"  >7 = Severe Problem</option>
				<option value="8"  >8 = Severe to Extreme</option>
				<option value="9"  >9 = Extreme Problem</option>
				</select>
			</div>
			<label class="description">Symptoms/Assets </label>
			<div>
				<span><input id="security_management_needs_1"  name="security_management_needs_1" class="element checkbox" type="checkbox" <?php if ($obj{"security_management_needs_1"} == "on") {echo "checked";};?>  /><label class="choice" for="security_management_needs_1">Home w/o Supervision</label></span>
				<span><input id="security_management_needs_2"  name="security_management_needs_2" class="element checkbox" type="checkbox" <?php if ($obj{"security_management_needs_2"} == "on") {echo "checked";};?>  /><label class="choice" for="security_management_needs_2">Suicide Watch</label></span>
				<span><input id="security_management_needs_3"  name="security_management_needs_3" class="element checkbox" type="checkbox" <?php if ($obj{"security_management_needs_3"} == "on") {echo "checked";};?>  /><label class="choice" for="security_management_needs_3">Behavioral Contract</label></span>
				<span><input id="security_management_needs_4"  name="security_management_needs_4" class="element checkbox" type="checkbox" <?php if ($obj{"security_management_needs_4"} == "on") {echo "checked";};?>  /><label class="choice" for="security_management_needs_4">Locked Unit</label></span>
				<span><input id="security_management_needs_5"  name="security_management_needs_5" class="element checkbox" type="checkbox" <?php if ($obj{"security_management_needs_5"} == "on") {echo "checked";};?>  /><label class="choice" for="security_management_needs_5">Protection from Others</label></span>
				<span><input id="security_management_needs_6"  name="security_management_needs_6" class="element checkbox" type="checkbox" <?php if ($obj{"security_management_needs_6"} == "on") {echo "checked";};?>  /><label class="choice" for="security_management_needs_6">Seclusion </label></span>
				<span><input id="security_management_needs_7"  name="security_management_needs_7" class="element checkbox" type="checkbox" <?php if ($obj{"security_management_needs_7"} == "on") {echo "checked";};?>  /><label class="choice" for="security_management_needs_7">Home w/Supervision</label></span>
				<span><input id="security_management_needs_8"  name="security_management_needs_8" class="element checkbox" type="checkbox" <?php if ($obj{"security_management_needs_8"} == "on") {echo "checked";};?>  /><label class="choice" for="security_management_needs_8">Run/Escape Risk</label></span>
				<span><input id="security_management_needs_9"  name="security_management_needs_9" class="element checkbox" type="checkbox" <?php if ($obj{"security_management_needs_9"} == "on") {echo "checked";};?>  /><label class="choice" for="security_management_needs_9">Restraint </label></span>
				<span><input id="security_management_needs_10"  name="security_management_needs_10" class="element checkbox" type="checkbox" <?php if ($obj{"security_management_needs_10"} == "on") {echo "checked";};?>  /><label class="choice" for="security_management_needs_10">Involuntary Exam/Commitment</label></span>
				<span><input id="security_management_needs_11"  name="security_management_needs_11" class="element checkbox" type="checkbox" <?php if ($obj{"security_management_needs_11"} == "on") {echo "checked";};?>  /><label class="choice" for="security_management_needs_11">Time-out</label></span>
				<span><input id="security_management_needs_12"  name="security_management_needs_12" class="element checkbox" type="checkbox" <?php if ($obj{"security_management_needs_12"} == "on") {echo "checked";};?>  /><label class="choice" for="security_management_needs_12">PRN Medications </label></span>
				<span><input id="security_management_needs_13"  name="security_management_needs_13" class="element checkbox" type="checkbox" <?php if ($obj{"security_management_needs_13"} == "on") {echo "checked";};?>  /><label class="choice" for="security_management_needs_13">Monitored House Arrest</label></span>
				<span><input id="security_manageent_needs_14"  name="security_management_needs_14" class="element checkbox" type="checkbox" <?php if ($obj{"security_management_needs_14"} == "on") {echo "checked";};?>  /><label class="choice" for="security_management_needs_14">One-to-One Supervision</label></span>
			</div>
		</li>
		<br>
		
		<br>Electronically Signed By:<?php echo stripslashes($obj{"provider_print_name"});?>


		<br>
		<div style="margin: 10px;">
			
		</div>