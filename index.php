<?php
	require_once 'core/init.php';	
	if($user->isLoggedIn()) {
		Redirect::to("/dashboard/");
	} else {
		Redirect::to("/login/");
	}
?>