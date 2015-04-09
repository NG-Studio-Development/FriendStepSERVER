<?php

function handleResult($result, $message, $senderId, $friendId, $con) {
	$arr = json_decode($result,true);

	print_r($arr);
	
	if ($arr['success'] == 1) {
		echo "<br>Success send GCM message <br>";
		queryInsertMessage($message, $senderId, $friendId, $con);
	} else {
		echo "<br>Failure send GCM message <br>";
	}
}

 
function queryInsertMessage($message, $senderId, $friendId, $con) {
	$date = new DateTime();
	$time = $date->getTimestamp();
	echo "<br>Time = ".$time."<br>";
	
	$sqlInsertMessage = "INSERT INTO Messages(message, id_sender) VALUES ('".$message."','".$senderId."')";
	
	echo "<br>sqlInsertMessage = ".$sqlInsertMessage."<br>";
	
	$result = mysql_query($sqlInsertMessage, $con);
	
	if(!$result) {
		echo "<br>queryInsertMessage() Error in insert into message<br>";
	} else {
		$id = mysql_insert_id();
		$sqlInsertOwnermessages = "INSERT INTO Ownermessages (id_user, id_friend, id_mess ) VALUES ('".$senderId."','".$friendId."','".$id."'),('".$friendId."','".$senderId."','".$id."')";
		if(mysql_query($sqlInsertOwnermessages, $con)) {
			echo "<br>Success save message into DB <br>";
		} else {
			echo "<br>Failure save message into DB <br>";
		}
	}
}

 
if (isset($_GET["userId"]) && isset($_GET["friendId"]) && isset($_GET["message"])) {

    $userId = $_GET["userId"];
	$friendId = $_GET["friendId"];
    $message = $_GET["message"];
	
	$con = mysql_connect("localhost","akimovdev","qwerty");
	if(!$con){
		die('MySQL connection failed'.mysql_error());
	}
	
	$db = mysql_select_db("akimovdev",$con);
		if(!$db){
		die('Database selection failed'.mysql_error());
	}

	$sql = "SELECT registration_id FROM tblRegistration WHERE id=".$friendId;
	$result = mysql_query($sql, $con);
	
	if(!$result) {
		  die('MySQL query failed'.mysql_error());
	} else {
			$contacts = array();
			while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
				
				$regId = $line['registration_id'];
								
				include_once './GCM.php';
				$gcm = new GCM();
				$registatoin_ids = array($regId);
				$from = "FROM_SWEB";
				$message = array("price" => $message, "from_gcm" => $from);
				$result = $gcm->send_notification($registatoin_ids, $message);
				
				handleResult($result, $message["price"], $userId, $friendId,$con);
				echo "Result = ".$result;
			
			}
		}
}

?>
