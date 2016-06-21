<div class="container admin_panel">
	<div id="admin_utils">
		<a href="<?=base_url()?>admin/logout" title="log out" class="first">log out</a><a href="<?=base_url()?>admin" title="Cacel">Cancel</a>
	</div>
	<div id="admin_msg"><p><?=$msg?></p></div>
	<div id="error_msg"><p><?=validation_errors();?></p></div>
	<h1>Add file</h1>
	<br>
	<form method="post" action="#" id="apply_job_form" enctype="multipart/form-data">
		<?php echo form_error('name'); ?>
		<div  class="column third first collapse">
			<label>Name:*</label>
		</div><div class="column two_third">
			<input type="text" id="name" name="name" lang="en" class="custom_textbox" maxlength="45" value="<?=set_value('name'); ?>"/>	
		</div>
		<?php echo form_error('description'); ?>
		<div  class="column third first collapse">
			<label>Description:* </label>
		</div><div  class="column two_third">
			<textarea id="description" name="description" lang="en" class="custom_textbox" maxlength="200"><?=set_value('description'); ?></textarea>
		</div>
		<?php echo form_error('upload_file'); ?>
		<div  class="column third first collapse">
			<label>Upload file:*</label>
		</div><div  class="column two_third uppload_file_area">
			<input type="hidden" name="upload_file" id="upload_file" value="<?=set_value('upload_file');?>" />
			<input type="file" id="upload_file_route" name="upload_file_route" maxlength="140" class="upload_file_button"/><!--<p class="upload_file_status">No file chosen</p>-->
			<br/>Allowed extensions: .jpg, .png, .doc, .docx, .pdf
			<br/>Max size: 2MB
		</div>
		<div  class="column third first collapse">
		</div><div  class="column two_third">
			<input type="submit"  class="custom_submit" value="Submit" />
		</div>
	</form>
</div>
