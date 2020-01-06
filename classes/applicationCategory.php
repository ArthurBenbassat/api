<?php

require_once 'dataCategory.php';

class ApplicationCategory {
    public function execute($params, $data) {
        if (count($params)) {
            return $this->get($params[0]);
        }else {
            return $this->getAll();
        }
    }

    private function get($id) {
        $category = new DataCategory();

        return $category->read($id);
    }

    private function getAll() {
        $categories = new DataCategory();

        return $categories->readAll();        
    }
}