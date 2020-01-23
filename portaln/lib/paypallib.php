<?php

use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use Paypal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;


/**
 *
 * Copyright (C) 2016-2017 Jerry Padgett <sjpadgett@gmail.com>
 *
 * LICENSE: This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEMR
 * @author Jerry Padgett <sjpadgett@gmail.com>
 * @link http://www.open-emr.org
 */

session_start();
if (isset($_SESSION['pid']) && isset($_SESSION['patient_portal_onsite_two'])) {
    $pid = $_SESSION['pid'];
    $ignoreAuth = true;
    require_once(dirname(__FILE__) . "/../../interface/globals.php");
} else {
    session_destroy();
    $ignoreAuth = false;
    require_once(dirname(__FILE__) . "/../../interface/globals.php");
    if (!isset($_SESSION['authUserID'])) {
        $landingpage = "index.php";
        header('Location: ' . $landingpage);
        exit();
    }
}

error_reporting(E_ALL);
$baseUrl = (env('APP_ENV') == 'dev') ? "http://localhost/portalopenemr/portal" : "https://portal.pircinc.org/openemr/portal";

require_once("./appsql.class.php");
require_once("./paypal.inc");
//$_SESSION['whereto'] = 'paymentpanel';
if ($_SESSION['portal_init'] != 'true') {
    $_SESSION['whereto'] = 'paymentpanel';
}

$_SESSION['portal_init'] = false;
$apiContext = new ApiContext(
    new OAuthTokenCredential(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET'))
);

$apiContext->setConfig(
    array(
        'mode' => env('PAYPAL_MODE'),
    )
);

if ($_POST) {
    $totalAmount = array_sum($_POST['form_upay']);
    if (!$totalAmount) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // After Step 2
    $payer = new Payer();
    $payer->setPaymentMethod('paypal');

    $amount = new Amount();
    $amount->setTotal($totalAmount);
    $amount->setCurrency('USD');

    $transaction = new Transaction();
    $transaction->setAmount($amount);

    $redirectUrls = new RedirectUrls();
    $redirectUrls->setReturnUrl("$baseUrl/lib/paypallib.php?return=success")
        ->setCancelUrl("$baseUrl/lib/paypallib.php?return=cancel");

    $payment = new Payment();
    $payment->setIntent('sale')
        ->setPayer($payer)
        ->setTransactions(array($transaction))
        ->setRedirectUrls($redirectUrls);

    try {
        $payment->create($apiContext);
//        echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
    } catch (PayPalConnectionException $ex) {
        echo $ex->getData();
    }

    foreach ($payment->getLinks() as $link) {
        if ($link->getRel() == 'approval_url') {
            $redirect_url = $link->getHref();
            break;
        }
    }

    $_SESSION['paymentId'] = $payment->getId();
    $_SESSION['totalAmount'] = $totalAmount;
    if (isset($redirect_url)) {
        $paypalTransaction = insertPaypalTransaction($_POST['form_pid'], $totalAmount, $payment->getId(), json_encode($_POST));
        header("Location: " . $redirect_url);
        exit();
    }
}

if ($_GET['return'] == 'success') {
    $paymentId = $_SESSION['paymentId'];
    $paymentTransaction = getPaypalTransaction($paymentId);

    $payment = Payment::get($paymentId, $apiContext);
    $execution = new PaymentExecution();
    $execution->setPayerId($_GET['PayerID']);

    $transaction = new Transaction();
    $amount = new Amount();

    $amount->setCurrency('USD');
    $amount->setTotal($paymentTransaction['payment_amount']);
    $transaction->setAmount($amount);

    $execution->addTransaction($transaction);

    try {
        $result = $payment->execute($execution, $apiContext);
        try {
            $payment = Payment::get($paymentId, $apiContext);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getData();
            header("Location: " . $baseUrl . 'home.php');
        }
    } catch (\PayPal\Exception\PayPalConnectionException $ex) {
        echo $ex->getData();
        header("Location: " . $baseUrl . 'home.php');
    }

    $inputs = [];
    $inputs['transaction_status'] = strtoupper($payment->getState());
    $inputs['payer_email'] = $payment->payer->payer_info->email;
    $inputs['payment_amount_currency'] = $payment->transactions[0]->amount->currency;
    $inputs['transaction_fee'] = $payment->transactions[0]->related_resources[0]->sale->transaction_fee->value;
    $inputs['transaction_fee_currency'] = $payment->transactions[0]->related_resources[0]->sale->transaction_fee->currency;
    $flag = updateSuccessPaypalTransaction($paymentTransaction['id'], $inputs);

    unset($_SESSION['paymentId']);
    unset($_SESSION['totalAmount']);
    header("Location: " . $baseUrl . '/paypal/success.php?payment_id=' . base64_encode($paymentId));
} else if ($_GET['return'] == 'cancel') {
    $paymentId = $_SESSION['paymentId'];
    $paymentTransaction = getPaypalTransaction($paymentId);
    $inputs = [];
    $inputs['transaction_status'] = strtoupper('cancelled');
    $flag = updateCancelledPaypalTransaction($paymentTransaction['id'], $inputs);
    unset($_SESSION['paymentId']);
    unset($_SESSION['totalAmount']);
    header("Location: " . $baseUrl . '/paypal/cancel.php');
} else {
    header("Location: " . $baseUrl . '/paypal/error.php');
}
