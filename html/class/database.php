<?php 
class Database {

    public $conn;
    private $configz = array();

    public function __construct($configuration) {
        $this->configz = $configuration;
    }

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=".$this->configz['dbHost'].";dbname=".$this->configz['dbName'], $this->configz['dbU'], $this->configz['dbPW']);
            $this->conn->exec("set names utf8");
        } 
        catch(PDOException $exception) {
            echo "Database could not be connected: " . $exception->getMessage();
        }
        return $this->conn;
    }
}  
?>