<?php
/**
 * Portal referral Wizard
 *
 * @package OpenEMR
 * @link    http://www.open-emr.org
 * @author  Jerry Padgett <sjpadgett@gmail.com>
 * @copyright Copyright (c) 2017-2018 Jerry Padgett <sjpadgett@gmail.com>
 * @license https://www.gnu.org/licenses/agpl-3.0.en.html GNU Affero General Public License 3
 */
error_reporting(false);
session_start();
session_regenerate_id(true);

unset($_SESSION['itsme']);
$_SESSION['authUser'] = 'portal-user';
$_SESSION['pid'] = true;
$_SESSION['referral'] = true;

$_SESSION['site_id'] = isset($_SESSION['site_id']) ? $_SESSION['site_id'] : 'default';
$landingpage = "index.php?site=" . $_SESSION['site_id'];

$ignoreAuth_onsite_portal_two = true;

require_once("../../interface/globals.php");
require_once("../../library/options.inc.php");

$res2 = sqlStatement("select * from lang_languages where lang_description = ?", array(
    $GLOBALS['language_default']
));
for ($iter = 0; $row = sqlFetchArray($res2); $iter++) {
    $result2[$iter] = $row;
}
if (count($result2) == 1) {
    $defaultLangID = $result2[0]{"lang_id"};
    $defaultLangName = $result2[0]{"lang_description"};
} else {
    // default to english if any problems
    $defaultLangID = 1;
    $defaultLangName = "English";
}

if (!isset($_SESSION['language_choice'])) {
    $_SESSION['language_choice'] = $defaultLangID;
}
// collect languages if showing language menu
if ($GLOBALS['language_menu_login']) {
    // sorting order of language titles depends on language translation options.
    $mainLangID = empty($_SESSION['language_choice']) ? '1' : $_SESSION['language_choice'];
    if ($mainLangID == '1' && !empty($GLOBALS['skip_english_translation'])) {
        $sql = "SELECT * FROM lang_languages ORDER BY lang_description, lang_id";
        $res3 = SqlStatement($sql);
    } else {
        // Use and sort by the translated language name.
        $sql = "SELECT ll.lang_id, " . "IF(LENGTH(ld.definition),ld.definition,ll.lang_description) AS trans_lang_description, " . "ll.lang_description " .
            "FROM lang_languages AS ll " . "LEFT JOIN lang_constants AS lc ON lc.constant_name = ll.lang_description " .
            "LEFT JOIN lang_definitions AS ld ON ld.cons_id = lc.cons_id AND " . "ld.lang_id = ? " .
            "ORDER BY IF(LENGTH(ld.definition),ld.definition,ll.lang_description), ll.lang_id";
        $res3 = SqlStatement($sql, array(
            $mainLangID
        ));
    }

    for ($iter = 0; $row = sqlFetchArray($res3); $iter++) {
        $result3[$iter] = $row;
    }

    if (count($result3) == 1) {
        // default to english if only return one language
        $hiddenLanguageField = "<input type='hidden' name='languageChoice' value='1' />\n";
    }
} else {
    $hiddenLanguageField = "<input type='hidden' name='languageChoice' value='" . htmlspecialchars($defaultLangID, ENT_QUOTES) . "' />\n";
}

?>

<?php
if($_POST)
{
    require_once("./../lib/consent_form.inc");
    $_POST['gender'] = $_POST['gender'] == 'Other' ? $_POST['gender_other'] : $_POST['gender'];
    $referral = insertReferralData($_POST);
    $response = json_decode($referral);
    if($response->type == 'success'){
        echo ("<script type='text/javascript'>
    window.alert('Thank you for your referral. A member of the PIRC team will contact you using the information indicated on the referral form.');
    window.location.href='https://pircinc.org';
    </script>");
    } else {
        echo ("<script type='text/javascript'>
    window.alert('Something went wrong while processing your referral request.');
    window.location.reload(forceGet);
    </script>");
    }
}
?>

<!DOCTYPE html>
<!-- saved from url=(0071)https://portal.pircinc.org/openemr/portal/account/register.php?typeId=2 -->
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo xlt('Referral Form'); ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="">

    <link href="./../assets/css/registration/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="./../assets/css/registration/jquery.datetimepicker.min.css">
    <link href="./../assets/css/registration/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="./../assets/css/registration/register.css" rel="stylesheet" type="text/css">
    <!-- Cstm-site.css Link -->
    <link href="./../assets/css/registration/cstm-site.css" rel="stylesheet" type="text/css">
    <script src="./../assets/css/registration/index.js.download" type="text/javascript"></script>

    <script src="./../assets/css/registration/bootstrap.min.js.download" type="text/javascript"></script>
    <script type="text/javascript" src="./../assets/css/registration/jquery.datetimepicker.full.min.js.download"></script>
    <script type="text/javascript" src="./../assets/css/registration/eModal.js.download"></script>

    <style>
        .display-block{
            display:block!important;
        }
        fieldset hr{ margin-top:12px; margin-bottom:12px; }
        .consent-inline p, .consent-inline form, .fee form, .fee form label{
          display:inline-block;
        }
        .consent-inline input, .fee input, .drug input{ border:none; border-bottom:1px solid #333; box-shadow:none; border-radius:0; margin-left:10px; }
        .consent-inline input:focus, .fee input:focus, .drug input:focus, .inline-select select:focus{
          outline:none;
          box-shadow:none;
        }
        .fee input{
          width:10%;
        }
        .fee input, .drug input, .inline-select select{
          display:inline-block;
        }
        .table tr td select{
          webkit-appearance:menulist;
        }
        select::-ms-expand { display: block; }
        /*Referral Form CSS*/
        .web-link a{
            font-size: 12px;
            margin-left: 15px;
            color: #fff;
        }
        .web-link a:hover{
            color:#bfdefd;
        }

    </style>

</head>
<body class="skin-blue md-bg">
<div class="container">
    <!-- End Insurance. Next what we've been striving towards..the end-->
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <fieldset>
                <form action="" method="post" id="referralForm">
                <legend class="bg-success title-bg">
                    <div class="row">
                        <div class="col-sm-12 col-md-5 web-link">
                            <a href="https://pircinc.org">Back to main website</a>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            Referral Form
                        </div>
                    </div>
                </legend>
                <div class="well ml-bg register-success">

                      <div class="referral-form">
                          <div class="form-row">
                            <div class="col-sm-12 col-md-4">
                              <label class="">Patient Name: </label>
                              <input type="text" class="form-control" name="patient_name" placeholder="fill here" required>
                            </div>
                            <div class="col-sm-12 col-md-4">
                              <label>Age:</label>
                              <input type="number" class="form-control" name="age" placeholder="fill here" min="1">
                            </div>
                            <div class="col-sm-12 col-md-4">
                              <label>D.O.B:</label>
                              <input type="text" class="form-control datepicker" name="dob" placeholder="fill here">
                            </div>
                          </div>
                          <div class="clearfix"></div>

                          <div class="form-row">
                            <div class="col-sm-12 col-md-4 ctm-form mt-4">
                              <label>Gender: </label>
                              <label class="ctmcontainer ">Male<input type="radio" name="gender" value="Male">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                              </label>
                              <label class="ctmcontainer ">Female<input type="radio" name="gender" value="Female">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                              </label>
                                <label class="ctmcontainer ">Other<input type="radio" name="gender" value="Other">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-sm-12 col-md-4 ctm-form mt-4 otherGender">
                              <label class="">Other (Specify)</label>
                              <input type="text" class="form-control" name="gender_other">
                            </div>
                          </div>
                          <div class="clearfix"></div>

                          <div class="form-row">
                              <div class="col-sm-12 col-md-4 ctm-form mt-4">
                                  <label class="">Insurance Provider#: </label>
                                  <input type="text" class="form-control" name="insurance_provid-er">
                              </div>
                              <div class="col-sm-12 col-md-4 ctm-form mt-4">
                                  <label class="">Policy Number#: </label>
                                  <input type="text" class="form-control" name="policy_number">
                              </div>
                              <div class="col-sm-12 col-md-4 ctm-form mt-4">
                                  <label class="">Medicaid #: </label>
                                  <input type="text" class="form-control" name="medicaid">
                              </div>
                          </div>
                          <div class="clearfix"></div>

                          <div class="form-row">

                              <div class="col-sm-12 col-md-4 ctm-form mt-4">
                                  <label class="">Medicare Number #: </label>
                                  <input type="text" class="form-control" name="medicare_number">
                              </div>
                              <div class="col-sm-12 col-md-4 mt-4">
                                  <label class="">Street: </label>
                                  <input type="text" class="form-control" name="street" placeholder="Street" required>
                              </div>
                              <div class="col-sm-12 col-md-4 mt-4">
                                  <label>City:</label>
                                  <input type="text" class="form-control" name="city" placeholder="City" required>
                              </div>
                          </div>
                          <div class="clearfix"></div>

                          <div class="form-row">

                              <div class="col-sm-12 col-md-4 mt-4">
                                  <label>State:</label>
                                  <?php
                                  echo generate_select_list('state', 'state', $row['state'], xl('State'), 'Unassigned', "form-control");
                                  ?>
                              </div>
                            <div class="col-sm-12 col-md-4 mt-4">
                              <label class="">Zip Code: </label>
                              <input type="number" class="form-control" name="zip_code" placeholder="Zip Code">
                            </div>
                              <div class="col-sm-12 col-md-4 mt-4">
                                  <label class="">Email Address #: </label>
                                  <input type="text" class="form-control" name="email_address" placeholder="Email Address">
                              </div>
                          </div>
                          <div class="clearfix"></div>

                          <div class="form-row">
                            <div class="col-sm-12 col-md-4 mt-4">
                              <label class="">Telephone #: </label>
                                <select class="form-control" name="telephone_type">
                                    <option value="home">Home</option>
                                    <option value="office">Office</option>
                                    <option value="mobile">Mobile</option>
                                </select>
                            </div>
                              <div class="col-sm-12 col-md-4 mt-4">
                                  <label class="">Telephone Number: </label>
                                  <input type="text" class="form-control" name="telephone_number" placeholder="Telephone Number">
                              </div>
                          </div>
                          <div class="clearfix"></div>

                          <div class="row">
                            <div class="col-sm-12">
<!--                              <span class="seperator mt-4"></span>-->
                            </div>
                          </div>
                          <div class="clearfix"></div>

                          <div class="form-row">
                            <div class="col-sm-12 col-md-8 mt-4">
                              <label class="">Referring Agency: </label>
                              <input type="text" class="form-control" name="referring_agency" placeholder="Referring Agency">
                            </div>

                            <div class="col-sm-12 col-md-4 mt-4">
                              <label class="">Referring Email: </label>
                              <input type="text" class="form-control" name="referring_email" placeholder="Referring Email">
                            </div>
                          </div>
                          <div class="clearfix"></div>

                          <div class="form-row">
                            <div class="col-sm-12 col-md-8 mt-4">
                              <label class="">Name Ref. Source: </label>
                              <input type="text" class="form-control" name="referring_source" placeholder="Name Ref. Source">
                            </div>

                            <div class="col-sm-12 col-md-4 mt-4">
                              <label class="">Title: </label>
                              <input type="text" class="form-control" name="referring_title" placeholder="Title">
                            </div>
                          </div>
                          <div class="clearfix"></div>

                          <div class="form-row">
                            <div class="col-sm-12 form-group form-group col-md-6 mt-4">
                              <label class="">Phone #: </label>
                              <input type="text" class="form-control" name="referring_phone" placeholder="Telephone">
                            </div>

                            <div class="col-sm-12 form-group col-md-6 mt-4">
                              <label class="">Fax: </label>
                              <input type="text" class="form-control" name="referring_fax" placeholder="Fax">
                            </div>
                          </div>
                          <br/>
                      </div>
                      <div class="form-row">
                        <div class="col-sm-12 form-group col-md-12 mt-4">
                          <h4>Reason for referral (check all that applies): </h4>
                        </div>
                      </div>
                  <div class="form-row">
                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Death
                        <input type="checkbox" name="reason[]" value="Death">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Mental Illness
                        <input type="checkbox" name="reason[]" value="Mental Illness">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Drug Abuse
                        <input type="checkbox" name="reason[]" value="Drug Abuse">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Homeless
                        <input type="checkbox" name="reason[]" value="Homeless">
                        <span class="checkmark"></span>
                      </label>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Anger
                        <input type="checkbox" name="reason[]" value="Anger">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Parenting
                        <input type="checkbox" name="reason[]" value="Parenting">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Divorce
                        <input type="checkbox" name="reason[]" value="Divorce">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Family Conflicts
                        <input type="checkbox" name="reason[]" value="Family Conflicts">
                        <span class="checkmark"></span>
                      </label>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Custody
                        <input type="checkbox" name="reason[]" value="Custody">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Dom. violence
                        <input type="checkbox" name="reason[]" value="Dom. violence">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Depression
                        <input type="checkbox" name="reason[]" value="Depression">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Child care
                        <input type="checkbox" name="reason[]" value="Child care">
                        <span class="checkmark"></span>
                      </label>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Self-esteem
                        <input type="checkbox" name="reason[]" value="Self-esteem">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Social Skills
                        <input type="checkbox" name="reason[]" value="Social Skills">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Run-Away
                        <input type="checkbox" name="reason[]" value="Run-Away">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Truancy
                        <input type="checkbox" name="reason[]" value="Truancy">
                        <span class="checkmark"></span>
                      </label>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Medication
                        <input type="checkbox" name="reason[]" value="Medication">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Financial
                        <input type="checkbox" name="reason[]" value="Financial">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Child Abuse
                        <input type="checkbox" name="reason[]" value="Child Abuse">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Child Neglect
                        <input type="checkbox" name="reason[]" value="Child Neglect">
                        <span class="checkmark"></span>
                      </label>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Sexual Abuse
                        <input type="checkbox" name="reason[]" value="Sexual Abuse">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Crime Victim
                        <input type="checkbox" name="reason[]" value="Crime Victim">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Legal Issues
                        <input type="checkbox" name="reason[]" value="Legal Issues">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                    <div class="form-group col-xs-6 col-md-3 mt-2">
                      <label class="ctmcontainer">Other
                        <input type="checkbox" name="reason[]" value="Other">
                        <span class="checkmark"></span>
                      </label>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-xs-12 col-md-12">
                        <label>Comments on the above: </label>
                        <textarea class="form-control" rows="4" name="comments"></textarea>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-sm-12 form-group">
                          <!-- <button class="btn btn-primary prevBtn btn-sm pull-left mt-4 mb-3" type="button">Previous</button> -->
                          <button class="btn btn-success btn-sm pull-right mt-4 mb-3 send-r" style="width:15%;" type="submit" id="submitPatient">Submit</button>
                      </div>
                  </div>
                </div>
                </form>
            </fieldset>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.datepicker').datetimepicker({
                <?php $datetimepicker_timepicker = false; ?>
                <?php $datetimepicker_showseconds = false; ?>
                <?php $datetimepicker_formatInput = false; ?>
                <?php require($GLOBALS['srcdir'] . '/js/xl/jquery-datetimepicker-2-5-4.js.php'); ?>
            });
        $('.otherGender').hide();
        $('[name="gender"]').on('change', function(e){
            (this.value == 'Other') ? $('.otherGender').show() : $('.otherGender').hide();
        });
    });

</script>
</body>
</html>
