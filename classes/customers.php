<?php
require_once 'sql/dbconnection.php';

class Customer
{
    public $id = 0;
    public $firstName = '';
    public $lastName = '';
    public $email = '';


    public function login($email, $password)
    {
        $this->checkBlankEmailOrPassword($email, $password);

        $this->checkUser($email, $password);
        $errorObject = new stdClass();
        $errorObject->error = 200;
        $errorObject->errorDescription = "Successfully logged in";
        return $errorObject;
    }

    private function checkBlankEmailOrPassword($email, $password)
    {
        if ($email == '' || $password == '') {
            throw new Exception('Fill everthing in!');
        }
    }

    private function checkUser($email, $password)
    {
        global $connection;

        if ($stmt = $connection->prepare('SELECT id, password, first_name, last_name FROM Customers WHERE email = ?')) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();
        }

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $passwordHashedDB, $firstName, $lastName);
            $stmt->fetch();
            $salt = 'zrgfkjhzghzkrgj';
            $passwordHashed = md5($password . $salt);

            if ($passwordHashed == $passwordHashedDB) {
                $this->email = $email;
                $this->firstName = $firstName;
                $this->lastName = $lastName;
                $this->id = $id;
            } else {
                throw new Exception('Incorrect password!');
            }
        } else {
            throw new Exception("Incorrect username!");
        }
        $stmt->close();
    }

    private function getAllCustomers()
    { }

    private function getCustomer($customerID)
    { }

    private function deleteCustomer($customerID)
    { }

    private function updateCustomer()
    { }

    function readCustomers($sql, $result)
    {
        while ($rij = $result->fetch_assoc()) {
            $this->id = $rij["id"];
            $this->customer_type_id = $rij["customer_type_id"];
            $this->email = $rij["email"];
            $this->first_name = $rij["first_name"];
            $this->last_name = $rij["last_name"];
            $this->address_line1 = $rij["address_line1"];
            $this->address_line2 = $rij["address_line2"];
            $this->postal_code = $rij["postal_code"];
            $this->city = $rij["city"];
            $this->country = $rij["country"];
            $this->phone_number = $rij["phone_number"];
            $this->organization_name = $rij["organization_name"];
            $this->vat_number = $rij["vat_number"];
        }
    }
}
