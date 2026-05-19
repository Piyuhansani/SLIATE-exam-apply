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

// Fetch timetable details
$sql = "
    SELECT t.date, t.start_time, t.end_time, t.subject, t.department
    FROM timetable t
    JOIN studentapply s 
    ON (t.subject = s.subject1 OR t.subject = s.subject2 OR t.subject = s.subject3 OR 
        t.subject = s.subject4 OR t.subject = s.subject5 OR t.subject = s.subject6 OR 
        t.subject = s.subject7 OR t.subject = s.subject8 OR t.subject = s.subject9 OR 
        t.subject = s.subject10)
    AND t.Year = s.academic_year
    AND t.Semester = s.semester
    WHERE s.Registration_number = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $regNumber);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Time Table</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {background-color:#ece000;}
       form,.card {background-color: #f0ff7f;}
    </style>
</head>
<body class="">

<?php include('navbar.php'); ?>

<div class="container mt-5 pt-5">
    <h1 class="text-center mb-4">Your Exam Time Table</h1>

    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Subject</th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Iterate over the result set and display data
                    while ($row = $result->fetch_assoc()): 
                    ?>
                        <tr>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['start_time']; ?></td>
                            <td><?php echo $row['end_time']; ?></td>
                            <td><?php echo $row['subject']; ?></td>
                            <td><?php echo $row['department']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center" role="alert">
            No timetable found for your registration details.
        </div>
    <?php endif; ?>

    <!-- Back button -->
    <div class="mt-3 text-center">
        <a href="already_applied.php" class="btn btn-primary">Go Back</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
