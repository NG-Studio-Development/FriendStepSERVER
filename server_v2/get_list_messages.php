<?php

 
if (isset($_GET["userId"]) && isset($_GET["friendId"])) {

    $userId = $_GET["userId"];
	$friendId = $_GET["friendId"];
    
	$con = mysql_connect("localhost","akimovdev","qwerty");
	if(!$con){
		die('MySQL connection failed'.mysql_error());
	}
	
	$db = mysql_select_db("akimovdev",$con);
		if(!$db){
		die('Database selection failed'.mysql_error());
	}

	$sqlSelectByUserId = "SELECT * FROM Messages WHERE id IN(SELECT id_mess FROM Ownermessages WHERE id_user = ".$userId." AND id_friend = ".$friendId.")";
	//echo "sql = ".$sqlSelectByUserId;
	
	$result = mysql_query($sqlSelectByUserId, $con);
	
	if(!$result) {
		die('MySQL query failed'.mysql_error());
	} else {
		$i = 0;
		$messages = array();
		while($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$time = strtotime($line['messagetime']);
			$message = array("message" => $line['message'], "sender_id"=>$line['id_sender'], "messagetime"=>$time);
			array_push($messages, $message);
		}
		
		echo json_encode($messages);
	}

mysql_close($con);	
}

?>
