<?php
// Lists controller.
// Returns dropdown lists for forms.

require_once(__DIR__ . "/../model/listDB.php");

class ListsController {

    public static function getAllProductsServices() {
        return getAllProductsServices();
    }

    public static function getAllComplaintTypes() {
        return getAllComplaintTypes();
    }

    public static function getAllTechnicians() {
        return getAllTechnicians();
    }
}
