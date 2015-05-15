<?
    include 'utils/DBManager.php';
    
    file_put_contents('mylog.log', 'In get avatar', FILE_APPEND);
    
    $name = $_POST['name'];
    $dbManager = new DBManager();
    
    $sqlResult = $dbManager->query("SELECT bitmap_string FROM tblRegistration WHERE name = '$name'");

    $line = $dbManager->fetch_assoc($sqlResult);
    
    echo json_encode($line);

?>