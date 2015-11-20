<?php
class Input {
	public static function exists($type = 'post') {
		switch($type) {
			case 'post':
				return (!empty($_POST)) ? true : false;
			break;
			
			case 'get':
				return (!empty($_GET)) ? true : false;
			break;

			default: 
				return false;
			break;
		}
	}

	public static function get($item,$item2 = null) {
		if(isset($_POST[$item])) {
			return $_POST[$item];			
		} else if(isset($_FILES[$item][$item2])) {
			return $_FILES[$item][$item2];
		} else if(isset($_GET[$item])) {
			return $_GET[$item];
		}
		return '';
	}
}
?>