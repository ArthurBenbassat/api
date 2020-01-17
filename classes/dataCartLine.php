<?php
require_once 'businessCart.php';
require_once 'businessCartLine.php';
require_once 'DBConnection.php';
require_once 'businessProduct.php';

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
        $sql = "SELECT cl.id cart_lines_id, cl.cart_id, cl.quantity, p.* FROM shop_cart_lines cl INNER JOIN shop_products p ON cl.product_id = p.id WHERE cl.cart_id = {$businessCart->id}";
            $result = $this->db->execute($sql);
            while ($rij = $result->fetch_assoc()) {
                $businessCartLine = new BusinessCartLine();
                $businessCartLine->id = $rij['cart_lines_id'];
                $businessCartLine->cart_id = $rij['cart_id'];
                $businessCartLine->quantity = $rij['quantity'];
                $businessProduct = new BusinessProduct();
                $businessProduct->id = $rij['id'];
                $businessProduct->name = $rij['name'];
                $businessProduct->price = $rij['price'];
                $businessProduct->photo = $rij['media_id'];
                $businessCartLine->product = $businessProduct;
                $businessCart->lines[] = $businessCartLine;
            }
    }

    public function update($businessCart)
    {
    }

    public function delete($businessCart ,$businessCartLine) {
        $sql = "DELETE FROM shop_cart_lines WHERE id = $businessCartLine->id";
        $this->db->execute($sql);
    }
}
