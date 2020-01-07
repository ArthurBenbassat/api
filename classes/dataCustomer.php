<?php
require_once 'DBConnection.php';
require_once 'businessCustomer.php';

class DataCustomer
{
    private $db;
    
    function __construct()
    {
        $this->db = new DBConnection();
    }

    public function create($businessCustomer)
    {       
        try {
            $salt = 'zrgfkjhzghzkrgj';
            $hashedPassword = md5($businessCustomer->password . $salt);

            $sql = "insert into shop_customers (customer_type_id,email,first_name,last_name,address_line1,address_line2,postal_code,city,country,phone_number,organization_name,vat_number,password,verified) values (
            " . $businessCustomer->customer_type_id . ",
            '" . mysqli_real_escape_string($this->db->connection, $businessCustomer->email) . "',
            '" . mysqli_real_escape_string($this->db->connection, $businessCustomer->first_name) . "',
            '" . mysqli_real_escape_string($this->db->connection, $businessCustomer->last_name) . "',
            '" . mysqli_real_escape_string($this->db->connection, $businessCustomer->address_line1) . "',
            '" . mysqli_real_escape_string($this->db->connection, $businessCustomer->address_line2) . "',
            '" . mysqli_real_escape_string($this->db->connection, $businessCustomer->postal_code) . "',
            '" . mysqli_real_escape_string($this->db->connection, $businessCustomer->city) . "',
            '" . mysqli_real_escape_string($this->db->connection, $businessCustomer->country) . "',
            '" . mysqli_real_escape_string($this->db->connection, $businessCustomer->phone_number) . "',
            '" . mysqli_real_escape_string($this->db->connection, $businessCustomer->organization_name) . "',
            '',
            '" . $hashedPassword . "',
            '0')";
                
            $this->db->execute($sql);

            return $this->db->connection->insert_id;
        } catch (Exception $e) {
            throw new Exception("Cannot create user"); 
        }
    }

    public function read($customerID)
    {
        $sql = "SELECT * FROM shop_customers WHERE id = $customerID";
        $result = $this->db->execute($sql);

        if ($rij = $result->fetch_assoc()) {
            $businessCustomer = new BusinessCustomer();

            $businessCustomer->id = $rij["id"];
            $businessCustomer->customer_type_id = $rij["customer_type_id"];
            $businessCustomer->email = $rij["email"];
            $businessCustomer->first_name = $rij["first_name"];
            $businessCustomer->last_name = $rij["last_name"];
            $businessCustomer->address_line1 = $rij["address_line1"];
            $businessCustomer->address_line2 = $rij["address_line2"];
            $businessCustomer->postal_code = $rij["postal_code"];
            $businessCustomer->city = $rij["city"];
            $businessCustomer->country = $rij["country"];
            $businessCustomer->phone_number = $rij["phone_number"];
            $businessCustomer->organization_name = $rij["organization_name"];
            $businessCustomer->vat_number = $rij["vat_number"];
            $businessCustomer->verified = $rij['verified'];
            $businessCustomer->password = '';

            return $businessCustomer;
        }
        else {
            throw new Exception("Customer $customerID not found");
        }
        
     }

    

    public function delete($customerID)
    { }

    public function update($businessCustomer){ 

        try {
            $sql = "UPDATE shop_customers
            SET verified = 1
            WHERE email = '$businessCustomer->email'";
            $this->db->execute($sql);
        } catch (Exception $e) {
            throw new Exception("Customer: $businessCustomer->email cannot update status");
        }
        
    }

    public function readAll()
    { 
        /*
        // TODO: AF TE WERKEN!!!
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
        */
        
    }

    public function checkUser($email, $password)
    {
        
        if ($stmt = $this->db->connection->prepare('SELECT id, password, first_name, last_name, verified FROM shop_customers WHERE email = ?')) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();
        }

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $passwordHashedDB, $firstName, $lastName, $verified);
            $stmt->fetch();
            $salt = 'zrgfkjhzghzkrgj';
            $passwordHashed = md5($password . $salt);

            if ($passwordHashed == $passwordHashedDB) {
                // OK
                return $id;
            } else {
                throw new Exception('Incorrect password!');
            }
        } else {
            throw new Exception("Incorrect username!");
        }
        $stmt->close();
    }


}
