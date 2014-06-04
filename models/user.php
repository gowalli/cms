<?php

class user extends DatabaseObject {
	function __construct() {
		$this->_setPrimaryKey('user_id');
	}

	static function login($username, $password) {
		$user = User::fetch(array('email' => $username));
		if(!is_object($user)) {
			return(false);
		}

		if(!password_verify($password, $user->password)) {
			return(false);
		}

		return($user);
	}

	function set_login_cookie() {
		$time = time();
		$cookie_key = Site_Option::fetch(array('option_name' => 'cookie_key'));
		$hash = hash_hmac("sha256", "{$this->email}|$time", $cookie_key->option_value);

		setcookie("sid", "{$this->email}|$time|$hash", time() + (60*60*24*30), '/', $_SERVER['HTTP_HOST']);
	}

	static function maybe_load_user() {
		if(!isset($_COOKIE['sid']))
			return(false);

		$cookie_parts = explode('|', $_COOKIE['sid']);
		if(sizeof($cookie_parts) != 3)
			return(false);

		$email = $cookie_parts[0];
		$time = $cookie_parts[1];
		$hash = $cookie_parts[2];

		$cookie_key = Site_Option::fetch(array('option_name' => 'cookie_key'));

		$user = User::fetch(array('email' => $email));
		if(!is_object($user))
			return(false);

		$expected_hash = hash_hmac("sha256", "{$user->email}|$time", $cookie_key->option_value);

		if(strcmp($hash, $expected_hash) != 0)
			return(false);

		return($user);
	}
}
