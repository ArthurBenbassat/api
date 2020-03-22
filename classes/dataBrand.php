<?php
require_once 'DBConnection.php';
require_once 'businessStandard.php';

class DataBrand {
    private $db;
    
    function __construct()
    {
        $this->db = new DBConnection();
    }

    public function readAll() {
        
        $sql = "SELECT * FROM shop_brands";
        $result = $this->db->execute($sql);

        $brands = [];

        while ($row = $result->fetch_assoc()) {
            $brand = new BusinessStandard;
            $brand->id =$row['id'];
            $brand->name = $row['name'];
            $brands[] = $brand;
        } 
        return $brands;
    }
}