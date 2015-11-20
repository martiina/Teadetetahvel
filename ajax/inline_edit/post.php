<?php
	require_once '../../core/init.php';
	$news = new News();
	
	//Uudiste muutmine
	if(Input::get('value') && Input::get('name') && Input::get('pk')) {
		$update = $news->updateNews(Input::get('pk'), Input::get('name'), nl2br(escape(Input::get('value'))), $user->data()->firstname.' '.$user->data()->lastname);
		if(!$update) {
			header('HTTP 400 Bad Request', true, 400);
			echo "Midagi juhtus uuendamisel!";
		}
	} else {
		Redirect::to('/dashboard/');
	}
?>