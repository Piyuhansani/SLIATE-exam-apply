<?php
// Start session
session_start();

// Database connection
include "../DBConnection/connect.php";

// Check if the user is logged in
if (!isset($_SESSION['regNumber'])) {
    header("Location: login.php");
    exit();
}

// Retrieve the registration number from the session
$regNumber = $_SESSION['regNumber'];

// Initialize the status message
$statusMessage = "Your application is under review.";

// Check in the pending_studentapply table
$sql = "SELECT Registration_number FROM pending_studentapply WHERE Registration_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $regNumber);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $statusMessage = "Your application status is Pending.";
} else {
    // Check in the approved_studentapply table
    $sql = "SELECT Registration_number FROM approved_studentapply WHERE Registration_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $regNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $statusMessage = "Your application is completed. Congratulations on your exams!";
    } else {
        // Check in the rejected__studentapply table
        $sql = "SELECT Registration_number FROM rejected__studentapply WHERE Registration_number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $regNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $statusMessage = "Your application status is Rejected.";
        }
    }
}

// Close statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {background-color: #f4f4f4;}
        .card {background-color: #fff9c4;}
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>

    <br>

    <div class="container mt-5">
        <div class="card p-4 shadow-lg">
            <h1 class="text-center mb-4">Application Status</h1>
            <p class="text-center fs-4">
                <?php echo $statusMessage; ?>
            </p>
        </div>

        <!-- Back button -->
        <div class="mt-3 text-center">
            <a href="already_applied.php" class="btn btn-primary">Go Back</a>
        </div>
    </div>

    
</body>
</html>
