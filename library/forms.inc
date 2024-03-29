<?php
$GLOBALS['form_exit_url'] = "javascript:parent.closeTab(window.name, false)";

//TESTING
function getFormById($id, $cols = "*")
{
    $sql = "select $cols from forms where id='$id' and deleted = 0 order by date DESC limit 0,1";
    //echo $sql . "<br />";
    return sqlQuery($sql);
}

function getFormInfoById($id, $cols = "*")
{
    $sql = "select $cols from forms where id = '$id' and deleted = 0 order by date DESC limit 0,1";
    //echo $sql . "<br />";
    $result = sqlQuery($sql);
    if ($result['formdir'] == "newpatient") {
        $result['formdir'] = "encounter";
    }

    $sql = "select * from form_" . $result['formdir'] . " where id='" . $result['form_id'] . "'";
    //echo $sql . "<br />";
    $result = sqlQuery($sql);
    //print_r($result);
    return $result;
}

function getFormsByPid($pid, $cols = "*")
{
    return sqlQuery("select $cols from forms where pid = '$pid' and deleted = 0");
}

function getTreatmentPlanById($id)
{
    return sqlQuery("select * from form_treatment_plan where id = '$id'");
}

function getAllTreatmentPlansByPid($pid, $cols = "*")
{
    $res = sqlStatement("select $cols from form_treatment_plan forms where pid = '$pid'");
    for ($iter = 0; $row = sqlFetchArray($res); $iter++) {
        $all[$iter] = $row;
    }
    return $all;
}

function getAllActiveTreatmentPlansByPid($pid, $cols = "*")
{
    $query = "Select plan.id, plan.service_name, plan.user, plan.form_status, form.pid";
    $query .= " from `form_treatment_plan` plan join `forms` form on plan.id=form.form_id ";
    $query .= " where form.deleted=0 and form.form_name='Treatment Plan' and form.pid='" . $pid . "'";

    $res = sqlStatement($query);
    for ($iter = 0; $row = sqlFetchArray($res); $iter++) {
        $all[$iter] = $row;
    }
    return $all;
}




//END TESTING									  
function getFormByEncounter(
    $attendant_id,
    $encounter,
    $cols = "form_id, form_name",
    $name = "",
    $orderby = "FIND_IN_SET(formdir,'vitals') DESC, date DESC"
) {

    global $attendant_type;
    $arraySqlBind = array();
    $sql = "select " . escape_sql_column_name(process_cols_escape($cols), array('forms')) . " from forms where encounter = ? and deleted = 0 ";
    array_push($arraySqlBind, $encounter);
    if (!empty($name)) {
        $sql .= "and form_name=? ";
        array_push($arraySqlBind, $name);
    }

    if ($attendant_type == 'pid') {
        $sql .= " and pid=? and therapy_group_id IS NULL ";
    } else {
        $sql .= " and therapy_group_id = ? and pid IS NULL ";
    }

    array_push($arraySqlBind, $attendant_id);

    // Default $orderby puts vitals first in the list, and newpatient last:
    $sql .= "ORDER BY $orderby";

    $res = sqlStatement($sql, $arraySqlBind);

    for ($iter=0; $row=sqlFetchArray($res); $iter++) {
        $all[$iter] = $row;
    }

    return $all;
}

function addForm(
    $encounter,
    $form_name,
    $form_id,
    $formdir,
    $pid,
    $authorized = "0",
    $date = "NOW()",
    $user = "",
    $group = "",
    $therapy_group = 'not_given'
) {

    global $attendant_type;
    if (!$user) {
        $user = $_SESSION['authUser'];
    }

    if (!$group) {
        $group = $_SESSION['authProvider'];
    }

    if ($therapy_group == 'not_given') {
        $therapy_group = $attendant_type == 'pid' ? null : $_SESSION['therapy_group'];
    }

    //print_r($_SESSION['therapy_group']);die;
        $arraySqlBind = array();
    $sql = "insert into forms (date, encounter, form_name, form_id, pid, " .
        "user, groupname, authorized, formdir, therapy_group_id) values (";
    if ($date == "NOW()") {
        $sql .= "$date";
    } else {
        $sql .= "?";
                array_push($arraySqlBind, $date);
    }

    $sql .= ", ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        array_push($arraySqlBind, $encounter, $form_name, $form_id, $pid, $user, $group, $authorized, $formdir, $therapy_group);
    return sqlInsert($sql, $arraySqlBind);
}

function authorizeForm($id, $authorized = "1")
{
    sqlQuery("UPDATE forms SET authorized = ? WHERE id = ? AND deleted = 0", array($authorized, $id));
}

function getEncounters($pid, $dateStart = '', $dateEnd = '', $encounterRuleType = '')
{
    $arraySqlBind = array();

    if ($encounterRuleType) {
        // Only collect certain type of encounters (list_options item from the rule_enc_types list that is mapped via enc_category_map table)
        $from = "form_encounter LEFT JOIN enc_category_map ON (form_encounter.pc_catid = enc_category_map.main_cat_id)";
        $where = "enc_category_map.rule_enc_id = ? and ";
        array_push($arraySqlBind, $encounterRuleType);
    } else {
        // Collect all encounters
        $from = "form_encounter";
    }

    if ($dateStart && $dateEnd) {
        $where .= "form_encounter.pid = ? and form_encounter.date >= ? and form_encounter.date <= ?";
        array_push($arraySqlBind, $pid, $dateStart, $dateEnd);
    } else if ($dateStart && !$dateEnd) {
        $where .= "form_encounter.pid = ? and form_encounter.date >= ?";
        array_push($arraySqlBind, $pid, $dateStart);
    } else if (!$dateStart && $dateEnd) {
        $where .= "form_encounter.pid = ? and form_encounter.date <= ?";
        array_push($arraySqlBind, $pid, $dateEnd);
    } else {
        $where .= "form_encounter.pid = ?";
        array_push($arraySqlBind, $pid);
    }

    //Not table escaping $from since this is hard-coded above and can include more than just a table name
    $res = sqlStatement("SELECT distinct encounter FROM " . $from . " WHERE " . $where . " ORDER by date desc", $arraySqlBind);

    for ($iter=0; $row=sqlFetchArray($res); $iter++) {
        $all[$iter] = $row;
    }

    return $all;
}

function getEncounterDateByEncounter($encounter)
{
    global $attendant_type;
    $table = $attendant_type == 'pid' ? 'form_encounter' : 'form_groups_encounter';
    // $sql = "select date from forms where encounter='$encounter' order by date";
    $sql = "SELECT date FROM " . escape_table_name($table) . " WHERE encounter = ? ORDER BY date";
    return sqlQuery($sql, array($encounter));
}

function getProviderIdOfEncounter($encounter)
{
        global $attendant_type;
        $table = $attendant_type == 'pid' ? 'form_encounter' : 'form_groups_encounter';
        $sql = "SELECT provider_id FROM " . escape_table_name($table) . " WHERE encounter=? ORDER BY date";
        $res = sqlQuery($sql, array($encounter));
        return $res['provider_id'];
}

function getFormNameByFormdirAndFormid($formdir, $form_id)
{
    return sqlQuery("SELECT form_name FROM forms WHERE formdir = ? AND form_id = ? AND deleted = 0", array($formdir, $form_id));
}

function getFormIdByFormdirAndFormid($formdir, $form_id)
{
    $result = sqlQuery("select id from forms where formdir = ? and form_id = ? and deleted = 0 ", array( $formdir, $form_id ));
    return $result['id'];
}

function getFormNameByFormdir($formdir)
{
    return sqlQuery("SELECT form_name FROM forms WHERE formdir = ? AND deleted = 0", array($formdir));
}

function getDocumentsByEncounter($patientID = null, $encounterID = null)
{
    $allDocuments = null;
    $currentEncounter = ( $encounterID ) ? $encounterID : $_SESSION['encounter'];
    $currentPatient = ( $patientID ) ? $patientID : $_SESSION['pid'];

    if ($currentPatient != "" && $currentEncounter != "") {
        $sql = "SELECT d.id, d.type, d.url, d.docdate, d.list_id, c.name,d.encounter_id FROM documents AS d, categories_to_documents AS cd,
			categories AS c WHERE d.foreign_id = ? AND d.encounter_id=? AND cd.document_id = d.id AND c.id = cd.category_id ORDER BY d.docdate DESC, d.id DESC";
        $res = sqlStatement($sql, array($currentPatient,$currentEncounter));

        while ($row = sqlFetchArray($res)) {
            $allDocuments[] = $row;
        }
    }

    return $allDocuments;
}

function hasFormPermission($formDir)
{
    // get the aco spec from registry table
    $formRow = sqlQuery("SELECT aco_spec FROM registry WHERE directory = ?", array($formDir));
    $permission = explode('|', $formRow['aco_spec']);
    return acl_check($permission[0], $permission[1]);
}
