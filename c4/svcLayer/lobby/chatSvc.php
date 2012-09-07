<?php
	// all methots regarding chat room are in this service
	
	require_once "../../dbInfoPS.inc";
	require_once('bizLayer/lobbyBiz.php');		
	require_once('bizLayer/utils.php');
	
	//all files in my parent folder are loaded when the a=chat in the ajax call!
	
	/*************************
	chat : gets all the chats in the chat room
	***************************/
	function chat($d, $ip, $token){
		//what should happen here?
			//we are in the service layer - so service stuff
				//token CHECK
				//data split
		//go to the data/biz layer and actually get the chat...
		//path from mid.php point of view
		return getChatData($d);
	}	
	
	/*************************
	sendChat : adds a new chat message
	***************************/
	function sendChat($d, $ip, $token) {
		list($username, $message, $gameId) = explode("|", $d);
		$message = sanitizeString($message);
		if($message != '') {
			addChatData($username, $message, $gameId);
		}
	}
	
	/*************************
	getOnlineUsers : gets all the users in the chat room
	***************************/
	function getOnlineUsers($d, $ip, $token) {
		return getCurrentUsers($d);
	}
?>