<?php $this->assign('canonical', '/about'); ?>
<?php $this->assign('title', 'About'); ?>
<?php include('page_header.tpl.php'); ?>

<div class="container">

	<div class="row mb-4 p-4 bg-light">
		<div class="col">
			<hr />
			<h5 class="text-center text-uppercase"><span class="text-muted">About</span> Linda Holcomb-Bryant</h5>
			<hr />
			<p class="text-center float-none float-md-left">
				<img class="img-fluid img-thumbnail mr-md-4 mb-md-2" src="<?php echo IMAGE_PATH; ?>/linda_1.jpg" alt="Linda Holcomb-Bryant" />
			</p>
			<hr class="d-md-none">
			<div class="text-justify">
				<?php echo Template::nl2p($this->shopInfo->About->Members[0]->bio); ?>
				<?php echo Template::nl2p($this->shopInfo->About->story); ?>
			</div>
		</div>
	</div>

	<div class="row mb-4 p-4 bg-light">
		<div class="col">
			<div class="row">
				<div class="col-12">
					<hr />
					<h5 class="text-uppercase text-center"><span class="text-muted">At</span> Play</h5>
					<hr />
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 text-center">
					<img class="img-fluid" src="<?php echo IMAGE_PATH; ?>/flameworking_1.jpg" alt="">
					<hr class="d-md-none">
				</div>
				<div class="col-md-6 text-center">
					<img class="img-fluid" src="<?php echo IMAGE_PATH; ?>/isa_760xN.20315585230_50s5.jpg" alt="">
					<hr class="d-md-none">
				</div>
				<div class="col-md-3 text-center">
					<img class="img-fluid" src="<?php echo IMAGE_PATH; ?>/flameworking_2.jpg" alt="">
				</div>
			</div>
		</div>
	</div>

</div>

<?php include('page_footer.tpl.php'); ?>
