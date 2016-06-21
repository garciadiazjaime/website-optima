<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
		<?php $this->load->view('fe/layout/head');?>
	</head>
	<body>
		<div id="wrapper" class="<? echo($location); ?>">
			<?php $this->load->view('fe/layout/header', array('menu'=>$menu, $location)); ?>
			<div id="content">
				<?=$content?>
			</div>
			
			<?php $this->load->view('fe/layout/footer', array('menu'=>$menu)); ?>

		</div>
		<?php if($location=="talent"){ ?>
			<!-- Modal -->
			<?php
				require_once('modal_talent.php');
			?>
			
		<?php } ?>
	</body>
</html>
