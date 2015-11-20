<?php
/**
 * vxCommunity 1.0 (C) vxCommunity
 * Last file update: 22.01.2014
 * All rights reserved by our local policy. If You steal, we make your life hell! ^^.
*/

/**
 * Function:	getNewsAuthor($id);
 * Description:	Gets news author
 * Finish date:	02.06.2014 1.53
 * Build:		Martin
 * Updated:		Martin
*/
function getNewsAuthor($id) {
	$db = Database::getInstance();
	
	$query = $db->get('news', array('id', '=', $id));
	if($query->count()) {
		return $query->first()->authorid;
	}
	return false;
}


/**
 * Function:	escape($string);
 * Description:	Converts all applicable characters to HTML entities.
 * Finish date:	22.01.2014 22:15
 * Build:		Martin
 * Updated:		Martin
*/
function escape($string) {
	return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Function:	inline_errors($errors, $columns=12, $offset=0, $title="");
 * Description:	Shows all errors in un-ordered list.
 * Finish date:	22.01.2014 22:15
 * Build:		Martin
 * Updated:		Martin
*/
function inline_errors($errors, $columns=12, $offset=0, $title="", $dashboard = false) {

	global $tpl;

	if(empty($title)) {
		$title = 'Palun paranda järgmised vead!';
	}

	if(!is_array($errors)) {
		$errors = array($errors);
	}
	
	$tpl->dashboard = $dashboard;

	$tpl->error_title = $title;
	$tpl->inline_error = $errors;
	
	$tpl->columns = $columns;
	$tpl->offset = $offset;
	$tpl->display('templates/errors/inline_errors.tpl.php');
}

/**
 * Function:	output_page($page, $title="", $css=array(), $js=array());
 * Description:	Loads template including header and footer with given page title, js and css files.
 * Finish date:	23.01.2014 20:20
 * Build:		Martin
 * Updated:		Martin
*/
function output_page($page, $title="", $css=array(), $js=array(), $header = true) {
	global $tpl;

	if(empty($title)) {
		$title = 'Blank title.';
	}

	$tpl->title = Config::get('misc/base-name').' - '.$title;
	$tpl->css = $css;
	$tpl->js = $js;
	
	if($header) { 
		$tpl->display('templates/header.tpl.php');
	}
	$tpl->display('templates/'.$page.'.tpl.php');
	$tpl->display('templates/footer.tpl.php');
}

/**
 * Function:	getflash();
 * Description:	Shows flash messages, if session not empty.
 * Finish date:	25.01.2014 00:08
 * Build:		Martin
 * Updated:		Martin
*/
function getflash($dash = false, $columns=12, $offset=0) {

	global $tpl;
	$tpl->dashboard = $dash;
	$tpl->columns = $columns;
	$tpl->offset = $offset;

	if(Session::exists(Config::get('flash-settings/flash-bad'))) {
		$tpl->error_type = Config::get('flash-settings/flash-bad');
		$tpl->alert_heading = "<i class=\"fa fa-times-circle\"></i> Error!";
		$tpl->alert_content = Session::flash(Config::get('flash-settings/flash-bad'));
		$tpl->display('templates/errors/flash-messages.tpl.php');
	} 
	if(Session::exists(Config::get('flash-settings/flash-warn'))) {
		$tpl->error_type = Config::get('flash-settings/flash-warn');
		$tpl->alert_heading = "<i class=\"fa fa-warning\"></i> Warning!";
		$tpl->alert_content = Session::flash(Config::get('flash-settings/flash-warn'));
		$tpl->display('templates/errors/flash-messages.tpl.php');
	} 
	if(Session::exists(Config::get('flash-settings/flash-good'))) {
		$tpl->error_type = Config::get('flash-settings/flash-good');
		$tpl->alert_heading = "<i class=\"fa fa-check\"></i> Success!";
		$tpl->alert_content = Session::flash(Config::get('flash-settings/flash-good'));
		$tpl->display('templates/errors/flash-messages.tpl.php');
	} 
	if(Session::exists(Config::get('flash-settings/flash-info'))) {
		$tpl->error_type = Config::get('flash-settings/flash-info');
		$tpl->alert_heading = "<i class=\"fa fa-info-circle\"></i> Info!";
		$tpl->alert_content = Session::flash(Config::get('flash-settings/flash-info'));
		$tpl->display('templates/errors/flash-messages.tpl.php');
	}
	return '';
}

/**
 * Function:	sentence_case($string);
 * Description:	Makes words first letter CAPITAL
 * Finish date:	28.01.2014 23:27
 * Build:		Martin
 * Updated:		Martin
*/
function sentence_case($string) {
    $sentences = preg_split('/([.?!]+)/', $string, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
    $new_string = '';
    foreach ($sentences as $key => $sentence) {
        $new_string .= ($key & 1) == 0?
		ucfirst(strtolower(trim($sentence))) :
		$sentence.' ';
    }
    return trim($new_string);
}

/**
 * Function:	displayContent($file);
 * Description:	Displays content to dashboard.
 * Finish date:	03.03.2014 20:21
 * Build:		Martin
 * Updated:		Martin
*/
function displayContent($file) {
	if(!empty($file)) {
		$data = 'templates/content/pages/'.$file.'.tpl.php';
		if(file_exists($data)) {
			return $data;
		} else {
			die("Faili ei leitud!");
		}
	}
	return false;
}

/**
 * Function:	checkPermissions($key);
 * Description:	Checking for permissions for current user!
 * Finish date:	03.03.2014 20:21
 * Build:		Martin
 * Updated:		Martin
*/
function checkPermissions($key) {
	$user = new User();
	if(!empty($key)) {
		if(is_string($key)) {
			if($user->hasPermissions($key)) {
				return true;
			}
		}
	}
	return false;
}

/**
 * Function:	HumanizeTimestamp($timestamp, $format);
 * Description:	Humanizes timestamp and outputs it's Human readable!
 * Finish date:	18.03.2014 00:37
 * Build:		Martin
 * Updated:		Martin
*/
function HumanizeTimestamp($timestamp = 0, $format = 'Y-m-d') {
	$output = '';
	if(!$timestamp) {
		$output = 'Tähtaega pole määratud.';
	} else {
		if(date($format) == date($format, $timestamp)) {
			$output = 'Täna <i class="fa fa-clock-o" style="margin-left: 5px;"></i> ' . ucfirst(strftime('%H:%M', $timestamp));
		} elseif(date($format, $timestamp) == date($format, strtotime('tomorrow'))) {
			$output = 'Homme';
		} elseif(date($format, $timestamp) == date($format, strtotime('yesterday'))) {
			$output = 'Eile';
		} else {
			setlocale(LC_ALL, 'et_EE.UTF-8');
			$output = ucfirst(strftime('%A, %d %B %Y kell %H:%M', $timestamp));
		}
	}
	return $output;
}

/**
 * Function:	activeMenu($page);
 * Description:	Adds class (active) where page is current
 * Finish date:	20.03.2014 18:24
 * Build:		Martin
 * Updated:		Martin
*/
function activeMenu($page) {
	$current = $_SERVER['REQUEST_URI'];
	if($current === $page) {
		return ' class="active"';
	}
}

/**
 * Function:	EuropeFormat($time);
 * Description:	Converts US date or other date format to Europe one. Example: 01.04.2014 15:30
 * Finish date:	09.04.2014 17:16
 * Build:		Martin
 * Updated:		Martin
*/
function EuropeFormat($time) {
	if($time) {
		return date('d.m.Y, H:i', strtotime($time));
	}
	return false;
}

/**
 * Function:	debug($array);
 * Description:	Just for debuging
 * Finish date:	09.04.2014 17:24
 * Build:		Martin
 * Updated:		Martin
*/
function debug($array) {
	if(is_array($array)) {
		echo '<pre>';
		print_r($array);
		echo '</pre>';
		exit();
	}
	die("No array");
}

/**
 * Function:	getUserGroupId($user_id);
 * Description:	Gets user group id
 * Finish date:	01.04.2014 04:40
 * Build:		Josh
 * Updated:		Josh
*/
function getUserGroupId($id) {
	$db = Database::getInstance();
	$groupid = $db->get('users', array('id', '=', $id));
	if($groupid->count()) {
		return $group = $groupid->first()->group;
	}
	return 'Unknown';
}

/**
 * Function:	getUserGroupColor($author_id);
 * Description:	Gets user group color by author_id
 * Finish date:	09.04.2014 23:39
 * Build:		Josh
 * Updated:		Josh
*/
function getNewsGroupColor($user_id,$group_id) {
	global $user;
	// Personaalne
	if($user_id != 0) {
		if($user_id == $user->data()->id) {
			// Sinule
			return 'warning';
		} else {
			// Kellelegi teisele
			return 'info';
		}
	} elseif($group_id == 1) {
		// Tavakasutaja
		return 'success';
	} elseif($group_id == 2) {
		// Administraator
		return 'danger';
	} else {
		// Kõigile
		return 'primary';
	}
	return false;
}

/**
 * Function:	getNewsGroup($id);
 * Description:	Gets news group by id
 * Finish date:	10.042014 00:14
 * Build:		Josh
 * Updated:		Josh
*/
function getNewsGroup($user,$uid,$gid) {
	
	// Kõigile
	if($uid == 0 && $gid == 0): return 'Kõigile'; endif;
	
	// db
	$db = Database::getInstance();
	
	// explode
	$exp_user = explode('|',$uid);
	$exp_group = explode('|',$gid);
		
	// Kui groupid'd ja userid'd on üks
	if(count($exp_user) == 1 && count($exp_group) == 1) {
		// kas mõni value on 0?
		if(in_array(0,$exp_user)) {
			// kui user on 0, returni group
			$query = $db->get('groups', array('id', '=', $gid));
			return $query->first()->name;
		} elseif(in_array(0,$exp_group)) {
			// Kui userid == user, siis personaalne
			if($uid == $user) {
				return 'Sinule';
			} else {
				$query = $db->get('users', array('id', '=', $uid));
				return $query->first()->firstname . ' ' . $query->first()->lastname;
			}
		} else {
			// returni userid ja groupid
			$query_user = $db->get('users', array('id', '=', $uid));
			$user_firstname = $query_user->first()->firstname;
			$user_lastname = $query_user->first()->lastname;
			//	
			$query_group = $db->get('groups', array('id', '=', $gid));
			
			return  $user_firstname . ' ' . $user_lastname . ', ' . $query_group->first()->name;
		}	
	} else {
		// valuesid on rohkem kui 1,
		if(in_array(0,$exp_user)) {
			// kui user on 0, returnin kõik grupid
			$groups_list = array();
			foreach($exp_group as $group) {
				$query = $db->get('groups', array('id', '=', $group));
				$groups_list[] = $query->first()->name;
			}
			return implode(', </br>', $groups_list);
		} elseif(in_array(0,$exp_group)) { 
			// kui group on 0, returnin kõik userid
			$users_list = array();
			foreach($exp_user as $user) {
				$query = $db->get('users', array('id', '=', $user));
				$users_list[] = $query->first()->firstname . ' ' . $query->first()->lastname;
			}
			return implode(', </br>', $users_list);
		} else {
			// returnin kõik
			$users_list = array();
			foreach($exp_user as $user) {
				$query = $db->get('users', array('id', '=', $user));
				$users_list[] = $query->first()->firstname . ' ' . $query->first()->lastname;
			}
			$groups_list = array();
			foreach($exp_group as $group) {
				$query = $db->get('groups', array('id', '=', $group));
				$groups_list[] = $query->first()->name;
			}
			return implode(', </br>', array_merge($users_list, $groups_list));
		}
	}
	
	return 'Unknown';
}

/**
 * Function:	getUserGroup($id);
 * Description:	Gets user group name
 * Finish date:	27.03.2014 15:45
 * Build:		Martin
 * Updated:		Martin
*/
function getUserGroup($id) {
	$db = Database::getInstance();
	$groupid = $db->get('users', array('id', '=', $id));
	if($groupid->count()) {
		$grup = $groupid->first()->group;
		$grup_name = $db->get('groups', array('id', '=', $grup));
		return $grup_name->first()->name;
	}
	return 'Unknown';
}

/**
 * Function:	getAvatar($user_id);
 * Description:	Gets user avatar url
 * Finish date:	03.04.2014 07:16
 * Build:		Josh
 * Updated:		Josh
*/
function getAvatar($user_id) {
	$db = Database::getInstance();
	$av = $db->query("SELECT avatar FROM users WHERE id = ?", array($user_id));
	if($av->count()) {
		return $av->first()->avatar;
	}
	return false;
}

/**
 * Function:	newsPercentage($timestamp);
 * Description:	Calculates time left percentage
 * Finish date:	04.04.2014 02:10
 * Build:		Josh
 * Updated:		Josh
*/
function newsPercentage($timestamp) {
	$now = time();
	if($timestamp > $now) {
		$conf = 1.65;
		$proc = round((($timestamp-$now)/100)/$conf);
		if($proc > 65) {
			return 'time-green';
		} elseif($proc < 65 && $proc > 35) {
			return 'time-yellow';
		} elseif($proc < 35) {
			return 'time-red';
		}
	}
	return false;
}


/**
 * Function:	send($to, $subject, $message);
 * Description:	Calculates time left percentage
 * Finish date:	04.04.2014 15:46
 * Build:		Martin
 * Updated:		Martin
*/
function mail_utf8($to, $from_user, $from_email, $subject = '(No subject)', $message = '') {
  $from_user = "=?UTF-8?B?".base64_encode($from_user)."?=";
  $subject = "=?UTF-8?B?".base64_encode($subject)."?=";

  $headers = "From: $from_user <$from_email>\r\n".
		   "MIME-Version: 1.0" . "\r\n" .
		   "Content-type: text/html; charset=UTF-8" . "\r\n";

 return mail($to, $subject, $message, $headers);
}

?>