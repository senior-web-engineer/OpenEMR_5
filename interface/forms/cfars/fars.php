    <ul class = "blank">
		<li id="li_1"  >
			<label class="description">DCF Outcomes Report <span id="required_1" class="required">*</span></label>
			<div>
				<select class="element select medium select-css" id="dcf_outcomes_report" name="dcf_outcomes_report"> 
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
				<select class="element select medium select-css" id="program_evaluation" name="program_evaluation"> 
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
			<label class="description" for="primary_diagnosis">DSM-IV Code for Primary Diagnosis </label>
			<div>
			<input class ="input-css" id="primary_diagnosis" name="primary_diagnosis" type="text"  value="<?php echo stripslashes($obj{"primary_diagnosis"});?>"/>
			</div> 
		</li>		
		<li id="li_4"  >
			<label class="description" for="secondary_diagnosis">DSM-IV Code for Secondary Diagnosis </label>
			<div>
			<input class ="input-css" id="secondary_diagnosis" name="secondary_diagnosis" type="text" value="<?php echo stripslashes($obj{"secondary_diagnosis"});?>" />
			</div> 
		</li>		
		<li id="li_5"  >
			<label class="description" for="substance_abuse_history">Substance Abuse History </label>
			<div>
				<select class="element select medium select-css" id="substance_abuse_history" name="substance_abuse_history"> 
					<option selected=""><?php echo stripslashes($obj{"substance_abuse_history"});?></option>
					<option value="YES"  >YES</option>
					<option value="NO"  >NO</option>
				</select>
			</div> 
		</li>
		<li id="li_6" >
			<label class="description" for="cfars_rater_notes">FARS Rater's Notes (Optional): </label>
			<div>
				<textarea id="cfars_rater_notes" name="cfars_rater_notes" class="element textarea medium" rows="8" cols="90" onkeyup="limit_input(6,'c',250);" onchange="limit_input(6,'c',250);"><?php echo stripslashes($obj{"cfars_rater_notes"});?></textarea>
				</div>
		</li>
		
		<input name="service_name" value="FARS" type="hidden" />
        
        <li id="li_8" class="section_break">
        <fieldset>
            <legend>Depression</legend>
			<label class="description" for="depression">Rating 
			<span id="required_12" class="required">*</span></label>
            <span>
				<select class="element select small select-css" id="depression" name="depression">
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
                </span>
			<div>
			<label class="description">Symptoms/Assets </label>
			</div>
				<div>
                  <span class="columns">  <label class="container" for="depression_1">Depressed Mood
                <input type="checkbox" id="depression_1" name="depression_1"<?php if ($obj{"depression_1"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
               <span class="columns">  <label class="container" for="depression_2">Happy
                <input type="checkbox" id="depression_2" name="depression_2"<?php if ($obj{"depression_2"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                <span class="columns">  <label class="container" for="depression_3">Sleep Problems
                <input type="checkbox" id="depression_3" name="depression_3"<?php if ($obj{"depression_3"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                <span class="columns">  <label class="container" for="depression_4">Sad
                <input type="checkbox" id="depression_4" name="depression_4"<?php if ($obj{"depression_4"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                <span class="columns">  <label class="container" for="depression_5">Hopeless
                <input type="checkbox" id="depression_5" name="depression_5"<?php if ($obj{"depression_5"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
             <span class="columns">  <label class="container" for="depression_6">Lacks Energy/Interest
                <input type="checkbox" id="depression_6" name="depression_6"<?php if ($obj{"depression_6"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                <span class="columns">  <label class="container" for="depression_7">Irritable
                <input type="checkbox" id="depression_7" name="depression_7"<?php if ($obj{"depression_7"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
               <span class="columns">  <label class="container" for="depression_8">Withdrawn
                <input type="checkbox" id="depression_8" name="depression_8"<?php if ($obj{"depression_8"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
              <span class="columns">  <label class="container" for="depression_9">Anti-Depression Meds
                <input type="checkbox" id="depression_9" name="depression_9"<?php if ($obj{"depression_9"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
		        </div>
            </fieldset>
        </li>
        <li id="li_11" class="section_break">
        <fieldset>
            <legend>Anxiety</legend>
		
			<label class="description" for="anxiety">Rating 
			<span id="required_9" class="required">*</span></label>
			<span>
  
				<select class="element select small select-css" id="anxiety" name="anxiety">
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
			</span>
            <div>
			<label class="description">Symptoms/Assets </label>
            </div>
			<div>
                <span class="columns">  <label class="container" for="anxiety_1">Anxious/Tense
                <input type="checkbox" id="anxiety_1" name="anxiety_1"<?php if ($obj{"anxiety_1"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                   <span class="columns">  <label class="container" for="anxiety_2">Calm
                <input type="checkbox" id="anxiety_2" name="anxiety_2"<?php if ($obj{"anxiety_2"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                  <span class="columns">  <label class="container" for="anxiety_3">Guilt
                <input type="checkbox" id="anxiety_3" name="anxiety_3"<?php if ($obj{"anxiety_3"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                  <span class="columns">  <label class="container" for="anxiety_4">Phobic
                <input type="checkbox" id="anxiety_4" name="anxiety_4"<?php if ($obj{"anxiety_4"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                  <span class="columns">  <label class="container" for="anxiety_5">Worried/Fearful
                <input type="checkbox" id="anxiety_5" name="anxiety_5"<?php if ($obj{"anxiety_5"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                  <span class="columns">  <label class="container" for="anxiety_6">Anti-Anxiety Meds
                <input type="checkbox" id="anxiety_6" name="anxiety_6"<?php if ($obj{"anxiety_6"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                  <span class="columns">  <label class="container" for="anxiety_7">Obsessive/Compulsive
                <input type="checkbox" id="anxiety_7" name="anxiety_7"<?php if ($obj{"anxiety_7"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                 <span class="columns">  <label class="container" for="anxiety_8">Panic
                <input type="checkbox" id="anxiety_8" name="anxiety_8"<?php if ($obj{"anxiety_8"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                     </label></span>
			</div>
		</fieldset>	
        </li>
        <li id="li_15" class="section_break">
        <fieldset>
            <legend>Hyper Affect</legend>
		
			
			<label class="description" for="hyper_affect">Rating 
			<span id="required_19" class="required">*</span></label>
			<span>
                <span>
				<select class="element select small select-css" id="hyper_affect" name="hyper_affect">
				<option selected=""><?php echo stripslashes($obj{"hyper_affect"});?></option>
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
                </span>
			</span>
            <div>
			<label class="description">Symptoms/Assets </label>
            </div>
			<div>
                  <span class="columns">  <label class="container" for="hyper_affect_1">Manic
                <input type="checkbox" id="hyper_affect_1" name="hyper_affect_1"<?php if ($obj{"hyper_affect_1"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                <span class="columns">  <label class="container" for="hyper_affect_2">Elevated Mood
                <input type="checkbox" id="hyper_affect_2" name="hyper_affect_2"<?php if ($obj{"hyper_affect_2"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                 <span class="columns">  <label class="container" for="hyper_affect_3">Agitated
                <input type="checkbox" id="hyper_affect_3" name="hyper_affect_3"<?php if ($obj{"hyper_affect_3"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                <span class="columns">  <label class="container" for="hyper_affect_4">Sleep Deficit
                <input type="checkbox" id="hyper_affect_4" name="hyper_affect_4"<?php if ($obj{"hyper_affect_4"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="hyper_affect_5">Overactive
                <input type="checkbox" id="hyper_affect_5" name="hyper_affect_5"<?php if ($obj{"hyper_affect_5"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				<span class="columns">  <label class="container" for="hyper_affect_6">Mood Swings
                <input type="checkbox" id="hyper_affect_6" name="hyper_affect_6"<?php if ($obj{"hyper_affect_6"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                <span class="columns">  <label class="container" for="hyper_affect_7">Pressured Speech
                <input type="checkbox" id="hyper_affect_7" name="hyper_affect_7"<?php if ($obj{"hyper_affect_7"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="hyper_affect_8">Relaxed
                <input type="checkbox" id="hyper_affect_8" name="hyper_affect_8"<?php if ($obj{"hyper_affect_8"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				<span class="columns">  <label class="container" for="hyper_affect_9">Anti-Manic Meds
                <input type="checkbox" id="hyper_affect_9" name="hyper_affect_9"<?php if ($obj{"hyper_affect_9"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
		</fieldset>
        </li>
        <li id="li_21" class="section_break">
        <fieldset>
            <legend>Thought Process</legend>
			<label class="description" for="thought_process">Rating 
			<span id="required_22" class="required">*</span></label>
			<span>
				<select class="element select small select-css" id="thought_process" name="thought_process">
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
			</span>
            <div>
			<label class="description">Symptoms/Assets </label>
            </div>
			<div>
                <span class="columns">  <label class="container" for="thought_process_1">Illogical
                <input type="checkbox" id="thought_process_1" name="thought_process_1"<?php if ($obj{"thought_process_1"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
               <span class="columns">  <label class="container" for="thought_process_2">Delusional
                <input type="checkbox" id="thought_process_2" name="thought_process_2"<?php if ($obj{"thought_process_2"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				<span class="columns">  <label class="container" for="thought_process_3">Hallucinations
                <input type="checkbox" id="thought_process_3" name="thought_process_3"<?php if ($obj{"thought_process_3"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
				 <div>
                     <span class="columns">  <label class="container" for="thought_process_4">Paranoid
                <input type="checkbox" id="thought_process_4" name="thought_process_4"<?php if ($obj{"thought_process_4"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                 <span class="columns">  <label class="container" for="thought_process_5">Ruminative
                <input type="checkbox" id="thought_process_5" name="thought_process_5"<?php if ($obj{"thought_process_5"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="thought_process_6">Intact
                <input type="checkbox" id="thought_process_6" name="thought_process_6"<?php if ($obj{"thought_process_6"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                     </label></span>
            </div>
			<div>
                <span class="columns">  <label class="container" for="thought_process_7">Derailed Thinking
                <input type="checkbox" id="thought_process_7" name="thought_process_7"<?php if ($obj{"thought_process_7"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                 <span class="columns">  <label class="container" for="thought_process_8">Loose Associations
                <input type="checkbox" id="thought_process_8" name="thought_process_8"<?php if ($obj{"thought_process_8"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
			     <span class="columns">  <label class="container" for="thought_process_9">Anti-Psych Med.
                <input type="checkbox" id="thought_process_9" name="thought_process_9"<?php if ($obj{"thought_process_9"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
		</fieldset>	
        </li>
        <li id="li_24" class="section_break">
        <fieldset>
            <legend>Cognitive Performance</legend>
		
			
			<label class="description" for="cognitive_performance">Rating 
			<span id="required_25" class="required">*</span></label>
			<span>
				<select class="element select small select-css" id="cognitive_performance" name="cognitive_performance">
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
			</span>
            <div>
			<label class="description">Symptoms/Assets</label>
            </div>
			<div>
                <span class="columns">  <label class="container" for="cognitive_performance_1">Poor Memory
                <input type="checkbox" id="cognitive_performance_1" name="cognitive_performance_1"<?php if ($obj{"cognitive_performance_1"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                <span class="columns">  <label class="container" for="cognitive_performance_2">Low Self-Awareness
                <input type="checkbox" id="cognitive_performance_2" name="cognitive_performance_2"<?php if ($obj{"cognitive_performance_2"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                <span class="columns">  <label class="container" for="cognitive_performance_3">Impaired Judgment
                <input type="checkbox" id="cognitive_performance_3" name="cognitive_performance_3"<?php if ($obj{"cognitive_performance_3"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                <span class="columns">  <label class="container" for="cognitive_performance_4">Short Attention
                <input type="checkbox" id="cognitive_performance_4" name="cognitive_performance_4"<?php if ($obj{"cognitive_performance_4"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                 <span class="columns"><label class="container" for="cognitive_performance_5">Development Disability 
                <input type="checkbox" id="cognitive_performance_5" name="cognitive_performance_5"<?php if ($obj{"cognitive_performance_5"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="cognitive_performance_6">Slow Processing
                <input type="checkbox" id="cognitive_performance_6" name="cognitive_performance_6"<?php if ($obj{"cognitive_performance_6"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                 <span class="columns">  <label class="container" for="cognitive_performance_7">Insightful
                <input type="checkbox" id="cognitive_performance_7" name="cognitive_performance_7"<?php if ($obj{"cognitive_performance_7"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                 <span class="columns">  <label class="container" for="cognitive_performance_8">Poor Concentration
                <input type="checkbox" id="cognitive_performance_8" name="cognitive_performance_8"<?php if ($obj{"cognitive_performance_8"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                <span class="columns">  <label class="container" for="cognitive_performance_9">Oriented Times 4
                <input type="checkbox" id="cognitive_performance_9" name="cognitive_performance_9"<?php if ($obj{"cognitive_performance_9"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                    </label></span>
            </div>
            <div>
                 <span class="columns">  <label class="container" for="cognitive_performance_10">Not Oriented to Person
                <input type="checkbox" id="cognitive_performance_10" name="cognitive_performance_10"<?php if ($obj{"cognitive_performance_10"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
			    <span class="columns">  <label class="container" for="cognitive_performance_11">Not Oriented to Place
                <input type="checkbox" id="cognitive_performance_11" name="cognitive_performance_11"<?php if ($obj{"cognitive_performance_11"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
              <span class="columns">  <label class="container" for="cognitive_performance_12">Not Oriented to Time
                <input type="checkbox" id="cognitive_performance_12" name="cognitive_performance_12"<?php if ($obj{"cognitive_performance_12"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                 <span class="columns">  <label class="container" for="cognitive_performance_13">Not Oriented to Circumstance
                <input type="checkbox" id="cognitive_performance_13" name="cognitive_performance_13"<?php if ($obj{"cognitive_performance_13"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
			</div>
		</fieldset>	
        </li>
        <li id="li_28" class="section_break">
        <fieldset>
            <legend>Medical / Physical</legend>
		
			<label class="description" for="medical_physical">Rating 
			<span id="required_27" class="required">*</span></label>
			<span>
				<select class="element select small select-css" id="medical_physical" name="medical_physical">
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
			</span>
            <div>
			<label class="description">Symptoms/Assets </label>
            </div>
            <div>
                 <span class="columns">  <label class="container" for="medical_physical_1">Acute Illiness
                <input type="checkbox" id="medical_physical_1" name="medical_physical_1"<?php if ($obj{"medical_physical_1"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                  <span class="columns">  <label class="container" for="medical_physical_2">Handicap or Perm. Dis.
                <input type="checkbox" id="medical_physical_2" name="medical_physical_2"<?php if ($obj{"medical_physical_2"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="medical_physical_3">Good Health
                <input type="checkbox" id="medical_physical_3" name="medical_physical_3"<?php if ($obj{"medical_physical_3"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                 <span class="columns">  <label class="container" for="medical_physical_4">CNS Disorder
                <input type="checkbox" id="medical_physical_4" name="medical_physical_4"<?php if ($obj{"medical_physical_4"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				  <span class="columns">  <label class="container" for="medical_physical_5">Chronic Illness
                <input type="checkbox" id="medical_physical_5" name="medical_physical_5"<?php if ($obj{"medical_physical_5"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				  <span class="columns">  <label class="container" for="medical_physical_6">Need Health Care
                <input type="checkbox" id="medical_physical_6" name="medical_physical_6"<?php if ($obj{"medical_physical_6"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                 <span class="columns">  <label class="container" for="medical_physical_7">Pregnat
                <input type="checkbox" id="medical_physical_7" name="medical_physical_7"<?php if ($obj{"medical_physical_7"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				  <span class="columns">  <label class="container" for="medical_physical_8">Poor Nutrition
                <input type="checkbox" id="medical_physical_8" name="medical_physical_8"<?php if ($obj{"medical_physical_8"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				<span class="columns">  <label class="container" for="medical_physical_9">Enuretic/Encopretic
                <input type="checkbox" id="medical_physical_9" name="medical_physical_9"<?php if ($obj{"medical_physical_9"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                <span class="columns">  <label class="container" for="medical_physical_10">Eating Disorder
                <input type="checkbox" id="medical_physical_10" name="medical_physical_10"<?php if ($obj{"medical_physical_10"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				<span class="columns">  <label class="container" for="medical_physical_11">Seizures
                <input type="checkbox" id="medical_physical_11" name="medical_physical_11"<?php if ($obj{"medical_physical_11"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="medical_physical_12">Stress-Related Illness
                <input type="checkbox" id="medical_physical_12" name="medical_physical_12"<?php if ($obj{"medical_physical_12"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>				
			</div>
		</fieldset>
        </li>
        <li id="li_28" class="section_break">
        <fieldset>
            <legend>Traumatic Stress</legend>
		
			
			<label class="description" for="traumatic_stress">Rating 
			<span id="required_27" class="required">*</span></label>
			<span>
				<select class="element select small select-css" id="traumatic_stress" name="traumatic_stress">
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
            </span>
            <div>
			<label class="description">Symptoms/Assets </label>
            </div>
			<div>
                <span class="columns">  <label class="container" for="traumatic_stress_1">Acute
                <input type="checkbox" id="traumatic_stress_1" name="traumatic_stress_1"<?php if ($obj{"traumatic_stress_1"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                 <span class="columns">  <label class="container" for="traumatic_stress_2">Dreams/Nightmares
                <input type="checkbox" id="traumatic_stress_2" name="traumatic_stress_2"<?php if ($obj{"traumatic_stress_2"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="traumatic_stress_3">Chronic
                <input type="checkbox" id="traumatic_stress_3" name="traumatic_stress_3"<?php if ($obj{"traumatic_stress_3"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
				<div>
                     <span class="columns">  <label class="container" for="traumatic_stress_4">Detached
                <input type="checkbox" id="traumatic_stress_4" name="traumatic_stress_4"<?php if ($obj{"traumatic_stress_4"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                 <span class="columns">  <label class="container" for="traumatic_stress_5">Avoidant
                <input type="checkbox" id="traumatic_stress_5" name="traumatic_stress_5"<?php if ($obj{"traumatic_stress_5"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="traumatic_stress_6">Repression/Amnesia
                <input type="checkbox" id="traumatic_stress_6" name="traumatic_stress_6"<?php if ($obj{"traumatic_stress_6"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
				
            <div>
                 <span class="columns">  <label class="container" for="traumatic_stress_7">Upsetting Memories
                <input type="checkbox" id="traumatic_stress_7" name="traumatic_stress_7"<?php if ($obj{"traumatic_stress_7"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                 <span class="columns">  <label class="container" for="traumatic_stress_8">Hyper Vigilance
                <input type="checkbox" id="traumatic_stress_8" name="traumatic_stress_8"<?php if ($obj{"traumatic_stress_8"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				</div>
		</fieldset>
        </li>
        <li id="li_28" class="section_break">
        <fieldset>
            <legend>Substance Uses</legend>
		
			
			<label class="description" for="substance_use">Rating 
			<span id="required_27" class="required">*</span></label>
			<span>
				<select class="element select small select-css" id="substance_use" name="substance_use">
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
			</span>
            <div>
			<label class="description">Symptoms/Assets </label>
            </div>
			<div>
                 <span class="columns">  <label class="container" for="substance_use_1">Alcohol
                <input type="checkbox" id="substance_use_1" name="substance_use_1"<?php if ($obj{"substance_use_1"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
              <span class="columns">  <label class="container" for="substance_use_2"> Drug(s)
                <input type="checkbox" id="substance_use_2" name="substance_use_2"<?php if ($obj{"substance_use_2"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				<span class="columns">  <label class="container" for="substance_use_3">Dependance
                <input type="checkbox" id="substance_use_3" name="substance_use_3"<?php if ($obj{"substance_use_3"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                <span class="columns">  <label class="container" for="substance_use_4">Abuse
                <input type="checkbox" id="substance_use_4" name="substance_use_4"<?php if ($obj{"substance_use_4"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                 <span class="columns">  <label class="container" for="substance_use_5">Family History
                <input type="checkbox" id="substance_use_5" name="substance_use_5"<?php if ($obj{"substance_use_5"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
               <span class="columns">  <label class="container" for="substance_use_6">Craving/Urges
                <input type="checkbox" id="substance_use_6" name="substance_use_6"<?php if ($obj{"substance_use_6"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                </div>
            <div>
                <span class="columns">  <label class="container" for="substance_use_7">DUI
                <input type="checkbox" id="substance_use_7" name="substance_use_7"<?php if ($obj{"substance_use_7"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
			<span class="columns">  <label class="container" for="substance_use_8">Abstinent
                <input type="checkbox" id="substance_use_8" name="substance_use_8"<?php if ($obj{"substance_use_8"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
			<span class="columns">  <label class="container" for="substance_use_9">Med. Control
                <input type="checkbox" id="substance_use_9" name="substance_use_9"<?php if ($obj{"substance_use_9"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                <span class="columns">  <label class="container" for="substance_use_10">Recovery
                <input type="checkbox" id="substance_use_10" name="substance_use_10"<?php if ($obj{"substance_use_10"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				<span class="columns">  <label class="container" for="substance_use_11">Interface w/duties
                <input type="checkbox" id="substance_use_11" name="substance_use_11"<?php if ($obj{"substance_use_11"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				<span class="columns">  <label class="container" for="substance_use_12">I.V. Drugs
                <input type="checkbox" id="substance_use_12" name="substance_use_12"<?php if ($obj{"substance_use_12"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
			</div>
		</fieldset>
        </li>
        <li id="li_28" class="section_break">
        <fieldset>
            <legend>Interpersonal Relationships</legend>
		
			
			<label class="description" for="interpersonal_relationships">Rating 
			<span id="required_27" class="required">*</span></label>
			<span>
				<select class="element select small select-css" id="interpersonal_relationships" name="interpersonal_relationships">
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
			</span>
            <div>
			<label class="description">Symptoms/Assets </label>
            </div>
			<div>
                <span class="columns">  <label class="container" for="interpersonal_relationships_1">Problem w/Friends
                <input type="checkbox" id="interpersonal_relationships_1" name="interpersonal_relationships_1"<?php if ($obj{"interpersonal_relationships_1"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                 <span class="columns">  <label class="container" for="interpersonal_relationships_2">Diff. Estab./ Maintain Relationships
                <input type="checkbox" id="interpersonal_relationships_2" name="interpersonal_relationships_2"<?php if ($obj{"interpersonal_relationships_2"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="interpersonal_relationships_3">Poor Social Skills
                <input type="checkbox" id="interpersonal_relationships_3" name="interpersonal_relationships_3"<?php if ($obj{"interpersonal_relationships_3"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                 <span class="columns">  <label class="container" for="interpersonal_relationships_4">Difficulty Maintaining Relationships
                <input type="checkbox" id="interpersonal_relationships_4" name="interpersonal_relationships_4"<?php if ($obj{"interpersonal_relationships_4"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                 <span class="columns">  <label class="container" for="interpersonal_relationships_5">Adequate Social Skills
                <input type="checkbox" id="interpersonal_relationships_5" name="interpersonal_relationships_5"<?php if ($obj{"interpersonal_relationships_5"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
			 <span class="columns">  <label class="container" for="interpersonal_relationships_6">Supportive Relathionships
                <input type="checkbox" id="interpersonal_relationships_6" name="interpersonal_relationships_6"<?php if ($obj{"interpersonal_relationships_6"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
			</div>
		</fieldset>
        </li>
        <li id="li_28" class="section_break">
        <fieldset>
             <legend>Family Relationships</legend>
		
			
			<label class="description" for="family_relationships">Rating 
			<span id="required_27" class="required">*</span></label>
			<span>
				<select class="element select small select-css" id="family_relationships" name="family_relationships">
				<option selected=""><?php echo stripslashes($obj{"familty_relationships"});?></option>
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
			</span>
            <div>
			<label class="description">Symptoms/Assets </label>
            </div>
			<div>
                 <span class="columns">  <label class="container" for="family_relationships_1">No Contact w/Family
                <input type="checkbox" id="family_relationships_1" name="family_relationships_1"<?php if ($obj{"family_relationships_1"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                 <span class="columns">  <label class="container" for="family_relationships_2">Poor Parenting Skills
                <input type="checkbox" id="family_relationships_2" name="family_relationships_2"<?php if ($obj{"family_relationships_2"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="family_relationships_3">Supportive Family
                <input type="checkbox" id="family_relationships_3" name="family_relationships_3"<?php if ($obj{"family_relationships_3"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                 <span class="columns">  <label class="container" for="family_relationships_4">Difficulty w/Partner
                <input type="checkbox" id="family_relationships_4" name="family_relationships_4"<?php if ($obj{"family_relationships_4"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="family_relationships_5">Acting Out
                <input type="checkbox" id="family_relationships_5" name="family_relationships_5"<?php if ($obj{"family_relationships_5"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="family_relationships_6">No Family
                <input type="checkbox" id="family_relationships_6" name="family_relationships_6"<?php if ($obj{"family_relationships_6"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                 <span class="columns">  <label class="container" for="family_relationships_7">Conflict w/Relative
                <input type="checkbox" id="family_relationships_7" name="family_relationships_7"<?php if ($obj{"family_relationships_7"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="family_relationships_8">Difficulty w/Child
                <input type="checkbox" id="family_relationships_8" name="family_relationships_8"<?php if ($obj{"family_relationships_8"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
			 <span class="columns">  <label class="container" for="family_relationships_9">Difficulty w/Parent
                <input type="checkbox" id="family_relationships_9" name="family_relationships_9"<?php if ($obj{"family_relationships_9"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>				
			</div>
		</fieldset>
        </li>
        <li id="li_28" class="section_break">
        <fieldset>
            <legend>Family Environment</legend>
		
			
			<label class="description" for="family_environment">Rating 
			<span id="required_27" class="required">*</span></label>
			<span>
				<select class="element select small select-css" id="family_environment" name="family_environment">
				<option selected=""><?php echo stripslashes($obj{"family_environment"});?></option>
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
			</span>
            <div>
			<label class="description">Symptoms/Assets </label>
            </div>
			<div>
                 <span class="columns">  <label class="container" for="family_environment_1">Family Instability
                <input type="checkbox" id="family_environment_1" name="family_environment_1"<?php if ($obj{"family_environment_1"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                <span class="columns">  <label class="container" for="family_environment_2">Separration
                <input type="checkbox" id="family_environment_2" name="family_environment_2"<?php if ($obj{"family_environment_2"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="family_environment_3">Custody Problem
                <input type="checkbox" id="family_environment_3" name="family_environment_3"<?php if ($obj{"family_environment_3"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                <span class="columns">  <label class="container" for="family_environment_4">Family Legal Problems
                <input type="checkbox" id="family_environment_4" name="family_environment_4"<?php if ($obj{"family_environment_4"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="family_environment_5">Stable Home
                <input type="checkbox" id="family_environment_5" name="family_environment_5"<?php if ($obj{"family_environment_5"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				<span class="columns">  <label class="container" for="family_environment_6">Divorce
                <input type="checkbox" id="family_environment_6" name="family_environment_6"<?php if ($obj{"family_environment_6"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                </div>
            <div>
                <span class="columns">  <label class="container" for="family_environment_7">Single Parent
                <input type="checkbox" id="family_environment_7" name="family_environment_7"<?php if ($obj{"family_environment_7"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="family_environment_8">Birth in Family
                <input type="checkbox" id="family_environment_8" name="family_environment_8"<?php if ($obj{"family_environment_8"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				<span class="columns">  <label class="container" for="family_environment_9">Death in Family
                <input type="checkbox" id="family_environment_9" name="family_environment_9"<?php if ($obj{"family_environment_9"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
			</div>
		</fieldset>
        </li>
        <li id="li_28" class="section_break">
        <fieldset>
            <legend>Socio-Legal</legend>

			
			<label class="description" for="socio_legal">Rating 
			<span id="required_27" class="required">*</span></label>
			<span>
				<select class="element select small select-css" id="socio_legal" name="socio_legal">
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
			</span>
            <div>
			<label class="description">Symptoms/Assets </label>
            </div>
            <div>
                <span class="columns">  <label class="container" for="socio_legal_1">Disregard Rules
                <input type="checkbox" id="socio_legal_1" name="socio_legal_1"<?php if ($obj{"socio_legal_1"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				<span class="columns">  <label class="container" for="socio_legal_2">Probation
                <input type="checkbox" id="socio_legal_2" name="socio_legal_2"<?php if ($obj{"socio_legal_2"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                     <span class="columns">  <label class="container" for="socio_legal_3">Pending Charges
                <input type="checkbox" id="socio_legal_3" name="socio_legal_3"<?php if ($obj{"socio_legal_3"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                    <span class="columns">  <label class="container" for="socio_legal_4">Dishonesty
                <input type="checkbox" id="socio_legal_4" name="socio_legal_4"<?php if ($obj{"socio_legal_4"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				     <span class="columns">  <label class="container" for="socio_legal_5">Use/Con Other(s)
                <input type="checkbox" id="socio_legal_5" name="socio_legal_5"<?php if ($obj{"socio_legal_5"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				    <span class="columns">  <label class="container" for="socio_legal_6">Reliable
                <input type="checkbox" id="socio_legal_6" name="socio_legal_6"<?php if ($obj{"socio_legal_6"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                    <span class="columns">  <label class="container" for="socio_legal_7">Offensive/Property
                <input type="checkbox" id="socio_legal_7" name="socio_legal_7"<?php if ($obj{"socio_legal_7"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				    <span class="columns">  <label class="container" for="socio_legal_8">Offense/Person
                <input type="checkbox" id="socio_legal_8" name="socio_legal_8"<?php if ($obj{"socio_legal_8"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				</div>
		</fieldset>
        </li>
        <li id="li_28" class="section_break">
        <fieldset>
            <legend>Work or School</legend>
		
			<h3>Select: Work or School</h3>
			<div>
				<select class="element select small select-css" id="work_or_school_option" name="work_or_school_option"> 
					<option selected=""><?php echo stripslashes($obj{"work_or_school_option"});?></option>
					<option value="Work"  >Work</option>
					<option value="School"  >School</option>
				</select>
			</div>
			<label class="description" for="work_or_school">Rating 
			<span id="required_27" class="required">*</span></label>
			<span>
				<select class="element select small select-css" id="work_or_school" name="work_or_school">
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
			</span>
            <div>
			<label class="description">Symptoms/Assets </label>
            </div>
			<div>
                    <span class="columns">  <label class="container" for="work_or_school_1">Absenteeism
                <input type="checkbox" id="work_or_school_1" name="work_or_school_1"<?php if ($obj{"work_or_school_1"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="work_or_school_2">Poor Performance
                <input type="checkbox" id="work_or_school_2" name="work_or_school_2"<?php if ($obj{"work_or_school_2"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="work_or_school_3">Attends School
                <input type="checkbox" id="work_or_school_3" name="work_or_school_3"<?php if ($obj{"work_or_school_3"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                 <span class="columns">  <label class="container" for="work_or_school_4">Dropped Out
                <input type="checkbox" id="work_or_school_4" name="work_or_school_4"<?php if ($obj{"work_or_school_4"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="work_or_school_5">Learning Disability
                <input type="checkbox" id="work_or_school_5" name="work_or_school_5"<?php if ($obj{"work_or_school_5"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="work_or_school_6">Seeking Employment
                <input type="checkbox" id="work_or_school_6" name="work_or_school_6"<?php if ($obj{"work_or_school_6"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                 <span class="columns">  <label class="container" for="work_or_school_7">Employed
                <input type="checkbox" id="work_or_school_7" name="work_or_school_7"<?php if ($obj{"work_or_school_7"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                 <span class="columns">  <label class="container" for="work_or_school_8">Doesn't Read/Write
                <input type="checkbox" id="work_or_school_8" name="work_or_school_8"<?php if ($obj{"work_or_school_8"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
			    <span class="columns">  <label class="container" for="work_or_school_9">Tardiness
                <input type="checkbox" id="work_or_school_9" name="work_or_school_9"<?php if ($obj{"work_or_school_9"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                 <span class="columns">  <label class="container" for="work_or_school_10">Disabled
                <input type="checkbox" id="work_or_school_10" name="work_or_school_10"<?php if ($obj{"work_or_school_10"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                 <span class="columns">  <label class="container" for="work_or_school_11">Not Employed
                <input type="checkbox" id="work_or_school_11" name="work_or_school_11"<?php if ($obj{"work_or_school_11"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
			</div>
		</fieldset>
        </li>
        <li id="li_28" class="section_break">
        <fieldset>
            <legend>ADL Functioning</legend>
		
			
			<label class="description" for="adl_functioning">Rating 
			<span id="required_27" class="required">*</span></label>
			<span>
				<select class="element select small select-css" id="adl_functioning" name="adl_functioning">
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
			</span>
            <div>
			<label class="description">Symptoms/Assets </label>
            </div>
			<div>
                 <span class="columns">  <label class="container" for="adl_functioning_1">Money Management
                <input type="checkbox" id="adl_functioning_1" name="adl_functioning_1"<?php if ($obj{"adl_functioning_1"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                <span class="columns">  <label class="container" for="adl_functioning_2">Meal Preparation Difficulties
                <input type="checkbox" id="adl_functioning_2" name="adl_functioning_2"<?php if ($obj{"adl_functioning_2"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				<span class="columns">  <label class="container" for="adl_functioning_3">Personal Hygiene Problems
                <input type="checkbox" id="adl_functioning_3" name="adl_functioning_3"<?php if ($obj{"adl_functioning_3"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                <span class="columns">  <label class="container" for="adl_functioning_4">Transportation Problems
                <input type="checkbox" id="adl_functioning_4" name="adl_functioning_4"<?php if ($obj{"adl_functioning_4"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				<span class="columns">  <label class="container" for="adl_functioning_5">Problem Obtain/Maintain Employment
                <input type="checkbox" id="adl_functioning_5" name="adl_functioning_5"<?php if ($obj{"adl_functioning_5"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				<span class="columns">  <label class="container" for="adl_functioning_6">Problem Obtain/Maintain Housing
                <input type="checkbox" id="adl_functioning_6" name="adl_functioning_6"<?php if ($obj{"adl_functioning_6"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
			</div>
		</fieldset>
        </li>
        <li id="li_28" class="section_break">
        <fieldset>
            <legend>Ability to Care for Self</legend>
            
			
			<label class="description" for="ability_to_care_for_self">Rating 
			<span id="required_27" class="required">*</span></label>
			<span>
				<select class="element select small select-css" id="ability_to_care_for_self" name="ability_to_care_for_self">
				<option selected=""><?php echo stripslashes($obj{"ability_to_care_for_self"});?></option>
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
			</span>
            <div>
			<label class="description">Symptoms/Assets </label>
            </div>
			<div>
                 <span class="columns">  <label class="container" for="ability_to_care_for_self_1">Able to Care for Self
                <input type="checkbox" id="ability_to_care_for_self_1" name="ability_to_care_for_self_1"<?php if ($obj{"ability_to_care_for_self_1"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                 <span class="columns">  <label class="container" for="ability_to_care_for_self_2">Risk of Harm
                <input type="checkbox" id="ability_to_care_for_self_2" name="ability_to_care_for_self_2"<?php if ($obj{"ability_to_care_for_self_2"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="ability_to_care_for_self_3">Suffers from Neglect
                <input type="checkbox" id="ability_to_care_for_self_3" name="ability_to_care_for_self_3"<?php if ($obj{"ability_to_care_for_self_3"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                     </label></span>
            </div>
            <div>
                 <span class="columns">  <label class="container" for="ability_to_care_for_self_4">Refuse to Care for Self
                <input type="checkbox" id="ability_to_care_for_self_4" name="ability_to_care_for_self_4"<?php if ($obj{"ability_to_care_for_self_4"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="ability_to_care_for_self_5">Not Able to Survive w/o Help
                <input type="checkbox" id="ability_to_care_for_self_5" name="ability_to_care_for_self_5"<?php if ($obj{"ability_to_care_for_self_5"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="ability_to_care_for_self_8">Alternative Care Not Available
                <input type="checkbox" id="ability_to_care_for_self_8" name="ability_to_care_for_self_8"<?php if ($obj{"ability_to_care_for_self_8"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
			</div>
		</fieldset>
        </li>
        <li id="li_28" class="section_break">
        <fieldset>
            <legend>Danger to Self</legend>
            
			
			<label class="description" for="danger_to_self">Rating 
			<span id="required_27" class="required">*</span></label>
			<span>
				<select class="element select small select-css" id="danger_to_self" name="danger_to_self">
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
			</span>
            <div>
			<label class="description">Symptoms/Assets </label>
            </div>
			<div>
                 <span class="columns">  <label class="container" for="danger_to_self_1">Suicidal Ideation
                <input type="checkbox" id="danger_to_self_1" name="danger_to_self_1"<?php if ($obj{"danger_to_self_1"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                <span class="columns">  <label class="container" for="danger_to_self_2">Current Plan
                <input type="checkbox" id="danger_to_self_2" name="danger_to_self_2"<?php if ($obj{"danger_to_self_2"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				<span class="columns">  <label class="container" for="danger_to_self_3">Recent Attempt
                <input type="checkbox" id="danger_to_self_3" name="danger_to_self_3"<?php if ($obj{"danger_to_self_3"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                <span class="columns">  <label class="container" for="danger_to_self_4">Past Attempt
                <input type="checkbox" id="danger_to_self_4" name="danger_to_self_4"<?php if ($obj{"danger_to_self_4"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
               <span class="columns">  <label class="container" for="danger_to_self_5">Self-Injury
                <input type="checkbox" id="danger_to_self_5" name="danger_to_self_5"<?php if ($obj{"danger_to_self_5"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="danger_to_self_6">Self-Mutilation
                <input type="checkbox" id="danger_to_self_6" name="danger_to_self_6"<?php if ($obj{"danger_to_self_6"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
		</fieldset>
        </li>
        <li id="li_28" class="section_break">
        <fieldset>
            <legend>Danger to Others</legend>
		
			
			<label class="description" for="danger_to_others">Rating 
			<span id="required_27" class="required">*</span></label>
			<span>
				<select class="element select small select-css" id="danger_to_others" name="danger_to_others">
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
			</span>
            <div>
                <label class="description">Symptoms/Assets </label>
            </div>
			<div>
                <span class="columns">  <label class="container" for="danger_to_others_1">Violent Temper
                <input type="checkbox" id="danger_to_others_1" name="danger_to_others_1"<?php if ($obj{"danger_to_others_1"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				<span class="columns">  <label class="container" for="danger_to_others_2">Threatens Others
                <input type="checkbox" id="danger_to_others_2" name="danger_to_others_2"<?php if ($obj{"danger_to_others_2"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				<span class="columns">  <label class="container" for="danger_to_others_3">Physical Abuser
                <input type="checkbox" id="danger_to_others_3" name="danger_to_others_3"<?php if ($obj{"danger_to_others_3"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                <span class="columns">  <label class="container" for="danger_to_others_4">Homicidal Ideations
                <input type="checkbox" id="danger_to_others_4" name="danger_to_others_4"<?php if ($obj{"danger_to_others_4"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				<span class="columns">  <label class="container" for="danger_to_others_5">Hostile
                <input type="checkbox" id="danger_to_others_5" name="danger_to_others_5"<?php if ($obj{"danger_to_others_5"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                <span class="columns">  <label class="container" for="danger_to_others_6">Homicidal Threats
                <input type="checkbox" id="danger_to_others_6" name="danger_to_others_6"<?php if ($obj{"danger_to_others_6"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                <span class="columns">  <label class="container" for="danger_to_others_7">Assaultive
                <input type="checkbox" id="danger_to_others_7" name="danger_to_others_7"<?php if ($obj{"danger_to_others_7"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
			<span class="columns">  <label class="container" for="danger_to_others_8">Homicide Attempt
                <input type="checkbox" id="danger_to_others_8" name="danger_to_others_8"<?php if ($obj{"danger_to_others_8"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
			     <span class="columns">  <label class="container" for="danger_to_others_9">Does Not Appear Dangerous to Others
                <input type="checkbox" id="danger_to_others_9" name="danger_to_others_9"<?php if ($obj{"danger_to_others_9"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				</div>
		</fieldset>
        </li>
        <li id="li_28" class="section_break">
        <fieldset>
            <legend>Security/Management Needs</legend>
		
			
			<label class="description" for="security_management_needs">Rating 
			<span id="required_27" class="required">*</span></label>
			<span>
				<select class="element select small select-css" id="security_management_needs" name="security_management_needs">
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
			</span>
            <div>
			<label class="description">Symptoms/Assets </label>
            </div>
			<div>
                <span class="columns">  <label class="container" for="security_management_needs_1">Home w/o Supervision
                <input type="checkbox" id="security_management_needs_1" name="security_management_needs_1"<?php if ($obj{"security_management_needs_1"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				<span class="columns">  <label class="container" for="security_management_needs_2">Suicide Watch 
                <input type="checkbox" id="security_management_needs_2" name="security_management_needs_2"<?php if ($obj{"security_management_needs_2"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				<span class="columns">  <label class="container" for="security_management_needs_3">Behavioral Contract
                <input type="checkbox" id="security_management_needs_3" name="security_management_needs_3"<?php if ($obj{"security_management_needs_3"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                <span class="columns">  <label class="container" for="security_management_needs_4">Locked Unit
                <input type="checkbox" id="security_management_needs_4" name="security_management_needs_4"<?php if ($obj{"security_management_needs_4"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                 <span class="columns">  <label class="container" for="security_management_needs_5">Protecton from Others
                <input type="checkbox" id="security_management_needs_5" name="security_management_needs_5"<?php if ($obj{"security_management_needs_5"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
				 <span class="columns">  <label class="container" for="security_management_needs_6">Seclusion
                <input type="checkbox" id="security_management_needs_6" name="security_management_needs_6"<?php if ($obj{"security_management_needs_6"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                <span class="columns">  <label class="container" for="security_management_needs_7">Home w/ Supervision
                <input type="checkbox" id="security_management_needs_7" name="security_management_needs_7"<?php if ($obj{"security_management_needs_7"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
                 <span class="columns">  <label class="container" for="security_management_needs_8">Run/Escape Risk
                <input type="checkbox" id="security_management_needs_8" name="security_management_needs_8"<?php if ($obj{"security_management_needs_8"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
			     <span class="columns">  <label class="container" for="security_management_needs_9">Restraint
                <input type="checkbox" id="security_management_needs_9" name="security_management_needs_9"<?php if ($obj{"security_management_needs_9"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
            </div>
            <div>
                <span class="columns">  <label class="container" for="security_management_needs_10">Involuntary Exam/Commitment
                <input type="checkbox" id="security_management_needs_10" name="security_management_needs_10"<?php if ($obj{"security_management_needs_10"} == "on") {echo "checked";};?>
               class ="choice">
                <span class="checkmark" ></span>
                      </label></span>
			</div>
		</fieldset>
        </li>
