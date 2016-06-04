<?php $this->setSCript('//assets.pinterest.com/js/pinit.js'); ?>
<?php $this->assign('itemscope', 'Product'); ?>
<?php $this->assign('og_description', $this->listing->description); ?>
<?php $this->assign('og_image', $this->listing->Images[0]->url_fullxfull); ?>
<?php $this->assign('canonical', '/item/' . Template::itemLink($this->listing->listing_id, $this->listing->title)); ?>
<?php $this->assign('title', $this->listing->title); ?>
<?php include('page_header.tpl.php'); ?>

<div class="container">

	<div class="row mb-4 p-4 bg-light">
		<div class="col">
			<div class="row">
				<div class="col-lg-12">
					<hr />
					<h5 class="text-uppercase text-center" itemprop="name">
						<?php
							$textArray = explode(' ', $this->listing->title);
							$firsthalf = implode(' ', array_slice($textArray, 0, count($textArray) / 2));
							$secondhalf = implode(' ', array_slice($textArray, count($textArray) / 2));
						?>
						<span class="text-muted"><?php echo $firsthalf; ?></span> <?php echo $secondhalf; ?>
					</h5>
					<hr />
				</div>
			</div>

			<div class="row">
				<div class="col-lg-4 mb-2 img-thumbnail">
					<?php if (count($this->listing->Images) > 1) { ?>
					<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<?php $count = 0; foreach ($this->listing->Images AS $key => $image) { $count++ ?>
								<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $count; ?>"<?php if ($count == 1) { ?> class="active"<?php } ?>></li>
							<?php } ?>
						</ol>
						<div class="carousel-inner">
							<?php $count = 0; foreach ($this->listing->Images AS $key => $image) { $count++ ?>
							<div class="carousel-item<?php if ($count == 1) { ?> active<?php } ?>">
								<img class="d-block w-100" src="<?php echo $image->url_570xN; ?>" data-mfp-src="<?php echo $image->url_fullxfull; ?>" alt="<?php echo $this->listing->title; ?>">
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
					<?php } else { ?>
					<img class="img-fluid img-full mfp-zoom" src="<?php echo $this->listing->Images[0]->url_570xN; ?>" data-mfp-src="<?php echo $this->listing->Images[0]->url_fullxfull; ?>" alt="<?php echo $this->listing->title; ?>">
					<?php } ?>
					<meta itemprop="image" content="<?php echo $this->listing->Images[0]->url_570xN; ?>" />
				</div>

				<div class="col-lg-8">

					<hr class="d-block d-md-none" />

					<div class="row">
						<div class="col-md-6 pt-md-3">
							<p class="text-center text-md-left" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
								<?php if ($this->listing->state != 'sold_out') { ?>
									<strong itemprop="price"><?php echo $this->listing->price; ?></strong> <span itemprop="priceCurrency"><?php echo $this->listing->currency_code; ?></span>
									<meta itemprop="availability" content="InStock" />
								<?php } else { ?>
									<strong itemprop="availability" content="OutOfStock">Sold out</strong>
									<meta itemprop="price" content="0" />
									<meta itemprop="priceCurrency" content="<?php echo $this->listing->currency_code; ?>" />
								<?php } ?>
							</p>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-6 mb-2">
									<?php if ($this->listing->state != 'sold_out') { ?>
										<a class="btn btn-warning btn-block" href="<?php echo str_replace('&', '&amp;', $this->listing->url); ?>"><i class="fas fa-shopping-cart"></i> Buy on Etsy</a>
									<?php } ?>
								</div>
								<div class="col-md-6">
									<a class="btn btn-info btn-block" id="back_button" href="<?php echo (!empty($this->back) ? $this->back : '/shop'); ?>">Back to Shop</a>
								</div>
							</div>
						</div>
					</div>

					<hr />

					<div class="text-justify" itemprop="description">
						<?php echo Template::nl2p($this->listing->description); ?>
					</div>

					<hr class="visible-xs visible-sm visible-md" />

					<p>Materials: <?php echo implode(', ', $this->listing->materials); ?></p>

					<span style="vertical-align: middle !important; margin-right: 20px; height: 28px; display: inline-block;"><a data-pin-do="buttonPin" data-pin-tall="true" data-pin-color="red" href="https://www.pinterest.com/pin/create/button/?url=<?php echo rawurlencode('http://stoneriverdesign.com/' . $this->canonical . '?utm_source=pinterest'); ?>&media=<?php echo rawurlencode($this->og_image); ?>&description=<?php echo rawurlencode($this->og_description); ?>"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_red_28.png" alt="Pin" /></a></span>

				</div>

			</div>

		</div>

	</div>

</div>

<?php include('page_footer.tpl.php'); ?>
