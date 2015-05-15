<?php 
//include 'utils/DBManager.php';
include_once 'utils/DBManager.php'; 
class Register {
  
  function __construct() {}
  
  function register($regId,$name, $email, $pass) {
          
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
  } 
  
  
  function signIn($name, $pass) {
      
      $dbManager = new DBManager();
      
      $resultQuery = $dbManager->query("SELECT * FROM tblRegistration WHERE name = '$name' AND pass='$pass'");
      $row = $dbManager->fetch_assoc($resultQuery);
      $authorization = FALSE;
      
      if(empty($row)) {
          echo "Error authorization";
      } else {
          echo json_encode($row, JSON_FORCE_OBJECT);    
      }
          //$authorization = TRUE;
      
          
       
    } 
}

 $regId = $_GET['regId'];
 $name = $_GET['name'];
 $email = $_GET['email'];
 $pass = $_GET['pass'];
 
 $register = new Register();
 
 if (isset($_GET['regId']) && isset($_GET['name']) && isset($_GET['email'])&& isset($_GET['pass'])) 
        $register->register($regId,$name, $email, $pass);
 else if(isset($_GET['name']) && isset($_GET['pass'])) 
        $register->signIn($name, $pass);              
 
?>


