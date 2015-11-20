<?php

	require_once 'core/init.php';
	$news = new News();
	
	
	//Arhiveerimine
	if(Input::get('ajax_call_archive') && Input::get('news_id')) {
		if($user->hasPermissions('administrator')) {
			$news->archiveStatus(Input::get('news_id'));
			echo 'OK';
		}
	} elseif(Input::get('ajax_call_restore') && Input::get('news_id')) { 
		if($user->hasPermissions('administrator')) {
			$news->restoreArchive(Input::get('news_id'));
			echo 'OK';
		}
	} elseif(Input::get('ajax_call_delete') && Input::get('news_id')) {
		$db = Database::getInstance();
		$db->query("SELECT authorid FROM news WHERE id = ?", array(Input::get('news_id')));
		$data = $db->first();
		if($data->authorid === $user->data()->id) {
			$news->deleteArchive(Input::get('news_id'));
			echo 'OK';
		} else {
			if($user->hasPermissions('administrator')) {
				$news->deleteArchive(Input::get('news_id'));
				echo 'OK';
			}
		}
	} elseif(Input::get('task_complete')) { //Uudise märkimine tehtuks
		$news->taskComplete(Input::get('task_complete_id'), 1);
	} elseif(Input::get('task_uncomplete')) { //Uudise märkimine mitte tehtuks
		$news->taskComplete(Input::get('task_complete_id'), 0);
	} elseif(Input::get('ajax_call_check_done')) { // Märgime täitsa valmis selle
		$news->taskComplete(Input::get('news_id'), 2);
	} elseif(Input::get('ajax_call_check_undone')) { // saadame tagasi
		$news->taskComplete(Input::get('news_id'), 0);
	} else {
		Redirect::to('/');
	}
	
?>