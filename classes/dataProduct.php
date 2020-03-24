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
            $sql = "SELECT pl.*, m.media as photo, p.price, b.name brand, p.weight, ca.name category, p.category_id from shop_products_lang pl left outer join shop_products p on pl.id = p.id Left outer JOIN shop_media m ON m.id = p.media_id INNER JOIN shop_categories_lang ca ON ca.id = p.category_id INNER JOIN shop_brands b ON p.brand_id = b.id where pl.language = 'fr_FR' AND p.id = $id AND ca.language = 'fr_FR'";
        } elseif ($language == 'en_US') {
            $sql = "SELECT pl.*, m.media as photo, p.price, b.name brand, p.weight, ca.name category, p.category_id from shop_products_lang pl left outer join shop_products p on pl.id = p.id Left outer JOIN shop_media m ON m.id = p.media_id INNER JOIN shop_categories_lang ca ON ca.id = p.category_id INNER JOIN shop_brands b ON p.brand_id = b.id where pl.language = 'en_US' AND p.id = $id AND ca.language = 'en_US'";
        } elseif ($language == 'nl_BE') {
            $sql = "SELECT m.media photo, p.name, p.price, p.id, b.name brand, p.weight, p.ingredients, ca.name category, p.category_id FROM shop_products p INNER JOIN shop_categories ca ON ca.id = p.category_id  left outer JOIN shop_media m ON m.id = p.media_id INNER JOIN shop_brands b ON p.brand_id = b.id WHERE p.id = $id;";
        } else {
            throw new Exception('Language not recognized');
        }
        
        $result = $this->db->execute($sql);

        if ($row = $result->fetch_assoc()) {
            $product = new BusinessProduct();
            $product->id = $row['id'];
            $product->photo = $row['photo'];
            $product->name = $row['name'];
            $product->price = $row['price'];
            $product->brand = $row['brand'];
            $product->weight = $row['weight'];
            $product->ingredients = $row['ingredients'];
            $product->category = $row['category'];
            $product->categoryId =$row['category_id'];
        } 
        else {
            throw new Exception('Cannot find product ' . $id);
        }

        return $product;
    }
    public function readAll($language, $where = "", $orderBy = "") {
        if ($language == 'fr_FR') {
            $sql = "SELECT pl.*, m.media as photo, p.price, b.name brand, p.weight, ca.name category from shop_products_lang pl left outer join shop_products p on pl.id = p.id Left outer JOIN shop_media m ON m.id = p.media_id INNER JOIN shop_categories_lang ca ON ca.id = p.category_id INNER JOIN shop_brands b ON p.brand_id = b.id where pl.language = 'fr_FR' AND ca.language = 'fr_FR' $where $orderBy";
        } elseif ($language == 'en_US') {
            $sql = "SELECT pl.*, m.media photo, p.price, b.name brand, p.weight, ca.name category from shop_products_lang pl left outer join shop_products p on pl.id = p.id Left outer JOIN shop_media m ON m.id = p.media_id INNER JOIN shop_categories_lang ca ON ca.id = p.category_id INNER JOIN shop_brands b ON p.brand_id = b.id where pl.language = 'en_US' AND ca.language= 'en_US' $where $orderBy";
        } elseif ($language == 'nl_BE') {
            $sql = "SELECT m.media photo, p.name, p.price, p.id, p.weight, p.ingredients, b.name brand, ca.name category FROM shop_products p  INNER JOIN shop_categories ca ON ca.id = p.category_id Left outer JOIN shop_media m ON m.id = p.media_id INNER JOIN shop_brands b ON p.brand_id = b.id WHERE p.name <> '' $where $orderBy;";
        } else {
            throw new Exception('Language not recognized');
        }

        $result = $this->db->execute($sql);

        $products = [];

        while ($row = $result->fetch_assoc()) {
            $product = new BusinessProduct();
            $product->id = $row['id'];
            $product->photo = $row['photo'];
            $product->name = $row['name'];
            $product->price = $row['price'];
            $product->brand = $row['brand'];
            $product->weight = $row['weight'];
            $product->ingredients = $row['ingredients'];
            $product->category = $row['category'];
            $products[] = $product;
        } 
        return $products;
    }
}