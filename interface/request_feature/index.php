<?php
/**
 * Feature Request Page for client
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @copyright Copyright (c) 2013-2018 Brady Miller <brady.g.miller@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

require_once("../globals.php");
require_once("$srcdir/acl.inc");

use OpenEMR\Core\Header;
use OpenEMR\Services\VersionService;


?>
<html>
<head>    
    <title><?php echo xl("Feature Request");?> </title>
    <link rel="stylesheet" href="<?php echo $GLOBALS['webroot'] ?>/public/assets/bootstrap-3-3-4/dist/css/bootstrap.min.css?v=41" type="text/css" />
    <link rel="stylesheet" href="<?php echo $GLOBALS['webroot'] ?>/library/jqwidgets/styles/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $GLOBALS['webroot'] ?>/library/jqwidgets/styles/jqx.light.css" type="text/css" />
    <link rel="stylesheet" href="common.css" type="text/css" />

    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/jqwidgets/jqxloader.js"></script>
    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/jqwidgets/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/jqwidgets/jqxdatetimeinput.js"></script>
    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/jqwidgets/jqxcalendar.js"></script>
    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/jqwidgets/jqxgrid.selection.js"></script> 
    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/jqwidgets/jqxgrid.columnsresize.js"></script> 
    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/jqwidgets/jqxdata.js"></script> 
    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/jqwidgets/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/jqwidgets/jqxgrid.filter.js"></script>
    
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <script type="text/javascript">
      var saveUrl = '<?php echo $GLOBALS['webroot']."/interface/request_feature/save.php" ?>';
      <?php
        if (!acl_check('admin', 'acl')) {
          echo "var isAdmin = false;";
        }
        else {
          echo "var isAdmin = true; var saveAdminUrl = '{$GLOBALS['webroot']}/interface/request_feature/admin_save.php';";
        }
      ?>
    </script>
    <script type="text/javascript" src="common.js"></script>
</head>
<body>
<?php if(!acl_check('admin', 'acl')) {?>
  <div class="action-container">
    <button id='btnCreate' class="btn btn-primary mb-2" onclick="$('#window').jqxWindow('open');">Request New Feature</button>
  </div>
<?php }?>
  <div id="grid"></div>
  <div id="jqxLoader"></div>
  
  <div id="window">
    <div id="windowHeader">
      Request New Feature
    </div>
    <div id="windowContent">
      <form validate id="request-feature-form">
        <div id="request-window-content">
          <div class="form-horizontal">
            <div class="form-group">
              <label for="title" class="col-sm-2 control-label">Title</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="title" name="title" placeholder="Request Title" required="required" pattern="(.*\S+.*){5}" validate-msg="Title should be great rather than 5 characters" oninvalid="customValidity(this);" onkeypress="customValidity(this)">
              </div>
            </div>
            <div class="form-group">
              <label for="feature" class="col-sm-2 control-label">Feature</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="feature" name="feature" placeholder="Feature Name" required="required" pattern="(.*\S+.*){3}" validate-msg="Feature should be great rather than 3 characters" oninvalid="customValidity(this);" onkeypress="customValidity(this)" />
              </div>
            </div>
            <div class="form-group">
              <label for="feature_comment" class="col-sm-2 control-label">Feature Comment</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="feature_comment" name="feature_comment" placeholder="Feature Comment" rows="13"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="window-action-panel">
            <input type="submit" class="btn btn-success" id="request-feature" value="Request" style="margin-right: 10px" />
            <input type="button" class="btn btn-danger" id="request-cancel" value="Cancel" onclick="$('#window').jqxWindow('close');" />
        </div>
      </form>
    </div>
  </div>
  <script type="text/html" id="template-detail-view">
    <div class="form-horizontal">
      <div class="form-group">
        <label for="feature_comment" class="col-sm-2 control-label">Feature Comment</label>
        <div class="col-sm-10">
          <textarea class="form-control" id="tmp-feature-comment" rows="8" readonly="readonly"></textarea>
        </div>
      </div>
      <div class="form-group">
        <label for="feature_comment" class="col-sm-2 control-label">Admin Comment</label>
        <div class="col-sm-10">
          <textarea class="form-control" id="tmp-admin-comment" rows="8" readonly="readonly"></textarea>
        </div>
      </div>
    </div>       
  </script>
<?php
  if (acl_check('admin', 'acl') === true) {
?>
  <div id="window-admin-comment">
    <div id="windowHeader">
      Leave Admin Comment
    </div>
    <div id="windowContent">
      <form validate id="admin-update-feature-form">
        <input type="hidden" id="id-for-admin-comment" name="id-for-admin-comment" />
        <div id="request-window-content">
          <div class="form-horizontal">
            <div class="form-group">
              <label for="title" class="col-sm-3 control-label">Status</label>
              <div class="col-sm-9">
                <select class="form-control" id="request-feature-status" name="status">
                  <option>request</option>
                  <option>accepted</option>
                  <option>rejected</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="feature_comment" class="col-sm-3 control-label">Admin Comment</label>
              <div class="col-sm-9">
                <textarea class="form-control" id="admin-comment" name="admin_comment" rows="12"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="window-action-panel">
            <input type="submit" class="btn btn-success" id="admin-request-feature-update" value="Leave comment" style="margin-right: 10px" />
            <input type="button" class="btn btn-danger" value="Cancel" onclick="$('#window-admin-comment').jqxWindow('close');" />
        </div>
      </form>
    </div>
  </div>
<?php
}
?>
</body>
</html>
