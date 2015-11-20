<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// in_script
define("IN_SCRIPT","TRUE");

//$errors global variable
$errors = "";

//NEID MITTE NÄPPIDA....
$GLOBALS['settings'] = array(
	'mysql' => array(
		'hostname' => '127.0.0.1',
		'username' => 'root',
		'password' => '',
		'database' => ''
	),
	'remember' => array(
		'cookie_name' => 'vxhash',
		'cookie_expiry' => 604800
	),
	'session' => array(
		'token_name' => 'vx_session',
		'session_name' => 'user_session',
		'lang' => 'et'
	),
	'misc' => array(
		'base-url' => 'http://vsk.smaidar.ee/',
		'base-name' => 'Teadetetahvel'
	),
	'user-settings' => array(
		'user-min-length' => 3,
		'user-max-length' => 28,
		'pass-min-length' => 4
	),
	'flash-settings' => array(
		'flash-bad' => 'danger',
		'flash-warn' => 'warning',
		'flash-good' => 'success',
		'flash-info' => 'info'
	)
);

require_once('functions/sanitize.php');

spl_autoload_register(function($class){
	require_once('classes/' . $class . '.php');
});

$tpl = new Savant3();
$user = new User();

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = Database::getInstance()->get('users_session', array('hash', '=', $hash));
	if($hashCheck->count()) {
		$user = new User($hashCheck->first()->user_id);
		$user->login();
	}
}

if($user->isLoggedIn()) {
	$tpl->logged = true;
	$tpl->userdata = $user->data();
} else {
	$tpl->logged = false;
}
?>