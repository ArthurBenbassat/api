<?php

require_once 'dataProduct.php';

class ApplicationProduct {
    public function execute($params, $data) {
        if (count($params) == 1) {
            return $this->get($params[0], $data->language);
        }else {
            if (isset($data->filter)) {
                return $this->getAll($data->language, $this->createWhereClause($data->filter), $this->createOrder($data->filter));
            } else {
                return $this->getAll($data->language);
            }
        }
    }

    private function get($id, $language) {
        $product = new DataProduct();

        return $product->read($id, $language);
    }

    private function getAll($language, $where = "", $orderBy = "") {
        $product = new DataProduct();

        return $product->readAll($language, $where, $orderBy);        
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

    private function createOrder($filter) {
        $order = "";
        if (isset($filter->sorting)) {
            if ($filter->sorting == 'price') {
                $order = "ORDER BY p.price";
            } elseif ($filter->sorting == 'review') {
                $order = "ORDER BY p.id";
            } else {
                $order = "ORDER BY p.name";
            }
        } else {
            $order = "ORDER BY p.name";
        }
        if (isset($filter->order)) {
            if ($filter->order == 'descending') {
                $order .= " DESC";
            } else {
                $order .= ' ASC';
            }
        } else {
            $order .= ' ASC';
        }
        
        return $order;
    }
}