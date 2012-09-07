function getOnlineUsers(){
	ajaxCall('GET',{method:"getOnlineUsers",a:"lobby", data:username},callbackOnlineUsers);
}

function callbackOnlineUsers(data, status){
	var h='';
	for(i=0;i<data.length;i++){
		h+= "<div onclick='challengePlayer(\"" + data[i].name + "\")'>" + data[i].name+'</div><br/>';
	}
	$('#userList').html(h);
	//$( "div", "#userList").button();
	//send the next
	setTimeout("getOnlineUsers()",1000);
}

function challengePlayer(playerId){
	$( "#dialog-confirm-makeChallenge" ).dialog({
		resizable: false,
		height:200,
		width:500,
		modal: true,
		buttons: {
			"Yes": function() {
				$( this ).dialog( "close" );
				
				var challengeDetails = username + "|" + playerId ;
				ajaxCall('GET',{method:"challengePlayer",a:"lobby", data:challengeDetails}, callbackChallenge);
				
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});
}

function callbackChallenge(data, status){
	//challenge id status
	// 0: challenge pending
	// 1: accepted
	// -1:rejected

	if(data.gameId > 0){
		var loc = "game.php?player=" + username + "&gameId=" + data.gameId;	
		window.location = loc;
	}else if(data.gameId < 0){
		$( "#dialog-message-challengeRejected" ).dialog({
			modal: true,
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
				}
			}
		});	
	}
}

function checkChallenges(){
	ajaxCall('GET',{method:"checkChallenges",a:"lobby", data:username}, callbackNewChallenge);
}

function callbackNewChallenge(data, status){		
	if(data.gameId != 0){
		$("#challenger").text(data.player1);
		$( "#dialog-confirm-acceptChallenge" ).dialog({
			resizable: false,
			height:220,
			width:500,
			modal: true,
			buttons: {
				"Yes": function() {
					$( this ).dialog( "close" );
					
					var challengeDetails = username + "|" + data.gameId ;
					ajaxCall('GET',{method:"acceptChallenge",a:"lobby", data:challengeDetails}, callbackChallenge);					
				},
				Cancel: function() {
					$( this ).dialog( "close" );
					var challengeDetails = username + "|" + data.gameId ;
					ajaxCall('GET',{method:"rejectChallenge",a:"lobby", data:challengeDetails}, callbackChallenge);
				}
			}
		});
	}else{
		setTimeout("checkChallenges()",1000);
	}		
}