<div class="container admin_panel">
	<div id="admin_utils">
		<a href="<?=base_url()?>admin/logout" title="log out" class="first">log out</a><a href="<?=base_url()?>admin/add_file" title="add file">Add file</a>
	</div>
	<div id="admin_msg"><p><?=$msg?></p></div>
	<h1>Panel</h1>
	<br /><br />
	<?php if(sizeof($files) and is_array($files)): ?>
		<table>
			<th id="t_name">Name</th>
			<th id="t_description">Description</th>
			<th id="t_date">Date</th>
			<th id="t_view">View</th>
			<th id="t_delete">Delete</th>
		<?php foreach($files as $row): ?>
			<tr class="<?=alternator('odd', 'even');?>">
				<td class="table_name"><?=$row->name?></td>
				<td class="table_description"><?=$row->description?></td>
				<td><?=$row->date?></td>
				<td class="table_file"><a href="<?=base_url()?>resources/files/<?=$row->upload_file?>" title="<?=$row->name?>" target="_blank">file</a></td>
				<td class="doc_delete"><a href="<?=base_url()?>admin/remove_file/<?=$row->id?>" title="<?=$row->name?>">Remove file</a></td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php else: ?>
		There no files
	<?php endif; ?>
</div>