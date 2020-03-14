<?php

require_once 'businessCategory.php';
require_once 'DBConnection.php';

class DataCategory {
    private $db;
    
    function __construct()
    {
        $this->db = new DBConnection();
    }
    public function read($id, $language) {
        if ($language == 'nl_BE') {
            $sql = "SELECT c.id, c.name from shop_categories c WHERE c.id = $id;";
        } elseif ($language == 'fr_FR') {
            $sql = "SELECT cl.* from shop_categories c LEFT OUTER JOIN shop_categories_lang cl ON c.id = cl.id WHERE cl.language = 'fr_FR' AND c.id = $id";
        } elseif ($language == 'en_US') {
            $sql = "SELECT cl.* from shop_categories c LEFT OUTER JOIN shop_categories_lang cl ON c.id = cl.id WHERE cl.language = 'en_US' AND c.id = $id";
        } else {
            throw new Exception('Language not recognized');
        }
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
    public function readAll($language) {
        if ($language == 'nl_BE') {
            $sql = "SELECT c.id, c.name from shop_categories c;";
        } elseif ($language == 'fr_FR') {
            $sql = "SELECT cl.* from shop_categories c LEFT OUTER JOIN shop_categories_lang cl ON c.id = cl.id WHERE cl.language = 'fr_FR'";
        } elseif ($language == 'en_US') {
            $sql = "SELECT cl.* from shop_categories c LEFT OUTER JOIN shop_categories_lang cl ON c.id = cl.id WHERE cl.language = 'en_US'";
        } else {
            throw new Exception('Language not recognized');
        }
        
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