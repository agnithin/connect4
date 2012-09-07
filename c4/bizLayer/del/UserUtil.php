<?php

function sanitizeString($string)
{
	$blacklist = array("/`/", "/'/", "/</", "/>/", '/"/', "/%/", "/\(/", "/\)/", "/\\\/", "/\//", "/\_/", "/\|/");
	$string = htmlentities($string);
	$string = strip_tags($string);
	$string = stripslashes($string);
	$string = preg_replace($blacklist, "", $string);
	$string = trim($string);
	return $string;
}

function checkLogin($username, $password)
{
	$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
	if (mysqli_connect_errno()) { 
		printf("Connect failed: %s\n", mysqli_connect_error()); 
		exit(); 
	}
	
	//echo"\nn:".$username."|p:".$password;
	$username = sanitizeString($username);
	$password = sanitizeString($password);
	$password = sha1($password);
	
	$logged_in=false;
	
	//create a prepared statement
	$sql="SELECT name FROM c4users WHERE name = ? AND password = ?";
	if($stmt = $mysqli->prepare($sql))
	{
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$stmt->bind_result($result); 
		$stmt->fetch();
		
		if($result)
		{
			$logged_in=true;
		}
		
		$stmt->close();			
	}	
	return $logged_in;
}


function setToken($username)
{	
	$ip = explode(".",$_SERVER["REMOTE_ADDR"]);
	$ip = implode("",$ip);
    $time = time();
    $token = $ip."|".$time;
    $expire = time() + 60 * 60 * 24; //24 hours from now
    //$path = "/~nxa1884/";
    //$domain = "nova.it.rit.edu";
    //setcookie("token", $token, $expire, $path, $domain);
	setcookie("token", $token, $expire);
	return $token;
}

function makeUserActive($username)
{
	$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
	if (mysqli_connect_errno()) { 
		printf("Connect failed: %s\n", mysqli_connect_error()); 
		exit(); 
	}
	
	if($stmt = $mysqli->prepare("UPDATE c4users SET Status = 1 WHERE Name = ?"))
	{	
		$stmt->bind_param("s",$username);
		$stmt->execute();
		$stmt->close();
	}
}

function registerUser($username, $password)
{
	$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
	if (mysqli_connect_errno()) { 
		return false; 		
	}
	
	//echo"\nn:".$username."|p:".$password;
	$username = sanitizeString($username);
	$password = sanitizeString($password);
	$password = sha1($password);
	
	$sql = "INSERT INTO c4users (Name, Password, Status) VALUES(?, ?, 0)";
	if($stmt = $mysqli->prepare($sql))
	{	
		$stmt->bind_param("ss",$username, $password);
		$stmt->execute();
		$stmt->close();
		return true; 
	}
	return false; 
}
?>