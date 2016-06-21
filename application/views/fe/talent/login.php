<!-- INICIA LOGIN  - Muestra    -->
<div class="container login">

	<div class="column  third first">
		<h2>REGISTER</h2>
		<p><strong>Don't have an account with Optima?</strong></br>
			<a class="green" href="<?=base_url()?>talent/register">Register for free</a>
		</p>
		<p>With an Optima account you can:</p>
		<ul>
			<li>Apply to our job offers</li>
			<li>Get the latest updates and news</li>
			<li>Access online features and services</li>
		</ul>
		<a href="#more_of_your_account" title="Learn more about your account" target="_blank" role="button" data-toggle="modal" class="plus_link_left">Learn more about what can you do with your Optima Account.</a>
		<a href="<?=base_url()?>talent/register" class="purple_button short_pb"><span>Register</span></a>
	</div>
	<div class="column two_third">
		<h1>LOGIN</h1>
		<p><strong>Already have an account with Optima</strong><br />
			Apply by logging in to your account below </p>

		<p>Login to update your personal information, check which jobs you had applied to, as well as email the job's contact person.</p>
		<br />
		<form method="post" action="#" id="login_form">
			<?php echo form_error('email'); ?>
			<label id="lab_email">Email</label><input type="email" id="email" name="email" lang="en" class="custom_textbox" maxlength="45"  value="<?=set_value('email'); ?>" />	

			<?php echo form_error('password'); ?>
			<label id="lab_password">Password</label><input type="password" id="password" name="password" lang="en" class="custom_textbox" maxlength="45" value="<?=set_value('password'); ?>"/>	
			<a href="<?=base_url()?>forgot_password" title="Forgot Your Password?" id="forgot_password">Forgot Your Password?</a><input type="submit"  class="custom_submit" value="Submit" />
		</form><br />
		<span id="msg"><?=$msg?></span>
	</div>
</div>

<!-- TERMINA LOGIN  - Muestra    -->