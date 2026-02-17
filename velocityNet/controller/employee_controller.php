<?php
// Employee controller.
// Keeps employee database work in one place.

require_once(__DIR__ . "/../model/employeesDB.php");

class EmployeeController {

    // Get all employees.
    public static function getAllEmployees() {
        return getAllEmployees();
    }

    // Get one employee by id.
    public static function getEmployeeById($employeeIdNumber) {
        return getEmployeeById((int)$employeeIdNumber);
    }

    // Add an employee.
    public static function addEmployee($emailText, $firstNameText, $lastNameText, $roleText, $passwordText) {
        return insertEmployee($emailText, $firstNameText, $lastNameText, $roleText, $passwordText);
    }

    // Update an employee.
    public static function updateEmployee($employeeIdNumber, $emailText, $firstNameText, $lastNameText, $roleText) {
        return updateEmployee((int)$employeeIdNumber, $emailText, $firstNameText, $lastNameText, $roleText);
    }

    
}
