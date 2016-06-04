<?php $this->assign('canonical', '/'); ?>
<?php $this->display('page_header.tpl.php'); ?>

<div class="container">

	<div class="row mb-4 p-4 bg-light">
		<div class="col text-center">
			<div class="row mb-4">
				<div class="col-md-10 m-auto">
					<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<?php $count = 0; foreach ($this->shopInfo->About->Images AS $id => $image) { $count++; ?>
								<li data-target="#carousel-slide-<?php echo $id; ?>" data-slide-to="<?php echo $id; ?>"<?php if ($count == 1) { ?> class="active"<?php } ?>></li>
							<?php } ?>
						</ol>
						<div class="carousel-inner">
							<?php $count = 0; foreach ($this->shopInfo->About->Images AS $id => $image) { $count++; ?>
								<div class="carousel-item<?php if ($count == 1) { ?> active<?php } ?>">
									<img class="d-block w-100" src="<?php echo $image->url_760xN; ?>" alt="<?php echo $image->caption; ?>">
								</div>
							<?php } ?>
						</div>
						<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<p class="text-muted">Welcome to</p>
					<h1>Stone River Design</h1>
					<hr />
					<h5 class="text-uppercase"><span class="text-muted">By</span> Linda Holcomb-Bryant</h5>
				</div>
			</div>
		</div>
	</div>

	<div class="row mb-4 p-4 bg-light">
		<div class="col-lg-12">
			<hr />
			<h5 class="text-center text-uppercase"><span class="text-muted">Lampwork glass beads</span> and fused glass</h5>
			<hr />
			<p class="text-center float-none float-md-left">
			<img class="img-responsive img-thumbnail mr-md-4 mb-md-2" src="<?php echo IMAGE_PATH; ?>/intro_pic.jpg" alt="Welcome" />
			</p>
			<hr class="d-md-none">
			<div class="text-justify">
				<?php echo Template::nl2p($this->shopInfo->policy_welcome); ?>
			</div>
		</div>
	</div>

	<div class="row mb-4 p-4 bg-light">
		<div class="col-lg-12">
			<hr />
			<h5 class="text-center text-uppercase"><span class="text-muted">Recent</span> Feedback</h5>
			<hr />
			<div class="row">

				<div class="col">
<?php $count = 1; foreach ($this->feedback AS $key => $feedback) { ?>
					<div class="row">

						<div class="col-md-9">
							<div class="row mb-2">
								<div class="col text-center">
									<p><?php echo date('M d', $feedback->creation_tsz); ?> <strong><?php echo date('Y', $feedback->creation_tsz); ?></strong></p>
									<p><i class="fas fa-<?php if ($feedback->value == 1) { ?>thumbs-up<?php } else if ($feedback->value == 0) { ?>meh<?php } else { ?>thumbs-down<?php } ?> rating"></i></p>
								</div>
							</div>
							<div class="row">
								<div class="col text-justify">
									<?php echo (!empty($feedback->message)) ? Template::nl2p($feedback->message) : '<p>(No message)</p>'; ?>
								</div>
							</div>
						</div>
						<div class="col-md-3 mb-2 text-center">
							<figure class="figure">
								<a href="/item/<?php echo Template::itemLink($feedback->Listing->listing_id, $feedback->Listing->title); ?>">
									<img src="<?php echo $feedback->Listing->Images[0]->url_170x135; ?>" class="figure-img img-fluid rounded" alt="<?php echo $feedback->Listing->title; ?>" />
								</a>
								<figcaption class="figure-caption"><?php echo $feedback->Listing->title; ?></figcaption>
							</figure>
						</div>

					</div>
					<hr />
<?php } ?>
					<p class="text-center"><a class="btn btn-warning btn-lg" href="https://www.etsy.com/shop/StoneRiverDesign/reviews">View on Etsy</a></p>
				</div>

			</div>

		</div>
	</div>

	<?php if (empty($this->shopInfo->is_vacation) && !empty($this->listings)) { ?>
	<div class="row mb-4 p-4 bg-light">
		<div class="col-lg-12">
			<hr />
			<h5 class="text-center text-uppercase"><span class="text-muted">Featured</span> Items</h5>
			<hr />
			<?php $count = 1; foreach ($this->listings AS $key => $listing) { ?>
				<div class="row">
					<div class="col-md-3 mb-2 text-center">
						<a href="/item/<?php echo Template::itemLink($listing->listing_id, $listing->title); ?>">
							<img src="<?php echo $listing->Images[0]->url_170x135; ?>" class="img-fluid" alt="<?php echo $listing->title; ?>" />
						</a>
					</div>
					<div class="col-md-9">
						<div class="row mb-2">
							<div class="col text-center text-md-left">
								<a href="/item/<?php echo Template::itemLink($listing->listing_id, $listing->title); ?>"><?php echo $listing->title; ?></a>
							</div>
						</div>
						<div class="row mb-2">
							<div class="col text-center text-md-left">
								<span class="font-weight-bold"><?php echo $listing->price; ?></span> <?php echo $listing->currency_code; ?>
							</div>
						</div>
						<div class="row">
							<div class="col text-justify">
								<?php echo $listing->description; ?>
							</div>
						</div>
					</div>
				</div>
				<?php if (++$count != count($this->listings) + 1) { ?>
				<hr />
				<?php } ?>
			<?php } ?>
		</div>
	</div>
	<?php } ?>

</div>

<?php $this->display('page_footer.tpl.php'); ?>