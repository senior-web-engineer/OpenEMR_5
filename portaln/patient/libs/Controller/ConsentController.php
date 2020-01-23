<?php
/** @package    Patient Portal::Controller */

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

/**
 * import supporting libraries
 */
require_once("AppBaseController.php");
require_once("Model/Patient.php");

/**
 * PatientController is the controller class for the Patient object.
 * The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package Patient Portal::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class ConsentController extends AppBaseController
{

    /**
     * Override here for any controller-specific functionality
     *
     * @inheritdocs
     */
    protected function Init()
    {
        parent::Init();
        // require_once ( '../lib/appsql.class.php' );

        // $this->RequirePermission(SecureApp::$PERMISSION_USER,'SecureApp.LoginForm');
    }

    /**
     * API Method inserts a new Patient record and render response as JSON
     */
    public function Create()
    {
        $json = json_decode(RequestUtil::GetBody());
        dd($json);
    }

    public function Avatar()
    {
        $pid = RequestUtil::Get('patientId');
        $appsql = new ApplicationTable();
        try {
            if(isset($_FILES['attachment'])){
                $errors= array();
                $fileName = $_FILES['attachment']['name'];
                $fileSize =$_FILES['attachment']['size'];
                $fileTmp =$_FILES['attachment']['tmp_name'];
                $fileType=$_FILES['attachment']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                $newFileName = str_random(4).time();
                $extensions= array("jpeg","jpg","png");

                if(in_array($fileExtension,$extensions)=== false){
                    $errors[]="extension not allowed, please choose a JPEG or PNG file.";
                }

                if($fileSize > 2097152){
                    $errors[]='File size must be less than or equal to 2 MB';
                }
                if(empty($errors)==true){
                    $storeFileName = 'attachments/'.$newFileName.'.'.$fileExtension;
                    $targetPath = __DIR__."/../../../".$storeFileName;
                    move_uploaded_file($fileTmp, $targetPath);
                    chmod($targetPath, 0644);
                    $inputs = array ();
                    $inputs['pid'] = $pid;
                    $inputs['attachment'] = $storeFileName;
                    $appsql->portalNewAttachment($inputs);
                    echo json_encode([
                        'type'=>'success',
                        'message'=>'Avatar uploaded successfully.'
                    ]);
                }else{
                    echo json_encode([
                        'type'=>'error',
                        'message'=>$errors
                    ]);
                }
            }
        } catch (Exception $ex) {
            $this->RenderExceptionJSON($ex);
        }
    }
}
