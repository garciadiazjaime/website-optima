<div class="container">
	<h1>Recover your password</h1>
	<hr>
	<br/>
	<div class="column two_third first">
		<form method="post" action="#" id="recover_password_form">
			<?php echo form_error('email'); ?>
			<label id="lab_email">Please type your email address</label><input type="email" id="email" name="email" lang="en" class="custom_textbox" maxlength="45"  value="<?=set_value('email'); ?>" />	
			<input type="submit" value="Recover your password" class="custom_submit"  />
		</form>			
		<br>
		<p><span id="msg"><?=$msg?></span></p>
		<br>
		<p>If you don’t get any e-mail, please report it to: <a href="mailto:info@optima-os.com" title="info@optima-os.com">info@optima-os.com</a></p>
	</div>
</div>
