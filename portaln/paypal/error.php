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

$errorMessage = 'Please contact the administrator at ' . htmlentities($frow['phone']) . ' for the support if needed.';

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
        </script>
    </head>
    <body style="text-align: center; margin: auto;">
    <div id='pop_receipt' style='display: block'>
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


    </div>
    </body>
    </html>
<?php
ob_end_flush();
?>