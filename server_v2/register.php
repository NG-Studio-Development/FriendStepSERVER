<?php 

$regId = $_GET['regId'];
$name = $_GET['name'];
$email = $_GET['email'];
$pass = $_GET['pass'];
 
 $con = mysql_connect("localhost","akimovdev","qwerty");
 if(!$con){
  die('MySQL connection failed'.mysql_error());
 }
 
 $db = mysql_select_db("akimovdev",$con);
 if(!$db){
  die('Database selection failed'.mysql_error());
 }
 
 $sql = "INSERT INTO tblRegistration (registration_id,name,email,pass) values ('$regId','$name','$email','$pass')";
 
 if(!mysql_query($sql, $con)){
  die('MySQL query failed'.mysql_error());
 } else {
	$id = mysql_insert_id();
	//echo "successful id = ".$id;
	
	$regData = array("id"=>$id, "regId"=>$regId, "name"=>$name, "email"=>$email, "pass"=>$pass);
	//$regData = array("id"=>$id);
	echo json_encode($regData, JSON_FORCE_OBJECT);
	
	}
 
mysql_close($con);

?>


