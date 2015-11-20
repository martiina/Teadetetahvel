<?php
	require_once 'core/init.php';

	$validation = new Validation();
	if(Input::exists()) {
		if(Token::check(Input::get(Config::get('session/token_name')))) {
			$validate = $validation->check($_POST, array(
				'username' => array(
					'required' => true,
					'min' => Config::get('user-settings/user-min-length'),
					'max' => Config::get('user-settings/user-max-length'),
					'alias' => 'Kasutajatunnus'
				),
				'password' => array(
					'required' => true,
					'min' => Config::get('user-settings/pass-min-length'),
					'alias' => 'Parool'
				)
			));
			if($validation->passed()) {
				$user = new User();
				$remember = (Input::get('remember') === 'on') ? true : false;
				$login = $user->login(Input::get('username'), Input::get('password'), $remember);
				if($login) {
					Redirect::to('/desktop/');
				} else {
					$errors[] = 'Vale kasutajatunnus või parool';
				}
			} else {
				foreach($validation->errors() as $error) {
					$errors[] = $error;
				}
			}
		}
	}

	$tpl->errors = $errors;

	output_page('content/login', 'Logi sisse');
?>