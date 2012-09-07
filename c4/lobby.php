<?php 
	session_start();
	include "./bizLayer/utils.php";
	if(!isset($_COOKIE['username']) || !isset($_COOKIE['token'])){
		header("location: login.php");
	}
	if(!validateToken($_COOKIE['username'], $_SERVER['REMOTE_ADDR'], $_COOKIE['token']))
	{
		header("location: login.php");
	}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Connect 4 : Lobby</title>
	<link type="text/css" href="_styles/lobbyPage.css" rel="stylesheet" />
	<link type="text/css" href="_styles/common.css" rel="stylesheet" />
	<link rel="stylesheet" href="./_styles/fonts.css" type="text/css" />
	<link type="text/css" href="_styles/redmond/jquery-ui-1.8.12.custom.css" rel="stylesheet" />
    <script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="js/jquery-ui-1.8.12.custom.min.js" type="text/javascript"></script>
	<script src="js/ajaxFunctions.js" type="text/javascript"></script>
	<script src="js/lobbyFunctions.js" type="text/javascript"></script>
	<script src="js/commonFunctions.js" type="text/javascript"></script>
	<script src="js/cookies.js" type="text/javascript"></script>
    <script>
	//var username = '<?php //echo $_SESSION['username']; ?>';
	var username = GetCookie('username');
	var gameId=0; 
	
    //working here:  http://nova.it.rit.edu/~dsbics/arch/
	$(document).ready(function(){
		getChat(); // get new chats
		getOnlineUsers(); // get list of users
		checkChallenges(); // check if anyone has challenged you
		
		$( "#newChat" ).bind( 'keypress', function( event ) {
		  if( event.which == 13 ) {
			sendChat(); // add chat
		  }
		});
		
		$("#userMsg").html("Welcome <b>" + username + "</b>");
		$( "#dialog:ui-dialog" ).dialog( "destroy" ); // jquery ui for some ie bug
		//$( "input:button", "#addChat").button();
     });
    </script>
  </head>
  <body onbeforeunload="logoffUserAjax(username);">
 	<header>
		<h2>CONNECT 4</h2>
	</header>
	<div id="content">
		<div id="userBar"><span id="userMsg"></span><button id="logout" style="float:right" onclick="logoffUserAjax(username);this.disabled=true;">Logout</button></div>
		<div id="leftBar">
			<h3>Lobby Chat</h3>
			<div id="chatLog"></div>
			<div id="addChat">
				<input type="text" size="53" id="newChat">
				<input type="button" Value="Send" onclick="sendChat();">
			</div>
		</div>		
		<div id="rightBar">
			<h3>Online Users</h3>
			<div id="userList"></div>
		</div>
	</div>
	<div id="dialog-confirm-makeChallenge" title="Challenge Player?" style="display:none">
		<p>
			<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
			Do you want to challenge the player for a game?
		</p>
	</div>
	<div id="dialog-message-noChatText" title="Download complete" style="display:none">
		<p>
			<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
			Please enter some message.
		</p>
	</div>
	<div id="dialog-confirm-acceptChallenge" title="Accept Challenge?" style="display:none">
		<p>
			<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
			You have be challenged by <b><span id="challenger"></span></b>. Do you want to accept the challenge?
		</p>
	</div>
	<div id="dialog-message-challengeRejected" title="Challenge Regected" style="display:none">
		<p>
			<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
			Your challenge was rejected.
		</p>
	</div>

	<footer>Copyright © 2011. Nithin Anand Gangadharan. All rights reserved.</footer>
  </body>
</html>