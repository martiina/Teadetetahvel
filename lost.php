<?php
	require_once 'core/init.php';
	
	if($user->isLoggedIn()) {
		Redirect::to('/dashboard/');
	}
	
	if(Input::get('action') === 'recover' && Input::get('hash')) {
		$query = Database::getInstance()->get('users', array('hash', '=', Input::get('hash')));
		if($query->count()) {
			$validation = new Validation();
			if(Input::exists()) {
				if(Token::check(Input::get(Config::get('session/token_name')))) {
					$validate = $validation->check($_POST, array(
						'password' => array(
							'min' => Config::get('user-settings/pass-min-length'),
							'alias' => 'Uus parool'
						),
						'password2' => array(
							'matches' => 'password',
							'alias' => 'Paroolid'
						),
					));
					if($validation->passed()) {
						$salt = Hash::salt(32);
						$user->update(array(
							'password' => Hash::make(Input::get('password'), $salt),
							'salt' => utf8_encode($salt),
							'hash' => ''
						), $query->first()->id);
						Session::flash(Config::get('flash-settings/flash-good'), 'Parool edukalt muudetud!');
						Redirect::to('/login/');
					} else {
						foreach($validation->errors() as $error) {
							$errors[] = $error;
						}
					}
				}
			}
			
			$tpl->errors = $errors;
			output_page('content/recover_change', 'Parooli taastamine');
		} else {
			Session::flash(Config::get('flash-settings/flash-bad'), 'Parooli taastamisel juhtus viga. Kui vajutasid lingile, mis oli saadetud Su emailile, siis võta ühendust administraatoriga!');
			Redirect::to('/lost/');
		}
	} else {
		$validation = new Validation();
		if(Input::exists()) {
			if(Token::check(Input::get(Config::get('session/token_name')))) {
				$validate = $validation->check($_POST, array(
					'email' => array(
						'required' => true,
						'valid_email' => true
					)
				));
				if($validation->passed()) {
					$email = Database::getInstance()->get('users', array('email', '=', Input::get('email')));
					if($email->count()) {
						$hash = Hash::unique();
						$data = array(
							'to' => Input::get('email'),
							'subject' => 'VSK Parooli taastamine',
							'message' => 'Lugupeetud '.$email->first()->firstname.' '.$email->first()->lastname.'!<br />Oled tellinud parooli meeldetuletuse. Kui ei, ignoreerige seda kirja! Allpool on link, kus saate oma parooli muuta.<br />Link: <a href="'.Config::get('misc/base-url').'lost/?action=recover&amp;hash='.$hash.'">Taasta parool siit.</a><hr />Link ei tööta?<br />Kopeeri see aadress otse brauseri aadressi ribale.<hr />'.Config::get('misc/base-url').'lost/?action=recover&amp;hash='.$hash.''
						);
						$user->update(array(
							'hash' => $hash
						), $email->first()->id);
						mail_utf8($data['to'], 'Võru spordikool', 'support@spordikool.ee', $data['subject'], $data['message']);
						Session::flash(Config::get('flash-settings/flash-good'), 'Parooli taastamise juhendid saadetud emailile! Email peaks saabuma mõne minutiga ning ära unusta kontrollida rämpsposti.');
						Redirect::to('/login/');
					} else {
						$errors[] = 'Sellist emaili andmebaasis ei eksisteeri!';
					}
				} else {
					foreach($validation->errors() as $error) {
						$errors[] = $error;
					}
				}
			}
		}
		$tpl->errors = $errors;
		output_page('content/recover', 'Parooli taastamine');
	}
?>