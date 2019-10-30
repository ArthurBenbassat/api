<?php
class Customer{
    public function execute($params, $post) {
        
    }

    private function getAllCustomers() {

    }

    private function getCustomer($customerID) {

    }

    private function deleteCustomer($customerID) {

    }

    private function updateCustomer() {

    }

    function readCustomers($sql, $result){
        while ($rij = $result->fetch_assoc()) {
            $this->id = $rij["id"];
            $this->customer_type_id = $rij["customer_type_id"];
            $this->email = $rij["email"];
            $this->first_name = $rij["first_name"];
            $this->last_name = $rij["last_name"];
            $this->address_line1 = $rij["address_line1"];
            $this->address_line2 = $rij["address_line2"];
            $this->postal_code = $rij["postal_code"];
            $this->city = $rij["city"];
            $this->country = $rij["country"];
            $this->phone_number = $rij["phone_number"];
            $this->organization_name = $rij["organization_name"];
            $this->vat_number = $rij["vat_number"];
        }
    }
}
