	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Connect 4 - Login</title>
		<link rel="stylesheet" href="./_styles/loginPage.css" type="text/css" />
		<link rel="stylesheet" href="./_styles/fonts.css" type="text/css" />
		<link type="text/css" href="_styles/redmond/jquery-ui-1.8.12.custom.css" rel="stylesheet" />
		
		
		<script src="http://code.jquery.com/jquery-latest.js"></script>	
		<script src="js/jquery-ui-1.8.12.custom.min.js" type="text/javascript"></script>		
		<script src="js/loginFunction.js" type="text/javascript"></script>
		<script src="js/ajaxFunctions.js" type="text/javascript"></script>
		<script src="js/cookies.js" type="text/javascript"></script>	
		<script>
			$(document).ready(function(){
				$("#username").focus();
				document.getElementById('submitLogin').addEventListener('click', loginUser, false);
				document.getElementById('submitRegister').addEventListener('click', registerUser, false);	
			})
		</script>
	</head>
	<body>
	<header>
		<h2>Connect 4</h2>
	</header>
	<div id="loginForm">
		<div id="titleBar">
			<h2>Login</h2>
		</div>
		<div id="login">
			<p>Username: <input type="text" name="username" id="username" size="20" required/></p>
			<p>Password: <input type="password" name="password" id="password" size="20" required/></p>
			<p>
				<input type="submit" name="submitLogin" id="submitLogin" value="Submit"/>
			</p>
			<p><a href='#' onclick="showRegister();">New User?</a></p>
		</div>
	</div>
	<div id="registerForm" style="display:none">
		<div id="titleBar">
			<h2>Register</h2>
		</div>
		<div id="register">
			<p>Username: <input type="text" name="rusername" id="rusername" size="20" required/></p>
			<p>Password: <input type="password" name="rpassword" id="rpassword" size="20" required/></p>
			<p>
				<input type="submit" name="submitRegister" id="submitRegister" value="Register"/>
			</p>
			<p><a href='#' onclick="showLogin();">Back to Login</a></p>
		</div>
	</div>

	<div id="dialog-invalidLogon" title="Invalid Login" style="display:none">
		<p>
			<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
			Incorrect Username/Password.
		</p>
	</div>
	<div id="dialog-registerSuccess" title="Registration Successfull" style="display:none">
		<p>
			<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
			User Registered Successfully. Please login to continue.
		</p>
	</div>
	<div id="dialog-registerFail" title="Registration Failed" style="display:none">
		<p>
			<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
			User could not be registered. Please try a different username.
		</p>
	</div>	
