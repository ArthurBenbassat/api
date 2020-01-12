<?php
require_once 'businessCart.php';
require_once 'businessCartLine.php';
require_once 'DBConnection.php';

class DataCartLine
{
    private $db;

    function __construct()
    {
        $this->db = new DBConnection();
    }

    public function create($businessCart ,$businessCartLine)
    {
        try {
            $sql = "INSERT INTO shop_cart_lines (cart_id, product_id, quantity) VALUES ({$businessCart->id}, {$businessCartLine->product_id}, {$businessCartLine->quantity})";
            $this->db->execute($sql);
        }catch (Exception $e) {
            throw new Exception($e->getMessage()); //"Cannot create cart line");
        }
    }

    public function read($businessCart) {
        $sql = "SELECT * FROM shop_cart_lines WHERE cart_id = {$businessCart->id}";
            $result = $this->db->execute($sql);
            while ($rij = $result->fetch_assoc()) {
                $businessCartLine = new BusinessCartLine();
                $businessCartLine->id = $rij['id'];
                $businessCartLine->cart_id = $rij['cart_id'];
                $businessCartLine->product_id = $rij['product_id'];
                $businessCartLine->quantity = $rij['quantity'];
                $businessCart->lines[] = $businessCartLine;
            }
    }

    public function update($guid)
    {
    }

    public function delete($guid, $id)
    {
    }
}
