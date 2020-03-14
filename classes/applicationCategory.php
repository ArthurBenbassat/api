<?php

require_once 'dataCategory.php';

class ApplicationCategory {
    public function execute($params, $data) {
        if (count($params)) {
            return $this->get($params[0], $data->language);
        }else {
            return $this->getAll($data->language);
        }
    }

    private function get($id, $language) {
        $category = new DataCategory();

        return $category->read($id, $language);
    }

    private function getAll($language) {
        $categories = new DataCategory();

        return $categories->readAll($language);        
    }
}