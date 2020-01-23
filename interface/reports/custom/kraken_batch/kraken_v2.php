<!--*******************************************************-->
<!--*******************************************************-->
<!--**                                                   **-->
<!--** Named in memory of Pipopo, aka Kraken.            **-->
<!--** When released, things happen, good and bad.       **-->
<!--** So be careful, when you 'Release The Kraken!'     **-->
<!--**                                                   **--> 
<!--*******************************************************-->
<!--*******************************************************-->
<?php
echo "Kraken1";

//include_once("../../globals.php");
include_once("../../../globals.php");
//include_once("$srcdir/api.inc");
//include_once("$srcdir/forms.inc");
echo "<br>Kraken2";
//$connection = mysql_connect($host, $login, $pass); 
//$db = @mysql_select_db($dbase, $connection);
$conn = mysqli_connect($host, $login, $pass, $dbase) or die(mysqli_connect_error());
//****************************************************************************Add Billing****************************
//TO DO: Remove Database Security Info from page
// Disable form after 'Ready for Billing'
//NEED IN FORM billing_id, provider_id
//<input type="hidden" name="provider_id" id="provider_id" value="<?php echo $provider_results["id"]; 
//$providerIDres = getProviderIdOfEncounter($encounter);//Currently billing by the encounter creator, not form creator. To be fixed
////////////////////////////////////////////////////////////////////
//ALTER TABLE `openemr`.`form_XXX_XXXX`
//ADD COLUMN `provider_id` BIGINT(20) NULL AFTER `provider_print_name`,
//ADD COLUMN `billing_id` BIGINT(20) NULL DEFAULT '-99' AFTER `billing_status`, 
//ADD COLUMN `problem3` VARCHAR(255) NULL AFTER `problem2`,
//ADD COLUMN `problem4` VARCHAR(255) NULL AFTER `problem3`;
////////////////////////////////////////////////////////////////////
//  $f_billing_id = $_POST["billing_id"];
//  $provider_id = $_POST["provider_id"];
//  $servicecode = $_POST["servicecode"];
//  $justify1 = substr($_POST["problem1"], 0, strpos($_POST["problem1"], ' '));
//  $justify2 = substr($_POST["problem2"], 0, strpos($_POST["problem2"], ' '));
//$justify3 = substr($_POST["problem3"], 0, strpos($_POST["problem3"], ' '));
//$justify4 = substr($_POST["problem4"], 0, strpos($_POST["problem4"], ' '));
//$justify5 = str_replace(':', '|', $justify1).":".str_replace(':', '|', $justify2).":".str_replace(':', '|', $justify3).":".str_replace(':', '|', $justify4).":";
//$patterns = array();
//$patterns[0] = '/::::/';
//$patterns[1] = '/:::/';
//$patterns[2] = '/::/';
//$replacements = ':';
//$justify = preg_replace($patterns, $replacements, $justify5);
//$units = $_POST["units"];
//echo "formbillingid:" . $f_billing_id;
//****************************Calculations
//switch ($servicecode) {
//    case "H2019HO":
//        $fee= 32*$units;
//        $code_text = "TBOSS";
//       $code_type = "HCPCS";
//        break;
//    case "H2019HR":
//        $fee= 36.66*$units;
//        $code_text = "INDIVIDUAL THERAPY";
//        $code_type = "HCPCS";
//        break;
//    case "H2017":
//        $fee= 18*$units;
//        $code_text = "PSYCHO SOCIAL REHABILITATION";
//        $code_type = "HCPCS";
//        break;
//   
//}

//***************Database Insert Billing****************************
//if ($_GET["mode"] == "new" AND $_POST["status"] =="Ready for Billing/Supervisor"){
//if ($_POST["status"] =="Ready for Billing/Supervisor" AND $f_billing_id == 0)
echo "<br>Kraken4";
echo "<br>Number of Record:". count($_POST["pid"]);
echo "<br>Number of Record:". count($_POST["boxes"]);
for ($i = 0; $i < count($_POST['pid']); ++$i)
				{
				//echo "<br>1 Form ID:". $_POST["form_id"][$i]. "<br>";
				//echo "<br>1 Encounter ID:". $_POST["en_encounter"][$i]. "<br>";
				

								$sql = "insert into billing (date, encounter, code_type, code, code_text, " .
							    "pid, authorized, user, groupname, activity, billed, provider_id, " .
							    "modifier, units, fee, ndc_info, justify, notecodes) values (" .
									    "NOW(),										
									    '".$_POST["en_encounter"][$i]."',			
									    '".$_POST["code_type"][$i]."',	
									    '".substr($_POST["servicecode"][$i],0,5)."',
									    '".$_POST["code_text"][$i]."',			
									    '".$_POST["pid"][$i]."',						
									    '1',
									    '9993',
									    '',
									    1,
									    '',
									    '".$_POST["provider_id"][$i]."',			
									    '".$_POST["modifier"][$i]."',
									    '".$_POST["units"][$i]."',
									    '".$_POST["fee"][$i]."',					
									    '',
									    '".$_POST["justify"][$i]."',					
							    '')";
							    echo "<br>". $sql;

							   
							    $form_id = $_POST["form_id"][$i];
							    $form_selected = $_POST["form_selected"][$i];
								if (mysqli_query($conn, $sql)) {
							$billing_id = mysqli_insert_id($conn);
														
							//echo "<br>". $_POST["pid"][$i]. "<br>";
						    echo "<br>New record created successfully. Last inserted ID is: " . $billing_id;} else {
						    echo "<br>Error: " . $sql . "<br>" . mysqli_error($conn);
													    }
								sqlInsert("update $form_selected set billing_id = $billing_id, billing_status = 'Billed'  where id = $form_id");
								
								if (!empty($_POST["justify1"][$i]))
										{
										sqlInsert("insert into billing (date, encounter, code_type, code, code_text, " .
							    "pid, authorized, user, groupname, activity, billed, provider_id, " .
							    "units, fee, ndc_info, notecodes) values (" .
									    "NOW(),										
									    '".$_POST["en_encounter"][$i]."',			
									    '".$_POST["code_type1"][$i]."',	
									    '".$_POST["justify1"][$i]."',
									    '".$_POST["diag1"][$i]."',			
									    '".$_POST["pid"][$i]."',						
									    '1',
									    '9993',
									    '',
									    1,
									    '',
									    '".$_POST["provider_id"][$i]."',			
									    '1',
									    '0.00',					
									    '',
									    '')");
									  	}
								if (!empty($_POST["justify2"][$i]))
										{
										sqlInsert("insert into billing (date, encounter, code_type, code, code_text, " .
							    "pid, authorized, user, groupname, activity, billed, provider_id, " .
							    "units, fee, ndc_info, notecodes) values (" .
									    "NOW(),										
									    '".$_POST["en_encounter"][$i]."',			
									    '".$_POST["code_type2"][$i]."',	
									    '".$_POST["justify2"][$i]."',
									    '".$_POST["diag2"][$i]."',			
									    '".$_POST["pid"][$i]."',						
									    '1',
									    '9993',
									    '',
									    1,
									    '',
									    '".$_POST["provider_id"][$i]."',			
									    '1',
									    '0.00',					
									    '',
									    '')");
									  	}
								if (!empty($_POST["justify3"][$i]))
										{
										sqlInsert("insert into billing (date, encounter, code_type, code, code_text, " .
							    "pid, authorized, user, groupname, activity, billed, provider_id, " .
							    "units, fee, ndc_info, notecodes) values (" .
									    "NOW(),										
									    '".$_POST["en_encounter"][$i]."',			
									    '".$_POST["code_type3"][$i]."',	
									    '".$_POST["justify3"][$i]."',
									    '".$_POST["diag3"][$i]."',			
									    '".$_POST["pid"][$i]."',						
									    '1',
									    '9993',
									    '',
									    1,
									    '',
									    '".$_POST["provider_id"][$i]."',			
									    '1',
									    '0.00',					
									    '',
									    '')");
									  	}
							   if (!empty($_POST["justify4"][$i]))
										{
										sqlInsert("insert into billing (date, encounter, code_type, code, code_text, " .
							    "pid, authorized, user, groupname, activity, billed, provider_id, " .
							    "units, fee, ndc_info, notecodes) values (" .
									    "NOW(),										
									    '".$_POST["en_encounter"][$i]."',			
									    '".$_POST["code_type4"][$i]."',	
									    '".$_POST["justify4"][$i]."',
									    '".$_POST["diag4"][$i]."',			
									    '".$_POST["pid"][$i]."',						
									    '1',
									    '9993',
									    '',
									    1,
									    '',
									    '".$_POST["provider_id"][$i]."',			
									    '1',
									    '0.00',					
									    '',
									    '')");
									  	}



						    
						//if (mysqli_query($conn, $sql)) {
						//	$billing_id = mysqli_insert_id($conn);
						//     echo "New record created successfully. Last inserted ID is: " . $billing_id;} else {
						//    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
						//							    }
						// mysqli_close($conn);
						
						//switch (($_GET["mode"])) {
						//    case "new":
						//       sqlInsert("update form_psychosocial set billing_id = $billing_id where id=$newid");
						//        break;
						//    case "update":
						//        sqlInsert("update form_psychosocial set billing_id = $billing_id where id=$id");
						//        break;
						//        			    	}
				}
//****************************************************************************End Add Billing****************************
//}

//$_SESSION["encounter"] = $encounter;
//formHeader("Redirecting....");
//formJump();
//formFooter();
mysqli_close($conn);
echo "<br>Kraken5";
?>
