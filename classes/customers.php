<?php
class Customer {
    function readCustomer(){
 
        $query = "SELECT * FROM ";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);
     
        // execute query
        $stmt->execute();
     
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        // set values to object properties
        $this->email = $row['email'];
        $this->firstName = $row['first_name'];
        $this->lastName = $row['last_name'];
        $this->addressLine1 = $row['address_line1'];
        $this->postal_code = $row['postal_code'];
        $this->city = $row['city'];
        $this->country = $row['country'];
        $this->phone_number = $row['phone_number'];
        $this->organization_name = $row['organization_name'];
    }
} 