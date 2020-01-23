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

error_reporting(E_ALL);
$ignoreAuth = true;
require_once("../../../interface/globals.php");
require_once('sigconvert.php');
$errors = array ();
$signer = filter_input(INPUT_POST, 'signer', FILTER_DEFAULT);
$type = filter_input(INPUT_POST, 'type', FILTER_DEFAULT);
$signatureId = filter_input(INPUT_POST, 'signature_id', FILTER_DEFAULT);
$output = filter_input(INPUT_POST, 'output', FILTER_UNSAFE_RAW);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($type == 'admin-signature') {
        $signer = $user;
    }

    if (! json_decode($output)) {
        exit();
    }

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
    if (empty($errors))
    {
        $sig_hash = sha1($output);
        $created = time();
        $ip = $_SERVER['REMOTE_ADDR'];
        $status = 'filed';
        $lastmod = date('Y-m-d H:i:s');

        $patientSignature = sqlQuery("SELECT * FROM `onsite_signatures` WHERE `id`=?", array($signatureId));
        if($patientSignature){
            $updateQuery = "UPDATE onsite_signatures SET ".
                "lastmod = '". $lastmod ."',".
                "type = '". $type ."',".
                "signator = '". $signer ."',".
                "signature = '". $svgsig ."',".
                "sig_hash = '". $sig_hash ."',".
                "ip = '". $ip ."',".
                "sig_image = '". $image_data ."' ".
                "WHERE id=".$signatureId;
            sqlStatement($updateQuery);
        } else {
            $insertQuery = "INSERT INTO onsite_signatures (lastmod,status,type,signator, signature, sig_hash, ip, created, sig_image) VALUES (?,?,?,?,?,?,?,?,?) ";
            $signatureId = sqlInsert($insertQuery, [$lastmod, $status,$type, $signer, $svgsig, $sig_hash, $ip, $created, $image_data]);
        }
        $signature = sqlQuery("SELECT id,pid,signature,sig_image FROM `onsite_signatures` WHERE `id`=?", array($signatureId));

        echo json_encode(['type'=>'success', 'signature'=>$signature], 200);
        exit();
    }
    echo json_encode(['type'=>'error', 'message'=>'Something went Error']);
    exit();
}
