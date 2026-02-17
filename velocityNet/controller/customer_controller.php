<?php
// Customer controller.
// Keeps customer database work in one place.

require_once(__DIR__ . "/../model/customerDB.php");

class CustomerController {

    // Get all customers.
    public static function getAllCustomers() {
        return getAllCustomers();
    }

    // Get one customer by id.
    public static function getCustomerById($customerIdNumber) {
        return getCustomerById((int)$customerIdNumber);
    }

    // Add a customer.
    public static function addCustomer($emailText, $firstNameText, $lastNameText, $streetText, $cityText, $stateText, $zipCodeText, $phoneNumberText, $passwordText = "") {
        return insertCustomer($emailText, $firstNameText, $lastNameText, $streetText, $cityText, $stateText, $zipCodeText, $phoneNumberText, $passwordText);
    }

    // Update a customer.
    public static function updateCustomer($customerIdNumber, $emailText, $firstNameText, $lastNameText, $streetText, $cityText, $stateText, $zipCodeText, $phoneNumberText) {
        return updateCustomer((int)$customerIdNumber, $emailText, $firstNameText, $lastNameText, $streetText, $cityText, $stateText, $zipCodeText, $phoneNumberText);
    }
}
