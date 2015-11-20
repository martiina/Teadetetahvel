<?php
require_once 'core/init.php';
$news = new News();
$db = Database::getInstance();

if(!$user->isLoggedIn()) {
	Session::flash(Config::get('flash-settings/flash-bad'), 'Sa pead sisse logima kõigepealt.');
	Redirect::to('/login/');
}
$tpl->groupName = $user->getGroup();
if(Cookie::exists('sidebar') && Cookie::get('sidebar') == 1) {
	$tpl->status = 'sb-collapsed';
	$tpl->icon = 'fa fa-angle-right';
} else {
	$tpl->status = '';
	$tpl->icon = 'fa fa-angle-left';
}
if(Input::get('page')) {
	$page = Input::get('page');
	switch($page) {
		case 'edit':
			if(!intval(Input::get('id')) || !$user->isLoggedIn()) {
				Redirect::to('/dashboard/');
			}
			
			$id = Input::get('id');
			
			$query = $db->get('news', array('id', '=', $id));
			
			if(!$query->count()) {
				Session::flash(Config::get('flash-settings/flash-bad'), 'Valitud uudist ei eksisteeri.');
				Redirect::to('/dashboard/notifications/all/');
			}
			
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
						if(Input::get('complete')) {
							$completed = Input::get('complete');
						} else {
							$completed = 0;
						}
						try {
							if(Input::get('time')) {
								$date = new DateTime(Input::get('time'));
								$deadline = $date->getTimestamp();
							} else {
								$deadline = 0;
							}
							$db->update('news', 'id', $id, array(
								'content'		=> nl2br(escape(Input::get('teade'))),
								'author' 		=> $user->data()->firstname.' '.$user->data()->lastname,
								'authorid'		=> $user->data()->id,
								'groupid'		=> $grupp,
								'userid'		=> $ppl,
								'date'			=> date('Y-m-d H:i:s'),
								'deadline'		=> $deadline,
								'completed' 	=> $completed
							));
							Session::flash(Config::get('flash-settings/flash-info'), 'Teade edukalt muudetud!');
							Redirect::to('/dashboard/notifications/all/');
						} catch(Exception $e) {
							die($e->getMessage());
						}
					} else {
						foreach($validation->errors() as $error) {
							$errors[] = $error;
						}
					}
				}
			}
			
			$tpl->results = $query->first();
			$tpl->listgroup = $user->listItems('groups');
			$tpl->listusers = $user->listItems('users');
			
			$tpl->errors = $errors;
			$title = 'Muuda teadet';
			$tpl->content = displayContent('edit');
		break;
		case 'notifications':
			if(!$user->isLoggedIn()) {
				$title = 'Viga';
				$tpl->content = displayContent('errors/no-permission');
			} else {
				$title = 'Teated';
				$tpl->content = displayContent('notifications');
				$tpl->displayNewsByAuthor = $news->displayNewsByAuthor($user->data()->id);
				$tpl->getNewsData = $news->getNewsData();
				$tpl->archiveCount = $news->getArchiveCount();
				$tpl->archiveData = $news->getArchiveData();
				$tpl->doneNews = $news->getDone();
				$tpl->doneNewsCount = $news->getDoneCount();
			}
		break;
		case 'adduser':
			if(!checkPermissions('administrator')) {
				$title = 'Viga';
				$tpl->content = displayContent('errors/no-permission');
			} else {
				$validation = new Validation();
				if(Input::exists()) {
					if(Token::check(Input::get(Config::get('session/token_name')))) {
						$validate = $validation->check($_POST, array(
							'username' => array(
								'required' => true,
								'min' => Config::get('user-settings/user-min-length'),
								'max' => Config::get('user-settings/user-max-length'),
								'unique' => 'users',
								'alias' => 'Kasutajanimi'
							),
							'password' => array(
								'required' => true,
								'min' => Config::get('user-settings/pass-min-length'),
								'alias' => 'Parool'
							),
							'password2' => array(
								'required' => true,
								'min' => Config::get('user-settings/pass-min-length'),
								'matches' => 'password',
								'alias' => 'Paroolid'
							),
							'email' => array(
								'required' => true,
								'valid_email' => true,
								'alias' => 'Email',
								'unique' => 'users'
							),
							'firstname' => array(
								'required' => true,
								'alias' => 'Eesnimi'
							),
							'lastname' => array(
								'required' => true,
								'alias' => 'Perekonnanimi'
							),
							'grupp' => array(
								'required' => true,
								'alias' => 'Grupp'
							)
						));
						if($validation->passed()) {
							$salt = Hash::salt(32);
							try {
								$user->create(array(
									'username' 		=> Input::get('username'),
									'password'		=> Hash::make(Input::get('password'), $salt),
									'email' 		=> Input::get('email'),
									'salt'			=> utf8_encode($salt),
									'firstname'		=> Input::get('firstname'),
									'lastname'		=> Input::get('lastname'),
									'joined'		=> date('Y-m-d H:i:s'),
									'group'			=> Input::get('grupp')
								));
								Session::flash(Config::get('flash-settings/flash-good'), 'Kasutaja edukalt lisatud!');
								Redirect::to('/dashboard/adduser');
							} catch(Exception $e) {
								die($e->getMessage());
							}
						} else {
							foreach($validation->errors() as $error) {
								$errors[] = $error;
							}
						}
					}
				}
				$title = 'Lisa kasutaja';
				$tpl->content = displayContent('adduser');
				$tpl->errors = $errors;
				$tpl->listgroup = $user->listItems('groups');
			}
		break;
		case 'add':
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
						try {
							if(Input::get('time')) {
								$date = new DateTime(Input::get('time'));
								$deadline = $date->getTimestamp();
							} else {
								$deadline = 0;
							}
							$news->add(array(
								'content'		=> nl2br(escape(Input::get('teade'))),
								'author' 		=> $user->data()->firstname.' '.$user->data()->lastname,
								'authorid'		=> $user->data()->id,
								'groupid'		=> $grupp,
								'userid'		=> $ppl,
								'date'			=> date('Y-m-d H:i:s'),
								'deadline'		=> $deadline
							));
							Session::flash(Config::get('flash-settings/flash-info'), 'Teade edukalt lisatud!');
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
			}
			$tpl->errors = $errors;
			$tpl->listgroup = $user->listItems('groups');
			$tpl->listusers = $user->listItems('users');
			$title = 'Lisa teade!';
			$tpl->content = displayContent('add');
		break;
		case 'users':
			if(!checkPermissions('administrator')) {
				$title = 'Viga';
				$tpl->content = displayContent('errors/no-permission');
			} else {
				$tpl->getUsers = $user->listItems('users');
				$title = 'Kasutajad';
				$tpl->content = displayContent('users');
			}
		break;
		case 'settings':
			$validation = new Validation();
			if(Input::exists()) {
				if(Token::check(Input::get(Config::get('session/token_name')))) {
					$validate = $validation->check($_POST, array(
						'current_pass' => array(
							'required' => true,
							'alias' => 'Hetkene parool'
						),
						'password' => array(
							'min' => Config::get('user-settings/pass-min-length'),
							'alias' => 'Uus parool'
						),
						'new_pass' => array(
							'matches' => 'password',
							'alias' => 'Paroolid'
						),
						'email' => array(
							'required' => true,
							'valid_email' => true,
							'alias' => 'Email'
						)
					));
					if($validation->passed()) {
						if(Hash::make(Input::get('current_pass'), utf8_decode($user->data()->salt)) !== $user->data()->password) {
							$errors[] = "Su hetkene parool on vale!";
						} elseif(Input::get('avatar','tmp_name')) {
							$allowed = array('jpg', 'jpeg', 'png', 'gif');
							$filename = Input::get('avatar', 'name');
							$filesize = Input::get('avatar', 'size');
							$explode = explode('.', $filename);
							$extension = strtolower(end($explode));
							$max_filesize = 2097152; //2MB
							
							if($filesize > $max_filesize) {
								$errors[] = 'Failisuurus peab olema alla 2MB!';
							} elseif(!in_array($extension, $allowed)) {
								$errors[] = 'Faililaiend on lubamatu!';
							} else {
								$name = sha1(time()) . '.'.$extension.'';
								if(!empty($user->data()->avatar) && file_exists('assets/avatars/'.$user->data()->avatar)) {
									unlink('assets/avatars/'.$user->data()->avatar);
								}
								move_uploaded_file(Input::get('avatar', 'tmp_name'), 'assets/avatars/'.$name);
								$user->update(array(
									'avatar' => $name
								));
							}
						} else {
							if(!Input::get('password') && !Input::get('new_pass')) {
								$user->update(array(
									'email' => Input::get('email')
								));
							} else {
								$salt = Hash::salt(32);
								$user->update(array(
									'password' => Hash::make(Input::get('password'), $salt),
									'salt' => utf8_encode($salt),
									'email' => Input::get('email')
								));
							}
							Session::flash(Config::get('flash-settings/flash-good'), 'Seaded edukalt muudetud!');
							Redirect::to('/dashboard/settings');
						}
					} else {
						foreach($validation->errors() as $error) {
							$errors[] = $error;
						}
					}
				}
			}
			$tpl->errors = $errors;
			$tpl->content = displayContent('settings');
			$title = 'Seaded';
		break;
		case 'change':
			if(!$user->hasPermissions('administrator')) {
				$title = 'Viga';
				$tpl->content = displayContent('errors/no-permission');
			} else {
				if(intval(Input::get('user'))) {
					$id = Input::get('user');
					$query = $db->get('users', array('id', '=', $id));
					if($query->count()) {
						$data = $query->first();
						$validation = new Validation();
						if(Input::exists()) {
							if(Token::check(Input::get(Config::get('session/token_name')))) {
								$validate = $validation->check($_POST, array(
									'password' => array(
										'min' => Config::get('user-settings/pass-min-length'),
										'alias' => 'Parool'
									),
									'password2' => array(
										'min' => Config::get('user-settings/pass-min-length'),
										'matches' => 'password',
										'alias' => 'Paroolid'
									),
									'email' => array(
										'required' => true,
										'valid_email' => true,
										'alias' => 'Email'
									),
									'firstname' => array(
										'required' => true,
										'alias' => 'Eesnimi'
									),
									'lastname' => array(
										'required' => true,
										'alias' => 'Perekonnanimi'
									),
									'grupp' => array(
										'required' => true,
										'alias' => 'Grupp'
									)
								));
								if($validation->passed()) {
									try {
										if(Input::get('password') && Input::get('password2')) {
											$salt = Hash::salt(32);
											$updater = array(
												'group' => Input::get('grupp'),
												'password' => Hash::make(Input::get('password'), $salt),
												'salt' => utf8_encode($salt),
												'email' => Input::get('email'),
												'firstname' => Input::get('firstname'),
												'lastname' => Input::get('lastname')
											);
										} else {
											$updater = array(
												'group' => Input::get('grupp'),
												'email' => Input::get('email'),
												'firstname' => Input::get('firstname'),
												'lastname' => Input::get('lastname')
											);
										}
										$user->update($updater, $data->id);
										Session::flash(Config::get('flash-settings/flash-good'), ''.$data->username.' seaded edukalt muudetud!');
										Redirect::to('/dashboard/users');
									} catch(Exception $e) {
										die($e->getMessage());
									}
								} else {
									foreach($validation->errors() as $error) {
										$errors[] = $error;
									}
								}
							}
						}
						$user_data = array(
							'id' => $data->id,
							'username' => $data->username,
							'group' => $data->group,
							'eesnimi' => $data->firstname,
							'perenimi' => $data->lastname,
							'email' => $data->email
						);
						$tpl->errors = $errors;
						$tpl->profile_data = (object) $user_data; //Teeme array objectiks.
						$tpl->content = displayContent('change');
						$title = 'Muuda kasutajat';
						$tpl->listgroups = $user->listItems('groups');
					} else {
						Session::flash(Config::get('flash-settings/flash-info'), 'Valitud kasutajat ei eksisteeri!');
						Redirect::to(404);
					}
				} else {
					Redirect::to('/dashboard');
				}
			}
		break;
		default:
			Session::flash(Config::get('flash-settings/flash-info'), 'Valitud lehte ei eksisteeri!');
			Redirect::to(404);
		break;
	}
	output_page('content/dashboard', $title, array('/assets/css/dashboard.css'));
} else {
	$tpl->content = displayContent('default');
	/* Get */
	$tpl->getUserNewsCount = $news->getNewsCount($user->data()->id, null);
	$tpl->getGroupNewsCount = $news->getNewsCount(null, $user->data()->group);
	$tpl->getAllNewsCount = $news->getNewsCount(0, 0);
	
	/* Teadete kuvamine */
	$tpl->displayNewsAll = $news->displayNews(0,0,0);
	$tpl->displayNewsUser = $news->displayNews($user->data()->id,null,null);
	$tpl->displayNewsGroup = $news->displayNews(null,$user->data()->group,null);
	$tpl->displayNewsAuthor = $news->displayNews(null,null,$user->data()->id);

	$tpl->getGroup = $user->getGroup();
	//output_page('content/dashboard', $tpl->userdata->username.'\'s dashboard', array('/assets/css/dashboard.css'));
	Redirect::to('/desktop/');
}
?>