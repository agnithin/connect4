<?php
	// all functions regarding the lobby challenge are placed in this service
	
	require_once "../../dbInfoPS.inc";
	require_once('bizLayer/lobbyBiz.php');
	require_once('bizLayer/utils.php');		
	
	/*************************
	challengePlayer : adds new challenge
	***************************/	
	function challengePlayer($d, $ip, $token){
		//what should happen here?
			//we are in the service layer - so service stuff
				//token CHECK
				//data split
		//go to the data/biz layer and actually get the chat...
		//path from mid.php point of view
		list($player1, $player2) = explode("|", $d);
		return challengePlayerBiz($player1, $player2);
	}

	/*************************
	checkChallenges : checks to see if any player has challenged
	***************************/
	function checkChallenges($d, $ip, $token){
		return checkChallengesBiz($d);
	}
	
	/*************************
	acceptChallenge : accepts the challenge and gets the game id
	***************************/
	function acceptChallenge($d, $ip, $token){
		list($username, $gameId) = explode("|", $d);
		return acceptChallengeBiz($username, $gameId);
	}
	
	/*************************
	rejectChallenge : rejects the challenge
	***************************/
	function rejectChallenge($d, $ip, $token){
		list($username, $gameId) = explode("|", $d);
		return rejectChallengeBiz($username, $gameId);
	}
?>