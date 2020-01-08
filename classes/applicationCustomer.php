<?php

require_once 'dataCustomer.php';
require_once 'businessCustomer.php';

class ApplicationCustomer {
    public function execute($params, $data) {
        $customer = new DataCustomer();
        return $customer->read($params[0]);
    }

}