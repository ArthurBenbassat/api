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
            if (isset($data->user_id)) {
                $businessCart->user_id = $data->user_id; 
            } else {
                $businessCart->user_id = '';
            }
            
            
            if (isset($data->guid)) {
                $businessCartLine->product_id = $data->product_id;
                $businessCart = $cart->readByGuid($businessCart->guid);
                
                $businessCartLine->quantity = $data->quantity;
                $businessCart->guid = $data->guid;
                
                $cart_line->create($businessCart->cart, $businessCartLine);
            } else {
                $businessCartLine->quantity = $data->quantity;
                $businessCart->guid = $data->guid;
                
                $businessCart->id = $cart->create($businessCart);
                $cart_line->create($businessCart->id, $businessCartLine);

                return $cart->readById($businessCart->id);
            }
        } elseif ($requestType == 'GET') {
            $businessCart->guid = $params[0];
            return $cart->readByGuid($businessCart);

        } elseif ($requestType == 'PUT') {
            $businessCart->guid = $data->guid;
            $businessCartLine->product_id = $data->product_id;
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