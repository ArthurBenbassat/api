<?php
require_once 'businessCart.php';
require_once 'businessCartLine.php';
require_once 'dataCart.php';
require_once 'dataCartLine.php';

class ApplicationCart {
    public function execute($requestType, $params, $data){
        
        $cart = new DataCart();
        $cart_line = new DataCartLine();
        $businessCartLine = new BusinessCartLine();
        $businessCart = new BusinessCart();
        if ($data->language) {
            $language = $data->language;
        } else {
            throw new Exception("No language set");
        }

        if ($requestType == 'POST') {
            if (!empty($data->user_id)) {
                $businessCart->user_id = $data->user_id; 
            } else {
                $businessCart->user_id = '';
            }
            
            if (!isset($data->quantity) && !isset($data->product_id)) {
                //GET THE CART
                $businessCart->guid = $params[0];
                return $cart->readByGuid($businessCart->guid, $language);
            } else {
                if (isset($params[0]) || !empty($params[0]) && $data->product_id && $data->quantity) {
                    $businessCart->guid = $params[0];
                    
                    $businessCart = $cart->readByGuid($businessCart->guid, $language);
                    // MOET NOG AAN GEWERKT WORDEN
                    for ($i=0; $i < count($businessCart->lines); $i++) {
                        if ($businessCart->lines[$i]->product->id == $data->product_id) {
                            $againProduct = true;
                            $quantity = $businessCart->lines[$i]->quantity;
                            $lineId = $businessCart->lines[$i]->id;
                        }
                    }
                    if ($againProduct == true) {
                        $cart_line->updateQuantity($businessCart, $lineId, $quantity + 1);
    
                    } else  {
                        $businessCartLine->product_id = $data->product_id;
                        $businessCartLine->quantity = $data->quantity;
                        $cart->updateDate($businessCart);
                        $cart_line->create($businessCart->id, $businessCartLine);
                    }
    
                    return $cart->readByGuid($businessCart->guid, $language);
                } else {
                    $businessCartLine->quantity = $data->quantity;
                    $businessCartLine->product_id = $data->product_id;
                   
                    $businessCart->id = $cart->create($businessCart);
                    $cart_line->create($businessCart->id, $businessCartLine);
    
                    return $cart->readById($businessCart->id, $language);
                }
            }

        } elseif ($requestType == 'GET') {
            $businessCart->guid = $params[0];
            return $cart->readByGuid($businessCart->guid, 'nl_BE');

        } elseif ($requestType == 'PUT') {
            if (isset($params[1])) {
                // update of cart line
                if ($params[1] == 'line') {
                    $businessCart->guid = $params[0];                    
                    $businessCartLine->quantity = $data->quantity;
                    $businessCartLine->id = $params[2];
                    $businessCart = $cart->readByGuid($businessCart->guid, $language);
                    
                    $cart_line->updateQuantity($businessCart, $businessCartLine->id, $data->quantity);
                    $cart->updateDate($businessCart);
                } else {
                    throw new Exception('Unknown cart resource');
                }
            } else {
                // update of the cart
                $businessCart->guid = $params[0];
                $businessCart->user_id = $data->user_id;
                $cart->updateUser($businessCart->user_id, $businessCart->guid);
                $cart->updateDate($businessCart);
            }
                        
            return $cart->readByGuid($businessCart->guid, $language);
            
        } elseif ($requestType == 'DELETE') {
            if (isset($params[1])) {
                // update of cart line
                if ($params[1] == 'line') {
                    $businessCart->guid = $params[0];
                    $businessCartLine->id = $params[2];
                    
                    $cart_line->deleteLine($cart->readByGuid($businessCart->guid, $language), $businessCartLine);
                    $cart->updateDate($businessCart);
                } else {
                    throw new Exception('Unknown cart resource');
                }
            } else {
                // update of the cart
                $businessCart->guid = $params[0];
                $cart->deleteLine($businessCart->guid);
            }
            
            return $cart->readByGuid($businessCart->guid, $language);
            
        } else {
            throw new Exception("Unknown request type: $requestType");
        }
    }
}