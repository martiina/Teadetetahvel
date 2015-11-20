<?php
	require_once '../core/init.php';
	$db = Database::getInstance();
	$validation = new Validation();
	if(Input::exists()) {
		if(Token::check(Input::get(Config::get('session/token_name')))) {
			$validate = $validation->check($_POST, array(
				'teade' => array(
					'required' => true,
					'alias' => 'Teade'
				)
			));						
			if($validation->passed()) {
				if(Input::get('grupp')) {
					$grupp = implode('|', Input::get('grupp'));
				} else {
					$grupp = 0;
				}
				if(Input::get('ppl')) {
					$ppl = implode('|', Input::get('ppl'));
				} else {
					$ppl = 0;
				}
				$complete = Input::get('complete');
				if($complete == 2): $archive = 1; else: $archive = 0; endif;
				try {
					if(Input::get('time')) {
						$date = new DateTime(Input::get('time'));
						$deadline = $date->getTimestamp();
					} else {
						$deadline = 0;
					}
					$id = Input::get('news_id');
					$db->update('news', 'id', $id, array(
						'content'		=> nl2br(escape(Input::get('teade'))),
						'author' 		=> $user->data()->firstname.' '.$user->data()->lastname,
						'authorid'		=> $user->data()->id,
						'groupid'		=> $grupp,
						'userid'		=> $ppl,
						'date'			=> date('Y-m-d H:i:s'),
						'deadline'		=> $deadline,
						'archive'		=> $archive,
						'completed'		=> $complete
					));
					Redirect::to('/desktop/');
				} catch(Exception $e) {
					die($e->getMessage());
				}
			} else {
				foreach($validation->errors() as $error) {
					$errors[] = $error;
				}
			}
		}
	} else {
		Redirect::to('/desktop/');
	}
?>