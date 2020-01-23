<?php
require_once("../../../globals.php");
//require_once("../../globals.php");
require_once("$srcdir/patient.inc");
include_once("$srcdir/api.inc");

$result = getPatientData($pid, "fname,mname,lname,pid,pubpid,phone_home,pharmacy_id,DOB,DATE_FORMAT(DOB,'%Y%m%d') as DOB_YMD");
//$insurance = getInsuranceDataByDate($pid, (substr($row["date"], 0, 10)), "primary", "provider");
$insurance = getInsuranceDataByDate($pid, "02/19/2018", "primary", "provider");
//$insurance2 = getRecInsuranceData($pid, $ins_type);
echo "HI<br>", $result['fname']," ",  $result['lname'], " ",$result['mname']," ", $result['DOB'], "<br>";
echo $insurance['primary'];
echo $insurance2;
$insurance_test2 = getInsurancePnDataByDate($pid, "2018-02-29", "primary", "provider", policy_number);

foreach($insurance_test2 as $key => $value) {
	$company = getInsuranceProvider($insurance_test2[$key]);
	//echo $company; 
}
//print_r ($insurance_test2);
echo "<br>",$insurance_test2['policy_number'], "<br>";

$dob=$result['DOB'];
$fname=$result['fname'];
$lname=$result['lname'];
$policy_number=$insurance_test2['policy_number'];


?>

<?php
 

$eligibility_request = array(
       "member" => array(
             	"birth_date" => $dob,
        		"first_name" => $fname,
        		"last_name" => $lname,
        		"id" => $policy_number
           ),
       	"provider" => array(
	        	"npi"=> "1326275207",
	            "organization_name"=> "Assurance"
 	       ),
        "trading_partner_id" => "medicaid_fl"
   );

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://platform.pokitdok.com/api/v4/eligibility/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($eligibility_request));
curl_setopt($ch, CURLOPT_POST, 1);

$headers = array();
$headers[] = "Authorization: Bearer yJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjbGllbnRfaWQiOiJqRWdqc3FUaWRkRUJ4MkxrUEJCZiIsInNjb3BlIjowLCJqdGkiOiJiNjI0NzA2MjVkYmM0YTMwODY2ZDgxNjcyMDE5ZGY0NCIsImV4cCI6MTUzMDc3MDk1Mn0.n1jVBSZKfCz1D3rUaILvFKiQqV8ZIvoTkjZjmfOD77s"; 
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
				//echo $result;
				//echo "<br>  >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>><br>";

				//print_r ($result);//////////////////////////////////////////////////////////////PRINT RESULT/////////////////////////////////////////////////////////////
				//echo "<br>hello1";
				//preg_match_all("/organization_name\(.*?)\address/", $result, $matches);
				//print_r ($matches);
				//echo "<br>hello2";
				//echo ($matches);
				
				//echo "<br>hello3";
				//$final1 = $matches[0][0];
				//$final2 = $matches[0][1];
				////$final3 = $matches[1][0];
				//$final4 = $matches[1][1];
				//$final5 = $matches[0];
				//$final6 = $matches[1];
				//echo "test<br>";
				//echo "<br>____________________________________________________________<br>";
				//echo $final1;
				//echo "<br>____________________________________________________________<br>";
				//echo $final2;
				//echo "<br>____________________________________________________________<br>";
				//echo $final3;
				//echo "<br>____________________________________________________________<br>";
				//echo $final4;
				//echo "<br>____________________________________________________________<br>";
				//echo $final5;
				//echo "<br>____________________________________________________________<br>";
				//echo $final6;
				//echo "start json<br>";
				//$messages = json_encode($result);
				//echo "1 json<br>";
				//foreach ($messages as $message) {
				//echo $message;
				//echo $message -> first_name;
				//echo "hello<br>"; 
				//echo "{$message[first_name]}";
				//echo $message -> first_name; 
				//echo "{$message[first_name]}";
				//echo $message{"first_name"};
				//echo $message['first_name'];
				//echo "yes";
				
				//}
				//echo "2 json<br>";
				$mysqli = mysqli_connect("192.168.123.5", "openemr", "4050!Pirc", "openemr");
				//echo $host;
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
						$active = $json['data']['coverage']['active'];


				
				$sql = "INSERT INTO eligible (pid,policy_number,active,results_json) VALUES ($pid,$policy_number,$active,$result1)";
				 //sqlInsert("$var1");
				// Close connection
				
				
				
				if (mysqli_query($mysqli, $sql)) {
											$billing_id = mysqli_insert_id($mysqli);
																		
											//echo "<br>". $_POST["pid"][$i]. "<br>";
										    echo "<br>New record created successfully. Last inserted ID is: ";} else {
										    echo "<br>Error: " . $sql . "<br>" . mysqli_error($mysqli);
																	    }

}




?>