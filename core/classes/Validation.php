<?php
class Validation {
	private $_passed = false,
			$_errors = array(),
			$_db = null;
			
	public function __construct() {
		$this->_db = Database::getInstance();
	}
	public function check($source, $items = array()) {
		foreach($items as $item => $rules) {
			$value = trim($source[$item]);
			$alias = $item;

			foreach($rules as $rule => $rule_value) {
			
				if(isset($rules['alias'])) {
					$alias = $rules['alias'];
				}
				$alias = escape(ucfirst($alias));
				
				if($rule === 'required' && empty($value)) {
					$this->addError("{$alias} on kohustuslik!");
				} elseif(!empty($value)) {
					switch($rule) {
						case 'min':
							if(strlen($value) < $rule_value) {
								$this->addError("{$alias} peab olema vähemalt {$rule_value} tähemärki.");
							}
						break;
						case 'max':
							if(strlen($value) > $rule_value) {								
								$this->addError("{$alias} ei tohi ületada {$rule_value} tähemärki.");
							}
						break;
						case 'matches':
							if($value != $source[$rule_value]) {
								$this->addError("{$alias} ei kattu!");
							}
						break;
						case 'unique':
							$check = $this->_db->get($rule_value, array($item, '=', $value));
							if($check->count()) {
								$this->addError("{$alias} on juba kasutusel.");
							}
						break;
						case 'valid_email':
							if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
								$this->addError("Palun sisesta korrektne email.");
							}
						break;
						case 'check_spam':
							if(!empty($value)) {
								$this->addError("Spam tuvastatud! Barm-Barm");
							}
						break;
					}
				}
			}
		}
		if(empty($this->_errors)) {
			$this->_passed = true;
		}
		return $this;
	}
	private function addError($errors) {
		$this->_errors[] = $errors;
	}
	public function errors() {
		return $this->_errors;
	}
	public function passed() {
		return $this->_passed;
	}
}
?>