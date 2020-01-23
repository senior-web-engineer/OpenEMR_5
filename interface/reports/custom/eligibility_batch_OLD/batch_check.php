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

include_once("../../../globals.php");

require_once("$srcdir/patient.inc");
require_once("$srcdir/formatting.inc.php");
require_once("$srcdir/options.inc.php");
echo "<br>Kraken2";
////////////////////////////////////////////////////////////////////////////////////////////
//						Get Token														 //
///////////////////////////////////////////////////////////////////////////////////////////
$last_token = sqlQuery("SELECT id, access_token, date FROM eligibility_token ORDER BY id DESC LIMIT 1;");
$system_time = sqlQuery("SELECT NOW() AS system_time;");
echo $last_token['id'];
echo $last_token['access_token'];
echo $last_token['date'],"<br>";
$access_token = $last_token['access_token'];
 
echo "Time",date_format($last_token['date'],"H:i:s"),"<br>";
$localtime = localtime();
print_r ($localtime);
$timestamp = $last_token['date'];

$diff = strtotime($system_time['system_time']) - strtotime($last_token['date']);
echo "DIFF", $diff,"<br>";
		if (empty($last_token['access_token'])||$diff > '3600' || $diff < '0'){
						echo "Time Expired", $diff;
						$ch = curl_init();
						        curl_setopt($ch, CURLOPT_URL, "https://platform.pokitdok.com/oauth2/token");
						        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						        curl_setopt($ch, CURLOPT_POST, true);
						        curl_setopt(
						            $ch,
						            CURLOPT_POSTFIELDS,
						                 	 array(
						  	            "grant_type" => "client_credentials",
						                "client_id" => "dDTsHZqbry1mDSlmQzpZ",
						       	        "client_secret" => "k1ckBosb6ZZnMloHlMV9VSfhgjwCuwOsHgzUiA61"
						           )
						        );
						        $result = curl_exec($ch);
						  
						       
						        if ($ch === false) {
						            echo "<br>a";
						            throw new \Exception(curl_error($ch), curl_errno($ch));
						            echo "<br>b";
						        }
						        $result = curl_exec($ch);
						        if ($result === false) {
						            throw new \Exception(curl_error($ch), curl_errno($ch));
						            echo "<br>c";
						        }
						        $json = json_decode($result,true);
						        echo "<b>Access Token    :</b>  ", $json['access_token'], "<br>";
						        echo "<b>Token Type      :</b>  ", $json['token_type'], "<br>";
						        echo "<b>Expires         :</b>  ", $json['expires'], "<br>";
						        echo "<b>Expires In      :</b>  ", $json['expires_in'], "<br>";
						        $access_token = $json['access_token'];
						        $token_type = $json['token_type'];
						        $expires = $json['expires'];
						        $expires_in = $json['expires_in'];
						        sqlInsert("INSERT INTO eligibility_token SET access_token= '$access_token', token_type='$token_type', expires='$expires', expires_in='$expires_in'");
						        echo "<br>SucceSS";
						        
						        //$this->setAccessToken($result);////////////////////THESE LINES WILL KEEP THE CODE FROM GOING FURTHER/////////////////////////////////
						        echo "<br>2<br>";
						        curl_close($ch);
						        //return $this->_access_token_result;////////////////////THESE LINES WILL KEEP THE CODE FROM GOING FURTHER/////////////////////////////////
						
						        curl_errno($ch);
						        $json = json_decode($result,true);
						        
						        echo "<b>Access Token    :</b>  ", $json['access_token'], "<br>";
						        echo "<b>Token Type      :</b>  ", $json['token_type'], "<br>";
						        echo "<b>Expires         :</b>  ", $json['expires'], "<br>";
						        echo "<b>Expires In      :</b>  ", $json['expires_in'], "<br>";
						        
						//        TEST
						//         array(
						//                "grant_type" => "client_credentials",
						//                "client_id" => "jEgjsqTiddEBx2LkPBBf",
						//                "client_secret" => "ZoE2yqN6NhM13J02EPhJ8DeSuXcWQ3IQ95M3WTyG"
						//            )
						//		LIVE
						//		 array(
						//                "grant_type" => "client_credentials",
						//                "client_id" => "dDTsHZqbry1mDSlmQzpZ",
						//                "client_secret" => "k1ckBosb6ZZnMloHlMV9VSfhgjwCuwOsHgzUiA61"
						//           )
						echo "<br>end";
						
		
		
		
		}
	
	echo "Time Good", $diff;




////////////////////////////////////////////////////////////////////////////////////////////
//						End of Get oken													 //
///////////////////////////////////////////////////////////////////////////////////////////
/////		Insert Batch Tracking/////////////////////////////////////////////////////////
$mysqli = mysqli_connect($host, $login, $pass, $dbase) or die(mysqli_connect_error());				//echo $host;

echo $_SESSION["authUser"];
$sql = "INSERT INTO eligibility_request_tracking (user) VALUES ('".$_SESSION["authUser"]."')";

				 //sqlInsert("$var1");
				// Close connection
				
				
				
				if (mysqli_query($mysqli, $sql)) {
											$tracking_id = mysqli_insert_id($mysqli);
																		
											//echo "<br>". $_POST["pid"][$i]. "<br>";
										    echo "<br>New record created successfully. Last inserted ID is: ". $tracking_id;} else {
										    echo "<br>Error: " . $sql . "<br>" . mysqli_error($mysqli);
																	    }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


echo "<br>Number of Record:". count($_POST["pid"]);
echo $form_to_date;
for ($i = 0; $i < count($_POST["pid"]); ++$i)
				{
				//echo "<br>1 Form ID:". $_POST["form_id"][$i]. "<br>";
				//echo "<br>1 Encounter ID:". $_POST["en_encounter"][$i]. "<br>";
//$pubpid = $_POST["pubpid"][$i];
$pid = $_POST["pid"][$i];
$fname = $_POST["fname"][$i];
$lname = $_POST["lname"][$i];
$mname = $_POST["mname"][$i];
$dob = $_POST["dob"][$i];
$policy_number = $_POST["policy_number"][$i];
$api_code = $_POST["api_code"][$i];
$facility_name = $_POST["facility_name"][$i];
$facility_npi = $_POST["facility_npi"][$i];


echo "<br>Success2<br>";
echo "<br>", $pid;
echo "<br>", $fname;
echo "<br>", $lname;
echo "<br>", $mname;
echo "<br>", $dob;
echo "<br>", $policy_number;
echo "<br>", $api_code;
echo "<br>", $facility_name;
echo "<br>", $facility_npi;

///////////////////////////////////////////////////////////////////////////////////////////////////
//                    Start Check																//
//////////////////////////////////////////////////////////////////////////////////////////////////

$eligibility_request = array(
        "member" => array(
             	"birth_date" => $dob,
        		"first_name" => $fname,
        		"last_name" => $lname,
        		"id" => $policy_number
           ),
       	"provider" => array(
	        	"npi"=> $facility_npi,
	            "organization_name"=> $facility_name
 	       ),
        "trading_partner_id" => $api_code
   );

//print_r($eligibility_request);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://platform.pokitdok.com/api/v4/eligibility/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($eligibility_request));
curl_setopt($ch, CURLOPT_POST, 1);

$headers = array();
$headers[] = "Authorization: Bearer ".$access_token; 
$headers[] = "Content-Type: application/json";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);

$result1 = json_encode($result);
$json = json_decode($result,true);

$notauthorized = $json['message'];
if ($notauthorized == 'Unauthorized'){
										echo "<br>Need to Renew<br>";
										echo $result;
										}else{
if (curl_errno($ch)) {
    echo '-Error:--' . curl_error($ch);
}
				curl_close ($ch);
				
				//$mysqli = mysqli_connect($host, $login, $pass, $dbase) or die(mysqli_connect_error());				//echo $host;
				//echo $login;
				$result1 = json_encode($result);
				
				$json = json_decode($result,true);
						echo "<b>Client ID        :</b>  ", $json['data']['client_id'], "<br>";
						echo "<b>City             :</b>  ", $json['data']['benefit_related_entities'][0]['address']['city'], "<br>";
						echo "<b>Coverage Level   :</b>  ", $json['data']['benefit_related_entities'][0]['coverage_level'], "<br>";
						echo "<b>Organization Name:</b>  ", $json['data']['benefit_related_entities'][0]['organization_name'], "<br>";
						echo "<b>active           :</b>  ", $json['data']['coverage']['active'], "<br>";
						echo "<b>Last Name:</b>  ", $json['data']['subscriber']['last_name'], "<br>";
						echo "<b>First Name:</b> ", $json['data']['subscriber']['first_name'], "<br>";
						echo "<b>MI:</b>         ", $json['data']['subscriber']['middle_name'], "<br>";
						echo "<b>ID:</b>         ", $json['data']['subscriber']['id'], "<br>";
						echo "<b>DOB:</b>        ", $json['data']['subscriber']['birth_date'], "<br>";
						echo "<b>Gender:</b>        ", $json['data']['subscriber']['gender'], "<br>";

						echo $json['data']['coverage']['limitations'][3]['plan_description'], "<br>";
						echo $json['data']['coverage']['limitations'][3]['plan_description'], "<br>";
						
						
						$lname = $json['data']['subscriber']['last_name'];
						$mname = $json['data']['subscriber']['middle_name'];
						$fname = $json['data']['subscriber']['first_name'];
						$sex = $json['data']['subscriber']['gender'];
						$active = $json['data']['coverage']['active'];
							if ($active !='1'){$active ='0';}
						$insurance_company = $json['data']['benefit_related_entities'][0]['organization_name'];
						$plan_description = $json['data']['coverage']['coinsurance'][0]['plan_description'];
				
				$sql = "INSERT INTO eligible (batch_id,pid,insurance_company,lname,fname,mname,sex,policy_number,active,plan_description,results_json)". 
						"VALUES ('$tracking_id','$pid','$insurance_company','$lname','$fname','$mname','$sex','$policy_number','$active','$plan_description','$result')";

				 //sqlInsert("$var1");
				// Close connection
				
				
				
				if (mysqli_query($mysqli, $sql)) {
											$billing_id = mysqli_insert_id($mysqli);
																		
											//echo "<br>". $_POST["pid"][$i]. "<br>";
										    echo "<br>New record created successfully. Last inserted ID is: ";} else {
										    echo "<br>Error: " . $sql . "<br>" . mysqli_error($mysqli);
																	    }

		}


/////////////////////////////////////////////////////////////////////////////////////////////////
//						End Check															   //
/////////////////////////////////////////////////////////////////////////////////////////////////

								
}
echo "<br>Kraken5";



?>
<!--<form method=post name="SigForm" id="SigForm">
<input class="form-control validate" name="tracking_id" id="tracking_id" type="text" style="width: 216px" value="<?php echo $tracking_id;?>"><br>


<input id="button" name="StopBtn" type="button" value="Quick Check" onclick="QuickCheck()"/>-->
	<div id="progresswheel">
	<img height="32" src="ajax-loader.gif" width="32">
	</div>
	<form method="post" id="theForm" action="display_results.php">
<input type="hidden" name="tracking_id" value="<?php echo $tracking_id ?>">
</form>
<script type="text/javascript">
document.getElementById('theForm').submit()
</script>


	



           
           

