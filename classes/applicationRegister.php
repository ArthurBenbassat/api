<?php

require_once 'dataCustomer.php';
require_once 'businessCustomer.php';

class ApplicationRegister {
    public function execute($params, $data) {
        $dataCustomer = new DataCustomer();
        $businessCustomer = new BusinessCustomer();    
        $businessCustomer->customer_type_id = $this->getCustomerTypeID($data->organization_name);
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
        $businessCustomer->vat_number = $data->vat_number;
        $businessCustomer->password = $data->password;
        $businessCustomer->verified = $data->verified;    
        file_put_contents('c:\tmp\log.txt', print_r($businessCustomer, TRUE));
        $id = $dataCustomer->create($businessCustomer);
        return $dataCustomer->read($id);
    }

    private function checkEmailOrPassword($email, $password, $password2)
    {
        if ($email == "" or $password == "") {
            throw new Exception('Fill everthing in!');
        }
        if ($password != $password2) {
            throw new Exception('passwords are not the same');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('email is not correct');
        }
    }

    private function getCustomerTypeID($organization_name)
    {
        if ($organization_name == "") {
            $customers_type = 1;
        } else {
            $customers_type = 2;
        }
        
        return $customers_type;
    }
}