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

    public function readById($cartId, $language) {
        $sql = "SELECT * FROM shop_cart WHERE id = $cartId";
        return $this->readBySQL($sql, $language);
    }


    public function readByGuid($guid, $language) {
        $sql = "SELECT * FROM shop_cart WHERE guid = '$guid'";
        return $this->readBySQL($sql, $language);
    }

    private function readBySQL($sql, $language) {        
        
        $result = $this->db->execute($sql);

        if ($rij = $result->fetch_assoc()) {
            $businessCart = new BusinessCart();

            $businessCart->id = $rij['id'];
            $businessCart->guid = $rij['guid'];
            $businessCart->last_update = $rij['last_update'];
            $businessCart->user_id = $rij['user_id'];
            $businessCart->delivery_first_name = $rij['delivery_first_name'];
            $businessCart->delivery_last_name = $rij['delivery_last_name'];
            $businessCart->delivery_address_line1 = $rij['delivery_address_line1'];
            $businessCart->delivery_address_line2 = $rij['delivery_address_line2'];
            $businessCart->delivery_postal_code = $rij['delivery_postal_code'];
            $businessCart->delivery_city = $rij['delivery_city'];
            $businessCart->delivery_country = $rij['delivery_country'];
            $businessCart->delivery_email = $rij['delivery_email'];
            $businessCart->delivery_phone = $rij['delivery_phone'];

            $cart_lines = new DataCartLine(); 
            $cart_lines->read($businessCart, $language);

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

    public function updateDelivery($businessCart) {
        try {
            $sql = "UPDATE shop_cart SET delivery_first_name = '{$businessCart->delivery_first_name}',delivery_last_name = '{$businessCart->delivery_last_name}',delivery_address_line1 = '{$businessCart->delivery_address_line1}',delivery_address_line2 = '{$businessCart->delivery_address_line2}',delivery_postal_code = '{$businessCart->delivery_postal_code}',delivery_city = '{$businessCart->delivery_city}',delivery_country = '{$businessCart->delivery_country}',delivery_email  = '{$businessCart->delivery_email}', delivery_phone = '{$businessCart->delivery_phone}' WHERE guid = '{$businessCart->guid}'";
            $this->db->execute($sql);
        } catch (Exception $e) {
            throw new Exception("Cannot update delivery address from guid: {$businessCart->guid}");
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
