<?php

require_once 'businessCategory.php';
require_once 'DBConnection.php';

class DataCategory {
    private $db;
    
    function __construct()
    {
        $this->db = new DBConnection();
    }
    public function read($id) {
        $sql = "SELECT c.id, c.name from shop_categories c where c.id = $id;";
        $result = $this->db->execute($sql);

        if ($row = $result->fetch_assoc()) {    
            $category = new BusinessCategory;
            $category->id = $row['id'];
            $category->name = $row['name'];
            
        } 
        else {
            throw new Exception('Cannot find category ' . $id);
        }

        return $category;
    }
    public function readAll() {
        $sql = "SELECT c.id, c.name from shop_categories c;";
        $result = $this->db->execute($sql);

        $categories = [];

        while ($row = $result->fetch_assoc()) {
            $category = new BusinessCategory;
            $category->id = $row['id'];
            $category->name = $row['name'];
            $categories[] = $category;
        } 
        return $categories;
    }
}