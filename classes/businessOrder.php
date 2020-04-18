<?php
class BusinessOrder {
    public $id;
    public $order_date ;
    public $user_id;
    public $lines = [];
    public $totalPrice;
    public $totalLines;
    public $delivery_first_name;
    public $delivery_last_name;
    public $delivery_address_line1;
    public $delivery_address_line2;
    public $delivery_postal_code;
    public $delivery_city;
    public $delivery_country;
    public $delivery_email;
    public $delivery_phone;
    public $status_id;
}