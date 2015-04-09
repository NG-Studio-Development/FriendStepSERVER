<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//if (isset($_GET["regId"]) && isset($_GET["message"])) {
    //$regId = $_GET["regId"];
    $regId = "APA91bG8HT61Iw9fB6Q3fn4prwyr3cPts27Y2cRtXg8BgJ0e-SuJtqsLOy1G5VimVep24ZYaHRQiIJ7fI23SswZE2l7bH0hpTp2fYA8lBCZoHX778eHti9TcteiznxtEUe9RzLrJc2zWXmnB13jnP0BtUabnebOcx5ahwOuWwA0MUGD6YyOjKEY";
    //$message = $_GET["message"];
    $message = "DebugMessage";

    include_once './GCM.php';
    
    $gcm = new GCM();

    $registatoin_ids = array($regId);
    $message = array("price" => $message);

    $result = $gcm->send_notification($registatoin_ids, $message);

    echo "Result".$result;
//}
?>
