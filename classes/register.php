<?php
require_once 'sql/dbconnection.php';

class Register
{
    public function execute($email, $first_name, $last_name, $address_line1, $address_line2, $postal_code, $city, $country, $phone_number, $organization_name, $vat_number, $password, $password2)
    {
        $this->checkEmailOrPassword($email, $password, $password2);
        $customers_type = $this->checkcustomersType($organization_name);
        $this->registerUser($customers_type, $email, $first_name, $last_name, $address_line1, $address_line2, $postal_code, $city, $country, $phone_number, $organization_name, $vat_number, $password);

        $errorObject = new stdClass();
        $errorObject->error = 200;
        $errorObject->errorDescription = "Successfully logged in";
        return $errorObject;
    }

    private function checkEmailOrPassword($email, $password, $password2)
    {
        if ($email == "" or $password == "") {
            throw new Exception('Fill everthing in!');
        }
        if ($password <> $password2) {
            throw new Exception('passwords are not the same');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('email is not correct');
        }
    }

    private function checkcustomersType($organization_name)
    {
        if ($organization_name == "") {
            $customers_type = 1;
        } else {
            $customers_type = 2;
        }
        die($organization_name . "test");
        return $customers_type;
    }

    private function registerUser($customers_type, $email, $first_name, $last_name, $address_line1, $address_line2, $postal_code, $city, $country, $phone_number, $organization_name, $vat_number, $password)
    {
        
        global $connection;

        $salt = 'zrgfkjhzghzkrgj';
        $hashedPassword = md5($password . $salt);

        $sql = "insert into Customers (customer_type_id,email,first_name,last_name,address_line1,address_line2,postal_code,city,country,phone_number,organization_name,vat_number,password,verified) values (
        " . $customers_type . ",
        '" . mysqli_real_escape_string($connection, $email) . "',
        '" . mysqli_real_escape_string($connection, $first_name) . "',
        '" . mysqli_real_escape_string($connection, $last_name) . "',
        '" . mysqli_real_escape_string($connection, $address_line1) . "',
        '" . mysqli_real_escape_string($connection, $address_line2) . "',
        '" . mysqli_real_escape_string($connection, $postal_code) . "',
        '" . mysqli_real_escape_string($connection, $city) . "',
        '" . mysqli_real_escape_string($connection, $country) . "',
        '" . mysqli_real_escape_string($connection, $phone_number) . "',
        '" . mysqli_real_escape_string($connection, $organization_name) . "',
        '',
        '" . $hashedPassword . "',
        '0')";

        $gelukt = mysqli_query($connection, $sql) or die("Error: " . mysqli_error($connection));
    }
}
