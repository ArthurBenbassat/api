<?php

require_once 'dataCustomer.php';
require_once 'businessCustomer.php';

class ApplicationCustomer {
    public function execute($params, $data) {
        $customer = new DataCustomer();
        if ($params[0] == 'changePassword') {
            return $customer->changePassword($params[1], $data->oldPassword, $data->newPassword);
        } else {
            
            return $customer->read($params[0]);
        }
        
    }

}