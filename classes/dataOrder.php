<?php

class DataOrder {
    private $db;

    function __construct()
    {
        $this->db = new DBConnection();
    }

    function createCheckout($businessCustomer) {
        try {
            $sql = "INSERT INTO shop_order (customer_id, delivery_first_name, delivery_last_name, delivery_address_line1, delivery_address_line2, delivery_postal_code, delivery_city, delivery_country, delivery_email, status_id, order_date)
            values ({$businessCustomer->id}, '{$businessCustomer->first_name}', '{$businessCustomer->last_name}', '{$businessCustomer->address_line1}', '{$businessCustomer->address_line2}', '{$businessCustomer->postal_code}', '{$businessCustomer->city}', '{$businessCustomer->country}', '{$businessCustomer->email}', 1, date())";
            $this->db->execute($sql);
            
            return $this->db->connection->insert_id;
        } catch (Exception $e) {
            throw new Exception("Cannot add cart to checkout");
        }
    }

    function createCheckoutLines($businessCart, $orderId) {
        try {
            for ($i=0; $i < count($businessCart->lines); $i++) {
                $sql = "INSERT INTO shop_order_line (order_id, product_id, quantity, unit_price, vat_percentage_id, line_total, status_id)
                values ($orderId, {$businessCart->lines[$i]->product->id}, {$businessCart->lines[$i]->quantity}, {$businessCart->lines[$i]->product->price}, 1, {$businessCart->lines[$i]->linePrice}, 1)";
                $this->db->execute($sql);
            }
            
            return $this->db->connection->insert_id;
        } catch (Exception $e) {
            throw new Exception("Cannot add cart to checkout");
        }
    }

    function deleteCart($guid) {
        try {
            $sql = "DELETE FROM shop_cart WHERE guid = $guid";
            $this->db->execute($sql);
        } catch (Exception $e) {
            throw new Exception("Cannot delete cart $guid");
        }
    }
}