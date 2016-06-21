<div class="container">
	<h1>Recover your password</h1>
	<hr>
	<br/>
	<form method="post" action="#" id="recover_password_form">
		<?php echo form_error('email'); ?>
		<label id="lab_email">Please type your email address</label><input type="email" id="email" name="email" lang="en" class="custom_textbox" maxlength="45"  value="<?=set_value('email'); ?>" />	
		<input type="submit" value="Recover your password" />
	</form>			
	<br>
	<p><span id="msg"><?=$msg?></span></p>
	<br>
	<p>If you don't receive any email please let us know <a href="info@optima-os.com" title="info@optima-os.com">info@optima-os.com</a></p>
</div>
