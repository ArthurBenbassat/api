<?php

require_once 'dataProduct.php';

class ApplicationProduct {
    public function execute($params, $data) {
        if (count($params) == 1) {
            return $this->get($params[0], $data->language);
        }else {
            if (isset($data->filter)) {
                return $this->getAll($data->language, $this->createWhereClause($data->filter));
            } else {
                return $this->getAll($data->language);
            }
        }
    }

    private function get($id, $language) {
        $product = new DataProduct();

        return $product->read($id, $language);
    }

    private function getAll($language, $where = "") {
        $product = new DataProduct();

        return $product->readAll($language, $where);        
    }

    private function createWhereClause($filter) {
        $whereClause = "";
        if (isset($filter->brand_id)) {
            $whereClause = 'AND (brand_id = ';
            $whereClause .= $filter->brand_id;
            $whereClause = str_replace(',', ' OR brand_id = ', $whereClause);
            $whereClause .= ')';
        }
        if (isset($filter->cat_id)) {
            if (isset($whereClause)) {
                $whereClause .= ' AND (category_id = ';
            } else {
                $whereClause = 'AND (category_id = ';
            }
            $whereClause .= $filter->cat_id;
            $whereClause = str_replace(',', ' OR category_id = ', $whereClause);
            $whereClause .= ')';
        }
        return $whereClause;
    }
}