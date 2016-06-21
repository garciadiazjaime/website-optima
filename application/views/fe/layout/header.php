<div id="header">
	<div id="header_wrapp">
		<div class="container">
			<ul id="social"><li class="first"><a href="http://www.facebook.com/OptimaOS?fref=ts" title="Find us on Facebook" class="social_button facebook" target="_blank"></a></li><li><a href="https://twitter.com/Optima_Org_Sol" title="Find us on Twitter" class="social_button twitter" target="_blank"></a></li></ul><p id="slogan"><a href="<?=base_url()?>knowledge_sharing" title="Knowledge sharing">Knowledge sharing</a></p><p id="my_account_link"><a href="<?=base_url()?>talent/my_account" title="My account">My account</a></p>			
		    <?=$menu?>			
			<a href="<?=base_url()?>" title="Return to Home"><img src="<?=base_url()?>resources/images/logo_optima.png" alt="Optima"></a>
		</div>
	</div>
</div>	
<?php if ($location == 'home'):?> 
	<div id="hidden_header">
		<div id="hidden_header_wrapp">
			<div class="container">
				<ul id="hidden_social"><li class="first"><a href="http://www.facebook.com/OptimaOS?fref=ts" title="Find us on Facebook" class="social_button facebook" target="_blank"></a></li><li><a href="#" title="Find us on Twitter" class="social_button twitter"></a></li></ul><p id="slogan"><a href="<?=base_url()?>knowledge_sharing" title="Knowledge sharing">Knowledge sharing</a></p><p id="my_account_link"><a href="<?=base_url()?>talent/my_account" title="My account">My account</a></p>
				<?=$menu?>			
				<a href="<?=base_url()?>" title="Return to Home"><img src="<?=base_url()?>resources/images/logo_optima.png" alt="Optima"></a>
			</div>
		</div>
	</div>
<?php endif; ?>	
