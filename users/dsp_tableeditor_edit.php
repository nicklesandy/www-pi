
<?php

echo '<h1>';
if($id > 0)
{
	echo 'Edit entry for ';
}
else 
{
	echo 'Create new ';
}
echo $tableeditor['tablename'];
if($id > 0)
{
	echo '';
}
else 
{
	echo ' entry';
}
echo '</h1>';

?>



<form id="frm-edit" class="form-horizontal" method="post" action="index.php?action=<?= $action->getCode() ?>&amp;mode=save&amp;id=<?= $id ?>">
	<input type="hidden" name="action" value="<?= $action->getCode() ?>"/>
	<input type="hidden" name="mode" value="save"/>
	<input type="hidden" name="id" value="<?= $id ?>"/>
	
	<?php
	mysql_data_seek($qry_tableeditor_fields, 0);
	while($tableeditor_field = mysql_fetch_array($qry_tableeditor_fields))
	{
		switch($tableeditor_field['fieldtype'])
		{
			case 'bool':
			case 'boolean':
			case 'bit':
			case 'checkbox':
			case 'check':
				?>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="tef_<?= $tableeditor_field['fieldname'] ?>"><?= $tableeditor_field['fieldname'] ?></label>
						<div class="col-sm-3">
							<input id="tef_<?= $tableeditor_field['fieldname'] ?>" name="tef_<?= $tableeditor_field['fieldname'] ?>" type="checkbox" 
								<?php if($tableentry[$tableeditor_field['fieldname']] == 1) { ?>checked<?php } ?>>
						</div>
						<?php
							/*if($tableeditor_field['tooltip'] != ''){
								echo '<p class="help-block col-sm-11 col-sm-offset-1">' . $tableeditor_field['tooltip'] . '</p>';
							}*/
						?>
					</div>
				<?php
				break;
				
			default:
				?>
				
				<div class="form-group">
					<label class="col-sm-3 control-label" for="tef_<?= $tableeditor_field['fieldname'] ?>"><?= $tableeditor_field['fieldname'] ?></label>
					<?php
						if($tableeditor_field['fieldtype'] == 'int' || $tableeditor_field['fieldtype'] == 'integer'){
							$colsize = 3;
						}
						else {
							$colsize = 9;
						}
					?>
					<div class="col-sm-<?= $colsize ?>">
						<input id="tef_<?= $tableeditor_field['fieldname'] ?>" name="tef_<?= $tableeditor_field['fieldname'] ?>" type="text" class="form-control" 
							value="<?= $tableentry[$tableeditor_field['fieldname']] ?>">
					</div>
					<?php
						/*if($tableeditor_field['tooltip'] != ''){
							echo '<p class="help-block col-sm-11 col-sm-offset-1">' . $tableeditor_field['tooltip'] . '</p>';
						}*/
					?>
				</div>
				<?php
		}
	}
	?>
	
	
	<div class="form-group">
		<!--label class="control-label" for="singlebutton">Save</label-->
		<button id="singlebutton" name="singlebutton" class="btn btn-primary" type="submit" value="Save">Save</button>
	</div>

	
	<div class="form-group">
	<?php
	/*if($error == 1){
		echo '<div class="alert alert-danger">Some required fields are incorrect</div>';
	}*/
	?>
	</div>
	
	
</form>
