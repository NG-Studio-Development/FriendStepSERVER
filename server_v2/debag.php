<?

    include 'utils/DBManager.php';
    
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


    //$var = distFrom(47.199702, 39.626338, 47.199704, 39.626879);
    
    
    $userLat = 47.199702;
    $userLong = 39.626338;
    $distanceFind = 400;
    
    $queryString = "SELECT * FROM Locations";
    $dbManager = new DBManager();
    $sqlResult = $dbManager->query($queryString);
        
    $arr = array();
    
    while ($line = $dbManager->fetch_assoc($sqlResult)) {
        $distance = calcDistanceByLocation($userLat, $userLong, $line['latitude'], $line['longitude']);
        if($distance <= $distanceFind) {
            array_push($arr, $line);    
        }
        
    }

    
    
    

?>