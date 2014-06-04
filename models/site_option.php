<?php

class site_option extends DatabaseObject {
	function __construct() {
		$this->_setPrimaryKey('option_id');
	}
}
