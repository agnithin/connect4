<?php
function clearOldLobbyChat(){
	//global $mysqli;
	$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
    $seconds = 24 * 60 * 60;
    $cutoff = time() - $seconds;
    $cutoff = date("Y-m-d H:i:s", $cutoff);
    
    $sql = "DELETE FROM c4lobbychat WHERE timestamp < '$cutoff'";
    if($stmt = $mysqli->prepare($sql)) 
	{
        $stmt->execute();
        $stmt->close();
    }
	return;
}

?>