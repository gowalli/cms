<?php

class page extends DatabaseObject {
	function __construct() {
		$this->_setPrimaryKey('page_id');
	}

	static function load() {
		// First we need to parse the path we're on
                $url = parse_url(
                        (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' .         // Scheme
                        $_SERVER['HTTP_HOST'] .                                         // Hostname
                        $_SERVER['REQUEST_URI']                                         // Path and query string
                );

		// Break the current path into parts
		$path = trim($url['path'], "/");
		$path_parts = explode('/', $path);

		// If there's nothing in the path, load the home page
		$page = false;
		if(!strlen(@$path_parts[0])) {
			$page = Page::fetch(array('is_home' => 1));
		}
		else {
			// Otherwise, we need to do some more complex stuff
		}

		// Now we either have a page, or not
		return($page);
	}
}
