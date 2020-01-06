<?php
require_once 'dataCustomer.php';

class ApplicationVerify {
    public function execute($params, $data) {
        if (count($data) == 2) {
            return $this->isTokenCorrect($data[0], $data[1]);
        }else {
            return $this->isVerified($data[0]);
        }
    }
    private function isTokenCorrect($id, $token) {
        $customer = new DataCustomer();
        file_put_contents('C:\tmp\log.txt', var_dump($customer->read($id), true));  
        //return $customer->read($id);
    }

    private function isVerified($id) {
        $customer = new DataCustomer();

        return $customer->readAll();
    }
}