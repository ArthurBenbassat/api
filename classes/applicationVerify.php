<?php
require_once 'dataCustomer.php';
require_once 'businessCustomer.php';

class ApplicationVerify {
    public function execute($params, $data) {
        $businessCustomer = new BusinessCustomer;
        $businessCustomer->id = $data->id;
        $customer = new DataCustomer();
        
        if ($customer->read($businessCustomer->id)->token == $data->token) {
            return $customer->update($businessCustomer);
        }else {
            throw new Exception('Token is wrong');
        }

    }
    //file_put_contents('C:\tmp\log.txt', var_dump($customer->read($id), true));  

}