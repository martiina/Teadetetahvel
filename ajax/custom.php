<?php
	require_once '../core/init.php';
	
	//Sidebari state küpsisesse kirjutamine:
	if(Input::get('update_sidebar')) {
		Cookie::put('sidebar', Input::get('sidebar_state'), Config::get('remember/cookie_expiry'));
	} elseif(Input::get('update_sorting')) {
		Cookie::put('sort_by', Input::get('sort_by'), Config::get('remember/cookie_expiry'));
		Cookie::put('sort_value', Input::get('sort_value'), Config::get('remember/cookie_expiry'));
	} else {
		Redirect::to('/');
	}

?>