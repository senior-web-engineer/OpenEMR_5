<?php

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

require_once("./../lib/appsql.class.php");
require_once("./../lib/paypal.inc");
require_once("$srcdir/patient.inc");
$baseUrl = (env('APP_ENV') == 'dev') ? "http://localhost/portalopenemr/portal" : "https://portal.pircinc.org/openemr/portal";

// Get details for what we guess is the primary facility.
$frow = sqlQuery("SELECT * FROM facility " . "ORDER BY billing_location DESC, accepts_assignment DESC, id LIMIT 1");


$errorMessage = null;
if (!$_REQUEST['payment_id']) {
    $errorMessage = 'Something went wrong while processing your request. Please contact the administrator at ' . htmlentities($frow['phone']) . ' for the support.';
}

$paypalTransaction = getPaypalTransaction(base64_decode($_REQUEST['payment_id']));
$patient = getPatientData($pid, 'pid,title,fname,mname,lname,dob,postal_code');

if ($pid != $paypalTransaction['pid']) {
    $errorMessage = 'Something went wrong while processing your request. Please contact the administrator at ' . htmlentities($frow['phone']) . ' for the support.';
} else {
    echo "<script>alert('Thank You! Your payment is accepted.')</script>";
}

// Now proceed with printing the receipt.
ob_start();
?>
    <html>
    <head>

        <title><?php echo xlt('Receipt for Payment'); ?></title>

        <script type="text/javascript"
                src="<?php echo $GLOBALS['assets_static_relative']; ?>/jquery-min-1-11-3/index.js"></script>
        <script type="text/javascript">
            $(document).ready();

            function goHome() {
                window.location.replace("<?= $baseUrl ?>/home.php");
            }

            function notifyPatient() {
                var pid = <?php echo attr($pid);?>;
                var note = $('#pop_receipt').text();
                var formURL = './messaging/handle_note.php';
                $.ajax({
                    url: formURL,
                    type: "POST",
                    data: {
                        'task': 'add',
                        'pid': pid,
                        'inputBody': note,
                        'title': 'Bill/Collect',
                        'sendto': '-patient-',
                        'noteid': '0'
                    },
                    success: function (data, textStatus, jqXHR) {
                        alert('Receipt sent to patient via Messages.')
                    },
                    error: function (jqXHR, status, error) {
                        console.log(status + ": " + error);
                    }
                });
            }
        </script>
    </head>
    <body style="text-align: center; margin: auto;">
    <div id='pop_receipt' style='display: block'>

            <?php if ($errorMessage){ ?>
                <p><?php echo text($frow['name']) ?>
                    <br><?php echo text($frow['street']) ?>
                    <br><?php echo text($frow['city'] . ', ' . $frow['state']) . ' ' . text($frow['postal_code']) ?>
                    <br><?php echo htmlentities($frow['phone']) ?>
                <p>
        <div style="text-align: center; margin: auto;">
            <table border='0' cellspacing='8'
                   style="text-align: center; margin: auto;">
                <tr>
                    <td><?= $errorMessage ?></td>
                </tr>
            </table>
        </div>
        <button class='btn btn-sm' type='button' onclick='goHome()'
                id='returnhome'><?php echo xla('Return Home'); ?></button>

        <?php } else { ?>
                <h2><?php echo xlt('Receipt for Payment'); ?></h2>
                <p><?php echo text($frow['name']) ?>
                    <br><?php echo text($frow['street']) ?>
                    <br><?php echo text($frow['city'] . ', ' . $frow['state']) . ' ' . text($frow['postal_code']) ?>
                    <br><?php echo htmlentities($frow['phone']) ?>
                <p>
            <div style="text-align: center; margin: auto;">
                <table border='0' cellspacing='8'
                       style="text-align: center; margin: auto;">
                    <tr>
                        <td><?php echo xlt('Date'); ?>:</td>
                        <td><?php echo text(oeFormatSDFT(strtotime($paypalTransaction['created_at']))) ?></td>
                    </tr>
                    <tr>
                        <td><?php echo xlt('Patient'); ?>:</td>
                        <td><?php echo text($patient['fname']) . " " . text($patient['mname']) . " " . text($patient['lname']) . " (" . text($patdata['pubpid']) . ")" ?></td>
                    </tr>
                    <tr>
                        <td><?php echo xlt('Paid Via'); ?>:</td>
                        <td><?php echo text('Paypal'); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo xlt('Amount Paid'); ?>:</td>
                        <td><?php echo text(oeFormatMoney($paypalTransaction['payment_amount'])) ?></td>
                    </tr>
                    <tr>
                        <td><?php echo xlt('Payment ID'); ?>:</td>
                        <td><?php echo text($paypalTransaction['payment_id']) ?></td>
                    </tr>
                    <tr>
                        <td><?php echo xlt('Payer Email'); ?>:</td>
                        <td><?php echo text($paypalTransaction['payer_email']) ?></td>
                    </tr>
                    <tr>
                        <td><?php echo xlt('Payment Status'); ?>:</td>
                        <td><?php echo text($paypalTransaction['transaction_status']) ?></td>
                    </tr>
                </table>
            </div>
            <button class='btn btn-sm' type='button' onclick='goHome()'
                    id='returnhome'><?php echo xla('Return Home'); ?></button>
            <!--    <button class='btn btn-sm' type='button' onclick="notifyPatient()">--><?php //echo xla('Notify Patient'); ?><!--</button>-->
        <?php } ?>
    </div>
    </body>
    </html>
<?php
ob_end_flush();
?>