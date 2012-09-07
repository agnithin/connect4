<?php
//if we have gotten here - we know:
//-they have permissions to be here
//-we are ready to do something with the database
//-method calling these are in the svcLayer
//-method calling specific method has same name droping 'Data' at end checkTurnData() here is called by checkTurn() in svcLayer
//-include of db info happens in the service layer to force users to go through that layer (if they try to access methods in here without it there will be no db connection!)

/*************************
	startData	
*/
function startData($gameId){
	global $mysqli;
	
	/* Why is this done ???
	//return $gameId.'sdf';
	//simple test for THIS 'game' - resets the last move and such to empty
	if($stmt=$mysqli->prepare("UPDATE checkers_games SET player0_pieceID=null, player0_boardI=null, player0_boardJ=null, player1_pieceID=null, player1_boardI=null, player1_boardJ=null WHERE game_id=?")){
		//bind parameters for the markers (s - string, i - int, d - double, b - blob)
		$stmt->bind_param("i",$gameId);
		$stmt->execute();
		$stmt->close();
	} */
	//get the init of the game
	if($stmt=$mysqli->prepare("SELECT * FROM c4game WHERE gameId=?")){
		//bind parameters for the markers (s - string, i - int, d - double, b - blob)
		$stmt->bind_param("i",$gameId);
		$data=returnJson($stmt);
		$mysqli->close();
		return $data;
	}
}
/*************************
	checkTurnData
*/
function checkTurnData($gameId){
	global $mysqli;
	if($stmt=$mysqli->prepare("SELECT whoseTurn, status FROM c4game WHERE gameId=?")){
		//bind parameters for the markers (s - string, i - int, d - double, b - blob)
		$stmt->bind_param("i",$gameId);
		$data=returnJson($stmt);
		$mysqli->close();
		return $data;
	}
}
/*************************
	changeTurnData
*/
function changeTurnData($gameId){
	global $mysqli;
	//ugly, but toggle the turn (if the turn was 0, then make it 1, else make it 0)
	if($stmt=$mysqli->prepare("UPDATE c4game SET whoseTurn='2' WHERE gameId=? AND whoseTurn='0'")){
		$stmt->bind_param("i",$gameId);
		$stmt->execute();
		$stmt->close();
	}
	if($stmt=$mysqli->prepare("UPDATE c4game SET whoseTurn='0' WHERE gameId=? AND whoseTurn='1'")){
		$stmt->bind_param("i",$gameId);
		$stmt->execute();
		$stmt->close();
	}
	if($stmt=$mysqli->prepare("UPDATE c4game SET whoseTurn='1' WHERE gameId=? AND whoseTurn='2'")){
		$stmt->bind_param("i",$gameId);
		$stmt->execute();
		$stmt->close();
	}
	$mysqli->close();
}

/*************************
	changeBoardData
*/
function changeBoardData($gameId, $pieceId, $boardI, $boardJ, $playerId){
	//update the board
	global $mysqli;
	/*if($stmt=$mysqli->prepare("UPDATE checkers_games SET player".$playerId."_pieceId=?, player".$playerId."_boardI=?, player".$playerId."_boardJ=? WHERE game_id=?")){
		$stmt->bind_param("siii",$pieceId,$boardI,$boardJ,$gameId);
		$stmt->execute();
		$stmt->close();
	}*/
	//double check to see if there is already a piece at the particular postion
	if($stmt=$mysqli->prepare("SELECT pieceId FROM c4board WHERE gameId=? AND row=? AND col=?")){
		$stmt->bind_param("iii", $gameId, $boardI, $boardJ);
		$stmt->bind_result($result); 
		$stmt->execute();
		$stmt->fetch();
	}
	//check for result
	if($result){ // if there is already a peice in that location donot insert
	}else{	
		$sql = "INSERT INTO c4board (gameId, row, col, player, pieceId) VALUES(?, ?, ?, ?, ?)";
		if($stmt=$mysqli->prepare($sql)){
			$stmt->bind_param("iiiss",$gameId, $boardI,$boardJ, $playerId, $pieceId);
			$stmt->execute();
			$stmt->close();
		}
	}
	//after inserting check for game over condition
	if(checkForWin($gameId, $boardI, $boardJ, $playerId))
	{
		gameOver($gameId, $playerId);
	}
	
	$mysqli->close();
}
/*************************
	getMoveData
*/
function getMoveData($gameId){
	global $mysqli;
	if($stmt=$mysqli->prepare("SELECT * FROM c4board WHERE gameId=?")){
		//bind parameters for the markers (s - string, i - int, d - double, b - blob)
		$stmt->bind_param("i",$gameId);
		$data=returnJson($stmt);
		$mysqli->close();
		return $data;
	}
}

/************************************** my functions */
/*************************
	checkForWin ; checks for winning condition
*/
function checkForWin($gameId, $boardI, $boardJ, $playerId){
	global $mysqli;
	//$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
	if($stmt=$mysqli->prepare("SELECT row, col, player FROM c4board WHERE gameId=?")){
		//bind parameters for the markers (s - string, i - int, d - double, b - blob)
		$stmt->bind_param("i",$gameId);
		$stmt->execute();
		$stmt->bind_result($row, $col, $player);
		$board = array();
		
		// create a blank board;
		// i am creating a blank board of 10X10;  since the game board is just 7X7 i wont face any problem; but not ideal for future enhancements
		// need to remove this and make it dynamic(ie. max of row/col from table)
		for($i=-1; $i<10;$i++)
			for($j=-1; $j<10;$j++)
				$board[$i][$j] = 9; // some random number other that 0 or 1; 9 means the position is unoccupied
				
		//$data = array();
		// fill the occupied positions with the player ids		
		while($stmt->fetch()) {
			$board[$row][$col] = $player;
		}
		//$board[$boardI][$boardJ] = 8;
		
		/*
		sample board will look like this
		9 9 9 9 9
		9 9 9 9 9 
		9 0 1 0 0
		1 1 0 1 0
		
		1-> where player 1 pieces are there
		0-> where player 0 pieces are there
		9-> unoccupied
		
		Now what we need to do is find 4 consicutive 1's or 0's
		what the function does is takes the last dropped piece and checks if ther are 4 consicutinve pieces.
		
		*/		
		
		//printBoard($board);		
		$count = 0;
		$isWin = false;
		$newRow = $boardI;
		$newCol = $boardJ;
		
		// check if makes 4 in the downward direction
		while(true){
			if($board[++$newRow][$newCol] == $playerId)
			{				
				if(++$count >2)
				{
					$isWin = true;
					break;
				}
			}else{
				break;
			}
		}
		
		// check if makes 4 in the right direction
		$count=0;
		$newRow = $boardI;
		$newCol = $boardJ;
		while(true){
			if($board[$newRow][++$newCol] == $playerId)
			{
				if(++$count >2)
				{
					$isWin = true;
					break;
				}
			}else{
				break;
			}
		}
		
		// check if makes 4 in the left direction
		$count=0;
		$newRow = $boardI;
		$newCol = $boardJ;
		while(true){
			if($board[$newRow][--$newCol] == $playerId)
			{
				if(++$count >2)
				{
					$isWin = true;
					break;
				}
			}else{
				break;
			}
		}		

		// check if makes 4 in the diagonal bottom Left direction
		$count=0;
		$newRow = $boardI;
		$newCol = $boardJ;
		while(true){
			if($board[++$newRow][--$newCol] == $playerId)
			{
				if(++$count >2)
				{
					$isWin = true;
					break;
				}
			}else{
				break;
			}
		}
		
		// check if makes 4 in the diagonal bottom right direction
		$count=0;
		$newRow = $boardI;
		$newCol = $boardJ;
		while(true){
			if($board[++$newRow][++$newCol] == $playerId)
			{
				if(++$count >2)
				{
					$isWin = true;
					break;
				}
			}else{
				break;
			}
		}
		
		return $isWin; 
	}
}

/*************************
	printBoard : function for testing purposes; draws a board in a table
*/
function printBoard($board){
	//print_r($board);
	echo "<table border='1'><tr><td></td>";
	for($i=-1; $i<10;$i++)
		echo "<td><b>$i</b></td>";
	echo "</tr>";	
	for($i=-1; $i<10;$i++)
	{	
		echo "<tr><td><b>$i</b></td>";
		for($j=-1; $j<10;$j++)		
			echo "<td> ".$board[$i][$j]." </td>";
		echo "</tr>";				
	}
	echo "</table><br /><br/>";
}

/*************************
	gameOver;  set status of the game as 3 or 4
	//3=player 0 won
	//4=player 1 won
	//5=player left game
*/
function gameOver($gameId, $playerId)
{
	$playerId = $playerId+3;
	global $mysqli; 
	//$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
	if($stmt=$mysqli->prepare("UPDATE c4game SET status=? WHERE gameId=?")){
		$stmt->bind_param("ii",$playerId, $gameId);
		$stmt->execute();
		$stmt->close();
	}
}
?>