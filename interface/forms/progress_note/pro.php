<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");
require_once("$srcdir/patient.inc");
require_once("$srcdir/options.inc.php");
include_once("$srcdir/forms.inc");
//$id = '.$_POST["fid"].';
$id = $_POST['fid'];
$form_name = $_POST['form_name'];
echo $id;
echo "ID=";
//$id = "96799";
//$id = 0 + (isset($_GET['id']) ? $_GET['id'] : '');
echo "hello world";
//(form_id='$id' AND pid = '{$GLOBALS['pid']}')
$con = mysql_connect($host, $login, $pass); 
//mysql_select_db($dbase, $con);
echo $host;
echo $login;
echo $pass;
echo $dbase;

				$db = @mysql_select_db($dbase, $con) or die(mysql_error());
				
							  $query = "SELECT id, IsPrimary, description FROM form_progress_problems WHERE (form_id='$id' AND pid = '{$GLOBALS['pid']}') AND IsDeleted = 0 ORDER BY IsPrimary " ;
							  echo "12345";
								 $result = mysql_query($query) or die(mysql_error());
								 echo "<p>result";
							 			while($row = mysql_fetch_assoc($result)) {
							   			$problem_id = $row['id'];
							   			echo "kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk";
							   			echo "<li><h4>Problem: <i>".$row['description']."</i></h4></li>";
							   			echo "89012";
										//---- Goals---- ----- 
										if ($form_name == "IND")
											{
														echo "<ul><li><h5>Goal(s):<h5></li></ul>";
														 $query_2 = "SELECT id, problem_id, description AS goaldescription ".
																	"FROM form_progress_notes_goals ".
																	"WHERE (form_id='1361' AND problem_id = $problem_id) AND IsDeleted = 0 " ;
								 							$result_2 = mysql_query($query_2) or die(mysql_error());
							 									while($row_2 = mysql_fetch_assoc($result_2)) {
							   										echo "<ul>";
							   										echo "<ul><li><i>".$row_2['goaldescription']."</i></li></ul>";
																	echo "</ul>";
																				 							 }
										
										//---- Objectives ----- 
														echo "<ul><li><h5>Objective(s):<h5></li></ul>";
														$query_3 = "SELECT oj.id AS ojid, oj.Description AS ojdescription, oj.ObjectiveNumber AS ojObjectiveNumber ".
																	"FROM form_progress_notes_objectives AS oj ".
																	"WHERE oj.form_id = $id AND oj.problem_id = $problem_id and (IsDeleted is Null or IsDeleted = 0) ".
																	"ORDER BY oj.id";
															$result_3 = @mysql_query($query_3) or die(mysql_error());
																while ($row_3 = mysql_fetch_array($result_3)) { 
																	echo "<ul>";
																	echo "<ul><li><i>".$row_3['ojdescription']."</i></li></ul>";
																	echo "</ul>";
																				}
											}								
										//***************************************************
										
																				}
			echo "<p>Done";
			?>
