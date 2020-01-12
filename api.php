<?php
header('Content-Type: application/json');

require_once 'classes/applicationLogin.php';
require_once 'classes/applicationProduct.php';
require_once 'classes/applicationRegister.php';
require_once 'classes/applicationVerify.php';
require_once 'classes/applicationCategory.php';
require_once 'classes/applicationCustomer.php';
require_once 'classes/applicationCart.php';

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
        $data = json_decode($data);
    } else {
        $data = '';
    }


    // analyse the command
    switch ($resource) {
        case 'customer':
            $o =  new ApplicationCustomer();
            $retval = $o->execute($params, $data);
            break;
        case 'products':
            $o = new ApplicationProduct();
            $retval = $o->execute($params, $data);
            break;
        case 'login':
            $o = new ApplicationLogin();
            $retval = $o->execute($params, $data);            
            break;
        case 'register':
            $o =  new ApplicationRegister();
            $retval = $o->execute($params, $data);            
            break;
        case 'verify':
            $o = new ApplicationVerify();
            $retval = $o->execute($params, $data);
            break;
        case 'categories':
            $o = new ApplicationCategory();
            $retval = $o->execute($params, $data);
            break;
        case 'cart':
            $o = new ApplicationCart();
            $retval = $o->execute($requestType, $params, $data);
            break;
        default:
            throw new Exception("Unknown resource: $resource");
    }
    
    http_response_code(200);
    
    echo json_encode($retval);
} catch (Exception $e) {
    http_response_code(500);    
    echo json_encode(['errorMessage' => $e->getMessage()]);
}
