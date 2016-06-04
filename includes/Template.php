<?php

/**
 * Created by PhpStorm.
 * User: Ryan.Snook
 * Date: 12/8/2014
 * Time: 1:52 PM
 */
class Template extends Savant3
{
	static private $head_script_array = array();
	static private $head_script_var_array = array();
	static private $head_css_array = array();
	static private $head_onload_array = array();
	public $shopInfo = false;

	public $user = null;

	function __construct($User)
	{
		$this->user = $User;

		$this->setPath('template', TEMPLATE_PATH);

		// Load required external css files
		$this->initSetCSS();

		// Load required external script files
		$this->initSetScript();

		// Load required scripts
		$this->initOnload();

		// Load Main Store information
		$this->initShopInfo();
	}

	public function loadTemplate($tpl = null)
	{
		// make sure we have a template source to work with
		if (is_null($tpl))
		{
			$tpl = $this->__config['template'];
		}

		// get a path to the compiled template script
		$result = $this->template($tpl);

		return $result;
	}

	// Required scripts for all pages
	function initOnload()
	{
		// Following included in front end
		//self::$head_onload_array[] = 'global_init();';

		if ($this->user->isAdmin())
		{
			self::$head_onload_array[] = 'admin_init();';
		}

		$this->assign('head_onload', array_unique(self::$head_onload_array));
	}

	function initShopInfo()
	{
		if (empty($this->shopInfo))
		{
			require_once('Etsy.php');

			$store = new Etsy();
			$store->endpoint = '/shops/stoneriverdesign';
			$store->params = array('includes' => 'About/Members,About/Images,User,Sections');
			$store->queryEtsy();

			$this->shopInfo = $store;
		}
		else
		{
			$store = $this->shopInfo;
		}

		$this->assign('shopInfo', $store->result->results[0]);
	}

	function setOnLoad($javascript)
	{
		self::$head_onload_array[] = trim($javascript);

		$this->assign('head_onload', array_unique(self::$head_onload_array));
	}

	// Required scripts for all pages
	function initSetScript()
	{
		// libraries
		self::setScript('//code.jquery.com/jquery-3.3.1.slim.min.js');
		self::setScript('//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js');
		self::setScript('//stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js');

		self::setScript(SCRIPT_PATH . '/vendor/jquery.magnific-popup.min.js');
		self::setScript(SCRIPT_PATH . '/stoneriver.js');

		if ($this->user->isAdmin())
		{
			self::setScript(SCRIPT_PATH . '/themer_admin.js');
		}

		$this->assign('head_script', array_unique(self::$head_script_array));
	}

	function setScript($javascript)
	{
		self::$head_script_array[] = trim($javascript) . ((strpos($javascript, '?')) ? '&amp;' : '?') . 'v=' . JS_CSS_VERSION;

		$this->assign('head_script', array_unique(self::$head_script_array));
	}

	function setScriptVar($javascript)
	{
		self::$head_script_var_array[] = trim($javascript);

		$this->assign('head_script_var', array_unique(self::$head_script_var_array));
	}

	// Required css for all pages
	function initSetCSS()
	{
		// libraries
		self::setCSS('//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800');
		self::setCSS('//fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic');
		self::setCSS('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css');
		self::setCSS('//use.fontawesome.com/releases/v5.0.13/css/all.css');

		// site css
		self::setCSS('//stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css');

		self::setCSS(CSS_PATH . '/vendor/magnific-popup.css');
		self::setCSS(CSS_PATH . '/style.css');

		$this->assign('head_css', array_unique(self::$head_css_array));
	}

	function setCSS($stylesheet)
	{
		self::$head_css_array[] = trim($stylesheet) . ((strpos($stylesheet, '?')) ? '&amp;' : '?') . 'v=' . JS_CSS_VERSION;

		$this->assign('head_css', array_unique(self::$head_css_array));
	}

	function setStatusMsg($msg)
	{
		$existingMsg = '';
		if (App::getCookie('statusMsg'))
		{
			$existingMsg = App::getCookie('statusMsg');
		}
		if (!empty($existingMsg))
		{
			App::setCookie('statusMsg', $existingMsg . '<br />' . addslashes($msg));
		}
		else
		{
			App::setCookie('statusMsg', addslashes($msg));
		}
	}

	function setErrorMsg($msg)
	{
		$existingMsg = '';
		if (App::getCookie('errorMsg'))
		{
			$existingMsg = App::getCookie('errorMsg');
		}
		if (!empty($existingMsg))
		{
			App::setCookie('errorMsg', $existingMsg . '<br />' . addslashes($msg));
		}
		else
		{
			App::setCookie('errorMsg', addslashes($msg));
		}
	}

	/**
	 * Gets the message and unsets it from the cache
	 */
	function getStatusMsg()
	{
		$rtn = '';
		if (App::getCookie('statusMsg'))
		{
			$rtn = App::getCookie('statusMsg');

			App::setCookie('statusMsg', false);
		}

		return $rtn;
	}

	/**
	 * Gets the message and unsets it from the cache
	 */
	function getErrorMsg()
	{
		$rtn = '';

		if (App::getCookie('errorMsg'))
		{
			$rtn = App::getCookie('errorMsg');

			App::setCookie('errorMsg', false);
		}

		return $rtn;
	}

	static function nl2p($str)
	{
		$arr = explode("\n", $str);
		$out = '';

		for ($i = 0; $i < count($arr); $i++)
		{
			if (strlen(trim($arr[$i])) > 0)
			{
				$out .= '<p>' . trim($arr[$i]) . '</p>' . "\n";
			}
		}

		return $out;
	}

	static function itemLink($id, $title, $page = false)
	{
		return self::storeLink($id, $title, $page);
	}

	static function sectionLink($id, $title, $page = false)
	{
		return self::storeLink($id, $title, $page);
	}

	static function storeLink($id, $title, $page = false)
	{
		$link = '';

		if (!empty($id) && !empty($title))
		{
			$link .= $id . '-' . preg_replace('/[^a-z0-9]+/', '_', strtolower($title));
		}

		if (!empty($page))
		{
			$link .= ((!empty($page) && $page > 1) ? (!empty($link) ? '/' : '') . $page : '');
		}

		return $link;
	}
}

?>