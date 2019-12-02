<?php

require_once 'dataProduct.php';

class ApplicationProduct {
    public function execute($params, $data) {
        if (count($params)) {
            return $this->get($params[0]);
        }
    }

    private function get($id) {
        $data = new DataProduct();

        return $data->get($id);
    }
}