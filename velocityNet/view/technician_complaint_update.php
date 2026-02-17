<?php
// Technician Complaint Update page.
// Updates status/resolution fields for a complaint.

require_once(__DIR__ . "/../controller/complaint_controller.php");

$errorMessage = "";
$successMessage = "";

$complaintIdNumber = 0;
if (isset($_GET["complaint_id"])) $complaintIdNumber = (int)$_GET["complaint_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $technicianNotesText = $_POST["technician_notes"] ?? "";
    $statusText = $_POST["status"] ?? "";
    $resolutionDateText = $_POST["resolution_date"] ?? "";
    $resolutionNotesText = $_POST["resolution_notes"] ?? "";

    if ($complaintIdNumber <= 0) {
        $errorMessage = "Missing complaint id.";
    } else {

        $ok = ComplaintController::updateComplaintTechnicianFields(
            $complaintIdNumber,
            $technicianNotesText,
            $statusText,
            $resolutionDateText,
            $resolutionNotesText
        );

        if ($ok) $successMessage = "Complaint updated.";
        else $errorMessage = "Update failed.";
    }
}

$complaintRow = null;
if ($complaintIdNumber > 0) $complaintRow = ComplaintController::getComplaintById($complaintIdNumber);

require_once("header.php");
?>

<h2>Technician Complaint Update</h2>

<?php if ($errorMessage != "") { ?>
    <p><?php echo $errorMessage; ?></p>
<?php } ?>

<?php if ($successMessage != "") { ?>
    <p><?php echo $successMessage; ?></p>
<?php } ?>

<?php if ($errorMessage == "" && $complaintRow != null) { ?>

    <p><b>Complaint ID:</b> <?php echo $complaintRow->getComplaintId(); ?></p>
    <p><b>Status:</b> <?php echo $complaintRow->getStatus(); ?></p>
    <p><b>Description:</b> <?php echo $complaintRow->getDescription(); ?></p>

<!-- form to update complaint status and notes -->
    <form action="technician_complaint_update.php?complaint_id=<?php echo $complaintIdNumber; ?>&employee_id=<?php echo $employeeIdNumber; ?>" method="post">

        <label>Technician Notes</label><br>
        <textarea name="technician_notes" rows="6" cols="60"><?php echo $complaintRow->getTechnicianNotes(); ?></textarea>

        <br><br>

        <label>Status</label><br>
<!-- dropdown list built from database values -->
        <select name="status">
            <option value="">Select</option>
            <option value="open" <?php if ($complaintRow->getStatus() == "open") echo "selected"; ?>>open</option>
            <option value="closed" <?php if ($complaintRow->getStatus() == "closed") echo "selected"; ?>>closed</option>
        </select>

        <br><br>

        <label>Resolution Date</label><br>
        <input type="text" name="resolution_date" value="<?php echo $complaintRow->getResolutionDate(); ?>">

        <br><br>

        <label>Resolution Notes</label><br>
        <textarea name="resolution_notes" rows="6" cols="60"><?php echo $complaintRow->getResolutionNotes(); ?></textarea>

        <br><br>

        <input type="submit" value="Update Complaint">

    </form>

    <p><a href="technician_complaint_list.php?employee_id=<?php echo $employeeIdNumber; ?>">Back to technician list</a></p>

<?php } ?>

<?php require_once("footer.php"); ?>