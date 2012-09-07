<?php
require "../../dbInfoPS.inc";
echo checkForWin(4, 2, 5, 1);

function checkForWin($gameId, $boardI, $boardJ, $playerId){
	//global $mysqli;
	$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
	if($stmt=$mysqli->prepare("SELECT row, col, player FROM c4board WHERE gameId=?")){
		//bind parameters for the markers (s - string, i - int, d - double, b - blob)
		$stmt->bind_param("i",$gameId);
		$stmt->execute();
		$stmt->bind_result($row, $col, $player);
		$board = array();
		for($i=-1; $i<10;$i++)
			for($j=-1; $j<10;$j++)
				$board[$i][$j] = 9;
		//$data = array();		
		while($stmt->fetch()) {
			$board[$row][$col] = $player;
		}
		//$board[$boardI][$boardJ] = 8;
		
		printBoard($board);

		
		$count = 0;
		$isWin = false;
		$newRow = $boardI;
		$newCol = $boardJ;
		
		// down
		while(true){
			//echo $newRow."|".$newCol."=".$board[$newRow][$newCol]."<br />";
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
		echo ("count:$count<br />");
		// right
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
		echo ("count:$count<br />");
		//left
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
		echo ("count:$count<br />");	
		return $isWin; 
	}
}

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
?>