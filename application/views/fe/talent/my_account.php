<div class="container">
	<?php require_once("user_utils_bar.php");?>
	<h1>Your Application</h1>
	<hr>
	<p>Recent Applications with  <a href="<?=base_url()?>" title="optima" class="normal_weight">www.optima-os.com</a></p>
	
	<div id="applications_table">
		<div id="app_header">
			<p class="col_applied">Applied</p><p class="col_job">Job</p>
		</div>
		<p>You are logged in as  <a href="<?=base_url()?>profile" title="View your Profile" ><?=$user_name?></a>. You have applied to  <?php if($applications == 0 ) echo '0 jobs'; elseif(sizeof($applications) == 1) echo "1 job"; else echo sizeof($applications)." jobs";?></p>
		<table>
			<?php if(is_array($applications)): ?>
			<?php foreach($applications as $row): ?>
			<tr><td class="col_applied"><?=$row->updated?></td><td class="col_job"><?=$row->title?></td><td class="col_send"><!--<a href="<?=base_url()?>send_note" title="Send Note">Send Note</a>/<a href="<?=base_url()?>send_question" title="Send Question">Question</a>--></td></tr>
			<?php endforeach; ?>
			<?php endif; ?>
		</table>
		<p>Moved or changed your contact information?  <a href="<?=base_url()?>profile" title="Update your profile" class="green_link">Update your profile</a></p>
	</div>
	
	<br><br>
</div>