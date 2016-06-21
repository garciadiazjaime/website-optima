<div class="container">
	<h1>Create account</h1>
	<hr>
	<?=validation_errors();?>
	<br>
	<div class="column two_third first">
		<h3 class="gray_title">Create Account</h3>
		<form method="post" action="#" id="apply_job_form" enctype="multipart/form-data">
			<?php echo form_error('email'); ?>
			<div  class="column third first collapse">
				<label id="lab_email">Email:*</label>
			</div><div class="column two_third">
				<input type="email" id="email" name="email" lang="en" class="custom_textbox" maxlength="45" value="<?=set_value('email'); ?>"/>	
			</div>
			<?php echo form_error('password'); ?>
			<div  class="column third first collapse">
				<label id="lab_password">Password:* </label>
			</div><div  class="column two_third">
				<input type="password" id="password" name="password" lang="en" class="custom_textbox" maxlength="45" value="<?=set_value('password'); ?>"/>	
			</div>
			<?php echo form_error('passconf'); ?>
			<div  class="column third first collapse">
				<label id="lab_passconf">Repeat:* </label>
			</div><div  class="column two_third">
				<input type="password" id="passconf" name="passconf" lang="en" class="custom_textbox" maxlength="45" value="<?=set_value('passconf'); ?>"/>	
			</div>
			<p><strong>General  *</strong> - indicates a required field</p>
			<br>
			<br>
			<?php echo form_error('upload_file'); ?>
			<div  class="column third first collapse">
				<label>Upload Resume:*</label>
			</div><div  class="column two_third uppload_file_area">
				<input type="hidden" name="upload_file" id="upload_file" value="<?=set_value('upload_file');?>" />
				<input type="file" id="upload_file_route" name="upload_file_route" maxlength="140" class="upload_file_button"/><!--<p class="upload_file_status">No file chosen</p>-->
				<br/>Allowed extensions: .jpg, .png, .doc, .docx, .pdf
				<br/>Max size: 2MB
			</div>
			<?php echo form_error('first_name'); ?>
			<div  class="column third first collapse">
				<label id="lab_first_name">First Name:*</label>
			</div><div  class="column two_third">
				<input type="text" id="first_name" name="first_name" lang="en" class="custom_textbox" maxlength="45" value="<?=set_value('first_name'); ?>"/>
			</div>
			<?php echo form_error('last_name'); ?>
			<div  class="column third first collapse">
				<label id="lab_last_name">Last Name:*</label>
			</div><div  class="column two_third">
				<input type="text" id="last_name" name="last_name" lang="en" class="custom_textbox" maxlength="45" value="<?=set_value('last_name'); ?>"/>
			</div>
			<?php echo form_error('title'); ?>
			<div  class="column third first collapse">
				<label id="lab_title">Title:*</label>
			</div><div  class="column two_third">
				<input type="text" id="title" name="title" lang="en" class="custom_textbox" maxlength="45" value="<?=set_value('title'); ?>"/>
			</div>
			<?php echo form_error('phone'); ?>
			<div  class="column third first collapse">
				<label id="lab_phone">Primary Phone:*</label>
			</div><div  class="column two_third">
				<input type="tel" id="phone" name="phone" lang="en" class="custom_textbox" maxlength="20" value="<?=set_value('phone'); ?>"/>
			</div>
			<?php echo form_error('address'); ?>
			<div  class="column third first collapse">
				<label id="lab_address">Address:*</label>
			</div><div  class="column two_third">
				<textarea id="address" name="address" lang="en" class="custom_textarea" maxlength="140"><?=set_value('address'); ?></textarea>
			</div>
			<?php echo form_error('city'); ?>
			<div  class="column third first collapse">
				<label id="lab_city">City:*</label>
			</div><div  class="column two_third">
				<input type="text" id="city" name="city" lang="en" class="custom_textbox" maxlength="45" value="<?=set_value('city'); ?>"/>
			</div>
			<?php echo form_error('state'); ?>
			<div  class="column third first collapse">
				<label id="lab_state">State:*</label>
			</div><div  class="column two_third">
				<input type="text" id="state" name="state" lang="en" class="custom_textbox" maxlength="45" value="<?=set_value('state'); ?>"/>
			</div>
			<?php echo form_error('zip_code'); ?>
			<div  class="column third first collapse">
				<label id="lab_zip_code">Zip Code:*</label>
			</div><div  class="column two_third">
				<input type="text" id="zip_code" name="zip_code" lang="en" class="custom_textbox" maxlength="10" value="<?=set_value('zip_code'); ?>"/>
			</div>
			<?php echo form_error('date_available'); ?>
			<div  class="column third first collapse">
				<label id="lab_date_available">Date Available:* (DD-MM-YYYY)</label>
			</div><div  class="column two_third">
				<input type="date" id="date_available" name="date_available" lang="en" class="custom_textbox" maxlength="10" value="<?=set_value('date_available'); ?>"/>
			</div>
			<div  class="column third first collapse">
				<label id="lab_current_employer">Current Employer:</label>
			</div><div  class="column two_third">
				<input type="text" id="current_employer" name="current_employer" class="custom_textbox" maxlength="45" value="<?=set_value('current_employer'); ?>"/>
			</div>
			<div  class="column third first collapse">
				<label id="lab_current_title">Current Title:</label>
			</div><div  class="column two_third">
				<input type="text" id="current_title" name="current_title" class="custom_textbox" maxlength="45" value="<?=set_value('current_title'); ?>"/>
			</div>
			<div  class="column third first collapse">
				<label id="lab_skills">Key Skills:</label>
			</div><div  class="column two_third">
				<textarea id="skills" name="skills" class="custom_textarea" maxlength="250"><?php echo set_value('skills'); ?></textarea>
			</div>
			<div  class="column third first collapse">
				<label id="lab_technologies">Key Technologies:</label>
			</div><div  class="column two_third">
				<input type="text" id="technologies" name="technologies" class="custom_textbox" maxlength="140" value="<?=set_value('technologies'); ?>"/>
			</div>
			<div  class="column third first collapse">
				<label id="lab_alt_phone">Alt Phone:</label>
			</div><div  class="column two_third">
				<input type="tel" id="alt_phone" name="alt_phone" class="custom_textbox" maxlength="20" value="<?=set_value('alt_phone'); ?>"/>
			</div>
			<div  class="column third first collapse">
				<label id="lab_current_pay">Current Rate of Pay:</label>
			</div><div  class="column two_third">
				<input type="number" id="current_pay" name="current_pay" class="custom_textbox" maxlength="20" value="<?=set_value('current_pay'); ?>"/>
			</div>
			<div  class="column third first collapse">
				<label id="lab_desire_pay">Desired Rate of Pay:</label>
			</div><div  class="column two_third">
				<input type="number" id="desire_pay" name="desire_pay" class="custom_textbox" maxlength="20" value="<?=set_value('desire_pay'); ?>"/>
			</div>
			<div  class="column third first collapse">
				<label id="lab_more_info">Additional Information:</label>
			</div><div  class="column two_third">
				<textarea id="more_info" name="more_info" class="custom_textarea" maxlength="250"><?php echo set_value('more_info'); ?></textarea>
			</div>
			<div  class="column third first collapse">
			</div><div  class="column two_third">
				<?php echo form_error('terms'); ?>
				<input type="checkbox" name="terms" id="terms" value="1"><p id="terms_warning">I accept the
				<a href="#terms_conditions" title="Read our Terms and Conditions" target="_blank" role="button" data-toggle="modal">Terms and Conditions</a></p>
				<!--<p id="terms_warning">By submitting this form you accept our
				<a href="<?=base_url()?>terms_conditions" title="Read our Terms and Conditions" target="_blank">Terms and Conditions</a></p>--><input type="submit"  class="custom_submit" value="Submit" />
			</div>
		</form><br /><br /><br />
		<div id="msg"><?=$msg?></div>
	</div><div class="column third second">
		<h3>Thanks for accessing to our talent page.</h3>
		<hr class="half_width_separator" />
		<p>Please complete your registration to create your account and enjoy the benefits of using this powerful tool!!</p>
		<p>In the Registration process, please ensure to review the Privacy Awareness document, which is for either clients or users.</p>
	</div>
	
	
	
</div>
