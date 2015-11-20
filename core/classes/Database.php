<?php
class Database {
	private static $_instance = null;
	private $_pdo,
		    $_query,
  		    $_error = false,
    	    $_results,
	        $_count = 0;

	private function __construct() {
		try {
			$this->_pdo = new PDO('mysql:host=' . Config::get('mysql/hostname') . ';dbname=' . Config::get('mysql/database') . ';charset=utf8', Config::get('mysql/username'), Config::get('mysql/password'));
		} catch(PDOException $e) {
			die($e->getMessage());
		}
	}

	public static function getInstance() {
		if(!isset(self::$_instance)) {
			self::$_instance = new Database();
		}
		return self::$_instance;
	}
	
	public function query_assoc($sql, $params = array()) {
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)){
			if(count($params)) {
				$counter = 1;
				foreach($params as $param) {
					$this->_query->bindValue($counter, $param);
					$counter++;
				}
			}
			if($this->_query->execute()) {
				$this->_results = $this->_query->fetchAll(PDO::FETCH_ASSOC);
				$this->_count = $this->_query->rowCount();
			} else {
				$this->_error = true;
			}
		}
		return $this;
	}

	public function query($sql, $params = array()) {
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)){
			if(count($params)) {
				$counter = 1;
				foreach($params as $param) {
					$this->_query->bindValue($counter, $param);
					$counter++;
				}
			}
			if($this->_query->execute()) {
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
			} else {
				$this->_error = true;
			}
		}
		return $this;
	}

	public function action($action, $table, $where = array()) {
		if(count($where) === 3){
			$operators = array('=', '>', '<', '<=', '>=');
			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];
			if(in_array($operator, $operators)) {
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				if(!$this->query($sql, array($value))->error()) {
					return $this;
				}
			}
		}
		return false;
	}

	public function get($table, $where) {
		return $this->action('SELECT *', $table, $where);
	}

	public function delete($table, $where) {
		return $this->action('DELETE', $table, $where);
	}


	/****************************************************** 
	*				  - Inserting MySQL -                 *
	******************************************************/
	public function insert($table, $fields = array()) {
		if(count($fields)) {
			$keys    = array_keys($fields);
			$values  = null;
			$counter = 1;

			foreach($fields as $field) {
				$values .= "?";
				if($counter < count($fields)) {
					$values .= ', ';
				}
				$counter++;
			}

			$sql = "INSERT INTO {$table} (`" . implode('`, `',$keys) . "`) VALUES ({$values})";
			
			if(!$this->query($sql, $fields)->error()){
				return true;
			}
		}
		return false;
	}


	/****************************************************** 
	*				   - Updating MySQL -                 *
	******************************************************/
	public function update($table, $where, $val, $fields) {
		$set 	 = '';
		$counter = 1;

		foreach($fields as $name => $value) {
			$set .= "`{$name}` = ?";
			if($counter < count($fields)){
				$set .= ", ";
			}
			$counter++;
		}

		$sql = "UPDATE {$table} SET {$set} WHERE {$where} = '{$val}'";
		
	
		if(!$this->query($sql, $fields)->error()){
			return true;
		}
		return false;
	}

	/****************************************************** 
	*				   - MySQL results -                  *
	******************************************************/
	public function results() {
		return $this->_results;
	}

	public function error() {
		return $this->_error;
	}

	public function count() {
		return $this->_count;
	}

	public function first() {
		return $this->_results[0];
	}

}
?>