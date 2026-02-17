<?php
// Customer Complaint View page.
// Shows one complaint by id.

require_once(__DIR__ . "/../controller/complaint_controller.php");

$complaintIdNumber = 0;
if (isset($_GET["complaint_id"])) $complaintIdNumber = (int)$_GET["complaint_id"];

$complaintRow = null;
if ($complaintIdNumber > 0) $complaintRow = ComplaintController::getComplaintById($complaintIdNumber);

require_once("header.php");
?>

<h2>View Complaint</h2>

<p>This page will be built later.</p>

<?php require_once("footer.php"); ?>