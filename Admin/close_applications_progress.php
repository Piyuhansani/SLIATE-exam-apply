<?php
// Include database connection
include "../DBConnection/connect.php";

// Get the current year and month
$currentYearMonth = date('Y_m');

// Define table names for the new tables
$newStudentApply = "studentapply_" . $currentYearMonth;
$newPendingStudentApply = "pending_studentapply_" . $currentYearMonth;
$newApprovedStudentApply = "approved_studentapply_" . $currentYearMonth;
$newRejectedStudentApply = "rejected__studentapply_" . $currentYearMonth;

// Function to create new tables and move data
function closeApplications($conn, $oldTable, $newTable) {
    // Create the new table (structure is copied from the old table)
    $createTableQuery = "CREATE TABLE $newTable LIKE $oldTable";
    $conn->query($createTableQuery);

    // Move data from the old table to the new table
    $moveDataQuery = "INSERT INTO $newTable SELECT * FROM $oldTable";
    $conn->query($moveDataQuery);

    // Clear the old table
    $clearTableQuery = "TRUNCATE TABLE $oldTable";
    $conn->query($clearTableQuery);
}

// Close applications for all tables
closeApplications($conn, "studentapply", $newStudentApply);
closeApplications($conn, "pending_studentapply", $newPendingStudentApply);
closeApplications($conn, "approved_studentapply", $newApprovedStudentApply);
closeApplications($conn, "rejected__studentapply", $newRejectedStudentApply);

// Redirect to admin page with success message
header("Location: admin.php?status=closed");
exit();

// Close the connection
$conn->close();
?>
