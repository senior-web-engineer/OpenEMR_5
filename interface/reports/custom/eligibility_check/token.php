<?php
require_once("../../../globals.php");
//require_once("../../globals.php");
//include_once("$srcdir/api.inc");
//include_once("$srcdir/forms.inc");



$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://platform.pokitdok.com/oauth2/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
                    array(
                "grant_type" => "client_credentials",
                "client_id" => "jEgjsqTiddEBx2LkPBBf",
                "client_secret" => "ZoE2yqN6NhM13J02EPhJ8DeSuXcWQ3IQ95M3WTyG"
            )
        );
        $result = curl_exec($ch);
       // echo "<br>00<br>";
       // echo $result;
       // curl_exec($ch);
       // echo "<br>00<br>";
        
        
        
       
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

?>

