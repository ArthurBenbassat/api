<?php 
require_once 'businessStandard.php';
require_once 'dataBrand.php';

class applicationBrand {
    public function execute($params, $data) {
        $brand = new DataBrand();
        return $brand->readAll();
    }
}