// chat function ###############################################################################
function getChat(){
	ajaxCall('GET',{method:"chat",a:"lobby", data:gameId},callbackChat);
}

function callbackChat(data, status){
	var h='';
	for(i=0;i<data.length;i++){
		h+= "<span style='color:gray;'><b>" + data[i].name+':</b></span> '+data[i].message+' <span style="color:gray;">'+data[i].timeStamp+'</span><br/>';
	}
	$('#chatLog').html(h);
	//send the next
	setTimeout("getChat()",1000);
	document.getElementById('chatLog').scrollTop=document.getElementById('chatLog').scrollHeight;
}

function sendChat(){
	var chatMsg = document.getElementById("newChat").value;
	if(chatMsg ==""){
		$( "#dialog-message-noChatText" ).dialog({
			modal: true,
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
				}
			}
		});
	}else{		
		var chatText = username + "|" + chatMsg + "|" + gameId;
		ajaxCall('POST',{method:"sendChat",a:"lobby",data:chatText},null);
		document.getElementById("newChat").value = "";
	}
}

/*function callbackSendChat(data, status){
	document.getElementById("newChat").value = "";
}*/
// END chat function ###############################################################################