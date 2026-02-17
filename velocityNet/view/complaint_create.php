<?php
// Complaint Create page.
// Inserts a new complaint (customer side).
// 

require_once(__DIR__ . "/../controller/auth_controller.php");
require_once(__DIR__ . "/../controller/lists_controller.php");
require_once(__DIR__ . "/../controller/complaint_controller.php");

AuthController::startSession();

$errorMessage = "";
$successMessage = "";

// dropdown data
$productServiceList = ListsController::getAllProductsServices();
$complaintTypeList = ListsController::getAllComplaintTypes();

// insert when user submits the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $customerIdNumber = 0;
    if (isset($_SESSION["user_id"])) $customerIdNumber = (int)$_SESSION["user_id"];

    if ($customerIdNumber <= 0) {
        $errorMessage = "Login is required to submit a complaint.";
    }

    $productServiceIdNumber = (int)($_POST["product_service_id"] ?? 0);
    $complaintTypeIdNumber = (int)($_POST["complaint_type_id"] ?? 0);
    $descriptionText = $_POST["description"] ?? "";

    if ($productServiceIdNumber <= 0 || $complaintTypeIdNumber <= 0 || $descriptionText == "") {
        $errorMessage = "Please pick options and type a description.";
    } else {

        $ok = ComplaintController::addComplaint($customerIdNumber, $productServiceIdNumber, $complaintTypeIdNumber, $descriptionText);

        if ($ok) $successMessage = "Complaint submitted.";
        else $errorMessage = "Insert failed.";
    }
}

require_once("header.php");
?>

<h2>Enter a Complaint</h2>

<?php if ($errorMessage != "") { ?>
    <!-- Show validation error if something was left blank -->
    <p><?php echo $errorMessage; ?></p>
<?php } ?>

<?php if ($successMessage != "") { ?>
    <!-- Show success message after insert -->
    <p><?php echo $successMessage; ?></p>
<?php } ?>

<!-- form to enter complaint -->
<form action="complaint_create.php" method="post">

    <label>Product/Service</label><br>

    <!-- value is product_service_id so the controller can insert the correct id -->
<!-- dropdown list built from database values -->
    <select name="product_service_id">
        <option value="0">Select</option>

<?php //loop through productServiceList and build output ?>
        <?php foreach ($productServiceList as $productServiceRow) { ?>
            <option value="<?php echo $productServiceRow->getProductServiceId(); ?>">
                <?php echo $productServiceRow->getProductServiceName(); ?>
            </option>
        <?php } ?>
    </select>

    <br><br>

    <label>Complaint Type</label><br>

<!-- dropdown list built from database values -->
    <select name="complaint_type_id">
        <option value="0">Select</option>

<?php //loop through complaintTypeList and build output ?>
        <?php foreach ($complaintTypeList as $complaintTypeRow) { ?>
            <option value="<?php echo $complaintTypeRow->getComplaintTypeId(); ?>">
                <?php echo $complaintTypeRow->getComplaintTypeName(); ?>
            </option>
        <?php } ?>
    </select>

    <br><br>

    <label>Description</label><br>

    <!-- typed description is stored in complaints.description -->
    <textarea name="description" rows="6" cols="50"></textarea>

    <br><br>

    <input type="submit" value="Submit Complaint">

</form>

<?php require_once("footer.php"); ?>