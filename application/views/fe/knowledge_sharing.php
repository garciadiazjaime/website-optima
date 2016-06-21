<div class="container knowledge_sharing">
	<div  class="column third first">
		<div id="welcome_message_knowledge_sh">
			<h4>Welcome</h4>
			<div>
				<p>Hello!, we are creating this section with the sole purpose to connect all our colleagues, friends, clients, etc., to share any need, comments, experience, documents that may help others in their journey to Organizational Excellence.</p> 
				<p>We are using Facebook and Twitter to support this application!, please join us and be part of the great experience to share and learn about all topics related to the services we provide.</p>
				<p class="follow">Follow Us</p><ul id="knowledge_sharing_social"><li class="first"><a href="https://twitter.com/Optima_Org_Sol" title="Follow us on twitter" target="_blank" class="social_button twitter"></a></li><li><a href="#" title="Follow us on facebook" target="_blank" class="social_button facebook"></a></li></ul>

			</div>
			<img src="<?=base_url()?>resources/images/fe/banner_knowledge_sharing.jpg" alt="Sharing the Inspiration that brought us here">
		</div>
	</div><div  class="column two_third no_padding_bottom">
		<h1>Knowledge Sharing</h1>		
		<form id="form_knowledge_sharing" method="get" action="<?=base_url()?>knowledge_sharing">
			<label>Search</label><input type="search" id="search" name="search" lang="en" class="custom_textbox" value="<?=$search?>" />
			<input type="submit"  class="custom_submit" value="Submit" />
		</form>		
		<ul id="knowledge_list">
			<?php if(sizeOf($files) && is_array($files)): ?>
			<?php foreach($files as $item):?>
			<li><div class="document_description"><h2><a href="<?=base_url()?>resources/files/<?=$item->upload_file?>" target="_blank" title="<?=$item->name?>"><?=$item->name?></a></h2>
				<p><?=$item->description?></p>
				<p class="document_date"><?=$item->date?></p>
			</div><div class="document_download">
				<a href="<?=base_url()?>resources/files/<?=$item->upload_file?>" title="<?=$item->name?>" class="pdf_document" target="_blank">Download PDF</a>
			</div>
			</li>
			<?php endforeach; ?>
			<?php else: ?>
			There is no files
			<?php endif; ?>			
		</ul>
		<hr class="gray_line" />
		<!--
		<ul id="pagination">
			<li><a href="#">1</a></li><li><a href="#">2</a></li>
		</ul>
		-->
	</div>
	
</div>
