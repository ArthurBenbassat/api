<?php

header('Content-Type: application/json');
try {

    include "sql/dbconnection.php";
    if (isset($_SERVER['PHP_SELF'])) {
        $id =  substr($_SERVER['PHP_SELF'],19 ,1);
        $sql = "Select * from Customers where id = $id";
    } else {
        $sql = "Select * from Customers";
}
/*
    if (array_key_exists('id', $_GET)) {
        $id = $_GET["id"];
        $sql = "Select * from Customers where id = $id";
    } else {
        $sql = "Select * from Customers";
    }
*/
    $result = mysqli_query($connection, $sql);
    if (!$result) {
        throw new Exception('500');
    }

    $customers = [];
    while ($rij = $result->fetch_assoc()) {
        $customer = new stdClass();
        $customer->id = $rij["id"];
        $customer->customer_type_id = $rij["customer_type_id"];
        $customer->email = $rij["email"];
        $customer->first_name = $rij["first_name"];
        $customer->last_name = $rij["last_name"];
        $customer->address_line1 = $rij["address_line1"];
        $customer->address_line2 = $rij["address_line2"];
        $customer->postal_code = $rij["postal_code"];
        $customer->city = $rij["city"];
        $customer->country = $rij["country"];
        $customer->phone_number = $rij["phone_number"];
        $customer->organization_name = $rij["organization_name"];
        $customer->vat_number = $rij["vat_number"];
        $customers[] = $customer;
    }
    echo json_encode($customers);
} catch (Exception $e) {
    http_response_code(500);
}
