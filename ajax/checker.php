<?php

	require_once '../core/init.php';
	$news = new News();
	if(Input::get('logged_in')) {
		if(Input::get('logged_in') == false) {
			$all_news = $news->getNewsCount(0,0);
		} else {
			$all_news = $news->getDesktopNewsCount();
		}

		echo $all_news;
	} else {
		Redirect::to('/');
	}

?>