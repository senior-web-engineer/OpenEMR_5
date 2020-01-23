<?php
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

$ignoreAuth = true;
require_once("../../../interface/globals.php");
require_once 'sigconvert.php';
$errors = array ();
$signer = filter_input(INPUT_POST, 'signer', FILTER_DEFAULT);
$type = filter_input(INPUT_POST, 'type', FILTER_DEFAULT);
$pid = filter_input(INPUT_POST, 'pid', FILTER_DEFAULT);
$output = filter_input(INPUT_POST, 'output', FILTER_UNSAFE_RAW);
$user = filter_input(INPUT_POST, 'user', FILTER_UNSAFE_RAW);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($type == 'admin-signature') {
        $signer = $user;
    }

    if (! json_decode($output)) {
        exit();
    }

/* Don't need at present
    if( $pid > 0 ) $resizedFile = './../../patient_documents/signed/current/' . $pid . '_master.png';
    else $resizedFile = './../../patient_documents/signed/current/' . $signer . '_master.png';
 */
    $svgsig = '';
    if (empty($errors)) {
        try {
            $svg = new sigToSvg($output, array (
                    'penWidth' => 6
            ));
            $svgsig = $svg->getImage();
            $r = $svg->max[1] / $svg->max[0];
            $x = round($svg->max[0] * $r);
            $y = round($svg->max[1] * $r);
            $img = sigJsonToImage($output, array (
                    'imageSize' => array (
                            $svg->max[0],
                            $svg->max[1]
                    )
            ));
            ob_start();
            imagepng($img);
            $image = ob_get_contents();
            ob_clean();
            $image_png = smart_resize_image(null, $image, $svg->max[0], 75, true, 'return', false, false, 100, false);
            //imagepng( $image_png, $resizedFile, 0 );
            imagepng($image_png);
            $image = ob_get_contents();
            ob_end_clean();
            imagedestroy($img);
            imagedestroy($image_png);
            $image_data = base64_encode($image);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // No validation errors exist, so we can start the database stuff
    if (empty($errors)) {

        $patientConsentForm = sqlQuery("SELECT * FROM `patient_consent_forms` WHERE `pid`=?", array($pid));
        if($patientConsentForm){
            $updateQuery = "UPDATE patient_consent_forms set signature=?, signature_image=?  where id=".$patientConsentForm['id'];
            $result = sqlStatement($updateQuery, [$svgsig, $image_data]);
        } else {
            $insertQuery = "INSERT INTO patient_consent_forms (`pid`,`signature`, `signature_image`)" .
                " VALUES ('".$pid . "','" . $svgsig . "','" . $image_data . "')";
            $result = sqlInsert($insertQuery);
        }
        return json_encode(['data'=>$result]);
    }

    print json_encode('Done');
}
