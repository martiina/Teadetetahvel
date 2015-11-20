<?php
	require_once 'core/init.php';
	$news = new News();
	$tpl->token = Token::generate();
	if($user->isLoggedIn() && !Input::exists()) {
		$tpl->newsCount = $news->getDesktopNewsCount();
		//$tpl->content = displayContent('desktop/desk.default');
		if(Input::get('page')) {
			$page = Input::get('page');
			switch($page) {
				case 'logout':
					$user->logout();
					Redirect::to('/login/');
				break;
				default:
					Session::flash(Config::get('flash-settings/flash-info'), 'Valitud lehte ei eksisteeri!');
					Redirect::to(404);
				break;
			}
		}
		$tpl->sortNewsList = $news->sortNewsList();
		$tpl->listgroup = $user->listItems('groups');
		$tpl->listusers = $user->listItems('users');
		$tpl->content = displayContent('desktop/desk.logged');
		output_page('content/desktop', 'Desktop', null, null, false);
	} elseif(Input::get('getModalData')) {
		$nid = Input::get('nid');
		if($nid) {
			echo "<h4>Muuda uudist: " . $nid . "</h4>";
			echo "<div class='row'>
					<div class='col-lg-6'>
						Grupid: 
						<select>
							<option>Tuleb mõelda</option>
							<option>Tuleb mõelda</option>
							<option>Tuleb mõelda</option>
						</select>
					</div>
					<div class='col-lg-6'>
						Inimesed:
						<select>
							<option>Tuleb mõelda</option>
							<option>Tuleb mõelda</option>
							<option>Tuleb mõelda</option>
						</select>
					</div>
					<div class='col-lg-12'>
						<textarea>Sisu</textarea>
					</div>
				 </div>";
		} else {
			echo "<h4>Tekkis viga andmete laadimisel...</h4>";
		}
	} elseif(Input::get('changeNews')) {
		echo 'test';
	} else {
		// $validation = new Validation();
		// if(Input::exists()) {
			// if(Token::check(Input::get(Config::get('session/token_name')))) {
				// $validate = $validation->check($_POST, array(
					// 'username' => array(
						// 'required' => true,
						// 'min' => Config::get('user-settings/user-min-length'),
						// 'max' => Config::get('user-settings/user-max-length'),
						// 'alias' => 'Kasutajanimi'
					// ),
					// 'password' => array(
						// 'required' => true,
						// 'min' => Config::get('user-settings/pass-min-length'),
						// 'alias' => 'Parool'
					// )
				// ));
				// if($validation->passed()) {
					// $remember = (Input::get('remember') === 'on') ? true : false;
					// $login = $user->login(Input::get('username'), Input::get('password'), $remember);
					// if($login) {
						// Redirect::to('/desktop/');
					// } else {
						// $errors[] = 'Vale kasutajanimi või parool';
					// }
				// } else {
					// foreach($validation->errors() as $error) {
						// $errors[] = $error;
					// }
				// }
			// }
		// }
		// $tpl->errors = $errors;	
		// $tpl->token = Token::generate();
		// $tpl->content = displayContent('desktop/desk.login');
		// $title = 'Login';
		// output_page('content/desktop', $title, null, null, false);
		Redirect::to('/login/');
	}
?>