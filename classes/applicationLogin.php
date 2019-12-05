<?php

require_once 'dataCustomer.php';

class ApplicationLogin {
    public function execute($params, $data)
    {
        $this->checkBlankEmailOrPassword($data->email, $data->password);

        $dataCustomer = new DataCustomer();
        $id = $dataCustomer->checkUser($data->email, $data->password);
        return $dataCustomer->read($id);
    }

    private function checkBlankEmailOrPassword($email, $password)
    {
        if ($email == '' || $password == '') {
            throw new Exception('Fill everthing in!');
        }
    }
}