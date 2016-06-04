<?php
require_once('includes/Etsy.php');

class page_shop
{
	function runPublic()
	{
		$this->runShop();
	}

	function runUser()
	{
		$this->runShop();
	}

	function runShop()
	{
		$tpl = App::instance()->template();

		if (!empty($tpl->shopInfo->is_vacation))
		{
			$tpl->setStatusMsg($tpl->shopInfo->vacation_message);
			header('HTTP/1.1 307 Temporary Redirect');
			App::bounce('/');
		}

		$tpl->assign('sections', $tpl->shopInfo->Sections);
		$tpl->assign('listing_active_count', $tpl->shopInfo->listing_active_count);

		$req_page = 1;
		$per_page = 12;
		$page_offset = 0;
		$search_key = array();

		if (!empty($tpl->uri_parts[1]) && $tpl->uri_parts[1] == 'search')
		{
			if (!empty($tpl->uri_parts[3]) && is_numeric($tpl->uri_parts[3]))
			{
				$req_page = $tpl->uri_parts[3];
				$page_offset = $per_page * ($req_page - 1);
			}

			if (!empty($tpl->uri_parts[2]))
			{
				$search_key = array(
					'sort_on' => 'score',
					'keywords' => str_replace('+', ',', $tpl->uri_parts[2])
				);
			}
		}

		if (!empty($tpl->uri_parts[2]) && is_numeric($tpl->uri_parts[2]) && $tpl->uri_parts[2] != '1')
		{
			$req_page = $tpl->uri_parts[2];
			$page_offset = $per_page * ($req_page - 1);
		}
		else if (!empty($tpl->uri_parts[1]) && is_numeric($tpl->uri_parts[1]))
		{
			$req_page = $tpl->uri_parts[1];
			$page_offset = $per_page * ($req_page - 1);
		}

		if (!empty($tpl->uri_parts[1]) && preg_match("/^[0-9]*\-[a-z_]*$/i", $tpl->uri_parts[1]))
		{
			$request = explode('-', $tpl->uri_parts[1]);
			$cat_id = $request[0];

			$listings = new Etsy();
			$listings->endpoint = '/shops/stoneriverdesign/sections/' . $cat_id . '/listings/active';
			$listings->params = array(
				'includes' => 'Section,Images',
				'limit' => $per_page,
				'offset' => $page_offset
			);
			$listings->queryEtsy();

			$listingsArray = $listings->result->results;

			$tpl->assign('page_title_section', (!empty($listings->result->results[0]->Section->title) ? $listings->result->results[0]->Section->title : false));
			$tpl->assign('req_shop_section_id', $cat_id);
		}
		else
		{
			$listings = new Etsy();
			$listings->endpoint = '/shops/stoneriverdesign/listings/active';
			$listings->params = array_merge($search_key, array(
				'includes' => 'Images',
				'limit' => $per_page,
				'offset' => $page_offset
			));
			$listings->queryEtsy();

			$listingsArray = $listings->result->results;

			$tpl->assign('page_title_section', false);
			$tpl->assign('req_shop_section_id', false);
		}

		if (empty($listingsArray))
		{
			$message = 'No listings found';

			if (!empty($search_key))
			{
				$message .= ' for "' . urldecode($tpl->uri_parts[2]) . '"';
			}

			$message .= '.';

			$tpl->setStatusMsg($message);
			header("HTTP/1.0 404 Not Found");
			App::bounce('/');
		}

		$sections_request = ((!empty($tpl->uri_parts[1]) && !is_numeric($tpl->uri_parts[1])) ? $tpl->uri_parts[1] . '/' : '');

		if (!empty($tpl->uri_parts[1]) && $tpl->uri_parts[1] == 'search')
		{
			$sections_request .= $tpl->uri_parts[2] . '/';
		}

		$tpl->assign('listings', $listingsArray);
		$tpl->assign('section_request', $sections_request);
		$tpl->assign('pagination', $listings->result->pagination);
	}
}

?>