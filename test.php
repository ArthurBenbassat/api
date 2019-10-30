<?php
/*
header('Content-Type: application/json');
try {

    include "sql/dbconnection.php";
    require_once "classes/customers.php";

    if (array_key_exists('id', $_GET)) {
        $id = $_GET["id"];
        $sql = "Select * from Customers where id = $id";
    } else {
        $sql = "Select * from Customers";
    }

    $result = mysqli_query($connection, $sql);
    if (!$result) {
        throw new Exception('500');
    }
    $customer->readCustomers($sql, $result);


    echo json_encode($readCustomers);
} catch (Exception $e) {
    http_response_code(500);
}
*/


echo $_SERVER['PHP_SELF'] . "<br>";
echo substr($_SERVER['PHP_SELF'],14 ,1);
