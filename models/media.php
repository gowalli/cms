<?php

class media extends DatabaseObject {
	function __construct() {
		$this->_setPrimaryKey('media_id');
	}
}
