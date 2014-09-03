<?php
class Homemodel extends CI_Model {
	
	public function setValue($val){
		$this->value = $val;
	}
	
	private function getValue(){
		return $this->value;
	}
}
?>