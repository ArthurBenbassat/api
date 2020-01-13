<?php
require_once 'businessCart.php';
require_once 'businessCartLine.php';
require_once 'DBConnection.php';
require_once 'dataCartLine.php';

class DataCart
{
    private $db;

    function __construct()
    {
        $this->db = new DBConnection();
    }

    public function create($businessCart)
    {
        try {
            $sql = "INSERT INTO shop_cart (guid, last_update, user_id) values (uuid(), now(), {$businessCart->user_id})";
            $this->db->execute($sql);
            
            return $this->db->connection->insert_id;
        } catch (Exception $e) {
            throw new Exception("Cannot create cart");
        }
    }

    public function read($cartId) {
        $sql = "SELECT * FROM shop_cart WHERE id = $cartId";
        $result = $this->db->execute($sql);

        if ($rij = $result->fetch_assoc()) {
            $businessCart = new BusinessCart();

            $businessCart->id = $rij['id'];
            $businessCart->guid = $rij['guid'];
            $businessCart->last_update = $rij['last_update'];
            $businessCart->user_id = $rij['user_id'];

            $cart_lines = new DataCartLine(); 
            $businessCart->lines = $cart_lines->read($businessCart);

            return $businessCart;
        } else {
            throw new Exception("Cart $cartId not found");
        }
    }
    public function readByGuid($businessCart) {
        $sql = "SELECT * FROM shop_cart WHERE guid = $businessCart->guid";
        $result = $this->db->execute($sql);
        if ($rij = $result->fetch_assoc()) {
            $businessCart = new BusinessCart();

            $businessCart->id = $rij['id'];
            $businessCart->guid = $rij['guid'];
            $businessCart->last_update = $rij['last_update'];
            $businessCart->user_id = $rij['user_id'];

            $cart_lines = new DataCartLine(); 
            $businessCart->lines = $cart_lines->read($businessCart);

            return $businessCart;
        }
    }
    public function update($guid) {
    }

    public function delete($guid, $id) {
        $sql = "DELETE FROM "
    }
}
