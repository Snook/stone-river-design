<?php
require_once('includes/Etsy.php');

class page_item
{
	function runPublic()
	{
		$this->runItem();
	}

	function runUser()
	{
		$this->runItem();
	}

	function runItem()
	{
		$tpl = App::instance()->template();

		if (!empty($tpl->uri_parts[1]) && !is_numeric($tpl->uri_parts[1]))
		{
			$request = explode('-', $tpl->uri_parts[1]);
			$listing_id = $request[0];

			$listing = new Etsy();
			$listing->endpoint = '/listings/' . $listing_id;
			$listing->params = array('includes' => 'Images');
			$listing->queryEtsy();

			if (empty($listing->result->results[0]) || empty($listing->result->results[0]->listing_id))
			{
				$tpl->setErrorMsg('Listing not found.');
				header("HTTP/1.0 404 Not Found");
				App::bounce('/shop');
			}

			if (!empty($_GET['back']))
			{
				$tpl->assign('back', $_GET['back']);
			}
			else
			{
				$tpl->assign('back', false);
			}

			$tpl->assign('listing', $listing->result->results[0]);
			$tpl->assign('page_title_section', (!empty($listing->result->results[0]->Section->title) ? $listing->result->results[0]->Section->title : false));
		}

	}
}
?>