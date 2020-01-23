<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CFARS</title>
<link rel="stylesheet" type="text/css" href=".../../forms/cfars/form_11709/css/view.css" media="all" />
<link rel="stylesheet" type="text/css" href="../../forms/cfars/themes/theme_23.css" media="all" />

<script type="text/javascript" src="../../forms/cfars/jquery.min.js"></script>
<script type="text/javascript" src="../../forms/cfars/jquery-ui/ui/jquery.effects.core.js"></script>
<script type="text/javascript" src="../../forms/cfars/view.js"></script>




</head>
<body id="main_body" class=" no_guidelines">
	
	<div id="form_container" class="WarpShadow WLarge WNormal">
	
		<h1><a>CFARS</a></h1>
		<form id="form_11709" class="appnitro top_label"  method="post" data-highlightcolor="#FFF7C0" action="#main_body">
					<div class="form_description">
			<h2>CFARS</h2>
			<p>This is your form description. Click here to edit.</p>
		</div>						
			<ul >
			
			
			
					<li id="li_1"  >
		<label class="description">DCF Outcomes Report <span id="required_1" class="required">*</span></label>
		<div>
			<select class="element select medium" id="element_1" name="element_1"> 
			<option value="Admission to Provider" > Admission to Provider</option>
			
<option value="Post Admission Evaluation(e.g., six months, annual, etc.)"> Post Admission Evaluation(e.g., six months, annual, etc.)</option>
<option value="Discharge from Provider"> Discharge from Provider</option>
<option value="Administrative/Immediate Discharge"> Administrative/Immediate Discharge</option>
<option value="None of the Above"> None of the Above</option>
</select>

		</div> 
		</li>		<li id="li_2"  >
		<label class="description">Program Evaluation<br />
(Optional) </label>
		<div>
			<span><input id="element_2_1"  name="element_2" class="element radio" type="radio" value="1"  />
<label class="choice" for="element_2_1">Admission to Program</label>
</span>
<span><input id="element_2_2"  name="element_2" class="element radio" type="radio" value="2"  />
<label class="choice" for="element_2_2">6 Months After Admission to Program</label>
</span>
<span><input id="element_2_6"  name="element_2" class="element radio" type="radio" value="6"  />
<label class="choice" for="element_2_6">Annually After Admission to Program</label>
</span>
<span><input id="element_2_3"  name="element_2" class="element radio" type="radio" value="3"  />
<label class="choice" for="element_2_3">Planned Discharge from, or Transfer to another Program within agency</label>
</span>
<span><input id="element_2_4"  name="element_2" class="element radio" type="radio" value="4"  />
<label class="choice" for="element_2_4">Administrative/Immediate Discharge</label>
</span>
<span><input id="element_2_5"  name="element_2" class="element radio" type="radio" value="5"  />
<label class="choice" for="element_2_5">None of the above</label>
</span>

		</div> 
		</li>		<li id="li_3"  >
		<label class="description" for="element_3">DSM-IV Code for Primary Diagnosis </label>
		<div>
		<select class="element select medium" id="element_3" name="element_3"> 
			<option value="" selected="selected"></option>
<option value="1"  >000.00</option>
<option value="2"  >111.11</option>
<option value="3"  >222.22</option>

		</select>
		</div> 
		</li>		<li id="li_4"  >
		<label class="description" for="element_4">DSM-IV Code for Secondary Diagnosis </label>
		<div>
		<select class="element select medium" id="element_4" name="element_4"> 
			<option value="" selected="selected"></option>
<option value="1"  >333.33</option>
<option value="2"  >444.44</option>
<option value="3"  >555.55</option>

		</select>
		</div> 
		</li>		<li id="li_5"  class="inline_columns">
		<label class="description">Substance Abuse History <span id="required_5" class="required">*</span></label>
		<div>
			<span><input id="element_5_1"  name="element_5" class="element radio" type="radio" value="1"  />
<label class="choice" for="element_5_1">Yes</label>
</span>
<span><input id="element_5_2"  name="element_5" class="element radio" type="radio" value="2"  />
<label class="choice" for="element_5_2">No</label>
</span>

		</div> 
		</li>		<li id="li_6" >
		<label class="description" for="element_6">CFARS Rater's Notes (Optional): </label>
		<div>
			<textarea id="element_6" name="element_6" class="element textarea medium" rows="8" cols="90" onkeyup="limit_input(6,'c',250);" onchange="limit_input(6,'c',250);"></textarea>
			<label for="element_6">Maximum of <var id="range_max_6">250</var> characters allowed.&nbsp;&nbsp; <em class="currently_entered">Currently Entered: <var id="currently_entered_6">0</var> characters.</em></label> 
		</div> 
		</li>		<li id="li_7" class="section_break">
			<h3>CFARS Problem Severity Ratings</h3>
			<p></p>
		</li>		<li id="li_8" class="section_break">
			<h3>Depression</h3>
			<p></p>
		</li>		<li id="li_12"  >
		<label class="description" for="element_12">Rating <span id="required_12" class="required">*</span></label>
		<div>
		<select class="element select small" id="element_12" name="element_12"> 
			<option value="" selected="selected"></option>
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
		</li>		<li id="li_10"  class="three_columns">
		<label class="description">Symptoms/Assets </label>
		<div>
			<span><input id="element_10_1"  name="element_10_1" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_10_1">Depressed Mood</label>
</span>
<span><input id="element_10_2"  name="element_10_2" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_10_2">Happy</label>
</span>
<span><input id="element_10_3"  name="element_10_3" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_10_3">Sleep Problems</label>
</span>
<span><input id="element_10_9"  name="element_10_9" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_10_9">Sad</label>
</span>
<span><input id="element_10_8"  name="element_10_8" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_10_8">Hopeless</label>
</span>
<span><input id="element_10_7"  name="element_10_7" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_10_7">Laks Energy/Interst</label>
</span>
<span><input id="element_10_6"  name="element_10_6" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_10_6">Irritable</label>
</span>
<span><input id="element_10_5"  name="element_10_5" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_10_5">Withdrawn</label>
</span>
<span><input id="element_10_4"  name="element_10_4" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_10_4">Anti-Depression Meds</label>
</span>

		</div> 
		</li>		<li id="li_11" class="section_break bold">
			<h3>Anxiety</h3>
			<p></p>
		</li>		<li id="li_9"  >
		<label class="description" for="element_9">Rating <span id="required_9" class="required">*</span></label>
		<div>
		<select class="element select small" id="element_9" name="element_9"> 
			<option value="" selected="selected"></option>
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
		</li>		<li id="li_13"  class="three_columns">
		<label class="description">Symptoms/Assets </label>
		<div>
			<span><input id="element_13_1"  name="element_13_1" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_13_1">Anxious/Tense</label>
</span>
<span><input id="element_13_2"  name="element_13_2" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_13_2">Calm</label>
</span>
<span><input id="element_13_3"  name="element_13_3" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_13_3">Guilt</label>
</span>
<span><input id="element_13_9"  name="element_13_9" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_13_9">Phobic</label>
</span>
<span><input id="element_13_8"  name="element_13_8" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_13_8">Worried/Fearful</label>
</span>
<span><input id="element_13_7"  name="element_13_7" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_13_7">Ant-Anxiety Meds</label>
</span>
<span><input id="element_13_6"  name="element_13_6" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_13_6">Obsessive/Compulsive</label>
</span>
<span><input id="element_13_5"  name="element_13_5" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_13_5">Panic</label>
</span>

		</div> 
		</li>		<li id="li_15" class="section_break bold">
			<h3>Hyperactivity</h3>
			<p></p>
		</li>		<li id="li_19"  >
		<label class="description" for="element_19">Rating <span id="required_19" class="required">*</span></label>
		<div>
		<select class="element select small" id="element_19" name="element_19"> 
			<option value="" selected="selected"></option>
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
		</li>		<li id="li_17"  class="three_columns">
		<label class="description">Symptoms/Assets </label>
		<div>
			<span><input id="element_17_1"  name="element_17_1" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_17_1">Manic</label>
</span>
<span><input id="element_17_2"  name="element_17_2" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_17_2">Inattentive</label>
</span>
<span><input id="element_17_3"  name="element_17_3" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_17_3">Agitated</label>
</span>
<span><input id="element_17_9"  name="element_17_9" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_17_9">Sleep Deficit</label>
</span>
<span><input id="element_17_8"  name="element_17_8" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_17_8">Overactive/Hyperactive</label>
</span>
<span><input id="element_17_7"  name="element_17_7" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_17_7">Mood Swings</label>
</span>
<span><input id="element_17_6"  name="element_17_6" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_17_6">Pressured Speech</label>
</span>
<span><input id="element_17_5"  name="element_17_5" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_17_5">Relaxed</label>
</span>
<span><input id="element_17_10"  name="element_17_10" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_17_10">Impulsivity</label>
</span>
<span><input id="element_17_11"  name="element_17_11" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_17_11">ADHD Meds</label>
</span>
<span><input id="element_17_12"  name="element_17_12" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_17_12">Anti-Manic Meds</label>
</span>

		</div> 
		</li>		<li id="li_18" class="section_break bold">
			<h3>XXHyperactivity</h3>
			<p></p>
		</li>		<li id="li_16"  >
		<label class="description" for="element_16">Rating <span id="required_16" class="required">*</span></label>
		<div>
		<select class="element select small" id="element_16" name="element_16"> 
			<option value="" selected="selected"></option>
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
		</li>		<li id="li_20"  class="three_columns">
		<label class="description">Symptoms/Assets </label>
		<div>
			XX<span><input id="element_20_1"  name="element_20_1" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_20_1">Manic</label>
</span>
<span><input id="element_20_2"  name="element_20_2" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_20_2">Inattentive</label>
</span>
<span><input id="element_20_3"  name="element_20_3" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_20_3">Agitated</label>
</span>
<span><input id="element_20_9"  name="element_20_9" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_20_9">Sleep Deficit</label>
</span>
<span><input id="element_20_8"  name="element_20_8" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_20_8">Overactive/Hyperactive</label>
</span>
<span><input id="element_20_7"  name="element_20_7" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_20_7">Mood Swings</label>
</span>
<span><input id="element_20_6"  name="element_20_6" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_20_6">Pressured Speech</label>
</span>
<span><input id="element_20_5"  name="element_20_5" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_20_5">Relaxed</label>
</span>
<span><input id="element_20_10"  name="element_20_10" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_20_10">Impulsivity</label>
</span>
<span><input id="element_20_11"  name="element_20_11" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_20_11">ADHD Meds</label>
</span>
<span><input id="element_20_12"  name="element_20_12" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_20_12">Anti-Manic Meds</label>
</span>

		</div> 
		</li>		<li id="li_21" class="section_break bold">
			<h3>Thought Process</h3>
			<p></p>
		</li>		<li id="li_22"  >
		<label class="description" for="element_22">Rating <span id="required_22" class="required">*</span></label>
		<div>
		<select class="element select small" id="element_22" name="element_22"> 
			<option value="" selected="selected"></option>
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
		</li>		<li id="li_23"  class="three_columns">
		<label class="description">Symptoms/Assets </label>
		<div>
			<span><input id="element_23_14"  name="element_23_14" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_23_14">Illogical</label>
</span>
<span><input id="element_23_15"  name="element_23_15" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_23_15">Delusional</label>
</span>
<span><input id="element_23_16"  name="element_23_16" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_23_16">Hallucinations</label>
</span>
<span><input id="element_23_17"  name="element_23_17" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_23_17">Paranoid</label>
</span>
<span><input id="element_23_18"  name="element_23_18" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_23_18">Ruminative</label>
</span>
<span><input id="element_23_19"  name="element_23_19" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_23_19">Command Hallucination</label>
</span>
<span><input id="element_23_20"  name="element_23_20" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_23_20">Derailed Thinking</label>
</span>
<span><input id="element_23_21"  name="element_23_21" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_23_21">Loose Associations</label>
</span>
<span><input id="element_23_22"  name="element_23_22" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_23_22">Intact</label>
</span>
<span><input id="element_23_23"  name="element_23_23" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_23_23">Oriented</label>
</span>
<span><input id="element_23_24"  name="element_23_24" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_23_24">Disoriented</label>
</span>
<span><input id="element_23_25"  name="element_23_25" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_23_25">Anti-Psych. Med.</label>
</span>

		</div> 
		</li>		<li id="li_24" class="section_break bold">
			<h3>Cognitive Performance</h3>
			<p></p>
		</li>		<li id="li_25"  >
		<label class="description" for="element_25">Rating <span id="required_25" class="required">*</span></label>
		<div>
		<select class="element select small" id="element_25" name="element_25"> 
			<option value="" selected="selected"></option>
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
		</li>		<li id="li_26"  class="two_columns">
		<label class="description">Symptoms/Assets </label>
		<div>
<span><input id="element_26_1"  name="element_26_1" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_26_1">Poor Memory</label>
</span>
<span><input id="element_26_2"  name="element_26_5" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_26_5">Low Self-Awareness</label>
</span>
<span><input id="element_26_3"  name="element_26_6" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_26_6">Poor Attention/Concentration</label>
</span>
<span><input id="element_26_4"  name="element_26_7" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_26_7">Development Disability</label>
</span>
<span><input id="element_26_5"  name="element_26_8" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_26_8">Insightful</label>
</span>
<span><input id="element_26_6"  name="element_26_9" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_26_9">Concrete Thinking</label>
</span>
<span><input id="element_26_7"  name="element_26_10" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_26_10">Impaired Judgment</label>
</span>
<span><input id="element_26_8"  name="element_26_8" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_26_18">Slow Processing</label>
</span>

		</div> 
		</li>		<li id="li_28" class="section_break bold">
			<h3>Medical / Physical</h3>
			<p></p>
		</li>		<li id="li_27"  >
		<label class="description" for="element_27">Rating <span id="required_27" class="required">*</span></label>
		<div>
		<select class="element select small" id="element_27" name="element_27"> 
			<option value="" selected="selected"></option>
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
		</li>		<li id="li_29"  class="three_columns">
		<label class="description">Symptoms/Assets </label>
		<div>
<span><input id="element_29_1"  name="element_29_1" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_1">Acute Illness</label>
</span>
<span><input id="element_29_2"  name="element_29_2" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_2">Hypochondria</label>
</span>
<span><input id="element_29_3"  name="element_29_3" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_3">Good Health</label>
</span>
<span><input id="element_29_4"  name="element_29_4" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_4">CNS Disorder</label>
</span>
<span><input id="element_29_5"  name="element_29_5" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_5">Chronic Illness</label>
</span>
<span><input id="element_29_6"  name="element_29_6" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_6">Need. Med/Dental Care</label>
</span>
<span><input id="element_29_7"  name="element_29_7" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_7">Pregnant</label>
</span>
<span><input id="element_29_8"  name="element_29_8" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_8">Poor Nutrition</label>
</span>
<span><input id="element_29_9"  name="element_29_9" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_9">Enuretic/Encopretic</label>
</span>
<span><input id="element_29_10"  name="element_29_10" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_10">Eating Disorder</label>
</span>
<span><input id="element_29_11"  name="element_29_11" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_11">Seizures</label>
</span>
<span><input id="element_29_12"  name="element_29_12" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_12">Stress-Related Illness</label>
</span>

		</div> 
		</li>
			
			<li id="li_28" class="section_break bold">
			<h3>Traumatic Stress</h3>
			<p></p>
		</li>		<li id="li_27"  >
		<label class="description" for="element_27">Rating <span id="required_27" class="required">*</span></label>
		<div>
		<select class="element select small" id="element_27" name="element_27"> 
			<option value="" selected="selected"></option>
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
		</li>		<li id="li_29"  class="three_columns">
		<label class="description">Symptoms/Assets </label>
		<div>
<span><input id="element_29_1"  name="element_29_1" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_1">Acute</label>
</span>
<span><input id="element_29_2"  name="element_29_2" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_2">Dreams/Nightmares</label>
</span>
<span><input id="element_29_3"  name="element_29_3" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_3">Chronic</label>
</span>
<span><input id="element_29_4"  name="element_29_4" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_4">Detached</label>
</span>
<span><input id="element_29_5"  name="element_29_5" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_5">Avoidance</label>
</span>
<span><input id="element_29_6"  name="element_29_6" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_6">Repression/Amnesia</label>
</span>
<span><input id="element_29_7"  name="element_29_7" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_7">Upseting Memories</label>
</span>
<span><input id="element_29_8"  name="element_29_8" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_8">Hyper vigilance</label>
</span>

		</div> 
		</li>
<li id="li_28" class="section_break bold">
			<h3>Substance Use</h3>
			<p></p>
		</li>		<li id="li_27"  >
		<label class="description" for="element_27">Rating <span id="required_27" class="required">*</span></label>
		<div>
		<select class="element select small" id="element_27" name="element_27"> 
			<option value="" selected="selected"></option>
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
		</li>		<li id="li_29"  class="three_columns">
		<label class="description">Symptoms/Assets </label>
		<div>
			<span><input id="element_29_1"  name="element_29_1" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_1">Alcohol</label>
</span>
<span><input id="element_29_2"  name="element_29_2" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_2">Drug(s)</label>
</span>
<span><input id="element_29_3"  name="element_29_3" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_3">Dependance</label>
</span>
<span><input id="element_29_4"  name="element_29_4" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_4">Abuse</label>
</span>
<span><input id="element_29_5"  name="element_29_5" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_5">Over the Counter Drugs</label>
</span>
<span><input id="element_29_6"  name="element_29_6" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_6">Craving/Urges</label>
</span>
<span><input id="element_29_7"  name="element_29_7" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_7">DUI</label>
</span>
<span><input id="element_29_8"  name="element_29_8" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_8">Abstinent</label>
</span>
<span><input id="element_29_9"  name="element_29_9" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_9">I.V. Drugs</label>
</span>
<span><input id="element_29_10"  name="element_29_10" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_10">Recovery</label>
</span>
<span><input id="element_29_11"  name="element_29_11" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_11">Interfere w/Functioning</label>
</span>
<span><input id="element_29_12"  name="element_29_12" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_12">Med. Control</label>
</span>

		</div> 
		</li>
		<li id="li_28" class="section_break bold">
			<h3>Interpersonal Relationships</h3>
			<p></p>
		</li>		<li id="li_27"  >
		<label class="description" for="element_27">Rating <span id="required_27" class="required">*</span></label>
		<div>
		<select class="element select small" id="element_27" name="element_27"> 
			<option value="" selected="selected"></option>
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
		</li>		<li id="li_29"  class="three_columns">
		<label class="description">Symptoms/Assets </label>
		<div>
			<span><input id="element_29_1"  name="element_29_1" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_1">Problems w/Friends</label>
</span>
<span><input id="element_29_2"  name="element_29_2" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_2">Diff. Estab./Maintain Relationships</label>
</span>
<span><input id="element_29_3"  name="element_29_3" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_3">Poor Social Skills</label>
</span>
<span><input id="element_29_4"  name="element_29_4" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_4">Age-Appropriate Group Participation</label>
</span>
<span><input id="element_29_5"  name="element_29_5" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_5">Adequate Social Skills</label>
</span>
<span><input id="element_29_6"  name="element_29_6" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_6">Supportive Relationships</label>
</span>
<span><input id="element_29_7"  name="element_29_7" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_7">Overly Shy</label>
</span>

		</div> 
		</li>
<li id="li_28" class="section_break bold">
			<h3>Behavior in &quot;Home&quot; Setting</h3>
			<p></p>
		</li>		<li id="li_27"  >
		<label class="description" for="element_27">Rating <span id="required_27" class="required">*</span></label>
		<div>
		<select class="element select small" id="element_27" name="element_27"> 
			<option value="" selected="selected"></option>
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
		</li>		<li id="li_29"  class="three_columns">
		<label class="description">Symptoms/Assets </label>
		<div>
			<span><input id="element_29_1"  name="element_29_1" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_1">Disregard Rules</label>
</span>
<span><input id="element_29_2"  name="element_29_2" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_2">Defies Authority</label>
</span>
<span><input id="element_29_3"  name="element_29_3" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_3">Conflict w/Sibling or Peer</label>
</span>
<span><input id="element_29_4"  name="element_29_4" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_4">Conflict w/Parent or Caregiver</label>
</span>
<span><input id="element_29_5"  name="element_29_5" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_5">Conflict w/Relative</label>
</span>
<span><input id="element_29_6"  name="element_29_6" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_6">Respectful</label>
</span>
<span><input id="element_29_7"  name="element_29_7" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_7">Responsipble</label>
</span>

		</div> 
		</li>
<li id="li_28" class="section_break bold">
			<h3>ADL Functioning</h3>
			<p></p>
		</li>		<li id="li_27"  >
		<label class="description" for="element_27">Rating <span id="required_27" class="required">*</span></label>
		<div>
		<select class="element select small" id="element_27" name="element_27"> 
			<option value="" selected="selected"></option>
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
		</li>		<li id="li_29"  class="three_columns">
		<label class="description">Symptoms/Assets </label>
		<div>
			<span><input id="element_29_1"  name="element_29_1" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_1">Handicapped</label>
</span>
<span><input id="element_29_2"  name="element_29_2" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_2">Permanent Disability</label>
</span>
<span><input id="element_29_3"  name="element_29_3" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_3">No Known Limitations</label>
</span>
Not Age Appropriate In:
<span><input id="element_29_4"  name="element_29_4" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_4">Communication</label>
</span>
<span><input id="element_29_5"  name="element_29_5" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_5">Self-Care</label>
</span>
<span><input id="element_29_6"  name="element_29_6" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_6">Hygiene</label>
</span>
<span><input id="element_29_7"  name="element_29_7" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_7">Recreation</label>
</span>
<span><input id="element_29_8"  name="element_29_8" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_8">Mobility</label>
</span>

		</div> 
		</li>
<li id="li_28" class="section_break bold">
			<h3>Socio-Legal</h3>
			<p></p>
		</li>		<li id="li_27"  >
		<label class="description" for="element_27">Rating <span id="required_27" class="required">*</span></label>
		<div>
		<select class="element select small" id="element_27" name="element_27"> 
			<option value="" selected="selected"></option>
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
		</li>		<li id="li_29"  class="three_columns">
		<label class="description">Symptoms/Assets </label>
		<div>
			<span><input id="element_29_1"  name="element_29_1" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_1">Disregard Rules</label>
</span>
<span><input id="element_29_2"  name="element_29_2" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_2">Offense/Property</label>
</span>
<span><input id="element_29_3"  name="element_29_3" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_3">Offense/Person</label>
</span>
<span><input id="element_29_4"  name="element_29_4" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_4">Fire Setting</label>
</span>
<span><input id="element_29_5"  name="element_29_5" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_5">Comm. Control/Re-entry</label>
</span>
<span><input id="element_29_6"  name="element_29_6" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_6">Pending Charges</label>
</span>
<span><input id="element_29_7"  name="element_29_7" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_7">Dishonest</label>
</span>
<span><input id="element_29_8"  name="element_29_8" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_8">Incompetent to Proceed</label>
</span>
<span><input id="element_29_9"  name="element_29_9" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_9">Detention/Commitment</label>
</span>
<span><input id="element_29_10"  name="element_29_10" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_10">Use/Con Other(s)</label>
</span>
<span><input id="element_29_11"  name="element_29_11" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_11">Street Gang Member</label>
</span>

		</div> 
		</li>
<li id="li_28" class="section_break bold">
			<h3>Select: Work or School</h3>
			<div>
		<select class="element select small" id="element_27" name="element_27"> 
			<option value="" selected="selected"></option>
<option value="Work"  >Work</option>
<option value="School"  >School</option>
		</select>
		</div> 
					
			<p></p>
		</li>		<li id="li_27"  >
		<label class="description" for="element_27">Rating <span id="required_27" class="required">*</span></label>
		<div>
		<select class="element select small" id="element_27" name="element_27"> 
			<option value="" selected="selected"></option>
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
		</li>		<li id="li_29"  class="three_columns">
		<label class="description">Symptoms/Assets </label>
		<div>
			<span><input id="element_29_1"  name="element_29_1" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_1">Absenteeism</label>
</span>
<span><input id="element_29_2"  name="element_29_2" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_2">Poor Performance</label>
</span>
<span><input id="element_29_3"  name="element_29_3" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_3">Regular</label>
</span>
<span><input id="element_29_4"  name="element_29_4" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_4">Dropped Out</label>
<input id="element_29_5"  name="element_29_5" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_5">Learning Disability</label>
<input id="element_29_6"  name="element_29_6" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_6">Seeking</label>
<input id="element_29_7"  name="element_29_7" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_7">Employed</label>
<input id="element_29_8"  name="element_29_8" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_8">Doesn't Read/Write</label>
<input id="element_29_9"  name="element_29_9" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_9">Tardiness</label>
<input id="element_29_10"  name="element_29_10" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_10">Defies Authority</label>
<input id="element_29_11"  name="element_29_11" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_11">Not Emplyed</label>
<input id="element_29_12"  name="element_29_12" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_12">Suspended</label>
<input id="element_29_13"  name="element_29_13" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_13">Disruptive</label>
<input id="element_29_14"  name="element_29_14" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_14">Terminated/Expelled</label>
<input id="element_29_15"  name="element_29_15" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_15">Skips Class</label>
</span>

		</div> 
		</li>
<li id="li_28" class="section_break bold">
			<h3>Danger to Self</h3>
			<p></p>
		</li>		<li id="li_27"  >
		<label class="description" for="element_27">Rating <span id="required_27" class="required">*</span></label>
		<div>
		<select class="element select small" id="element_27" name="element_27"> 
			<option value="" selected="selected"></option>
<option value="1"  >1</option>
<option value="2"  >2</option>
<option value="3"  >3</option>
<option value="4"  >4</option>
<option value="5"  >5</option>
<option value="6"  >6</option>
<option value="7"  >7</option>
<option value="8"  >8</option>
<option value="9"  >9</option>

		</select>
		</div> 
		</li>		<li id="li_29"  class="three_columns">
		<label class="description">Symptoms/Assets </label>
		<div>
			<span><input id="element_29_1"  name="element_29_1" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_1">First option</label>
</span>
<span><input id="element_29_2"  name="element_29_2" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_2">Second option</label>
</span>
<span><input id="element_29_3"  name="element_29_3" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_3">Third option</label>
</span>
<span><input id="element_29_4"  name="element_29_4" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_4">Acute Illness</label>
</span>
<span><input id="element_29_5"  name="element_29_5" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_5">Hypochondria</label>
</span>
<span><input id="element_29_6"  name="element_29_6" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_6">Good Health</label>
</span>
<span><input id="element_29_7"  name="element_29_7" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_7">CNS Disorder</label>
</span>
<span><input id="element_29_8"  name="element_29_8" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_8">Chronic Illness</label>
</span>
<span><input id="element_29_9"  name="element_29_9" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_9">Need. Med/Dental Care</label>
</span>
<span><input id="element_29_10"  name="element_29_10" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_10">Pregnant</label>
</span>

		</div> 
		</li>
<li id="li_28" class="section_break bold">
			<h3>Danger to Others</h3>
			<p></p>
		</li>		<li id="li_27"  >
		<label class="description" for="element_27">Rating <span id="required_27" class="required">*</span></label>
		<div>
		<select class="element select small" id="element_27" name="element_27"> 
			<option value="" selected="selected"></option>
<option value="1"  >1</option>
<option value="2"  >2</option>
<option value="3"  >3</option>
<option value="4"  >4</option>
<option value="5"  >5</option>
<option value="6"  >6</option>
<option value="7"  >7</option>
<option value="8"  >8</option>
<option value="9"  >9</option>

		</select>
		</div> 
		</li>		<li id="li_29"  class="three_columns">
		<label class="description">Symptoms/Assets </label>
		<div>
			<span><input id="element_29_1"  name="element_29_1" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_1">First option</label>
</span>
<span><input id="element_29_2"  name="element_29_2" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_2">Second option</label>
</span>
<span><input id="element_29_3"  name="element_29_3" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_3">Third option</label>
</span>
<span><input id="element_29_4"  name="element_29_4" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_4">Acute Illness</label>
</span>
<span><input id="element_29_5"  name="element_29_5" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_5">Hypochondria</label>
</span>
<span><input id="element_29_6"  name="element_29_6" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_6">Good Health</label>
</span>
<span><input id="element_29_7"  name="element_29_7" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_7">CNS Disorder</label>
</span>
<span><input id="element_29_8"  name="element_29_8" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_8">Chronic Illness</label>
</span>
<span><input id="element_29_9"  name="element_29_9" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_9">Need. Med/Dental Care</label>
</span>
<span><input id="element_29_10"  name="element_29_10" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_10">Pregnant</label>
</span>
<span><input id="element_29_11"  name="element_29_11" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_11">Poor Nutrition</label>
</span>
<span><input id="element_29_12"  name="element_29_12" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_12">Enuretic/Encopretic</label>
</span>

		</div> 
		</li>
<li id="li_28" class="section_break bold">
			<h3>Security/Management Needs</h3>
			<p></p>
		</li>		<li id="li_27"  >
		<label class="description" for="element_27">Rating <span id="required_27" class="required">*</span></label>
		<div>
		<select class="element select small" id="element_27" name="element_27"> 
			<option value="" selected="selected"></option>
<option value="1"  >1</option>
<option value="2"  >2</option>
<option value="3"  >3</option>
<option value="4"  >4</option>
<option value="5"  >5</option>
<option value="6"  >6</option>
<option value="7"  >7</option>
<option value="8"  >8</option>
<option value="9"  >9</option>

		</select>
		</div> 
		</li>		<li id="li_29"  class="three_columns">
		<label class="description">Symptoms/Assets </label>
		<div>
			<span><input id="element_29_1"  name="element_29_1" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_1">First option</label>
</span>
<span><input id="element_29_2"  name="element_29_2" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_2">Second option</label>
</span>
<span><input id="element_29_3"  name="element_29_3" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_3">Third option</label>
</span>
<span><input id="element_29_4"  name="element_29_4" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_4">Acute Illness</label>
</span>
<span><input id="element_29_5"  name="element_29_5" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_5">Hypochondria</label>
</span>
<span><input id="element_29_6"  name="element_29_6" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_6">Good Health</label>
</span>
<span><input id="element_29_7"  name="element_29_7" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_7">CNS Disorder</label>
</span>
<span><input id="element_29_8"  name="element_29_8" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_8">Chronic Illness</label>
</span>
<span><input id="element_29_9"  name="element_29_9" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_9">Need. Med/Dental Care</label>
</span>
<span><input id="element_29_10"  name="element_29_10" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_10">Pregnant</label>
</span>
<span><input id="element_29_11"  name="element_29_11" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_11">Poor Nutrition</label>
</span>
<span><input id="element_29_12"  name="element_29_12" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_12">Enuretic/Encopretic</label>
</span>
<span><input id="element_29_13"  name="element_29_13" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_13">Eating Disorder</label>
</span>
<span><input id="element_29_14"  name="element_29_14" class="element checkbox" type="checkbox" value="1"  />
<label class="choice" for="element_29_14">Seizures</label>
</span>


		</div> 
		</li>


			
					<li id="li_buttons" class="buttons">
			    <input type="hidden" name="form_id" value="11709" />
			    
			    <input type="hidden" name="submit_form" value="1" />
			    <input type="hidden" name="page_number" value="1" />
				<input id="submit_form" class="button_text" type="submit" name="submit_form" value="Submit" />
		</li>
			</ul>
		</form>	
		<div id="footer">
		</div>
	</div>
	
	</body>
</html>