<?php
// Complaint controller.
// Keeps complaint database work in one place.

require_once(__DIR__ . "/../model/complaintDB.php");

class ComplaintController {

    // Customer/admin list.
    public static function getAllComplaintsWithNames() {
        return getAllComplaintsWithNames();
    }

    // Customer list by customer.
    public static function getComplaintsByCustomerIdWithNames($customerIdNumber) {
        return getComplaintsByCustomerIdWithNames((int)$customerIdNumber);
    }

    // Tech list by technician.
    public static function getComplaintsByEmployeeIdWithNames($employeeIdNumber) {
        return getComplaintsByEmployeeIdWithNames((int)$employeeIdNumber);
    }

    // Admin open list.
    public static function getOpenComplaintsWithNames() {
        return getOpenComplaintsWithNames();
    }

    // Admin unassigned open list.
    public static function getUnassignedOpenComplaintsWithNames() {
        return getUnassignedOpenComplaintsWithNames();
    }

    // One complaint.
    public static function getComplaintById($complaintIdNumber) {
        return getComplaintById((int)$complaintIdNumber);
    }

    // Insert a complaint.
    public static function addComplaint($customerIdNumber, $productServiceIdNumber, $complaintTypeIdNumber, $descriptionText) {
        return insertComplaint((int)$customerIdNumber, (int)$productServiceIdNumber, (int)$complaintTypeIdNumber, $descriptionText);
    }

    // Assign technician.
    public static function assignComplaintToTechnician($complaintIdNumber, $employeeIdNumber) {
        return assignComplaintToTechnician((int)$complaintIdNumber, (int)$employeeIdNumber);
    }

    // Update technician fields.
    public static function updateComplaintTechnicianFields($complaintIdNumber, $technicianNotesText, $statusText, $resolutionDateText, $resolutionNotesText) {
        return updateComplaintTechnicianFields((int)$complaintIdNumber, $technicianNotesText, $statusText, $resolutionDateText, $resolutionNotesText);
    }

    // Counts for technicians (admin report).
    public static function getTechnicianOpenComplaintCounts() {
        return getTechnicianOpenComplaintCounts();
    }
}
