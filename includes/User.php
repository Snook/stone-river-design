<?php

/**
 * Created by PhpStorm.
 * User: Ryan.Snook
 * Date: 12/5/2014
 * Time: 9:45 PM
 */
class User
{
	const USER = 'USER';
	const MOD = 'MOD';
	const ADMIN = 'ADMIN';

	public $id = null;
	public $user_type = 'GUEST';
	public $token = null;
	public $username = null;
	public $reddit_auth_token = null;
	public $reddit_refresh_token = null;
	public $reddit_id = null;
	public $reddit_username = null;

	public $profile = 'me';
	public $ip_address = null;

	function __construct()
	{
		if (!empty($_COOKIE['themer']) && ctype_alnum($_COOKIE['themer']))
		{
			$this->token = $_COOKIE['themer'];
		}

		$this->ip_address = $_SERVER['REMOTE_ADDR'] ? : ($_SERVER['HTTP_X_FORWARDED_FOR'] ? : $_SERVER['HTTP_CLIENT_IP']);
	}

	function isLoggedIn()
	{
		if (!empty($this->id))
		{
			return true;
		}

		return false;
	}

	function isAdmin()
	{
		if (!empty($this->user_type) && $this->user_type == User::ADMIN)
		{
			return true;
		}

		return false;
	}

	function isMod()
	{
		if (!empty($this->user_type) && $this->user_type == User::MOD)
		{
			return true;
		}

		return false;
	}

	function isUser()
	{
		if (!empty($this->user_type) && $this->user_type == User::USER)
		{
			return true;
		}

		return false;
	}

	function getCurrentUser()
	{
		if (!empty($this->token))
		{
			$User = Database::f("SELECT * FROM `themer_user` WHERE token = '" . $this->token . "'");

			if (!empty($User))
			{
				$User->ip_address = $this->ip_address;

				foreach ($User AS $k => $v)
				{
					$this->{$k} = $v;
				}

				if (!empty($this->username))
				{
					$this->profile = strtolower($this->username);
				}

				$STH = Database::prepare("UPDATE `themer_user` SET `ip_address` = :ip_address WHERE `id` = :id");
				$STH->bindValue(':id', $User->id, PDO::PARAM_INT);
				$STH->bindValue(':ip_address', $User->ip_address, PDO::PARAM_STR);
				$STH->execute();

				/*
				if (empty($this->username) && !empty($this->reddit_username))
				{
					$this->me_username = $this->reddit_username;
				}

				if (empty($this->username) && !empty($this->imgur_username))
				{
					$this->me_username = $this->imgur_username;
				}
				*/
			}
		}
	}
}

?>