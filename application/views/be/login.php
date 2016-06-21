<!-- INICIA LOGIN  - Muestra    -->
<div class="container login">

	<div class="column  third first">
	</div>
	<div class="column two_third">
		<h1>LOGIN</h1>
		<br />	
		<form method="post" action="#" id="login_form">
			<?php echo form_error('email'); ?>
			<label id="lab_email">Email</label><input type="email" id="email" name="email" lang="en" class="custom_textbox" maxlength="45"  value="<?=set_value('email'); ?>" />	

			<?php echo form_error('password'); ?>
			<label id="lab_password">Password</label><input type="password" id="password" name="password" lang="en" class="custom_textbox" maxlength="45" value="<?=set_value('password'); ?>"/>

			<input type="submit" value="log in"  class="custom_submit" />
		</form>
		<br /><br /><br /><br />
		<div id="msg"><?=$msg?></div>
	</div>
</div>

<!-- TERMINA LOGIN  - Muestra    -->