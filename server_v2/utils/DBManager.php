<?php 
define("DB_HOST", "localhost");
define("DB_USER", "akimovdev");
define("DB_PASSWORD", "qwerty");
define("DB_DATABASE", "akimovdev");

class DBManager  {
    
    private function connect() {
        $con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
        mysql_select_db(DB_DATABASE);
        return $con;
    }
    

    public function query($queryString) {
        $con = $this->connect();
    
        $result = mysql_query($queryString, $con);
        
        if (!$result) 
            echo "<br> Error in query<br>";
        
        $this->close();
        
        return $result;
    }
    
    public function fetch_assoc($result) {
        return mysql_fetch_assoc($result);
    }

    private function close() {
        mysql_close();
    }
    
    public function testMethod() {
        echo "DBManager -> testMethod() is call";
        
    }
    

}





?>
