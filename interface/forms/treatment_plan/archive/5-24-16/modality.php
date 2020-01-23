      <h3>Modalities</h3>
      <p></p>
      
     
      
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<script>    
$(document).ready(function(){

var i = $('input').size() + 1;

$('#add').click(function() {
$('<div>' +
'<select name="modality_1">' +
	'<option></option>' +
	'<option>Individual Therapy</option>' +
	'<option>Psych Eval</option>' +
	'</select><select name="HSCP_Code1">' +
	'<option></option>' +
	'<option>H2019HR</option>' +
	'<option>H2017</option>' +
	'</select><select name="Interval1">' +
	'<option></option>' +
	'<option>1</option>' +
	'<option>2</option>' +
	'</select><select name="Frequency1">' +
	'<option></option>' +
	'<option>Daily</option>' +
	'<option>Weekly</option>' +
	'</select><select name="Provider1">' +
	'<option></option>' +
	'<option>Yves Charles</option>' +
	'<option>Janet Ward</option>' +
	'</select>' +

'<input type="text" class="field" name="dynamic[]" value="' + 
i + '" /></div>').fadeIn('slow').appendTo('.inputs');
i++;
});

$('#remove').click(function() {
if(i > 1) {
$('.field:last').remove();
i--;
}
});

$('#reset').click(function() {
while(i > 2) {
$('.field:last').remove();
i--;
}
});

// here's our click function for when the forms submitted

$('.submit').click(function(){

var answers = [];
$.each($('.field'), function() {
answers.push($(this).val());
});

if(answers.length == 0) {
answers = "none";
}

alert(answers);

return false;

});

});
      
 </script>     
 
 <style>
input{
	border:1px solid #ccc;
	padding:8px;
	font-size:14px;
	width:300px;
	}
	
.submit{
	width:110px;
	background-color:#FF6;
	padding:3px;
	border:1px solid #FC0;
	margin-top:20px;}	

</style>

</head>

<body>

<noscript><div id="noscript">You need JavaScript enabled to view most of the demos!</div></noscript>


<a href="#" id="add">Add</a> | <a href="#" id="remove">Remove</a>  | <a href="#" id="reset">Reset</a>  

<form>
<div class="inputs">
<div>
<select name="modality[]">
	<option></option>
	<option>Individual Therapy</option>
	<option>Psych Eval</option>


<input type="text" name="dynamic[]" class="field" value="1"/></div>
</div>
<input name="submit" type="button" class="submit" value="Submit" />
</form>
</div>






</div>
      
      
      
     <p>Modality&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HCPT Code  &nbsp;&nbsp;Interval  &nbsp;&nbsp;Frequency  &nbsp;&nbsp;Responsible Provider</p>







    <select name="modality_1">
	<option></option>
	<option>Individual Therapy</option>
	<option>Psych Eval</option>
	</select><select name="HSCP_Code1">
	<option></option>
	<option>H2019HR</option>
	<option>H2017</option>
	</select><select name="Interval1">
	<option></option>
	<option>1</option>
	<option>2</option>
	</select><select name="Frequency1">
	<option></option>
	<option>Daily</option>
	<option>Weekly</option>
	</select><select name="Provider1">
	<option></option>
	<option>Yves Charles</option>
	<option>Janet Ward</option>
	</select>
    <button name="select1">Select</button>
    <button name="clear1">Clear</button>
      <p></p>
 <select name="Modality2">
	<option></option>
	<option>Individual Therapy</option>
	<option>Psych Eval</option>
	</select><select name="HSCP_Code2">
	<option></option>
	<option>H2019HR</option>
	<option>H2017</option>
	</select><select name="Interval2">
	<option></option>
	<option>1</option>
	<option>2</option>
	</select><select name="Frequency2">
	<option></option>
	<option>Daily</option>
	<option>Weekly</option>
	</select><select name="Provider2">
	<option></option>
	<option>Yves Charles</option>
	<option>Janet Ward</option>
	</select>
    <button name="select1">Select</button>
    <button name="clear1">Clear</button>
<p></p>
  <select name="Modality3">
	<option></option>
	<option>Individual Therapy</option>
	<option>Psych Eval</option>
	</select><select name="HSCP_Code3">
	<option></option>
	<option>H2019HR</option>
	<option>H2017</option>
	</select><select name="Interval3">
	<option></option>
	<option>1</option>
	<option>2</option>
	</select><select name="Frequency3">
	<option></option>
	<option>Daily</option>
	<option>Weekly</option>
	</select><select name="Provider3">
	<option></option>
	<option>Yves Charles</option>
	<option>Janet Ward</option>
	</select>
    <button name="select1">Select</button>
    <button name="clear1">Clear</button>
  <p></p>
 <select name="Modality4">
	<option></option>
	<option>Individual Therapy</option>
	<option>Psych Eval</option>
	</select><select name="HSCP_Code4">
	<option></option>
	<option>H2019HR</option>
	<option>H2017</option>
	</select><select name="Interval4">
	<option></option>
	<option>1</option>
	<option>2</option>
	</select><select name="Frequency4">
	<option></option>
	<option>Daily</option>
	<option>Weekly</option>
	</select><select name="Provider4">
	<option></option>
	<option>Yves Charles</option>
	<option>Janet Ward</option>
	</select>
    <button name="select1">Select</button>
    <button name="clear1">Clear</button>
<p></p>
 <select id="modality" name="modality">
	<option></option>
	<option>Individual Therapy</option>
	<option>Psych Eval</option>
	</select><select name="HSCP_Code">
	<option></option>
	<option>H2019HR</option>
	<option>H2017</option>
	</select><select name="Interval">
	<option></option>
	<option>1</option>
	<option>2</option>
	</select><select name="Frequency">
	<option></option>
	<option>Daily</option>
	<option>Weekly</option>
	</select><select name="Provider">
	<option></option>
	<option>Yves Charles</option>
	<option>Janet Ward</option>
	</select>
    <button name="select1">Select</button>
    <button name="clear1">Clear</button>


<p>Modality Note</p>
<textarea id="modality_note" name="modality_note"></textarea>
<button name="select1">Select</button>
<button name="clear1">Clear</button>








