<?php

class Database {

	// Function to create the tables and fill them with the default data
	function create_tables($data)
	{
		// Connect to the database
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);

		// Check for errors
		if(mysqli_connect_errno())
			return false;

		// Open the default SQL file
		$query = file_get_contents('cache/install.sql');

		// Execute a multi query
		$mysqli->multi_query($query);

		// Close the connection
		$mysqli->close();

		return true;
	}
}