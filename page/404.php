<?php
class page_404
{
	function runPublic()
	{
		$this->run404();
	}

	function runUser()
	{
		$this->run404();
	}

	function run404()
	{
		header('HTTP/1.1 404 Not Found');
	}
}
?>