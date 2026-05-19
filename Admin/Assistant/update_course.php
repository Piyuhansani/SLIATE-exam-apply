<?php
include "../../DBConnection/connect.php";

// Retrieve POST data
$courseID = $_POST['course_ID'];
$courseCode = $_POST['course_code'];
$courseName = $_POST['course_name'];
$divisionName = $_POST['division_name'];
$academicYear = $_POST['academic_year'];
$semester = $_POST['semester'];
$batch = $_POST['batch'];
$totalCredits = $_POST['total_credits'];
$department = $_POST['department'];
$includedSubjects = $_POST['included_subjects'];

// Update the database
$sql = "UPDATE course 
        SET course_code = ?, course_name = ?, division_name = ?, academic_year = ?, semester = ?, batch = ?, total_credits = ?, department = ?, included_subjects = ?
        WHERE course_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sssssssssi",
    $courseCode, 
    $courseName, 
    $divisionName, 
    $academicYear, 
    $semester, 
    $batch, 
    $totalCredits, 
    $department, 
    $includedSubjects, 
    $courseID
);

if ($stmt->execute()) {
    echo "Success";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
