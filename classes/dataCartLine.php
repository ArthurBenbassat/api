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

    public function create($cartId ,$businessCartLine)
    {
        try {
            $sql = "INSERT INTO shop_cart_lines (cart_id, product_id, quantity) VALUES ($cartId, {$businessCartLine->product_id}, {$businessCartLine->quantity})";
            $this->db->execute($sql);
        }catch (Exception $e) {
            throw new Exception($e->getMessage()); //"Cannot create cart line");
        }
    }

    public function read(&$businessCart) {
        $sql = "SELECT cl.id cart_lines_id, cl.cart_id, cl.quantity, p.*, m.media as photo FROM shop_cart_lines cl INNER JOIN shop_products p ON cl.product_id = p.id LEFT OUTER JOIN shop_media m ON m.id = p.media_id WHERE cl.cart_id = {$businessCart->id}";
            $result = $this->db->execute($sql);
            while ($rij = $result->fetch_assoc()) {
                $businessCartLine = new BusinessCartLine();
                $businessCartLine->id = $rij['cart_lines_id'];
                $businessCartLine->cart_id = $rij['cart_id'];
                $businessCartLine->quantity = $rij['quantity'];
                $totalQuantity += $rij['quantity'];
                
                $businessProduct = new BusinessProduct();
                $businessProduct->id = $rij['id'];
                $businessProduct->name = $rij['name'];
                $businessProduct->price = $rij['price'];
                $businessProduct->photo = $rij['photo'];
                $businessCartLine->product = $businessProduct;

                $businessCartLine->linePrice = $rij['price'] * $rij['quantity']; 

                $businessCart->lines[] = $businessCartLine;
            }
            $businessCart->totalQuantity = $totalQuantity;
    }

    public function updateQuantity($businessCart, $lineId, $quantity) {
        try {
            
            $sql = "UPDATE shop_cart_lines SET quantity = $quantity WHERE cart_id = {$businessCart->id} AND id = $lineId";
            $this->db->execute($sql);
            
        } catch (Exception $e) {
            throw new Exception("Cannot update cart line with cart id: {$businessCart->id}");
        }
    }

    public function deleteLine($businessCart, $businessCartLine) {
        try {
            $sql = "DELETE FROM shop_cart_lines WHERE cart_id = {$businessCart->id} AND id = {$businessCartLine->id}";
            $this->db->execute($sql);

        } catch (Exception $e) {
            throw new Exception("Cannot delete cart line with cart id: {$businessCart->id}");
        }
    }
}
