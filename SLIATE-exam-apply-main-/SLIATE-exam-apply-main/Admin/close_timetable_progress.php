<?php
// Include database connection
include "../DBConnection/connect.php";

// Get the current year and month
$currentYearMonth = date('Y_m');

// Define the new table name for the backup
$newTimetable = "timetable_" . $currentYearMonth;

try {
    // Begin transaction
    $conn->begin_transaction();

    // Create the new timetable table (structure is copied from the old table)
    $createTableQuery = "CREATE TABLE $newTimetable LIKE timetable";
    $conn->query($createTableQuery);

    // Move data from the old timetable table to the new table
    $moveDataQuery = "INSERT INTO $newTimetable SELECT * FROM timetable";
    $conn->query($moveDataQuery);

    // Clear the old timetable table
    $clearTableQuery = "TRUNCATE TABLE timetable";
    $conn->query($clearTableQuery);

    // Commit transaction
    $conn->commit();

    // Redirect to admin page with a success message
    header("Location: admin.php?status=timetable_closed");
    exit();
} catch (Exception $e) {
    // Rollback transaction in case of error
    $conn->rollback();
    echo "Error occurred: " . $e->getMessage();
    exit();
}

// Close the connection
$conn->close();
?>
