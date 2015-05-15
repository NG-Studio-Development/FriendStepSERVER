<?
   include 'utils/DBManager.php';
   //$arr = array();
    
    /*$nerbyContact = array("name"=>"One", "mobilenumber"=>"1111111111", "latitude"=>0.0, "longitude"=>0.0, "loc_time"=>555555);
    array_push($arr, $nerbyContact);
    
    $nerbyContact = array("name"=>"Two", "mobilenumber"=>"8888888888", "latitude"=>20.0, "longitude"=>20.0, "loc_time"=>5555558);
    array_push($arr, $nerbyContact); */
    
   //echo json_encode($arr);
    
   ini_set('display_errors', 1);
   error_reporting(E_ALL); 

   function calcDistanceByLocation($lat1, $lng1, $lat2, $lng2) {
        $earthRadius = 6371000; //meters
        $dLat = deg2rad($lat2-$lat1);
        $dLng = deg2rad($lng2-$lng1);
        $a = sin($dLat/2) * sin($dLat/2) +
                   cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
                   sin($dLng/2) * sin($dLng/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $dist = (float) ($earthRadius * $c);
    
        return $dist;
    }

    $prnt_get = print_r($_GET,true);
    file_put_contents('mylog.log',$prnt_get, FILE_APPEND);
         
        
    if (isset($_GET['user_id']) && isset($_GET['user_lat']) && isset($_GET['user_long']) && isset($_GET['distance_find'])) {
            
        //$userLat = 47.199702;
        //$userLong = 39.626338;
        //$distanceFind = 400;
        
        $user_id = $_GET['user_id'];
        $userLat = $_GET['user_lat'];
        $userLong = $_GET['user_long'];
        $distanceFind = $_GET['distance_find'];
        
        $queryString = "SELECT tblRegistration.id, tblRegistration.name, Locations.latitude, Locations.longitude 
                        FROM tblRegistration INNER JOIN Locations 
                        ON tblRegistration.id = Locations.id_user 
                        WHERE Locations.id_user IN (SELECT id_friend from Friends WHERE id_user = '$user_id')"; 
        
        file_put_contents('mylog.log',"\n".$queryString, FILE_APPEND);
        
        $dbManager = new DBManager();
        $sqlResult = $dbManager->query($queryString);
            
        $arr = array();
        
        while ($line = $dbManager->fetch_assoc($sqlResult)) {
            $distance = calcDistanceByLocation($userLat, $userLong, $line['latitude'], $line['longitude']);
            if($distance <= $distanceFind) {
                array_push($arr, $line);
            }
        }
        
        echo json_encode($arr);        
    } else {
        echo "<br>Error<br>";
        //print_r($_GET);
    }
    
    
?>