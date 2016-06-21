<div class="container">
	<h1>Talent</h1>
	<div  class="column third first">
		<h4 id="user_name_title">User Last Name</h4>
		<hr class="half_width_separator">
		<div class="talent_gradient_box">
			<div class="talent_gr_bx_wrapp">
				<p>In Optima they are very professional recruiters. They delivered and outstanding result when I worked with them. Thank you Optima.</p>
			</div>
			<span class="talent_gr_bx_decoration"></span>
		</div>
	</div><div  class="column two_third">
		<h3>Open Job</h3>
		<hr>
		<a href="<?=base_url()?>talent" title="Go back to Jobs" class="gray_link">Back to jobs</a>
		<br />
		<span><?=$msg?></span>
		<hr class="gray_line">
		<div id="job_description">
			<h1><?=$job->title?></h1>
			<p>
				Location: <?=ucfirst($job->city)?>, <?=strtoupper($job->state)?><br>
				<?php if(!empty($job->salary)): ?>
				Salary: <?=$job->salary?><br>
				<?php endif; ?>
				Posted: <?=$job->date?>
			</p>
			<div class="talent_description">
				<?=str_replace(array("\\n", "'"), array("", ""), $job->description)?>
			</div>
			<hr class="gray_line">
			<a href="<?=base_url()?>talent/apply/<?=$job->joborder_id?>" title="Apply for this job" class="custom_button">Apply to job</a><!--<a href="<?=base_url()?>talent/open_jobs/send_to_friend/permalink123" title="Sed this job to a friend" class="custom_button">Send to friend</a>-->

			<div id="socialMediaIcons">
				<div id="emailShare">
					<span class="icon"></span>
					<a href="mailto:?subject=<?=$job->title?>&amp;body=I came across this job on the Internet and I thought that you or someone you know might be interested. <?=base_url()?>talent/job/<?=$job->joborder_id?>?"><span>Email</span></a>
				</div>
				<div id="linkedinShare">
					<script src="//platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script><script type="IN/Share" data-url="<?=base_url()?>talent/job/<?=$job->joborder_id?>?>"></script>
				</div>
				<div id="twitterShare">
					<iframe scrolling="no" frameborder="0" allowtransparency="true" src="http://platform.twitter.com/widgets/tweet_button.1366232305.html#_=1366263226256&amp;count=none&amp;id=twitter-widget-0&amp;lang=en&amp;original_referer=<?=urlencode(base_url().'talent/job/'.$job->joborder_id)?>&amp;size=m&amp;text=<?=$job->title?>&amp;url=<?=urlencode(base_url().'talent/job/'.$job->joborder_id)?>" class="twitter-share-button twitter-count-none" style="width: 55px; height: 20px;" title="Twitter Tweet Button" data-twttr-rendered="true"></iframe><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</div>
				<div id="facebookShare">
				        <div id="fb-root"></div>
						<script>(function(d, s, id) {
						  var js, fjs = d.getElementsByTagName(s)[0];
						  if (d.getElementById(id)) return;
						  js = d.createElement(s); js.id = id;
						  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
						  fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));</script>
						<div class="fb-like" data-href="<?=base_url()?>talent/job/<?=$job->joborder_id?>?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
						
						<!--<fb:like data-href="<?=base_url()?>talent/job/<?=$job->joborder_id?>?>" send="false" layout="button_count" width="46" show_faces="false" font="segoe ui"></fb:like>-->
				</div>
			</div>

		</div>
	</div>
</div>	