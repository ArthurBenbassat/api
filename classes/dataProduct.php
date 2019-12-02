<?php

require_once 'businessProduct.php';
require_once 'DBConnection.php';

class DataProduct {
    public function get($id) {
        $db = new DBConnection();        
        $sql = "SELECT m.media1 photo, p.name, p.price, p.id FROM Products p  INNER JOIN media m ON m.id = p.media_id WHERE p.id = $id;";
        $result = $db->execute($sql);

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
}