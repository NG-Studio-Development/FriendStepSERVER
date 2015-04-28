<?php 

define("ACTION_SEND_CANDIDATURE", 0);
define("ACTION_APPROVE_CANDIDATURE", 1);

class ContactRequest {
	
	private $host = "localhost";
	private $user = "akimovdev";
	private $pass = "qwerty";
	 
	private function addContact($name, $user_id, $status) {
		
		ini_set('display_errors', 1);
		error_reporting(E_ALL); 
		
		$con = mysql_connect($this->host, $this->user, $this->pass);
		
		if(!$con) { echo "<br>Is no connect<br>"; }
		
		$db = mysql_select_db("akimovdev", $con);
		
		if(!$db){ echo "Error select db"; }
		
		$sql = "SELECT * from tblRegistration WHERE name = '$name'";
		
		echo "<br> SQL = ".$sql."<br>";
		$result = mysql_query($sql, $con);
		
		if(!$result){
			echo "Error not found user with this name";
		} else {
				    
				if($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
					
					$id_friend = $line['id'];
					$sqlInsert = "INSERT INTO Friends(id_friend,id_user,status) VALUES('$id_friend','$user_id','$status')";
					
					if (!mysql_query($sqlInsert, $con)) {
						echo "Error: Not add friend <br>";
					} else {
						echo "Friend was add sucessful <br>";
					}
				} else {
					echo json_encode(array('Error' => "Not found user with name: ".$name), JSON_FORCE_OBJECT);
				}
			}
	}
	 
	
	public function sendCandidatureContact($name, $user_id) {
		echo "sendCandidatureContact is call";
		$this->addContact($name, $user_id, -1);
	}
	
    public function approveCandidate($name, $user_id) {
        $this->query("UPDATE Friends 
                      SET status = 1
                      WHERE id_friend = (SELECT id from tblRegistration WHERE name = '$name')");
    }
    
    private function query($sqlQuery) {
            
        ini_set('display_errors', 1);
        error_reporting(E_ALL); 
        
        $con = mysql_connect($this->host, $this->user, $this->pass);
        if(!$con) {
            echo "<br>Is no connect<br>";
        }
        
        $db = mysql_select_db("akimovdev",$con);
        
        if (!$db) { echo "Error select db"; }
        
        if (!mysql_query($sqlQuery, $con)) {
            echo "<br>Error: Not add friend <br>";
        } else {
            echo "Friend was add sucessful <br>";
        }
    }
    
}
	 
$name = $_GET['name'];
$user_id = $_GET['id'];
$action = $_GET['action'];
	 
$prnt_get = print_r($_GET, true);
file_put_contents('mylog.log',$prnt_get, FILE_APPEND);
	 
$contactRequest = new ContactRequest();
	 
switch($action) {
		
	case ACTION_SEND_CANDIDATURE:
		$contactRequest->sendCandidatureContact($name, $user_id);
		break;
	
	case ACTION_APPROVE_CANDIDATURE:
		$contactRequest->approveCandidate($name, $user_id);
		break;
}

?>


