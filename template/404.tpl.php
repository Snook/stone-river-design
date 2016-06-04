<?php $this->assign('title', '404 Not Found'); ?>
<?php $this->assign('canonical', '/404'); ?>
<?php $this->display('page_header.tpl.php'); ?>

	<div class="container">
		<div class="row mb-4 p-4 bg-light">
			<div class="col-lg-12 text-center mt-3">
				<h1><i class="fas fa-exclamation-triangle text-warning"></i> File not found</h1>
			</div>
		</div>
	</div>

<?php $this->display('page_footer.tpl.php'); ?>