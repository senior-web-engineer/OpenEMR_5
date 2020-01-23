<?php
include_once("../../interface/globals.php");
include_once("$srcdir/jsonwrapper/jsonwrapper.php");

header('Content-Type: application/json');

$api = getPost("api","");
$output = "null";
$errorString = "";
$message = "";
function customError($errno, $errstr) {
  $errorString = "[$errno] $errstr";
  echo "{\"data\": null, \"error\": \"$errorString\"}";
  die();
}
set_error_handler("customError");

function getPost($key, $default) {
    if (isset($_POST[$key]))
        return $_POST[$key];
    return $default;
}

switch ($api){
    case "getControl": //params: page, textboxid
        //returns control configuration data in json
        $pageName = getPost("page","");
        $textboxId = getPost("textboxid","");
        $res = sqlStatement("SELECT textImporterControlId AS 'id', controlHeading AS 'heading' FROM openemr.form_textimporter_controls where pageName = '$pageName' and textboxId = '$textboxId';");
        $ticontrols = array();
        $textcontrolid = 0;
        while($ticontrol = SqlFetchArray($res)){
            $ticontrols['controls'] = $ticontrol;
        }
		$noControlErr = false;
		if(array_key_exists('controls', $ticontrols)) {
			if (count($ticontrols['controls']) > 0){
				$controlid = $ticontrols['controls']['id'];
				$selectorSql = "SELECT textImporterSelectorId AS 'id', selectorLabel AS 'heading', control, rememberId, getParentId ";
				$selectorSql = $selectorSql . " FROM openemr.form_textimporter_selectors WHERE textImporterControlId = $controlid ORDER BY sortOrder ;";
				$res = sqlStatement($selectorSql);
				$tiselectors = array();
				if(!array_key_exists('selectors', $tiselectors)) {
					while($tiselector = SqlFetchArray($res)){
						$tiselectors['selectors'][] = $tiselector;
					}
					if(!array_key_exists('selectors', $tiselectors)) {
						$ticontrols['controls']['selectors'] = array();
					} else {
						$ticontrols['controls']['selectors'] = $tiselectors['selectors'];
					}
					$output = json_encode($ticontrols);
				} else { $noControlErr = true; }
			} else { $noControlErr = true; }
		} else { $noControlErr = true; }
		if ($noControlErr) {
            $errorString = "No controls found please check TextImporter tables.";
        }
        break;
    case "getSelectorData": //params: id, where
        $controlid = getPost("controlid","");
        $id0 = getPost("id0","0");
        $id1 = getPost("id1","0");
        $id2 = getPost("id2","0");
        $id3 = getPost("id3","0");
        $id4 = getPost("id4","0");
        $id5 = getPost("id5","0");
        $id6 = getPost("id6","0");
        
        //1) get selector query info from table
        $res = sqlStatement("SELECT valueField, dataField, whereField, fromTable, setLimit, orderByField FROM openemr.form_textimporter_selectors where textImporterSelectorId = $controlid;");
        $tiselectors = array();
        while($tiselector = SqlFetchArray($res)){
            $tiselectors['selectors'] = $tiselector;
        }
        
        if (count($tiselectors['selectors']) > 0){
            //2) assemble query
            $valueField = $tiselectors['selectors']['valueField'];
            $dataField = $tiselectors['selectors']['dataField'];
            $fromTable = $tiselectors['selectors']['fromTable'];
            $whereField = $tiselectors['selectors']['whereField'];
            $setLimit = $tiselectors['selectors']['setLimit'];
            $orderByField = $tiselectors['selectors']['orderByField'];
            $queryString = " SELECT " . $valueField . " AS 'value', " . $dataField . " AS 'desc' FROM " . $fromTable . " ";
            if ($whereField != null){
                $whereField = sprintf($whereField, $id0, $id1, $id2, $id3, $id4, $id5, $id6);
                $queryString = $queryString . " WHERE " . $whereField . " "; //this will only work for numeric look_up fields
            }
            if ($orderByField != null){
                $queryString = $queryString . " ORDER BY $orderByField ";
            }
            if ($setLimit != null){
                $queryString = $queryString . " LIMIT $setLimit ";
            }
            $message = $queryString; //-------------!!!!!  DEBUG ONLY  !!!!!-----------: show query string in client
            
            //3) runn query & return JSON
            $rows = array();
            $res = sqlStatement($queryString);
            while($row = SqlFetchArray($res)){
                $rows['list'][] = $row;
            }
            $output = json_encode($rows);
        } else {
            $errorString = "No selectors found";
        }
        break;
    case "getSampleData": //params: none
        $rows = array();
        $res = sqlStatement("SELECT id AS 'value', problem_1  AS 'desc' FROM openemr.form_individualized_treatment_plan_cmh LIMIT 10 ");
        while($row = SqlFetchArray($res)){
            $rows['list'][] = $row;
        }
        $output = json_encode($rows);
        break;
    default:
        $output = "{\"api\": \"$api\"}";
}
//echo($test);
echo "{\"data\": $output, \"error\": \"$errorString\", \"message\": \"$message\"}";
?>