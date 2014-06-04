<?php

class user extends DatabaseObject {
	function __construct() {
		$this->_setPrimaryKey('user_id');
	}
}
