<?php
	header('Content-type: text/javascript');
	require_once '../../core/init.php';
	$news = new News();
	
	$json = array(
		'success' => false,
		'result' => 0
	);
	
	//date muutmine
	if(Input::get('value') && Input::get('name') && Input::get('pk')) {
		$strtime = strtotime(Input::get('value'));
		$update = $news->updateNews(Input::get('pk'), Input::get('name'), $strtime, $user->data()->firstname.' '.$user->data()->lastname);
		$json['success'] = true;
		$json['result'] = HumanizeTimestamp($strtime);
		
		echo json_encode($json);
	} else {
		Redirect::to('/dashboard/');
	}
?>