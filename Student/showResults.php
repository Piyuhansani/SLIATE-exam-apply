<?php
session_start();
include "../DBConnection/connect.php";

$results = [];

// Check if the registration number is set in the session
if (isset($_SESSION['regNumber'])) {
    $regNumber = $_SESSION['regNumber'];

    // Use prepared statement for secure query execution
    $stmt = $conn->prepare("SELECT * FROM approved_results WHERE registrationNumber = ?");
    $stmt->bind_param("s", $regNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all results into an array
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previous Exam Results</title>

    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body, html {
            
            background-color:#ece000;
        }
        .results-container {
         position: absolute;
         top: 80px; 
         left: 50%;
          transform: translateX(-50%);
           text-align: center;
          padding: 20px;
        }

        table {
    width: 80%;
    border-collapse: collapse;
    text-align: center;
    }

    th, td {
        padding: 10px;
        border: 1px solid #ddd;
    }

    th {
    background-color: #f4f4f4;
    font-weight: bold;
    }

 

  
    </style>

</head>
<body>
    <!-- Navigation -->
    <?php include('navbar.php'); ?>

    <!-- Results Section -->
    <div class="results-container">
    <h1>Previous Exam Results</h1><br>
    
    <?php if (!empty($results)): ?>
        <table border="1" cellspacing="0" cellpadding="10" style="margin: auto; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Result ID</th>
                    <th>Module</th>
                    <th>Registration Number</th>
                    <th>Grade</th>
                    <th>Issued Date</th>
                    <th>Issued Time</th>
                    <th>Result Status</th>
                    <th>Marks</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['result_ID']) ?></td>
                        <td><?= htmlspecialchars($row['Module']) ?></td>
                        <td><?= htmlspecialchars($row['registrationNumber']) ?></td>
                        <td><?= htmlspecialchars($row['grade']) ?></td>
                        <td><?= htmlspecialchars($row['issued_Date']) ?></td>
                        <td><?= htmlspecialchars($row['issued_time']) ?></td>
                        <td><?= htmlspecialchars($row['result_status']) ?></td>
                        <td><?= htmlspecialchars($row['marks']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No results found for your registration number.</p>
    <?php endif; ?>

     <!-- Back button -->
     <div class="mt-3 text-center">
            <a href="already_applied.php" class="btn btn-primary">Go Back</a>
        </div>
</div>


    <script src="../Admin/script.js"></script>
</body>
</html>
