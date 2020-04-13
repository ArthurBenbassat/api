<?php
require_once 'businessCart.php';
require_once 'businessCustomer.php';

require_once 'dataOrder.php';

class ApplicationOrder {
    function execute($params, $data) {
        $businessCart = new BusinessCart();
        $dataCheckout = new DataOrder();

        $businessCart = $data->cart;
        
        //add information in db
        $orderId = $dataCheckout->createCheckout($businessCart);
        
        //add products in db
        $dataCheckout->createCheckoutLines($businessCart, $orderId);

        //deleting cart
        $dataCheckout->deleteCart($businessCart->guid);

    }
}