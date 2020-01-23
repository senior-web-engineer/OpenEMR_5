
<?php
include_once("../../globals.php");

//$id = '.$_POST["fid"].';
$id = $_POST['fid'];
$formid = 0 + (isset($_GET['id']) ? $_GET['id'] : '');
$form_name = $_POST['form_name'];
//echo $id;
//echo "ID=";
//$id = "96799";
//$id = 0 + (isset($_GET['id']) ? $_GET['id'] : '');
//echo "hello world";
//(form_id='$id' AND pid = '{$GLOBALS['pid']}')
//$con = mysql_connect($host, $login, $pass); 
?>
<div id="problem">
	<div class="panel-body">
		<ul>
		

		
		<?php 

			$mysqli = new mysqli($host, $login, $pass, $dbase); 

				
							  $query = "SELECT id, IsPrimary, description FROM form_progress_problems WHERE (form_id='$id' AND pid = '{$GLOBALS['pid']}') AND IsDeleted = 0 ORDER BY IsPrimary " ;
							 // echo "12345";
								 $result = $mysqli -> query ($query);
								 //echo "<p>result";
							 			while($row = mysqli_fetch_assoc($result)) {
							   			$problem_id = $row['id'];
							   			//echo "kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk";
							   			echo "<li><h4><b>Problem: </i></b><br><i>".$row['description']."</h4></i>";
							  		
										
										//---- Goals---- ----- 
										if ($form_name == "IND"|| $form_name == "TBO")
											{
														echo "<ul><li><h5><b>Treatment Goal:</b><h5></li></ul>";
														 $query_2 = "SELECT id, problem_id, description AS goaldescription ".
																	"FROM form_progress_notes_goals ".
																	"WHERE (form_id='$id' AND problem_id = $problem_id) AND IsDeleted = 0 " ;
								 							$result_2 =  $mysqli -> query ($query_2);
							 									while($row_2 = mysqli_fetch_assoc($result_2)) {
							   										echo "<ul>";
							   										echo "<ul><li><i>".$row_2['goaldescription']."</i></li></ul>";
																	echo "</ul>";
																				 							 }
										
										
										//---- Objectives ----- 
//														echo "<ul><li><h5>Objective(s):<h5></li></ul>";
//														$query_3 = "SELECT oj.id AS ojid, oj.Description AS ojdescription, oj.ObjectiveNumber AS ojObjectiveNumber ".
//																	"FROM form_progress_notes_objectives AS oj ".
//
//																	"ORDER BY oj.id";
//															$result_3 = @mysql_query($query_3) or die(mysql_error());
//																while ($row_3 = mysql_fetch_array($result_3)) { 
//																	echo "<ul>";
//																	echo "<ul><li><i>".$row_3['ojdescription']."</i></li></ul>";
//																	echo "</ul>";
//																				}
											}								
										//***************************************************
										
																				}
			//echo "<p>Done";
			?>
		</ul>
	</div>
</div>

			
			
			
			
