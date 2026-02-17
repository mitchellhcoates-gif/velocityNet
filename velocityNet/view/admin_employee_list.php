<?php
// Admin Employee List page.
// Shows all employees.

require_once(__DIR__ . "/../controller/employee_controller.php");

$employeeList = EmployeeController::getAllEmployees();

require_once("header.php");
?>

<h2>Admin Employee List</h2>

<p><a href="admin_employee_add.php">Add Employee</a></p>

<!-- table to display records from the database -->
<table border="1" cellpadding="6">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>

<?php //loop through employeeList and build output ?>
    <?php foreach ($employeeList as $employeeRow) { ?>
        <tr>
            <td><?php echo $employeeRow->getEmployeeId(); ?></td>
            <td><?php echo $employeeRow->getLastName() . ", " . $employeeRow->getFirstName(); ?></td>
            <td><?php echo $employeeRow->getEmail(); ?></td>
            <td><?php echo $employeeRow->getRole(); ?></td>
            <td>
                <a href="admin_employee_edit.php?employee_id=<?php echo $employeeRow->getEmployeeId(); ?>">Edit</a>
            </td>
        </tr>
    <?php } ?>

</table>

<?php require_once("footer.php"); ?>