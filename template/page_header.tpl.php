<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php echo (!empty($this->og_description)) ? $this->og_description : 'Lampwork glass beads and fused glass by Linda Holcomb-Bryant, for yourself or someone special.'; ?>">
	<meta name="author" content="Linda Holcomb-Bryant">
	<title><?php if (!empty($this->title)) { ?><?php echo $this->title; ?> - <?php } ?>Stone River Design</title>
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#3e6515">
	<meta name="apple-mobile-web-app-title" content="Stone River Design">
	<meta name="application-name" content="Stone River Design">
	<meta name="msapplication-TileColor" content="#3e6515">
	<meta name="theme-color" content="#3e6515">
	<meta name="msapplication-navbutton-color" content="#3e6515">
	<meta name="apple-mobile-web-app-status-bar-style" content="#3e6515">
	<meta property="og:title" content="<?php if (!empty($this->title)) { ?><?php echo $this->title; ?> - <?php } ?>Stone River Design" />
	<meta property="og:description" content="<?php echo (!empty($this->og_description)) ? $this->og_description : 'Lampwork glass beads and fused glass by Linda Holcomb-Bryant, for yourself or someone special.'; ?>" />
	<meta property="og:image" content="<?php echo (!empty($this->og_image) ? $this->og_image : HTTP_SERVER . IMAGE_PATH . '/slide-2.jpg'); ?>" />
<?php if (!empty($this->canonical)) { ?>
	<meta property="og:url" content="<?php echo HTTP_SERVER; ?><?php echo $this->canonical; ?>" />
	<link rel="canonical" href="<?php echo $this->canonical; ?>" />
<?php } ?>
<?php
if(isset($this->head_css))
{
	foreach ($this->head_css as $css)
	{
		echo '	<link href="' . $css . '" rel="stylesheet" type="text/css" />' . "\n";
	}
}
?>
</head>

<body id="page-top"<?php if (!empty($this->itemscope)) { ?> itemscope itemtype="http://schema.org/<?php echo $this->itemscope; ?>"<?php } ?>>

<header class="d-none d-md-block d-lg-block">
	<div class="container">
		<div class="row">
			<div class="col text-center my-4">
				<h1 class="brand"<?php if (!empty($this->itemscope)) { ?> itemprop="brand" itemscope itemtype="http://schema.org/Brand"<?php } ?>><span<?php if (!empty($this->itemscope)) { ?>  itemprop="name"<?php } ?>>Stone River Design</span></h1>
				<h2 class="address-bar">Monmouth, Oregon</h2>
			</div>
		</div>
	</div>
</header>

<nav class="navbar navbar-expand-md sticky-top navbar-light bg-light py-md-4 mb-4">
	<a class="navbar-brand d-md-none d-lg-none" href="#page-top">
		<img src="/favicon-32x32.png" width="30" height="30" class="d-none d-sm-inline-block align-top rounded-circle" alt="Stone River Design">
		Stone River Design
	</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav m-auto text-right">
			<li class="nav-item text-md-center mr-4 mt-4 mt-md-0"><a class="nav-link text-uppercase" href="/"><i class="fas fa-home d-none d-md-inline-block"></i> Home <i class="fas fa-home d-md-none"></i></a></li>
			<li class="nav-item text-md-center mr-4"><a class="nav-link text-uppercase" href="/about"><i class="fas fa-user d-none d-md-inline-block"></i> About <i class="fas fa-user d-md-none"></i></a></li>
			<?php if (empty($this->shopInfo->is_vacation)) { ?>
			<li class="nav-item text-md-center mr-4 mb-4 mb-md-0"><a class="nav-link text-uppercase" href="/shop"><i class="fas fa-shopping-cart d-none d-md-inline-block"></i> Shop <i class="fas fa-shopping-cart d-md-none"></i></a></li>
			<li>
				<div class="input-group">
					<input id="search" type="text" class="form-control" placeholder="Keyword"<?php echo ((!empty($this->uri_parts[1]) && $this->uri_parts[1] == 'search') ? ' value="' . urldecode($this->uri_parts[2]) . '"' : ''); ?>/>
					<div class="input-group-append">
						<button id="do_search" class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i> Search</button>
					</div>
				</div>
			</li>
			<?php } ?>
		</ul>
	</div>
</nav>

<?php if (!empty($this->shopInfo->is_vacation)) { ?>
<div class="container">
	<div class="row mb-4 p-4 bg-light">
		<div class="col text-center">
			<hr />
			<h5 class="text-uppercase"><span class="text-muted">Vacation</span> message</h5>
			<hr />
			<p><?php echo $this->shopInfo->vacation_message; ?></p>
		</div>
	</div>
</div>
<?php } ?>