<?php
// Include database connection
include "../../DBConnection/connect.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if course_ID is provided in the POST request
    if (isset($_POST['course_ID']) && !empty($_POST['course_ID'])) {
        // Retrieve course_ID from the POST data
        $courseID = $_POST['course_ID'];

        // Prepare the SQL DELETE query
        $sql = "DELETE FROM course WHERE course_ID = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind the course_ID parameter to the query
            $stmt->bind_param("i", $courseID);

            // Execute the query
            if ($stmt->execute()) {
                // If the deletion was successful
                echo "Course with ID $courseID deleted successfully!";
            } else {
                // If the execution failed
                echo "Error: Could not delete the course. " . $stmt->error;
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            // If the SQL statement could not be prepared
            echo "Error: Could not prepare the SQL statement. " . $conn->error;
        }
    } else {
        // If course_ID was not provided
        echo "Error: No course_ID provided.";
    }
} else {
    // If the request method is not POST
    echo "Invalid request method. Please use POST to delete a course.";
}

// Close the database connection
$conn->close();
?>
