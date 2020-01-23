<?php
/**
 * consent_form.inc includes functions for manipulating consent form information.
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @copyright Copyright (c) 2018 Brady Miller <brady.g.miller@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */


use OpenEMR\Common\Utils\QueryUtils;


function insertReferralOl($inputs)
{
    $insertQuery = "INSERT INTO referral (".
                        "`patient_name`,".
                        "`age`,".
                        "`dob`,".
                        "`sex`,".
                        "`ss`,".
                        "`medicaid`,".
                        "`address`,".
                        "`city`,".
                        "`st`,".
                        "`zip_code`,".
                        "`telephone`,".
                        "`mobile`,".
                        "`referring_agency`,".
                        "`referring_date`,".
                        "`referring_source`,".
                        "`referring_title`,".
                        "`referring_phone`,".
                        "`referring_fax`,".
                        "`reason`,".
                        "`comments`,".
                        "`recommended_service`,".
                        "`non_admission_reason`,".
                        "`referred_to`,".
                        "`signature`,".
                        ."`signature_date`) VALUES ('".
                        $inputs['patient_name'] . "','" .
                        $inputs['age'] . "','" .
                        $inputs['dob'] . "','" .
                        $inputs['sex'] . "','" .
                        $inputs['ss'] . "','" .
                        $inputs['medicaid'] . "','" .
                        $inputs['address'] . "','" .
                        $inputs['city'] . "','" .
                        $inputs['st'] . "','" .
                        $inputs['zip_code'] . "','" .
                        $inputs['telephone'] . "','" .
                        $inputs['mobile'] . "','" .
                        $inputs['referring_agency'] . "','" .
                        $inputs['referring_date'] . "','" .
                        $inputs['referring_source'] . "','" .
                        $inputs['referring_title'] . "','" .
                        $inputs['referring_phone'] . "','" .
                        $inputs['referring_fax'] . "','" .
                        json_encode($inputs['reason']) . "','" .
                        $inputs['comments'] . "','" .
                        $inputs['recommended_service'] . "','" .
                        $inputs['non_admission_reason'] . "','" .
                        $inputs['referred_to'] . "','" .
                        $inputs['signature'] . "','" .
                        $inputs['signature_date'] . "','" .
                        "')";
                        print_r($insertQuery);
    $returnValue = sqlInsert($insertQuery);
    
    return $returnValue;
}