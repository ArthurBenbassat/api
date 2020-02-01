<?php
require_once 'businessCart.php';
require_once 'businessCustomer.php';

require_once 'dataCheckout.php';

class ApplicationCheckout {
    function execute($params, $data) {
        $cart = new BusinessCart();
        $cart = json_decode($data['cart']);
        $businessCustomer = new BusinessCustomer();
        $businessCustomer->email = $data->email;
        $businessCustomer->first_name = $data->first_name;
        $businessCustomer->last_name = $data->last_name;
        $businessCustomer->address_line1 = $data->address_line1;
        $businessCustomer->address_line2 = $data->address_line2;
        $businessCustomer->postal_code = $data->postal_code;
        $businessCustomer->city = $data->city;
        $businessCustomer->country = $data->country;
        $businessCustomer->phone_number = $data->phone_number;
        $businessCustomer->organization_name = $data->organization_name;
    }
}