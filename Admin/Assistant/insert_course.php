<?php
// Include database connection
include "../../DBConnection/connect.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve input values from POST request
    $courseCode = $_POST['course_code'] ?? null;
    $courseName = $_POST['course_name'] ?? null;
    $divisionName = $_POST['division_name'] ?? null;
    $academicYear = $_POST['academic_year'] ?? null;
    $semester = $_POST['semester'] ?? null;
    $batch = $_POST['batch'] ?? null;
    $totalCredits = $_POST['total_credits'] ?? null;
    $department = $_POST['department'] ?? null;
    $includedSubjects = $_POST['included_subjects'] ?? null;

    // Validate mandatory fields (add checks if needed)
    if (is_null($courseCode) || is_null($courseName)) {
        die("Error: Course code and course name are required fields.");
    }

    // Prepare the SQL INSERT query
    $sql = "INSERT INTO course (course_code, course_name, division_name, academic_year, semester, batch, total_credits, department, included_subjects) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters to the query
        $stmt->bind_param(
            "sssssssss", 
            $courseCode, 
            $courseName, 
            $divisionName, 
            $academicYear, 
            $semester, 
            $batch, 
            $totalCredits, 
            $department, 
            $includedSubjects
        );

        // Execute the query
        if ($stmt->execute()) {
            echo "New course added successfully!";
        } else {
            echo "Error: Could not insert the course. " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Error: Could not prepare the SQL statement. " . $conn->error;
    }
} else {
    echo "Invalid request method. Please use POST to insert a new course.";
}

// Close the database connection
$conn->close();
?>
