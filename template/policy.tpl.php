<?php $this->assign('canonical', '/policy'); ?>
<?php $this->assign('title', 'Policy'); ?>
<?php $this->display('page_header.tpl.php'); ?>

<div class="container">

	<div class="row mb-4 p-4 bg-light">
		<div class="col">
			<hr />
			<h5 class="text-uppercase text-center"><span class="text-muted">Payment</span> Policy</h5>
			<hr />
			<?php echo Template::nl2p($this->shopInfo->policy_payment); ?>
		</div>
	</div>

	<div class="row mb-4 p-4 bg-light">
		<div class="col">
			<hr />
			<h5 class="text-uppercase text-center"><span class="text-muted">Shipping</span> Policy</h5>
			<hr />
			<?php echo Template::nl2p($this->shopInfo->policy_shipping); ?>
		</div>
	</div>

	<div class="row mb-4 p-4 bg-light">
		<div class="col">
			<hr />
			<h5 class="text-uppercase text-center"><span class="text-muted">Refunds</span> and Exchanges</h5>
			<hr />
			<?php echo Template::nl2p($this->shopInfo->policy_refunds); ?>
		</div>
	</div>

</div>

<?php $this->display('page_footer.tpl.php'); ?>