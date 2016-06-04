<?php
require_once('Config.php');
require_once('Savant3.php');
require_once('Database.php');
require_once('Template.php');
require_once('User.php');

class App
{
	private $_template = null;

	public $request_uri = null;
	public $uri_parsed = array();
	public $uri_parts = array();
	public $uri_request = null;
	public $user = null;

	static private $_instance = null;

	static function instance()
	{
		return self::$_instance;
	}

	function template()
	{
		return $this->_template;
	}

	function __construct()
	{
		self::$_instance = $this;

		$redirect_url = (!empty($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : false);

		$this->request_uri = strtolower(preg_replace('/[^a-z0-9\+_\-\\/]+/i', '', $redirect_url));

		$this->uri_parsed = parse_url($this->request_uri);
		$this->uri_parts = explode('/', substr($this->uri_parsed['path'], 1));

		$this->uri_request = $this->uri_parts[0];
	}

	function run($page)
	{
		$User = $this->user();

		$this->_template = new Template($User);

		$this->_template->assign('user', $User);
		$this->_template->assign('uri_request', $this->uri_request());
		$this->_template->assign('uri_parts', $this->uri_parts());
		$this->_template->assign('request_uri', $this->request_uri());

		if (file_exists(PAGE_PATH . '/' . $page . '.php'))
		{
			require_once(PAGE_PATH . '/' . $page . '.php');

			$pageClass = 'page_' . $page;

			$pageLogic = new $pageClass();

			if (!empty($User->id))
			{
				$pageLogic->runUser();
			}
			else
			{
				$pageLogic->runPublic();
			}
		}
		else if (file_exists(TEMPLATE_PATH . '/' . $page . '.tpl.php'))
		{
			// static page only, no page file
		}
		else
		{
			App::bounce('/404');
		}

		$this->_template->display($page . '.tpl.php');

	}

	function user()
	{
		$User = new User();
		$User->getCurrentUser();

		return $User;
	}

	function uri_request()
	{
		return $this->uri_request;
	}

	function uri_parts()
	{
		return $this->uri_parts;
	}

	function request_uri()
	{
		return $this->request_uri;
	}

	static public function bounce($page = '/')
	{
		header('location: ' . $page);
		die('Redirect');
	}

	static public function setCookie($key, $value)
	{
		setcookie($key, $value, strtotime('next year'), '/', null, null, true);
	}

	static public function getCookie($key)
	{
		$val = false;

		if (array_key_exists($key, $_COOKIE))
		{
			$val = $_COOKIE[$key];
		}

		return $val;
	}
}
?>