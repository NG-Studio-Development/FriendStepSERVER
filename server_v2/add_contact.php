	<?php 

	define("ACTION_SEND_CANDIDATURE", 0);
	define("ACTION_APPROVE_CANDIDATURE", 1);

	 class ContactRequest {
		
		private $host = "localhost";
		private $user = "akimovdev";
		private $pass = "qwerty";
	 
		 /*public function connectDB() {
			$this->TEST_VAL = "connectDB was called";
			
			echo "<br><br> Test value = ".$this->TEST_VAL."<br><br>";
			$this->connect = mysql_connect($this->host, $this->user, $this->pass);
			return $this->connect;
		 } */
		 
		 private function addContact($name, $user_id, $status) {
			
			//$conn = $this->connect;
			ini_set('display_errors', 1);
			error_reporting(E_ALL); 
			
			echo "<br>".$this->host;
			echo "<br>".$this->user;
			echo "<br>".$this->pass;
			
			$con = mysql_connect($this->host, $this->user, $this->pass);
			if(!$con) {
				echo "<br>Is no connect<br>";
			}
			
			$db = mysql_select_db("akimovdev",$con);
				if(!$db){
					echo "Error select db";
				}
			
			//echo "<br><br>Name = '$name'<br><br>";
			$sql = "SELECT * from tblRegistration WHERE name = '$name'";
			//$sql = "SELECT * from tblRegistration WHERE name = 't15'";
			echo "<br> SQL = ".$sql."<br>";
			 $result = mysql_query($sql, $con);
			 if(!$result){
				echo "Error not found user with this name";
			  } else {
					echo "addContact is 2";
				if($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
					echo "addContact is 2";
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
			echo "approveCandidate is call";
			$this->addContact($name, $user_id, 1);
		}
	 
	 }
	 
	 
	 $name = $_GET['name'];
	 $user_id = $_GET['id'];
	 $action = $_GET['action'];
	 
	 // ***** NOT DELETE ***** //
		//$prnt_get = print_r($_GET,true);
		//file_put_contents('mylog.log',$prnt_get, FILE_APPEND);
	 
	 $contactRequest = new ContactRequest();
	 //$isConnnect = $contactRequest->connectDB();
	 
	 //if(!$isConnnect){
	  //echo "Error connect <br>";
	 //}
	 
	 switch($action) {
		
		case ACTION_SEND_CANDIDATURE:
			$contactRequest->sendCandidatureContact($name, $user_id);
			break;

		case ACTION_APPROVE_CANDIDATURE:
			$contactRequest->approveCandidate($id_friend, $user_id);
			break;
	 }
	 
	//mysql_close($con);
	?>


