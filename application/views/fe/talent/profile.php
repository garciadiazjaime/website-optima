<div class="container">
	<?php require_once "user_utils_bar.php"; ?>
	<h1>Your account</h1>
	<hr>
	<br>
	<h3 class="gray_title">Your Account</h3>
	<span id="msg"><?=$msg?></span>
	<?=validation_errors();?>
	<form method="post" action="#" id="apply_job_form" enctype="multipart/form-data">
		<?php echo form_error('email'); ?>
		<div  class="column third first collapse">
			<label>Email:*</label>
		</div><div class="column two_third">
			<input type="email" id="email" name="email" lang="en" class="custom_textbox" maxlength="45" value="<?=$data->email?>"/>	
		</div>
		<?php echo form_error('password'); ?>
		<div  class="column third first collapse">
			<label>Password:* </label>
		</div><div  class="column two_third">
			<input type="password" id="password" name="password" lang="en" class="custom_textbox" maxlength="45" value="<?=$data->password?>"/>	
		</div>
		<?php echo form_error('passconf'); ?>
		<div  class="column third first collapse">
			<label>Repeat:* </label>
		</div><div  class="column two_third">
			<input type="password" id="passconf" name="passconf" lang="en" class="custom_textbox" maxlength="45" value="<?=$data->passconf?>"/>	
		</div>
		<p><strong>General  *</strong> - indicates a required field</p>
		<br>
		<br>
		<?php echo form_error('upload_file'); ?>
		<div  class="column third first collapse">
			<label>Upload Resume:*</label>
		</div><div  class="column two_third uppload_file_area">
			<input type="hidden" name="upload_file" value="<?=$data->upload_file?>"/>
			<input type="file" id="upload_file_route" name="upload_file_route" maxlength="140" class="upload_file_button"/><p class="upload_file_status" id="lab_upload_file"><?=$error_msg?></p>
			<br />Current Resume: <a href="<?php echo base_url().'resources/cv/'.$data->upload_file?>" target="_blank"><?=$data->upload_file?></a>
		</div>
		<?php echo form_error('first_name'); ?>
		<div  class="column third first collapse">
			<label>First Name:*</label>
		</div><div  class="column two_third">
			<input type="text" id="first_name" name="first_name" lang="en" class="custom_textbox" maxlength="45" value="<?=$data->first_name?>"/>
		</div>
		<?php echo form_error('last_name'); ?>
		<div  class="column third first collapse">
			<label>Last Name:*</label>
		</div><div  class="column two_third">
			<input type="text" id="last_name" name="last_name" lang="en" class="custom_textbox" maxlength="45" value="<?=$data->last_name?>"/>
		</div>
		<?php echo form_error('title'); ?>
		<div  class="column third first collapse">
			<label>Title:*</label>
		</div><div  class="column two_third">
			<input type="text" id="title" name="title" lang="en" class="custom_textbox" maxlength="45" value="<?=$data->title?>"/>
		</div>
		<?php echo form_error('phone'); ?>
		<div  class="column third first collapse">
			<label>Primary Phone:*</label>
		</div><div  class="column two_third">
			<input type="tel" id="phone" name="phone" lang="en" class="custom_textbox" maxlength="20" value="<?=$data->phone?>"/>
		</div>
		<?php echo form_error('address'); ?>
		<div  class="column third first collapse">
			<label>Address:*</label>
		</div><div  class="column two_third">
			<textarea id="address" name="address" lang="en" class="custom_textarea" maxlength="140"><?=$data->address?></textarea>
		</div>
		<?php echo form_error('city'); ?>
		<div  class="column third first collapse">
			<label>City:*</label>
		</div><div  class="column two_third">
			<input type="text" id="city" name="city" lang="en" class="custom_textbox" maxlength="45" value="<?=$data->city?>"/>
		</div>
		<?php echo form_error('state'); ?>
		<div  class="column third first collapse">
			<label>State:*</label>
		</div><div  class="column two_third">
			<input type="text" id="state" name="state" lang="en" class="custom_textbox" maxlength="45" value="<?=$data->state?>"/>
		</div>
		<?php echo form_error('zip_code'); ?>
		<div  class="column third first collapse">
			<label>Zip Code:*</label>
		</div><div  class="column two_third">
			<input type="text" id="zip_code" name="zip_code" lang="en" class="custom_textbox" maxlength="10" value="<?=$data->zip_code?>"/>
		</div>
		<?php echo form_error('date_available'); ?>
		<div  class="column third first collapse">
			<label>Date Available: (DD-MM-YYYY)*</label>
		</div><div  class="column two_third">
			<input type="date" id="date_available" name="date_available" lang="en" class="custom_textbox" maxlength="10" value="<?=$data->date_available?>"/>
		</div>
		<div  class="column third first collapse">
			<label>Current Employer:</label>
		</div><div  class="column two_third">
			<input type="text" id="current_employer" name="current_employer" lang="en" class="custom_textbox" maxlength="45" value="<?=$data->current_employer?>"/>
		</div>
		<div  class="column third first collapse">
			<label>Current Title:</label>
		</div><div  class="column two_third">
			<input type="text" id="current_title" name="current_title" lang="en" class="custom_textbox" maxlength="45" value="<?=$data->current_title?>"/>
		</div>
		<div  class="column third first collapse">
			<label>Key Skills:</label>
		</div><div  class="column two_third">
			<textarea id="skills" name="skills" lang="en" class="custom_textarea" maxlength="250"><?php echo $data->skills?></textarea>
		</div>
		<div  class="column third first collapse">
			<label>Key Technologies:</label>
		</div><div  class="column two_third">
			<input type="text" id="technologies" name="technologies" lang="en" class="custom_textbox" maxlength="140" value="<?=$data->technologies?>"/>
		</div>
		<div  class="column third first collapse">
			<label>Alt Phone:</label>
		</div><div  class="column two_third">
			<input type="tel" id="alt_phone" name="alt_phone" lang="en" class="custom_textbox" maxlength="20" value="<?=$data->alt_phone?>"/>
		</div>
		<div  class="column third first collapse">
			<label>Current Rate of Pay:</label>
		</div><div  class="column two_third">
			<input type="number" id="current_pay" name="current_pay" lang="en" class="custom_textbox" maxlength="20" value="<?=$data->current_pay?>"/>
		</div>
		<div  class="column third first collapse">
			<label>Desired Rate of Pay:</label>
		</div><div  class="column two_third">
			<input type="number" id="desire_pay" name="desire_pay" lang="en" class="custom_textbox" maxlength="20" value="<?=$data->desire_pay?>"/>
		</div>
		<div  class="column third first collapse">
			<label>Additional Information:</label>
		</div><div  class="column two_third">
			<textarea id="more_info" name="more_info" lang="en" class="custom_textarea" maxlength="250"><?=$data->more_info?></textarea>
		</div>
		<div  class="column third first collapse"></div><div  class="column two_third">
			<p id="terms_warning">By submitting this form you accept our
			<a href="<?=base_url()?>terms_conditions" title="Read our Terms and Conditions" target="_blank">Terms and Conditions</a></p><input type="submit"  class="custom_submit" value="Submit" />
		</div>
		<input type="hidden" name="terms" value="1" />
	</form><br /><br /><br />
</div>