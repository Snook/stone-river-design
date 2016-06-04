<?php
require_once('includes/Etsy.php');

class page_home
{
	function runPublic()
	{
		$this->runHome();
	}

	function runUser()
	{
		$this->runHome();
	}

	function runHome()
	{
		$tpl = App::instance()->template();

		$feedback = new Etsy();
		$feedback->endpoint = '/users/stoneriverdesign/feedback/as-seller';
		$feedback->params = array('includes' => 'Listing/Images', 'limit' => 8);
		$feedback->queryEtsy();

		$feedbackArray = $feedback->result->results;

		$tpl->assign('feedback', $feedbackArray);

		$featured = new Etsy();
		$featured->endpoint = '/shops/stoneriverdesign/listings/featured';
		$featured->params = array('includes' => 'Images');
		$featured->queryEtsy();

		$listingArray = $featured->result->results;

		$tpl->assign('listings', $listingArray);
	}
}
?>