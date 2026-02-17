<?php
// Employees database functions.
// Runs SQL queries for this part of the system.
// Returns results back to controllers.


require_once(__DIR__ . "/Database.php");
require_once(__DIR__ . "/Employee.php");

class EmployeeDB {

    //convert a row into an object
    private static function rowToEmployee($row) {

        // Convert a DB row into an Employee object.
        $employee = new Employee(
            $row["email"],
            $row["first_name"],
            $row["last_name"],
            $row["level"],
            $row["employee_password"]
        );

        $employee->setEmployeeId((int)$row["employee_id"]);
        return $employee;
    }

    //get all employees
    public static function getAllEmployees() {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return array();

        /*
            SQL pulls all employees.
            Roles are stored directly in employees.role (admin, technician).
        */
        $sql = "select employee_id, email, first_name, last_name, level, employee_password
                from employees
                order by employee_id desc";

        $result = mysqli_query($conn, $sql);
        $employeeList = array();

        if ($result != false) {
            while ($row = mysqli_fetch_assoc($result)) {
                $employeeList[] = self::rowToEmployee($row);
            }
        }

        return $employeeList;
    }

    //get employee by id
    public static function getEmployeeById($employeeIdNumber) {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return null;

        /*
            SQL pulls one employee by primary key.
        */
        $sql = "select employee_id, email, first_name, last_name, level, employee_password
                from employees
                where employee_id = ?";

        $statement = mysqli_prepare($conn, $sql);
        if ($statement == false) return null;

        mysqli_stmt_bind_param($statement, "i", $employeeIdNumber);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        if ($result == false) return null;

        $row = mysqli_fetch_assoc($result);
        if ($row == null) return null;

        return self::rowToEmployee($row);
    }

    //insert a new record
    public static function insertEmployee($emailText, $firstNameText, $lastNameText, $roleText, $passwordText) {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return false;

        
        $sql = "insert into employees
                (email, first_name, last_name, role, employee_password)
                values (?, ?, ?, ?, ?)";

        $statement = mysqli_prepare($conn, $sql);
        if ($statement == false) return false;

        mysqli_stmt_bind_param($statement, "sssss", $emailText, $firstNameText, $lastNameText, $roleText, $passwordText);
        return mysqli_stmt_execute($statement);
    }

    //update an existing record
    public static function updateEmployee($employeeIdNumber, $emailText, $firstNameText, $lastNameText, $roleText) {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return false;

        /*
            SQL updates an employee row.

            Password is not updated here because the edit form does not include it.
        */
        $sql = "update employees
                set email = ?, first_name = ?, last_name = ?, role = ?
                where employee_id = ?";

        $statement = mysqli_prepare($conn, $sql);
        if ($statement == false) return false;

        mysqli_stmt_bind_param($statement, "ssssi", $emailText, $firstNameText, $lastNameText, $roleText, $employeeIdNumber);
        return mysqli_stmt_execute($statement);
    }
    //update password
    public static function updateEmployeePassword($employeeIdNumber, $passwordText) {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return false;

        /*
            SQL updates the password for one employee.
        */
        $sql = "update employees
                set employee_password = ?
                where employee_id = ?";

        $statement = mysqli_prepare($conn, $sql);
        if ($statement == false) return false;

        mysqli_stmt_bind_param($statement, "si", $passwordText, $employeeIdNumber);
        return mysqli_stmt_execute($statement);
    }


    //get employee by email
    public static function getEmployeeByEmail($emailText) {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return null;

        /*
            SQL finds one employee row by email.
            Used for login checks.
        */
        $sql = "select employee_id, email, first_name, last_name, level, employee_password
                from employees
                where email = ?
                limit 1";

        $statement = mysqli_prepare($conn, $sql);
        if ($statement == false) return null;

        mysqli_stmt_bind_param($statement, "s", $emailText);
        if (mysqli_stmt_execute($statement) == false) return null;

        $result = mysqli_stmt_get_result($statement);
        if ($result == false) return null;

        $row = mysqli_fetch_assoc($result);
        if ($row == null) return null;

        return self::rowToEmployee($row);
    }

}

//get all employees
function getAllEmployees() { return EmployeeDB::getAllEmployees(); }
//get employee by id
function getEmployeeById($employeeIdNumber) { return EmployeeDB::getEmployeeById($employeeIdNumber); }
//insert a new record
function insertEmployee($emailText, $firstNameText, $lastNameText, $roleText, $passwordText) { return EmployeeDB::insertEmployee($emailText, $firstNameText, $lastNameText, $roleText, $passwordText); }
//update an existing record
function updateEmployee($employeeIdNumber, $emailText, $firstNameText, $lastNameText, $roleText) { return EmployeeDB::updateEmployee($employeeIdNumber, $emailText, $firstNameText, $lastNameText, $roleText); }

//update password
function updateEmployeePassword($employeeIdNumber, $passwordText) { return EmployeeDB::updateEmployeePassword($employeeIdNumber, $passwordText); }

//get employee by email
function getEmployeeByEmail($emailText) { return EmployeeDB::getEmployeeByEmail($emailText); }
?>