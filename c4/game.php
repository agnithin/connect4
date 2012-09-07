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
	if(!isset($_GET['gameId']) || !isset($_GET['player'])){
		header("location: lobby.php");
	}	
	header('Content-type: application/xhtml+xml');
	//HAVE TO echo this out - if not php short open tags will try to parse
	echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<!--Check out: http://developer.mozilla.org/en/docs/SVG_in_Firefox -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
          "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Connect 4 : Game</title>
	<link rel="stylesheet" href="./_styles/gamePage.css" type="text/css" />
	<link rel="stylesheet" href="./_styles/common.css" type="text/css" />
	<link rel="stylesheet" href="./_styles/fonts.css" type="text/css" />
	<link type="text/css" href="_styles/redmond/jquery-ui-1.8.12.custom.css" rel="stylesheet" />
    <script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="js/jquery-ui-1.8.12.custom.min.js" type="text/javascript"></script>
	<script src="js/Objects/Cell.js" type="text/javascript"></script>
	<script src="js/Objects/Piece.js" type="text/javascript"></script>
	<script src="js/gameFunctions.js" type="text/javascript"></script>
	<script src="js/commonFunctions.js" type="text/javascript"></script>
	<script src="js/ajaxFunctions.js" type="text/javascript"></script>
	<script src="js/cookies.js" type="text/javascript"></script>
	<script type="text/javascript">
		<![CDATA[
			var gameId=<?php echo $_GET['gameId'] ?>; 
			//var player="<?php echo $_GET['player']?>"; // change this to session var
			var player = GetCookie('username');
			var username = player; // reqired for commonFunctions.js
			initGame('start', gameId);
			$(document).ready(function(){
				$("#userMsg").html("Welcome <b>" + player + "</b>");
				getChat();
			});
		]]>
	</script>

</head>
<body onbeforeunload="logoffUserAjax(player);">
	<header>
		<h2>CONNECT 4</h2>
	</header>
	<div id="content">
		<div id="userBar"><span id="userMsg"></span><button id="logout" style="float:right" onclick="logoffUserAjax(player);">Logout</button></div>
			<svg xmlns="http://www.w3.org/2000/svg"  xmlns:xlink="http://www.w3.org/1999/xlink"
				version="1.1"  width="650px" height="620px">

				<!-- Make the background -> 800x600 -->
				<rect x="0px" y="0px" width="100%" height="100%" id="background" />

				<text x="270px" y="20px" id="nyt" fill="red" display="none">
					NOT YOUR TURN!
				</text>
				<text x="270px" y="20px" id="nyp" fill="red" display="none">
					NOT YOUR PIECE!
				</text>
				<text x="50px" y="20px" id="output2">
				</text>
			</svg>
			<div id="chat">
				<h3>Chat</h3>
				<div id="chatLog"></div>
				<div id="addChat">
					<input type="text" size="23" id="newChat" />
					<input type="button" value="Send" onclick="sendChat();" /> 
				</div>
			</div>
		</div>	

		<div id="dialog-message-gameover" title="Download complete" style="display:none">
			<p>
				<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
				<span id="gameOverText">Game Over</span>
			</p>
		</div>
		<div id="dialog-message-opponentLeft" title="Opponent Missing" style="display:none">
			<p>
				<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
				<span id="gameOverText">Your opponent has left the game.</span>
			</p>
		</div>
			<div id="dialog-message-noChatText" title="Download complete" style="display:none">
		<p>
			<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
			Please enter some message.
		</p>
	</div>
	<footer>Copyright &#169; 2011. Nithin Anand Gangadharan. All rights reserved.</footer>
</body>
</html>