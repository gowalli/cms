<?php

// Our MySQL implementation of the abstract database class
class MySQL extends Database {
	// Initialize the database connection
	function initialize($host, $user, $password, $database) {
		$mysqli = new mysqli($host, $user, $password, $database);
		if($mysqli->connect_errno) {
			echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

		$this->mysqli = $mysqli;
	}

	// Execute a query, returning the raw results
	function query($query, $vars = array()) {
		foreach($vars as $key => $value) {
			$value = mysqli_real_escape_string($this->mysqli, $value);
			$query = str_replace(":$key", $value, $query);
		}

		$results = $this->mysqli->query($query);
		if($results == false) {
			error_log("MySQL error (" . $this->mysqli->errno . "): " . $this->mysqli->error);
		}

		return($results);
	}

	// Execute a query, returning a single object
	function object_query($query, $vars = array()) {
		$result = $this->query($query, $vars);
		if($result->num_rows) {
			return($result->fetch_object());
		}

		return(false);
	}

	// Execute a query, returning an array of results
	function array_query($query, $vars = array()) {
		$result = $this->query($query, $vars);
		if($result->num_rows) {
			return($result->fetch_assoc());
		}

                return(false);
	}

	// Execute a query, returning an array of objects
	function object_array_query($query, $vars = array()) {
		$result = $this->query($query, $vars);
		if($result->num_rows) {
                        $array = array();
			while($object = $result->fetch_object())
				array_push($array, $object);

			if(!sizeof($array))
				return(false);

			return($array);
                }

                return(false);
	}
}

