<?php

class site extends DatabaseObject {
	function __construct() {
		$this->_setPrimaryKey('site_id');
	}
}
