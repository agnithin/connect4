<?php
/*********************************Utilities*********************************/
// functions common to all biz layer files

/*************************
	returnJson
	takes: prepared statement
		-parameters already bound
	returns: json encoded multi-dimensional associative array
*/
function returnJson ($stmt){
	//echo $stmt;
	$stmt->execute();
	$stmt->store_result();
 	$meta = $stmt->result_metadata();
    $bindVarsArray = array();
	//using the stmt, get it's metadata (so we can get the name of the name=val pair for the associate array)!
	while ($column = $meta->fetch_field()) {
    	$bindVarsArray[] = &$results[$column->name];
    }
	//bind it!
	call_user_func_array(array($stmt, 'bind_result'), $bindVarsArray);
	//now, go through each row returned,
	$data = array();
	while($stmt->fetch()) {
    	$clone = array();
        foreach ($results as $k => $v) {
        	$clone[$k] = $v;
        }
        $data[] = $clone;
    }
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	//MUST change the content-type
	header("Content-Type:text/plain");
	// This will become the response value for the XMLHttpRequest object
    return json_encode($data);
}

/*************************
	sanitizeString
*/
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

/*************************
	generateToken: generate a 2 way hash token from IP and username; 
	really basic implementation fo a token
*/
function generateToken($username, $ip)
{	
	$ip = explode(".",$ip);
	$ip = implode("",$ip);
    $time = time(); // removing time because
	$salt = "THEMATRIX";
	
	$token = $username | $ip;
	$token = $token & $salt;
	
    //$token = base64_encode($ip."|".$username."|".$time);
	$token = base64_encode($token."|".$time);
	
	return $token;
}

/*************************
	validateToken : check if the token matches with user IP and username
*/
function validateToken($username, $ip, $token)
{
	$ip = explode(".",$ip);
	$ip = implode("",$ip);
    $time = time(); // removing time because
	$salt = "THEMATRIX";
	
	$gen_token = $username | $ip;
	$gen_token = $gen_token & $salt;
	
	$token = base64_decode($token);
	@list($firstPartofToken, $tok_time) = explode("|", $token);
	
	if($firstPartofToken == $gen_token)
	{
		return true;
	}else{
		return false;
	}
	
	/*$token = base64_decode($token);
	list($tok_ip, $tok_username, $tok_time) = explode("|", $d);
	
	$ip = explode(".",$ip);
	$ip = implode("",$ip);
	
	if($tok_ip == $ip && $tok_username == $username)
	{
		return true;
	}else{
		return false;
	}*/

}