<?php
// Admin Customer List page.
// Shows all customers.

require_once(__DIR__ . "/../controller/customer_controller.php");

$customerList = CustomerController::getAllCustomers();

require_once("header.php");
?>

<h2>Admin Customer List</h2>

<p><a href="admin_customer_add.php">Add Customer</a></p>

<!-- table to display records from the database -->
<table border="1" cellpadding="6">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>City</th>
        <th>State</th>
        <th>Action</th>
    </tr>

<?php //loop through customerList and build output ?>
    <?php foreach ($customerList as $customerRow) { ?>
        <tr>
            <td><?php echo $customerRow->getCustomerId(); ?></td>
            <td><?php echo $customerRow->getLastName(); ?>, <?php echo $customerRow->getFirstName(); ?></td>
            <td><?php echo $customerRow->getEmail(); ?></td>
            <td><?php echo $customerRow->getPhoneNumber(); ?></td>
            <td><?php echo $customerRow->getCity(); ?></td>
            <td><?php echo $customerRow->getState(); ?></td>
            <td><a href="admin_customer_edit.php?customer_id=<?php echo $customerRow->getCustomerId(); ?>">Edit</a></td>
        </tr>
    <?php } ?>
</table>

<?php require_once("footer.php"); ?>