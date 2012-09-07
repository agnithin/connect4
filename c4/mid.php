<?php
	if(isset($_REQUEST['method'])){
		//include all files for needed area (a)
		foreach (glob("./svcLayer/".$_REQUEST['a']."/*.php") as $filename){
			include $filename;
		}
		$serviceMethod=$_REQUEST['method'];
		$data=$_REQUEST['data'];
		
		require_once('bizLayer/utils.php');
		// for login and register user/ token are not set and index not found error; 
		// ugly hack but i coudnt think of anything else
		
		if($_REQUEST['method'] == "checkLogin" || $_REQUEST['method'] == "registerUser")
		{
			$result=call_user_func($serviceMethod, $data, $_SERVER['REMOTE_ADDR'], "");
		}else{
			if(validateToken($_COOKIE['username'], $_SERVER['REMOTE_ADDR'], $_COOKIE['token'])){
				$result=call_user_func($serviceMethod, $data, $_SERVER['REMOTE_ADDR'], $_COOKIE['token']);
			}
		}
		
		if($result){
			//might need the header cache stuff
			header("Content-Type:text/plain");
			echo $result;
		}
	}
?>