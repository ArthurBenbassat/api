<?php
require_once 'dataCustomer.php';
require_once 'businessCustomer.php';

class ApplicationVerify {
    public function execute($params, $data) {
        $businessCustomer = new BusinessCustomer;
        $businessCustomer->email = $data->email;
        $customer = new DataCustomer();
        
        return $customer->update($businessCustomer);

    }
    //file_put_contents('C:\tmp\log.txt', var_dump($customer->read($id), true));  

}