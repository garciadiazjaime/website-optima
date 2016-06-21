<h1  class="hidden">Talent</h1>
<div class="container">	
	<!-- FIRST VIEW OF JOBS - STARTS -->
	<div  class="column third first talent_login">
		<?php
		include("talent/login_bar.php");
		?>
		
		<div id="welcome_message_talent">
			<h4>Welcome</h4>
			<div>
				<p>Hello, thank you for visiting our <strong>Talent Search page</strong>.</p> 
				<p>It is our objective, that you get familiar with this page, and optimize this resource to help you better in your career or business objectives.</p>
				
				<hr>
				<a href="#more_of_your_account" title="Learn more about your account" target="_blank" role="button" data-toggle="modal" class="plus_link_left">Learn more about what can you do with your Optima Account.</a>
				
			</div>
		</div>
		<h4 id="tal_testimonial_title"><a href="<?=base_url()?>experiencing_optima/from_our_clients" title="Testimonials from our users">Testimonials from our users</a></h4>
		<hr class="half_width_separator">
		<div class="talent_gradient_box">
			<div class="talent_gr_bx_wrapp">
				<p><a href="<?=base_url()?>experiencing_optima/from_our_clients" title="Testimonials from our users">In Optima they are very professional recruiters. They delivered and outstanding result when I worked with them. Thank you Optima.</a></p>
			</div>
			<span class="talent_gr_bx_decoration"></span>
		</div>
		
	</div><div  class="column two_third no_padding_bottom">
		<h2 class="short">Open Jobs</h2>
		<hr>
		<div id="job_sorter" class="column first nopadbtm">
				<form id="form_talent_search" method="get" action="<?=base_url()?>talent/<?=$num?>/" id="talen_search_form">
				<label>Search</label><input type="search" id="search" name="search" lang="en" class="custom_textbox" />
				<!--
				<label>Sort</label><select>
					<option>Job Title (Ascending)</option>
					<option>Job Title (Descending)</option>
				</select>
				-->
				<input type="submit"  class="custom_submit" value="Submit" />
			</form>
		</div>
		<div id="js_job_list">
			<div class="column two_third first collapse">
				<h2>Job Title</h2>
				<hr class="gray_line">
				<ul class="jobs_list">
					<?php if(sizeof($jobs['job_info']) and is_array($jobs['job_info'])): ?>
					<?php foreach($jobs['job_info'] as $row): ?>						
						<li>
							<a href="<?=base_url()?>talent/job/<?=$row['job_id']?>" title="<?=$row['title']?>">
								<em><?=$row['title']?></em>
								<?=$row['description']?>
							</a>
						</li>
					<?php endforeach; ?>					
					<?php else: ?>
						There is no available information yet
					<?php endif; ?>
				</ul>
			</div><div  class="column third first collapse jobs_location">
				<h2>Job Location</h2>
				<hr class="gray_line">
				<?php if(sizeof($jobs['job_info']) and is_array($jobs['job_info'])): ?>
				<?php foreach($jobs['job_info'] as $row): ?>						
				<p><a href="<?=base_url()?>talent/job/<?=$row['job_id']?>" title="<?=$row['title']?>"><?=ucfirst($row['city'])?>, <?=strtoupper($row['state'])?></a></a></p>
				<?php endforeach; ?>				
				<?php endif; ?>
			</div>
			<hr class="gray_line">
			<ul id="pagination">
				<?=$jobs['pagination']?>
			</ul>			
		</div>
	</div>
</div>