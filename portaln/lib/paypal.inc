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


function getPaypalTransaction($paymentId)
{
    return sqlQuery("SELECT * FROM `paypal_transactions` WHERE `payment_id`=?", array($paymentId));
}

function getApprovedTransactionsByPid($pid)
{
    return sqlStatement("SELECT * FROM `paypal_transactions` WHERE `pid`=".$pid." AND `transaction_status`='APPROVED' ORDER BY created_at DESC");
}

function insertPaypalTransaction($pid, $totalAmount, $paymentId, $formDetails)
{
    $insertQuery = "INSERT INTO paypal_transactions (`pid`,`payment_amount`, `payment_id`,`form_details`, `transaction_status`, `created_at`)" .
            " VALUES ('" . $pid . "','" . $totalAmount ."','" . $paymentId . "','". $formDetails ."', 'CREATED','".date('Y-m-d H:i:s')."' )";
        $returnValue = sqlInsert($insertQuery);

    return $returnValue;
}

function updateSuccessPaypalTransaction($id, $inputs)
{
    $returnValue = false;
    $transaction = sqlQuery("SELECT * FROM `paypal_transactions` WHERE `id`=?", array($id));
    if ($transaction) {
        $updateQuery = "UPDATE paypal_transactions set ";
        $updateQuery .= "`transaction_status`='" . $inputs['transaction_status'] ."',";
        $updateQuery .= "`payer_email`='" . $inputs['payer_email']."',";
        $updateQuery .= "`payment_amount_currency`='" . $inputs['payment_amount_currency']."',";
        $updateQuery .= "`transaction_fee`='" . $inputs['transaction_fee']."',";
        $updateQuery .= "`transaction_fee_currency`='" . $inputs['transaction_fee_currency'];
        $updateQuery .= "' where id='" . $transaction['id'] ."'";
        $returnValue = sqlInsertClean_audit($updateQuery, $inputs);
    }
    return $returnValue;
}

function updateCancelledPaypalTransaction($id, $inputs)
{
    $returnValue = false;
    $transaction = sqlQuery("SELECT * FROM `paypal_transactions` WHERE `id`=?", array($id));
    if ($transaction) {
        $updateQuery = "UPDATE paypal_transactions set ";
        $updateQuery .= "`transaction_status`='" . $inputs['transaction_status'];
        $updateQuery .= "' where id='" . $transaction['id'] ."'";
        $returnValue = sqlInsertClean_audit($updateQuery, $inputs);
    }
    return $returnValue;
}
