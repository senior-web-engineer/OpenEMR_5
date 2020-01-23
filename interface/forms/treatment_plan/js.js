<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type='text/javascript'>
//<![CDATA[
 $(document).ready(function() {
  var currentItem = 1;
  $('#addnew').click(function(){
   currentItem++;
   $('#items').val(currentItem);
var strToAdd = '<tr><td>Year</td><td>:</td><td><select name="year'+currentItem+'" id="year'+currentItem+'" ><option value="2012">2012</option><option value="2011">2011</option></select></td><td>Month</td><td>:</td><td width="17%"><select name="month'+currentItem+'" id="month'+currentItem+'"><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select></td><td width="7%">Week</td><td width="3%">:</td><td width="17%"><select name="week'+currentItem+'" id="week'+currentItem+'" ><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option></select></td><td width="8%">&nbsp;</td><td colspan="2">&nbsp;</td></tr><tr><td>Actual</td><td>:</td><td width="17%"><input name="actual'+currentItem+'" id="actual'+currentItem+'" type="text" /></td><td width="7%">Max</td> <td width="3%">:</td><td><input name="max'+currentItem+'" id ="max'+currentItem+'"type="text" /></td><td>Target</td><td>:</td><td><input name="target'+currentItem+'" id="target'+currentItem+'" type="text" /></td></tr>';
   $('#data').append(strToAdd);
   
  });
 });

//]]>
</script>