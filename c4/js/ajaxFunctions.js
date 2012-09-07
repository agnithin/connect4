//ajax util
//d is data sent, looks like {name:value,name2:val2}
function ajaxCall(GetPost,d,callback){
	$.ajax({
 		type: GetPost,
 		async: true,
  		cache:false,
  		url: "mid.php",
  		data: d,  
  		dataType: "json",
  		success: callback
	});
}

//this is my starter call
//goes out and gets all pertinant information about the game (FOR ME)
function initGame(whatMethod,val){
	//data is gameId
	ajaxCall("GET",{method:whatMethod,a:"game",data:val},callbackStart);
}

function callbackStart(jsonObj){
		//compare the session name to the player name to find out my playerId;
		turn = jsonObj[0].whoseTurn;
		if(player == jsonObj[0].player1){
			player2 = jsonObj[0].player0;
			playerId = 1;
		}else{
			player2 = jsonObj[0].player1;
			playerId = 0;
		}
		if(playerId == turn){
			document.getElementById('output2').firstChild.nodeValue='Your Turn to play';
		}else{
			document.getElementById('output2').firstChild.nodeValue='Oppponent s turn to play';
		}
		//document.getElementById('output2').firstChild.nodeValue='playerId '+playerId+ ' turn '+turn;
		//start building the game (board and piece)
    	gameInit();
	}

function changeServerTurnAjax(whatMethod,val){
	ajaxCall("GET",{method:whatMethod,a:"game",data:val},null);
}
// send player move to server
function changeBoardAjax(pieceId, boardI, boardJ, whatMethod, val){
	//data: gameId~pieceId~boardI~boardJ~playerId
	ajaxCall("GET",{method:whatMethod,a:"game",data:val+"~"+pieceId+"~"+boardI+"~"+boardJ+"~"+playerId},null);
}

function checkTurnAjax(whatMethod,val){
	if(turn!=playerId){
		ajaxCall("GET",{method:whatMethod,a:"game",data:val},callbackTurn);
	}
	if(playerId == turn){
		document.getElementById('output2').firstChild.nodeValue='Your Turn to play';
	}else{
		document.getElementById('output2').firstChild.nodeValue='Oppponent s turn to play';
	}
	setTimeout("checkTurnAjax('checkTurn',"+gameId+")",3000);
}

function callbackTurn(jsonObj){
	var status = parseInt(jsonObj[0].status);
	if(status > 2 ){
		setTimeout("gameOver("+status+")",1000);
	}
	if(jsonObj[0].whoseTurn == playerId){
		//switch turns
		turn=jsonObj[0].whoseTurn;  //moved this to acallbackMove to fix  bug
		//get the data from the last guys move
		getMoveAjax('getMove',gameId);
	}
}

function getMoveAjax(whatMethod,val){
	ajaxCall("GET",{method:whatMethod,a:"game",data:val},callbackMove);
}
function callbackMove(jsonObj){

	for ( var key in jsonObj ) {
		if(boardArr[jsonObj[key].row][jsonObj[key].col].occupied == "")
		{
			pieceArr[0][pieceArr[0].length] = new Piece('game_'+gameId, jsonObj[key].player, jsonObj[key].row, jsonObj[key].col, 'Checker', pieceArr[0].length);
		}
	}
	//turn=Math.abs(turn=-1); // change turn
}

function endGameAjax(whatMethod,val){
	ajaxCall("GET",{method:whatMethod,a:"game",data:val},callbackMove);
}

function checkLoginAjax(username,password){
	ajaxCall("GET",{method:"checkLogin",a:"login",data:username+"|"+password},callbackCheckLogin);
}

function makeUserActiveAjax(username){
	ajaxCall("GET",{method:"makeUserActive",a:"login",data:username},callbackMakeUserActive);
}

function registerUserAjax(username,password){
	ajaxCall("GET",{method:"registerUser",a:"login",data:username+"|"+password},callbackRegisterUser);
}

function logoffUserAjax(username){
	ajaxCall("GET",{method:"logoffUser",a:"login",data:username},callbackLogoffUser);
}

function callbackLogoffUser(jsonObj){
	DeleteCookie("token");
	DeleteCookie("username");	
	window.location="login.php";
}