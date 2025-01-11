<?php 

class Database {
    
    private $host = "localhost";
    private $username = "root";
    private $password = "pgo_programmer";
    private $database = "brgyaurelio";



    public function connect() 
    {
        try {
            $conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            return $conn;
        } catch(Exception $e) {
            echo $e;
            return $e;
        }
    }
}