<?php 

 $name = $_GET['name'];
 $user_id = $_GET['id'];
 
 $prnt_get = print_r($_GET,true);
 file_put_contents('mylog.log',$prnt_get, FILE_APPEND);
 
 $con = mysql_connect("localhost","akimovdev","qwerty");
 if(!$con){
  echo "Error connect";
 }
 
 $db = mysql_select_db("akimovdev",$con);
 if(!$db){
  echo "Error select db";
 }
 $sql = "SELECT * from tblRegistration WHERE name = '$name'";
 $result = mysql_query($sql, $con);
 if(!$result){
 	echo "Error not found user with this name";
  } else {
	
	if($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$id_friend = $line['id'];
		$sqlInsert = "INSERT INTO Friends(id_friend,id_user) VALUES('$id_friend','$user_id')";
		if (!mysql_query($sqlInsert, $con)) {
			echo "Error: Not add friend <br>";
		} else {
			echo "Friend was add sucessful <br>";
		}
	} else {
		echo json_encode(array('Error' => "Not found user with name: ".$name), JSON_FORCE_OBJECT);
	}
 }
 
mysql_close($con);
?>


