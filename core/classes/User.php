<?php
class User {
	private $_db, $_data, $_sessionName, $_isLoggedIn, $_cookieName;
	
	public function __construct($user = null) {
		$this->_db = Database::getInstance();
		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');
		
		if(!$user) {
			if(Session::exists($this->_sessionName)) {
				$user = Session::get($this->_sessionName);

				if($this->find($user)) {
					$this->_isLoggedIn = true;
				}
			}
		} else {
			$this->find($user);
		}
	}
	
	public function create($fields = array()) {
		if(!$this->_db->insert('users', $fields)) {
			throw new Exception("Error in creating an account.");
		}
	}
	
	public function find($user = null) {
		if($user) {
			$field = (is_numeric($user)) ? 'id' : 'username';
			$data = $this->_db->get('users', array($field, '=', $user));
			
			if($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}
	
	public function logout() {
	
		$this->_db->delete('users_session', array('user_id', '=', $this->data()->id));
	
		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
	}
	
	public function update($fields = array(), $id = null) {
	
		if(!$id && $this->isLoggedIn()) {
			$id = $this->data()->id;
		} 
	
		if(!$this->_db->update('users', 'id', $id, $fields)) {
			throw new Exception("Kasutajat ei saanud muuta.");
		}
	}
	
	public function login($username = null, $password = null, $remember = false) {		
		if(!$username && !$password && $this->exists()) {
			Session::put($this->_sessionName,  $this->data()->id);
			$URI = $_SERVER['REQUEST_URI'];
			Redirect::to(Config::get('misc/base-url').$URI);
		} else {
			$user = $this->find($username);
			if($user) {
				$salt = utf8_decode($this->data()->salt);
				if($this->data()->password === Hash::make($password, $salt)) {
					Session::put($this->_sessionName, $this->data()->id);
					if($remember) {
						$hash = Hash::unique();
						$hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));
						if(!$hashCheck->count()) {
							$this->_db->insert('users_session', array(
								'user_id' => $this->data()->id,
								'hash' => $hash
							));
						} else {
							$hash = $hashCheck->first()->hash;
						}
						Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
					}
					return true;
				}
			}
		}	
		return false;
	}
	
	public function data() {
		return $this->_data;
	}
	
	public function exists() {
		return (!empty($this->_data)) ? true : false;
	}
	
    public function isLoggedIn() {
		return $this->_isLoggedIn;
	}
	
	public function hasPermissions($key) {
		$group = $this->_db->get('groups', array('id', '=', $this->data()->group));
		
		if($group->count()) {
			$permissions = json_decode($group->first()->permissions, true);
			
			if($permissions[$key] == true) {
				return true;
			}
		}
		return false;
	}
	
	public function listItems($item) {
		$query = $this->_db->query("SELECT * FROM {$item}");
		if($query->count()) {
			$name = $query->results();
			return $name;
		}
		return false;
	}
	
	public function getGroup() {
		$group = $this->_db->get('groups', array('id', '=', $this->data()->group));
		
		if($group->count()) {
			$name = $group->first()->name;
			return $name;
		}
		return false;
	}
	
	public function getGroupNameByUser($userid) {
		$group = $this->_db->query("SELECT group FROM users WHERE id='$userid'");
		$this->getGroupNameByID(2);
	}
	
	public function getGroupNameByID($groupid) {
		$group = $this->_db->get('groups', array('id', '=', $groupid));
		$name = $group->first()->name;
		return $name;
	}
	
}

?>