<?php        
	//database server
	define('DB_SERVER', "localhost");

	//database login name
	define('DB_USER', "");
	//database login password
	define('DB_PASS', "");

	//database name
	define('DB_DATABASE', "nxa1884");

    $mysqli=new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);             
    // where should this file be?
	if (mysqli_connect_errno()) 
	{ 
		printf("Connect failed: %s\n", mysqli_connect_error()); 
		exit(); 
	}
?>
