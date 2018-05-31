<?php

class Database {

    private $connection;
    private static $instance; // The single instance
    private $db_host = 'localhost';
    private $db_user = 'esther';
    private $db_pass = '1234';
    private $db_name = 'bobbleshop';

    // Get an instance of the Database @return Instance

    public static function getInstance() {
        if(!self::$instance) {
            // If no instance then make one
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Constructor
    private function __construct() {
        $this->connection = new mysqli($this->db_host, $this->db_user, 
                            $this->db_pass, $this->db_name);

        // If the connection fails
        if(mysqli_connect_error()) {
            trigger_error("Database connection failed." . mysqli_connect_error(),
                            E_USER_ERROR);
        }
    }

    // Magic method clone is empty to prevent duplication of connection
    private function __clone() { }

    // Get mysqli connection
    public function getConnection() {
        return $this->connection;
    }

    
}

?>