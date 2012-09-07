<?php
// all methods called in the game page are included in this service

//error_reporting (E_ALL);
require "./bizLayer/gameBiz.php";
require_once('bizLayer/utils.php');
require "../../dbInfoPS.inc";//to use we need to put in: global $mysqli;
//Why include the database stuff here?  (not doing any db stuff in the service layer!)
//because it forces all to go through the service layer in order to get to the bizLayer
//if someone tries to access the bizLayer on it's own the code will fail since there isn't a connection!


/*************************
	start
	takes: gameId
	uses in bizLayer: gameBiz.php->startData
	returns:	gameInfo	
*/
function start($d){
	//Should they be here?  (check)
	//if true:
	return startData($d);
}

/*************************
	changeTurn
	takes: gameId
	uses in bizLayer: gameBiz.php->changeTurnData
	returns:	Nothing
*/
function changeTurn($d){
	//can they change the turn?
	//if true:
	changeTurnData($d);
}

/*************************
	checkTurn
	takes: gameId
	uses in bizLayer: gameBiz.php->checkTurnData
	returns:	whoseTurn
				[{"whoseTurn":1}]
*/
function checkTurn($d){
	//Can they check is it my turn yet?
	//if true:
	return checkTurnData($d);
	
}

/*************************
	changeBoard
	takes: gameId~pieceId~boardI~boardJ~playerId
	uses in bizLayer: gameBiz.php->changeBoardData
	returns:	Nothing
*/
function changeBoard($d){
	//can they change the board?
	//if true:
	//split the data  //data: gameId~pieceId~boardI~boardJ~playerId
							//38~piece_1|10~4~6~1
	$h=explode('~',$d);
	//changeBoardData($gameId,$pieceId,$boardI,$boardJ,$playerId);
	changeBoardData($h[0],$h[1],$h[2],$h[3],$h[4]);
}

/*************************
	getMove
	takes: gameId
	uses in bizLayer: gameBiz.php->getMoveData
	returns:	gameInfo	
*/
function getMove($d){
	//if it is my turn and I should be here, get the other players move	
	return getMoveData($d);
}
?>