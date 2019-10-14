<?php
header('Content-Type: application/json');
include("sql/dbconnection.php");
$sql="Select * from customers";
$gelukt = mysqli_query($connection,$sql) or die("Error: " . mysqli_error($connection));
$customers = [];
while($rij=$gelukt -> fetch_assoc()){
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
