<?
    include 'utils/DBManager.php';

     $prnt_get = print_r($_POST,true);
     file_put_contents('mylog.log',$prnt_get, FILE_APPEND);

    if(isset($_POST['name']) && $_POST['image']) {
     
        $name = $_POST['name'];
        $image = $_POST['image'];
        
        $dbManager = new DBManager();
        
        $queryString = "UPDATE tblRegistration SET bitmap_string='$image' WHERE name='$name'";
        $sqlResult = $dbManager->query($queryString);
        
        if ($sqlResult === TRUE) {
           echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
        
        //$sqlResult = $dbManager->query("SELECT bitmap_string FROM tblRegistration WHERE name = '$name'");
        
        //$line = $dbManager->fetch_assoc($sqlResult);
        //echo json_encode($line);
        
    }

?>