<?php

require_once 'dataProduct.php';

class ApplicationProduct {
    public function execute($params, $data) {
        //var_dump($data);exit;
        if (count($params) == 1) {
            return $this->get($params[0], $data->language);
        }else {
            return $this->getAll($data->language);
        }
    }

    private function get($id, $language) {
        $product = new DataProduct();

        return $product->read($id, $language);
    }

    private function getAll($language) {
        $product = new DataProduct();

        return $product->readAll($language);        
    }
}