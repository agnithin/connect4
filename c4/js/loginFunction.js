function showRegister(){
	$("#loginForm").hide(1000);
	$("#registerForm").show(1000);
	$("#rusername").focus();
}

function showLogin(){
	$("#registerForm").hide(1000);
	$("#loginForm").show(1000);
	$("#username").focus();
}

//checks if valid user
function loginUser(){
	document.getElementById('submitLogin').disabled = true;
	checkLoginAjax($("#username").val(), $("#password").val());
}

//if valid user set token cookie and redirect to lobby page; else display error
function callbackCheckLogin(jsonObj){
	if(jsonObj.validUser == true){
		SetCookie("token", jsonObj.token);
		SetCookie("username", jsonObj.username);
		makeUserActiveAjax(jsonObj.username);		
	}else{
		$( "#dialog-invalidLogon" ).dialog({
			modal: true,
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
				}
			}
		});	
		document.getElementById('submitLogin').disabled = false;
	}
}

// creates a new user
function registerUser(){
	document.getElementById('submitRegister').disabled = true;
	registerUserAjax($("#rusername").val(), $("#rpassword").val());
}

// displays a dialog with success or failure
function callbackRegisterUser(jsonObj){
	if(jsonObj.registerStatus == true){
		$( "#dialog-registerSuccess" ).dialog({
			modal: true,
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
				}
			}
		});	
		$("#username").val(jsonObj.username);
		$("#password").val("");
		showLogin();
	}else{
		$( "#dialog-registerFail" ).dialog({
			modal: true,
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
				}
			}
		});	
	}
	document.getElementById('submitRegister').disabled = false;
}

function callbackMakeUserActive(jsonObj){
	window.location="lobby.php";
}