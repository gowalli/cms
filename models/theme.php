<?php

class theme extends DatabaseObject {
	function __construct() {
		$this->_setPrimaryKey('theme_id');
	}

	function load($conf) {
		$theme_data = json_decode(file_get_contents($conf));
	}
}
