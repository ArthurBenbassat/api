<?php

require_once 'dataCustomer.php';
require_once 'businessCustomer.php';

class ApplicationCustomer {
    public function execute($params, $data) {
        $customer = new DataCustomer();
        $businessCustomer = new BusinessCustomer();
        if ($params[0] == 'changePassword') {
            return $customer->changePassword($params[1], $data->oldPassword, $data->newPassword);
        } elseif ($params[0] == 'changeDetails') {
            $businessCustomer->id =  $params[1];
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

            return $customer->changeDetails($businessCustomer);

        } else {
            
            return $customer->read($params[0]);
        }
        
    }

}