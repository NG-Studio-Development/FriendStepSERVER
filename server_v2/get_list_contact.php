	<?php 
		
		function getStatusName($statusCode) {
		    $statusName = "NaN";
		    
		    if ($statusCode == -1)
		        $statusName = "pending";
		    else if ($statusCode == 1) 
		        $statusName = "approve";
		     
            return $statusName;   
		}
		
		$user_id = $_GET['id'];
		 
		 $prnt_get = print_r($_GET,true);
		 file_put_contents('mylog.log',$prnt_get, FILE_APPEND);
		 
		 
		 $con = mysql_connect("localhost","akimovdev","qwerty");
		 if(!$con){
			die('MySQL connection failed'.mysql_error());
		 }
		 
		 $db = mysql_select_db("akimovdev",$con);
		 
		 if(!$db){
		  die('Database selection failed'.mysql_error());
		 }
		 
		 $sql = "SELECT id_friend, status from Friends WHERE id_user = '$user_id'";
		 $result = mysql_query($sql, $con);
		 
		 if(!$result) {
		  die('MySQL query failed'.mysql_error());
		 } else {
			$contacts = array();

			while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
				    
				$id_friend = $line['id_friend'];
				
				$status = getStatusName($line['status']);
				
				$subSql = "SELECT * from tblRegistration WHERE id = $id_friend";
				
				$resultSubQuery = mysql_query($subSql, $con);
				
				if (!$resultSubQuery) {
					echo "Error: Not add friend <br>";
				} else {
					
					$i = 0;
					while ($lineSubQuery = mysql_fetch_array($resultSubQuery, MYSQL_ASSOC)) {
						
						$contact = array("id" => $lineSubQuery['id'], 
						                  "name" => $lineSubQuery['name'],
                                          "contact_status" => $status);
						
						array_push($contacts, $contact);
					}
				}
			}
			echo json_encode($contacts);
		}

		mysql_close($con);
	?>


