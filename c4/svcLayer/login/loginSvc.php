<?php
	//all methods called in the login page are included in this service	
	require_once "../../dbInfoPS.inc";
	require_once('bizLayer/loginBiz.php');
	require_once('bizLayer/utils.php');
		
	
	/*************************
	checkLogin : if valid user return the token
	***************************/
	function checkLogin($d, $ip, $token){
		list($username, $password) = explode("|", $d);
		return checkLoginBiz($username, $password);
	}

	/*************************
	makeUserActive : set the users status as active to display him in the lobby userlist
	***************************/
	function makeUserActive($d, $ip, $token){
		return makeUserActiveBiz($d);
	}

	/*************************
	registerUser : creates a new user; returns a joson with the true or false
	***************************/
	function registerUser($d, $ip, $token){
		list($username, $password) = explode("|", $d);
		return registerUserBiz($username, $password);
	}

	/*************************
	logoffUser : logs out the user and ends all his game
	***************************/
	function logoffUser($d, $ip, $token){
		return logoffUserBiz($d);
	}	
?>