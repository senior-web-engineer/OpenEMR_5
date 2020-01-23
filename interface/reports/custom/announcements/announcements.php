<?php
/**
 * Report to view the background services.
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @copyright Copyright (c) 2013-2018 Brady Miller <brady.g.miller@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */


require_once("../../../globals.php");
require_once("$srcdir/acl.inc");
if (!acl_check('admin', 'acl')) {
    echo "(" . xlt('ACL Administration Not Authorized') . ")";
    exit;
}

use OpenEMR\Core\Header;
?>

<html>

<head>

<?php Header::setupHeader(); ?>

  <title><?php echo xlt('Announcements'); ?></title>

  <style type="text/css">
    .announce-body {
      padding: 20px;
    }
    .solid-boder {
      border: 2px solid #ccc;
    }
    .announcement-tr-background {
      background: #b8daff !important;
    }
    label {
      margin-top: 4px;
      font-size: 12px;
    }
    input[type="checkbox"] {
      width: 16px;
      height: 16px;
    }
  </style>

</head>

<body class='announce-body'>

<!-- Create Anncouncemets -->
<?php

  //create/update/delete  announcements
  if (isset($_POST['start_date'])) {
    $needConfirm = isset($_POST['needConfirm']) ? 'yes' : 'no';
    $bindParams = [$_POST['title'], $_POST['announcement'], $_POST['start_date'], $_POST['end_date'], $needConfirm];
    $actionType = $_POST['actionType'];
    
    if ($actionType == 'create') {
   
      $sql = 'INSERT INTO announcements SET '.
              'title=?,
              announcement=?,
              start_date=?,
              end_date=?,
              created_date = NOW(),
              need_read_confirmation=?';    
      sqlInsert($sql, $bindParams);
   
    } else if($actionType == 'update') {
     
      $sql = 'UPDATE announcements SET '.
              'title=?,
              announcement=?,
              start_date=?,
              end_date=?,
              need_read_confirmation=?'.
              'WHERE id=?';
      $bindParams[] = $_POST['announcementId'];
      sqlQuery($sql, $bindParams);
    
    } else if($actionType == 'delete') {

      $sql='DELETE FROM announcements WHERE id=?';
      $bindParams=[$_POST['announcementId']];
      sqlQuery($sql, $bindParams);
    
    }
  }

?>

<span class='title'><?php echo xlt('All Announcements'); ?></span>

<form method='POST' name='theform' id='theform' action='announcements.php' onsubmit='return top.restoreSession()'>

  <input type='hidden' id='announce_id' name='announce_id'>
  <input type='hidden' id='need_read_confirmation' name='need_read_confirmation' class="form-control">

<br>
<table class="table table-hover table-striped solid-boder table-responsive" width="100%">

  <thead>
    <th style='text-align: center' width="20%">
      <?php echo xlt('Title'); ?>
    </th>

    <th style='text-align: center' width="40%">
      <?php echo xlt('Announcement'); ?>
    </th>

    <th style='text-align: center' width="10%">
      <?php echo xlt('Start Date'); ?>
    </th>

    <th style='text-align: center' width="10%">
      <?php echo xlt('End Date'); ?>
    </th>

    <th style='text-align: center' width="3%">
      <?php echo xlt('Need Read Confirmation'); ?>
    </th>

    <th style='text-align: center' width="10%">
      <?php echo xlt('Created Date'); ?>
    </th>

  </thead>
  <tbody>  <!-- added for better print-ability -->
  <?php
  $arrAnnounce = [];
  $res = sqlStatement("SELECT * FROM `announcements`");
  while ($row = sqlFetchArray($res)) {
    array_push($arrAnnounce, $row);
  ?>
    <tr id='tr_<?php echo $row['id']; ?>' onclick="selectAnnouncement(<?php echo $row['id']; ?>)">
        <td align='center'><?php echo xlt($row['title']); ?></td>

        <td align='center'><?php echo xlt($row['announcement']); ?></td>

        <td align='center'><?php echo xlt($row['start_date']); ?></td>

        <td align='center'><?php echo xlt($row['end_date']); ?></td>

        <td align='center'><?php echo xlt($row['need_read_confirmation']); ?></td>

        <td align='center'><?php echo xlt($row['created_date']); ?></td>

    </tr>
  <?php
  } // $row = sqlFetchArray($res) while
  ?>
  </tbody>
</table>

<br><br>
<span class='title'><?php echo xlt('Announcements Details'); ?></span>

</form>

  <form id='detailForm' method='POST' class='solid-boder' action='announcements.php' style='width: 100%; padding-top: 20px' onsubmit='return top.restoreSession()'>
    
    <div class="form-group row">
      <label for='start_date' style='text-align: right' class='col-sm-2 col-form-label'> Start Date: </label>
      <div class="col-sm-3">
        <input type='date' name='start_date' id='start_date' class='form-control' required>
      </div>

      <label for='end_date' style='text-align: right' class='col-sm-2 col-form-label'> End Date: </label>
      <div class="col-sm-3">
        <input type='date' name='end_date' id='end_date' class='form-control' required>
      </div>
    </div>
    
    <div class="form-group row">
      <label for='title' style='text-align: right' class='col-sm-2 col-form-label'> Title: </label>
      <div class="col-sm-8">
        <input type='text' name='title' id='title' class='form-control' style='width: 100%' required>
      </div>
    </div>

    <div class="form-group row">
      <label for='announcement' style='text-align: right' class='col-sm-2 col-form-label'> Announcement: </label>
      <div class="col-sm-8">
        <textarea name='announcement' id='announcement' class='form-control' rows="5" style='width: 100%; resize: vertical;' required></textarea>
      </div>
    </div>

    <div class="form-group row">
      <label for='needConfirm' style='text-align: right' class='col-sm-2 col-form-label'> Need Read Confirmation: </label>
      <div class="col-sm-8">
        <input type='checkbox' name='needConfirm' id='needConfirm' />
      </div>
    </div>

    <div class="form-group row">
      <div class="col-sm-10" style="text-align: right">
        <button id='btnCreate' class="btn btn-primary mb-2" onclick='createAnnouncement()'>Create</button>
        <button id='btnUpdate' class="btn btn-success mb-2" onclick='updateAnnouncement()' disabled>Update</button>
        <button id='btnDelete' class="btn btn-danger mb-2" onclick='deleteAnnouncement()' disabled>Delete</button>
      </div>
    </div>

    <input type='hidden' id='actionType' name='actionType' value='create'>
    <input type='hidden' id='announcementId' name='announcementId'>

  </form>
</body>

<script type='text/javascript'>
  let arrAnnounce = <?php echo json_encode($arrAnnounce); ?>;

  function createAnnouncement() {
    $('#actionType').val('create');
    $('#detailForm').submit();
  }

  function updateAnnouncement() {
    $('#actionType').val('update');
    $('#detailForm').submit();
  }

  function deleteAnnouncement() {
    $('#actionType').val('delete');
    $('#detailForm').submit();
  }

  function selectAnnouncement(id) {
    $('#tr_' + id).addClass('announcement-tr-background').siblings().removeClass('announcement-tr-background');
    $('#announcementId').val(id);
    $('#btnUpdate').prop('disabled', false);
    $('#btnDelete').prop('disabled', false);

    arrAnnounce.forEach(function(announce) {
        
      if (parseInt(announce['id']) === id) {
      
        $('#start_date').val(announce['start_date']);
        $('#end_date').val(announce['end_date']);
        $('#title').val(announce['title']);
        $('#announcement').val(announce['announcement']);
        if (announce['need_read_confirmation'] === 'yes') {
          $('#needConfirm').prop('checked', true);
        } else {
          $('#needConfirm').prop('checked', false);
        }

        return;
      
      }
    });

  }
</script>
</html>

