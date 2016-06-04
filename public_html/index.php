<?php
include_once('../includes/App.php');

$app = new App();

$page = 'home';

$uri_request = $app->uri_request();

if (!empty($uri_request))
{
	$page = $uri_request;
}

$app->run($page);
?>