<?php
require_once 'businessCart.php';
require_once 'businessCartLine.php';
require_once 'dataCart.php';
require_once 'dataCartline.php';

class ApplicationCart {
    public function execute($requestType, $params, $data){
        
        $cart = new DataCart();
        $cart_line = new DataCartLine();
        $businessCartLine = new BusinessCartLine();
        $businessCart = new BusinessCart();

        if ($requestType == 'POST') {
            $businessCart->user_id = $data->user_id; 
            $businessCartLine->product_id = $data->product_id;
            $businessCartLine->quantity = $data->quantity;

            $businessCart->id = $cart->create($businessCart);
            $cart_line->create($businessCart, $businessCartLine);
            return $cart->read($businessCart->id);

        } elseif ($requestType == 'GET') {
            $businessCart->guid = $params->guid;
            return $cart->readByGuid($businessCart);

        } elseif ($requestType == 'PUT') {
            $businessCart->guid = $data->guid;
            return $cart_line->create($cart->readByGuid($businessCart), $businessCartLine);
            
        } elseif ($requestType == 'DELETE') {
            $businessCart->guid = $data->guid;
            $businessCartLine->product_id = $data->product_id;

            if (Count($cart->readByGuid($businessCart)->lines) == 1) {
                $cart_line->delete($businessCart, $businessCartLine);
                $cart->delete($businessCart);
            } else {
                $cart_line->delete($businessCart, $businessCartLine);
                $cart->delete($businessCart);
                return $cart->readByGuid($businessCart);
            }
            
        } else {
            throw new Exception("Unknown request type: $requestType");
        }

        

    }
}