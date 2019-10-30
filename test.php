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

$url = $_SERVER['PHP_SELF'];
echo $url . "<br>";

$urlItems = explode('/', $url);

switch ($urlItems[2]) {
    case 'products':
        $p = new Product();
        $p->execute($urlItems, $_POST);
        break;
    case 'customers':
        $c = new Customer();
        $c->execute($urlItems, $_POST);
        break;  
    default:
        throw new Exception(500);

}


var_dump($urlItems);



