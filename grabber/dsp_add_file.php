
<h1>Add a download</h1>

<?php
	if($added == 1) echo '<div class="alert alert-success" role="alert"><strong>Success!</strong> New download link added</div>';
	if($added == 0) echo '<div class="alert alert-danger" role="alert"><strong>Error</strong> Your link could not be added</div>';
?>

<form id="frm-addfile" class="form-horizontal" method="post" action="index.php?action=do_add_file&amp;id_grab=<?=$id_grab?>">
	<input type="hidden" name="action" value="do_add_file"/>
	<input type="hidden" name="id_grab" value="<?=$id_grab?>"/>
	
		<?php
		/*
			$grab_max_grabbers = 'null';
			$grab_excluded = '';
			$grab_excluded_size = -1;
			$grab_always_retry = 0;
			$grab_script_completion = '';
			$grab_remove_completed_after_days = -1;
			$grab_remove_inactive_after_months = -1;
			$grab_keep_diskspace_free = 0;
			$grab_scheduled = 0;
		*/
		?>

		<div class="form-group">
			<label for="grab_type">Type</label>
			<select id="grab_type" name="grab_type" class="form-control">
				<option value="">Default (grabber)</option>
				<option value="youtube-dl">Youtube downloader (youtube-dl)</option>
			</select>
		</div>
		
		<div class="form-group">
			<label for="grab_url">URL</label>
			<input id="grab_url" name="grab_url" placeholder="" class="form-control" type="text" value="">
		</div>
		
		<div class="form-group">
			<label for="grab_referer">(Optional) Referer</label>
			<input id="grab_referer" name="grab_referer" placeholder="" class="form-control" type="text" value="">
		</div>
		
		<div class="form-group">
			<label for="grab_path">Path</label>
			<input id="grab_path" name="grab_path" placeholder="" class="form-control" type="text" value="<?=$grab_path?>">
		</div>
		
		<div class="form-group">
			<label for="grab_filename">Filename <i class="fa fa-spinner fa-spin hidden"></i></label>
			<input id="grab_filename" name="grab_filename" placeholder="" class="form-control" type="text" value="">
		</div>
		
		<div class="alert alert-warning alert-file-exists hidden" role="alert">This file already exists! Please enter a different filename.</div>
		
		
		<div class="form-group">
			<!--label class="control-label" for="singlebutton">Save</label-->
			<button id="singlebutton" name="singlebutton" class="btn btn-primary" type="submit" value="Save">Add</button>
		</div>


		
		<div class="form-group">
		<?php
		if($error == 1){
			echo '<div class="alert alert-danger">Some required fields are incorrect</div>';
		}
		?>
		</div>
		
	
	
</form>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>