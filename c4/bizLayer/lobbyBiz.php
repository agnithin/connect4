<?php

	function getChatData($gameId)
	{
		global $mysqli;
		$returnJson = "";

		/* Send a query to the server */ 
		//$sql = "SELECT u.name, lc.* FROM c4users u INNER JOIN c4lobbyChat lc ON u.id=lc.userId";
		$sql = "SELECT userId, message, timestamp FROM c4chat WHERE gameId=? ORDER BY timestamp";
		if ($stmt = $mysqli->prepare($sql)) { 
			$stmt->bind_param('i', $gameId);
			$stmt->execute();
			$stmt->bind_result($userId, $message, $timestamp);
			
			$chatArr = array();
			/* Fetch the results of the query */ 
			while($stmt->fetch() ){ 
				//printf("%s (%s)<br />\n", $row['userId'], $row['message']); 
				$tChat['name'] = $userId;
				$tChat['message'] = $message;
				$tstamp = strtotime($timestamp);				
				$tChat['timeStamp'] = date("h:i a", $tstamp);
				$chatArr[] = $tChat;				
			} 
			$returnJson = json_encode($chatArr);

			/* Destroy the result set and free the memory used for it */ 
			$stmt->close();
			$mysqli->close();
		} 		
		return $returnJson;
	}
	
	function addChatData($username, $message, $gameId)
	{
		global $mysqli; 
		/* Send a query to the server */ 
		if ($stmt = $mysqli->prepare("INSERT INTO c4chat (userId, message, timestamp, gameId)VALUES(?, ?, CURRENT_TIMESTAMP, ?)")) { 

			$stmt->bind_param('ssi', $username, $message, $gameId);
			$stmt->execute();
			$affected_rows = $stmt->affected_rows;
			$stmt->close();
			return $affected_rows;
		} 		
		return false;
	}
	
	function getCurrentUsers($d)
	{
		global $mysqli;
		$retval = "";		
		$sql = "SELECT id, name, status FROM c4users WHERE status = 1 AND Name <> ?";
		if ($stmt = $mysqli->prepare($sql)) { 
			$stmt->bind_param('s', $d);
			$retval=returnJson($stmt);
			/*$stmt->execute();
			$stmt->bind_result($id, $name, $status);
			
			$usersArr = array();
			// Fetch the results of the query  
			while( $stmt->fetch()){ 
				$tUsers['id'] = $id;
				$tUsers['name'] = $name;
				$tUsers['status'] = $status;
				$usersArr[] = $tUsers;				
			} 
			$returnJson = json_encode($usersArr);
			*/
			//Destroy the result set and free the memory used for it 
			$stmt->close();
			$mysqli->close();			
		} 		
		return $retval;		
	}
	
	function challengePlayerBiz($player1, $player2)
	{
		global $mysqli;
		$returnValue['gameId'] = 0;
		
		$sql = "INSERT INTO c4game (player1, player2, whoseTurn, status) VALUES (?, ?, ?, ?)";
		if ($stmt = $mysqli->prepare($sql))
		{	
			$stmt->bind_param('sssi', $player1, $player2, $turn, $status); 

			$turn = 0; 
			$status = 0; 

			/* execute prepared statement */ 
			$stmt->execute();
			$returnValue['gameId'] = $mysqli->insert_id;
		}		
		return json_encode($returnValue);
	
	}
	
	function checkChallengesBiz($d)
	{
		global $mysqli;
		$challengeDetails['gameId'] = 0;
		// status
		// 0 = new challengeDetails
		// 1 = challenge accepted
		// -1 = challenge rejected
		// 3 = game done won by player 1
		// 4 = game done won by player 2
		$sql = "SELECT gameId, player1 FROM c4game WHERE status = 0 AND player2 = ?";
		if ($stmt = $mysqli->prepare($sql)) { 

			$stmt->bind_param('s', $d);
			$stmt->execute();
			$stmt->bind_result($gameId, $player1);
			
			$usersArr = array();
			/* Fetch the results of the query */ 
			if( $stmt->fetch()){ 
				$challengeDetails['gameId'] = $gameId;
				$challengeDetails['player1'] = $player1;
			}

			/* Destroy the result set and free the memory used for it */ 
			$stmt->close(); 
		} 		
		return json_encode($challengeDetails);		
	}
	
	function acceptChallengeBiz($username, $gameId)
	{
		global $mysqli;
		$returnValue['gameId'] = 0;
		
		$sql = "UPDATE c4game SET status = 1 WHERE gameId=? AND player2 = ?";
		if ($stmt = $mysqli->prepare($sql))
		{	
			$stmt->bind_param('ss', $gameId, $username); 

			/* execute prepared statement */ 
			$stmt->execute();
			$returnValue['gameId'] = $gameId;
		}		
		return json_encode($returnValue);	
	}
	
	function rejectChallengeBiz($username, $gameId)
	{
		global $mysqli;
		$returnValue['gameId'] = 0;
		
		$sql = "UPDATE c4game SET status = -1 WHERE gameId=? AND player2 = ?";
		if ($stmt = $mysqli->prepare($sql))
		{	
			$stmt->bind_param('ss', $gameId, $username); 

			/* execute prepared statement */ 
			$stmt->execute();
			$returnValue['gameId'] = -1;
		}		
		return json_encode($returnValue);	
	}
?>