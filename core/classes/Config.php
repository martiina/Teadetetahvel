<?php
class Config {
	public static function get($path = null) {
		if($path) {
			$config = $GLOBALS['settings'];
			$path = explode('/', $path);
			foreach($path as $bit) {
				if(isset($config[$bit])){
					$config = $config[$bit];
				}
			}
			return $config;
		}
	}
}
?>