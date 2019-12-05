<?php

require_once 'sql/settings.php';

class DBConnection {
    public $connection;

    function __construct() {
        $this->connection = mysqli_connect(SQL_HOST, SQL_USER, SQL_PASSWORD, SQL_DATABASE);
        if (!$this->connection) {
          throw new Exception('Cannot connect to the database');
        }       
    }

    public function execute($sql) {
        $result  = mysqli_query($this->connection, $sql);
        if ($result === FALSE) {
            throw new Exception("Cannot execute: $sql");
        }
        else {
            return $result;
        }        
    }
}

 