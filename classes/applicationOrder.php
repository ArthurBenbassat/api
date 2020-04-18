<?php
require_once 'businessCart.php';
require_once 'businessCustomer.php';

require_once 'dataOrder.php';

class ApplicationOrder {
    function execute($params, $data) {
        if ($params[0]) {
            $dataCheckout = new DataOrder();
            return $dataCheckout->getorder($params[0]);
        } elseif ($data) {
            $businessCart = new BusinessCart();
            $dataCheckout = new DataOrder();
    
            $businessCart = $data->cart;
            
            //add information in db
            $orderId = $dataCheckout->createCheckout($businessCart);
            
            //add products in db
            $dataCheckout->createCheckoutLines($businessCart, $orderId);
    
            //deleting cart
            $dataCheckout->deleteCart($businessCart->guid);
            return $orderId;
        } else {
            throw new Exception("No orderid given");
        }
        

    }
}