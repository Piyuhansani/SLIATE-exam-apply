<?php
// Include database connection
include "../DBConnection/connect.php";

// Retrieve query parameters safely
$department = $_GET['department'] ?? '';
$batch = $_GET['batch'] ?? '';
$year = $_GET['year'] ?? '';
$semester = $_GET['semester'] ?? '';

// Start HTML structure
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timetable</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
        }
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature-section div {
            text-align: center;
        }
        .issued-date {
            text-align: right;
            margin-top: 20px;
        }
        h1, h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="no-print">
            <a href="filter_timetable.php" class="btn btn-secondary mb-3">Back</a>
            <button class="btn btn-primary mb-3" onclick="window.print()">Print</button>
        </div>';

// Check if all required filters are provided
if (!empty($department) && !empty($batch) && !empty($year) && !empty($semester)) {
    echo '<h1>Timetable</h1>';
    echo '<h2>Department: ' . htmlspecialchars($department) . '</h2>';
    echo '<h2>Year: ' . htmlspecialchars($year) . '</h2>';
    echo '<h2>Batch: ' . htmlspecialchars($batch) . '</h2>';
    echo '<h2>Semester: ' . htmlspecialchars($semester) . '</h2>';

    // Query the database safely using prepared statements
    $stmt = $conn->prepare("SELECT * FROM timetable WHERE department = ? AND batch = ? AND year = ? AND semester = ?");
    $stmt->bind_param("ssss", $department, $batch, $year, $semester);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display the timetable if records are found
    if ($result->num_rows > 0) {
        echo '<table class="table table-bordered table-striped mt-4">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Subject</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                    </tr>
                </thead>
                <tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' . htmlspecialchars($row['date']) . '</td>
                    <td>' . htmlspecialchars($row['subject']) . '</td>
                    <td>' . htmlspecialchars($row['start_time']) . '</td>
                    <td>' . htmlspecialchars($row['end_time']) . '</td>
                  </tr>';
        }
        echo '</tbody>
            </table>';

        // Add placeholders for signatures and issuance details
        echo '<div class="signature-section">
                <div>
                    <p>__________________________</p>
                    <p>Director\'s Signature</p>
                </div>
                <div>
                    <p>__________________________</p>
                    <p>Department Head\'s Signature</p>
                </div>
              </div>';
        echo '<div class="issued-date">
                <p>Issued on: ' . date("d-m-Y H:i:s") . '</p>
              </div>';
              echo '<div class="Computer Generated">
              <p>Computer based auto generated document</p>
            </div>';
    } else {
        // Handle case when no records are found
        echo '<p class="text-danger text-center">No timetable found for the selected criteria.</p>';
    }
} else {
    // Handle case when filters are missing
    echo '<p class="text-danger text-center">Please select all filters to view the timetable.</p>';
}

echo '</div>
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>';
?>
