<?php

header('Content-Type: application/json');
try {
    include "sql/dbconnection.php";

    if (substr($_SERVER['PHP_SELF'], 13, 9) == "customers") {
        // gebruikers
        $tableName =  "Customers";
        if (substr($_SERVER['PHP_SELF'], 23, 1) == "") {
            $sql = "Select * from $tableName";
        } else {
            if ((substr($_SERVER['PHP_SELF'], 24, 1) == "") || (substr($_SERVER['PHP_SELF'], 24, 1) == "/")) {
                $id =  substr($_SERVER['PHP_SELF'], 23, 1);
                $sql = "Select * from $tableName where id = $id";
            } else {
                $id =  substr($_SERVER['PHP_SELF'], 23, 2);
                $sql = "Select * from $tableName where id = $id";
            }
        }
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

    } elseif (substr($_SERVER['PHP_SELF'], 13, 8) == "products") {
        // Producten 
        $tableName =  "Products";

        if (substr($_SERVER['PHP_SELF'], 23, 1) == "") {
            $sql = "Select * from $tableName";
        } else {
            if ((substr($_SERVER['PHP_SELF'], 24, 1) == "") || (substr($_SERVER['PHP_SELF'], 24, 1) == "/")) {
                $id =  substr($_SERVER['PHP_SELF'], 23, 1);
                $sql = "Select * from $tableName where id = $id";
            } else {
                $id =  substr($_SERVER['PHP_SELF'], 23, 2);
                $sql = "Select * from $tableName where id = $id";
            }
        }

        $result = mysqli_query($connection, $sql);

        if (!$result) {
            throw new Exception('500');
        }

        $products = [];
        while ($rij = $result->fetch_assoc()) {
            $product = new stdClass();
            $product->id = $rij["id"];
            $product->name = $rij["name"];
            $product->description = $rij["description"];
            $product->ingredients = $rij["ingredients"];
            $product->category_id = $rij["category_id"];
            $product->media_id = $rij["media_id"];

            $products[] = $product;
        }
        echo json_encode($products);
    } else {
        echo 'we werken er aan sss';
    }
} catch (Exception $e) {
    http_response_code(500);
}
