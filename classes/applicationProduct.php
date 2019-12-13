<?php

require_once 'dataProduct.php';

class ApplicationProduct {
    public function execute($params, $data) {
        if (count($params)) {
            return $this->get($params[0]);
        }else {
            return $this->getAll();
        }
    }

    private function get($id) {
        $product = new DataProduct();

        return $product->read($id);
    }

    private function getAll() {
        $product = new DataProduct();

        return $product->readAll();
    }
}