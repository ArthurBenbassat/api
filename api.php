<?php
header('Content-Type: application/json');
//require_once 'classes/customers.php';
//require_once 'classes/login.php';
require_once 'classes/applicationProduct.php';
//require_once 'classes/register.php';

try {
    // get the URL and extract the string after /api.php/
    $start = strpos($_SERVER['PHP_SELF'], '/api.php/');
    if ($start === FALSE) {
        throw new Exception("No resource");
    }

    $url = substr($_SERVER['PHP_SELF'], $start + 9);
    if ($url == '') {
        throw new Exception("No resource");
    }

    // extract the command + parameters
    $resourceAndParamaters = explode('/', $url);
    $params = [];

    $resource = $resourceAndParamaters[0];
    for ($i = 1; $i < count($resourceAndParamaters); $i++) {
        $params[] = $resourceAndParamaters[$i];
    }

    // extract the HTTP command
    $requestType = $_SERVER['REQUEST_METHOD'];
    if ($requestType != 'GET') {
        $data = file_get_contents('php://input');
    } else {
        $data = '';
    }

    // analyse the command
    switch ($resource) {
        case 'customers':
            $o = new Customer();
            $retval = $o->execute($params, $data);
            break;
        case 'products':
            $o = new ApplicationProduct();
            $retval = $o->execute($params, $data);
            break;
        case 'login':
            $splitdata = explode('&', $data);
            if (substr($splitdata[0], 0, 5) == "email" && substr($splitdata[1], 0, 8)) {
                $email = substr($splitdata[0], 6);
                $password = substr($splitdata[1], 9);
            }
            $o = new Login();
            $retval = $o->execute($email, $password);
            break;
        case 'register':
            $splitdata = explode('&', $data);
            for ($i=0; $i < count($splitdata); $i++) {
                $splitdata2 = explode('=', $splitdata[$i]);
                ${$splitdata2[0]} = $splitdata2[1];
            }

            $o =  new Register();
            $retval = $o->execute($email, $first_name, $last_name, $address_line1, $address_line2, $postal_code, $city, $country, $phone_number, $organization_name, $vat_number, $password, $password2);
            break;
        default:
            throw new Exception("Unknown resource: $resource");
    }

    echo json_encode($retval);
} catch (Exception $e) {
    $errorObject = new stdClass();
    $errorObject->error = 500;
    $errorObject->errorDescription = $e->getMessage();
    echo json_encode($errorObject);
}
