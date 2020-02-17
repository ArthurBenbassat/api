<?php
require_once 'businessCart.php';
require_once 'businessCustomer.php';

require_once 'dataOrder.php';

class ApplicationOrder {
    function execute($params, $data) {
        $businessCart = new BusinessCart();
        $businessCustomer = new BusinessCustomer();
        $dataCheckout = new DataOrder();

        $businessCart = $data->cart;
        

        $businessCustomer->id = $data->userId;
        $businessCustomer->email = $data->email;
        $businessCustomer->first_name = $data->first_name;
        $businessCustomer->last_name = $data->last_name;
        $businessCustomer->address_line1 = $data->address_line1;
        $businessCustomer->address_line2 = $data->address_line2;
        $businessCustomer->postal_code = $data->postal_code;
        $businessCustomer->city = $data->city;
        $businessCustomer->country = $data->country;
        
        $orederId = $dataCheckout->createCheckout($businessCustomer);
        $dataCheckout->createCheckoutLines($businessCart, $orederId);
        $dataCheckout->deleteCart($businessCart->guid);

    }
}