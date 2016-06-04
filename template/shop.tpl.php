<?php $this->assign('title', 'Etsy Shop' . ((!empty($this->page_title_section)) ? ' - ' . $this->page_title_section : '') . ((!empty($this->pagination->effective_page) && $this->pagination->effective_page > 1) ? ' - Page ' . $this->pagination->effective_page : '') ); ?>
<?php $this->assign('canonical', '/shop' . (!empty($this->req_shop_section_id) ? '/' . Template::sectionLink($this->req_shop_section_id, $this->page_title_section, $this->pagination->effective_page) : '')); ?>
<?php include('page_header.tpl.php'); ?>

<div class="container">

	<div class="row mb-4 p-4 bg-light">
		<div class="col">
			<div class="row">
				<div class="col">
					<hr />
					<h5 class="text-uppercase text-center"><span class="text-muted">Etsy</span> Shop</h5>
					<hr />
				</div>
			</div>

			<div class="row">

				<div class="d-none d-md-block col-md-4 col-lg-3">
					<div class="list-group">
						<a class="list-group-item d-flex justify-content-between align-items-center<?php if (empty($this->req_shop_section_id)) { ?> active<?php } ?>" href="/shop">
							Shop Home <span class="badge badge-primary badge-pill"><?php echo $this->listing_active_count; ?> items</span>
						</a>
						<?php foreach ($this->sections AS $key => $section) { ?>
						<a class="list-group-item d-flex justify-content-between align-items-center<?php if (!empty($this->req_shop_section_id) && $section->shop_section_id == $this->req_shop_section_id) { ?> active<?php } ?>" href="/shop/<?php echo Template::sectionLink($section->shop_section_id, $section->title); ?>">
							<?php echo $section->title; ?> <span class="badge badge-primary badge-pill"><?php echo $section->active_listing_count; ?></span>
						</a>
						<?php } ?>
					</div>

					<div class="text-center mt-4">
						<a class="btn btn-warning btn-lg" href="https://www.etsy.com/shop/StoneRiverDesign<?php if (!empty($this->req_shop_section_id)) {?>?section_id=<?php echo $this->req_shop_section_id; ?><?php } ?>">View on Etsy</a>
					</div>
				</div>

				<div class="d-md-none col mb-4">
					<select id="section_select" class="form-control">
						<option value="/shop">
							Shop Home (<?php echo $this->listing_active_count; ?> items)
						</option>
						<?php foreach ($this->sections AS $key => $section) { ?>
						<option value="/shop/<?php echo Template::sectionLink($section->shop_section_id, $section->title); ?>"<?php if (!empty($this->req_shop_section_id) && $section->shop_section_id == $this->req_shop_section_id) { ?> selected="selected"<?php } ?>>
							<?php echo $section->title; ?> (<?php echo $section->active_listing_count; ?>)
						</option>
						<?php } ?>
					</select>
				</div>

				<div class="col-md-8 col-lg-9">
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
					<hr />
					<?php } ?>
				</div>

			</div>

			<?php if (!empty($this->pagination->effective_offset) || !empty($this->pagination->next_page)) { ?>
			<div class="row">
				<div class="col-md-9 col-lg-9 offset-md-3 offset-lg-3 text-center">
					<nav>
					  <ul class="pagination justify-content-center">
						<li class="page-item<?php if (empty($this->pagination->effective_offset)) { ?> disabled<?php } ?>">
						  <a class="page-link" href="/shop/<?php echo $this->section_request; ?><?php echo (($this->pagination->effective_page - 1 > 1) ? $this->pagination->effective_page - 1 : ''); ?>">Previous</a>
						</li>
						<li class="page-item<?php if (empty($this->pagination->next_page)) { ?> disabled<?php } ?>">
						  <a class="page-link" href="/shop/<?php echo $this->section_request; ?><?php echo $this->pagination->next_page; ?>">Next</a>
						</li>
					  </ul>
				</nav>
				</div>
			</div>
			<?php } ?>

		</div>
	</div>
</div>

<?php include('page_footer.tpl.php'); ?>
