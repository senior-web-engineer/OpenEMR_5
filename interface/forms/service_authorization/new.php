<!-- Form generated from formsWiz -->
<?php
	$fake_register_globals=false;
	$sanitize_all_escapes=true;

	include_once("../../globals.php");
	include_once("$srcdir/api.inc");
	formHeader("Form: Service Authorization");

	use OpenEMR\Core\Header;

	$testing = "";
	$formid = 0 + (isset($_GET['id']) ? $_GET['id'] : ''); // formid
	$fsaid = formFetch("form_service_authorization_id", $formid);
	
	$testing .= " formid=" . $formid . " form_service_authorization_id=" . $fsaid;
	$testing .= " pid=" . $_SESSION["pid"] . " encounter=" . $_SESSION["encounter"];
	
	$check_res = array();
	if ($formid > 0) {
		$sql = "SELECT * FROM form_service_authorization 
				WHERE form_id=? AND pid = ? AND encounter = ? and IsDeleted = 0";
		$res = sqlStatement($sql, array($formid, $_SESSION["pid"], $_SESSION["encounter"]));
		for ($iter = 0; $row = sqlFetchArray($res); $iter++) {
			$check_res[$iter] = $row;
		}
	}
	$blank_obj = array(
		"insurance_provider" => "",
		"authorization_number" => "",
		"start_date" => "",
		"end_date" => "",
		"units" => "",
		"service_code" => "",
		"service_name" => "",
		"code_type" => "",
		"id" => 0
	);

	if ($formid > 0 && !empty($check_res)) {
		$testing .= " found data";
		$check_res = $check_res;
	} else {
		$testing .= " no data found";
		$check_res = array($blank_obj);
	}

	$providers = array();
	$providers_data = sqlStatement("select id, name, inactive from insurance_companies where inactive = '0' ORDER BY name");
	for ($iter = 0; $row = sqlFetchArray($providers_data); $iter++) {
		$providers[$iter] = $row;
	}

	if ($formid > 0) {
		$mode = "update";
	} else {
		$mode = "new";
	}
?>
<html>
<head>
	<title><?php echo xlt("Service Authorization"); ?></title>

	<?php Header::setupHeader(['datetime-picker']);?>

	<style type="text/css" title="mystyles" media="all">
		@media only screen and (max-width: 768px) {
			[class*="col-"] {
				width: 100%;
				text-align:left!Important;
			}
		}
		.tb_row {
			border-bottom: 1px solid #e5e5e5;
			padding-bottom: 8px;
		}
	</style>

	<script type="text/javascript">

		function duplicateRow(e) {
			var newRow = e.cloneNode(true);
			e.parentNode.insertBefore(newRow, e.nextSibling);
			changeIds('tb_row', true);
			changeIds('id');
			changeIds('visible_id');
			changeIds('insurance_provider');
			changeIds('authorization_number');
			changeIds('start_date');
			changeIds('end_date');
			changeIds('units');
			changeIds('service_code');
			changeIds('service_name');
			changeIds('code_type');
			removeVal(newRow.id);
		}

		function removeVal(rowId) {
			// hilight row and make id a negative number
			rowId1 = rowId.split('tb_row_');
			document.getElementById("id_" + rowId1[1]).value = 0;
			document.getElementById("visible_id_" + rowId1[1]).innerHTML = 0;
			document.getElementById("insurance_provider_" + rowId1[1]).value = '';
			document.getElementById("authorization_number_" + rowId1[1]).value = '';
			document.getElementById("start_date_" + rowId1[1]).value = '';
			document.getElementById("end_date_" + rowId1[1]).value = '';
			document.getElementById("units_" + rowId1[1]).value = '';
			document.getElementById("service_code_" + rowId1[1]).value = '';
			document.getElementById("service_name_" + rowId1[1]).value = '';
			document.getElementById("code_type_" + rowId1[1]).value = '';
		}

		function changeIds(class_val, isClass) {
			var elem = null;
			if (!!isClass) {
				elem = document.getElementsByClassName(class_val);
			} else {
				elem = $("[name='" + class_val + "[]'");
			}
			if (elem) {
				for (var i = 0; i < elem.length; i++) {
					if (elem[i].id) {
						index = i + 1;
						elem[i].id = class_val + "_" + index;
					}
				}
			}
		}

		function deleteRow(rowId) {
			if (rowId != 'tb_row_1') {
				var rowId1 = rowId.split('tb_row_');
				var oldId = document.getElementById("id_" + rowId1[1]).value;
				if (oldId > 0) {
					document.getElementById("id_" + rowId1[1]).value = (-oldId);
					document.getElementById("visible_id_" + rowId1[1]).innerHTML = (-oldId);
					$("#" + rowId).hide();
				} else {
					alert('Can not delete first row');
				}
			}
		}

		$(document).ready(function() {
			// special case to deal with static and dynamic datepicker items
			$(document).on('mouseover','.datepicker', function(){
				$(this).datetimepicker({
					<?php $datetimepicker_timepicker = false; ?>
					<?php $datetimepicker_showseconds = false; ?>
					<?php $datetimepicker_formatInput = false; ?>
					<?php require($GLOBALS['srcdir'] . '/js/xl/jquery-datetimepicker-2-5-4.js.php'); ?>
					<?php // can add any additional javascript settings to datetimepicker here; need to prepend first setting with a comma ?>
				});
			});
		});

	</script>
</head>
<body class="body_top">

<?php //echo $testing; ?>

<form method=post 
	action="<?php echo $rootdir;?>/forms/service_authorization/save.php?mode=<?php echo $mode;?>&id=<?php echo $formid;?>" 
	name="my_form">

	<div class="container">
		<div class="row">
			<div class="page-header">
				<h2><?php echo xlt('Service Authorization'); ?></h2>
			</div>
		</div>

		<div class="row">
			<fieldset>
				<legend><?php echo xlt('Enter Details'); ?></legend>

				<?php
				if (!empty($check_res)) {
					foreach ($check_res as $key => $obj) {
						$rowIdx = attr($key) + 1;
				?>

				<div class="tb_row" id="tb_row_<?php echo $rowIdx; ?>">
					<div class="row">
						<div class=" forms col-xs-1">
							<label for="id_<?php echo $rowIdx; ?>" class="h5"><?php echo xlt('ID: '); ?></label>
							<span name="visible_id[]" id="visible_id_<?php echo $rowIdx; ?>"><?php echo text($obj{"id"}); ?></span>
							<input type="hidden" name="id[]" id="id_<?php echo $rowIdx; ?>" 
								value ="<?php echo text($obj{"id"});?>">
						</div>

						<div class=" forms col-xs-3">
							<label for="insurance_provider_<?php echo $rowIdx; ?>" class="h5">Insuance Company/Plan Manager:</label>
							<select name='insurance_provider[]' id="insurance_provider_<?php echo $rowIdx; ?>" 
								class='form-control' required>
							<?php
								$select_provider = "";
								foreach ($providers as $pkey => $row) {
									$id = $row['id'];
									$select_provider .= "    <option value='$id'";
									if ($id == text($obj{"insurance_provider"})) $select_provider .= " selected";
									$select_provider .= ">" . $row['name'] . "\n";
								}
								echo $select_provider;
							?>
							</select>
						</div>
						<div class=" forms col-xs-2">
							<label for="authorization_number_<?php echo $rowIdx; ?>" class="h5"><?php echo xlt('Authorization Nunber: '); ?></label>
							<input cols=80  wrap=virtual name="authorization_number[]" id="authorization_number_<?php echo $rowIdx; ?>"
								value="<?php echo text($obj{"authorization_number"});?>" class='form-control' >
						</div>
						<div class=" forms col-xs-2">
							<label for="service_code_<?php echo $rowIdx; ?>" class="h5"><?php echo xlt('Service Code: '); ?></label>
							<input cols=80  wrap=virtual name="service_code[]" id="service_code_<?php echo $rowIdx; ?>"
								value="<?php echo text($obj{"service_code"});?>" class='form-control' >
						</div>
						<div class=" forms col-xs-2">
							<label for="service_name_<?php echo $rowIdx; ?>" class="h5"><?php echo xlt('Service Name: '); ?></label>
							<input cols=80  wrap=virtual name="service_name[]" id="service_name_<?php echo $rowIdx; ?>"
								value="<?php echo text($obj{"service_name"});?>" class='form-control' >
						</div>
						<div class=" forms col-xs-2">
							<label for="code_type_<?php echo $rowIdx; ?>" class="h5"><?php echo xlt('Code Type: '); ?></label>
							<select name="code_type[]" id="code_type_<?php echo $rowIdx; ?>" class='form-control' >
								<option selected=""><?php echo stripslashes($obj{"code_type"});?></option>
								<option value="HCPCS">HCPCS: Medicaid and MMA's</option>
								<option value="CPT4">CPT4: Medicare and most Commercial</option>
							</select>
						</div>
					</div>
					
					<div class="row">
						<div class=" forms col-xs-1">
							<i class="fa fa-plus-circle fa-2x" 
								aria-hidden="true" 
								onclick="duplicateRow(this.parentElement.parentElement.parentElement);" 
								title='<?php echo xla('Click here to duplicate the row'); ?>'></i>
							<i class="fa fa-times-circle fa-2x text-danger"  
								aria-hidden="true" 
								onclick="deleteRow(this.parentElement.parentElement.parentElement.id);"  
								title='<?php echo xla('Click here to delete the row'); ?>'></i>
						</div>
						<div class=" forms col-xs-1">
							<label for="units_<?php echo $rowIdx; ?>" class="h5"><?php echo xlt('Units/Visits: '); ?></label>
							<input cols=80  wrap=virtual name="units[]" id="units_<?php echo $rowIdx; ?>"
								value ="<?php echo text($obj{"units"});?>" class='form-control' >
						</div>
						<div class=" forms col-xs-2">
							<label for="start_date_<?php echo $rowIdx; ?>" class="h5"><?php echo xlt('Start Date: '); ?></label>
							<input cols=80  wrap=virtual name="start_date[]" id="start_date_<?php echo $rowIdx; ?>"
								value ="<?php echo text($obj{"start_date"});?>" class='form-control datepicker' >
						</div>
						<div class=" forms col-xs-2">
							<label for="end_date_<?php echo $rowIdx; ?>" class="h5"><?php echo xlt('End Date: '); ?></label>
							<input cols=80  wrap=virtual name="end_date[]" id="end_date_<?php echo $rowIdx; ?>"
								value ="<?php echo text($obj{"end_date"});?>" class='form-control datepicker' >
						</div>
						<div class="forms col-xs-1" style="padding-top:35px">
						</div>
						<div class="clearfix"></div>
					</div>
				</div><!-- tb_row -->
				<?php
					} // end loop
				} // end if
				?>

			</fieldset>

			<div class="form-group clearfix">
				<div class="col-sm-12 position-override">
					<div class="btn-group oe-opt-btn-group-pinch" role="group">
						<button type="submit" 
							onclick="top.restoreSession()" 
							class="btn btn-default btn-save"><?php echo xlt('Save'); ?></button>
						<button type="button" 
							class="btn btn-link btn-cancel oe-opt-btn-separate-left" 
							onclick="top.restoreSession(); parent.closeTab(window.name, false);"><?php echo xlt('Cancel');?></button>
						<input type="hidden" id="clickId" value="">
					</div>
				</div>
			</div>
			<!-- <a href="javascript:top.restoreSession();document.my_form.submit();" 
				class="link_submit">[<?php echo xlt('Save'); ?>]</a>
			<a href="< php echo "$rootdir/patient_file/encounter/$returnurl";?>" 
				class="link"
				onclick="top.restoreSession()">[<?php echo xlt('Don\'t Save'); ?>]</a> -->
		</div><!-- end row -->
	</div><!-- end container -->
</form>

</body>
</html>
