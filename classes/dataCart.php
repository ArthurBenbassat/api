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

    public function create($businessCart) {
        try {
            $sql = "INSERT INTO shop_cart (guid, last_update, user_id) values (uuid(), now(), '{$businessCart->user_id}')";
            $this->db->execute($sql);
            
            return $this->db->connection->insert_id;
        } catch (Exception $e) {
            throw new Exception("Cannot create cart");
        }
    }

    public function readById($cartId) {
        $sql = "SELECT * FROM shop_cart WHERE id = $cartId";
        return $this->readBySQL($sql);
    }


    public function readByGuid($guid) {
        $sql = "SELECT * FROM shop_cart WHERE guid = '$guid'";
        return $this->readBySQL($sql);
    }

    private function readBySQL($sql) {        
        
        $result = $this->db->execute($sql);

        if ($rij = $result->fetch_assoc()) {
            $businessCart = new BusinessCart();

            $businessCart->id = $rij['id'];
            $businessCart->guid = $rij['guid'];
            $businessCart->last_update = $rij['last_update'];
            $businessCart->user_id = $rij['user_id'];

            $cart_lines = new DataCartLine(); 
            $cart_lines->read($businessCart);

            for ($i=0; $i < Count($businessCart->lines); $i++) {
                $businessCart->totalPrice += $businessCart->lines[$i]->linePrice;
            }

            return $businessCart;
        } else {
            throw new Exception("Cart {$businessCart->id} / {$businessCart->guid} not found");
        }
    }

    public function updateUser($userId, $guid) {
        try {
            $sql = "UPDATE shop_cart SET user_id = $userId WHERE guid = '$guid'";
            $this->db->execute($sql);
        } catch (Exception $e) {
            throw new Exception("Cannot update user_id from user id: $userId");
        }
    }

    public function updateDate($businessCart) {
        // OF MET TRIGGER?
        try {
            $sql = "UPDATE shop_cart SET last_update = now() WHERE guid = '{$businessCart->guid}'";
            $this->db->execute($sql);
        } catch (Exception $e) {
            throw new Exception("Cannot update date from guid: {$businessCart->guid}");
        }
    }

    public function deleteLine($guid) {
        try {
            $sql = "DELETE FROM shop_cart WHERE guid = $guid";
            $this->db->execute($sql);
        } catch (Exception $e) {
            throw new Exception("Cannot delete cart $guid");
        }
    }
}
