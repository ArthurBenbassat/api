<?php
require_once 'businessCart.php';
require_once 'businessCartLine.php';
require_once 'dataCart.php';
require_once 'dataCartline.php';

class ApplicationCart {
    public function execute($requestType, $params, $data){
        
        $cart = new DataCart();
        $cart_line = new DataCartLine();
        if ($requestType == 'POST') {
            $businessCartLine = new BusinessCartLine();
            $businessCart = new BusinessCart();

            $businessCart->user_id = $data->user_id; 
            $businessCartLine->product_id = $data->product_id;
            $businessCartLine->quantity = $data->quantity;

            $businessCart->id = $cart->create($businessCart);
            $cart_line->create($businessCart, $businessCartLine);
            return $cart->read($businessCart->id);

        } elseif ($requestType == 'GET') {

        } elseif ($requestType == 'PUT') {
            $businessCart->user_id = $data->user_id;
            $businessCart->id = 
            $cart_line->create($businessCart, $businessCartLine);

        } elseif ($requestType == 'DELETE') {

        } else {
            throw new Exception("Unknown request type: $requestType");
        }

        

    }
}