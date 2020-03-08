<?php

require_once 'businessProduct.php';
require_once 'DBConnection.php';

class DataProduct {
    private $db;
    
    function __construct()
    {
        $this->db = new DBConnection();
    }
    public function read($id, $language) {
        if ($language == 'fr_FR') {
            $sql = "SELECT pl.*, m.media as photo, p.price  from shop_products_lang pl left outer join shop_products p on pl.id = p.id Left outer JOIN shop_media m ON m.id = p.media_id where language = 'fr_FR' AND p.id = $id";
        } elseif ($language == 'en_US') {
            $sql = "SELECT pl.*, m.media as photo, p.price from shop_products_lang pl left outer join shop_products p on pl.id = p.id Left outer JOIN shop_media m ON m.id = p.media_id where language = 'en_US' AND p.id = $id";
        } else {
            $sql = "SELECT m.media photo, p.name, p.price, p.id FROM shop_products p  left outer JOIN shop_media m ON m.id = p.media_id WHERE p.id = $id;";
        }
        
        $result = $this->db->execute($sql);

        if ($row = $result->fetch_assoc()) {
            $product = new BusinessProduct();
            $product->id = $row['id'];
            $product->photo = $row['photo'];
            $product->name = $row['name'];
            $product->price = $row['price'];
        } 
        else {
            throw new Exception('Cannot find product ' . $id);
        }

        return $product;
    }
    public function readAll($language) {
        if ($language == 'fr_FR') {
            $sql = "SELECT pl.*, m.media as photo, p.price  from shop_products_lang pl left outer join shop_products p on pl.id = p.id Left outer JOIN shop_media m ON m.id = p.media_id where language = 'fr_FR'";
        } elseif ($language == 'en_US') {
            $sql = "SELECT pl.*, m.media photo, p.price  from shop_products_lang pl left outer join shop_products p on pl.id = p.id Left outer JOIN shop_media m ON m.id = p.media_id where language = 'en_US'";
        } else {
            $sql = "SELECT m.media photo, p.name, p.price, p.id FROM shop_products p  Left outer JOIN shop_media m ON m.id = p.media_id;";
        }

        $result = $this->db->execute($sql);

        $products = [];

        while ($row = $result->fetch_assoc()) {
            $product = new BusinessProduct();
            $product->id = $row['id'];
            $product->photo = $row['photo'];
            $product->name = $row['name'];
            $product->price = $row['price'];
            $products[] = $product;
        } 
        return $products;
    }
}