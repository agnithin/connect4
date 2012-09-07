<?php
/*************************
	checkLoginBiz : check if un/pw valid
*/
function checkLoginBiz($username, $password)
{
	global $mysqli;
	//echo"\nn:".$username."|p:".$password;
	$username = sanitizeString($username);
	$password = sanitizeString($password);
	$password = sha1($password);
	
	$retval['validUser']=false;
	$retval['token']="";
	$retval['username']=$username;
	
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
			$retval['validUser']=true;
			$retval['token']=generateToken($username, $_SERVER["REMOTE_ADDR"]);
		}		
		$stmt->close();			
	}
	$mysqli->close();	
	return json_encode($retval);
}

/*************************
	makeUserActiveBiz : changes status of user
*/
function makeUserActiveBiz($username)
{
	global $mysqli; 
	
	if($stmt = $mysqli->prepare("UPDATE c4users SET Status = 1 WHERE Name = ?"))
	{	
		$stmt->bind_param("s",$username);
		$stmt->execute();
		$stmt->close();
	}
	clearOldLobbyChat();
}

/*************************
	registerUserBiz : registers new user
*/
function registerUserBiz($username, $password)
{
	global $mysqli;	
	$retval['registerStatus']=false;
	$retval['username']=$username;
	
	//echo"\nn:".$username."|p:".$password;
	$username = sanitizeString($username);
	$password = sanitizeString($password);
	$password = sha1($password);
	
	$sql = "INSERT INTO c4users (Name, Password, Status) VALUES(?, ?, 0)";
	if($stmt = $mysqli->prepare($sql))
	{	
		$stmt->bind_param("ss",$username, $password);
		$stmt->execute();
				
		if($mysqli->affected_rows > 0)
			$retval['registerStatus'] = true;
		$stmt->close();
	}
	return json_encode($retval); 
}

/*************************
	clearOldLobbyChat : clears old chats
*/
function clearOldLobbyChat(){
	global $mysqli;
	//$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
    $seconds = 24 * 60 * 60;
    $cutoff = time() - $seconds;
    $cutoff = date("Y-m-d H:i:s", $cutoff);
	
	/////
	// write code to dump to text files
	////
    
    $sql = "DELETE FROM c4chat WHERE timestamp < '$cutoff'";
	if($stmt = $mysqli->prepare($sql)) 
	{
        $stmt->execute();
        $stmt->close();
    }
}

/*************************
	logoffUserBiz : logs off user
*/
function logoffUserBiz($username)
{
	global $mysqli; 
	$listOfGames = array();
	if($stmt = $mysqli->prepare("UPDATE c4users SET Status=0 WHERE Name = ?"))
	{	
		$stmt->bind_param("s",$username);
		$stmt->execute();
		$stmt->close();
	}
	
	if($stmt=$mysqli->prepare("SELECT gameId FROM c4game WHERE (status=1 OR status=0) AND (player1=? OR player2=?)")){
		$stmt->bind_param("ii", $username, $username);
		$stmt->bind_result($gameId);
		$stmt->execute();
		while($stmt->fetch()) {
			$listOfGames[] = $gameId;			
		}
		$stmt->close();
		foreach($listOfGames as $gId ){
			endGameBiz($gId);
		}		
	}
	
	$mysqli->close();
}

/*************************
	endGameBiz : called when user closes his window
	//3=player 0 won
	//4=player 1 won
	//5=player left game
*/
function endGameBiz($gameId)
{
	$status = 5;	
	global $mysqli;
	//$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
	if($stmt=$mysqli->prepare("UPDATE c4game SET status=? WHERE gameId=?")){
		$stmt->bind_param("ii",$status, $gameId);
		$stmt->execute();		
		$stmt->close();
	}
	
	//clear board data
	if($stmt=$mysqli->prepare("DELETE FROM c4board WHERE gameId=?")){
		$stmt->bind_param("i",$gameId);
		$stmt->execute();
		$stmt->close();
	}
}
?>