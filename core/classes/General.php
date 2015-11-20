<?php
class General {	
	public $_db;
	public function __construct() {
	$this->_db = DB::getInstance();	}
	public static function base_url() {
		if(Config::get('config/base_url')) {
			return Config::get('config/base_url');
		}
		$url = "http://".$_SERVER['HTTP_HOST'];
		$url .= preg_replace('@/+$@','',dirname($_SERVER['SCRIPT_NAME'])).'/';
		return $url;
	}
}
?>