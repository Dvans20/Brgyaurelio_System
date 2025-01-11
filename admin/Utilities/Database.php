<?php 

class Database {
    
       private $host = "localhost";
    private $username = "u402400705_brgyaurelio";
    private $password = "!E6u6lTz0";
    private $database = "u402400705_brgyaurelio";


    public function connect() 
    {
        try {
            $conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            return $conn;
        } catch(Exception $e) {
            echo $e->getMessage();
            return $e->getMessage();
        }
    }

}
$con = new mysqli("localhost", "u402400705_brgyaurelio", "!E6u6lTz0", "u402400705_brgyaurelio");
